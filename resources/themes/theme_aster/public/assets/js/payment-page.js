"use strict";
$('#digital-payment-btn').on('click', function () {
    $('.digital-payment').slideToggle('slow');
});

$('#pay-offline-method').on('change', function () {
    payOfflineMethodField(this.value);
});
function payOfflineMethodField(methodId) {
    $.get($('.get-payment-method-list').data('action'), {method_id: methodId}, (response) => {
        $("#method-filed-div").html(response.methodHtml);
    })
}

$('.checkout-wallet-payment-form').on('submit', function (event) {
    setTimeout(() => {
        $('.update_wallet_cart_button').attr('type', 'button').addClass('disabled');
    }, 100);
});

$('.checkout-payment-form').on('submit', function (event) {
    event.preventDefault();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: $(this).attr('action'),
        method: "GET",
        data: $(this).serialize(),
        beforeSend: function () {
            $("#loading").addClass("d-grid");
        },
        success: function (response) {
            if (response?.status == 0 && response?.message) {
                toastr.error(response.message);
            }
            if (response?.redirect && response?.redirect != '') {
                location.href = response?.redirect;
            }
        },
        complete: function () {
            $("#loading").removeClass("d-grid");
        },
        error: function () {
        }
    });
})
