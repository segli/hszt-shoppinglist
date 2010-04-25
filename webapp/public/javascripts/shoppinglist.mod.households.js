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
        viewUpdated : function () {}
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

        var tmpHtml = [];
        tmpHtml.push('<ul>');
        for (var i = 0, len = data.households.length; i < len; i++) {
            tmpHtml.push('<li><a href="controller_proxy.php?controller=fetchshoppinglists&amp;hid=' + data.households[i].householdId + '" hid="' + data.households[i].householdId + '">' + data.households[i].name + '</a></li>');
        }
        tmpHtml.push('<ul>');

        $('.bdExisting', $ctx).html(tmpHtml.join(''));

    };

    

    init = function () {
        $ctx = $('.modHouseholds');
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

        $ctx.bind('dataChanged', function () {
            fetch_households_by_user_id(function (data) {
                update_existing_view(data);
            });
        });

        $ctx.click(function (e) {
            if ($(e.target).is('.bdExisting a',$ctx)) {
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
    }
}
));
