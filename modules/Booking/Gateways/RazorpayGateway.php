<?php

namespace Modules\Booking\Gateways;

use App\Currency;
use Illuminate\Http\Request;
use Mockery\Exception;
use Modules\Booking\Events\BookingCreatedEvent;
use Modules\Booking\Events\BookingUpdatedEvent;
use Modules\Booking\Models\Booking;
use Modules\Booking\Models\Payment;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;

class RazorpayGateway extends BaseGateway
{
    public $name = 'Razorpay';

    public $gateway;

    public function getOptionsConfigs()
    {
        return [
            [
                'type'  => 'checkbox',
                'id'    => 'enable',
                'label' => __('Enable Razorpay?')
            ],
            [
                'type'  => 'input',
                'id'    => 'name',
                'label' => __('Custom Name'),
                'std'   => __("Razorpay"),
                'multi_lang' => "1"
            ],
            [
                'type'  => 'upload',
                'id'    => 'logo_id',
                'label' => __('Logo'),
            ],
            [
                'type'  => 'editor',
                'id'    => 'html',
                'label' => __('Description'),
                'multi_lang' => "1"
            ],
            [
                'type'       => 'input',
                'id'        => 'razorpay_key',
                'label'     => __('Api Key'),
            ],
            [
                'type'       => 'input',
                'id'        => 'razorpay_secret',
                'label'     => __('Secret Key'),
            ],
            [
                'type'       => 'checkbox',
                'id'        => 'test_sandbox',
                'label'     => __('Test Mode'),
            ],
            [
                'type'       => 'input',
                'id'        => 'razorpay_test_key',
                'label'     => __('Test Api Key'),
            ],
            [
                'type'       => 'input',
                'id'        => 'razorpay_test_secret',
                'label'     => __('Test Secret Key'),
            ]
        ];
    }

    public function process(Request $request, $booking, $service)
    {
        $this->getGateway();

        if (in_array($booking->status, [
            $booking::PAID,
            $booking::COMPLETED,
            $booking::CANCELLED
        ])) {
            throw new Exception(__("Booking status does need to be paid"));
        }
        if (!$booking->pay_now) {
            throw new Exception(__("Booking total is zero. Can not process payment gateway!"));
        }
        $payment = new Payment();
        $payment->booking_id = $booking->id;
        $payment->payment_gateway = $this->id;
        $payment->status = 'draft';
        $payment->amount = (float) $booking->pay_now;

        // $stripe_customer_id =  $this->tryCreateUser($booking);
        $stripe_customer_id =  'test_id';
        $orderData = [
            'mode' => 'payment',
            'customer' => $stripe_customer_id,
            'success_url' => $this->getReturnUrl() . '?c=' . $booking->code . '&session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $this->getCancelUrl() . '?c=' . $booking->code,
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => setting_item('currency_main'),
                        'product_data' => [
                            'name' => $booking->service->title ?? '',
                            'images' => [get_file_url($booking->service->image_id ?? '')]
                        ],
                        'unit_amount' => (float) $booking->pay_now * 100
                    ],
                    'quantity' => 1
                ]
            ]
        ];

        $razorpayOrder = $this->gateway->order->create($orderData);

        $payment->addMeta('razorpay_order_id', $razorpayOrder->id);

        $booking->status = $booking::UNPAID;
        $booking->payment_id = $razorpayOrder->id;
        $booking->save();

        try {
            event(new BookingCreatedEvent($booking));
        } catch (\Exception $e) {
            Log::warning($e->getMessage());
        }

        $booking->addMeta('razorpay_order_id', $razorpayOrder->id);


        $razorpay_payment_url = '';
        return response()->json(['url' => $razorpay_payment_url])->send();
    }

    public function cancelPayment(Request $request)
    {
        $c = $request->query('c');
        $booking = Booking::where('code', $c)->first();
        if (!empty($booking) and in_array($booking->status, [$booking::UNPAID])) {
            $payment = $booking->payment;
            if ($payment) {
                $payment->status = 'cancel';
                $payment->logs = json_encode([
                    'customer_cancel' => 1
                ]);
                $payment->save();
            }

            // Refund without check status
            $booking->tryRefundToWallet(false);

            return redirect($booking->getDetailUrl())->with("error", __("You cancelled the payment"));
        }
        if (!empty($booking)) {
            return redirect($booking->getDetailUrl());
        } else {
            return redirect(url('/'));
        }
    }

    public function confirmPayment(Request $request)
    {
        $c = $request->query('c');
        $booking = Booking::where('code', $c)->first();

        $session_id = $request->query('session_id');

        $session = \Stripe\Checkout\Session::retrieve($session_id);
        if (empty($session)) {
            return redirect($booking->getDetailUrl(false));
        }

        if (!empty($booking) and in_array($booking->status, [$booking::UNPAID])) {

            $session_id = $request->query('session_id');
            if (empty($session_id)) {
                return redirect($booking->getDetailUrl(false));
            }

            $session = \Stripe\Checkout\Session::retrieve($session_id);
            if (empty($session)) {
                return redirect($booking->getDetailUrl(false));
            }

            if ($session->payment_status == 'paid') {
                $booking->paid += (float)$booking->pay_now;
                $booking->markAsPaid();
                $booking->addMeta('session_data', $session);
                $booking->addMeta('stripe_setup_intent', $session->setup_intent);
                $booking->addMeta('stripe_cs_complete', 1);
            }
            if ($session->payment_status == 'no_payment_required') {
                $booking->pay_now = 0;
                $booking->save();
                $booking->addMeta('session_data', $session);
                $booking->addMeta('stripe_setup_intent', $session->setup_intent);
                $booking->addMeta('stripe_cs_complete', 1);
            }

            return redirect($booking->getDetailUrl(false));
        }
        if (!empty($booking)) {
            return redirect($booking->getDetailUrl(false));
        } else {
            return redirect(url('/'));
        }
    }

    public function getGateway()
    {
        $gatewayConfiguration = (object)[
            'key' => $this->getOption('razorpay_key'),
            'secret' => $this->getOption('razorpay_secret'),
        ];
        if ($this->getOption('test_sandbox')) {
            $gatewayConfiguration->key = $this->getOption('razorpay_test_key');
            $gatewayConfiguration->secret = $this->getOption('razorpay_test_secret');
        }
        $this->gateway = (new Api($gatewayConfiguration->key, $gatewayConfiguration->secret));
    }
}
