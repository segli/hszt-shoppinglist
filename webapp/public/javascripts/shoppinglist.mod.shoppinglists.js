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
        var tmpHtml = [];
        tmpHtml.push('<ul>');
        for (var i = 0, len = data.shoppinglists.length; i < len; i++) {
            tmpHtml.push('<li><a href="#" sid="' + data.shoppinglists[i].shoppinglistId + '">' + data.shoppinglists[i].name + '</a></li>');
        }
        tmpHtml.push('<ul>');

        $('.bdExisting', $ctx).html(tmpHtml.join(''));
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
    }
}
));