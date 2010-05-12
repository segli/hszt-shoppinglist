<?php
//define(DOCUMENT_ROOT, $_SERVER['DOCUMENT_ROOT'] . '/../shlist.junghans.co.za');

define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);

set_include_path(get_include_path() . PATH_SEPARATOR . DOCUMENT_ROOT . '/../');

date_default_timezone_set('Europe/Zurich');
?>