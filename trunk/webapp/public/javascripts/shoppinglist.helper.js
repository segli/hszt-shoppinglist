/*global jQuery, log $ */
var Shoppinglist = Shoppinglist || {};

/**
 * Helper Functions Namespace
 */
Shoppinglist.helper = {};

/**
 * Helper for creating larger blocks of html markup
 * @class HtmlString
 * @namespace Shoppinglist.helper
 */
(function () {
    function HtmlString() {
        this.html_array = [];
    }

    HtmlString.prototype = {
        'add' : function (html_string) {
            this.html_array.push(html_string);
        },
        'toString' : function () {
            return this.html_array.join('\n');
        }
    };

    Shoppinglist.helper.HtmlString = HtmlString;
}());

(function () {
    /**
     *
     * @param {string} controller name eg. fetchhouseholds or createhousehold. This is the same value of the key "controller" in controller_proxy.php?controller=fetchhouseholds
     * @param {string} data_root_object. The object name returned by the controller_proxy.php
     * @param {function} callback
     */
    //Shoppinglist.helper.talk_to_controller = function (controller, data_root_object, callback) {
    Shoppinglist.helper.talk_to_controller = function (options) {

        var config = null,
            defaults = null,
            ajax_url = '';
        
        // Minimum of three paramenters are expected
        if (arguments.length < 1) {
            return false;
        }

        // Default values for config (4th parameter)
        defaults = {
            controller : null,
            ajax_data : {},
            data_root_object : null,
            callback : function () {},
            onError : function () {},
            onFetch : function () {}
        };

        config = $.extend({}, defaults, options);

        ajax_url = 'controller_proxy.php?controller=' + config.controller;

        $.ajax({
            'url' : ajax_url,
            'data' : config.ajax_data, 
            'type' : 'get',
            'dataType' : 'json',
            'success' : function (data) {

                if (data[config.data_root_object]) {
                    config.callback(data);
                    config.onFetch();
                } else if (data.type && data.type === 'error') {
                    config.onError(data);
                }
            },
            'beforeSend' : function() {
                $(Shoppinglist).trigger('globalAjaxLoadStart');
            },
            'complete' : function() {
                $(Shoppinglist).trigger('globalAjaxLoadEnd');
            }
        });

        return true;
    };
}());

(function () {
    function Currency(value) {
        if (isNaN(value)) {
            return false;
        }

        var i = 0,
            cent_length = 0,
            self = this;

        self.value = (Math.round(value * 100) / 100);

        self.currency_output = function (value) {

            value = value + '';

            if (value.indexOf('.') < 0) {
                return value + '.00';
            }

            cent_length = value.split('.')[1].length;

            i = 2;

            while (cent_length < i) {
                value += '0';
                i--;
            }

            return value;
           
        };

        self.output_value = self.currency_output(self.value);

        self.get_value = function () {
            return self.value;
        };

        self.get_output_value = function () {
            return self.output_value;
        };

        return true;
    }

    Currency.prototype.toString = function () {
        return this.get_output_value();
    };

    Shoppinglist.helper.Currency = Currency;
}());

(function () {
    $(Shoppinglist).bind('globalAjaxLoadStart', function () {
        $('#global-ajax-loader').addClass('show-block');
    });

    $(Shoppinglist).bind('globalAjaxLoadEnd', function () {
        $('#global-ajax-loader').removeClass('show-block');
    });
}());