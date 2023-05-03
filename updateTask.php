<?php
 
 // This code runs everything the page loads
 include __DIR__ . '/controllers/updateController.php';
 
?>
   

<html lang="en">
<head>
 <title><?= $action ?> Task</title>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="style.css">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
   
<div class="container">
 <p></p>
 <form class="form-horizontal" action="updateTask.php" method="post">
 <div class="panel panel-primary">
<div class="panel-heading"><h4><?= $action; ?> Task</h4></div>
<p></p>
   <div class="form-group">
     <label class="control-label col-sm-2" for="title">Title:</label>
     <div class="col-sm-10">
       <input type="text" class="form-control" id="title" placeholder="Name of task" required name="title" value="<?= $title; ?>">
     </div>
   </div>
   <div class="form-group">
     <label class="control-label col-sm-2" for="category">Category:</label>
     <div class="col-sm-10">
       <input type="text" class="form-control" id="category" placeholder="Enter category" required name="category" value="<?= $category; ?>">
     </div>
   </div>
   <div class="form-group">
     <label class="control-label col-sm-2" for="priority">Priority:</label>
     <div class="col-sm-10">
      <select name="priority" id="priority">
        <option value="0">Low</option>
        <option value="1">Medium</option>
        <option value="2">High</option>
      </select>
</div>
</div>
      <div class="form-group">
      <label class="control-label col-sm-2" for="dueDate">Due Date:</label>
      <input type="date" style="width:60%" class="form-control" id="dueDate" name="dueDate" required value="<?php echo date("Y-m-d", strtotime($dueDate));?>">
   </div>
   <div class="form-group">
     <label class="control-label col-sm-2" for="notes">Notes:</label>
     <div class="col-sm-10">
       <input type="text" class="form-control" id="notes" placeholder="Additional notes" name="notes" value="<?= $notes; ?>">
     </div>
   </div>
   <div class="form-group">
     <label class="control-label col-sm-2" for="birth date">Completed:</label>
     <div class="col-sm-2">
       <input type="checkbox" class="form-control" id="completed" name="completed" placeholder="Completed" <?php 
       if ($completed == 1) 
       {
         echo "checked='checked'";
       }?>>
     </div>
   </div>

   <div class="form-group">        
     <div class="col-sm-offset-2 col-sm-10">
       <button type="submit" class="btn btn-default"><?php echo $action; ?> task</button>
     </div>
   </div>
   <!--Send the detauls via form in hidden attribute so that the program knows what to do with it -->
   <input type="hidden" name="action" value="<?= $action; ?>">
   <input type="hidden" name="taskID" value="<?= $id; ?>">
 </form>
 
 <div class="col-sm-offset-2 col-sm-10"><a href="./taskView.php">View tasks</a></div>
</div>
</div>

</body>
</html>