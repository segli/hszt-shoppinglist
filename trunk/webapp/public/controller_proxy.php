<?

include_once('../config/environment.php');

if (isset($_GET['controller'])) {
    $controller = $_GET['controller'];

    if (ctype_alpha($controller) && is_file($_SERVER['DOCUMENT_ROOT'] . '/controllers/' . $controller . '.controller.php')) {
        include_once('../controllers/' . $controller . '.controller.php');
    }
}

exit;

?>