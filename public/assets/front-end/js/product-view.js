"use strict";

let productListPageBackup = $('#products-search-data-backup');
let productListPageData = {
    id: productListPageBackup.data('id'),
    name: productListPageBackup.data('name'),
    brand_id: productListPageBackup.data('brand'),
    category_id: productListPageBackup.data('category'),
    data_from: productListPageBackup.data('from'),
    offer_type: productListPageBackup.data('offer'),
    product_check: productListPageBackup.data('product-check'),
    min_price: productListPageBackup.data('min-price'),
    max_price: productListPageBackup.data('max-price'),
    sort_by: productListPageBackup.data('sort_by'),
    product_type: productListPageBackup.data('product-type'),
    vendor_id: productListPageBackup.data('vendor-id'),
    author_id: productListPageBackup.data('author-id'),
    publishing_house_id: productListPageBackup.data('publishing-house-id'),
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
            $('#loading').show();
        },
        success: function (response) {
            console.log(response)
            $('#ajax-products-view').html(response.view);
            $(".view-page-item-count").html(response.total_product);
            renderQuickViewFunction()
        },
        complete: function () {
            $('#loading').hide();
        },
    });
}

$('.product-list-filter-on-viewpage').on('change', function (){
    productListPageData.sort_by = $(this).val();
    productListPageData.data_from = $('#data_from').val();
    productListPageData.category_id = $('#category_id').val();
    productListPageData.brand_id = $('#brand_id').val();
    getProductListFilterRender();
})

$('.filter-on-product-filter-change').on('change', function () {
    productListPageData.data_from = $(this).val();
    productListPageData.offer_type = $('#clearance_sale').val();
    getProductListFilterRender();
});

$('.filter-on-product-type-change').on('change', function () {
    productListPageData.product_type = $(this).val();
    $('.current-product-type').html($('.current-product-type').data($(this).val()));
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

$('.action-search-products-by-price').on('click', function () {
    productListPageData.min_price = $('#min_price').val();
    productListPageData.max_price = $('#max_price').val();
    getProductListFilterRender();
})

$('#searchByFilterValue-m').change(function () {
    productListPageData.data_from = $(this).val();
    getProductListFilterRender();
});


$("#search-brand").on("keyup", function () {
    let value = this.value.toLowerCase().trim();
    $("#lista1 div>li").show().filter(function () {
        return $(this).text().toLowerCase().trim().indexOf(value) == -1;
    }).hide();
});


$(".search-product-attribute").on("keyup", function () {
    let value = this.value.toLowerCase().trim();
    $(this).closest('.search-product-attribute-container').find(".attribute-list ul>li").show().filter(function () {
        return $(this).text().toLowerCase().trim().indexOf(value) == -1;
    }).hide();
});
