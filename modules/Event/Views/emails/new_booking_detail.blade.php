<?php
$translation = $service->translate();
$lang_local = app()->getLocale();
?>
<div class="b-panel-title">{{__('Event information')}}</div>
<div class="b-table-wrap">
    <table class="b-table" cellspacing="0" cellpadding="0">
        <tr>
            <td class="label">{{__('Booking Number')}}</td>
            <td class="val">#{{$booking->id}}</td>
        </tr>
        <tr>
            <td class="label">{{__('Booking Status')}}</td>
            <td class="val">{{$booking->statusName}}</td>
        </tr>
        @if($booking->gatewayObj)
            <tr>
                <td class="label">{{__('Payment method')}}</td>
                <td class="val">{{$booking->gatewayObj->getOption('name')}}</td>
            </tr>
        @endif
        @if($booking->gatewayObj and $note = $booking->gatewayObj->getOption('payment_note'))
            <tr>
                <td class="label">{{__('Payment Note')}}</td>
                <td class="val">{!! clean($note) !!}</td>
            </tr>
        @endif
        <tr>
            <td class="label">{{__('Event name')}}</td>
            <td class="val">
                <a href="{{$service->getDetailUrl()}}">{!! clean($translation->title) !!}</a>
            </td>

        </tr>
        <tr>
            @if($translation->address)
                <td class="label">{{__('Address')}}</td>
                <td class="val">
                    {{$translation->address}}
                </td>
            @endif
        </tr>
        @if($booking->start_date && $booking->end_date)
            <tr>
                <td class="label">{{__('Start date')}}</td>
                <td class="val">{{display_date($booking->start_date)}}</td>
            </tr>
            @if($booking->getMeta("booking_type") == "ticket")
                <tr>
                    <td class="label">{{__('Duration:')}}</td>
                    <td class="val">
                        @php $duration = $booking->getMeta("duration") @endphp
                        @if( $duration <= 1)
                            {{__(':count hour',['count'=>$duration])}}
                        @else
                            {{__(':count hours',['count'=>$duration])}}
                        @endif
                    </td>
                </tr>
            @endif

            @if($booking->getMeta("booking_type") == "time_slot")
                <tr>
                    <td class="label">{{__('Duration:')}}</td>
                    <td class="val">
                        {{ $booking->getMeta("duration")  }}
                        {{ $booking->getMeta("duration_unit")  }}
                    </td>
                </tr>
                <tr>
                    <td class="label" colspan="2">{{__('Start Time:')}}</td>
                </tr>
                <tr class="flex-wrap">
                    <td colspan="2">
                        <div class="slots-wrapper d-flex justify-content-start flex-wrap">
                            @if(!empty($timeSlots = $booking->time_slots))
                                @foreach( $timeSlots as $item )
                                    <div class="btn btn-sm mr-2 mb-2 btn-success">
                                        {{ date( "H:i",strtotime($item->start_time)) }}
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </td>
                </tr>
            @endif
        @endif

        @php $ticket_types = $booking->getJsonMeta('ticket_types')
        @endphp

        @if(!empty($ticket_types))
            @foreach($ticket_types as $type)
                <tr>
                    <td class="label">{{$type['name']}}:</td>
                    <td class="val">
                        <strong>{{$type['number']}}</strong>
                    </td>
                </tr>
            @endforeach
        @endif
        <tr>
            <td class="label">{{__('Pricing')}}</td>
            <td class="val no-r-padding">
                <table class="pricing-list" width="100%">
                    @if($booking->getMeta("booking_type") == "time_slot")
                        <tr>
                            <td class="label">{{ $booking->total_guests }} x {{ format_money( $booking->getJsonMeta('base_price')) }}</td>
                            <td class="val no-r-padding">
                                {{format_money( $booking->getJsonMeta('base_price') * $booking->total_guests )  }}
                            </td>
                        </tr>
                    @endif
                    @if($booking->getMeta("booking_type") == "ticket")
                        @php $ticket_types = $booking->getJsonMeta('ticket_types')
                        @endphp
                        @if(!empty($ticket_types))
                            @foreach($ticket_types as $type)
                                <tr>
                                    <td class="label">{{$type['name']}}: {{$type['number']}} * {{format_money($type['price'])}}</td>
                                    <td class="val no-r-padding">
                                        <strong>{{format_money($type['price'] * $type['number'])}}</strong>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endif
                    @php $extra_price = $booking->getJsonMeta('extra_price')@endphp
                    @if(!empty($extra_price))
                        <tr>
                            <td colspan="2" class="label-title"><strong>{{__("Extra Prices:")}}</strong></td>
                        </tr>
                        <tr class="">
                            <td colspan="2" class="no-r-padding no-b-border">
                                <table width="100%">
                                    @foreach($extra_price as $type)
                                        <tr>
                                            <td class="label">{{$type['name']}}:</td>
                                            <td class="val no-r-padding">
                                                <strong>{{format_money($type['total'] ?? 0)}}</strong>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </td>
                        </tr>
                    @endif
                    @php
                        $list_all_fee = [];
                        if(!empty($booking->buyer_fees)){
                            $buyer_fees = json_decode($booking->buyer_fees , true);
                            $list_all_fee = $buyer_fees;
                        }
                        if(!empty($vendor_service_fee = $booking->vendor_service_fee)){
                            $list_all_fee = array_merge($list_all_fee , $vendor_service_fee);
                        }
                    @endphp
                    @if(!empty($list_all_fee))
                        @foreach ($list_all_fee as $item)
                            @php
                                $fee_price = $item['price'];
                                if(!empty($item['unit']) and $item['unit'] == "percent"){
                                    $fee_price = ( $booking->total_before_fees / 100 ) * $item['price'];
                                }
                            @endphp
                            <tr>
                                <td class="label">
                                    {{$item['name_'.$lang_local] ?? $item['name']}}
                                    <i class="icofont-info-circle" data-bs-toggle="tooltip" data-placement="top" title="{{ $item['desc_'.$lang_local] ?? $item['desc'] }}"></i>
                                    @if(!empty($item['per_person']) and $item['per_person'] == "on")
                                        : {{$booking->total_guests}} * {{format_money( $fee_price )}}
                                    @endif
                                </td>
                                <td class="val">
                                    @if(!empty($item['per_person']) and $item['per_person'] == "on")
                                        {{ format_money( $fee_price * $booking->total_guests ) }}
                                    @else
                                        {{ format_money( $fee_price ) }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    @if(!empty($booking->coupon_amount) and $booking->coupon_amount > 0)
                        <tr>
                            <td class="label">
                                {{__("Coupon")}}
                            </td>
                            <td class="val">
                                -{{ format_money($booking->coupon_amount) }}
                            </td>
                        </tr>
                    @endif
                </table>
            </td>
        </tr>
        <tr>
            <td class="label fsz21">{{__('Total')}}</td>
            <td class="val fsz21"><strong style="color: #FA5636">{{format_money($booking->total)}}</strong></td>
        </tr>
        <tr>
            <td class="label fsz21">{{__('Paid')}}</td>
            <td class="val fsz21"><strong style="color: #FA5636">{{format_money($booking->paid)}}</strong></td>
        </tr>
        @if($booking->total > $booking->paid)
            <tr>
                <td class="label fsz21">{{__('Remain')}}</td>
                <td class="val fsz21"><strong style="color: #FA5636">{{format_money($booking->total - $booking->paid)}}</strong></td>
            </tr>
        @endif
    </table>
</div>
<div class="text-center mt20">
    <a href="{{ route("user.booking_history") }}" target="_blank" class="btn btn-primary manage-booking-btn">{{__('Manage Bookings')}}</a>
</div>
