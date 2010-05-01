/*global jQuery, log $ */
var Shoppinglist = Shoppinglist || {};

(Shoppinglist.households = function (options) {
    var $btn_submit_create = null,
        $ctx = null,
        $form_create = null,
        init = {},
        config = null,
        defaults = null,
        fetch_households_by_user_id = null,
        fetch_invitations_by_user_email = null,
        prepare = null,
        update_invitations_view = null,
        update_existing_view = null;

    /**
     * Default parameters
     * @param callback
     */
    defaults = {
        onCreate : function () {},
        onFetch : function () {},
        viewUpdated : function () {},
        onError : function () {}
    };

    config = $.extend({}, defaults, options);

    fetch_households_by_user_id = function (callback) {
        return Shoppinglist.helper.talk_to_controller('fetchhouseholds', 'households', callback);
    };

    fetch_invitations_by_user_email = function (callback) {
        return Shoppinglist.helper.talk_to_controller('fetchinvitations', 'invitations', callback);
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
            tmpHtml.add('<img src="images/icon_house.png" height="20" width="20" border="0">');
            tmpHtml.add('<a href="controller_proxy.php?controller=fetchshoppinglists&amp;hid=' + current_item.householdId + '" hid="' + current_item.householdId + '">' + current_item.name + '</a>');

            if (parseInt(current_item.isOwner, 10) === 1) {
                tmpHtml.add('<span class="actions">');
                tmpHtml.add('<a class="delete" title="delete" onclick="return confirm(\'Are you sure?\')" href="controller_proxy.php?controller=deletehousehold&amp;hid=' + current_item.householdId + '" hid="' + current_item.householdId + '">');
                tmpHtml.add('<img src="images/icon_delete.png" height="20" width="20" border="0"');
                tmpHtml.add('</a>&nbsp;&nbsp;&nbsp;');
                tmpHtml.add('<a class="invite" title="invite" href="?hid=' + current_item.householdId + '" hid="' + current_item.householdId + '">');
                tmpHtml.add('<img src="images/icon_invite.png" height="20" width="20" border="0"');
                tmpHtml.add('</a>');
                tmpHtml.add('</span>');
            }
            tmpHtml.add('</li>');
        }
        tmpHtml.add('</ul>');

        $('.bdExisting', $ctx).html(tmpHtml.toString());

    };

    update_invitations_view = function (data) {

        var tmpHtml = new Shoppinglist.helper.HtmlString(),
            i = 0,
            len = 0,
            current_item = null;

        tmpHtml.add('<ul>');
        for (i = 0, len = data.invitations.length; i < len; i++) {
            current_item = data.invitations[i];
            tmpHtml.add('<li>');
            tmpHtml.add('<img src="images/icon_house.png" height="20" width="20" border="0">');
            tmpHtml.add('<a href="controller_proxy.php?controller=fetchshoppinglists&amp;hid=' + current_item.householdId + '" hid="' + current_item.householdId + '">' + current_item.householdName + '</a>');
            tmpHtml.add('</li>');
        }
        tmpHtml.add('</ul>');

        $('.bdInvitations', $ctx).html(tmpHtml.toString());
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
                        $ctx.trigger('dataChanged');
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
        var $ctx = $('.modHouseholds');

        prepare($ctx);

        fetch_invitations_by_user_email(function (data) {
           update_invitations_view(data);
        });

        $ctx.bind('dataChanged', function () {

            fetch_households_by_user_id(function (data) {
   
                update_existing_view(data);
            });
        });


        $ctx.delegate('.actions a.delete', 'click', function () {
            $.ajax({
                'url' : 'controller_proxy.php?controller=deletehousehold&hid=' + $(this).attr('hid'),
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

        $ctx.delegate('.bdExisting li>a', 'click', function () {
                Shoppinglist.selected_hid = $(this).attr('hid');
                Shoppinglist.load_page({
                    'page' : 'page.shoppinglists.php',
                
                    'afterLoad' : function () {
                        Shoppinglist.shoppinglists.init();
                    }
                });
                return false;
        });

        $ctx.delegate('.actions a.invite', 'click', function () {
            Shoppinglist.selected_hid = $(this).attr('hid');
            Shoppinglist.load_page({
                'page' : 'page.invite.php',

                'afterLoad' : function () {
                    Shoppinglist.invite.init();

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
