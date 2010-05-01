/*global jQuery, log $ */
var Shoppinglist = Shoppinglist || {};

(Shoppinglist.invite = function (options) {
    var $btn_submit_create = null,
        $ctx = null,
        $form_create = null,
        init = {},
        config = null,
        defaults = null,
        prepare = null,
        update_existing_view = null;

    defaults = {
        onCreate : function () {},
        onError : function () {}
    };

   

    config = $.extend({}, defaults, options);


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
                tmpHtml.add('<span class="actions">');
                tmpHtml.add('<a class="delete" href="controller_proxy.php?controller=deletehousehold&amp;hid=' + current_item.householdId + '" hid="' + current_item.householdId + '">[delete]</a>');    
                tmpHtml.add('<a class="invite" href="?hid=' + current_item.householdId + '" hid="' + current_item.householdId + '">[invite]</a>');
                tmpHtml.add('</span>');
            }
            tmpHtml.add('</li>');
        }
        tmpHtml.add('<ul>');

        $('.bdExisting', $ctx).html(tmpHtml.toString());

    };

    // TODO: prepare is common function used for households, shoppinglist and items. Apply OOP!!!
    prepare = function ($ctx) {
        $form_create = $('form.create', $ctx);
        $btn_submit_create = $('input[type="submit"]', $form_create);
        
        
        $btn_submit_create.click(function () {
            $.ajax({
                'url' : $form_create.attr('action'),
                'data' : $form_create.serialize(),
                'type' : $form_create.attr('method'),
                'dataType' : 'json',
                'success' : function (data) {

                    if (data.message && data.type === 'info') {

                        config.onCreate(data);
                    } else {
                        config.onError(data);
                    }
                }
            });
            return false;
        });

    };

    init = function () {
        var $ctx = $('.modInvite');

        prepare($ctx);

        $('form.create', $ctx).append('<input type="hidden" name="hid" value="' + Shoppinglist.selected_hid + '" />');
        
    };

    return {
        init : init
    };
}(
{
    'onCreate' : function (data) {
        log[data.type](data.message);
        Shoppinglist.load_page({
            'page' : 'page.households.php',

            'afterLoad' : function () {
                Shoppinglist.households.init();

            }
        });
    },
 
    'onError' : function (data) {
        log[data.type](data.message);
    }
}
));
