@php use App\Utils\Helpers; @endphp
@extends('theme-views.layouts.app')
@section('title',translate('shop_Page').' | '.$web_config['company_name'].' '.translate('ecommerce'))
@push('css_or_js')
    @if($shopInfoArray['id'] != 0)
        <meta property="og:image" content="{{ $shopInfoArray['image_full_url']['path'] }}"/>
        <meta property="og:title" content="{{ $shopInfoArray['name']}} "/>
        <meta property="og:url" content="{{route('shopView',[$shopInfoArray['id']])}}">
    @else
        <meta property="og:image" content="{{$web_config['fav_icon']['path']}}"/>
        <meta property="og:title" content="{{ $shopInfoArray['name']}} "/>
        <meta property="og:url" content="{{route('shopView',[$shopInfoArray['id']])}}">
    @endif

    @if($shopInfoArray['id'] != 0)
        <meta property="twitter:card" content="{{$shopInfoArray['image_full_url']['path']}}"/>
        <meta property="twitter:title" content="{{route('shopView',[$shopInfoArray['id']])}}"/>
        <meta property="twitter:url" content="{{route('shopView',[$shopInfoArray['id']])}}">
    @else
        <meta property="twitter:card" content="{{$web_config['fav_icon']['path']}}"/>
        <meta property="twitter:title" content="{{route('shopView',[$shopInfoArray['id']])}}"/>
        <meta property="twitter:url" content="{{route('shopView',[$shopInfoArray['id']])}}">
    @endif

    <meta property="og:description"
          content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">
    <meta property="twitter:description"
          content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">
@endpush
@section('content')
    <main class="main-content d-flex flex-column gap-3 py-3">
        <div class="container">
            <div class="rounded ov-hidden mb-3">
                @if($shopInfoArray['id'] != 0)
                    <div class="store-banner dark-support bg-badge overflow-hidden" data-bg-img="">
                        <img class="w-100" alt=""
                             src="{{ getStorageImages(path: $shopInfoArray['banner_full_url'], type:'shop-banner') }}">
                    </div>
                @else
                    @php($banner=getWebConfig(name: 'shop_banner'))
                    <div class="store-banner dark-support bg-badge overflow-hidden" data-bg-img="">
                        <img class="w-100" alt=""
                             src="{{ getStorageImages(path: $banner, type: 'shop-banner') }}">
                    </div>
                @endif
                <div class="bg-primary-light p-3">
                    <div class="d-flex gap-4 flex-wrap">
                        @if($shopInfoArray['id'] != 0)
                            <div class="media gap-3">
                                <div class="avatar rounded store-avatar overflow-hidden">
                                    <div class="position-relative">
                                        <img src="{{ getStorageImages(path:$shopInfoArray['image_full_url'], type:'shop') }}"
                                             class="dark-support rounded img-fit" alt="">
                                        @if($shopInfoArray['temporary_close'])
                                            <span class="temporary-closed position-absolute">
                                                <span class="text-center px-1">{{translate('Temporary_OFF')}}</span>
                                            </span>
                                        @elseif(($seller_id==0 && $shopInfoArray['vacation_status'] && $shopInfoArray['current_date'] >= $shopInfoArray['vacation_start_date'] && $shopInfoArray['current_date'] <= $shopInfoArray['vacation_end_date']) ||
                                            $seller_id!=0 && $shopInfoArray['vacation_status'] && $shopInfoArray['current_date'] >= $shopInfoArray['vacation_start_date'] && $shopInfoArray['current_date'] <= $shopInfoArray['vacation_end_date'])
                                            <span class="temporary-closed position-absolute">
                                                <span class="text-center px-1">{{translate('closed_Now')}}</span>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="media-body d-flex flex-column gap-2">
                                    <h4>{{ $shopInfoArray['name']}}</h4>
                                    <div class="d-flex gap-2 align-items-center">
                                        <span class="star-rating text-gold fs-12">
                                            @for ($index = 1; $index <= 5; $index++)
                                                @if ($index <= $shopInfoArray['average_rating'])
                                                    <i class="bi bi-star-fill"></i>
                                                @elseif ($shopInfoArray['average_rating'] != 0 && $index <= (int)$shopInfoArray['average_rating'] + 1 && $shopInfoArray['average_rating'] >= ((int)$shopInfoArray['average_rating']+.30))
                                                    <i class="bi bi-star-half"></i>
                                                @else
                                                    <i class="bi bi-star"></i>
                                                @endif
                                            @endfor
                                        </span>
                                        <span class="text-muted fw-semibold">({{round($shopInfoArray['average_rating'],1)}})</span>
                                    </div>
                                    <ul class="list-unstyled list-inline-dot fs-12">
                                        <li>{{ $shopInfoArray['total_review']}} {{translate('Reviews')}} </li>
                                        <li>{{ $shopInfoArray['total_order']}} {{translate('Orders')}} </li>
                                        @php($minimumOrderAmount=getWebConfig(name: 'minimum_order_amount_status'))
                                        @php($minimumOrderAmountBySeller=getWebConfig(name: 'minimum_order_amount_by_seller'))
                                        @if ($minimumOrderAmount ==1 && $minimumOrderAmountBySeller ==1)
                                            <li>{{ webCurrencyConverter($shopInfoArray['minimum_order_amount'])}} {{translate('minimum_order_amount')}} </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        @else
                            <div class="media gap-3">
                                <div class="avatar rounded store-avatar overflow-hidden">
                                    <div class="position-relative">
                                        <img class="dark-support rounded img-fit" alt=""
                                            src="{{ getStorageImages(path: $web_config['fav_icon'], type:'shop') }}">

                                        @if($shopInfoArray['temporary_close'])
                                            <span class="temporary-closed position-absolute">
                                            <span>{{translate('Temporary_OFF')}}</span>
                                        </span>
                                        @elseif(($seller_id==0 && $shopInfoArray['vacation_status'] && $shopInfoArray['current_date'] >= $shopInfoArray['vacation_start_date'] && $shopInfoArray['current_date'] <= $shopInfoArray['vacation_end_date']) ||
                                            $seller_id!=0 && $shopInfoArray['vacation_status'] && $shopInfoArray['current_date'] >= $shopInfoArray['vacation_start_date'] && $shopInfoArray['current_date'] <= $shopInfoArray['vacation_end_date'])
                                            <span class="temporary-closed position-absolute">
                                                <span>{{translate('closed_Now')}}</span>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="media-body d-flex flex-column gap-2">
                                    <h4>{{ $web_config['company_name'] }}</h4>
                                    <div class="d-flex gap-2 align-items-center">
                                        <span class="star-rating text-gold fs-12">
                                            @for ($index = 1; $index <= 5; $index++)
                                                @if ($index <= $shopInfoArray['average_rating'])
                                                    <i class="bi bi-star-fill"></i>
                                                @elseif ($shopInfoArray['average_rating'] != 0 && $index <= (int)$shopInfoArray['average_rating'] + 1 && $shopInfoArray['average_rating'] >= ((int)$shopInfoArray['average_rating']+.30))
                                                    <i class="bi bi-star-half"></i>
                                                @else
                                                    <i class="bi bi-star"></i>
                                                @endif
                                            @endfor
                                        </span>
                                        <span class="text-muted fw-semibold">({{round($shopInfoArray['average_rating'], 1)}})</span>
                                    </div>
                                    <ul class="list-unstyled list-inline-dot fs-12 mb-1">
                                        <li>{{ $shopInfoArray['total_review']}} {{translate('reviews')}} </li>
                                        <li>{{ $shopInfoArray['total_order']}} {{translate('orders')}} </li>
                                    </ul>
                                    @php($minimumOrderAmountStatus=getWebConfig(name: 'minimum_order_amount_status'))
                                    @php($minimumOrderAmountBySeller=getWebConfig(name: 'minimum_order_amount_by_seller'))
                                    @if ($minimumOrderAmountStatus ==1 && $minimumOrderAmountBySeller ==1)
                                        <span class="text-sm-nowrap">{{ webCurrencyConverter($shopInfoArray['minimum_order_amount'])}} {{translate('minimum_order_amount')}}</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                        <div class="d-flex gap-3 flex-wrap flex-grow-1">
                            <div class="card flex-grow-1">
                                <div class="card-body grid-center">
                                    <div class="text-center">
                                        <h2 class="fs-28 text-primary fw-extra-bold mb-2">
                                            {{ round($rattingStatusArray['positive']) }}%</h2>
                                        <p class="text-muted text-capitalize">{{translate("positive_review")}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card flex-grow-1">
                                <div class="card-body grid-center">
                                    <div class="text-center">
                                        <h2 class="fs-28 text-primary fw-extra-bold mb-2">{{$products_for_review}}</h2>
                                        <p class="text-muted">{{translate('products')}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap flex-lg-column flex-lg-down-grow-1 justify-content-center gap-3">
                            @if (auth('customer')->check())
                                <button class="btn btn-primary flex-lg-down-grow-1 fs-16" data-bs-toggle="modal"
                                        data-bs-target="#contact_sellerModal">
                                    <i class="bi bi-chat-square-fill text-capitalize"></i> {{translate('chat_with_vendor')}}
                                </button>
                                @include('theme-views.layouts.partials.modal._chat-with-seller',['shop'=>$shopInfoArray, 'user_type' => ($shopInfoArray['id'] == 0 ? 'admin':'seller')])
                            @else
                                <button class="btn btn-primary flex-lg-down-grow-1 fs-16" data-bs-toggle="modal"
                                        data-bs-target="#loginModal">
                                    <i class="bi bi-chat-square-fill text-capitalize"></i> {{translate('chat_with_vendor')}}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @if($shopInfoArray['id'] != 0 && $shopInfoArray['bottom_banner'])
                <div>
                    <img src="{{ getStorageImages(path: $shopInfoArray['bottom_banner_full_url'], type:'shop-banner') }}"
                         class="dark-support rounded img-fit" alt="">
                </div>
            @elseif($shopInfoArray['id'] == 0 && $shopInfoArray['bottom_banner'])
                <div>
                    <img src="{{ getStorageImages(path: $shopInfoArray['bottom_banner_full_url'], type:'shop-banner') }}"
                         class="dark-support rounded img-fit" alt="">
                </div>
            @endif
        </div>

        @if (count($featuredProductsList) > 0)
            <section class="bg-primary-light">
                <div class="container">
                    <div class="">
                        <div class="py-4">
                            <div class="d-flex flex-wrap justify-content-between gap-3 mb-3 mb-sm-4">
                                <h2 class="text-capitalize">{{translate('featured_products')}}</h2>
                                <div class="swiper-nav d-flex gap-2 align-items-center">
                                    <div class="swiper-button-prev top-rated-nav-prev position-static rounded-10"></div>
                                    <div class="swiper-button-next top-rated-nav-next position-static rounded-10"></div>
                                </div>
                            </div>
                            <div class="swiper-container">
                                <div class="position-relative">
                                    <div class="swiper" data-swiper-loop="false" data-swiper-margin="20"
                                         data-swiper-autoplay="true" data-swiper-pagination-el="null"
                                         data-swiper-navigation-next=".top-rated-nav-next"
                                         data-swiper-navigation-prev=".top-rated-nav-prev"
                                         data-swiper-breakpoints='{"0": {"slidesPerView": "1"}, "320": {"slidesPerView": "2"}, "992": {"slidesPerView": "3"}, "1200": {"slidesPerView": "4"}, "1400": {"slidesPerView": "5"}}'>
                                        <div class="swiper-wrapper">
                                            @foreach ($featuredProductsList as $product)
                                                <div class="swiper-slide mx-w300">
                                                    @include('theme-views.partials._product-large-card', ['product'=>$product])
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
        <section>
            <div class="container">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-3 align-items-center justify-content-between">
                            <div class="">
                                <div class="d-flex gap-3 align-items-center">
                                    <h3 class="mb-1 text-capitalize">{{translate('search_product')}}</h3>
                                    <a href="javascript:"
                                       class="text-primary text-decoration-underline fw-semibold">
                                        {{ $products->total() }} {{ $products->total() > 1 ? translate('items') : translate('item') }}</a>
                                </div>
                            </div>
                            <div class="">
                                <div class="d-flex flex-wrap flex-lg-nowrap gap-2">
                                    <div class="search-box">
                                        <form method="get" action="{{route('shopView',['id'=>$seller_id])}}">
                                            <div class="d-flex">
                                                <div class="select-wrap border d-flex align-items-center">
                                                    <input type="hidden" name="data_from" value="search">
                                                    <input type="search" class="form-control border-0 mx-w300 h-auto"
                                                           name="product_name" value="{{ request('product_name') }}"
                                                           placeholder="{{translate('search_for_items').'...'}}">
                                                    @if(request()->has('offer_type') && request('offer_type') == 'clearance_sale')
                                                        <input type="hidden" name="offer_type" value="clearance_sale">
                                                    @endif
                                                </div>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="bi bi-search"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="border rounded custom-ps-3 py-2 d-flex align-items-center">
                                        <div class="d-flex gap-2">
                                            <div class="flex-middle gap-2">
                                                <i class="bi bi-sort-up-alt"></i>
                                                <span class="d-none d-sm-inline-block">{{translate('sort_by').' :'}}</span>
                                            </div>
                                            <div class="dropdown product-view-sort-by">
                                                <button type="button"
                                                        class="border-0 bg-transparent dropdown-toggle text-dark p-0 custom-pe-3"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                    {{translate('default')}}
                                                </button>
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

                                    <div class="border rounded custom-ps-3 py-2 d-flex align-items-center gap-2">
                                        <div class="d-flex gap-2">
                                            <div class="flex-middle gap-2">
                                                <i class="bi bi-sort-up-alt"></i>
                                                <span
                                                    class="d-none d-sm-inline-block">{{translate('show_product')}} : </span>
                                            </div>

                                            <div class="dropdown">
                                                <button type="button"
                                                        class="border-0 bg-transparent dropdown-toggle p-0 custom-pe-3 filter-on-product-filter-button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                    {{$data['data_from']=="best-selling"||$data['data_from']=="top-rated"||$data['data_from']=="featured_deal"||$data['data_from']=="latest"||$data['data_from']=="most-favorite"?
                                                    str_replace(['-', '_', '/'], ' ', translate($data['data_from'])):translate('Choose_Option')}}
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li class="{{$data['data_from']=='latest'? 'selected':''}}">
                                                        <span class="filter-on-product-filter-change" data-value="latest">
                                                            {{ translate('Latest_Products') }}
                                                        </span>
                                                    </li>
                                                    <li class="{{$data['data_from']=='best-selling'? 'selected':''}}">
                                                        <span class="filter-on-product-filter-change" data-value="best-selling">
                                                            {{ translate('Best_Selling') }}
                                                        </span>
                                                    </li>
                                                    <li class="{{$data['data_from']=='top-rated'? 'selected':''}}">
                                                        <span class="filter-on-product-filter-change" data-value="top-rated">
                                                            {{ translate('Top_Rated') }}
                                                        </span>
                                                    </li>
                                                    <li class="{{$data['data_from']=='most-favorite'? 'selected':''}}">
                                                        <span class="filter-on-product-filter-change" data-value="most-favorite">
                                                            {{ translate('Most_Favorite') }}
                                                        </span>
                                                    </li>
                                                    @if($web_config['featured_deals'])
                                                        <li class="{{$data['data_from']=='featured_deal'? 'selected':''}}">
                                                            <span class="filter-on-product-filter-change" data-value="featured_deal">
                                                                {{ translate('Featured_Deal') }}
                                                            </span>
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
                    <div class="card filter-toggle-aside">
                        <div class="d-flex d-lg-none pb-0 p-3 justify-content-end">
                            <button class="filter-aside-close border-0 bg-transparent">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>

                        <div class="card-body d-flex flex-column gap-4">
                            @include('theme-views.seller-views.partials._shop-sidebar', ['brands' => $brands])
                        </div>
                    </div>
                    <div class="">
                        <div class="d-flex flex-wrap flex-lg-nowrap align-items-start justify-content-between gap-3 mb-2">
                            <div class="d-flex flex-wrap flex-md-nowrap align-items-center justify-content-between gap-2 gap-md-3 flex-grow-1">
                                <div class="nav nav-nowrap gap-3 gap-xl-4 {{ $stockClearanceProducts > 0 ? 'nav--tabs' : ''}}">
                                    <a href="{{ route('shopView',['id' => $seller_id]) }}" class="text-capitalize {{ request('offer_type') != 'clearance_sale' ? 'active' : '' }}">{{ translate('all_products') }}</a>
                                    @if($stockClearanceSetup && $stockClearanceProducts > 0)
                                        <a href="{{ route('shopView',['id' => $seller_id, 'offer_type' => 'clearance_sale']) }}" class="text-capitalize {{ request('offer_type') == 'clearance_sale' ? 'active' : '' }}">{{ translate('clearance_sale') }}</a>
                                    @endif
                                </div>

                                <ul class="product-view-option option-select-btn align-items-center gap-3">
                                    <li>
                                        <label>
                                            <input type="radio" name="product_view" value="grid-view" hidden=""
                                                   {{!session()->has('product_view_style')?'checked':''}}
                                                   {{(session()->get('product_view_style') == 'grid-view'?'checked':'')}} id="grid-view">
                                            <span class="py-2 d-flex align-items-center gap-2 text-capitalize">
                                                <i class="bi bi-grid-fill"></i>
                                                <span class="d-none d-sm-inline">{{translate('grid_view')}}</span>
                                            </span>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="radio" name="product_view" value="list-view" hidden=""
                                                   {{(session()->get('product_view_style') == 'list-view'?'checked':'')}} id="list-view">
                                            <span class="py-2 d-flex align-items-center gap-2 text-capitalize">
                                                <i class="bi bi-list-ul"></i>
                                                <span class="d-none d-sm-inline">{{translate('list_view')}}</span>
                                            </span>
                                        </label>
                                    </li>
                                    <li>
                                        <button class="toggle-filter square-btn btn btn-outline-primary rounded d-lg-none">
                                            <i class="bi bi-funnel"></i>
                                        </button>
                                    </li>
                                </ul>
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
    <span id="filter-url" data-url="{{url('/')}}/shopView/{{$shopInfoArray['id']}}"></span>
    <span id="product-view-style-url" data-url="{{route('product_view_style')}}"></span>
    <span id="shop-follow-url" data-url="{{route('shop-follow')}}"></span>
    <input type="hidden" value="{{$data['data_from']}}" id="data_from">
    <input type="hidden" value="{{$data['id']}}" id="data_id">
    <input type="hidden" value="{{$data['name']}}" id="data_name">
    <input type="hidden" value="{{$data['min_price']}}" id="data_min_price">
    <input type="hidden" value="{{$data['max_price']}}" id="data_max_price">
    <span id="products-search-data-backup"
          data-page="{{ request('page') ?? 1 }}"
          data-url="{{ route('shopView',['id' => ($shopInfoArray['id'] != 0 ? $shopInfoArray['id'] : 0)]) }}"
          data-brand="{{ $data['brand_id'] ?? '' }}"
          data-category_id="{{ $data['category_id'] ?? '' }}"
          data-name="{{ request('search') ?? request('name') }}"
          data-from="{{ request('data_from') }}"
          data-offer = "{{ request('offer_type') }}"
          data-sort="{{ request('sort_by') }}"
          data-min-price="{{ request('min_price') }}"
          data-max-price="{{ request('max_price') }}"
          data-publishing-house-id="{{ request('publishing_house_id') }}"
          data-author-id="{{ request('author_id') }}"
          data-product-type="{{ request('product_type') ?? 'all' }}"
          data-message="{{ translate('items_found') }}"
    ></span>
@endsection

@push('script')
    <script src="{{ theme_asset(path: 'assets/js/product-view.js') }}"></script>
@endpush
