<div class="d-block d-md-flex flex-center-between align-items-start mb-3">
    <div class="mb-1">
        <div class="mb-2 mb-md-0">
            <h1 class="font-size-23 font-weight-bold mb-1 mr-3">{!! clean($translation->title) !!}</h1>
        </div>
        <div class="d-block d-xl-flex flex-horizontal-center">
            <div class="d-block d-md-flex flex-horizontal-center font-size-14 text-gray-1 mb-2 mb-xl-0">
                @if($translation->address)
                    <i class="icon flaticon-placeholder mr-2 font-size-20"></i> {{$translation->address}}
                @endif
                @if($row->map_lat && $row->map_lng)
                    <a target="_blank" href="https://www.google.com/maps/place/{{$row->map_lat}},{{$row->map_lng}}/@<?php echo $row->map_lat ?>,{{$row->map_lng}},{{!empty($row->map_zoom) ? $row->map_zoom : 12}}z" class="ml-1 d-block d-md-inline">
                        - {{__('View on map')}}
                    </a>
                @endif
            </div>
            @if(setting_item('event_enable_review') and $review_score)
                <?php
                $reviewData = $row->getScoreReview();
                $score_total = $reviewData['score_total'];
                ?>
                <div class="ml-2 service-review review-{{$score_total}}">
                    <div class="d-inline-flex align-items-center font-size-17 text-lh-1 text-primary">
                        <div class="list-star green-lighter mr-2">
                            <ul class="booking-item-rating-stars">
                                <li><i class="fa fa-star-o"></i></li>
                                <li><i class="fa fa-star-o"></i></li>
                                <li><i class="fa fa-star-o"></i></li>
                                <li><i class="fa fa-star-o"></i></li>
                                <li><i class="fa fa-star-o"></i></li>
                            </ul>
                            <div class="booking-item-rating-stars-active" style="width: {{  $score_total * 2 * 10 ?? 0  }}%">
                                <ul class="booking-item-rating-stars">
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                </ul>
                            </div>
                        </div>
                        <span class="text-secondary font-size-14 mt-1">
                        @if($reviewData['total_review'] > 1)
                                {{ __(":number Reviews",["number"=>$reviewData['total_review'] ]) }}
                            @else
                                {{ __(":number Review",["number"=>$reviewData['total_review'] ]) }}
                            @endif
                    </span>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <ul class="list-group list-group-horizontal custom-social-share">
        <li class="list-group-item px-1 border-0">
            <span class="height-45 width-45 border rounded border-width-2 flex-content-center service-wishlist {{$row->isWishList()}}" data-id="{{$row->id}}" data-type="{{$row->type}}">
                <i class="flaticon-like font-size-18 text-dark"></i>
            </span>
        </li>
        <li class="list-group-item px-1 border-0 dropdown">
            <a id="shareDropdownInvoker{{$row->id}}"
               class="dropdown-nav-link dropdown-toggle d-flex height-45 width-45 border rounded border-width-2 flex-content-center" data-bs-toggle="dropdown"
               href="javascript:;" role="button" aria-controls="shareDropdown{{$row->id}}" aria-haspopup="true" aria-expanded="false" data-unfold-event="hover"
               data-unfold-target="#shareDropdown{{$row->id}}" data-unfold-type="css-animation" data-unfold-duration="300" data-unfold-delay="300" data-unfold-hide-on-scroll="true" data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">
                <i class="flaticon-share font-size-18 text-dark"></i>
            </a>
            <div id="shareDropdown{{$row->id}}" class="dropdown-menu dropdown-unfold dropdown-menu-right mt-0 px-3 min-width-3" aria-labelledby="shareDropdownInvoker{{$row->id}}">
                <a class="btn btn-icon btn-pill btn-bg-transparent transition-3d-hover  btn-xs btn-soft-dark  facebook mb-3" href="https://www.facebook.com/sharer/sharer.php?u={{$row->getDetailUrl()}}&amp;title={{$translation->title}}" target="_blank" rel="noopener" original-title="{{__("Facebook")}}">
                    <span class="font-size-15 fa fa-facebook-f btn-icon__inner"></span>
                </a>
                <br/>
                <a class="btn btn-icon btn-pill btn-bg-transparent transition-3d-hover  btn-xs btn-soft-dark  twitter" href="https://twitter.com/share?url={{$row->getDetailUrl()}}&amp;title={{$translation->title}}" target="_blank" rel="noopener" original-title="{{__("Twitter")}}">
                    <span class="font-size-15 fa fa-twitter btn-icon__inner"></span>
                </a>
            </div>
        </li>
    </ul>
</div>
@if($row->getGallery())
{{-- d-md-block --}}
    <div class="position-relative d-none ">
        <div id="sliderSyncingNav" class="travel-slick-carousel u-slick mb-2"
             data-infinite="true"
             data-arrows-classes="d-none d-lg-inline-block u-slick__arrow-classic u-slick__arrow-centered--y rounded-circle"
             data-arrow-left-classes="flaticon-back u-slick__arrow-classic-inner u-slick__arrow-classic-inner--left ml-lg-2 ml-xl-4"
             data-arrow-right-classes="flaticon-next u-slick__arrow-classic-inner u-slick__arrow-classic-inner--right mr-lg-2 mr-xl-4"
             data-nav-for="#sliderSyncingThumb">
            @foreach($row->getGallery() as $key=>$item)
                <div class="js-slide">
                    <img class="img-fluid border-radius-3" src="{{$item['large']}}" alt="{{ __("Gallery") }}">
                </div>
            @endforeach
        </div>
        <div id="sliderSyncingThumb" class="travel-slick-carousel u-slick u-slick--gutters-4 u-slick--transform-off"
             data-infinite="true"
             data-slides-show="6"
             data-is-thumbs="true"
             data-nav-for="#sliderSyncingNav"
             data-responsive='[{
                                        "breakpoint": 992,
                                        "settings": {
                                            "slidesToShow": 4
                                        }
                                    }, {
                                        "breakpoint": 768,
                                        "settings": {
                                            "slidesToShow": 3
                                        }
                                    }, {
                                        "breakpoint": 554,
                                        "settings": {
                                            "slidesToShow": 2
                                        }
                                    }]'>
            @foreach($row->getGallery() as $key=>$item)
                <div class="js-slide" style="cursor: pointer;">
                    <img class="img-fluid border-radius-3 height-110" src="{{$item['thumb']}}" alt="{{ __("Gallery") }}">
                </div>
            @endforeach
        </div>
    </div>
    {{-- mobile slider --}}
    <div class="d-block  splide">
        <div
            class="splide__track row align-items-center justify-content-center overflow-hidden">
            <div class="splide__list">
                @foreach($row->getGallery() as $key=>$item)
                    <div class="js-slide splide__slide" style="aspect-ratio: 16/9 !important; overflow: hidden;">
                        <img class="img-fluid border-radius-3" style="object-fit: cover !important;" src="{{$item['large']}}" alt="{{ __("Gallery") }}">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
<div class="py-4 border rounded  mb-4 mt-4">
    <ul class="list-group list-group-borderless list-group-horizontal flex-center-between text-center mx-md-4">
        <li class="list-group-item p-2 text-lh-sm ">
            <i class="icofont-heart-beat text-primary font-size-50 mb-1 "></i>
            <div class="text-gray-1 text-wrap text-break">
                {{ $row->getNumberWishlistInService() }}
                {{ __("Wishlist") }}</div>
        </li>
        @if($row->start_time)
            <li class="list-group-item p-2 text-lh-sm ">
                <i class="icofont-wall-clock text-primary font-size-50 mb-1 "></i>
                <div class="text-gray-1 text-wrap text-break"> {{ __("Start Time") }}: {{ $row->start_time }}</div>
            </li>
        @endif
        @if($row->duration)
            <li class="list-group-item p-2 text-lh-sm ">
                <i class="icofont-infinite text-primary font-size-50 mb-1 "></i>
                <div class="text-gray-1 text-wrap text-break"> {{ __("Duration") }}: {{duration_format($row->duration, true)}} </div>
            </li>
        @endif
        @if(!empty($row->location->name))
            @php $location =  $row->location->translate() @endphp
            <li class="list-group-item p-2 text-lh-sm ">
                <img class="cofont-island-alt text-primary font-size-50 mb-1" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAMAAAAp4XiDAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAM1BMVEVHcEwQOBUQOBUQOBUQOBUQOBUQOBUQOBUQOBUQOBUQOBUQOBUQOBUQOBUQOBUQOBUQOBU26PG9AAAAEHRSTlMABQ4cKzxKXneKqcLV4Oz3/hz0rQAAAeVJREFUeNrFlNtuhDAMRO1cnKvj+f+vLaTdlopkd/vU84CEyNF4IIT+D/ZRUpLomRY4uuFT+UY8vcblDsDGgQHWkqMXxAZYyxIOpDQDWqCnJIVVcd+RUg1dnhoD+msSdkkxEm0RRY/0G5YOjbTB99O4ERXN0xIuGLIc15DXRlAUXj6p0EAryu4BxYG8bjJDNjHN0Z1oJre1UrI/22AsBuAE9T93MQUizgZUTxQG0qrKDGfvmciVgS4uG6Yzh6Y7FZXJFdXiuBgArYae6nQK6lo5DABWiqGXAaBH8tNxtfJSOY3eMde6BqgQ8ZcjvOxSDC1EPQ3ONo2DT4cWZACHwcV+G8RbJwHoN+ORY7LeFW1pbD8l+f4w6GpMCrqjO5yvGZEuuIa63uObjN1+mTHXHuEyfN79Fq5eMkS7sD/g3VyT/JMhCmiqXZsnkjnXEh8uhhk0N6gnruiedlyMXAw9t0OJA4V2+P5jEOfTqf4MCbSDy7fB8bNX4hmyJ8SHIaoyc2Q2eco0ziumg2GW6ClRMc4M4OGguhfKQHOi1g5Mxc8z/AUZVjs0MJ/Lq1mmV7iKA/XzlWOO9ZLQZ40wDwE0T28wl44DzFPpLWTgCxV6D05fzkhE7zt/NIino4n+RNIu9EdCoH/lA18qH1gYHX5WAAAAAElFTkSuQmCC" />
                {{-- <i class="icofont-island-alt text-primary font-size-50 mb-1 "></i> --}}
                <div class="text-gray-1 text-wrap text-break">{{$location->name ?? ''}} </div>
            </li>
        @endif
    </ul>
</div>
@if($translation->content)
    <div class="border-bottom position-relative mt-4">
        <h5 class="font-size-21 font-weight-bold text-dark">
            {{ __("Description") }}
        </h5>
        <div class="description">
            <?php echo $translation->content ?>
        </div>
    </div>
@endif
@include('Event::frontend.layouts.details.attributes')
@include('Event::frontend.layouts.details.faqs')
@if($row->map_lat && $row->map_lng)
    <div class="mt-4">
        <h3 class="font-size-21 font-weight-bold text-dark mb-4">{{__("Location")}}</h3>
        <div class="location-map">
            <div id="map_content"></div>
        </div>
    </div>
@endif
