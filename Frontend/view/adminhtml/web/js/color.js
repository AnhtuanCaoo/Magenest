define([
    'jquery',
    'uiComponent',
    'ko'
], function ($, Component, ko) {
    'use strict';
    let customData = window.customConfig;
    console.log(customData);
    if(customData == null){
        let id = 0;
        return Component.extend({
            defaults: {
                template: 'Magenest_Frontend/color-pick'
            },

            initialize: function () {
                console.log(customData);
                this.options = ko.observableArray([]);
                this._super();
                this.addColor = function(){
                    id++;
                    let nameColor = "groups[color][fields][option][value][_"+ id +"][color]";
                    let nameColorCode = "groups[color][fields][option][value][_"+ id +"][code]";


                    this.options.push({

                        ids: id,
                        color_name: "",
                        color_code: "",
                        nameColor: nameColor,
                        nameColorCode: nameColorCode
                    });
                };
                this.deleteRecord = function (id){
                    this.options.destroy(id)
                    ;

                };
            },

        });
    }else{
        return Component.extend({
            defaults: {
                template: 'Magenest_Frontend/color-pick'
            },

            initialize: function () {
                let array = [];
                this.options = ko.observableArray([]);
                let count = 0;

                for(let key in customData) {
                    if (customData.hasOwnProperty(key)) {
                        let tmp = Object.keys(customData)[count];
                        let id = tmp.split('')[1];
                        if(parseInt(id)
                            !== count + 1){
                            for(let i=count;i<parseInt(id);i++){
                                array.push(i+1);
                                console.log(array);
                            }
                        }
                        let nameColor = "groups[color][fields][option][value][_" + id + "][color]";
                        let nameColorCode = "groups[color][fields][option][value][_" + id + "][code]";
                        console.log(customData[key]);
                        let name = customData[key].color;
                        let code = customData[key].code;
                        //do something with value;
                        this.options.push({
                            ids: id,
                            color_name: name,
                            color_code: code,
                            nameColor: nameColor,
                            nameColorCode: nameColorCode
                        });

                        count++;
                        console.log(this.options);
                        console.log(this.options._latestValue);
                        this._super();

                        this.addColor = function () {
                            if(array.length === 0){
                                tmp = count + 1;
                            }else{
                                tmp = array.pop();
                            }
                            count ++;
                            let nameColor = "groups[color][fields][option][value][_" + tmp + "][color]";
                            let nameColorCode = "groups[color][fields][option][value][_" + tmp + "][code]";
                            this.options.push({
                                ids: id,
                                color_name: "",
                                color_code: "",
                                nameColor: nameColor,
                                nameColorCode: nameColorCode
                            });
                        };
                        console.log(count);
                        console.log(parseInt(id));
                        console.log(parseInt(id)
                            === count );
                        this.deleteRecord = function (parent) {
                            console.log(parent);
                            console.log(parent.ids);
                            id = parent.ids;

                            array.push(id)
                            ;
                            console.log(array);
                            this.options.destroy(parent);
                            count--;
                            console.log(this.options);
                        };
                    }

                }

            }
        });
    }

});
