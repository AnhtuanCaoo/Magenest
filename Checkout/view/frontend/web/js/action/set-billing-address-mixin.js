define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote'
], function ($, wrapper,quote) {
    'use strict';

    return function (setBillingAddressAction) {
        return wrapper.wrap(setBillingAddressAction, function (originalAction) {

            var billingAddress = quote.billingAddress();

                if (billingAddress['extension_attributes'] === undefined) {
                    billingAddress['extension_attributes'] = {};
                }

                // if (billingAddress.customAttributes !== undefined) {
                //     $.each(billingAddress.customAttributes, function (key, value) {
                //         if($.isPlainObject(value)){
                //             value = value['vn_region'];
                //         }
                //
                //         billingAddress['extension_attributes'][key] = value;
                //     });
                // }
                billingAddress['extension_attributes']['vn_region'] = billingAddress.customAttributes['vn_region'];



            return originalAction();
        });
    };
});
