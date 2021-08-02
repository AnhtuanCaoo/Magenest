var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/action/set-shipping-information': {
                'Magenest_Checkout/js/action/set-shipping-information': true,
            },

            'Magento_Checkout/js/action/set-billing-address': {
                'Magenest_Checkout/js/action/set-billing-address-mixin': true
            },


        }
    }
};
