/*global jQuery, log $ */
var Shoppinglist = Shoppinglist || {};

(Shoppinglist.items = function (options) {
    var $btn_submit_create = null,
        $btn_submit_create_bill = null,
        $ctx = null,
        $form_create = null,
        $form_create_bill = null,
        init = null,
        calculate_total = null,
        check_input_value = null,
        config = null,
        defaults = null,
        fetch_items_by_shoppinglist_id = null,
        get_timer = null,
        run_updater = null,
        set_timer = null,
        timer = null,
        update_item = null,
        update_item_price = null,
        update_item_status = null,
        update_existing_view = null,
        update_total_field = null,
        view_updater = null;

    defaults = {
        onCreate : function () {},
        onFetch : function () {},
        onError : function () {},
        onDelete : function () {},
        onPrice : function () {},
        onStatus : function () {}
    };

    set_timer = function (new_timer) {
        timer = new_timer;
        return timer;
    };

    get_timer = function () {
        return timer;
    };

    run_updater = function () {
        view_updater();
    };
    
    config = $.extend({}, defaults, options);

    calculate_total = function ($ctx, callback) {
        var current = 0,
            $item_prices = null,
            i = 0,
            len = 0,
            total = 0;

        $item_prices = $('.bdExisting .items .selected input[name="price"]', $ctx);

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

    update_item = function (url, data, callback) {
        $.ajax({
            'url' : url,
            'data' : data,
            'type' : 'post',
            'dataType' : 'json',
            'success' : function (data) {

                if (data.message && data.type === 'info') {
                    callback(data);

                } else if (data.message && data.type === 'error') {
                    config.onError(data);
                }
            }
        });
    };

    update_item_status = function (item_id, status, callback) {
        update_item('controller_proxy.php?controller=statusitem', '&sid=' + Shoppinglist.selected_sid + '&iid=' + item_id + '&status=' + status, callback);
    };

    update_item_price = function (item_id, price, callback) {     
        update_item('controller_proxy.php?controller=updatepriceitem', '&sid=' + Shoppinglist.selected_sid + '&iid=' + item_id + '&price=' + price, callback);
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
            
            current_item.price = current_item.price === '' ? '0.00' : current_item.price;
            
            if ((+current_item.status) === 1) {
                tmpHtml.add('<tr class="selected">');
                checked = 'checked="checked"';
            } else {
                tmpHtml.add('<tr>');
                checked = '';
            }

            tmpHtml.add('<td width="30"><input ' + checked + ' type="checkbox" class="checkbox" name="got_it" value="' + current_item.itemId + '" /></td>');
            tmpHtml.add('<td><a class="itemx" href="?iid=' + current_item.itemId + '" iid="' + current_item.itemId + '">' + current_item.name + '</a></td>');
            tmpHtml.add('<td><input name="howmany_of" size="2" value="1" /> #</td>');
            tmpHtml.add('<td><input name="price" value="' + current_item.price + '" size="4" /></td>');
            tmpHtml.add('<td><span class="item_price_total">0.00</span></td>');
            tmpHtml.add('<td>');
            tmpHtml.add('<a class="delete" title="delete" href="controller_proxy.php?controller=deleteitem&amp;iid=' + current_item.itemId + '" iid="' + current_item.itemId + '"><img src="images/icon_delete.png" height="20" width="20" alt="delete item" /></a>');
            tmpHtml.add('</td>');
            tmpHtml.add('</tr>');
        }
        
        tmpHtml.add('<table>');

        $('.bdExisting', $ctx).html(tmpHtml.toString());
    };

    /**
     * Checks the value of the give input text field to see if it's a number. If not, the value
     * is set to 1.
     * @method check_input_value
     * @param $ctx {jQuery}
     * @param selector {String}
     */
    check_input_value = function ($ctx, selector) {
        var input_value = 0,
            $element = null;
        $element = $(selector, $ctx);
        input_value = $element.val();
        if (isNaN(input_value) || input_value <= 0) {
            input_value = 1;
            $element.val(input_value);
        }
        return input_value;
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

            $('input[name="item_name"]', $form_create).val('').focus();
            
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

        
        $ctx.delegate('input[name="howmany_of"], input[name="price"]', 'keyup', function (e) {

            //8, 190, 46, 48 - 57
            if (!(e.keyCode === 8 || e.keyCode === 46 || e.keyCode === 190 || (e.keyCode > 47 && e.keyCode < 58))) {
                return false;
            }

            var c = null,
                $tr = null,
                howmany_of = 0,
                price = 0;

            $tr = $(this).parents('tr');

            howmany_of = check_input_value($tr, 'input[name="howmany_of"]');
            price = check_input_value($tr, 'input[name="price"]');
            
            c = new Shoppinglist.helper.Currency(howmany_of * price);

            $('.item_price_total', $tr).html(c.get_output_value());
        });

        $ctx.bind('dataChanged', function () {
            fetch_items_by_shoppinglist_id(function (data) {
                // To prevent unneccessary view updates, the received data is saved to compare
                // with data received in the future
                if ($ctx.data('item_data') != JSON.stringify(data)) {
                    $ctx.data('item_data', JSON.stringify(data));
                    update_existing_view(data);
                }
            });
        });


        view_updater = function () {
            clearTimeout(timer);
            timer = null;
     
            timer = setTimeout(function () {
                $ctx.trigger('dataChanged');
                view_updater();
            }, 3000);
            return set_timer(timer);
        };

        run_updater();

        $ctx.mouseenter(function () {
            clearTimeout(get_timer());
        });

        $ctx.mouseleave(function () {
            run_updater(); 
        });

        $ctx.bind('itemStateChanged', function (e, data) {
            var $checkbox = null,
                status = 0;

            $checkbox = $($('.bdExisting .items input:checkbox', $ctx).get(data.index));
            $checkbox.get(0).checked = data.selected;

            status = data.selected ? 1 : 0;

            update_item_status($checkbox.val(), status, function (data) {
                
                config.onStatus(data);

                update_total_field($ctx);
            });

        });

        $ctx.bind('itemPriceChanged', function (e, data) {
            var $checkbox = null;

            $checkbox = $($('.bdExisting .items input:checkbox', $ctx).get(data.index));

            update_item_price($checkbox.val(), data.price, function (data) {
                config.onPrice(data);
            });

        });

        update_total_field = function ($ctx) {
            calculate_total($ctx, function (total) {
                var c = new Shoppinglist.helper.Currency(total);

                $('#commit_cost', $ctx).val(c.get_output_value());                     
            });

        };
        
        $ctx.delegate('.bdExisting .items tr', 'click', function () {
            var $tr = null,
                data = null;
            
            $tr = $(this);

            $tr.toggleClass('selected');

            data = {
                'index' : $('.bdExisting .items tr').index($tr),
                'selected' : $tr.hasClass('selected')
            };

            $ctx.trigger('itemStateChanged', [data]);    
        });

        // don't change state when focusing to input text
        $ctx.delegate('.bdExisting .items input:text', 'click', function () {
            var $this = $(this);
            if (!$this.data('first_click')) {
                $this.val('');
                $this.data('first_click', true);
            }

            return false;
        });

        $ctx.delegate('.bdExisting .items input[name="price"]', 'blur, keyup', function () {
            update_total_field($ctx);

            var $tr = null,
                data = null;

            $tr = $(this).parents('tr');

            data = {
                'index' : $('.bdExisting .items tr').index($tr),
                'price' : $(this).val()
            };

            $ctx.trigger('itemPriceChanged', [data]);

        
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
    'onPrice' : function (data) {
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