@extends('layouts.app')
@push('css')
<link href="{{ asset('themes/mytravel/dist/frontend/module/space/css/space.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('themes/mytravel/libs/ion_rangeslider/css/ion.rangeSlider.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('libs/fotorama/fotorama.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('libs/lightbox/jquery.lightbox.min.css') }}" />
<style>
    /* .otherMonthClass {
        opacity: 0.5;
    } */
    .beforeToday {
        background-color: #f5f5f5;
        color: #999;
    }

    .otherMonthClass {
        opacity: 0.6;
        color: #ccc;
    }

    .currentDay,
    .today {
        background-color: rgb(1, 205, 1);
        font-weight: bold;
        color: #fff;
    }

    .fixed-width-calendar th,
    .fixed-width-calendar td {
        width: 14.28%;
        /* Each column is 1/7th of 100% */
        text-align: center;
        /* Center-align text for better appearance */
        padding: 10px;
        /* Add padding for better readability */
        box-sizing: border-box;
        /* Ensure padding doesn't affect width */
    }

    .fixed-width-calendar {
        table-layout: fixed;
        /* Ensures table columns have fixed widths */
        width: 100%;
        /* Table spans the full container width */
        border-collapse: collapse;
        /* Neat borders for the table */
    }

    .fixed-width-calendar th {
        background-color: #e0e0e0;
        /* Light background for table header */
        font-weight: bold;
    }

    .fixed-width-calendar td {
        vertical-align: middle;
        /* Align content vertically to the middle */
    }

    .table-calendar {
        border-collapse: collapse;
        width: 100%;
    }

    .table-calendar td,
    .table-calendar th {
        padding: 5px;
        border: 1px solid #e2e2e2;
        text-align: center;
        vertical-align: top;
    }

    .calendarPrice {
        font-size: 12px;
        color: #333;
        font-weight: bold;
    }

    .calendarCross {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        font-size: 50px;
        color: #000;
        /* font-weight: bold; */
    }
    .calendarDate {
        font-size: 120%;
    }

    /* .available {
        background-color: #e8f5e9;
    }

    .unavailable {
        background-color: #ffebee;
    } */
</style>
@endpush
@section('content')
<div class="bravo_detail_space">
    @include('Space::frontend.layouts.details.space-banner')
    <div class="bravo_content">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-9">
                    @php $review_score = $row->review_data @endphp
                    @include('Space::frontend.layouts.details.space-detail')
                    <div class="mt-4">
                        <div id="availability-calendar" class="row g-4">
                            <!-- Current Month Calendar -->
                            <div class="col-12">
                                <h3>
                                    <center>{{ $today->format('F Y') }}</center>
                                </h3>
                                <table border="1" class="table-calendar w-100 fixed-width-calendar" style="min-height:300px;">
                                    <thead>
                                        <tr class="w3-theme">
                                            <th>Sun</th>
                                            <th>Mon</th>
                                            <th>Tue</th>
                                            <th>Wed</th>
                                            <th>Thu</th>
                                            <th>Fri</th>
                                            <th>Sat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (array_chunk($currentMonthDates, 7) as $week)
                                        <tr>
                                            @foreach ($week as $date)
                                            @php
                                            $availability = $availabilityMap->get($date->format('Y-m-d')); // Check availability for this date
                                            @endphp
                                            <td class="relative position-relative {{ $date->isToday() ? 'currentDay' : '' }} {{ $date->month != $today->month ? 'otherMonthClass' : '' }} {{ $date->lt($today) ? 'beforeToday' : '' }}
                                                {{ $availability && $availability['active'] ? 'available' : 'unavailable' }}
                                                {{ $availability && !$availability['active'] ? implode(' ', $availability['classNames'] ?? []) : '' }}
                                                ">
                                                <span class="calendarDate">
                                                    {{ $date->day }}
                                                </span>
                                                @if ($availability)
                                                @if ($availability['active'] == 0)
                                                <div class="calendarCross">X</div>
                                                @else
                                                <div class="calendarPrice">
                                                    {!! $availability['price_html'] !!}
                                                </div>
                                                @endif

                                                @endif
                                            </td>
                                            @endforeach
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Next Month Calendar -->
                            <div class="col-12">
                                <h3>
                                    <center>{{ $nextMonth->format('F Y') }}</center>
                                </h3>
                                <table border="1" class="table-calendar w-100 fixed-width-calendar" style="min-height:300px;">
                                    <thead>
                                        <tr class="w3-theme">
                                            <th>Sun</th>
                                            <th>Mon</th>
                                            <th>Tue</th>
                                            <th>Wed</th>
                                            <th>Thu</th>
                                            <th>Fri</th>
                                            <th>Sat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (array_chunk($nextMonthDates, 7) as $week)
                                        <tr>
                                            @foreach ($week as $date)
                                            @php
                                            $availability = $availabilityMap->get($date->format('Y-m-d')); // Check availability for this date
                                            @endphp
                                            <td class="relative position-relative {{ $date->month != $nextMonth->month ? 'otherMonthClass' : '' }}
                                            {{ $availability && $availability['active'] ? 'available' : 'unavailable' }}
                                            {{ $availability && !$availability['active'] ? implode(' ', $availability['classNames'] ?? []) : '' }}
                                            ">
                                                <span class="calendarDate">
                                                    {{ $date->day }}
                                                </span>
                                                @if ($availability)
                                                @if ($availability['active'] == 0)
                                                <div class="calendarCross">X</div>
                                                @else
                                                <div class="calendarPrice">
                                                    {!! $availability['price_html'] !!}
                                                </div>
                                                @endif

                                                @endif
                                            </td>
                                            @endforeach
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    @include('Space::frontend.layouts.details.space-review')
                </div>
                <div class="col-md-12 col-lg-3">
                    @include('Tour::frontend.layouts.details.vendor')
                    @include('Space::frontend.layouts.details.space-form-book')
                    @include('Booking::frontend/booking/booking-why-book-us')
                </div>
            </div>
            <div class="row end_tour_sticky">
                <div class="col-md-12">
                    @include('Space::frontend.layouts.details.space-related')
                </div>
            </div>
        </div>
    </div>
    @include('Space::frontend.layouts.details.space-form-book-mobile')
</div>
@endsection

@push('js')
{!! App\Helpers\MapEngine::scripts() !!}
<script>
    jQuery(function($) {
        "use strict"
        <?php if ($row->map_lat && $row->map_lng) { ?>
            new BravoMapEngine('map_content', {
                disableScripts: true,
                fitBounds: true,
                center: [<?= $row->map_lat ?>, <?= $row->map_lng ?>],
                zoom: <?= $row->map_zoom ?? "8" ?>,
                ready: function(engineMap) {
                    engineMap.addMarker([<?= $row->map_lat ?>, <?= $row->map_lng ?>], {
                        icon_options: {
                            iconUrl: "<?= get_file_url(setting_item("space_icon_marker_map"), 'full') ?? url('images/icons/png/pin.png') ?>"
                        }
                    });
                }
            });
        <?php } ?>
    })
</script>
<script>
    // dont change to php
    var bravo_booking_data = {!!json_encode($booking_data) !!}
    var bravo_booking_i18n = {
        no_date_select: 'Please select Start and End date',
        no_guest_select: 'Please select at least one guest',
        load_dates_url: '<?= route('space.vendor.availability.loadDates') ?>',
        name_required: 'Name is Required',
        email_required: 'Email is Required',
    };
</script>
<script type="text/javascript" src="<?= asset("themes/mytravel/libs/ion_rangeslider/js/ion.rangeSlider.min.js") ?>"></script>
<script type="text/javascript" src="<?= asset("libs/fotorama/fotorama.js") ?>"></script>
<script type="text/javascript" src="<?= asset("libs/sticky/jquery.sticky.js") ?>"></script>
<script type="text/javascript" src="<?= asset('themes/mytravel/module/space/js/single-space.js?_ver=' . config('app.asset_version')) ?>"></script>

<script type="text/javascript" src="<?= asset("libs/lightbox/jquery.lightbox.min.js") ?>"></script>

<script>
    $(function() {
        $('.lightboxGallery a').lightbox();
    });
</script>

@endpush
