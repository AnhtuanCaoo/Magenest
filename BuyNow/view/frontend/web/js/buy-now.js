define([
    'jquery'
], function ($) {
    "use strict";
    return function (config, element) {
        $(element).click(function () {
            var form = $(element.form);

            // change form action
            var baseUrl = form.attr('action'),
                buyNowUrl = baseUrl.replace('checkout/cart/add', 'buynow/cart/add');
            console.log(baseUrl);
            form.attr('action', buyNowUrl);

            form.trigger('submit');

            // set form action back
            form.attr('action', baseUrl);

            return false;
        });
    }
});
