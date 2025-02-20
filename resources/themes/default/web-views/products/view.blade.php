@extends('layouts.front-end.app')

@section('title',translate($data['offer_type']).' '.translate('products'))

@push('css_or_js')
    <meta property="og:image" content="{{$web_config['web_logo']['path']}}"/>
    <meta property="og:title" content="Products of {{$web_config['company_name']}} "/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description"
          content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)), 0, 160) }}">

    <meta property="twitter:card" content="{{$web_config['web_logo']['path']}}"/>
    <meta property="twitter:title" content="Products of {{$web_config['company_name']}}"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description"
          content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">
@endpush

@section('content')

    @php($decimal_point_settings = getWebConfig(name: 'decimal_point_settings'))

    <div class="container py-3" dir="{{Session::get('direction')}}">
        <div class="search-page-header">
            <div>
                <h5 class="font-semibold mb-1 text-capitalize">
                    <span class="current-product-type"
                    data-all="{{ translate('all') }}"
                    data-digital="{{ translate('digital') }}"
                    data-physical="{{ translate('physical') }}">
                        {{ translate(str_replace('_',' ',$data['offer_type'])) }} {{ request('product_type') == 'digital' ? translate(request('product_type')) : ''}}
                    </span>
                    {{ translate('products') }} {{ isset($data['brand_name']) ? '('.$data['brand_name'].')' : ''}}
                </h5>
                <div><span class="view-page-item-count clearance-sale-count">{{$products->total()}}</span> {{translate('items_found')}}</div>
            </div>
            <div class="d-flex flex-wrap gap-3">
                <form id="search-form" class="d-none d-lg-block" action="{{ route('products') }}" method="GET">
                    <input hidden name="data_from" value="{{$data['offer_type']}}">
                    <div class="sorting-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                            <path d="M11.6667 7.80078L14.1667 5.30078L16.6667 7.80078" stroke="#D9D9D9" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"/>
                            <path
                                d="M7.91675 4.46875H4.58341C4.3533 4.46875 4.16675 4.6553 4.16675 4.88542V8.21875C4.16675 8.44887 4.3533 8.63542 4.58341 8.63542H7.91675C8.14687 8.63542 8.33341 8.44887 8.33341 8.21875V4.88542C8.33341 4.6553 8.14687 4.46875 7.91675 4.46875Z"
                                stroke="#D9D9D9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path
                                d="M7.91675 11.9688H4.58341C4.3533 11.9688 4.16675 12.1553 4.16675 12.3854V15.7188C4.16675 15.9489 4.3533 16.1354 4.58341 16.1354H7.91675C8.14687 16.1354 8.33341 15.9489 8.33341 15.7188V12.3854C8.33341 12.1553 8.14687 11.9688 7.91675 11.9688Z"
                                stroke="#D9D9D9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M14.1667 5.30078V15.3008" stroke="#D9D9D9" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"/>
                        </svg>
                        <label class="for-sorting" for="sorting">
                            <span>{{translate('sort_by')}}</span>
                        </label>
                        <select class="product-list-filter-on-viewpage">
                            <option
                                value="latest" {{ request('sort_by') == 'latest' ? 'selected':'' }}>{{translate('latest')}}</option>
                            <option
                                value="low-high" {{ request('sort_by') == 'low-high' ? 'selected':'' }}>{{translate('low_to_High_Price')}} </option>
                            <option
                                value="high-low" {{ request('sort_by') == 'high-low' ? 'selected':'' }}>{{translate('High_to_Low_Price')}}</option>
                            <option
                                value="a-z" {{ request('sort_by') == 'a-z' ? 'selected':'' }}>{{translate('A_to_Z_Order')}}</option>
                            <option
                                value="z-a" {{ request('sort_by') == 'z-a' ? 'selected':'' }}>{{translate('Z_to_A_Order')}}</option>
                        </select>
                    </div>
                </form>
                <form class="d-none d-lg-block" action="{{ route('products') }}" method="GET">
                    <div class="sorting-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                            <path d="M11.6667 7.80078L14.1667 5.30078L16.6667 7.80078" stroke="#D9D9D9" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"/>
                            <path
                                d="M7.91675 4.46875H4.58341C4.3533 4.46875 4.16675 4.6553 4.16675 4.88542V8.21875C4.16675 8.44887 4.3533 8.63542 4.58341 8.63542H7.91675C8.14687 8.63542 8.33341 8.44887 8.33341 8.21875V4.88542C8.33341 4.6553 8.14687 4.46875 7.91675 4.46875Z"
                                stroke="#D9D9D9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path
                                d="M7.91675 11.9688H4.58341C4.3533 11.9688 4.16675 12.1553 4.16675 12.3854V15.7188C4.16675 15.9489 4.3533 16.1354 4.58341 16.1354H7.91675C8.14687 16.1354 8.33341 15.9489 8.33341 15.7188V12.3854C8.33341 12.1553 8.14687 11.9688 7.91675 11.9688Z"
                                stroke="#D9D9D9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M14.1667 5.30078V15.3008" stroke="#D9D9D9" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"/>
                        </svg>
                        <label class="for-sorting" for="sorting">
                            <span>{{translate('show_products')}}</span>
                        </label>
                        <select class="product-list-filter-on-viewpage">
                            <option value="latest" {{ request('sort_by') == 'latest' ? 'selected':'' }}>{{translate('latest')}}</option>
                            <option value="oldest" {{ request('sort_by') == 'oldest' ? 'selected':'' }}>{{translate('oldest')}}</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="d-lg-none">
                <div class="filter-show-btn btn btn--primary py-1 px-2 m-0">
                    <i class="tio-filter"></i>
                </div>
            </div>
        </div>

    </div>

    <div class="container pb-5 mb-2 mb-md-4 rtl __inline-35" dir="{{Session::get('direction')}}">
        <div class="row">
            <aside
                class="col-lg-3 hidden-xs col-md-3 col-sm-4 SearchParameters __search-sidebar {{Session::get('direction') === "rtl" ? 'pl-2' : 'pr-2'}}"
                id="SearchParameters">
                <div class="cz-sidebar __inline-35 p-4 overflow-hidden" id="shop-sidebar">
                    <div class="cz-sidebar-header p-0">
                        <button class="close ms-auto fs-18-mobile"
                                type="button" data-dismiss="sidebar" aria-label="Close">
                            <i class="tio-clear"></i>
                        </button>
                    </div>
                    <div class="pb-0 shop-sidebar-scroll">
                        <div class="d-flex gap-3 flex-column">
                            <div class="">
                                <h6 class="font-semibold fs-15 mb-2">{{ translate('filter') }}</h6>
                                <label class="w-100 opacity-75 text-nowrap for-sorting d-block mb-0 ps-0" for="sorting">
                                    <select class="form-control custom-select filter-on-product-filter-change">
                                        <option selected disabled>{{translate('Choose')}}</option>
                                        <option
                                            value="best-selling" {{isset($data['data_from'])!=null?$data['data_from']=='best-selling'?'selected':'':''}}>{{translate('Best_Selling_Product')}}</option>
                                        <option
                                            value="top-rated" {{isset($data['data_from'])!=null?$data['data_from']=='top-rated'?'selected':'':''}}>{{translate('Top_Rated')}}</option>
                                        <option
                                            value="most-favorite" {{isset($data['data_from'])!=null?$data['data_from']=='most-favorite'?'selected':'':''}}>{{translate('Most_Favorite')}}</option>
                                        <option
                                            value="featured_deal" {{isset($data['data_from'])!=null?$data['data_from']=='featured_deal'?'selected':'':''}}>{{translate('Featured_Deal')}}</option>
                                    </select>
                                </label>
                            </div>

                            @if($web_config['digital_product_setting'])
                            <div class="">
                                <h6 class="font-semibold fs-15 mb-2">{{ translate('Product_Type') }}</h6>
                                <label class="w-100 opacity-75 text-nowrap for-sorting d-block mb-0 ps-0" for="sorting">
                                    <select class="form-control custom-select filter-on-product-type-change">
                                        <option value="all" {{ !request('product_type') ? 'selected' : '' }}>{{ translate('All') }}</option>
                                        <option value="physical" {{ request('product_type') == 'physical' ? 'selected' : '' }}>
                                            {{ translate('physical') }}
                                        </option>
                                        <option value="digital" {{ request('product_type') == 'digital' ? 'selected' : '' }}>
                                            {{ translate('digital') }}
                                        </option>
                                    </select>
                                </label>
                            </div>
                            @endif
                            <div class="d-lg-none">
                                <h6 class="font-semibold fs-15 mb-2">{{ translate('Sort_By') }}</h6>
                                <form id="search-form" action="{{ route('products') }}" method="GET">
                                    <input hidden name="offer_type" value="{{$data['offer_type']}}">
                                    <input hidden id="data_from" value="{{ request('data_from') }}">
                                    <input hidden id="category_id" value="{{ request('category_id') }}">
                                    <input hidden id="brand_id" value="{{ request('brand_id') }}">
                                    <select class="form-control product-list-filter-on-viewpage">
                                        <option value="latest">{{translate('latest')}}</option>
                                        <option
                                            value="low-high">{{translate('low_to_High_Price')}} </option>
                                        <option
                                            value="high-low">{{translate('High_to_Low_Price')}}</option>
                                        <option
                                            value="a-z">{{translate('A_to_Z_Order')}}</option>
                                        <option
                                            value="z-a">{{translate('Z_to_A_Order')}}</option>
                                    </select>
                                </form>
                            </div>

                            <div>
                                <h6 class="font-semibold fs-15 mb-2">{{ translate('price') }}</h6>
                                <div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="__w-35p">
                                            <input
                                                class="bg-white cz-filter-search form-control form-control-sm appended-form-control"
                                                type="number" value="0" min="0" max="1000000" id="min_price"
                                                placeholder="{{ translate('min')}}">
                                        </div>
                                        <div class="__w-10p">
                                            <p class="m-0">{{translate('to')}}</p>
                                        </div>
                                        <div class="__w-35p">
                                            <input value="100000000000" min="10" max="100000000000"
                                                   class="bg-white cz-filter-search form-control form-control-sm appended-form-control"
                                                   type="number" id="max_price" placeholder="{{ translate('max')}}">
                                        </div>

                                        <div class="d-flex justify-content-center align-items-center __number-filter-btn">
                                            <a class="action-search-products-by-price">
                                                <i class="__inline-37 czi-arrow-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h6 class="font-semibold fs-15 mb-3">{{ translate('categories') }}</h6>
                                <div class="accordion mt-n1 product-categories-list" id="shop-categories">
                                    @foreach($categories as $category)
                                        <div class="menu--caret-accordion">
                                            <div class="card-header flex-between">
                                                <div>
                                                    <label class="for-hover-label cursor-pointer get-view-by-onclick"
                                                           data-link="{{ route('products',['category_id'=> $category['id'],'data_from'=>'category', 'offer_type' => isset($data['offer_type']) ? $data['offer_type'] : '', 'page'=>1]) }}">
                                                        {{$category['name']}}
                                                    </label>
                                                </div>
                                                <div class="px-2 cursor-pointer menu--caret">
                                                    <strong class="pull-right for-brand-hover">
                                                        @if($category->childes->count()>0)
                                                            <i class="tio-next-ui fs-13"></i>
                                                        @endif
                                                    </strong>
                                                </div>
                                            </div>
                                            <div
                                                class="card-body p-0 ms-2 d--none"
                                                id="collapse-{{$category['id']}}">
                                                @foreach($category->childes as $child)
                                                    <div class="menu--caret-accordion">
                                                        <div class="for-hover-label card-header flex-between">
                                                            <div>
                                                                <label class="cursor-pointer get-view-by-onclick"
                                                                       data-link="{{ route('products',['sub_category_id'=> $child['id'],'data_from'=>'category', 'offer_type' => isset($data['offer_type']) ? $data['offer_type'] : '','page'=>1]) }}">
                                                                    {{$child['name']}}
                                                                </label>
                                                            </div>
                                                            <div class="px-2 cursor-pointer menu--caret">
                                                                <strong class="pull-right">
                                                                    @if($child->childes->count()>0)
                                                                        <i class="tio-next-ui fs-13"></i>
                                                                    @endif
                                                                </strong>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="card-body p-0 ms-2 d--none"
                                                            id="collapse-{{$child['id']}}">
                                                            @foreach($child->childes as $ch)
                                                                <div class="card-header">
                                                                    <label
                                                                        class="for-hover-label d-block cursor-pointer text-left get-view-by-onclick"
                                                                        data-link="{{ route('products',['sub_sub_category_id'=> $ch['id'],'data_from'=>'category','page'=>1]) }}">
                                                                        {{$ch['name']}}
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            @if($web_config['brand_setting'])
                                <div class="product-type-physical-section search-product-attribute-container">
                                    <h6 class="font-semibold fs-15 mb-2">{{ translate('brands') }}</h6>
                                    <div class="pb-2">
                                        <div class="input-group-overlay input-group-sm">
                                            <input placeholder="{{ translate('search_by_brands') }}"
                                                   class="__inline-38 cz-filter-search form-control form-control-sm appended-form-control search-product-attribute"
                                                   type="text">
                                            <div class="input-group-append-overlay">
                                        <span class="input-group-text">
                                            <i class="czi-search"></i>
                                        </span>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="__brands-cate-wrap attribute-list" data-simplebar
                                        data-simplebar-auto-hide="false">
                                        @foreach($activeBrands as $brand)
                                            <ul
                                                class="brand mt-2 p-0 for-brand-hover {{Session::get('direction') === "rtl" ? 'mr-2' : ''}}"
                                                id="brand">
                                                <li class="flex-between get-view-by-onclick cursor-pointer"
                                                    data-link="{{ route('products',['brand_id'=> $brand['id'],'data_from'=>'brand', 'offer_type' => isset($data['offer_type']) ? $data['offer_type'] : '', 'page'=>1]) }}">
                                                    <div class="text-start">
                                                        {{ $brand['name'] }}
                                                    </div>
                                                    <div class="__brands-cate-badge">
                                                    <span>
                                                        {{ $brand['brand_products_count'] }}
                                                    </span>
                                                    </div>
                                                </li>
                                            </ul>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if($web_config['digital_product_setting'] && count($web_config['publishing_houses']) > 0)
                                <div class="product-type-digital-section search-product-attribute-container">
                                    <h6 class="font-semibold fs-15 mb-2">{{ translate('Publishing_House') }}</h6>
                                    <div class="pb-2">
                                        <div class="input-group-overlay input-group-sm">
                                            <input placeholder="{{ translate('search_by_name') }}"
                                                   class="__inline-38 cz-filter-search form-control form-control-sm appended-form-control search-product-attribute"
                                                   type="text">
                                            <div class="input-group-append-overlay">
                                                    <span class="input-group-text">
                                                        <i class="czi-search"></i>
                                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="__brands-cate-wrap attribute-list" data-simplebar
                                        data-simplebar-auto-hide="false">
                                        @foreach($web_config['publishing_houses'] as $publishingHouseItem)
                                            <ul class="brand mt-2 p-0 for-brand-hover {{Session::get('direction') === "rtl" ? 'mr-2' : ''}}"
                                                 id="brand">
                                                <li class="flex-between get-view-by-onclick cursor-pointer pe-2"
                                                    data-link="{{ route('products',['publishing_house_id'=> $publishingHouseItem['id'], 'product_type' => 'digital', 'offer_type' => isset($data['offer_type']) ? $data['offer_type'] : '', 'page'=>1]) }}">
                                                    <div class="text-start">
                                                        {{ $publishingHouseItem['name'] }}
                                                    </div>
                                                    <div class="__brands-cate-badge">
                                                            <span>
                                                                {{ $publishingHouseItem['publishing_house_products_count'] }}
                                                            </span>
                                                    </div>
                                                </li>
                                            </ul>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if($web_config['digital_product_setting'] && count($web_config['digital_product_authors']) > 0)
                                <div class="product-type-digital-section search-product-attribute-container">
                                    <h6 class="font-semibold fs-15 mb-2">
                                        {{ translate('authors') }}/{{ translate('Creator') }}/{{ translate('Artist') }}
                                    </h6>
                                    <div class="pb-2">
                                        <div class="input-group-overlay input-group-sm">
                                            <input placeholder="{{ translate('search_by_name') }}"
                                                   class="__inline-38 cz-filter-search form-control form-control-sm appended-form-control search-product-attribute"
                                                   type="text">
                                            <div class="input-group-append-overlay">
                                                <span class="input-group-text">
                                                    <i class="czi-search"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="__brands-cate-wrap attribute-list" data-simplebar
                                        data-simplebar-auto-hide="false">
                                        @foreach($web_config['digital_product_authors'] as $productAuthor)
                                            <ul class="brand mt-2 p-0 for-brand-hover {{Session::get('direction') === "rtl" ? 'mr-2' : ''}}"
                                                 id="brand">
                                                <li class="flex-between get-view-by-onclick cursor-pointer pe-2"
                                                    data-link="{{ route('products',['author_id' => $productAuthor['id'], 'product_type' => 'digital','offer_type' => isset($data['offer_type']) ? $data['offer_type'] : '', 'page' => 1]) }}">
                                                    <div class="text-start">
                                                        {{ $productAuthor['name'] }}
                                                    </div>
                                                    <div class="__brands-cate-badge">
                                                        <span>
                                                            {{ $productAuthor['digital_product_author_count'] }}
                                                        </span>
                                                    </div>
                                                </li>
                                            </ul>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                        </div>
                    </div>

                </div>
                <div class="sidebar-overlay"></div>
            </aside>

            <section class="col-lg-9">
                <div class="row" id="ajax-products-view">
                    @include('web-views.products._ajax-products',['products'=>$products,'decimal_point_settings'=>$decimal_point_settings])
                </div>
            </section>
        </div>
    </div>
    <span id="products-search-data-backup"
          data-page="{{ request('page') ?? 1 }}"
          data-url="{{ route('products') }}"
          data-brand="{{ $data['brand_id'] ?? '' }}"
          data-category="{{ $data['category_id'] ?? '' }}"
          data-name="{{ $data['name'] }}"
          data-offer-type="{{ $data['offer_type'] }}"
          data-from="{{ $data['data_from'] ?? $data['product_type'] }}"
          data-sort="{{ $data['sort_by'] }}"
          data-product-type="{{ $data['product_type'] }}"
          data-min-price="{{ $data['min_price'] }}"
          data-max-price="{{ $data['max_price'] }}"
          data-message="{{ translate('items_found') }}"
          data-publishing-house-id="{{ request('publishing_house_id') }}"
          data-author-id="{{ request('author_id') }}"
          data-offer="{{ request('offer_type') ?? '' }}"
    ></span>

@endsection

@push('script')
    <script src="{{ theme_asset(path: 'public/assets/front-end/js/product-view.js') }}"></script>
@endpush
