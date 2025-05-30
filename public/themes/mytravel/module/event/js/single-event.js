(function ($) {
    "use strict"
    new Vue({
        el:'#bravo_event_book_app',
        data:{
            id:'',
            extra_price:[],
            ticket_types:[],
            message:{
                content:'',
                type:false
            },
            html:'',
            onSubmit:false,
            start_date:'',
            start_date_html:'',
            step:1,

            total_price_before_fee:0,
            total_price_fee:0,
            start_date_obj:'',
            duration:0,
            allEvents:[],
            buyer_fees:[],

            is_form_enquiry_and_book:false,
            enquiry_type:'book',
            enquiry_is_submit:false,
            enquiry_name:"",
            enquiry_email:"",
            enquiry_phone:"",
            enquiry_note:"",

            booking_type:"",
            booking_time_slots:"",
            select_start_time:[],
        },
        watch:{
            extra_price:{
                handler:function f() {
                    this.step = 1;
                },
                deep:true
            },
            ticket_types:{
                handler:function f() {
                    this.step = 1;
                },
                deep:true
            },
            start_date(){
                this.step = 1;
                var me = this;
                var startDate = new Date(me.start_date).getTime();
                for (var ix in me.allEvents) {
                    var item = me.allEvents[ix];
                    var cur_date = new Date(item.start).getTime();
                    if (cur_date === startDate) {
                        if (item.ticket_types != null) {
                            me.ticket_types = Object.assign([], item.ticket_types);
                        } else {
                            me.ticket_types = null
                        }
                        if (item.booking_time_slots != null) {
                            me.booking_time_slots = Object.assign([], item.booking_time_slots);
                        } else {
                            me.booking_time_slots = null
                        }
                    }
                }
                me.select_start_time = [];
            },
        },
        computed:{
            total_price:function(){
                var me = this;
                if (me.start_date !== "") {
                    var total = 0;
                    var total_tickets = 0;
                    var startDate = new Date(me.start_date).getTime();

                    if(me.booking_type === "ticket")
                    {
                        // for ticket types
                        if (me.ticket_types != null) {
                            for (var ix in me.ticket_types) {
                                var person_type = me.ticket_types[ix];
                                total += parseFloat(person_type.price) * parseInt(person_type.number);
                                total_tickets += parseInt(person_type.number);
                            }
                        }
                        if(total_tickets <= 0) return 0;
                    }
                    if(me.booking_type === "time_slot")
                    {
                        if(me.select_start_time.length < 1){
                            return 0
                        }
                        for (var ix in me.allEvents) {
                            var item = me.allEvents[ix];
                            var cur_date = new Date(item.start).getTime();
                            if (cur_date === startDate) {
                                total += parseFloat(item.price) * me.select_start_time.length;
                            }
                        }
                        total_tickets = me.select_start_time.length;
                    }

                    for (var ix in me.extra_price) {
                        var item = me.extra_price[ix];
                        var type_total = 0;
                        if (item.enable === true) {
                            switch (item.type) {
                                case "one_time":
                                    type_total += parseFloat(item.price);
                                    break;
                                case "per_hour":
                                    if (me.duration > 0) {
                                        type_total += parseFloat(item.price) * parseFloat(me.duration);
                                    }
                                    break;
                            }
                            if (typeof item.per_ticket !== "undefined") {
                                type_total = type_total * total_tickets;
                            }
                            total += type_total;
                        }
                    }

                    this.total_price_before_fee = total;

                    var total_fee = 0;
                    for (var ix in me.buyer_fees) {
                        var item = me.buyer_fees[ix];

                        //for Fixed
                        var fee_price = parseFloat(item.price);

                        //for Percent
                        if (typeof item.unit !== "undefined" && item.unit === "percent" ) {
                            fee_price = ( total / 100 ) * fee_price;
                        }

                        if (typeof item.per_ticket !== "undefined") {
                            fee_price = fee_price * total_tickets;
                        }
                        total_fee += fee_price;
                    }
                    total += total_fee;
                    this.total_price_fee = total_fee;

                    return total;
                }
                return 0;
            },
            total_price_html:function(){
                if(!this.total_price) return '';
                return window.bravo_format_money(this.total_price);
            },
            daysOfWeekDisabled(){
                var res = [];

                for(var k in this.open_hours)
                {
                    if(typeof this.open_hours[k].enable == 'undefined' || this.open_hours[k].enable !=1 ){

                        if(k == 7){
                            res.push(0);
                        }else{
                            res.push(k);
                        }
                    }
                }

                return res;
            },
            pay_now_price:function(){
                if(this.is_deposit_ready){
                    var total_price_depossit = 0;

                    var tmp_total_price = this.total_price;
                    var deposit_fomular = this.deposit_fomular;
                    if(deposit_fomular === "deposit_and_fee"){
                        tmp_total_price = this.total_price_before_fee;
                    }

                    switch (this.deposit_type) {
                        case "percent":
                            total_price_depossit =  tmp_total_price * this.deposit_amount / 100;
                            break;
                        default:
                            total_price_depossit =  this.deposit_amount;
                    }
                    if(deposit_fomular === "deposit_and_fee"){
                        total_price_depossit = total_price_depossit + this.total_price_fee;
                    }

                    return  total_price_depossit
                }
                return this.total_price;
            },
            pay_now_price_html:function(){
                return window.bravo_format_money(this.pay_now_price);
            },
            is_deposit_ready:function () {
                if(this.deposit && this.deposit_amount) return true;
                return false;
            }
        },
        created:function(){
            for(var k in bravo_booking_data){
                this[k] = bravo_booking_data[k];
            }
            // console.log("Create!!!!!");
        },
        mounted(){
            var me = this;
            var options = {
                singleDatePicker: true,
                showCalendar: false,
                sameDate: true,
                autoApply           : true,
                disabledPast        : true,
                dateFormat          : bookingCore.date_format,
                enableLoading       : true,
                showEventTooltip    : true,
                classNotAvailable   : ['disabled', 'off'],
                disableHightLight: true,
                minDate:this.minDate,
                opens: bookingCore.rtl ? 'right':'left',
                locale:{
                    direction: bookingCore.rtl ? 'rtl':'ltr',
                    firstDay:daterangepickerLocale.first_day_of_week
                },
                isInvalidDate:function (date) {
                    for(var k = 0 ; k < me.allEvents.length ; k++){
                        var item = me.allEvents[k];
                        if(item.start == date.format('YYYY-MM-DD')){
                            return item.active ? false : true;
                        }
                    }
                    return false;
                }
            };

            if (typeof  daterangepickerLocale == 'object') {
                options.locale = _.merge(daterangepickerLocale,options.locale);
            }
            this.$nextTick(function () {
                $(this.$refs.start_date).daterangepicker(options).on('apply.daterangepicker',
                    function (ev, picker) {
                        me.start_date = picker.startDate.format('YYYY-MM-DD');
                        me.start_date_html = picker.startDate.format(bookingCore.date_format);
                    })
                    .on('update-calendar',function (e,obj) {
                        me.fetchEvents(obj.leftCalendar.calendar[0][0], obj.leftCalendar.calendar[5][6])
                    });
            });
        },
        methods:{
            handleTotalPrice: function () {
            },
            fetchEvents(start,end){
                var me = this;
                var data = {
                    start: start.format('YYYY-MM-DD'),
                    end: end.format('YYYY-MM-DD'),
                    id:bravo_booking_data.id,
                    for_single:1
                };
                console.log(data);

                $.ajax({
                    url: bravo_booking_i18n.load_dates_url,
                    dataType:"json",
                    type:'get',
                    data:data,
                    beforeSend: function() {
                        $('.daterangepicker').addClass("loading");
                    },
                    success:function (json) {
                        me.allEvents = json;
                        var drp = $(me.$refs.start_date).data('daterangepicker');
                        drp.allEvents = json;
                        drp.renderCalendar('left');
                        if (!drp.singleDatePicker) {
                            drp.renderCalendar('right');
                        }
                        $('.daterangepicker').removeClass("loading");
                    },
                    error:function (e) {
                        console.log(e);
                        console.log("Can not get availability");
                    }
                });
            },
            formatMoney: function (m) {
                return window.bravo_format_money(m);
            },
            validate(){
                if(!this.start_date)
                {
                    this.message.status = false;
                    this.message.content = bravo_booking_i18n.no_date_select;
                    return false;
                }
                return true;
            },
            selectStartTime(time){
                var me = this;
                if(me.select_start_time.indexOf(time) === -1){
                    me.select_start_time.push(time)
                }else{
                    const index = me.select_start_time.indexOf(time);
                    if (index > -1) {
                        me.select_start_time.splice(index, 1);
                    }
                }
            },
            isInArray(time){
                var me = this;
                if(me.select_start_time.indexOf(time) === -1){
                    return false;
                }
                return true;
            },
            addPersonType(type){
                type.number = parseInt(type.number);
                if(type.number < parseInt(type.max)) type.number +=1;
            },
            minusPersonType(type){
                type.number = parseInt(type.number);
                if(type.number > type.min) type.number -=1;
            },
            changePersonType(type){
                type.number = parseInt(type.number);
                if(type.number > parseInt(type.max)){
                    type.number = type.max;
                }
                if(type.number < type.min){
                    type.number = type.min
                }
            },
            doSubmit:function (e) {
                e.preventDefault();
                if(this.onSubmit) return false;

                if(!this.validate()) return false;

                this.onSubmit = true;
                var me = this;

                this.message.content = '';

                if(this.step == 1){
                    this.html = '';
                }

                $.ajax({
                    url:bookingCore.url+'/booking/addToCart',
                    data:{
                        service_id:this.id,
                        service_type:'event',
                        start_date:this.start_date,
                        ticket_types:this.ticket_types,
                        extra_price:this.extra_price,
                        step:this.step,
                        select_start_time:this.select_start_time,
                    },
                    dataType:'json',
                    type:'post',
                    success:function(res){

                        if(!res.status){
                            me.onSubmit = false;
                        }
                        if(res.message)
                        {
                            me.message.content = res.message;
                            me.message.type = res.status;
                        }

                        if(res.step){
                            me.step = res.step;
                        }
                        if(res.html){
                            me.html = res.html
                        }

                        if(res.url){
                            window.location.href = res.url
                        }

                        if(res.errors && typeof res.errors == 'object')
                        {
                            var html = '';
                            for(var i in res.errors){
                                html += res.errors[i]+'<br>';
                            }
                            me.message.content = html;
                        }
                    },
                    error:function (e) {
                        console.log(e);
                        me.onSubmit = false;

                        bravo_handle_error_response(e);

                        if(e.status == 401){
                            $('.bravo_single_book_wrap').modal('hide');
                        }

                        if(e.status != 401 && e.responseJSON){
                            me.message.content = e.responseJSON.message ? e.responseJSON.message : 'Can not booking';
                            me.message.type = false;

                        }
                    }
                })
            },
            doEnquirySubmit:function(e){
                e.preventDefault();
                if(this.onSubmit) return false;
                if(!this.validateenquiry()) return false;
                this.onSubmit = true;
                var me = this;
                this.message.content = '';

                $.ajax({
                    url:bookingCore.url+'/booking/addEnquiry',
                    data:{
                        service_id:this.id,
                        service_type:'event',
                        name:this.enquiry_name,
                        email:this.enquiry_email,
                        phone:this.enquiry_phone,
                        note:this.enquiry_note,
                    },
                    dataType:'json',
                    type:'post',
                    success:function(res){
                        if(res.message)
                        {
                            me.message.content = res.message;
                            me.message.type = res.status;
                        }
                        if(res.errors && typeof res.errors == 'object')
                        {
                            var html = '';
                            for(var i in res.errors){
                                html += res.errors[i]+'<br>';
                            }
                            me.message.content = html;
                        }
                        if(res.status){
                            me.enquiry_is_submit = true;
                            me.enquiry_name = "";
                            me.enquiry_email = "";
                            me.enquiry_phone = "";
                            me.enquiry_note = "";
                        }
                        me.onSubmit = false;

                    },
                    error:function (e) {
                        me.onSubmit = false;
                        bravo_handle_error_response(e);
                        if(e.status == 401){
                            $('.bravo_single_book_wrap').modal('hide');
                        }
                        if(e.status != 401 && e.responseJSON){
                            me.message.content = e.responseJSON.message ? e.responseJSON.message : 'Can not booking';
                            me.message.type = false;
                        }
                    }
                })
            },
            validateenquiry(){
                if(!this.enquiry_name)
                {
                    this.message.status = false;
                    this.message.content = bravo_booking_i18n.name_required;
                    return false;
                }
                if(!this.enquiry_email)
                {
                    this.message.status = false;
                    this.message.content = bravo_booking_i18n.email_required;
                    return false;
                }
                return true;
            },
            openStartDate(){
                console.log("xxx");
                $(this.$refs.start_date).trigger('click');
            }
        }

    });


    $(window).on("load", function () {
        var urlHash = window.location.href.split("#")[1];
        if (urlHash &&  $('.' + urlHash).length ){
            var offset_other = 70
            if(urlHash === "review-list"){
                offset_other = 330;
            }
            $('html,body').animate({
                scrollTop: $('.' + urlHash).offset().top - offset_other
            }, 1000);
        }
    });

    $(".bravo-button-book-mobile").on('click',function () {
        $('.bravo_single_book_wrap').modal('show');
    });

    $(".bravo_detail_event .g-faq .item .header").on('click',function () {
        $(this).parent().toggleClass("active");
    });

})(jQuery);
