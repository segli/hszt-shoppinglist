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
        onCreate : function () {},
        onFetch : function () {}
    };

    config = $.extend({}, defaults, options);

    fetch_shoppinglists_by_user_id = function (callback) {
        $.ajax({
           'url' : 'controller_proxy.php?controller=fetchshoppinglists&hid=' + Shoppinglist.selected_hid,
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
        var tmpHtml = new Shoppinglist.helper.HtmlString(),
            i = 0,
            len = 0,
            current_item = null;

        tmpHtml.add('<ul>');

        for (i = 0, len = data.shoppinglists.length; i < len; i++) {
            current_item = data.shoppinglists[i];
            tmpHtml.add('<li>');
            tmpHtml.add('<a href="#" sid="' + current_item.shoppinglistId + '">' + current_item.name + '</a>');
            tmpHtml.add('<a class="delete" href="controller_proxy.php?controller=deleteshoppinglist&amp;sid=' + current_item.shoppinglistId + '" sid="' + current_item.shoppinglistId + '">[delete]</a>');
            tmpHtml.add('</li>');
        }
        tmpHtml.add('<ul>');

        $('.bdExisting', $ctx).html(tmpHtml.toString());
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
                   } else {
                       log.info(data.error + ': ' + data.message);
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
                    if (!data.error) {
                        $ctx.trigger('dataChanged');

                        config.onCreate();
                   } else {
                       log.info(data.error, data.message);
                   }
                }
            });
            return false;
        });

        $ctx.bind('dataChanged', function () {
            fetch_shoppinglists_by_user_id(function (data) {
                update_existing_view(data);
            });
        });

        $ctx.click(function (e) {
            if ($(e.target).is('.bdExisting a.delete',$ctx)) {
                $.ajax({
                   'url' : $(e.target).attr('href'),
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
            } else if ($(e.target).is('.bdExisting a',$ctx)) {
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

        $ctx.trigger('dataChanged');

    };

    return {
        init : init
    };
}(
{
    'onCreate' : function () {
        log.info('Shoppinglist added');
    },
    'onDelete' : function (data) {
        log[data.type](data.message);
    },
    'onError' : function (data) {
        log[data.type](data.message);
    }
}
));