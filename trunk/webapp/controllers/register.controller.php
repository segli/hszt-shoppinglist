<?php
include_once('../config/environment.php');
include_once('lib/authentication.class.php');
include_once('lib/inputvalidation.class.php');
include_once('lib/message.class.php');

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
                        $msg = new Message ('User already exists', 'error');
                        $data = $msg->to_array();
                    }
               } else {
                   $msg = new Message ('Password too weak', 'error');
                   $data = $msg->to_array();
               }
            } else {
                $msg = new Message ('Password does not match', 'error');
                $data = $msg->to_array();
               
            }
        } else {
            $msg = new Message ('Please enter a valid email address', 'error');
            $data = $msg->to_array();
            
        }
    } else {
        $msg = new Message ('Please fill out all fields', 'error');
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