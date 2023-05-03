<?php

    // Include helper utility functions
    include_once __DIR__ . '/../include/functions.php';

    // Include user database definitions
    include_once __DIR__ . '/../model/UserDB.php';

    // This loads HTML header and starts our session if it has not been started
    include_once __DIR__ . "/../include/header.php";

    // set logged in to false
    $_SESSION['isLoggedIn'] = false;
    $_SESSION['userID'] = 0;
    
    // If this is a POST, check to see if user credentials are valid.
    // First we need to gab the crednetials form the form 
    //      and create a user database object
    $message = "";
    if (isPostRequest()) 
    {
        // Set up configuration file and create database
        $configFile = __DIR__ . '/../model/dbconfig.ini';
        try 
        {
            $userDatabase = new UserDB($configFile);
        } 
        catch ( Exception $error ) 
        {
            echo "<h2>" . $error->getMessage() . "</h2>";
        }   
         // get _POST form fields        
        $username = filter_input(INPUT_POST, 'userName');
        $password = filter_input(INPUT_POST, 'password');
        if (isset($_POST["login"]))
        {
            $id = $userDatabase->validateCredentials($username, $password);
            // Now we can check to see if use credentials are valid.
            if ($id != -1) 
            {
                // If so, set logged in to TRUE
                $_SESSION['isLoggedIn'] = true;
                $_SESSION['userID'] = $id;
                // Redirect to team listing page
                header ('Location: taskView.php');
            } 
            else 
            {
                // Whoops! Incorrect login. Tell user and stay on this page.
                $message = "Username and/or password is invalid!";
            }
        }
        // Here, we need to check if the username/email exists in the database. The emails must match and the passwords must match before adding to the database.
        elseif (isset($_POST["register"]))
        {
            $email = filter_input(INPUT_POST, 'email');
            $confirmEmail = filter_input(INPUT_POST, 'confirmEmail');
            $confirmPassword = filter_input(INPUT_POST, 'confirmPassword');
            if ($email == $confirmEmail)
            {
                if ($password == $confirmPassword)
                {
                    if ($userDatabase->emailExists($email))
                    {
                        $message = "Email already in use!";
                    }
                    else
                    {
                        if ($userDatabase->userExists($username))
                        {
                            $message = "Username is already in use!";
                        }
                        else
                        {
                            if ($userDatabase->addUser($username, $email, $password))
                            {
                                $message . "\nAdd successful. Continue to login";
                            }
                            else
                            {
                                $message . "Error connecting to database.";
                            }
                        }
                        
                    }
                }
                else
                {
                    $message = "Passwords don't match!";
                }
            }
            else
            {
                $message = "Emails don't match!";
            }
        }
    }

?>