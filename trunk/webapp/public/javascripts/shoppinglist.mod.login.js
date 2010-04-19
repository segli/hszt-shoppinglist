var Shoppinglist = Shoppinglist || {};

(Shoppinglist.login = function (options) {
    var $ctx = null,
        init = {},
        config = null,
        defaults = null;

    defaults = {
        onLogin : function () {}    
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
                   if (!data.error) {
                       $($('.bd', $ctx).get(0)).append('<div>Your session id: ' + data.session_id + '</div>');
                       config.onLogin();
                   }
                }
            });
            return false;
        });
    };

    return {
        init : init
    };
}(
{
    'onLogin' : function () {
        location.href = 'households.php';
    }
}
));
