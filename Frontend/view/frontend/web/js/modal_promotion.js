define([
    'uiComponent',
    'jquery',
    'Magento_Ui/js/modal/modal',
    'Magento_Customer/js/customer-data'
], function (Component, $, modal, storage) {
    'use strict';

    var cacheKey = 'modal-promotion';

    var getData = function () {
        return storage.get(cacheKey)();
    };

    var saveData = function (data) {
        storage.set(cacheKey, data);
    };

    if ($.isEmptyObject(getData())) {
        var modal_promotion = {
            'modal_promotion': false
        };
        saveData(modal_promotion);
    }

    return Component.extend({

        initialize: function () {

            this._super();
            var options = {
                type: 'popup',
                responsive: true,
                innerScroll: false,
                title: false,
                buttons: false
            };

            var modal_promotion_element = $('#modal-promotion');
            var popup = modal(options, modal_promotion_element);

            modal_promotion_element.css("display", "block");

            this.openModalPromotionModal();

        },

        openModalPromotionModal:function(){
            var modalContainer = $("#modal-promotion");

            if(this.getModalPromotion()) {
                return false;
            }
            this.setModalPromotion(true);
            modalContainer.modal('openModal');
        },

        setModalPromotion: function (data) {
            var obj = getData();
            obj.modal_promotion = data;
            saveData(obj);
        },

        getModalPromotion: function () {
            return getData().modal_promotion;
        }

    });
});
