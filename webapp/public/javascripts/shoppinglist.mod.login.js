var Shoppinglist = Shoppinglist || {};

(Shoppinglist.login = function () {
    var $ctx = $('.modLogin'),
        init = {};

    init = function () {
        $btn_submit = $('input[type="submit"]', $ctx);

        $btn_submit.click(function () {
            $.ajax({
               'url' : 'controller_proxy.php?controller=login',
               'data' : $('form',$ctx).serialize(),
               'type' : 'post',
               'dataType' : 'json',
               'success' : function (data) {
                   if (data.session_id) {
                       $('.bd', $ctx).append('<div>Your session id: ' + data.session_id + '</div>');
                   }
                }
            });
            return false;
        });

        console.info('modLogin loaded');
    };

    return {
        init : init
    };
}());