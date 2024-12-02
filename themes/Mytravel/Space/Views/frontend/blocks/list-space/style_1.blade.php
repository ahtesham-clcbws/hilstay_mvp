<div class="bravo-list-space product-card-block product-card-v2 border-bottom border-color-8">
    <div class="container space-1">
        @if(!empty($title))
            <div class="w-md-80 w-lg-50 text-center mx-md-auto mb-5 mt-4">
                <h2 class="section-title text-black font-size-30 font-weight-bold mb-0">{{$title}}</h2>
                <small class="font-size-xs-14 font-size-14 mb-0 text-lh-sm d-block mt-1">
                    {{ $desc }}
                </small>
            </div>
        @endif
        <div class="row">
            @foreach($rows as $row)
                <div class="col-md-6 col-lg-{{$col ?? 3}} col-xl-{{$col ?? 3}} mb-3 mb-md-4 pb-1">
                    @include('Space::frontend.layouts.search.loop-grid')
                </div>
            @endforeach
        </div>

        <div class="w-md-80 w-lg-50 text-center mx-md-auto mb-5 mt-4">
            <a class="p-2 font-size-17 text-center text-white font-weight-bold"style="background-color: #103815 !important;" href="{{ route('space.search') }}"">
                Explore more <i class="flaticon-right-arrow ml-2"></i>
            </a>
        </div>
    </div>
</div>
