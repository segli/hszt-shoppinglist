var Shoppinglist = Shoppinglist || {};

(Shoppinglist.register = function (options) {
    var $ctx = null,
        init = {},
        config = null,
        defaults = null;

    defaults = {
        onRegister : function () {},
        onMessage : function () {}
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
                   if (!data.message) {
                       $($('.bd', $ctx).get(0)).append('<div>New user id: ' + data.id + '</div>');

                       config.onRegister();
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
}(
{
    'onRegister' : function () {
        log.info('User added');
    },
    'onMessage' : function (data) {
        log[data.type](data.message);
    }
}
));
