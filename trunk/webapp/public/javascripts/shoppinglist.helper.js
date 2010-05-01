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