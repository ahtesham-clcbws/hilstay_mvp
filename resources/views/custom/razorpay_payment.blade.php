@extends('layouts.app')

@section('content')
<style>
    ._failed {
        border-bottom: solid 4px red !important;
    }

    ._failed i {
        color: red !important;
    }

    ._success {
        box-shadow: 0 15px 25px #00000019;
        padding: 45px;
        width: 100%;
        text-align: center;
        margin: 40px auto;
        border-bottom: solid 4px #28a745;
    }

    ._success i {
        font-size: 55px;
        color: #28a745;
    }

    ._success h2 {
        margin-bottom: 12px;
        font-size: 40px;
        font-weight: 500;
        line-height: 1.2;
        margin-top: 10px;
    }

    ._success p {
        margin-bottom: 0px;
        font-size: 18px;
        color: #495057;
        font-weight: 500;
    }
</style>
<div class="container my-4">
    <div class="row justify-content-center my-4">
        <div class="col-md-8 my-4">
            <div class="card my-4 bg-secondary">
                <div class="card-bod text-center">
                    <h3 class="my-4 text-white">Your payment is being processed. Please wait ...</h3>
                    <div class="spinner-border text-info" style="width: 3rem; height: 3rem;" role="status"></div>
                    <p class="my-4 text-white">It takes 2-3 minutes to finish the payment.</p>
                </div>
            </div>
        </div>
    </div>
    <button id="rzp-button1" style="height:0px !important;width:0px !important;"></button>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = {
            "key": "{{ $razorpay_key }}", // Enter the Key ID generated from the Dashboard
            "amount": "{{ intval($booking->pay_now) * 100 }}", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
            "currency": "INR",
            "name": "Hillstay", //your business name
            "description": "Booking",
            "image": "https://test.hillstay.in/uploads/0000/6/2024/12/02/hillstay-logo.png",
            "order_id": "{{ $order_id }}", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
            "callback_url": "{{ route('razorpay_success', $bookingId) }}",
            "prefill": { //We recommend using the prefill parameter to auto-fill customer's contact information especially their phone number
                "name": "{{ $booking->first_name }} {{ $booking->last_name }}", //your customer's name
                "email": "{{ $booking->email }}",
                "contact": "{{ $booking->phone }}" //Provide the customer's phone number for better conversion rates
            },
            "theme": {
                "color": "#103815"
            }
        };
        var rzp1 = new Razorpay(options);
        document.getElementById('rzp-button1').onclick = function(e) {
            rzp1.open();
            e.preventDefault();
        }
        document.getElementById('rzp-button1').click();
    </script>
</div>
@endsection
