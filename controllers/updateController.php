<?php
 
  // This code runs everything the page loads
  include_once __DIR__ . '/../model/Task.php';

  include_once __DIR__ . "/../include/header.php";
  
  // Set up configuration file and create database
  $configFile = __DIR__ . '/../model/dbconfig.ini';
  try 
  {
      $taskDatabase = new Task($configFile);
  } 
  catch ( Exception $error ) 
  {
      echo "<h2>" . $error->getMessage() . "</h2>";
  }   

  // Check to make sure they are logged in
  if (!isUserLoggedIn())
  {
    header ('Location: login.php');
  }
   
  // If it is a GET, we are coming from view.php
  // let's figure out if we're doing update or add
  if (isset($_GET['action'])) 
  {
      $action = filter_input(INPUT_GET, 'action');
      $id = filter_input(INPUT_GET, 'id', );
      if ($action == "Update") 
      {
          $row = $taskDatabase->getTask($id);
          $title = $row['title'];
          $category = $row['category'];
          $priority = $row['priority'];
          $dueDate = $row['dueDate'];
          $notes = $row['notes'];
          $completed = $row['completed'];
      } 
      //else it is Add and the user will enter patient info
      else 
      {
        $title = "";
        $category = "";
        $priority = 0;
        $dueDate = (new DateTime('now'))->format("m/d/Y");
        $notes = "";
        $completed = 0;
      }
  } // end if GET

  // If it is a POST, we are coming from updatePatient.php
  // we need to determine action, then return to view.php
  elseif (isset($_POST['action'])) 
  {
      $action = filter_input(INPUT_POST, 'action');
      $id = filter_input(INPUT_POST, 'taskID');
      $priority = filter_input(INPUT_POST, 'priority');
      $title = filter_input(INPUT_POST, 'title');
      $category = filter_input(INPUT_POST, 'category');
      $dueDate = filter_input(INPUT_POST, 'dueDate');
      $notes = filter_input(INPUT_POST, 'notes');
      $completed = 0;
      if (isset($_POST['completed']))
        $completed = 1;
      if ($action == "Add") 
      {
        $id = $_SESSION['userID'];
        $result = $taskDatabase->addTask($id, $priority, $category, $dueDate, $title, $notes);
      } 
      elseif ($action == "Update") 
      {
          $result = $taskDatabase->updateTask($id, $priority, $category, $dueDate, $title, $notes, $completed);
      }
      // Redirect to team listing on listPatients.php
      header('Location: taskView.php');
  } // end if POST

  // If it is neither POST nor GET, we go to listPatients.php
  // This page should not be loaded directly
  else
  {
    header('Location: taskView.php');  
  }
      
?>