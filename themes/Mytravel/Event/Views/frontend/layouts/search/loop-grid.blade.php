@php
    $translation = $row->translate();
@endphp
<div class="item-loop relative item-loop-wrap {{$wrap_class ?? ''}}">
    <div class="thumb-image ">
        <a @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl($include_param ?? true)}}">
            @if($row->image_url)
                @if(!empty($disable_lazyload))
                    <img src="{{$row->image_url}}" class="img-responsive" alt="">
                @else
                    {!! get_image_tag($row->image_id,'medium',['class'=>'img-responsive','alt'=>$row->title]) !!}
                @endif
            @endif
        </a>
        <div class="service-wishlist {{$row->isWishList()}}" data-id="{{$row->id}}" data-type="{{$row->type}}">
            {!! $row->isWishList() == 'active' ? '<i class="fa fa-heart"></i>' : '<i class="fa fa-heart-o"></i>' !!}
        </div>
        @if($row->discount_percent)
            <div class="sale_info">{{$row->discount_percent}}</div>
        @endif
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
    @if($row->is_featured == "1")
        <div class="position-absolute top-0 left-0 text-center featured">
            <span class="badge font-weight-normal badge-pill px-4 py-2">{{ __("Featured") }}</span>
        </div>
    @endif
    <div class="location">
        @if(!empty($row->location->name))
            @php $location =  $row->location->translate() @endphp
            {{$location->name ?? ''}}
        @endif
    </div>
    <div class="item-title">
        <a @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl($include_param ?? true)}}">
            @if($row->is_instant)
                <i class="fa fa-bolt d-none"></i>
            @endif
            {!! clean($translation->title) !!}
        </a>
    </div>
    @if(setting_item('space_enable_review'))
        <?php
        $reviewData = $row->getScoreReview();
        $score_total = $reviewData['score_total'];
        ?>
        <div class="service-review">
        <span class="rate">
            @if($reviewData['total_review'] > 0) {{$score_total}}/5 @endif <span class="rate-text">{{$reviewData['review_text']}}</span>
        </span>
            <span class="review">
         @if($reviewData['total_review'] > 1)
                    {{ __(":number Reviews",["number"=>$reviewData['total_review'] ]) }}
                @else
                    {{ __(":number Review",["number"=>$reviewData['total_review'] ]) }}
                @endif
        </span>
        </div>
    @endif
    @if(!empty($time = $row->start_time))
        <div class="start-time">
            {{ __("Start Time: :time",['time'=>$time]) }}
        </div>
    @endif
    <div class="info">
        <div class="duration">
            {{duration_format($row->duration)}}
        </div>
        <div class="g-price">
            <div class="prefix">
                <span class="fr_text">{{__("from")}}</span>
            </div>
            <div class="price">
                <span class="onsale">{{ $row->display_sale_price }}</span>
                <span class="text-price">{{ $row->display_price }}</span>
            </div>
        </div>
    </div>
</div>
