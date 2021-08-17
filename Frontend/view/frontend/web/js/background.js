define([
    'jquery',
    'uiComponent',
    'ko'
], function ($, Component, ko) {
    'use strict';
    let customData = window.customConfig;
        return Component.extend({
            initialize: function () {
                this._super();
                this.options = ko.observableArray([]);
                for(let key in customData) {
                    if (customData.hasOwnProperty(key)) {
                        this.options.push({'color': customData[key].color,
                                            'code': customData[key].code});
                        }
                    }
                this.selectedColor = ko.observable();

                this.selectedColor.subscribe(function(latest) {
                    console.log(latest);
                    $('body' ).css( "background-color", latest);

                }, this);

            }




    });
});
