<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Booking\Models\Booking;
use Modules\Booking\Models\Payment;
use Razorpay\Api\Api;

class RazorpayController extends Controller
{

    public function processPayment(Request $request, string $bookingId)
    {
        try {
            // a9b64d7d5ed9ed80584b46c1294f6708
            $booking = Booking::where('code', $bookingId)->first();

            $booking->first_name = $request->input('first_name');
            $booking->last_name = $request->input('last_name');
            $booking->email = $request->input('email');
            $booking->phone = $request->input('phone');
            $booking->address = $request->input('address_line_1');
            $booking->address2 = $request->input('address_line_2');
            $booking->city = $request->input('city');
            $booking->state = $request->input('state');
            $booking->zip_code = $request->input('zip_code');
            $booking->country = $request->input('country');
            $booking->customer_notes = $request->input('customer_notes');
            $booking->gateway = 'razorpay';
            // $booking->wallet_credit_used = floatval($credit);
            // $booking->wallet_total_used = floatval($wallet_total_used);
            $booking->pay_now = floatval((int)$booking->deposit == null ? $booking->total : (int)$booking->deposit);
            // print_r([$booking]);

            $paymentData = [
                'booking_id' => $booking->id,
                'payment_gateway' => 'razorpay',
                'status' => 'draft',
                'amount' => (float) $booking->pay_now
            ];

            $payment = new Payment();
            $payment->forceFill($paymentData);
            $payment->save();

            $order = [
                'receipt' => $bookingId,
                'amount' => intval($booking->pay_now) * 100,
                'currency' => 'INR',
                'notes' => [
                    'amount' => $booking->total_before_fees,
                    'to_be_pay' => $booking->pay_now,
                ]
            ];

            $api = new Api(config('razorpay.key'), config('razorpay.secret'));
            $razorpayOrder = $api->order->create($order);

            if ($razorpayOrder && ($razorpayOrder->status == 'created' || $razorpayOrder->status == 'attempted')) {
                // return print_r($razorpayOrder);
                $payment->addMeta('razorpay_order_id', $razorpayOrder->id);
                $payment->logs = json_encode($razorpayOrder);
                $payment->save();
                // continue with the view page
                return response()->json([
                    'request' => $request->all(),
                    'success' => true,
                    "bookingData" => $booking,
                    "razorpay_key" => config('razorpay.key'),
                    "order_id" => $razorpayOrder->id,
                    "callback_url" => route('razorpay_success', $bookingId)
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Some error happened.'
                ]);
                // return view('custom/razorpay_error_page');
            }

            // http://hillstay.test/booking/ff00a89e5b0fda83e29465f261353943
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function successPayment(Request $request, string $bookingId)
    {
        try {
            if ($request->razorpay_order_id && $request->razorpay_payment_id) {
                $booking = Booking::where('code', $bookingId)->orderBy('id', 'desc')->first();

                $payment = Payment::where('booking_id', $booking->id)->orderBy('id', 'desc')->first();
                $payment->status = 'paid';
                $payment->save();

                $booking->status = 'paid';
                $booking->payment_id = $payment->id;
                $booking->paid = $booking->pay_now;
                $payment->logs = json_encode([
                    'razorpay_order_id' => $request->razorpay_order_id,
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'status' => 'paid'
                ]);
                $booking->save();

                $url = '/booking/' . $bookingId;
                return redirect($url);

                // means payment is successful
                // redirect to below url
                // http://hillstay.test/booking/ff00a89e5b0fda83e29465f261353943
            } else {
                return view('custom/razorpay_error_page');
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getOption($key, $default = '')
    {
        return setting_item('g_razorpay_' . $key, $default);
    }
}
