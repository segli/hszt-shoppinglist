/*global jQuery, log $ */
var Shoppinglist = Shoppinglist || {};

(Shoppinglist.login = function (options) {
    var $btn_submit = null,
        $ctx = null,
        init = null,
        config = null,
        defaults = null;

    defaults = {
        onError : function () {},
        onMessage : function () {}
    };

    config = $.extend({}, defaults, options);

    init = function () {
        
        $ctx = $('.modLogin');

        if (Shoppinglist.session) {
            $('.hd', $ctx).hide();
            $('.bd', $ctx).replaceWith('<a href="#" id="go_to_households">Go to households</a>');

            $('#go_to_households').click(function () {
                config.onLogin();
                return false;
            });

            return false;
        }

        $($('input').get(0)).focus();
        
        $btn_submit = $('input[type="submit"]', $ctx);

        $btn_submit.click(function () {
        
            $.ajax({
                'url' : 'controller_proxy.php?controller=login',
                'data' : $('form', $ctx).serialize(),
                'type' : 'post',
                'dataType' : 'json',
                'success' : function (data) {
                  
                    if (data.session_id) {
                        Shoppinglist.session = data;
                        config.onLogin();
                    } else {
                        config.onError(data);
                    }
                }
            });

            return false;
        });
    };

    return {
        init : init
    };
}({
    'onLogin' : function () {
        Shoppinglist.load_page({
            'page' : 'page.households.php',
            'afterLoad' : function () {
                Shoppinglist.households.init();
            }
        });
    },
    'onError' : function (data) {
        log.error(data.message);    
    }
}));
