var Shoppinglist = Shoppinglist || {};

(Shoppinglist.shoppinglists = function (options) {
    var $btn_submit_create = null,
        $ctx = null,
        $form_create = null,
        init = {},
        config = null,
        defaults = null,
        fetch_shoppinglists_by_user_id = null,
        update_existing_view = null;

    defaults = {
        onCreateShoppinglist : function () {},
        onFetchShoppinglists : function () {}
    };



    config = $.extend({}, defaults, options);

    fetch_shoppinglists_by_user_id = function (callback) {
        $.ajax({
           'url' : 'controller_proxy.php?controller=fetchshoppinglists',
           'type' : 'get',
           'dataType' : 'json',
           'success' : function (data) {
               if (!data.error) {
                   callback(data);

                   config.onFetchShoppinglists();
               } else {
                   console.info(data.error, data.message);
               }
            }
        });
    };

    update_existing_view = function (data) {
        console.info(data);
        var tmpHtml = [];
        tmpHtml.push('<ul>');
        for (var i = 0, len = data.shoppinglists.length; i < len; i++) {
            tmpHtml.push('<li>' + data.shoppinglists[i].name + '</li>');
        }
        tmpHtml.push('<ul>');

        $('.bdExisting', $ctx).html(tmpHtml.join(''));
    };

    init = function () {
        $ctx = $('.modShoppinglists');
        $form_create = $('.create_shoppinglist', $ctx);
        $btn_submit_create = $('input[type="submit"]', $form_create);

        $btn_submit_create.click(function () {
            $.ajax({
               'url' : $form_create.attr('action'),
               'data' : $form_create.serialize(),
               'type' : $form_create.attr('method'),
               'dataType' : 'json',
               'success' : function (data) {
                    if (!data.error) {
                        $ctx.trigger('shoppinglistschanged');

                        config.onCreateShoppinglist();
                   } else {
                       log.info(data.error, data.message);
                   }
                }
            });
            return false;
        });

        $ctx.bind('shoppinglistschanged', function () {
            fetch_shoppinglists_by_user_id(function (data) {
                update_existing_view(data);
            });
        });

        $ctx.trigger('shoppinglistschanged');

    };

    return {
        init : init
    };
}(
{
    'onCreateShoppinglist' : function () {
        log.info('Shoppinglist added');
    }
}
));