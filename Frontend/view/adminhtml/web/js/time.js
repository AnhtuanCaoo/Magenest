define([
    'jquery'
], function ($) {
    'use strict';
    var enableDays = ['08-14-2021'];

    console.log(enableDays);

    function enableAllTheseDays(date) {
        var fDate = $.datepicker.formatDate('mm-dd-yy', date);
        var result = [false, ""];
        $.each(enableDays, function(k, d) {
            if (fDate === d) {
                result = [true, "highlight-green"];
            }
        });
        return result;
    }

    $("#ui-datepicker-div").datepicker({
        dateFormat: "MM/dd/yy",
        beforeShowDay: enableAllTheseDays,
    });


});
