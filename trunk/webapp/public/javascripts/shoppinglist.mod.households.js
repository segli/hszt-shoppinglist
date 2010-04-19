var Shoppinglist = Shoppinglist || {};

(Shoppinglist.households = function (options) {
    var $ctx = null,
        init = {},
        config = null,
        defaults = null;

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
                   console.info(data);

                   config.onFetchHouseholds();
               } else {
                   console.info(data.error, data.message);
               }
            }
        });
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
                       console.info(data);

                       config.onCreateHousehold();
                   } else {
                       console.info(data.error, data.message);
                   }
                }
            });
            return false;
        });

        fetch_households_by_user_id();
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
