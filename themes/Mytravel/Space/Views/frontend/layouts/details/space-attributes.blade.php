@php
    $terms_ids = $row->terms->pluck('term_id');
    $attributes = \Modules\Core\Models\Terms::getTermsById($terms_ids);
@endphp
@if (!empty($terms_ids) and !empty($attributes))
    @foreach ($attributes as $attribute)
        @php $translate_attribute = $attribute['parent']->translate() @endphp
        @if (empty($attribute['parent']['hide_in_single']))
            <div
                class="list-attributes border-bottom {{ $attribute['parent']->slug }} attr-{{ $attribute['parent']->id }} py-4">
                <h3 class="font-size-21 font-weight-bold text-dark mb-4">{{ $translate_attribute->name }}</h3>
                @php $terms = $attribute['child'] @endphp
                <div class="d-block d-md-none">
                    <div class="show collapse" id="attr_more_{{ intval($attribute['parent']->id) + 2000 }}"
                        data-parent="#attr_{{ intval($attribute['parent']->id) + 2000 }}"
                        aria-labelledby="cityCategoryHeadingOne">

                        <ul class="list-group list-group-borderless list-group-horizontal list-group-flush no-gutters row">
                            @foreach ($terms as $key => $term)
                                @if ($key <= 3)
                                    @php $translate_term = $term->translate() @endphp
                                    <li
                                        class="col-md-4 list-group-item item {{ $term->slug }} term-{{ $term->id }} mb-3">
                                        @if (!empty($term->image_id))
                                            @php $image_url = get_file_url($term->image_id, 'full'); @endphp
                                            <img class="img-responsive" src="{{ $image_url }}"
                                                alt="{{ $translate_term->name }}">
                                        @else
                                            <i
                                                class="font-size-16 text-primary {{ $term->icon ?? 'flaticon-tick icon-default' }} mr-2"></i>
                                        @endif
                                        {{ $translate_term->name }}
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                        <div class="collapse" id="more_term_{{ intval($attribute['parent']->id) + 2000 }}">
                            <ul class="list-group list-group-borderless list-group-horizontal list-group-flush no-gutters row">
                                @foreach ($terms as $key => $term)
                                    @if ($key > 3)
                                        @php $translate_term = $term->translate() @endphp
                                        <li
                                            class="col-md-4 list-group-item item {{ $term->slug }} term-{{ $term->id }} mb-3">
                                            @if (!empty($term->image_id))
                                                @php $image_url = get_file_url($term->image_id, 'full'); @endphp
                                                <img class="img-responsive" src="{{ $image_url }}"
                                                    alt="{{ $translate_term->name }}">
                                            @else
                                                <i
                                                    class="font-size-16 text-primary {{ $term->icon ?? 'flaticon-tick icon-default' }} mr-2"></i>
                                            @endif
                                            {{ $translate_term->name }}
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <a class="link link-collapse small font-size-1 mt-2" data-bs-toggle="collapse"
                            href="#more_term_{{ intval($attribute['parent']->id) + 2000 }}" role="button"
                            aria-expanded="false"
                            aria-controls="more_term_{{ intval($attribute['parent']->id) + 2000 }}">
                            <span class="link-collapse__default font-size-14">{{ __('Show all') }}</span>
                            <span class="link-collapse__active font-size-14">{{ __('Show less') }}</span>
                        </a>

                    </div>
                </div>
                <div class="d-none d-md-block">
                    <ul class="list-group list-group-borderless list-group-horizontal list-group-flush no-gutters row">
                        @foreach ($terms as $term)
                            @php $translate_term = $term->translate() @endphp
                            <li
                                class="col-md-4 list-group-item item {{ $term->slug }} term-{{ $term->id }} mb-3">
                                @if (!empty($term->image_id))
                                    @php $image_url = get_file_url($term->image_id, 'full'); @endphp
                                    <img class="img-responsive" src="{{ $image_url }}"
                                        alt="{{ $translate_term->name }}">
                                @else
                                    <i
                                        class="font-size-16 text-primary {{ $term->icon ?? 'flaticon-tick icon-default' }} mr-2"></i>
                                @endif
                                {{ $translate_term->name }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    @endforeach
@endif
