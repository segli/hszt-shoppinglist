<?php
include('lib/authentication.class.php');

// POST / GET variables
$id = $_POST['user_email'];
$password = $_POST['user_password'];

// Logic
$user = new User();
$user = Authentication::authenticate_user($id, $password);

if(count($user) == 1) {

    session_start();
    $_SESSION['isAuth'] = 1;

    $session_id = session_id();

    // Prepare Data
    $data = array(
        'id' => $user->email,
        'password' => $user->password,
        'firstname' => $user->firstname,
        'lastname' => $user->lastname,
        'session_id' => $session_id
    );

} else {

    // Prepare Data
    $data = array(
        'error' => '1',
        'message' => 'Incorrect creditentials'
    );

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