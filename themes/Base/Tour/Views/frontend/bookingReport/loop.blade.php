<tr>
    <td class="booking-history-type">
        @if($service = $booking->service)
            <i class="{{$service->getServiceIconFeatured()}}"></i>
        @endif
        <small>{{$booking->object_model}}</small>
    </td>
    <td>
        @if($service = $booking->service)
            <a target="_blank" href="{{$service->getDetailUrl()}}">
                {{$service->title}}
            </a>
            <small>
                <div>{{ __("Customer Info") }}</div>
                <div>
                    {{ __("First Name") }}: {{ $booking->first_name }}
                </div>
                <div>
                    {{ __("Last Name") }}: {{ $booking->last_name }}
                </div>
            </small>
        @else
            {{__("[Deleted]")}}
        @endif
    </td>
    <td class="a-hidden">{{display_date($booking->created_at)}}</td>
    <td class="a-hidden">
        {{__("Check in")}} : {{display_date($booking->start_date)}} <br>
        {{__("Duration")}} : {{ $booking->getMeta("duration") ?? "1"  }} {{__("hours")}}
    </td>
    <td>
        <div>{{__("Total")}}: {{format_money_main($booking->total)}}</div>
        <div>{{__("Paid")}}: {{format_money_main($booking->paid)}}</div>
        <div>{{__("Remain")}}: {{format_money($booking->total - $booking->paid)}}</div>
    </td>
    <td>
        {{ format_money($booking->commission) }}
    </td>
    <td class="{{$booking->status}} a-hidden">{{$booking->statusName}}</td>
    <td width="2%">
        @if($service = $booking->service)
            <a class="btn btn-xs btn-primary btn-info-booking" data-ajax="{{route('booking.modal',['booking'=>$booking])}}" data-bs-toggle="modal" data-id="{{$booking->id}}" data-bs-target="#modal_booking_detail">
                <i class="fa fa-info-circle"></i>{{__("Details")}}
            </a>
        @endif
        <a href="{{route('user.booking.invoice',['code'=>$booking->code])}}" class="btn btn-xs btn-primary btn-info-booking open-new-window mt-1" onclick="window.open(this.href); return false;">
            <i class="fa fa-print"></i>{{__("Invoice")}}
        </a>
        @if(!empty(setting_item("tour_allow_vendor_can_change_their_booking_status")))
            <a class="btn btn-xs btn-info btn-make-as" data-bs-toggle="dropdown">
                <i class="icofont-ui-settings"></i>
                {{__("Action")}}
            </a>
            <div class="dropdown-menu">
                @if(!empty($statues))
                    @foreach($statues as $status)
                        <a href="{{ route("tour.vendor.booking_report.bulk_edit" , ['id'=>$booking->id , 'status'=>$status]) }}">
                            <i class="icofont-long-arrow-right"></i> {{__('Mark as: :name',['name'=>booking_status_to_text($status)])}}
                        </a>
                    @endforeach
                @endif
            </div>
        @endif
        @if(!empty(setting_item("tour_allow_vendor_can_change_paid_amount")))
            <a class="btn btn-xs btn-info btn-info-booking mt-1" datadata-bs-target="odal" data-bs-target="#modal-paid-{{$booking->id}}">
                <i class="fa fa-dollar"></i>{{__("Set Paid")}}
            </a>
            @include ($service->set_paid_modal_file ?? '')
        @endif
    </td>
</tr>
