@extends('layouts.app')
@push('css')
<link href="{{ asset('themes/mytravel/dist/frontend/module/space/css/space.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('themes/mytravel/libs/ion_rangeslider/css/ion.rangeSlider.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('libs/fotorama/fotorama.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('libs/lightbox/jquery.lightbox.min.css') }}" />
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
    var bravo_booking_data = <?= json_encode($booking_data) ?>
    var bravo_booking_i18n = {
        no_date_select: '<?= __('Please select Start and End date') ?>',
        no_guest_select: '<?= __('Please select at least one guest') ?>',
        load_dates_url: '<?= route('space.vendor.availability.loadDates') ?>',
        name_required: '<?= __("Name is Required") ?>',
        email_required: '<?= __("Email is Required") ?>',
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
