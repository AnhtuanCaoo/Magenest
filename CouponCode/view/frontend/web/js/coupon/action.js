define(['jquery',
        'uiComponent',
        'ko',
        'Magento_Ui/js/modal/alert',
        'mage/url'],
    function ($, Component, ko, alert, urlBuilder) {
        'use strict';
        return Component.extend({
            initialize: function () {
                this._super();
            },
            seeMore: function (data) {
                alert({
                    title: 'Description',
                    content: data,
                    modalClass: 'alert',
                    buttons: [{
                        text: $.mage.__('Continue'),
                        class: 'action primary accept',
                        click: function () {
                            this.closeModal(true);
                        }
                    }]
                });
            },
            claimCoupon: function (coupon, rule, user) {
                var url = urlBuilder.build('couponcode/coupon/claim');
                var tmp = $('#claim' + rule );
                tmp.attr("disabled", true);
                tmp.html('Saved');
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        rule_id: rule,
                        customer_id: user,
                        coupon_id: coupon
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function (xhr, status, errorThrown) {
                        console.log('Error happens. Try again.');
                    }
                });
            },
            warning: function (data) {
                alert({
                    title: 'Coupon',
                    content: 'Please login to claim coupon ' + data,
                    modalClass: 'alert',
                    buttons: [{
                        text: $.mage.__('Accept'),
                        class: 'action primary accept',
                        click: function () {
                            this.closeModal(true);
                        }
                    }]
                });
            }
        });
    }
);
