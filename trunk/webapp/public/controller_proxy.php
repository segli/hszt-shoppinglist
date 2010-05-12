<?php
include_once('../config/environment.php');
if (isset($_GET['controller'])) {
    $controller = $_GET['controller'];

    if (ctype_alpha($controller) && is_file(CONTROLLER_PATH . '/' . $controller . '.controller.php')) {
        include_once(CONTROLLER_PATH . '/' . $controller . '.controller.php');
    } 
}
exit;