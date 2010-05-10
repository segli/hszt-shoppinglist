/*global jQuery, log $ */
var Shoppinglist = Shoppinglist || {};

Shoppinglist.load_page_from_url = function (options) {
    var location = window.location.href,
        anchor = window.location.hash,
        keyVals = '',
        keyValsPairs = null,
        i = 0,
        len = 0,
        module_name = '',
        keyVal = null,
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

    module_name = anchor.split('#page_')[1];

    if (module_name) {
        options_override = {
            'afterLoad' : function () {
                Shoppinglist[module_name].init();
            },
            'page' : 'page.' + module_name + '.php'
        };

        options = $.extend(options, options_override);
    }
    
    Shoppinglist.load_page(options);
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
            log.info('loaded: ' + config.page);
        }
    });



};

// Load first page
jQuery(document).ready(function () {

    Shoppinglist.load_page_from_url();
    
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