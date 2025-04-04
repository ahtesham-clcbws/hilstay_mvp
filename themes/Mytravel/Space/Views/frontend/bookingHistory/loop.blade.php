<tr>
    <td class="booking-history-type">
        @if($service = $booking->service)
            <i class="{{$service->getServiceIconFeatured()}}"></i>
        @endif
        <small>{{$booking->object_model}}</small>
    </td>
    <td>
        @if($service = $booking->service)
            @php
                $translation = $service->translate();
            @endphp
            <a target="_blank" href="{{$service->getDetailUrl()}}">
                {!! clean($translation->title) !!}
            </a>
        @else
            {{__("[Deleted]")}}
        @endif
    </td>
    <td class="a-hidden">{{display_date($booking->created_at)}}</td>
    <td class="a-hidden">
        {{__("Start date")}} : {{display_date($booking->start_date)}} <br>
        {{__("End date")}} : {{display_date($booking->end_date)}} <br>
        {{__("Duration")}} :
        @if($booking->getMeta("booking_type") == "by_day")
            @if($booking->duration_days <= 1)
                {{__(':count day',['count'=>$booking->duration_days])}}
            @else
                {{__(':count days',['count'=>$booking->duration_days])}}
            @endif
        @endif
        @if($booking->getMeta("booking_type") == "by_night")
            @if($booking->duration_nights <= 1)
                {{__(':count night',['count'=>$booking->duration_nights])}}
            @else
                {{__(':count nights',['count'=>$booking->duration_nights])}}
            @endif
        @endif
    </td>
    <td>{{format_money($booking->total)}}</td>
    <td>{{format_money($booking->paid)}}</td>
    <td>{{format_money($booking->total - $booking->paid)}}</td>
    <td class="{{$booking->status}} a-hidden">{{$booking->statusName}}</td>
    <td width="2%">
        @if($service = $booking->service)
            <a class="btn btn-xs btn-primary btn-info-booking" data-bs-toggle="modal" data-bs-target="#modal-booking-{{$booking->id}}">
                <i class="fa fa-info-circle"></i>{{__("Details")}}
            </a>
            @include ($service->checkout_booking_detail_modal_file ?? '')
        @endif
        <a href="{{route('user.booking.invoice',['code'=>$booking->code])}}" class="btn btn-xs btn-primary btn-info-booking open-new-window mt-1" onclick="window.open(this.href); return false;">
            <i class="fa fa-print"></i>{{__("Invoice")}}
        </a>
    </td>
</tr>
