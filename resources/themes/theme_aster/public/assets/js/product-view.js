"use strict";

let productListPageBackup = $('#products-search-data-backup');
let productListPageData = {
    page: productListPageBackup.data('page'),
    id: productListPageBackup.data('id'),
    name: productListPageBackup.data('name'),
    brand_id: productListPageBackup.data('brand'),
    category_id: productListPageBackup.data('category'),
    data_from: productListPageBackup.data('from'),
    offer_type: productListPageBackup.data('offer'),
    min_price: productListPageBackup.data('min-price'),
    max_price: productListPageBackup.data('max-price'),
    sort_by: productListPageBackup.data('sort_by'),
    product_type: productListPageBackup.data('product-type'),
    author_id: productListPageBackup.data('author-id'),
    publishing_house_id: productListPageBackup.data('publishing-house-id'),
    rating: [],
};

function getProductListFilterRender() {
    const baseUrl = productListPageBackup.data('url');
    const queryParams = $.param(productListPageData);
    const newUrl = baseUrl + '?' + queryParams;
    history.pushState(null, null, newUrl);
    $.get({
        url: productListPageBackup.data('url'),
        data: productListPageData,
        dataType: 'json',
        beforeSend: function () {
            $("#loading").addClass("d-grid");
        },
        success: function (response) {
            $("#ajax-products-view").html(response.view);
            renderQuickViewFunction()
        },
        complete: function () {
            $("#loading").removeClass("d-grid");
        },
    });
}

$('.product-list-filter-on-sort-by').on('click', function () {
    productListPageData.sort_by = $(this).data('value');
    $(".product-view-sort-by button").html($(this).text());
    $(".product-list-filter-on-sort-by").removeClass("selected");
    $(this).addClass("selected");
    getProductListFilterRender();
})

$('.filter-on-product-filter-change').on('click', function () {
    productListPageData.data_from = $(this).data('value');
    productListPageData.category_id = $('#category_id').val();
    productListPageData.brand_id = $('#brand_id').val();
    $(".filter-on-product-filter-button").html($(this).text());
    $(".filter-on-product-filter-change").removeClass("selected");
    $(this).addClass("selected");
    getProductListFilterRender();
})

$('.filter-on-product-type-change').on('click', function () {
    productListPageData.product_type = $(this).data('value');
    $(".filter-on-product-type-button").html($(this).text());
    listPageProductTypeCheck();
    getProductListFilterRender();
});

function listPageProductTypeCheck() {
    if (productListPageData?.product_type.toString() === 'digital') {
        $('.product-type-digital-section').show();
        $('.product-type-physical-section').hide();
    } else if (productListPageData?.product_type.toString() === 'physical') {
        $('.product-type-digital-section').hide();
        $('.product-type-physical-section').show();
    } else {
        $('.product-type-physical-section').show();
        $('.product-type-digital-section').show();
    }
}
listPageProductTypeCheck();

$('#min_price').on('change', function (){
    productListPageData.min_price = $(this).val();
    getProductListFilterRender();
})

$('#max_price').on('change', function (){
    productListPageData.max_price = $(this).val();
    getProductListFilterRender();
})

$('.action-search-products-by-price').on('click', function (){
    productListPageData.min_price = $('#min_price').val();
    productListPageData.max_price = $('#max_price').val();
    getProductListFilterRender();
})

$(document).ready(function() {
    $('.rating-input').on('change', function() {
        productListPageData.rating = $('.rating-input:checked').map(function() {
            return $(this).val();
        }).get() ?? [];
        getProductListFilterRender();
    });

});
