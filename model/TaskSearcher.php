<?php

include_once __DIR__ . '/Task.php'; 

// We extend the teams class so we can take advantage of work done earlier
class TaskSearcher extends Task
{

    // Allows user to search for by name or martial status
    // INPUT: team and/or division to search for
    public function searchTasks($title, $id) 
    {
        $results = [];                  // Array to hold results
        $taskTable = $this->getDatabaseRef();   // Alias for database PDO

        // Preparing SQL query 
        //    id is used to ensure we select the correct record
        $stmt = $taskTable->prepare("SELECT * FROM task WHERE userID=:id AND title LIKE :title");

         // Bind query parameter to method parameter value
         $stmt->bindValue(':id', $id);
         $stmt->bindValue(':title', '%' . $title . '%');
         // Execute query and check to see if rows were returned 
         if ( $stmt->execute() && $stmt->rowCount() > 0 ) 
         {
            // if successful, grab the first row returned
            $results = $stmt->fetchall(PDO::FETCH_ASSOC);                       
        }

        // Return results to client
        return $results;
    }
}

?>