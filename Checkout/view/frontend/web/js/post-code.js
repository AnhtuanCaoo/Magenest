require([
    'jquery',
    'jquery/ui',
    'jquery/validate',
    'mage/translate'
], function($){
    'use strict';
    $.validator.addMethod(
        "post-code-number",
        function(value, element) {
            return value != 0;
        },
        $.mage.__("Bạn phải nhập một giá trị khác 0.")
    );
});
