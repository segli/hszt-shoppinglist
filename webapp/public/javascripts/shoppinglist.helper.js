var Shoppinglist = Shoppinglist || {};
Shoppinglist.helper = {};

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
    Shoppinglist.helper.talk_to_controller = function (controller, data_root_object, callback) {

        if (arguments.length != 3 || !$.isFunction(callback)) {
            return false;
        }

        $.ajax({
            'url' : 'controller_proxy.php?controller=' + controller,
            'type' : 'get',
            'dataType' : 'json',
            'success' : function (data) {

                if (data[data_root_object]) {
                    callback(data);
                    config.onFetch();
                } else if (data.type && data.type === 'error') {
                    config.onError(data);
                }
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

        var self = this;

        self.value = (Math.round(value * 100) / 100);

        self.currency_output = function (value) {

            value = value + '';

            if (value.indexOf('.') < 0) {
                return value + '.00';
            }

            var cent_length = value.split('.')[1].length;

            var i = 2;
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