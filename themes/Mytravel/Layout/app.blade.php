<!DOCTYPE html>
<html class="{{ $html_class ?? '' }}" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="developer" content="ahtesham">
        <meta name="layout" content="theme app layout">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @php event(new \Modules\Layout\Events\LayoutBeginHead()); @endphp
        @php
            $favicon = setting_item('site_favicon');
        @endphp
        @if ($favicon)
            @php
                $file = (new \Modules\Media\Models\MediaFile())->findById($favicon);
            @endphp
            @if (!empty($file))
                <link type="{{ $file['file_type'] }}" href="{{ asset('uploads/' . $file['file_path']) }}"
                    rel="icon" />
            @else:
                <link type="image/png" href="{{ url('images/favicon.png') }}" rel="icon" />
            @endif
        @endif

        @include('Layout::parts.seo-meta')
        <link href="{{ asset('libs/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
        <link href="{{ asset('libs/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
        <link href="{{ asset('libs/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
        <link href="{{ asset('libs/icofont/icofont.min.css') }}" rel="stylesheet">
        <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet">

        <link href="{{ asset('themes/mytravel/libs/fancybox/jquery.fancybox.css') }}" rel="stylesheet">
        <link href="{{ asset('themes/mytravel/libs/slick/slick.css') }}" rel="stylesheet">
        <link href="{{ asset('themes/mytravel/libs/custombox/custombox.min.css') }}" rel="stylesheet">

        <link href="{{ asset('themes/mytravel/dist/frontend/css/notification.css') }}" rel="newest stylesheet">
        <link href="{{ asset('themes/mytravel/dist/frontend/css/app.css?_ver=' . time()) }}" rel="stylesheet">

        <link type="text/css" href="<?= asset('libs/daterange/daterangepicker.css') ?>" rel="stylesheet">
        <!-- Fonts -->
        <link href="//fonts.gstatic.com" rel="dns-prefetch">
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
        <link href="//fonts.googleapis.com/css?family=Rubik:300,400,500,700,900&display=swap" rel="stylesheet">
        <link href="//fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,600,700&display=swap"
            rel="stylesheet">
        <link
            href="https://fonts.googleapis.com/css?family=Libre+Franklin:100,200,300,400,500,600,700,800,900&display=swap"
            rel="stylesheet">

        <link href="{{ asset('themes/mytravel/libs/bootstrap-select/dist/css/bootstrap-select.min.css') }}"
            rel="stylesheet">
        <link href="{{ asset('libs/ion_rangeslider/css/ion.rangeSlider.css') }}" rel="stylesheet">

        {{-- <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/index.global.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/web-component@6.1.15/index.global.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.15/index.global.min.js'></script> --}}

        {!! \App\Helpers\Assets::css() !!}
        {!! \App\Helpers\Assets::js() !!}
        @include('Layout::parts.global-script')
        <!-- Styles -->
        @stack('css')
        {{-- Custom Style --}}
        <link href="{{ route('core.style.customCss') }}" rel="stylesheet">
        <link href="{{ asset('libs/carousel-2/owl.carousel.css') }}" rel="stylesheet">
        @if (setting_item_with_lang('enable_rtl'))
            <link href="{{ asset('themes/mytravel/dist/frontend/css/rtl.css?_v=' . config('app.asset_version')) }}"
                rel="stylesheet">
        @endif
        {!! setting_item('head_scripts') !!}
        {!! setting_item_with_lang_raw('head_scripts') !!}

        @php event(new \Modules\Layout\Events\LayoutEndHead()); @endphp

        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
        <style>
            ul li:before {
                border-color: #103815 !important;
                background-color: #103815 !important;
            }
        </style>

    </head>

    <body
        class="frontend-page {{ $body_class ?? '' }} @if (!empty($is_home) or !empty($header_transparent)) header_transparent @endif @if (setting_item_with_lang('enable_rtl')) is-rtl @endif @if (is_api()) is_api @endif"
        dir="{{ setting_item_with_lang('enable_rtl') ? 'rtl' : 'ltr' }}">
        @php event(new \Modules\Layout\Events\LayoutBeginBody()); @endphp

        {!! setting_item('body_scripts') !!}
        {!! setting_item_with_lang_raw('body_scripts') !!}
        <div class="bravo_wrap">
            @if (!is_api())
                @include('Layout::parts.header')
            @endif

            @yield('content')

            @include('Layout::parts.footer')
        </div>
        {!! setting_item('footer_scripts') !!}
        {!! setting_item_with_lang_raw('footer_scripts') !!}
        @php event(new \Modules\Layout\Events\LayoutEndBody()); @endphp
        {{-- @include('demo_script') --}}
    </body>

</html>
