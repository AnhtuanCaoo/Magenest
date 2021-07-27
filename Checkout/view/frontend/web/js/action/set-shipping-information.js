/*jshint browser:true jquery:true*/
/*global alert*/
define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote'
], function ($, wrapper, quote) {
    'use strict';

    return function (setShippingInformationAction) {

        return wrapper.wrap(setShippingInformationAction, function (originalAction) {
            var shippingAddress = quote.shippingAddress();
            if (shippingAddress['extension_attributes'] === undefined) {
                shippingAddress['extension_attributes'] = {};
            }

            shippingAddress['extension_attributes']['vn_region'] = shippingAddress.customAttributes['vn_region'];
            // if(billingAddress['extension_attributes'] === undefined){
            //     billingAddress['extension_attributes'] = {};
            // }
            // billingAddress['extension_attributes']['vn_region'] = billingAddress.customAttributes['vn_region'];
            //
            // console.log(shippingAddress);
            // console.log(billingAddress);

            // pass execution to original action ('Magento_Checkout/js/action/set-shipping-information')
            return originalAction();
        });
    };
});
