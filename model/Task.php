<?php

//*****************************************************
//
// This class provides a wrapper for the database 
// All methods work on the tasks

class Task
{

    // This data field represents the database
    private $taskData;
 
    
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
            $taskPDO = new PDO( "mysql:host=" . $ini['servername'] . 
                                ";port=" . $ini['port'] . 
                                ";dbname=" . $ini['dbname'], 
                                $ini['username'], 
                                $ini['password']);

            // Don't emulate (pre-compile) prepare statements
            $taskPDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            // Throw exceptions if there is a database error
            $taskPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //Set our database to be the newly created PDO
            $this->taskData = $taskPDO;
        }
        else
        {
            // Things didn't go well, throw exception!
            throw new Exception( "<h2>Creation of database object failed!</h2>", 0, null );
        }

    } // end constructor

    public function getUserTasks($id) 
    {
        $results = [];                  // Array to hold results
        $taskTable = $this->taskData;   // Alias for database PDO

        // Preparing SQL query 
        //    id is used to ensure we select the correct record
        $stmt = $taskTable->prepare("SELECT * FROM task WHERE userID=:id");

         // Bind query parameter to method parameter value
         $stmt->bindValue(':id', $id);
       
         // Execute query and check to see if rows were returned 
         if ( $stmt->execute() && $stmt->rowCount() > 0 ) 
         {
            // if successful, grab the first row returned
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);                       
        }

        // Return results to client
        return $results;
    }

   //*****************************************************
    // Gets one task based on id
    // INPUT: id of task
    // RETURNS: table of task that is selected
    public function getTask ($id) 
    {
        $results = [];                  // Array to hold results
        $taskTable = $this->taskData;   // Alias for database PDO

        // Preparing SQL query 
        //    id is used to ensure we select the correct record
        $stmt = $taskTable->prepare("SELECT * FROM task WHERE id=:id");

         // Bind query parameter to method parameter value
         $stmt->bindValue(':id', $id);
       
         // Execute query and check to see if rows were returned 
         if ( $stmt->execute() && $stmt->rowCount() > 0 ) 
         {
            // if successful, grab the first row returned
            $results = $stmt->fetch(PDO::FETCH_ASSOC);                       
        }

        // Return results to client
        return $results;
    }

    public function addTask($id, $priority, $category, $dueDate, $title, $notes)
    {
        $success = false;
        $taskTable = $this->taskData;
        // Preparing SQL query 
        $stmt = $taskTable->prepare("INSERT INTO task SET userID = :id, priority = :priority, category = :category, dueDate = :dueDate, title = :title, notes = :notes, completed = 0");

        $boundParams = array(
            ":id" => $id,
            ":priority" => intval($priority),
            ":category" => $category,
            ":dueDate" =>$dueDate,
            ":title" => $title,
            ":notes" => $notes
        );
        $success = ($stmt->execute($boundParams) && $stmt->rowCount() > 0);
        // return success to the client whether it succeeeded or not
        return $success;
    }

    public function updateTask($id, $priority, $category, $dueDate, $title, $notes, $completed)
    {
        $success = false;
        $taskTable = $this->taskData;
        // Preparing SQL query 
        $stmt = $taskTable->prepare("UPDATE task SET priority = :priority, category = :category, dueDate = :dueDate, title = :title, notes = :notes, completed = :completed WHERE id = :id");

        $boundParams = array(
            ":id" => $id,
            ":priority" => $priority,
            ":category" => $category,
            ":dueDate" =>$dueDate,
            ":title" => $title,
            ":notes" => $notes,
            ":completed" => $completed
        );
        $success = ($stmt->execute($boundParams) && $stmt->rowCount() > 0);
        // return success to the client whether it succeeeded or not
        return $success;
    }

    protected function getDatabaseRef()
    {
        return $this->taskData;
    }

   // Destructor to clean up any memory allocation
   public function __destruct() 
   {
       // Mark the PDO for deletion
       $this->taskData = null;

        // If we had a datafield that was a fileReference
        // we should ensure the file is closed
        // We don't have that here since taskFileRef was local to 
        // the method inserttasksFromFile   
        // if($this->myFileRef)
        // {
        //     fclose($this->myFileRef);
        // }

   }


} // end tasks class