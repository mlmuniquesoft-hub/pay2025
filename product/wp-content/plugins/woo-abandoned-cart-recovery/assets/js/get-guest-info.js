jQuery(document).ready(function ($) {
    'use strict';
    $('input#billing_email').on('change', function () {
        var pattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

        if (pattern.test($(this).val())) {
            wacv_send_get_guest_info();
        }
    });

    $('input#billing_phone').on('change', function () {
        wacv_send_get_guest_info();
    });

    function wacv_send_get_guest_info() {
        var data = $('form.woocommerce-checkout').serialize() + '&action=wacv_get_info&nonce=' + wacv_localize.nonce;
        $.ajax({
            url: wacv_localize.ajax_url,
            data: data,
            type: 'POST',
            xhrFields: {
                withCredentials: true
            },
            success: function (res) {
                // console.log(res);
            },
            error: function (res) {
                // console.log(res);
            }
        });
    }
});