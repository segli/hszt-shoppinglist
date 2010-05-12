<?php

// DEV. local.shoppinglist
if (strpos($_SERVER['SERVER_NAME'], 'shlist.junghans.co.za') === false) {
    define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);
    define('CONTROLLER_PATH', DOCUMENT_ROOT . '/../controllers');
    define('INCLUDE_PATH', DOCUMENT_ROOT . '/../');
// PROD. shlist.junghans.co.za
} else {
    define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT'] . '/../shlist.junghans.co.za');
    define('CONTROLLER_PATH', DOCUMENT_ROOT . '/controllers');
    define('INCLUDE_PATH', DOCUMENT_ROOT);
}

set_include_path(get_include_path() . PATH_SEPARATOR . INCLUDE_PATH);

date_default_timezone_set('Europe/Zurich');