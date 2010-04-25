var Shoppinglist = Shoppinglist || {};

(Shoppinglist.items = function (options) {
    var $btn_submit_create = null,
        $ctx = null,
        $form_create = null,
        init = {},
        config = null,
        defaults = null,
        fetch_items_by_shoppinglist_id = null,
        update_existing_view = null;

    defaults = {
        onCreate : function () {},
        onFetch : function () {}
    };

    config = $.extend({}, defaults, options);

    fetch_items_by_shoppinglist_id = function (callback) {
        $.ajax({
           'url' : 'controller_proxy.php?controller=fetchitems&sid=' + Shoppinglist.selected_sid,
           'type' : 'get',
           'dataType' : 'json',
           'success' : function (data) {
               if (!data.error) {
                   callback(data);

                   config.onFetch();
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
        for (var i = 0, len = data.items.length; i < len; i++) {
            tmpHtml.push('<li><a href="#" sid="' + data.items[i].id + '">' + data.items[i].name + '</a></li>');
        }
        tmpHtml.push('<ul>');

        $('.bdExisting', $ctx).html(tmpHtml.join(''));
    };

    init = function () {

        $ctx = $('.modItems');
        $form_create = $('.create_item', $ctx);
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

        $ctx.click(function (e) {
            if ($(e.target).is('.bdExisting a',$ctx)) {
                Shoppinglist.selected_sid = $(e.target).attr('sid');
                Shoppinglist.load_page({
                    'page' : 'page.items.php',

                    'afterLoad' : function () {
                        Shoppinglist.items.init();
                    }
                });
                return false;
           }
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