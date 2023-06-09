<?php

//*****************************************************
//
// This class provides a wrapper for the database 
// All methods work on the users table

class UserDB
{
    // This data field represents the database
    private $userData;

    // Used to salt user password
    const PASSWORD_SALT = "salt123";

    //*****************************************************
    // Users class constructor:
    // Instantiates a PDO object based on given URL and
    // uses that to initialize the data field $userData
    //
    // INPUT: URL of database configuration file
    // Throws exception if database access fails
    // ** This constructor is very generic and can be used to 
    // ** access your course database for any assignment
    // ** The methods need to be changed to hit the correct table(s)
    public function __construct($configFile) 
    {
        // Parse config file, throw exception if it fails
        if ($ini = parse_ini_file($configFile))
        {
            // Create PHP Database Object
            $userPDO = new PDO( "mysql:host=" . $ini['servername'] . 
                                ";port=" . $ini['port'] . 
                                ";dbname=" . $ini['dbname'], 
                                $ini['username'], 
                                $ini['password']);

            // Don't emulate (pre-compile) prepare statements
            $userPDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            // Throw exceptions if there is a database error
            $userPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //Set our database to be the newly created PDO
            $this->userData = $userPDO;
        }
        else
        {
            // Things didn't go well, throw exception!
            throw new Exception( "<h2>Creation of database object failed!</h2>", 0, null );
        }

    } // end constructor

// Database access & modify methods are listed below. 
// General structure of each method is:
//  1) Set up variable for database and query results
//  2) Set up SQL statement (with parameters, if needed)
//  3) Bind any parameters to values
//  4) Execute statement and check for returned rows
//  5) Return results if needed.

    //*****************************************************
    // Get listing of all users
    // INPUT: None
    // RETURNS: Array with each entry representing a row in the table
    //          If no records in table, array is empty
    //**************
    //**** STUB ****
    //**************
    public function getAllUsers() 
    {
        $results = [];                  // Array to hold results
        $userTable = $this->userData;   // Alias for database PDO

        // Return results to client
        return $results;
    }

    //*****************************************************
    // Add a user to database
    // INPUT: user and divison to add
    // RETURNS: True if add is successful, false otherwise
    public function addUser($user, $email, $password) 
    {
        $addSucessful = false;         // user not added at this point
        $userTable = $this->userData;   // Alias for database PDO
        
        $salt = "salt123";

        $stmt = $userTable->prepare("INSERT INTO users SET userName = :user, userPassword = :password, userEmail = :email, userSalt = :salt");

        // Bind query parameters to method parameter values
        $boundParams = array(
            ":user" => $user,
            ":password" => sha1($salt . $password),
            ":salt" => $salt,
            ":email" => $email
        );       
        
         // Execute query and check to see if rows were returned 
         // If so, the user was successfully added
        $addSucessful = ($stmt->execute($boundParams) && $stmt->rowCount() > 0);


         // Return status to client
         return $addSucessful;
    }

    public function emailExists($userEmail)
    {
        $userTable = $this->userData;   // Alias for database PDO
        $stmt = $userTable->prepare("SELECT * FROM users WHERE userEmail = :userEmail");
        $stmt->bindValue(":userEmail", $email);
        return ($stmt->execute() && $stmt->rowCount() > 0);
    }

    public function userExists($userName)
    {
        $userTable = $this->userData;   // Alias for database PDO
        $stmt = $userTable->prepare("SELECT * FROM users WHERE userName =:userName");
        $stmt->bindValue(':userName', $userName);
        return ($stmt->execute() && $stmt->rowCount() > 0);
    }
   

    //*****************************************************
    // Delete specified user from table
    // INPUT: id of user to delete
    // RETURNS: True if update is successful, false otherwise
    //**************
    //**** STUB ****
    //**************
    public function deleteUser ($id) 
    {
        $deleteSucessful = false;       // user not updated at this point
        $userTable = $this->userData;   // Alias for database PDO

        // Return status to client           
        return $deleteSucessful;
    }
 
    //*****************************************************
    // Get one user and place it into an associative array
    public function getUser($id) 
    {
        $results = [];                  // Array to hold results
        $userTable = $this->userData;   // Alias for database PDO

        // Return results to client
        return $results;
    }

    // Special function accessible to derived classes
    // Allows children to make database queries.
    public function getDatabaseRef()
    {
        return $this->userData;
    }

    // Validates credentials user entered on form
    // INPUT: username and password from login form
    // RETURN: User id to be stored in $_SESSION, -1 if false
    //      Password is salted.
    public function validateCredentials($userName, $password)
    {
        $user = -1;
        $userTable = $this->userData;   // Alias for database PDO

        // Create query object with username and password
        // $stmt = $userTable->prepare("SELECT id FROM users WHERE userName =:userName AND userPassword = :password");
        $stmt = $userTable->prepare("SELECT id, userPassword, userSalt FROM users WHERE userName = :userName");
 
        // Bind query parameter values
        $stmt->bindValue(':userName', $userName);

        $foundUser = ($stmt->execute() && $stmt->rowCount() > 0);
        // this will try validating credentials first via username, then via email 
        if ($foundUser)
        {
            $results = $stmt->fetch(PDO::FETCH_ASSOC); 
            $hashedPassword = sha1( $results['userSalt'] . $password);
            if ($hashedPassword == $results['userPassword'])
            {
                $user = $results['id'];
            }
                     
        }
        else
        {
            $stmt = $userTable->prepare("SELECT id, userPassword, userSalt FROM users WHERE userEmail = :userName");
            $stmt->bindValue(':userName', $userName);
            $foundUser = ($stmt->execute() && $stmt->rowCount() > 0);
            $results = $stmt->fetch(PDO::FETCH_ASSOC); 
            $hashedPassword = sha1( $results['userSalt'] . $password);
            if ($hashedPassword == $results['userPassword'])
            {
                $user = $results['id'];
            }
        }
        return $user;
        // Note that we prepend salt
        // You can post-pend it also, but be consistent with h.ow the password is stored.
       // $stmt->bindValue(':password', sha1( self::PASSWORD_SALT . $password));
               
        // If we successfully execute and return a row, the crednetials are valid
        return $isValidUser;
    }
 
} // end class users
?>