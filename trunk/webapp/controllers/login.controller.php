<?php
include_once('../config/environment.php');
include_once('lib/authentication.class.php');
include_once('lib/inputvalidation.class.php');
include_once('lib/message.class.php');

// POST / GET variables
$id = $_POST['user_email'];
$password = $_POST['user_password'];

// Logic
$user = new User();
$user = Authentication::authenticate_user($id, $password);

    if($user != null) {

        // Set the session cookie name and destroy the old session.
        session_name("ShopList");
        session_start();
        session_destroy();

        // Generate a new session id
        $session_id = sha1(uniqid(microtime()) . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
        session_id($session_id);
        session_start();

        // Set session data
        $_SESSION['isAuth'] = 1;
        $_SESSION['user'] = $user;

        // Prepare Data
        $data = array(
            'user_id' => $user->userId,
            'email' => $user->email,
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'session_id' => $session_id
            
        );

    } else {

        // Prepare Data
        $msg = new Message ('Incorrect creditentials', 'error');
        $data = $msg->to_array();

    }

// Convert to JSON
$json = json_encode($data);

// Set content type
header('Content-type: application/json');

// Prevent caching
header('Expires: 0');

// Send Response
print($json);

exit;