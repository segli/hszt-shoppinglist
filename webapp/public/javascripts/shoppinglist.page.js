var Shoppinglist = Shoppinglist || {};

Shoppinglist.load_page = function (options) {

    defaults = {
        'beforeLoad' : function () {},
        'afterLoad' : function () {},
        'page' : 'page.login.php',
        'data' : null
    };

    var config = $.extend({}, defaults, options);

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

    Shoppinglist.load_page({
        'page' : 'page.login.php',
        'afterLoad' : function () {
            Shoppinglist.login.init(); 
        }
    });

    $('body').delegate('#mainNavigation a', 'click', function () {
            var $this = $(this),

            // DRY this
                page_url = $this.attr('href').split('#')[1].split('_').join('.') + '.php',
                module_name = $this.attr('href').split('#')[1].split('_')[1];

            Shoppinglist.load_page({
                'page' : page_url,
                'afterLoad' : function () {
                    Shoppinglist[module_name].init();
                }
            });
        
    });


});