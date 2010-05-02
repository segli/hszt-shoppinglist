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
        onFetch : function () {},
        onError : function () {},
        onDelete : function () {}
    };

    config = $.extend({}, defaults, options);

    fetch_items_by_shoppinglist_id = function (callback) {
        $.ajax({
           'url' : 'controller_proxy.php?controller=fetchitems&sid=' + Shoppinglist.selected_sid,
           'type' : 'get',
           'dataType' : 'json',
           'success' : function (data) {
               if (data.items) {
                   callback(data);
                   config.onFetch();
               } else if (data.message && data.type === 'error') {
                   config.Error(data);
               }
            }
        });
    };

    update_existing_view = function (data) {
        var tmpHtml = new Shoppinglist.helper.HtmlString(),
            i = 0,
            len = 0,
            current_item = null;
        
        tmpHtml.add('<table class="items" width="100%">');
        
        for (i = 0, len = data.items.length; i < len; i++) {
            current_item = data.items[i];
            
            tmpHtml.add('<tr>');
            tmpHtml.add('<td width="30"><input type="checkbox" class="checkbox" name="got_it" /></td>');
            tmpHtml.add('<td><a href="#" iid="' + current_item.id + '">' + current_item.name + '</a></td>');
            tmpHtml.add('<td><input name="howmany_of" size="2" /></td>');
            tmpHtml.add('<td><input name="price" value="' + current_item.price + '" size="4" /></td>');
            tmpHtml.add('<td>');
            tmpHtml.add('<a class="delete" title="delete" onclick="return confirm(\'Are you sure?\')" href="controller_proxy.php?controller=deleteitem&amp;iid=' + current_item.itemId + '" iid="' + current_item.itemId + '"><img src="images/icon_delete.png" height="20" width="20" alt="delete item" /></a>');
            tmpHtml.add('</td>');
            tmpHtml.add('</tr>');
        }
        
        tmpHtml.add('<table>');

        $('.bdExisting', $ctx).html(tmpHtml.toString());
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
                    if (data.message && data.type === 'info') {
                        $ctx.trigger('dataChanged');

                        config.onCreate(data);
                    } else if (data.message && data.type === 'error') {
                        config.onError(data);
                    }
                }
            });
            return false;
        });

        $ctx.bind('dataChanged', function () {
            fetch_items_by_shoppinglist_id(function (data) {
                update_existing_view(data);
            });
        });

        $ctx.delegate('.bdExisting li>a', 'click', function () {
            return false;
        });

        $ctx.delegate('.bdExisting a.delete', 'click', function () {
            $.ajax({
               'url' : $(this).attr('href'),
               'type' : 'get',
               'dataType' : 'json',
               'success' : function (data) {
                    if (data.message && data.type !== 'error') {
                        $ctx.trigger('dataChanged');
                        config.onDelete(data);
                   } else {
                       config.onError(data);
                   }
                }
            });
            return false;
        });

        
        $ctx.trigger('dataChanged');

    };

    return {
        init : init
    };
}(
{
    'onCreate' : function (data) {
        log[data.type](data.message);
    },
    'onDelete' : function (data) {
        log[data.type](data.message);
    },
    'onError' : function (data) {
        log[data.type](data.message);
    }
}
));