<?php


    /*
    *   Input validation filter for the POST and GET array
    *   GET - Only a-z and numbers allowed
    *   POST - Special characters allowed but without '"<> etc.
    */

/*
    while (list($key, $val) = each($_GET)) {
		if(preg_match('/[^a-zA-Z0-9]/', $val )) {
            unset($_GET[$key]);
		}
	}


    while (list($key, $val) = each($_POST)) {

        // Whitelist approach
		if(preg_match('/[^a-zA-Z 0-9@\.\-_]/', $val )) {

            // Special regex for the password field to allow special characters
            if($key == "user_password") {
                if(preg_match('/[^a-zA-Z0-9\+!\*@\(\),;\?&=\$_\.]/', $val)) {
                    echo $key ." - " . $_POST[$key] . "\n";
                    unset($_POST[$key]);
                }

            } else {
                echo $key ." - " . $_POST[$key] . "\n";
                unset($_POST[$key]);
            }
		}

        /*
        // Blackbox approach
        if(preg_match('/[\'"<>]/', $val )) {
            echo $val;
            unset($_POST[$key]);
		}
		

	}
*/