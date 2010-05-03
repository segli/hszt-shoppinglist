var Shoppinglist = Shoppinglist || {};

(Shoppinglist.login = function (options) {
    var $ctx = null,
        init = {},
        config = null,
        defaults = null;

    defaults = {
        onError : function () {},
        onMessage : function () {}
    };

    config = $.extend({}, defaults, options);

    init = function () {
        $ctx = $('.modLogin');


        $($('input').get(0)).focus();
        
        $btn_submit = $('input[type="submit"]', $ctx);

        $btn_submit.click(function () {
            $.ajax({
               'url' : 'controller_proxy.php?controller=login',
               'data' : $('form',$ctx).serialize(),
               'type' : 'post',
               'dataType' : 'json',
               'success' : function (data) {
                   if (!data.message) {
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
