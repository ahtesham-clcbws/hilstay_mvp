@if($row->banner_image_id)
<style>
    #lightgallery a img {
        border-radius: 12px;
        overflow: hidden;
    }
    #imageNumbers {
        border: #ffffff solid 0.5px;
        border-radius: 10px;
        padding: 5px 13px;
        background-color: #ffffff;
        position: absolute;
        bottom: 25px;
        right: 25px;
        font-weight: 700;
    }
    #imageNumbers:hover {
        color: #ffffff;
        background-color: #103815;
        border-color: #103815;
    }
</style>
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
    <div class="mb-3 w-100 overflow-hidden position-relative">
        @if($row->getGallery())
        <div id="lightgallery" class="lightboxGallery row align-items-center justify-content-center overflow-hidden">
            <div class="col-md-6">
                <a href="<?= $row->getGallery()[0]['large']; ?>" target="_blank">
                    <img alt=".." src="<?= $row->getGallery()[0]['thumb']; ?>" class="w-100" />
                </a>
            </div>
            <div class="col-6 row justify-content-center gap-4 d-none d-md-flex">
                @foreach($row->getGallery() as $key => $item)
                <?php if ($key > 0 && $key < 5) : ?>
                    <div class="col-6 py-md-3">
                        <a href="<?= $item['large']; ?>" target="_blank">
                            <img alt=".." src="<?= $item['thumb']; ?>" class="w-100" />
                        </a>
                    </div>
                <?php endif; ?>
                @endforeach
            </div>
            @if(count($row->getGallery()) > 5)
            <a id="imageNumbers" href="<?= $row->getGallery()[5]['large']; ?>" target="_blank">{{ count($row->getGallery()) - 5 }} More images</a>
            @endif
        </div>
        @endif

    </div>

</div>
@endif
