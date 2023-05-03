<?php

    // Load helper functions (which also starts the session) then check if user is logged in
    include_once __DIR__ . '/controllers/listController.php'; 
   // This loads HTML header and starts our session if it has not been started
   include_once __DIR__ . "/include/header.php";
?>
<link rel="stylesheet" href="style.css">
<div class="container" style = "text-align: center;">
    <h2>Agenda</h2>
        <form action="#" method="post">
            <input type="hidden" name="id" value=<?=$_SESSION["userID"]?> />
            <input type="text" name="search" style="width: 300px;" />
            <button type="submit" name="Search" style="background: hsl(206,100%,52%); color: white;">Search</button>     
        </form>  
</div>    
  <div style="background-color: #fff0cc; padding: 10px;">

  <?php
    if (sizeof($taskListing) == 0)
    {
        echo("No new tasks<br>");
    }
    else
    {
        echo(' <div class="col-sm-offset-2 col-sm-10">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th>Priority</th>
                    <th>Due Date</th>
                    <th>Task</th>
                    <th>Category</th>
                    <th>Notes</th>
                    <th>Complete</th>
                </tr>
            </thead>
            <tbody>');
        foreach ($taskListing as $row)
        {
            echo ('<tr>');
            echo('<td> <form action="updateTask.php?action=Update&id=' . $row['id'] . '" method="post">
                <button class="btn glyphicon glyphicon-pencil" type="submit"></button>
            </form>   
            </td>');
            echo('<td');
            
            switch ($row['priority'])
            {
                case 0:
                    echo(' style="background:lightblue">Low');
                    break;
                case 1:
                    echo(' style="background:yellow">Medium');
                    break;
                case 2:
                    echo(' style="background:red">High');
                    break;
                default:
                    break;
            }
            echo('</td>');
            echo('<td>' . $row['dueDate'] . ' </td>');
            echo('<td>' . $row['title'] . ' </td>');
            echo('<td>' . $row['category'] . ' </td>');
            echo('<td>' . $row['notes'] . ' </td>');
            echo('<td><input type="checkbox" ');
            if ($row['completed'] == 1)
            {
                echo('checked="checked"');
            }
            echo('/></td>');
        }
    }
    ?>
    </div>
    <form action="updateTask.php?action=Add" method="post">
        <button type="add" name="Add" style="background: hsl(206,100%,52%); color: white;">Create new task</button> 
    </form>
</body>
</html>