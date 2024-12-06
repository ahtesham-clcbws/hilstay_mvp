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
    <div class="mb-8 w-100">
        @if($row->getGallery())
        <div id="lightgallery" class="lightboxGallery row align-items-center overflow-hidden">
            <div class="col-6 d-flex d-md-flex">
                <a href="<?= $row->getGallery()[0]['large']; ?>" rel="lightbox">
                    <img alt=".." src="<?= $row->getGallery()[0]['thumb']; ?>" class="w-100" />
                </a>
            </div>
            <div class="col-6 row gap-4 d-flex d-md-flex">
                @foreach($row->getGallery() as $key => $item)
                @if ($key > 0 && $key < 5)
                <div class="col-6 py-lg-3">
                    <a href="<?= $item['large']; ?>" rel="lightbox">
                        <img alt=".." src="<?= $item['thumb']; ?>" class="w-100" />
                    </a>
                </div>
                @endif
                @endforeach
            </div>
        </div>
        @endif
        <div class="travel-slick-carousel u-slick u-slick__img-overlay d-none"
            data-arrows-classes="d-none d-md-inline-block u-slick__arrow-classic u-slick__arrow-centered--y rounded-circle"
            data-arrow-left-classes="flaticon-back u-slick__arrow-classic-inner u-slick__arrow-classic-inner--left ml-md-4 ml-xl-8"
            data-arrow-right-classes="flaticon-next u-slick__arrow-classic-inner u-slick__arrow-classic-inner--right mr-md-4 mr-xl-8"
            data-infinite="true"
            data-slides-show="1"
            data-slides-scroll="1"
            data-center-mode="true"
            data-pagi-classes="d-md-none text-center u-slick__pagination mt-5 mb-0"
            data-center-padding="450px"
            data-responsive='[{
                        "breakpoint": 1480,
                        "settings": {
                            "centerPadding": "300px"
                        }
                    }, {
                        "breakpoint": 1199,
                        "settings": {
                            "centerPadding": "200px"
                        }
                    }, {
                        "breakpoint": 992,
                        "settings": {
                            "centerPadding": "120px"
                        }
                    }, {
                        "breakpoint": 554,
                        "settings": {
                            "centerPadding": "20px"
                        }
                    }]'>

            @if($row->getGallery())
            @foreach($row->getGallery() as $key=>$item)
            <div class="js-slide bg-img-hero min-height-550" style="background-image: url('<?= $item['large']; ?>');"></div>
            @endforeach
            @endif
        </div>
    </div>
</div>
@endif
