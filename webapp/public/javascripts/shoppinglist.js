/*global jQuery, log $ */
var Shoppinglist = Shoppinglist || {};

/**
 * Global
 * Shoppinglist.session is populated in Shoppinglist.login on success
 */
Shoppinglist.session = null;
Shoppinglist.selected_hid = null;
Shoppinglist.selected_sid = null;

jQuery(document).ready(function () {
    // find modules
    var $modules, js_class, i, modules_length;

    $modules = $('.mod');
    js_class = '';
    i = 0;
    
    modules_length = $modules.length;

    for (i = 0; i < modules_length; i++) {

        // get 2nd class which should be modMymodule and convert "modMymodule" to "mymodule"
        js_class = $($modules.get(i)).attr('class').split(' ')[1].split('mod')[1].toLowerCase();

        // load module
        if (Shoppinglist[js_class]) {
            Shoppinglist[js_class].init();
            log.info('Module init: ' + js_class);
        }

    }


});