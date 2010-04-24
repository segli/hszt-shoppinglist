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

    if(Authentication::fields_not_empty($user)) {
        if(Authentication::is_email_address($user->email)) {
            if(Authentication::password_confirmation($user->password, $confirm_pw)) {
               if(Authentication::password_complexity($user->password)) {

                    $id = Authentication::insert_user($user);

                    if($id != null) {

                        // Prepare Data
                        $data = array(
                            'id' => $id
                        );

                    } else {
                        $data = array(
                            'error' => '2',
                            'message' => 'User already exists'
                        );
                    }
               } else {
                    $data = array(
                        'error' => '2',
                        'message' => 'Password too weak'
                    );
               }
            } else {
                $data = array(
                    'error' => '2',
                    'message' => 'Password does not match'
                );
            }
        } else {
            $data = array(
                'error' => '2',
                'message' => 'Please enter a valid email address'
            );
        }
    } else {
        $data = array(
            'error' => '2',
            'message' => 'Please fill out all fields'
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