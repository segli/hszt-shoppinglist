<?php
include_once('../lib/authentication.class.php');
include_once('../lib/inputvalidation.class.php');

// POST / GET variables
$user = new User();
$user->firstname = $_POST['user_first_name'];
$user->lastname = $_POST['user_last_name'];
$user->email = $_POST['user_email'];
$user->password = $_POST['user_password'];
$confirm_pw = $_POST['user_confirm_password'];

    //Authentication::is_email_address($user->email);
    if(Authentication::password_confirmation($user->password, $confirm_pw)) {
       if(Authentication::password_complexity($user->password)) {

            $id = Authentication::insert_user($user);

            if($id != null) {

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
       } else {

            // Prepare Data
            $data = array(
                'error' => '2',
                'message' => 'Password too weak'
            );
       }
    } else {

         // Prepare Data
        $data = array(
            'error' => '2',
            'message' => 'Password does not match'
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