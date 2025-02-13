@php use App\Utils\BrandManager;use App\Utils\CategoryManager; @endphp
@extends('theme-views.layouts.app')

@section('title',translate(str_replace(['-', '_', '/'],' ',$data['data_from'])).' '.translate('products'))

@push('css_or_js')
    <meta property="og:image" content="{{$web_config['web_logo']['path']}}"/>
    <meta property="og:title" content="Products of {{$web_config['company_name']}} "/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description"
          content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">
    <meta property="twitter:card" content="{{$web_config['web_logo']['path']}}"/>
    <meta property="twitter:title" content="Products of {{$web_config['company_name']}}"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description"
          content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">
@endpush
@section('content')
    <main class="main-content d-flex flex-column gap-3 pt-3">
        <section>
            <div class="container">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row gy-2 align-items-center">
                            <div class="col-lg-4">
                                <h3 class="mb-1">{{translate(str_replace(['-', '_', '/'],' ',$data['offer_type']))}} {{translate('products')}}</h3>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb fs-12 mb-0">
                                        <li class="breadcrumb-item"><a href="#">{{ translate('home') }}</a></li>
                                        <li class="breadcrumb-item active"
                                            aria-current="page">{{translate(str_replace(['-', '_', '/'],' ',$data['offer_type']))}} {{translate('products')}} {{ isset($data['brand_name']) ? ' / '.$data['brand_name'] : ''}} {{ request('name') ? '('.request('name').')' : ''}}</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="col-lg-8">
                                <div class="d-flex justify-content-lg-end flex-wrap gap-3">
                                    <div class="search-box position-relative search-box-2 flex-grow-1">
                                    </div>
                                    <div class="border rounded custom-ps-3 py-2">
                                        <div class="d-flex gap-2">
                                            <div class="flex-middle gap-2">
                                                <i class="bi bi-sort-up-alt"></i>
                                                <span
                                                    class="d-none d-sm-inline-block">{{translate('sort_by').':'}} </span>
                                            </div>
                                            <div class="dropdown product-view-sort-by">
                                                <button type="button"
                                                        class="border-0 bg-transparent dropdown-toggle text-dark p-0 custom-pe-3"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                    {{translate('default')}}
                                                </button>
                                                <input hidden id="data_from" value="{{ request('data_from') }}">
                                                <input hidden id="category_id" value="{{ request('category_id') }}">
                                                <input hidden id="brand_id" value="{{ request('brand_id') }}">
                                                <ul class="dropdown-menu dropdown-menu-end" id="sort-by-list">
                                                    <li class="link-hover-base product-list-filter-on-sort-by selected" data-value="latest">
                                                        {{translate('default')}}
                                                    </li>

                                                    <li class="link-hover-base product-list-filter-on-sort-by" data-value="high-low">
                                                        {{translate('High_to_Low_Price')}}
                                                    </li>
                                                    <li class="link-hover-base product-list-filter-on-sort-by" data-value="low-high">
                                                        {{translate('Low_to_High_Price')}}
                                                    </li>
                                                    <li class="link-hover-base product-list-filter-on-sort-by" data-value="a-z">
                                                        {{translate('A_to_Z_Order')}}
                                                    </li>
                                                    <li class="link-hover-base product-list-filter-on-sort-by" data-value="z-a">
                                                        {{translate('Z_to_A_Order')}}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border rounded custom-ps-3 py-2">
                                        <div class="d-flex gap-2">
                                            <div class="flex-middle gap-2">
                                                <i class="bi bi-sort-up-alt"></i>
                                                <span class="d-none d-sm-inline-block">
                                                    {{ translate('Show_Product') }} :
                                                </span>
                                            </div>
                                            <div class="dropdown">
                                                <button type="button"
                                                        class="border-0 bg-transparent dropdown-toggle p-0 custom-pe-3 filter-on-product-filter-button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                    {{$data['data_from']=="best-selling"||$data['data_from']=="top-rated"||$data['data_from']=="featured_deal"||$data['data_from']=="latest"|| $data['data_from']=="most-favorite" || $data['data_from']=="featured" ?
                                                    ucwords(str_replace(['-', '_', '/'], ' ', translate($data['data_from']))) : translate('default')}}
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li class="link-hover-base filter-on-product-filter-change {{ $data['data_from'] == '' ? 'selected':''}}" data-value="">
                                                        {{ translate('default') }}
                                                    </li>
                                                    <li class="link-hover-base filter-on-product-filter-change {{$data['data_from']=='latest'? 'selected':''}}" data-value="latest">
                                                        {{ translate('Latest_Products') }}
                                                    </li>
                                                    <li class="link-hover-base filter-on-product-filter-change {{$data['data_from']=='best-selling'? 'selected':''}}" data-value="best-selling">
                                                        {{ translate('Best_Selling') }}
                                                    </li>
                                                    <li class="link-hover-base filter-on-product-filter-change {{$data['data_from']=='top-rated'? 'selected':''}}" data-value="top-rated">
                                                        {{translate('Top_Rated')}}
                                                    </li>
                                                    <li class="link-hover-base filter-on-product-filter-change {{$data['data_from']=='most-favorite'? 'selected':''}}" data-value="most-favorite">
                                                        {{ translate('Most_Favorite') }}
                                                    </li>
                                                    <li class="link-hover-base filter-on-product-filter-change {{$data['data_from']=='featured'? 'selected':''}}" data-value="featured">
                                                        {{ translate('featured') }}
                                                    </li>
                                                    @if($web_config['featured_deals'])
                                                        <li class="link-hover-base filter-on-product-filter-change {{$data['data_from']=='featured_deal'? 'selected':''}}" data-value="featured_deal">
                                                            {{ translate('Featured_Deal') }}
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flexible-grid lg-down-1 gap-3 width--16rem">
                    <div class="card filter-toggle-aside mb-5">
                        <div class="d-flex d-lg-none pb-0 p-3 justify-content-end">
                            <button class="filter-aside-close border-0 bg-transparent">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                        <div class="card-body d-flex flex-column gap-4">
                            <div>
                                <h6 class="mb-3">{{translate('price')}}</h6>
                                <div class="d-flex align-items-end gap-2">
                                    <div class="form-group">
                                        <label for="min_price" class="mb-1">{{translate('min')}}</label>
                                        <input type="number" id="min_price" class="form-control form-control--sm"
                                               placeholder="{{'$'.translate('0')}}">
                                    </div>
                                    <div class="mb-2">-</div>
                                    <div class="form-group">
                                        <label for="max_price" class="mb-1">{{translate('max')}}</label>
                                        <input type="number" id="max_price" class="form-control form-control--sm"
                                               placeholder="{{'$'.translate('1000')}}">
                                    </div>
                                    <button class="btn btn-primary py-1 px-2 fs-13 action-search-products-by-price" id="">
                                        <i class="bi bi-chevron-right"></i>
                                    </button>
                                </div>
                                <section class="range-slider">
                                    <span class="full-range"></span>
                                    <span class="incl-range"></span>
                                    <input name="rangeOne" value="0" min="0" max="100000000000" step="1" type="range"
                                           id="price_rangeMin">
                                    <input name="rangeTwo" value="800000" min="1" max="100000000000" step="1" type="range"
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
                                                <li class="link-hover-base selected filter-on-product-type-change cursor-pointer" data-value="all">
                                                    {{ translate('All') }}
                                                </li>
                                                <li class="link-hover-base filter-on-product-type-change cursor-pointer" data-value="physical">
                                                    {{ translate('physical') }}
                                                </li>
                                                <li class="link-hover-base filter-on-product-type-change cursor-pointer" data-value="digital">
                                                    {{ translate('digital') }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="">
                                <h6 class="mb-3">{{translate('Categories')}}</h6>

                                <div class="products_aside_categories">
                                    <ul class="common-nav flex-column nav flex-nowrap custom_common_nav">
                                        @foreach($categories as $category)
                                            <li>
                                                <div class="d-flex justify-content-between">
                                                    <a href="{{route('products',['category_id'=> $category['id'],'data_from'=>'category', 'offer_type' => isset($data['offer_type']) ? $data['offer_type'] : '','page'=>1])}}">{{$category['name']}}</a>
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
                                                                    <a href="{{route('products',['sub_category_id'=> $child['id'],'data_from'=>'category', 'offer_type' => isset($data['offer_type']) ? $data['offer_type'] : '','page'=>1])}}">{{$child['name']}}</a>
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
                                                                                    <a href="{{route('products',['sub_sub_category_id'=> $ch['id'],'data_from'=>'category', 'offer_type' => isset($data['offer_type']) ? $data['offer_type'] : '','page'=>1])}}">{{$ch['name']}}</a>
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
                                @if ($categories->count() > 10)
                                    <div class="d-flex justify-content-center">
                                        <button
                                            class="btn-link text-primary btn_products_aside_categories">{{translate('more_categories').'...'}}
                                        </button>
                                    </div>
                                @endif
                            </div>

                            @if($web_config['brand_setting'])

                                <div class="product-type-physical-section">
                                    <h6 class="mb-3">{{translate('Brands')}}</h6>
                                    <div class="products_aside_brands">
                                        <ul class="common-nav nav flex-column pe-2">
                                            @foreach($activeBrands as $brand)
                                                <li class="overflow-hidden w-100">
                                                    <div class="flex-between-gap-3 align-items-center">
                                                        <label class="custom-checkbox w-75">
                                                            <a class="text-truncate" href="{{route('products',['brand_id'=> $brand['id'],'data_from'=>'brand','offer_type' => isset($data['offer_type']) ? $data['offer_type'] : '','page'=>1])}}">{{ $brand['name'] }}</a>
                                                        </label>
                                                        <span
                                                            class="badge bg-badge rounded-pill text-dark ms-auto">{{ $brand['brand_products_count'] }}</span>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    @if($activeBrands->count() > 10)
                                        <div class="d-flex justify-content-center">
                                            <button
                                                class="btn-link text-primary btn_products_aside_brands text-capitalize">{{translate('more_brands').'...'}}
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            @if($web_config['digital_product_setting'] && count($web_config['publishing_houses']) > 0)

                                <div class="product-type-digital-section">
                                    <h6 class="mb-3">{{translate('Publishing_House')}}</h6>
                                    <div class="products_aside_brands">
                                        <ul class="common-nav nav flex-column pe-2">
                                            @foreach($web_config['publishing_houses'] as $publishingHouseItem)
                                                <li>
                                                    <div class="flex-between-gap-3 align-items-center">
                                                        <label class="custom-checkbox">
                                                            <a href="{{ route('products',['publishing_house_id'=> $publishingHouseItem['id'], 'product_type' => 'digital', 'offer_type' => isset($data['offer_type']) ? $data['offer_type'] : '', 'page'=>1]) }}">
                                                                {{ $publishingHouseItem['name'] }}
                                                            </a>
                                                        </label>
                                                        <span class="badge bg-badge rounded-pill text-dark ms-auto">
                                                            {{ $publishingHouseItem['publishing_house_products_count'] }}
                                                        </span>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    @if($web_config['digital_product_setting'] && count($web_config['publishing_houses']) > 10)
                                        <div class="d-flex justify-content-center">
                                            <button
                                                class="btn-link text-primary btn_products_aside_brands text-capitalize">{{translate('more_publishing_house').'...'}}
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            @if($web_config['digital_product_setting'] && count($web_config['digital_product_authors']) > 0)

                                <div class="product-type-digital-section">
                                    <h6 class="mb-3">
                                        {{ translate('authors') }}/{{ translate('Creator') }}/{{ translate('Artist') }}
                                    </h6>
                                    <div class="products_aside_brands">

                                        <ul class="common-nav nav flex-column pe-2">
                                            @foreach($web_config['digital_product_authors'] as $productAuthor)
                                                <li>
                                                    <div class="flex-between-gap-3 align-items-center">
                                                        <label class="custom-checkbox">
                                                            <a href="{{ route('products',['author_id' => $productAuthor['id'], 'product_type' => 'digital','offer_type' => isset($data['offer_type']) ? $data['offer_type'] : '', 'page' => 1]) }}">
                                                                {{ $productAuthor['name'] }}
                                                            </a>
                                                        </label>
                                                        <span class="badge bg-badge rounded-pill text-dark ms-auto">
                                                            {{ $productAuthor['digital_product_author_count'] }}
                                                        </span>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    @if(count($web_config['digital_product_authors']) > 10)
                                        <div class="d-flex justify-content-center">
                                            <button
                                                class="btn-link text-primary btn_products_aside_brands text-capitalize">{{translate('more_authors').'...'}}
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <div id="ajax-review_partials">
                                @include('theme-views.partials._products_review_partials', ['ratings'=>$ratings])
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div
                            class="d-flex flex-wrap flex-lg-nowrap align-items-start justify-content-between gap-3 mb-2">
                            <div class="flex-middle gap-3"></div>
                            <div class="d-flex align-items-center mb-3 mb-md-0 flex-wrap flex-md-nowrap gap-3">
                                <ul class="product-view-option option-select-btn gap-3">
                                    <li>
                                        <label>
                                            <input type="radio" name="product_view" value="grid-view" hidden=""
                                                   {{(session()->get('product_view_style') == 'grid-view'?'checked':'')}} id="grid-view">
                                            <span class="py-2 d-flex align-items-center gap-2 text-capitalize"><i
                                                    class="bi bi-grid-fill"></i> {{translate('grid_view')}}</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="radio" name="product_view" value="list-view" hidden=""
                                                   {{(session()->get('product_view_style') == 'list-view'?'checked':'')}} id="list-view">
                                            <span class="py-2 d-flex align-items-center gap-2 text-capitalize"><i
                                                    class="bi bi-list-ul"></i> {{translate('list_view')}}</span>
                                        </label>
                                    </li>
                                </ul>
                                <button class="toggle-filter square-btn btn btn-outline-primary rounded d-lg-none">
                                    <i class="bi bi-funnel"></i>
                                </button>
                            </div>
                        </div>
                        @php($decimal_point_settings = getWebConfig(name: 'decimal_point_settings'))
                        <div id="ajax-products-view">
                            @include('theme-views.product._ajax-products',['products'=>$products,'decimal_point_settings'=>$decimal_point_settings])
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <span id="filter-url" data-url="{{url('/').'/products'}}"></span>
    <span id="product-view-style-url" data-url="{{route('product_view_style')}}"></span>
    <input type="hidden" value="{{ $data['id'] }}" id="data_id">
    <input type="hidden" value="{{ $data['name'] }}" id="data_name">
    <input type="hidden" value="{{ $data['data_from'] }}" id="data_from">
    <input type="hidden" value="{{ $data['offer_type'] }}" id="offer_type">
    <input type="hidden" value="{{ $data['min_price'] }}" id="data_min_price">
    <input type="hidden" value="{{ $data['max_price'] }}" id="data_max_price">

    <span id="products-search-data-backup"
          data-page="{{ request('page') ?? 1 }}"
          data-url="{{ route('products') }}"
          data-id="{{ $data['id'] }}"
          data-brand="{{ $data['brand_id'] ?? '' }}"
          data-category="{{ $data['category_id'] ?? '' }}"
          data-name="{{ $data['name'] }}"
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
    <script src="{{ theme_asset(path: 'assets/js/product-view.js') }}"></script>
@endpush
