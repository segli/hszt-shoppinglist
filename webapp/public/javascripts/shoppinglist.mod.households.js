var Shoppinglist = Shoppinglist || {};

(Shoppinglist.households = function (options) {
    var $btn_submit_create = null,
        $ctx = null,
        $form_create = null,
        init = {},
        config = null,
        defaults = null,
        fetch_households_by_user_id = null,
        update_existing_view = null;

    defaults = {
        onCreate : function () {},
        onFetch : function () {},
        viewUpdated : function () {},
        onError : function () {}
    };

   

    config = $.extend({}, defaults, options);

    fetch_households_by_user_id = function (callback) {
        $.ajax({
           'url' : 'controller_proxy.php?controller=fetchhouseholds',
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
        for (i = 0, len = data.households.length; i < len; i++) {
            current_item = data.households[i];
            tmpHtml.add('<li>');
            tmpHtml.add('<a href="controller_proxy.php?controller=fetchshoppinglists&amp;hid=' + current_item.householdId + '" hid="' + current_item.householdId + '">' + current_item.name + '</a>');

            if (parseInt(current_item.isOwner, 10) === 1) {
                tmpHtml.add('<a class="delete" href="controller_proxy.php?controller=deletehousehold&amp;hid=' + current_item.householdId + '" hid="' + current_item.householdId + '">[delete]</a>');    
            }
            tmpHtml.add('</li>');
        }
        tmpHtml.add('<ul>');

        $('.bdExisting', $ctx).html(tmpHtml.toString());

    };

    // TODO: prepare is common function used for households, shoppinglist and items. Apply OOP!!!
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
        var $ctx = $('.modHouseholds');

        prepare($ctx);

        $ctx.bind('dataChanged', function () {
            fetch_households_by_user_id(function (data) {
                update_existing_view(data);
            });
        });

        $ctx.click(function (e) {
            var $target = $(e.target);
            if ($target.is('.bdExisting a.delete', $ctx)) {
                
                $.ajax({
                   'url' : 'controller_proxy.php?controller=deletehousehold&hid=' + $target.attr('hid'),
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
            } else if ($target.is('.bdExisting a',$ctx)) {
                Shoppinglist.selected_hid = $(e.target).attr('hid');
                Shoppinglist.load_page({
                    'page' : 'page.shoppinglists.php',
                
                    'afterLoad' : function () {
                        Shoppinglist.shoppinglists.init();
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
        log.info('Household added');
    },
    'onDelete' : function (data) {
        log[data.type](data.message);
    },
    'onError' : function (data) {
        log[data.type](data.message);
    }
}
));
