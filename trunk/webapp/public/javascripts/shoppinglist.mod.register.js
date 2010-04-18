var Shoppinglist = Shoppinglist || {};

(Shoppinglist.register = function (options) {
    var $ctx = null,
        init = {},
        config = null,
        defaults = null;

    defaults = {
        onRegister : function () {}    
    };

    config = $.extend({}, defaults, options);

   

    init = function () {
        $ctx = $('.modRegister');
        
        $btn_submit = $('input[type="submit"]', $ctx);

        $btn_submit.click(function () {
            $.ajax({
               'url' : 'controller_proxy.php?controller=register',
               'data' : $('form',$ctx).serialize(),
               'type' : 'post',
               'dataType' : 'json',
               'success' : function (data) {
                   if (!data.error) {
                       $('.bd', $ctx).append('<div>New user id: ' + data.id + '</div>');

                       config.onRegister();
                   } else {
                       console.info(data.error, data.message);
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
    'onRegister' : function () {
        console.info('user added');
    }
}
));
