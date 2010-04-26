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