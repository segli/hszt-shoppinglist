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
            tmpHtml.push('<li><a href="#" iid="' + data.items[i].id + '">' + data.items[i].name + '</a></li>');
        }
        tmpHtml.push('<ul>');

        $('.bdExisting', $ctx).html(tmpHtml.join(''));
    };

    init = function () {
        console.info('items init');
        $ctx = $('.modItems');
        $form_create = $('.create_item', $ctx);
        $btn_submit_create = $('input[type="submit"]', $form_create);
        $form_create.append('<input type="hidden" name="sid" value="' + Shoppinglist.selected_sid + '" />');
        
        $btn_submit_create.click(function () {
            $.ajax({
               'url' : $form_create.attr('action'),
               'data' : $form_create.serialize(),
               'type' : $form_create.attr('method'),
               'dataType' : 'json',
               'success' : function (data) {
                    if (!data.error) {
                        $ctx.trigger('itemschanged');

                        config.onCreate();
                   } else {
                       log.info(data.error, data.message);
                   }
                }
            });
            return false;
        });

        $ctx.bind('itemschanged', function () {
            fetch_items_by_shoppinglist_id(function (data) {
                update_existing_view(data);
            });
        });

        $ctx.click(function (e) {
            if ($(e.target).is('.bdExisting a',$ctx)) {
               
                return false;
           }
        });

        $ctx.trigger('itemschanged');

    };

    return {
        init : init
    };
}(
{
    'onCreate' : function () {
        log.info('Item added');
    }
}
));