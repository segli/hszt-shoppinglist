<?php

session_name("ShopList");
session_start();

if( ! isset($_SESSION['isAuth']) OR $_SESSION['isAuth'] != 1) {

    // Destroy the old session.
    $_SESSION = array();
    session_destroy();


    // Set a new session id
    $session_id = sha1(uniqid(microtime()) . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
    session_id($session_id);
    session_start();

    // Redirect to the start page
    header('Location: index.php');
    exit;
}