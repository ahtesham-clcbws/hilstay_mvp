<div class="item text-right d-block">
    @php
        $param = request()->input();
        $orderby =  request()->input("orderby");
    @endphp
    <div class="item-title d-block mb-3">
        {{ __("Sort by") }}
    </div>
    <div class="dropdown">
        <span class=" dropdown-toggle"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @switch($orderby)
                @case("price_low_high")
                {{ __("Price (Low to high)") }}
                @break
                @case("price_high_low")
                {{ __("Price (High to low)") }}
                @break
                @case("rate_high_low")
                {{ __("Rating (High to low)") }}
                @break
                @default
                {{ __("Recommended") }}
            @endswitch
        </span>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
            @php $param['orderby'] = "" @endphp
            <a class="dropdown-item" href="{{ route("space.search",$param) }}">{{ __("Recommended") }}</a>
            @php $param['orderby'] = "price_low_high" @endphp
            <a class="dropdown-item" href="{{ route("space.search",$param) }}">{{ __("Price (Low to high)") }}</a>
            @php $param['orderby'] = "price_high_low" @endphp
            <a class="dropdown-item" href="{{ route("space.search",$param) }}">{{ __("Price (High to low)") }}</a>
            @php $param['orderby'] = "rate_high_low" @endphp
            <a class="dropdown-item" href="{{ route("space.search",$param) }}">{{ __("Rating (High to low)") }}</a>
        </div>
    </div>
</div>
