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
        onCreateHousehold : function () {},
        onFetchHouseholds : function () {}
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

                   config.onFetchHouseholds();
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
        for (var i = 0, len = data.households.length; i < len; i++) {
            tmpHtml.push('<li>' + data.households[i].name + '</li>');
        }
        tmpHtml.push('<ul>');

        $('.bdExisting', $ctx).html(tmpHtml.join(''));
    };

    init = function () {
        $ctx = $('.modHouseholds');
        $form_create = $('.create_household', $ctx);
        $btn_submit_create = $('input[type="submit"]', $form_create);

        $btn_submit_create.click(function () {
            $.ajax({
               'url' : $form_create.attr('action'),
               'data' : $form_create.serialize(),
               'type' : $form_create.attr('method'),
               'dataType' : 'json',
               'success' : function (data) {
                    if (!data.error) {
                        $ctx.trigger('householdschanged');

                        config.onCreateHousehold();
                   } else {
                       console.info(data.error, data.message);
                   }
                }
            });
            return false;
        });

        $ctx.bind('householdschanged', function () {
            fetch_households_by_user_id(function (data) {
                update_existing_view(data);
            });
        });

        $ctx.trigger('householdschanged');

    };

    return {
        init : init
    };
}(
{
    'onCreateHousehold' : function () {
        console.info('household added');
    }
}
));
