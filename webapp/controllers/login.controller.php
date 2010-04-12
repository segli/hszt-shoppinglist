<?php
include('lib/authentication.class.php');

// POST / GET variables
$id = $_POST['user_email'];
$password = $_POST['user_password'];

// Logic
$session_id = Authentication::authenticate_user($id, $password);

setcookie('session_id', $session_id);

// Prepare Data
$data = array(
    'session_id' => $session_id,
    'id' => $id,
    'password' => $password
);

// Convert to JSON
$json = json_encode($data);

// Set content type
header('Content-type: application/json');

// Prevent caching
header('Expires: 0');

// Send Response
print($json);
exit;