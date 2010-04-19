var Shoppinglist = Shoppinglist || {};

(Shoppinglist.households = function (options) {
    var $ctx = null,
        init = {},
        config = null,
        defaults = null;

    defaults = {
        onCreateHousehold : function () {}
    };

    config = $.extend({}, defaults, options);

   

    init = function () {
        $ctx = $('.modHouseholds');

        $form_create = $('.create_household', $ctx);
        $btn_submit = $('input[type="submit"]', $form_create);


        $btn_submit.click(function () {
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
