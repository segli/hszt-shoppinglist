<?php
include_once('lib/include_dao.php');

// POST / GET variables
$first_name = $_POST['user_first_name'];
$last_name = $_POST['user_last_name'];
$email = $_POST['user_email'];
$password = $_POST['user_password'];
$confirm_password = $_POST['user_confirm_password'];

// Logic
$user = new User();
$user->email = $email;
$user->password = $password;
$user->firstname = $first_name;
$user->lastname = $last_name;

if(count(DAOFactory::getUserDAO()->queryByEmail($email)) == 0) {
    $id = DAOFactory::getUserDAO()->insert($user);

    // Prepare Data
    $data = array(
        'id' => $id
    );

} else {

    // Prepare Data
    $data = array(
        'error' => '2',
        'message' => 'User already exists'
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