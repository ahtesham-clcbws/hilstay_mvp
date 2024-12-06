<div class="d-block d-md-flex flex-center-between align-items-start">
    <div class="mb-3">
        <div class="d-block mb-2 mb-md-0">
            <h4 class="mb-0" style="font-size: calc(.8em + 2vw); font-weight: calc(300 + (100*1vw));">{!! clean($translation->title) !!}</h4>
            @if($row->getReviewEnable())
            <a href="#scroll-reviews">
                <span class="font-size-14 text-primary mr-2">{{ $review_score['score_total'] }}/5 <i class="icon fa fa-star-o mr-2"></i> {{$review_score['score_text']}}</span>
                <span class="font-size-14 text-gray-1 ml-1">{{__(":number reviews",['number'=>$review_score['total_review']])}}</span>
            </a>
            @endif
        </div>
        <div class="d-block d-md-flex flex-horizontal-center font-size-14 text-gray-1">
            @if($translation->address)
            <i class="icon flaticon-placeholder mr-2 font-size-20"></i>
            {{ $translation->address }}
            @endif
        </div>
    </div>
    <ul class="list-group list-group-horizontal custom-social-share d-none d-md-flex">
        <li class="list-group-item px-1 border-0">
            <span class="height-45 width-45 border rounded border-width-2 flex-content-center service-wishlist {{$row->isWishList()}}" data-id="{{$row->id}}" data-type="{{$row->type}}">
                <i class="flaticon-like font-size-18 text-dark"></i>
            </span>
        </li>
        <li class="list-group-item px-1 border-0">
            <a id="shareDropdownInvoker{{$row->id}}"
                class="dropdown-nav-link dropdown-toggle d-flex height-45 width-45 border rounded border-width-2 flex-content-center"
                href="javascript:;" role="button" aria-controls="shareDropdown{{$row->id}}" aria-haspopup="true" aria-expanded="false" data-unfold-event="hover"
                data-unfold-target="#shareDropdown{{$row->id}}" data-unfold-type="css-animation" data-unfold-duration="300" data-unfold-delay="300" data-unfold-hide-on-scroll="true" data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">
                <i class="flaticon-share font-size-18 text-dark"></i>
            </a>
            <div id="shareDropdown{{$row->id}}" class="dropdown-menu dropdown-unfold dropdown-menu-right mt-0 px-3 min-width-3" aria-labelledby="shareDropdownInvoker{{$row->id}}">
                <a class="btn btn-icon btn-pill btn-bg-transparent transition-3d-hover  btn-xs btn-soft-dark  facebook mb-3" href="https://www.facebook.com/sharer/sharer.php?u={{$row->getDetailUrl()}}&amp;title={{$translation->title}}" target="_blank" rel="noopener" original-title="{{__("Facebook")}}">
                    <span class="font-size-15 fa fa-facebook-f btn-icon__inner"></span>
                </a>
                <br />
                <a class="btn btn-icon btn-pill btn-bg-transparent transition-3d-hover  btn-xs btn-soft-dark  twitter" href="https://twitter.com/share?url={{$row->getDetailUrl()}}&amp;title={{$translation->title}}" target="_blank" rel="noopener" original-title="{{__("Twitter")}}">
                    <span class="font-size-15 fa fa-twitter btn-icon__inner"></span>
                </a>
            </div>
        </li>
    </ul>
</div>

<div class="border-bottom mb-4 pb-1 d-md-flex justify-content-between align-items-end">
    <ul class="list-group list-group-borderless list-group-horizontal d-flex">
        @if($row->bedroom)
        <li class="d-flex mr-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="text-primary" viewBox="0 0 32 32" width="16" height="16">
                <path d="M29.5 6h-2.793L24.85 4.143a1.5 1.5 0 1 0-2.7 0L20.293 6H17.5a.5.5 0 0 0-.5.5v8a.5.5 0 0 0 .5.5h12a.5.5 0 0 0 .5-.5v-8a.5.5 0 0 0-.5-.5zm-6-3a.5.5 0 1 1-.5.5.5.5 0 0 1 .5-.5zm-.643 1.85a1.453 1.453 0 0 0 1.286 0L25.293 6h-3.586zM29 7v3.293l-1.146-1.147a.5.5 0 0 0-.708 0L24.5 11.793l-2.646-2.647a.5.5 0 0 0-.708 0L18 12.293V7zm-11 6.707 3.5-3.5L25.293 14H18zm8.707.293-1.5-1.5 2.293-2.293 1.5 1.5V14z" />
                <circle cx="24.5" cy="8.5" r=".5" />
                <path d="M29.5 29H28v-7.5a4.505 4.505 0 0 0-4.5-4.5H10v-2.5A2.5 2.5 0 0 0 7.5 12H7V9.5a.5.5 0 0 0-.5-.5h-2a.5.5 0 0 0-.5.5V29H2.5a.5.5 0 0 0 0 1h27a.5.5 0 0 0 0-1zM27 21.5V25H7v-7h16.5a3.5 3.5 0 0 1 3.5 3.5zM7 26h18v3H7zm.5-13A1.5 1.5 0 0 1 9 14.5V17H7v-4zM5 29V10h1v19zm21 0v-3h1v3z" />
            </svg>
            <div class="text-gray-1 ml-1"> {{$row->bedroom}} {{ __("Bedroom") }}</div>
        </li>
        @endif
        <li class="d-flex mr-2">
            <svg width="16" height="16" class="text-primary" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                viewBox="0 0 489.6 489.6" xml:space="preserve">
                <g>
                    <g>
                        <path id="XMLID_2038_" style="fill:#94A4A4;" d="M244.72,99.2c0.1,0,0.2,0,0.2,0l0,0c40.4-0.4,34.5-54.4,34.5-54.4
                            c-1.6-36.1-31.7-35.8-34.7-35.7c-3-0.1-33.1-0.4-34.8,35.6c0,0-5.9,54,34.6,54.4l0,0C244.52,99.2,244.62,99.2,244.72,99.2z" />
                        <path id="XMLID_2039_" style="fill:#94A4A4;" d="M244.72,166.3l26.1-36c0,0,18.4,7.4,33.4,18.5c3.9,2.9,5.7,4.6,9.2,8.1
                            c8.3,8.3,4.8,56.4,0,74s-18.9,42.9-18.9,42.9c-2.8,6.4-4.6,13.3-5.3,20.2l-18,176.5c-0.6,5.6-5.3,9.9-10.9,9.9h-15.6h-15.6
                            c-5.6,0-10.4-4.3-10.9-9.9l-18-176.5c-0.7-7-2.5-13.8-5.3-20.2c0,0-14.1-25.2-18.9-42.9c-4.8-17.6-8.3-65.7,0-74
                            c3.5-3.5,5.3-5.2,9.2-8.1c15-11,33.4-18.5,33.4-18.5L244.72,166.3z" />
                        <path style="fill:#2C2F33;" d="M41.72,248.8c4.5,16.4,16.5,38.5,18.3,41.9c2.2,5.1,3.6,10.4,4.1,15.9l16.9,165.6
                            c1,9.9,9.3,17.4,19.3,17.4h29.2c10,0,18.3-7.5,19.3-17.4l16.9-165.6c0.6-5.6,2-11.1,4.3-16.2c2-4.6-0.1-9.9-4.6-11.9
                            c-4.6-2-9.9,0.1-11.9,4.6c-3,6.9-5,14.2-5.7,21.7l-16.9,165.6c-0.1,0.6-0.6,1.1-1.2,1.1h-29.2c-0.6,0-1.2-0.5-1.2-1.1l-17.1-165.7
                            c-0.8-7.5-2.7-14.8-5.7-21.7c-0.1-0.3-0.2-0.5-0.4-0.8c-0.1-0.2-12.7-22.9-16.9-38.2c-4.6-17.1-5.9-54.3-2.1-60.9
                            c3-3,4.3-4.2,7.4-6.5c7.9-5.8,17-10.5,22.9-13.3l20.2,27.8c1.7,2.3,4.4,3.7,7.3,3.7s5.6-1.4,7.3-3.7l24.5-33.7c2.9-4,2-9.7-2-12.7
                            c-4-2.9-9.7-2-12.7,2l-17.2,23.6l-17-23.5c-2.4-3.4-6.9-4.6-10.7-3.1c-0.7,0.3-18.5,7.5-33.3,18.4c-4.2,3.1-6.2,5-9.7,8.5
                            C31.32,183.4,38.42,236.6,41.72,248.8z" />
                        <path style="fill:#2C2F33;" d="M114.12,131.9c0.2,0,0.4,0,0.6,0c0.1,0,0.3,0,0.4,0c0.2,0,0.4,0,0.7,0c11.6-0.3,21.4-4.5,28.4-12.4
                            c14.9-16.8,12.8-44.8,12.4-48.3c-1.5-30.9-23-41.8-40.9-41.8c-0.3,0-0.6,0-0.8,0c-0.2,0-0.5,0-0.8,0c-17.9,0-39.3,11-40.9,41.8
                            c-0.3,3.5-2.5,31.5,12.4,48.3C92.72,127.4,102.52,131.7,114.12,131.9z M91.32,72.8c0-0.2,0-0.4,0-0.6c1-21.6,14.7-24.8,22.8-24.8
                            h0.4c0.2,0,0.5,0,0.7,0h0.4c8.1,0,21.8,3.2,22.8,24.8c0,0.2,0,0.4,0,0.5c0.7,6.4,0.5,25.1-8,34.7c-3.7,4.2-8.8,6.3-15.5,6.3
                            c-0.1,0-0.1,0-0.2,0l0,0c-6.7-0.1-11.8-2.1-15.5-6.3C90.82,97.9,90.72,79.2,91.32,72.8z" />
                        <path style="fill:#2C2F33;" d="M324.12,278.4c-4.6,2-6.7,7.4-4.6,11.9c2.3,5.2,3.7,10.6,4.3,16.2l16.9,165.6
                            c1,9.9,9.3,17.4,19.3,17.4h29.2c10,0,18.3-7.5,19.3-17.4l16.9-165.6c0.6-5.5,1.9-10.8,4.1-15.9c1.8-3.3,13.9-25.4,18.3-41.9
                            c3.3-12.2,10.5-65.4-2.3-78.2c-3.5-3.5-5.5-5.4-9.7-8.5c-14.8-10.9-32.5-18.1-33.3-18.4c-3.9-1.6-8.3-0.3-10.7,3.1l-17.2,23.6
                            l-17.3-23.5c-2.9-4.1-8.6-4.9-12.7-2c-4,2.9-4.9,8.6-2,12.7l24.5,33.7c1.7,2.3,4.4,3.7,7.3,3.7s5.6-1.4,7.3-3.7l20.2-27.8
                            c5.9,2.8,15,7.5,22.9,13.3c3,2.2,4.3,3.5,7.4,6.5c3.8,6.6,2.5,43.8-2.1,60.9c-4.2,15.3-16.8,38-16.9,38.2s-0.3,0.5-0.4,0.8
                            c-3,6.9-5,14.2-5.7,21.7l-16.9,165.6c-0.1,0.6-0.6,1.1-1.2,1.1h-29.2c-0.6,0-1.2-0.5-1.2-1.1l-16.9-165.6
                            c-0.8-7.5-2.7-14.8-5.7-21.7C334.02,278.4,328.72,276.4,324.12,278.4z" />
                        <path style="fill:#2C2F33;" d="M373.62,131.9c0.2,0,0.4,0,0.7,0c0.1,0,0.3,0,0.4,0c0.2,0,0.4,0,0.6,0c11.6-0.2,21.4-4.5,28.5-12.4
                            c14.9-16.8,12.8-44.8,12.4-48.3c-1.5-30.9-22.9-41.8-40.9-41.8c-0.3,0-0.6,0-0.8,0c-0.2,0-0.5,0-0.8,0c-17.9,0-39.3,11-40.9,41.8
                            c-0.3,3.5-2.5,31.5,12.4,48.3C352.22,127.4,362.02,131.6,373.62,131.9z M350.82,72.8c0-0.2,0-0.4,0-0.6
                            c1-21.6,14.7-24.8,22.8-24.8h0.4c0.2,0,0.5,0,0.7,0h0.4c8.1,0,21.8,3.2,22.8,24.8c0,0.2,0,0.4,0,0.5c0.7,6.4,0.5,25.1-8,34.7
                            c-3.7,4.2-8.8,6.2-15.5,6.3l0,0c-0.1,0-0.1,0-0.2,0c-6.7-0.1-11.8-2.1-15.5-6.3C350.32,97.9,350.22,79.2,350.82,72.8z" />
                        <path style="fill:#2C2F33;" d="M169.62,150.5c-13.5,13.5-5.9,69.8-2.3,82.8c4.8,17.5,17.6,41.1,19.5,44.5
                            c2.4,5.5,3.9,11.2,4.5,17.1l18,176.5c1,10.3,9.6,18,20,18h31.1c10.3,0,18.9-7.8,20-18l18-176.5c0.6-5.9,2.1-11.7,4.5-17.1
                            c1.9-3.5,14.7-27,19.5-44.5c3.5-13,11.2-69.3-2.3-82.8c-3.7-3.7-5.8-5.7-10.2-9c-15.7-11.6-34.6-19.2-35.4-19.6
                            c-3.9-1.6-8.3-0.3-10.7,3.1l-19.1,25.9l-18.8-25.9c-2.4-3.4-6.9-4.6-10.7-3.1c-0.8,0.3-19.6,8-35.4,19.6
                            C175.42,144.8,173.22,146.8,169.62,150.5z M182.62,163.1c3.3-3.3,4.7-4.6,8-7c8.6-6.4,18.6-11.5,25-14.5l21.8,30
                            c1.7,2.3,4.4,3.7,7.3,3.7c2.9,0,5.6-1.4,7.3-3.7l21.8-30c6.3,3,16.3,8.1,25,14.5c3.3,2.4,4.7,3.7,8,7c4.2,6.8,2.9,46.9-2.2,65.4
                            c-4.5,16.4-17.9,40.6-18.1,40.8c-0.1,0.2-0.3,0.5-0.4,0.8c-3.2,7.3-5.3,15-6.1,23l-18,176.5c-0.1,1-0.9,1.7-1.9,1.7h-31.1
                            c-1,0-1.8-0.7-1.9-1.7l-18-176.5c-0.8-7.9-2.8-15.7-6.1-23c-0.1-0.3-0.2-0.5-0.4-0.8c-0.1-0.2-13.6-24.5-18.1-40.9
                            C179.72,210,178.42,169.9,182.62,163.1z" />
                        <path style="fill:#2C2F33;" d="M243.82,108.2c0.2,0,0.5,0,0.7,0c0.1,0,0.4,0,0.5,0c0.2,0,0.4,0,0.6,0c12.4-0.2,22.4-4.6,29.9-13.1
                            c15.8-17.7,13.4-47.5,13.1-51.1c-1.6-32.5-24.1-44-43-44c-0.3,0-0.6,0-0.9,0c-0.2,0-0.5,0-0.9,0c-18.8,0-41.4,11.5-43,44
                            c-0.3,3.6-2.7,33.3,13.1,51C221.42,103.5,231.52,107.9,243.82,108.2z M218.92,45.7c0-0.2,0-0.4,0-0.6c1.1-24.4,17.8-27,24.9-27
                            h0.5c0.2,0,0.5,0,0.7,0h0.5c7.1,0,23.8,2.6,24.9,27c0,0.2,0,0.4,0,0.5c0.7,6.9,0.6,27.1-8.6,37.4c-4.1,4.6-9.7,6.9-17,6.9
                            c-0.1,0-0.2,0-0.3,0c-7.3-0.1-12.9-2.3-17-6.9C218.32,72.8,218.22,52.6,218.92,45.7z" />
                    </g>
                </g>
            </svg>
            <div class="text-gray-1 ml-1"> {{$row->max_guests}} {{ __("Guests") }}</div>
        </li>
        @if($row->bathroom)
        <li class="d-flex mr-2">
            <i class="flaticon-bathtub text-primary"></i>
            <div class="text-gray-1 ml-1"> {{$row->bathroom}} {{ __("Bathroom") }}</div>
        </li>
        @endif
        @if(!empty($row->bed))
        <li class="d-flex">
            <i class="flaticon-bed-1 text-primary"></i>
            <div class="text-gray-1 ml-1">{{$row->bed}} {{ __("Beds") }}</div>
        </li>
        @endif
    </ul>
    <div>

        <span class="font-size-14">{{ __("From") }}</span>
        <span class="font-size-24 text-gray-6 font-weight-bold ml-1">
            <small class="font-size-16 text-decoration-line-through text-danger">
                {{ $row->display_sale_price }}
            </small>
            {{ $row->display_price }}
        </span>
        <span class="font-size-12">/Night</span>
    </div>
</div>
@if($translation->content)
<div class="border-bottom position-relative">
    <h5 class="font-size-21 font-weight-bold text-dark">
        {{ __("Description") }}
    </h5>
    <div class="description">
        <?php echo $translation->content ?>
    </div>
</div>
@endif
@include('Space::frontend.layouts.details.space-attributes')
@include('Space::frontend.layouts.details.space-faqs')

@include('Space::frontend.layouts.details.space-video')
