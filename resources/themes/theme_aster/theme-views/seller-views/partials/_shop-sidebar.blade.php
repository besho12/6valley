<div>
    <h6 class="mb-3">{{translate('price')}}</h6>
    <div class="d-flex align-items-end gap-2">
        <div class="form-group">
            <label for="min_price" class="mb-1">{{translate('min')}}</label>
            <input type="number" id="min_price" class="form-control form-control--sm"
                   placeholder="$0">
        </div>
        <div class="mb-2">-</div>
        <div class="form-group">
            <label for="max_price" class="mb-1">{{translate('max')}}</label>
            <input type="number" id="max_price" class="form-control form-control--sm"
                   placeholder="{{'$'.translate('1000')}}">
        </div>
        <button class="btn btn-primary py-1 px-2 fs-13 action-search-products-by-price">
            <i class="bi bi-chevron-right"></i>
        </button>
    </div>

    <section class="range-slider">
        <span class="full-range"></span>
        <span class="incl-range"></span>
        <input name="rangeOne" value="0" min="0" max="10000000000" step="1" type="range"
               id="price_rangeMin">
        <input name="rangeTwo" value="100000000000" min="0" max="100000000000" step="1" type="range"
               id="price_rangeMax">
    </section>
</div>

@if($web_config['digital_product_setting'])
    <div>
        <div class="border rounded p-2">
            <div class="d-flex gap-2">
                <div class="flex-middle gap-2">
                    <i class="bi bi-sort-up-alt"></i>
                    <span class="d-none d-sm-inline-block">{{ translate('Product_Type') }} </span>
                </div>
                <div class="dropdown product_type_sorting">
                    <button type="button" class="border-0 bg-transparent dropdown-toggle text-dark p-0 custom-pe-3 filter-on-product-type-button" data-bs-toggle="dropdown" aria-expanded="false">
                        @if (request('product_type') == 'digital')
                            {{ translate('digital') }}
                        @elseif (request('product_type') == 'physical')
                            {{ translate('physical') }}
                        @else
                            {{ translate('All') }}
                        @endif
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" id="sort-by-list" style="">
                        <li class="selected filter-on-product-type-change cursor-pointer" data-value="all">
                            {{ translate('All') }}
                        </li>
                        <li class="filter-on-product-type-change cursor-pointer" data-value="physical">
                            {{ translate('physical') }}
                        </li>
                        <li class="filter-on-product-type-change cursor-pointer" data-value="digital">
                            {{ translate('digital') }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif

<div>
    <h6 class="mb-3">{{translate('Categories')}}</h6>
    <div class="products_aside_categories">
        <ul class="common-nav flex-column nav flex-nowrap custom_common_nav">
            @foreach($categories as $category)
                <li>
                    <div class="d-flex justify-content-between">
                        <a href="{{route('shopView', ['id'=> $seller_id, 'category_id' => $category['id'], 'data_from' => 'category', 'offer_type' => request('offer_type') ?? '', 'page' => 1])}}">
                            {{ $category['name']}}
                        </a>
                        @if ($category->childes->count() > 0)
                            <span>
                                <i class="bi bi-chevron-right"></i>
                            </span>
                        @endif
                    </div>
                    @if ($category->childes->count() > 0)
                        <ul class="sub_menu">
                            @foreach($category->childes as $child)
                                <li>
                                    <div class="d-flex justify-content-between">
                                        <a href="{{route('shopView',['id'=> $seller_id, 'sub_category_id' => $child['id'], 'data_from' => 'category', 'offer_type' => request('offer_type') ?? '', 'page' => 1])}}">
                                            {{ $child['name'] }}
                                        </a>
                                        @if ($child->childes->count() > 0)
                                            <span>
                                                <i class="bi bi-chevron-right"></i>
                                            </span>
                                        @endif
                                    </div>

                                    @if ($child->childes->count() > 0)
                                        <ul class="sub_menu">
                                            @foreach($child->childes as $ch)
                                                <li>
                                                    <label class="custom-checkbox">
                                                        <a href="{{ route('shopView', ['id' => $seller_id, 'sub_sub_category_id' => $ch['id'], 'data_from' => 'category', 'offer_type' => request('offer_type') ?? '', 'page' => 1])}}">
                                                            {{ $ch['name'] }}
                                                        </a>
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
    @if (count($categories) > 10)
        <div class="d-flex justify-content-center">
            <button
                class="btn-link text-primary btn_products_aside_categories text-capitalize">
                {{translate('more_categories').' ...'}}
            </button>
        </div>
    @endif
</div>

@if($web_config['brand_setting'])
    <div class="product-type-physical-section">
        <h6 class="mb-3">{{translate('Brands')}}</h6>
        <div class="products_aside_brands">
            <ul class="common-nav nav flex-column pe-2">
                @foreach($brands as $brand)
                    <li>
                        <div class="flex-between-gap-3 align-items-center">
                            <label class="custom-checkbox">
                                <a href="{{route('shopView',['id'=> $seller_id, 'brand_id' => $brand->id, 'data_from' => 'brand', 'offer_type' => request('offer_type') ?? '', 'page' => 1])}}">{{ $brand['name'] }}</a>
                            </label>
                            <span class="badge bg-badge rounded-pill text-dark">
                                {{ $brand['brand_products_count'] }}
                            </span>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        @if (count($brands) > 10)
            <div class="d-flex justify-content-center">
                <button class="btn-link text-primary btn_products_aside_brands">
                    {{translate('more_brands').'...'}}
                </button>
            </div>
        @endif
    </div>
@endif

@if($web_config['digital_product_setting'] && count($shopPublishingHouses) > 0)
    <div class="product-type-digital-section">
        <h6 class="mb-3">{{translate('Publishing_House')}}</h6>
        <div class="products_aside_brands">
            <ul class="common-nav nav flex-column pe-2">
                @foreach($shopPublishingHouses as $publishingHouseItem)
                    <li>
                        <div class="flex-between-gap-3 align-items-center">
                            <label class="custom-checkbox">
                                <a href="{{ route('shopView', ['id'=> $seller_id, 'publishing_house_id' => $publishingHouseItem['id'], 'product_type' => 'digital', 'offer_type' => request('offer_type') ?? '', 'page' => 1]) }}">
                                    {{ $publishingHouseItem['name'] }}
                                </a>
                            </label>
                            <span class="badge bg-badge rounded-pill text-dark">
                                {{ $publishingHouseItem['publishing_house_products_count'] }}
                            </span>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        @if(count($shopPublishingHouses) > 10)
            <div class="d-flex justify-content-center">
                <button
                    class="btn-link text-primary btn_products_aside_brands text-capitalize">{{translate('more_publishing_house').'...'}}
                </button>
            </div>
        @endif
    </div>
@endif

@if($web_config['digital_product_setting'] && count($digitalProductAuthors) > 0)
    <div class="product-type-digital-section">
        <h6 class="mb-3">
            {{ translate('authors') }}/{{ translate('Creator') }}/{{ translate('Artist') }}
        </h6>
        <div class="products_aside_brands">
            <ul class="common-nav nav flex-column pe-2">
                @foreach($digitalProductAuthors as $productAuthor)
                    <li>
                        <div class="flex-between-gap-3 align-items-center">
                            <label class="custom-checkbox">
                                <a href="{{ route('shopView', ['id'=> $seller_id, 'author_id' => $productAuthor['id'], 'product_type' => 'digital','offer_type' => request('offer_type') ?? '', 'page' => 1]) }}">
                                    {{ $productAuthor['name'] }}
                                </a>
                            </label>
                            <span class="badge bg-badge rounded-pill text-dark">
                                {{ $productAuthor['digital_product_author_count'] }}
                            </span>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        @if(count($digitalProductAuthors) > 10)
            <div class="d-flex justify-content-center">
                <button
                    class="btn-link text-primary btn_products_aside_brands text-capitalize">{{translate('more_authors').'...'}}
                </button>
            </div>
        @endif
    </div>
@endif

<div id="ajax-review_partials">
    @include('theme-views.partials._products_review_partials', ['ratings' => $ratings])
</div>
