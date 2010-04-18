var Shoppinglist = Shoppinglist || {};

jQuery(document).ready(function () {
   // find modules
   var $modules = $('.mod');

    var i = 0,
        modules_length = $modules.length;
    for (i = 0; i < modules_length; i++) {

        // get 2nd class which should be modMymodule and convert "modMymodule" to "mymodule"
        var js_class = $($modules.get(i)).attr('class').split(' ')[1].split('mod')[1].toLowerCase();

        // load module
        if (Shoppinglist[js_class]) {
            Shoppinglist[js_class].init();
        }

   }
});