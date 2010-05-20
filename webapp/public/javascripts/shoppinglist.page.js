/*global jQuery, log $ */
var Shoppinglist = Shoppinglist || {};

Shoppinglist.load_page_from_url = function () {
    var location = window.location.href,
        anchor = window.location.hash,
        config = null,
        defaults = null,
        keyVals = '',
        keyValsPairs = null,
        i = 0,
        len = 0,
        module_name = '',
        keyVal = null,
        options = null,
        options_override = null;

    if (location.indexOf('?') !== -1) {
        keyVals = location.split('?')[1].split('#')[0];
        keyValsPairs = keyVals.split('&');

        for (i = 0, len = keyValsPairs.length; i < len; i++) {
            keyVal = keyValsPairs[i].split('=');

            // TODO: Filter allowed keys for security reasons
            Shoppinglist[keyVal[0]] = keyVal[1];
        }

    }

    if (arguments.length > 0) {
        options = arguments[0];
    } else {
        options = {};
    }

    if (anchor === '') {
        module_name = 'login';
    } else {
        module_name = anchor.split('#page_')[1];
    }

    if (module_name) {
        defaults = {
            'afterLoad' : function () {
                Shoppinglist[module_name].init();
            },
            'page' : 'page.' + module_name + '.php'
        };

        config = $.extend(defaults, options);
    }
    Shoppinglist.load_page(config);
};

Shoppinglist.load_page = function (options) {
    var config = null,
        defaults = null;
    
    defaults = {
        'beforeLoad' : function () {},
        'afterLoad' : function () {},
        'page' : 'page.login.php',
        'data' : null
    };

    config = $.extend({}, defaults, options);

    config.beforeLoad();
    
    $.ajax({
        'url' : config.page,
        'type' : 'get',
        'data' : config.data,
        'dataType' : 'html',
        'success' : function (data) {
            $('#page').html(data);           
            config.afterLoad();
            location.href = '#page_' + config.page.split('.')[1];
            //log.info('loaded: ' + config.page);
        }
    });



};

// Load first page
jQuery(document).ready(function () {

      Shoppinglist.load_page_from_url();

 /*   Shoppinglist.load_page({
            'page' : 'page.login.php',
            'afterLoad' : function () {
                Shoppinglist['login'].init();
            }
        }); */
    
    $('body').delegate('#mainNavigation a', 'click', function () {
        
        var $this = $(this),
            page_url = '',
            module_name = '';

        // DRY this
        page_url = $this.attr('href').split('#')[1].split('_').join('.') + '.php';
        module_name = $this.attr('href').split('#')[1].split('_')[1];


        Shoppinglist.load_page({
            'page' : page_url,
            'afterLoad' : function () {
                Shoppinglist[module_name].init();
            }
        });
        return false;
    });


});