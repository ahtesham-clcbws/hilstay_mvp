<?php
return [
    'gateways'=>[
        'offline_payment'=>Modules\Booking\Gateways\OfflinePaymentGateway::class,
        'paypal'=>Modules\Booking\Gateways\PaypalGateway::class,
        'razorpay'=>Modules\Booking\Gateways\RazorpayGateway::class,
        'stripe'=>Modules\Booking\Gateways\StripeGateway::class,
        'payrexx'=>Modules\Booking\Gateways\PayrexxGateway::class,
        'paystack'=>Modules\Booking\Gateways\PaystackGateway::class,
    ],
];
