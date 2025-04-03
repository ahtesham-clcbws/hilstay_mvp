
(function ($) {

    new Vue({
        el: '#bravo-checkout-page',
        data: {
            onSubmit: false,
            message: {
                content: '',
                type: false
            }
        },
        methods: {
            doCheckout() {
                var me = this;

                if (this.onSubmit) return false;

                // http://hillstay.test/booking/ff00a89e5b0fda83e29465f261353943/checkout
                var selectedGateway = document.querySelector('input[name="payment_gateway"]:checked').value;
                var bookingCode = document.querySelector('input[name="code"]').value;

                if (selectedGateway == 'razorpay') {
                    console.log('bookingCode: ', bookingCode);
                    // console.log('data of payment gateway: ', $('.booking-form').find('input,textarea,select'))
                    // window.location.href = '/booking/razorpay/' + bookingCode;
                    // go to custom page for further processing of the razorpay payment gateway

                    // first create razorpay order here
                    return $.ajax({
                        url: '/booking/razorpay/' + bookingCode,
                        method: "post",
                        data: $('.booking-form').find('input,textarea,select').serialize(),
                        success: function (res) {
                            console.log('razorpay res: ', res);
                            // return false;
                            if (res.success) {
                                const bookingData = res.bookingData;
                                const razorpay_key = res.razorpay_key;
                                const order_id = res.order_id;
                                const callback_url = res.callback_url;

                                var rzpOptions = {
                                    // "key": "{{ $razorpay_key }}", // Enter the Key ID generated from the Dashboard
                                    "key": razorpay_key, // Enter the Key ID generated from the Dashboard
                                    // "amount": "{{ intval($booking->pay_now) * 100 }}", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                                    "amount": bookingData.pay_now * 100, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                                    "currency": "INR",
                                    "name": "Hillstay",
                                    "description": "Booking",
                                    "image": "https://test.hillstay.in/uploads/0000/6/2024/12/02/hillstay-logo.png",
                                    // "order_id": "{{ $order_id }}", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                                    "order_id": order_id, //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                                    // "callback_url": "{{ route('razorpay_success', $bookingId) }}",
                                    "callback_url": callback_url,
                                    "prefill": { //We recommend using the prefill parameter to auto-fill customer's contact information especially their phone number
                                        // "name": "{{ $booking->first_name }} {{ $booking->last_name }}", //your customer's name
                                        // "email": "{{ $booking->email }}",
                                        // "contact": "{{ $booking->phone }}" //Provide the customer's phone number for better conversion rates
                                        "name": bookingData.first_name + ' ' + bookingData.last_name, //your customer's name
                                        "email": bookingData.email,
                                        "contact": bookingData.phone //Provide the customer's phone number for better conversion rates
                                    },
                                    "theme": {
                                        "color": "#103815"
                                    }
                                };
                                var rzp1 = new Razorpay(rzpOptions);
                                rzp1.open();
                            } else {
                                alert('Error creating Razorpay order, please contact administrator.');
                            }
                        },
                        error: function (e) {
                            console.log('razorpay error: ', e);
                            alert('Booking error, please try after some time.');
                        }
                    });
                    return false;
                }

                if (!this.validate()) return false;

                this.onSubmit = true;

                $.ajax({
                    url: bookingCore.routes.checkout,
                    data: $('.booking-form').find('input,textarea,select').serialize(),
                    method: "post",
                    success: function (res) {
                        if (!res.status && !res.url) {
                            me.onSubmit = false;
                        }


                        if (res.elements) {
                            for (var k in res.elements) {
                                $(k).html(res.elements[k]);
                            }
                        }

                        if (res.message) {
                            me.message.content = res.message;
                            me.message.type = res.status;
                        }

                        if (res.url) {
                            window.location.href = res.url;
                        }

                        if (res.errors && typeof res.errors == 'object') {
                            var html = '';
                            for (var i in res.errors) {
                                html += res.errors[i] + '<br>';
                            }
                            me.message.content = html;
                        }
                        if (typeof BravoReCaptcha != "undefined") {
                            BravoReCaptcha.reset('booking');
                        }

                    },
                    error: function (e) {
                        me.onSubmit = false;
                        if (e.responseJSON) {
                            me.message.content = e.responseJSON.message ? e.responseJSON.message : 'Can not booking';
                            me.message.type = false;
                        } else {
                            if (e.responseText) {
                                me.message.content = e.responseText;
                                me.message.type = false;
                            }
                        }
                        if (typeof BravoReCaptcha != "undefined") {
                            BravoReCaptcha.reset('booking');
                        }
                    }
                });
            },
            validate() {
                return true;
            }
        }
    });
})(jQuery);
$('#confirmRegister').change(function () {
    if ($(this).prop('checked')) {
        $('#confirmRegisterContent').removeClass('d-none');
    } else {
        $('#confirmRegisterContent').addClass('d-none');
    }
});
