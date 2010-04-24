var Shoppinglist = Shoppinglist || {};

Shoppinglist.load_page = function (options) {

    defaults = {
        'beforeLoad' : function () {},
        'afterLoad' : function () {},
        'page' : 'page.login.php'
    };

    var config = $.extend({}, defaults, options);

    config.beforeLoad();
    
    $.ajax({
        'url' : config.page,
        'type' : 'get',
        'dataType' : 'html',
        'success' : function (data) {
            $('#page').html(data);           
            config.afterLoad();
        }
    });

};

// Load first page
jQuery(document).ready(function () {


    Shoppinglist.load_page({
        'page' : 'page.login.php',
        'afterLoad' : function () {
            Shoppinglist.login.init(); 
        }
    });

});