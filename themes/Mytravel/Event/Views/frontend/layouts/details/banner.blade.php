@if($row->banner_image_id)
    <div class="bravo_banner">
        @if(!empty($breadcrumbs))
            <div class="container">
                <nav class="py-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-no-gutter mb-0 flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble">
                        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{url('')}}">{{__('Home')}}</a></li>
                        @foreach($breadcrumbs as $breadcrumb)
                            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 {{$breadcrumb['class'] ?? ''}}">
                                @if(!empty($breadcrumb['url']))
                                    <a href="{{url($breadcrumb['url'])}}">{{$breadcrumb['name']}}</a>
                                @else
                                    {{$breadcrumb['name']}}
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </nav>
            </div>
        @endif
        <div class="mb-4 mb-lg-8 d-none d-md-block">
            <img class="img-fluid" src="{{ $row->getBannerImageUrlAttribute('full')}}" alt="{!! clean($translation->title) !!}">
            <div class="container">
                <div class="position-relative">
                    <div class="position-absolute video-gallery">
                        <div class="flex-horizontal-center">
                            @if($row->video)
                                <a class="travel-fancybox btn btn-white transition-3d-hover py-2 px-md-4 px-3 shadow-6 mr-1" href="javascript:;" data-src="{{ handleVideoUrl($row->video) }}" data-speed="700">
                                    <i class="flaticon-movie mr-md-2 font-size-18 text-primary"></i><span class="d-none d-md-inline">{{ __("Video") }}</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

