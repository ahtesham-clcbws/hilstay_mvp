@php
    $translation = $row->translate();
@endphp
<div class="card transition-3d-hover shadow-hover-2 item-loop {{$wrap_class ?? ''}} overflow-hidden">
    <div class="position-relative">
        <a @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl($include_param ?? true)}}" class="d-block gradient-overlay-half-bg-gradient-v5"
            style="aspect-ratio: 4/3 !important; overflow: hidden;">
            <img class="card-img-top" src="{{$row->image_url}}" alt="{!! clean($translation->title) !!}" style="object-fit: cover !important;">
        </a>
        <div class="position-absolute top-0 right-0 pt-4 pr-3 btn-wishlist">
            <button type="button" class="p-0 btn btn-sm btn-icon text-white rounded-circle service-wishlist {{$row->isWishList()}}" data-id="{{$row->id}}" data-type="{{$row->type}}" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{{ __("Save for later") }}">
            <span class="font-size-20">{!! $row->isWishList() == 'active' ? '<i class="fa fa-heart"></i>' : '<i class="fa fa-heart-o"></i>' !!}</span>
            </button>
        </div>
        <div class="position-absolute bottom-0 left-0 right-0 text-content">
            <div class="px-3 pb-2">
                <a @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl($include_param ?? true)}}" >
                    <span class="text-white font-weight-bold font-size-17">{!! clean($translation->title) !!}</span>
                </a>
                <div class="text-white my-2">
                    <small class="mr-1 font-size-14">{{ __("From") }}</small>
                    <small class="mr-1 font-size-13 text-decoration-line-through">
                        {{ $row->display_sale_price }}
                    </small>
                    <span class="font-weight-bold font-size-19">{{ $row->display_price }}</span>
                    <span class="mr-1 font-size-14">
                         @if($row->getBookingType()=="by_day")
                            {{__("/day")}}
                        @else
                            {{__("/night")}}
                        @endif
                    </span>
                </div>
            </div>
        </div>
        <div class="location d-none position-absolute bottom-0 left-0 right-0">
            <div class="px-4 pb-3">
                @if(!empty($row->location->name))
                    @php $location =  $row->location->translate(); @endphp
                    <a href="{{$row->location->getDetailUrl() ?? ''}}" class="d-block">
                        <div class="d-flex align-items-center font-size-14 text-white">
                            <i class="icon flaticon-pin-1 mr-2 font-size-20"></i> {{$location->name ?? ''}}
                        </div>
                    </a>
                @endif
            </div>
        </div>
    </div>
    <div class="position-absolute top-0 left-0 pt-4 pl-3 featured">
        @if($row->is_featured == "1")
            <span class="badge badge-pill bg-white text-primary px-4 mr-3 py-2 font-size-14 font-weight-normal">{{ __("Featured") }}</span>
        @endif
        @if($row->discount_percent)
            <span class="badge badge-pill bg-white text-danger px-3  py-2 font-size-14 font-weight-normal">{{$row->discount_percent}}</span>
        @endif
    </div>

    <div class="card-body px-3 py-3 border-bottom">
        <a @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl($include_param ?? true)}}" class="d-block location">
            <div class="d-flex align-items-center font-size-14 text-gray-1">
                @if(!empty($row->location->name))
                    @php $location =  $row->location->translate() @endphp
                    <i class="icon flaticon-placeholder mr-2 font-size-20"></i> {{$location->name ?? ''}}
                @endif
            </div>
        </a>
        <a @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl($include_param ?? true)}}" class="d-none title">
            <span class="font-weight-bold font-size-17">{!! clean($translation->title) !!}</span>
        </a>
        <div class="mt-1 service-review">
            @if(setting_item('space_enable_review'))
                @php
                    $reviewData = $row->getScoreReview();
                    $score_total = $reviewData['score_total'];
                @endphp
                <span class="py-1 font-size-14 border-radius-3 font-weight-normal pagination-v2-arrow-color rate">
                    {{ $score_total }}/5 <span class="rate-text">{{ $reviewData['review_text'] }}</span>
                </span>
                <span class="font-size-14 text-gray-1 ml-2 review">
                    @if($reviewData['total_review'] > 1)
                        {{ __(":number reviews",["number"=>$reviewData['total_review'] ]) }}
                    @else
                        {{ __(":number review",["number"=>$reviewData['total_review'] ]) }}
                    @endif
                </span>
            @endif
        </div>
        <div class="g-price d-none">
            <div class="prefix">
                <span class="fr_text">{{__("from")}}</span>
            </div>
            <div class="price">
                <span class="onsale">{{ $row->display_sale_price }}</span>
                <span class="text-price">{{ $row->display_price }}</span>
            </div>
        </div>
    </div>
    <div class="px-3 pt-3 pb-2 type-attribute">
        <div class="row">
            <div class="col-6">
                <ul class="list-unstyled mb-0">
                    <li class="media mb-2 text-gray-1 align-items-center">
                        <small class="mr-2" style="margin-top: -6px">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="16" height="19"><path d="M29.5 6h-2.793L24.85 4.143a1.5 1.5 0 1 0-2.7 0L20.293 6H17.5a.5.5 0 0 0-.5.5v8a.5.5 0 0 0 .5.5h12a.5.5 0 0 0 .5-.5v-8a.5.5 0 0 0-.5-.5zm-6-3a.5.5 0 1 1-.5.5.5.5 0 0 1 .5-.5zm-.643 1.85a1.453 1.453 0 0 0 1.286 0L25.293 6h-3.586zM29 7v3.293l-1.146-1.147a.5.5 0 0 0-.708 0L24.5 11.793l-2.646-2.647a.5.5 0 0 0-.708 0L18 12.293V7zm-11 6.707 3.5-3.5L25.293 14H18zm8.707.293-1.5-1.5 2.293-2.293 1.5 1.5V14z"/><circle cx="24.5" cy="8.5" r=".5"/><path d="M29.5 29H28v-7.5a4.505 4.505 0 0 0-4.5-4.5H10v-2.5A2.5 2.5 0 0 0 7.5 12H7V9.5a.5.5 0 0 0-.5-.5h-2a.5.5 0 0 0-.5.5V29H2.5a.5.5 0 0 0 0 1h27a.5.5 0 0 0 0-1zM27 21.5V25H7v-7h16.5a3.5 3.5 0 0 1 3.5 3.5zM7 26h18v3H7zm.5-13A1.5 1.5 0 0 1 9 14.5V17H7v-4zM5 29V10h1v19zm21 0v-3h1v3z"/></svg>
                        </small>
                        <div class="media-body font-size-1">
                            {{$row->bedroom}} <small>{{ __("Bedroom") }}</small>
                        </div>
                    </li>
                    <li class="media mb-2 text-gray-1 align-items-center">
                        <small class="mr-2">
                            <small class="flaticon-bathtub font-size-16"></small>
                        </small>
                        <div class="media-body font-size-1">
                            {{$row->bathroom}} <small>{{ __("Bathroom") }}</small>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-6">
                <ul class="list-unstyled mb-0">
                    <li class="media mb-2 text-gray-1 align-items-center">
                        <small class="mr-2" style="margin-top: -6px">

                            <svg width="16" height="19" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    viewBox="0 0 489.6 489.6" xml:space="preserve">
                                <g>
                                    <g>
                                        <path id="XMLID_2038_" style="fill:#94A4A4;" d="M244.72,99.2c0.1,0,0.2,0,0.2,0l0,0c40.4-0.4,34.5-54.4,34.5-54.4
                                            c-1.6-36.1-31.7-35.8-34.7-35.7c-3-0.1-33.1-0.4-34.8,35.6c0,0-5.9,54,34.6,54.4l0,0C244.52,99.2,244.62,99.2,244.72,99.2z"/>
                                        <path id="XMLID_2039_" style="fill:#94A4A4;" d="M244.72,166.3l26.1-36c0,0,18.4,7.4,33.4,18.5c3.9,2.9,5.7,4.6,9.2,8.1
                                            c8.3,8.3,4.8,56.4,0,74s-18.9,42.9-18.9,42.9c-2.8,6.4-4.6,13.3-5.3,20.2l-18,176.5c-0.6,5.6-5.3,9.9-10.9,9.9h-15.6h-15.6
                                            c-5.6,0-10.4-4.3-10.9-9.9l-18-176.5c-0.7-7-2.5-13.8-5.3-20.2c0,0-14.1-25.2-18.9-42.9c-4.8-17.6-8.3-65.7,0-74
                                            c3.5-3.5,5.3-5.2,9.2-8.1c15-11,33.4-18.5,33.4-18.5L244.72,166.3z"/>
                                        <path style="fill:#2C2F33;" d="M41.72,248.8c4.5,16.4,16.5,38.5,18.3,41.9c2.2,5.1,3.6,10.4,4.1,15.9l16.9,165.6
                                            c1,9.9,9.3,17.4,19.3,17.4h29.2c10,0,18.3-7.5,19.3-17.4l16.9-165.6c0.6-5.6,2-11.1,4.3-16.2c2-4.6-0.1-9.9-4.6-11.9
                                            c-4.6-2-9.9,0.1-11.9,4.6c-3,6.9-5,14.2-5.7,21.7l-16.9,165.6c-0.1,0.6-0.6,1.1-1.2,1.1h-29.2c-0.6,0-1.2-0.5-1.2-1.1l-17.1-165.7
                                            c-0.8-7.5-2.7-14.8-5.7-21.7c-0.1-0.3-0.2-0.5-0.4-0.8c-0.1-0.2-12.7-22.9-16.9-38.2c-4.6-17.1-5.9-54.3-2.1-60.9
                                            c3-3,4.3-4.2,7.4-6.5c7.9-5.8,17-10.5,22.9-13.3l20.2,27.8c1.7,2.3,4.4,3.7,7.3,3.7s5.6-1.4,7.3-3.7l24.5-33.7c2.9-4,2-9.7-2-12.7
                                            c-4-2.9-9.7-2-12.7,2l-17.2,23.6l-17-23.5c-2.4-3.4-6.9-4.6-10.7-3.1c-0.7,0.3-18.5,7.5-33.3,18.4c-4.2,3.1-6.2,5-9.7,8.5
                                            C31.32,183.4,38.42,236.6,41.72,248.8z"/>
                                        <path style="fill:#2C2F33;" d="M114.12,131.9c0.2,0,0.4,0,0.6,0c0.1,0,0.3,0,0.4,0c0.2,0,0.4,0,0.7,0c11.6-0.3,21.4-4.5,28.4-12.4
                                            c14.9-16.8,12.8-44.8,12.4-48.3c-1.5-30.9-23-41.8-40.9-41.8c-0.3,0-0.6,0-0.8,0c-0.2,0-0.5,0-0.8,0c-17.9,0-39.3,11-40.9,41.8
                                            c-0.3,3.5-2.5,31.5,12.4,48.3C92.72,127.4,102.52,131.7,114.12,131.9z M91.32,72.8c0-0.2,0-0.4,0-0.6c1-21.6,14.7-24.8,22.8-24.8
                                            h0.4c0.2,0,0.5,0,0.7,0h0.4c8.1,0,21.8,3.2,22.8,24.8c0,0.2,0,0.4,0,0.5c0.7,6.4,0.5,25.1-8,34.7c-3.7,4.2-8.8,6.3-15.5,6.3
                                            c-0.1,0-0.1,0-0.2,0l0,0c-6.7-0.1-11.8-2.1-15.5-6.3C90.82,97.9,90.72,79.2,91.32,72.8z"/>
                                        <path style="fill:#2C2F33;" d="M324.12,278.4c-4.6,2-6.7,7.4-4.6,11.9c2.3,5.2,3.7,10.6,4.3,16.2l16.9,165.6
                                            c1,9.9,9.3,17.4,19.3,17.4h29.2c10,0,18.3-7.5,19.3-17.4l16.9-165.6c0.6-5.5,1.9-10.8,4.1-15.9c1.8-3.3,13.9-25.4,18.3-41.9
                                            c3.3-12.2,10.5-65.4-2.3-78.2c-3.5-3.5-5.5-5.4-9.7-8.5c-14.8-10.9-32.5-18.1-33.3-18.4c-3.9-1.6-8.3-0.3-10.7,3.1l-17.2,23.6
                                            l-17.3-23.5c-2.9-4.1-8.6-4.9-12.7-2c-4,2.9-4.9,8.6-2,12.7l24.5,33.7c1.7,2.3,4.4,3.7,7.3,3.7s5.6-1.4,7.3-3.7l20.2-27.8
                                            c5.9,2.8,15,7.5,22.9,13.3c3,2.2,4.3,3.5,7.4,6.5c3.8,6.6,2.5,43.8-2.1,60.9c-4.2,15.3-16.8,38-16.9,38.2s-0.3,0.5-0.4,0.8
                                            c-3,6.9-5,14.2-5.7,21.7l-16.9,165.6c-0.1,0.6-0.6,1.1-1.2,1.1h-29.2c-0.6,0-1.2-0.5-1.2-1.1l-16.9-165.6
                                            c-0.8-7.5-2.7-14.8-5.7-21.7C334.02,278.4,328.72,276.4,324.12,278.4z"/>
                                        <path style="fill:#2C2F33;" d="M373.62,131.9c0.2,0,0.4,0,0.7,0c0.1,0,0.3,0,0.4,0c0.2,0,0.4,0,0.6,0c11.6-0.2,21.4-4.5,28.5-12.4
                                            c14.9-16.8,12.8-44.8,12.4-48.3c-1.5-30.9-22.9-41.8-40.9-41.8c-0.3,0-0.6,0-0.8,0c-0.2,0-0.5,0-0.8,0c-17.9,0-39.3,11-40.9,41.8
                                            c-0.3,3.5-2.5,31.5,12.4,48.3C352.22,127.4,362.02,131.6,373.62,131.9z M350.82,72.8c0-0.2,0-0.4,0-0.6
                                            c1-21.6,14.7-24.8,22.8-24.8h0.4c0.2,0,0.5,0,0.7,0h0.4c8.1,0,21.8,3.2,22.8,24.8c0,0.2,0,0.4,0,0.5c0.7,6.4,0.5,25.1-8,34.7
                                            c-3.7,4.2-8.8,6.2-15.5,6.3l0,0c-0.1,0-0.1,0-0.2,0c-6.7-0.1-11.8-2.1-15.5-6.3C350.32,97.9,350.22,79.2,350.82,72.8z"/>
                                        <path style="fill:#2C2F33;" d="M169.62,150.5c-13.5,13.5-5.9,69.8-2.3,82.8c4.8,17.5,17.6,41.1,19.5,44.5
                                            c2.4,5.5,3.9,11.2,4.5,17.1l18,176.5c1,10.3,9.6,18,20,18h31.1c10.3,0,18.9-7.8,20-18l18-176.5c0.6-5.9,2.1-11.7,4.5-17.1
                                            c1.9-3.5,14.7-27,19.5-44.5c3.5-13,11.2-69.3-2.3-82.8c-3.7-3.7-5.8-5.7-10.2-9c-15.7-11.6-34.6-19.2-35.4-19.6
                                            c-3.9-1.6-8.3-0.3-10.7,3.1l-19.1,25.9l-18.8-25.9c-2.4-3.4-6.9-4.6-10.7-3.1c-0.8,0.3-19.6,8-35.4,19.6
                                            C175.42,144.8,173.22,146.8,169.62,150.5z M182.62,163.1c3.3-3.3,4.7-4.6,8-7c8.6-6.4,18.6-11.5,25-14.5l21.8,30
                                            c1.7,2.3,4.4,3.7,7.3,3.7c2.9,0,5.6-1.4,7.3-3.7l21.8-30c6.3,3,16.3,8.1,25,14.5c3.3,2.4,4.7,3.7,8,7c4.2,6.8,2.9,46.9-2.2,65.4
                                            c-4.5,16.4-17.9,40.6-18.1,40.8c-0.1,0.2-0.3,0.5-0.4,0.8c-3.2,7.3-5.3,15-6.1,23l-18,176.5c-0.1,1-0.9,1.7-1.9,1.7h-31.1
                                            c-1,0-1.8-0.7-1.9-1.7l-18-176.5c-0.8-7.9-2.8-15.7-6.1-23c-0.1-0.3-0.2-0.5-0.4-0.8c-0.1-0.2-13.6-24.5-18.1-40.9
                                            C179.72,210,178.42,169.9,182.62,163.1z"/>
                                        <path style="fill:#2C2F33;" d="M243.82,108.2c0.2,0,0.5,0,0.7,0c0.1,0,0.4,0,0.5,0c0.2,0,0.4,0,0.6,0c12.4-0.2,22.4-4.6,29.9-13.1
                                            c15.8-17.7,13.4-47.5,13.1-51.1c-1.6-32.5-24.1-44-43-44c-0.3,0-0.6,0-0.9,0c-0.2,0-0.5,0-0.9,0c-18.8,0-41.4,11.5-43,44
                                            c-0.3,3.6-2.7,33.3,13.1,51C221.42,103.5,231.52,107.9,243.82,108.2z M218.92,45.7c0-0.2,0-0.4,0-0.6c1.1-24.4,17.8-27,24.9-27
                                            h0.5c0.2,0,0.5,0,0.7,0h0.5c7.1,0,23.8,2.6,24.9,27c0,0.2,0,0.4,0,0.5c0.7,6.9,0.6,27.1-8.6,37.4c-4.1,4.6-9.7,6.9-17,6.9
                                            c-0.1,0-0.2,0-0.3,0c-7.3-0.1-12.9-2.3-17-6.9C218.32,72.8,218.22,52.6,218.92,45.7z"/>
                                    </g>
                                </g>
                            </svg>
                            <!-- <small class="flaticon-door font-size-16"></small> -->
                        </small>
                        <div class="media-body font-size-1">
                            {{$row->max_guests}} <small>{{ __("People") }}</small>
                        </div>
                    </li>
                    <li class="media mb-2 text-gray-1 align-items-center">
                        <small class="mr-2">
                            <small class="flaticon-bed-1 font-size-16"></small>
                        </small>
                        <div class="media-body font-size-1">
                            {{$row->bed}} <small>{{ __("Beds") }}</small>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <a @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl($include_param ?? true)}}" class="p-2 font-size-17 text-center text-white font-weight-bold" style="background-color: #103815 !important;">
        Book Now
    </a>
</div>
