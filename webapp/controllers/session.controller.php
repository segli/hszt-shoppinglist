<?php
include('lib/authentication.class.php');

//session_name("ShopList");
session_start();

if( ! isset($_SESSION['isAuth']) OR $_SESSION['isAuth'] != 1) {
    session_destroy();
    header('Location: index.php');
}