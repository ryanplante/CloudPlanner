<?php

    // Load helper functions (which also starts the session) then check if user is logged in
    include_once __DIR__ . '/../include/functions.php'; 
    if (!isUserLoggedIn())
    {
        header ('Location: login.php');
    }
    // include task search class
    include_once __DIR__ . '/../model/TaskSearcher.php';

    // Set up configuration file and create database
    $configFile = __DIR__ . '/../model/dbconfig.ini';
    try 
    {
        $taskDatabase = new TaskSearcher($configFile);
    } 
    catch ( Exception $error ) 
    {
        echo "<h2>" . $error->getMessage() . "</h2>";
    }   
    // If POST, delete the requested task before listing all tasks
    $taskListing = [];
    $id = $_SESSION["userID"];
    // If POST & SEARCH, only fetch the specified tasks       
    if (isset($_POST["Search"]))
    {
        $title = $_POST["search"];
        $taskListing = $taskDatabase->searchTasks($title, $id);
    }
    // Else just fetch all tasks
    else
    {
        $taskListing = $taskDatabase->getUserTasks($id);
    }