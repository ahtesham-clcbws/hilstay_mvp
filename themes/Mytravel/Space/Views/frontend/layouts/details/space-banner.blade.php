@if ($row->banner_image_id)
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
        @if (!empty($breadcrumbs))
            <div class="container">
                <nav class="py-3" aria-label="breadcrumb">
                    <ol
                        class="breadcrumb breadcrumb-no-gutter flex-xl-wrap overflow-xl-visble mb-0 flex-nowrap overflow-auto">
                        <li class="breadcrumb-item flex-xl-shrink-1 flex-shrink-0"><a
                                href="{{ url('') }}">{{ __('Home') }}</a></li>
                        @foreach ($breadcrumbs as $breadcrumb)
                            <li class="breadcrumb-item flex-xl-shrink-1 {{ $breadcrumb['class'] ?? '' }} flex-shrink-0">
                                @if (!empty($breadcrumb['url']))
                                    <a href="{{ url($breadcrumb['url']) }}">{{ $breadcrumb['name'] }}</a>
                                @else
                                    {{ $breadcrumb['name'] }}
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </nav>
            </div>
        @endif
        @if ($row->getGallery())
            <div class="w-100 position-relative mb-3 overflow-hidden">
                <div class="d-none d-md-block">
                    <div class="lightboxGallery row align-items-center justify-content-center overflow-hidden" id="lightgallery">
                        <div class="col-md-6">
                            <a href="<?= $row->getGallery()[0]['large'] ?>" target="_blank">
                                <img class="w-100" src="<?= $row->getGallery()[0]['thumb'] ?>" alt=".." />
                            </a>
                        </div>
                        <div class="col-6 row justify-content-center d-none d-md-flex gap-4">
                            @foreach ($row->getGallery() as $key => $item)
                                <?php if ($key > 0 && $key < 5) : ?>
                                <div class="col-6 py-md-3">
                                    <a href="<?= $item['large'] ?>" target="_blank">
                                        <img class="w-100" src="<?= $item['thumb'] ?>" alt=".." />
                                    </a>
                                </div>
                                <?php endif; ?>
                            @endforeach
                        </div>
                        @if (count($row->getGallery()) > 5)
                            <a id="imageNumbers" href="<?= $row->getGallery()[5]['large'] ?>"
                                target="_blank">{{ count($row->getGallery()) - 5 }} More images</a>
                        @endif
                    </div>
                </div>
                {{-- mobile slider --}}
                <div class="d-block d-md-none splide">
                    <div
                        class="splide__track row align-items-center justify-content-center overflow-hidden">
                        <div class="splide__list lightboxGallery">
                            @foreach ($row->getGallery() as $key => $item)
                            <a href="<?= $item['large'] ?>" target="_blank" class="splide__slide" style="aspect-ratio: 4/3 !important; overflow: hidden;">
                                <img class="w-100" src="<?= $item['thumb'] ?>" alt=".." style="object-fit: cover !important;" />
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
    @if ($row->getGallery())
    @endif
@endif

@push('js')
@endpush
