/*global jQuery, log $ */
var Shoppinglist = Shoppinglist || {};

(Shoppinglist.shoppinglists = function (options) {
    var $btn_submit_create = null,
        $ctx = null,
        $form_create = null,
        init = null,
        config = null,
        defaults = null,
        fetch_shoppinglists_by_user_id = null,
        update_existing_view = null;

    defaults = {
        onCreate : function () {},
        onDelete : function () {},
        onFetch : function () {}
    };

    config = $.extend({}, defaults, options);

    fetch_shoppinglists_by_user_id = function (callback) {
        return Shoppinglist.helper.talk_to_controller({
            controller : 'fetchshoppinglists',
            data_root_object : 'shoppinglists',
            ajax_data : {
               'hid' : Shoppinglist.selected_hid
           },
            callback : callback
        });
    };

    update_existing_view = function (data, callback) {
        var tmpHtml = new Shoppinglist.helper.HtmlString(),
            i = 0,
            len = 0,
            current_item = null;

        if (data.shoppinglists.length === 0) {
            return false;
        }

        tmpHtml.add('<h2 class="base">My Shoppinglists</h2>');
        tmpHtml.add('<ul class="menu">');

        for (i = 0, len = data.shoppinglists.length; i < len; i++) {
            current_item = data.shoppinglists[i];
            tmpHtml.add('<li>');
            tmpHtml.add('<img src="images/icon_note.png" height="20" width="20" class="base" />');
            tmpHtml.add('<a href="controller_proxy.php?controller=fetchitems&amp;sid=' + current_item.shoppinglistId + '" sid="' + current_item.shoppinglistId + '">' + current_item.name + '</a>');
            tmpHtml.add('<span class="actions">');
            tmpHtml.add('<a class="delete" title="delete" href="controller_proxy.php?controller=deleteshoppinglist&amp;sid=' + current_item.shoppinglistId + '" sid="' + current_item.shoppinglistId + '">');
            tmpHtml.add('<img src="images/icon_delete.png" height="20" width="20" class="base" />');
            tmpHtml.add('</a>');
            tmpHtml.add('</span>');
            tmpHtml.add('</li>');
        }
        tmpHtml.add('</ul>');

        $('.bdExisting', $ctx).html(tmpHtml.toString());

        callback();
        
        return true;
    };

    // TODO: prepare is common function also used for shoppinglist and items!!!
    var prepare = function ($ctx) {
        $form_create = $('form.create', $ctx);
        $btn_submit_create = $('input[type="submit"]', $form_create);

        $btn_submit_create.click(function () {
            $.ajax({
               'url' : $form_create.attr('action'),
               'data' : $form_create.serialize(),
               'type' : $form_create.attr('method'),
               'dataType' : 'json',
               'success' : function (data) {

                    if (!data.error) {
                        $ctx.trigger('dataChanged');

                        config.onCreate();
                   } else if (data.message && data.type === 'error') {
                       config.Error(data);
                   }
                }
            });
            return false;
        });

    };

    init = function () {

        $ctx = $('.modShoppinglists');

        $form_create = $('form.create', $ctx);
        $btn_submit_create = $('input[type="submit"]', $form_create);
        $form_create.append('<input type="hidden" name="hid" value="' + Shoppinglist.selected_hid + '" />');
        
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
                    } else {
                        config.onError(data);
                    }
                }
            });

            $('input[name="shoppinglist_name"]', $form_create).val('');
            
            return false;
        });

        $ctx.bind('dataChanged', function () {
            fetch_shoppinglists_by_user_id(function (data) {
                update_existing_view(data, function () {
                    $('.bdExisting', $ctx).removeClass('bdHidden');
                });
            });
        });

        $ctx.delegate('.bdExisting a.delete', 'click', function () {
            if (!confirm('Are you sure?')) {
                return false;
            }
            
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

        $ctx.delegate('.bdExisting li', 'click', function () {
            Shoppinglist.selected_sid = $(this).children('a').attr('sid');
            Shoppinglist.load_page({
                'page' : 'page.items.php',
                'afterLoad' : function () {
                    Shoppinglist.items.init();
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