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
        var tmpHtml = [],
            i = 0,
            len = 0,
            current_item = null;
        
        tmpHtml.push('<table class="items" width="100%">');
        
        for (i = 0, len = data.items.length; i < len; i++) {
            current_item = data.items[i];
            
            tmpHtml.push('<tr>');
            tmpHtml.push('<td width="30"><input type="checkbox" class="checkbox" name="got_it" /></td>');
            tmpHtml.push('<td><a href="#" iid="' + current_item.id + '">' + current_item.name + '</a></td>');
            tmpHtml.push('<td><input name="howmany_of" size="2" /></td>');
            tmpHtml.push('<td><input name="price" value="' + current_item.price + '" size="4" /></td>');
            tmpHtml.push('<td><a href="#" iid="' + current_item.id + '"><img src="images/icon_delete.png" height="20" width="20" alt="delete item" /></a></td>');
            tmpHtml.push('</tr>');
        }
        
        tmpHtml.push('<table>');

        $('.bdExisting', $ctx).html(tmpHtml.join(''));
    };

    init = function () {
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