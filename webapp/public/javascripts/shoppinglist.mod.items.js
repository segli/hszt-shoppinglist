/*global jQuery, log $ */
var Shoppinglist = Shoppinglist || {};

(Shoppinglist.items = function (options) {
    var $btn_submit_create = null,
        $ctx = null,
        $form_create = null,
        init = null,
        calculate_total = null,
        config = null,
        defaults = null,
        fetch_items_by_shoppinglist_id = null,
        update_item_status = null,
        update_existing_view = null;

    defaults = {
        onCreate : function () {},
        onFetch : function () {},
        onError : function () {},
        onDelete : function () {},
        onStatus : function () {}
    };
    
    config = $.extend({}, defaults, options);

    calculate_total = function ($ctx, callback) {
            var $item_prices = $('.bdExisting .items input[name="price"]', $ctx),
                i = 0,
                len = 0,
                total = 0;

            for (i = 0, len = $item_prices.length; i < len; i++) {
                current = (+$($item_prices.get(i)).val()) * 100;
                if (isNaN(current)) {
                    continue;
                }

                total += current;
            }

            total = total / 100;

            if ($.isFunction(callback)) {
                callback(total, $ctx);
            }

            return total;
        };

    fetch_items_by_shoppinglist_id = function (callback) {
        $.ajax({
           'url' : 'controller_proxy.php?controller=fetchitems&sid=' + Shoppinglist.selected_sid,
           'type' : 'get',
           'dataType' : 'json',
           'success' : function (data) {
               if (data.items) {
                   callback(data);
                   config.onFetch();
               } else if (data.message && data.type === 'error') {
                   config.onError(data);
               }
            }
        });
    };

    update_item_status = function (item_id, status, callback) {

        $.ajax({
           'url' : 'controller_proxy.php?controller=statusitem',
           'data' : '&sid=' + Shoppinglist.selected_sid + '&iid=' + item_id + '&status=' + status,
           'type' : 'post',
           'dataType' : 'json',
           'success' : function (data) {
               
               if (data.message && data.type === 'info') {
                   callback(data);
                   config.onStatus();
               } else if (data.message && data.type === 'error') {
                   config.onError(data);
               }
            }
        });
    };

    update_existing_view = function (data) {
        var tmpHtml = new Shoppinglist.helper.HtmlString(),
            i = 0,
            len = 0,
            checked = '',
            current_item = null;
        
        tmpHtml.add('<table class="items" width="100%">');
        
        for (i = 0, len = data.items.length; i < len; i++) {
            current_item = data.items[i];

            
            if ((+current_item.status) === 1) {
                tmpHtml.add('<tr class="selected">');
                checked = 'checked="checked"';
            } else {
                tmpHtml.add('<tr>');
                checked = '';
            }

            tmpHtml.add('<td width="30"><input ' + checked + ' type="checkbox" class="checkbox" name="got_it" value="' + current_item.itemId + '" /></td>');
            tmpHtml.add('<td><a class="itemx" href="?iid=' + current_item.itemId + '" iid="' + current_item.itemId + '">' + current_item.name + '</a></td>');
            tmpHtml.add('<td><input name="howmany_of" size="2" /></td>');
            tmpHtml.add('<td><input name="price" value="' + current_item.price + '" size="4" /></td>');
            tmpHtml.add('<td>');
            tmpHtml.add('<a class="delete" title="delete" href="controller_proxy.php?controller=deleteitem&amp;iid=' + current_item.itemId + '" iid="' + current_item.itemId + '"><img src="images/icon_delete.png" height="20" width="20" alt="delete item" /></a>');
            tmpHtml.add('</td>');
            tmpHtml.add('</tr>');
            //onclick="return confirm(\'Are you sure?\')"
        }
        
        tmpHtml.add('<table>');

        $('.bdExisting', $ctx).html(tmpHtml.toString());
    };

    init = function () {
        
        $ctx = $('.modItems');
        $form_create = $('.create_item', $ctx);
        $btn_submit_create = $('input[type="submit"]', $form_create);
        $form_create.append('<input type="hidden" name="sid" value="' + Shoppinglist.selected_sid + '" />');
        
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
                    } else if (data.message && data.type === 'error') {
                        config.onError(data);
                    }
                }
            });
            return false;
        });

        $form_create_bill = $('.create_bill', $ctx);
        $btn_submit_create_bill = $('input[type="submit"]', $form_create_bill);
        $form_create_bill.append('<input type="hidden" name="sid" value="' + Shoppinglist.selected_sid + '" />');

        $btn_submit_create_bill.click(function () {

            update_total_field($ctx);
            $.ajax({
               'url' : $form_create_bill.attr('action'),
               'data' : $form_create_bill.serialize(),
               'type' : $form_create_bill.attr('method'),
               'dataType' : 'json',
               'success' : function (data) {

                    if (data.message && data.type === 'info') {
                        $ctx.trigger('dataChanged');

                        config.onCreate(data);
                    } else if (data.message && data.type === 'error') {
                        config.onError(data);
                    }
                }
            });

            
            return false;
            
        });


        $ctx.bind('dataChanged', function () {
            fetch_items_by_shoppinglist_id(function (data) {
                update_existing_view(data);
            });
        });

        $ctx.bind('itemStateChanged', function (e, data) {
            var $checkbox = $($('.bdExisting .items input:checkbox', $ctx).get(data.index));
            $checkbox.get(0).checked = data.selected;

            var status = data.selected ? 1 : 0;

            update_item_status($checkbox.val(), status, function (data) {
                
                config.onStatus(data);

                update_total_field($ctx);
            });


        });

        update_total_field = function ($ctx) {
            calculate_total($ctx, function (total) {
                var c = new Shoppinglist.helper.Currency(total);

                $('#commit_cost', $ctx).val(c.get_output_value());                     
            });

        };
        

        $ctx.delegate('.bdExisting .items tr', 'click', function () {
            var $tr = $(this);

            $tr.toggleClass('selected');

            var data = {
                'index' : $('.bdExisting .items tr').index($tr),
                'selected' : $tr.hasClass('selected')
            };


            $ctx.trigger('itemStateChanged', [data]);
              
        });



        // don't change state when focusing to input text
        $ctx.delegate('.bdExisting .items input:text', 'click', function () {
            return false;
        });

        // don't change state when focusing to input text
        $ctx.delegate('.bdExisting .itemx', 'click', function (e) {
            e.preventDefault();
        });

        
        $ctx.delegate('.bdExisting .items a.delete', 'click', function () {
            $.ajax({
               'url' : $(this).attr('href'),
               'type' : 'get',
               'dataType' : 'json',
               'success' : function (data) {
                    $ctx.trigger('dataChanged');
                    if (data.message && data.type !== 'error') {
                        config.onDelete(data);
                   } else {
                       config.onError(data);
                   }
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
    'onStatus' : function (data) {
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