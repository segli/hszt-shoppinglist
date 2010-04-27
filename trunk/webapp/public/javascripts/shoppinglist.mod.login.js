var Shoppinglist = Shoppinglist || {};

(Shoppinglist.login = function (options) {
    var $ctx = null,
        init = {},
        config = null,
        defaults = null;

    defaults = {
        onLogin : function () {},
        onMessage : function () {}
    };

    config = $.extend({}, defaults, options);

    init = function () {
        $ctx = $('.modLogin');
        
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
                       config.onMessage(data);
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
    'onMessage' : function (data) {
        log.error(data.message);    
    }
}));
