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
        onError : function () {},
        onDelete : function () {}
    };

    config = $.extend({}, defaults, options);

    fetch_households_by_user_id = function (callback) {
        return Shoppinglist.helper.talk_to_controller('fetchhouseholds', 'households', callback, config);
    };

    fetch_invitations_by_user_email = function (callback) {
        return Shoppinglist.helper.talk_to_controller('fetchinvitations', 'invitations', callback, config);
    };

    /**
     * Creates html for existing households
     * @method update_existing_view
     * @param {household} data
     * @return {boolean} true
     */
    update_existing_view = function (data, callback) {
        var tmpHtml = new Shoppinglist.helper.HtmlString(),
            i = 0,
            len = 0,
            current_item = null;

        if (data.households.length === 0) {
            return false;
        }

        tmpHtml.add('<h2 class="base">My Households</h2>');
        tmpHtml.add('<ul class="menu">');
        for (i = 0, len = data.households.length; i < len; i++) {
            current_item = data.households[i];
            tmpHtml.add('<li>');
            tmpHtml.add('<img src="images/icon_house.png" height="20" width="20" class="base">');
            tmpHtml.add('<a href="controller_proxy.php?controller=fetchshoppinglists&amp;hid=' + current_item.householdId + '" hid="' + current_item.householdId + '">' + current_item.name + '</a>');

            if (parseInt(current_item.isOwner, 10) === 1) {
                tmpHtml.add('<span class="actions">');
                tmpHtml.add('<a class="invite" title="invite" href="?hid=' + current_item.householdId + '" hid="' + current_item.householdId + '">');
                tmpHtml.add('<img src="images/icon_invite.png" height="20" width="20" class="base" />');
                tmpHtml.add('</a>');
                
                tmpHtml.add('<a class="delete" title="delete" href="controller_proxy.php?controller=deletehousehold&amp;hid=' + current_item.householdId + '" hid="' + current_item.householdId + '">');
                tmpHtml.add('<img src="images/icon_delete.png" height="20" width="20" class="base" />');
                tmpHtml.add('</a>');

                tmpHtml.add('</span>');
            }
            tmpHtml.add('</li>');
        }
        tmpHtml.add('</ul>');

        $('.bdExisting', $ctx).html(tmpHtml.toString());

        callback();
        
        return true;
    };

    /**
     * Creates html for pending household invitations
     * @method update_invitations_view
     * @param {invitations} data
     * @return {boolean} true
     */
    update_invitations_view = function (data, callback) {

        var tmpHtml = new Shoppinglist.helper.HtmlString(),
            i = 0,
            len = 0,
            current_item = null;

        if (data.invitations.length === 0) {
            return false;
        }

        tmpHtml.add('<h2 class="base">Pending Invitations</h2>');
        tmpHtml.add('<ul class="menu">');
        for (i = 0, len = data.invitations.length; i < len; i++) {
            current_item = data.invitations[i];
            tmpHtml.add('<li>');
            tmpHtml.add('<img src="images/icon_house.png" height="20" width="20" class="base" />');
            // use the link with household name to show details
            tmpHtml.add('<a href="#" hid="' + current_item.householdId + '">' + current_item.householdName + '</a>');
            tmpHtml.add('<span class="actions">');
            tmpHtml.add('<a class="accept" title="accept" href="controller_proxy.php?controller=deletehousehold&amp;hid=' + current_item.householdId + '" hid="' + current_item.householdId + '">');
            tmpHtml.add('Y');
            tmpHtml.add('</a>');
            tmpHtml.add('<a class="decline" title="decline" onclick="return confirm(\'Are you sure?\')" href="?hid=' + current_item.householdId + '" hid="' + current_item.householdId + '">');
            tmpHtml.add('N');
            tmpHtml.add('</a>');
            tmpHtml.add('</span>');

            tmpHtml.add('</li>');
        }
        tmpHtml.add('</ul>');

        $('.bdInvitations', $ctx).html(tmpHtml.toString());

        callback();
        return true;
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
            update_invitations_view(data, function () {
                $('.bdInvitations', $ctx).removeClass('bdHidden');
            });
        });

        $ctx.bind('dataChanged', function () {

            fetch_households_by_user_id(function (data) {
   
                update_existing_view(data, function () {
                    $('.bdExisting', $ctx).removeClass('bdHidden');
                });
            });
        });



        $ctx.delegate('.actions a.delete', 'click', function () {
            if (!confirm('Are you sure?')) {
                return false;
            }
            
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

        $ctx.delegate('.bdExisting li', 'click', function () {
                Shoppinglist.selected_hid = $(this).children('a').attr('hid');
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

        $ctx.delegate('.actions a.accept', 'click', function () {
            console.info('accept');
            return false;
        });

        $ctx.delegate('.actions a.decline', 'click', function () {
            console.info('decline');
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
