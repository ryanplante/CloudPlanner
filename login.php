<?php
    include_once __DIR__ . '/controllers/loginController.php';
?>
<link rel="stylesheet" href="style.css">

<div class="container">
    <?php 
        if ($message)
        {   ?>
            <div style="background-color: yellow; padding: 10px; border: solid 1px black;"> 
           <?php echo $message; ?>
           </div>
        <?php } ?>

    <div id="mainDiv" style="text-align: center;">
        <form method="post" action="login.php">
           
            <div class="rowContainer">
                <h3>Login</h3>
            </div>
            <div class="rowContainer">
                <div class="col1">User Name:</div>
                <div class="col2"><input type="text" name="userName" value="donald"></div> 
            </div>
            <div class="rowContainer">
                <div class="col1">Password:</div>
                <div class="col2"><input type="password" name="password" value="duck"></div> 
            </div>
              <div class="rowContainer">
                <div class="col1">&nbsp;</div>
                <a href="register.php">New user? Click here</a>
                <div class="col2"><input type="submit" name="login" value="Login" class="btn btn-warning"></div> 
            </div>
            
        </form>
        
    </div>

    <?php
      include_once __DIR__ . "/controllers/footer.php";
    ?>