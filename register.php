<?php
    include_once __DIR__ . '/controllers/loginController.php';
?>
<link rel="stylesheet" href="style.css">

<div class="container">
    <?php 
        $userName = "";
        $email = "";
        $confirmEmail = "";
        if (isset($_POST["register"]))
        {
            $userName = filter_input(INPUT_POST, 'userName');
            $email = filter_input(INPUT_POST, 'email');
            $confirmEmail = filter_input(INPUT_POST, 'confirmEmail');
        }
        if ($message)
        {   ?>
            <div style="background-color: yellow; padding: 10px; border: solid 1px black;"> 
           <?php echo $message; ?>
           </div>
        <?php } ?>

    <div id="mainDiv" style="text-align: center;">
        <form method="post" action="register.php">
           
            <div class="rowContainer">
                <h3>Create Account</h3>
            </div>
            <div class="rowContainer">
                <div class="col1">User Name:</div>
                <div class="col2"><input type="text" name="userName"  required value = <?=$userName;?>></div> 
            </div>
            <div class="rowContainer">
                <div class="col1">Email:</div>
                <div class="col2"><input type="text" name="email" required value = <?=$email;?>></div> 
            </div>
            <div class="rowContainer">
                <div class="col1">Confirm Email:</div>
                <div class="col2"><input type="text" name="confirmEmail" required value = <?=$confirmEmail;?>></div> 
            </div>
            <div class="rowContainer">
                <div class="col1">Password:</div>
                <div class="col2"><input type="password" name="password"  required></div> 
            </div>
            <div class="rowContainer">
                <div class="col1">Confirm Password:</div>
                <div class="col2"><input type="password" name="confirmPassword"  required></div> 
            </div>
              <div class="rowContainer">
                <div class="col1">&nbsp;</div>
                <a href="login.php">Already a user? Click here to login</a>
                <div class="col2"><input type="submit" name="register" value="Register" class="btn btn-warning"></div> 
            </div>
            
        </form>
        
    </div>

    <?php
      include_once __DIR__ . "/controllers/footer.php";
    ?>