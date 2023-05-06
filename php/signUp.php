<?php
require 'function.php';
if(isset($_SESSION["id"])){
  header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="../image/icon.png" type="image/x-icon">
        <link href="../css/signUp-style.css" rel="stylesheet" type="text/css">
        <title>Cost Analysis</title>
    </head>
    <body>
        <header>
            <a href="../index.html"><h1>Cost Analysis</h1></a>
            <a href="login.php"><button>Login</button></a>
        </header>
        <hr>
        <div class="login_form">
            <form action="" method="POST">
                <input type="hidden" id="action" value="register">
                <h2>Sign Up</h2>
                <ul>
                    <li>
                        <label for="">First Name</label>
                    </li>
                    <li>
                        <input type="text" name="first_name" id="first_name">
                    </li>
                    <li>
                        <label for="">Last Name</label>
                    </li>
                    <li>
                        <input type="text" name="last_name" id="last_name">
                    </li>
                    <li>
                        <label for="">Email</label>
                    </li>
                    <li>
                        <input type="email" name="email" id="email">
                    </li>
                    <li>
                        <label for="">Password</label>
                    </li>
                    <li>
                        <input type="password" name="password" id="password">
                    </li>
                    <li>
                        <label for="">Confirm Password</label>
                    </li>
                    <li>
                        <input type="password" name="conf_pass" id="conf_pass">
                    </li>
                    <li>
                        <button type="button" class="input_submit" onclick="submitData();">Sign Up</button> <br>
                        <p class="hidden" id="error">Error</p>
                    </li>
                </ul>
                <p>If you already have accaunt.
                    <a href="login.php" class="a_reg">Login</a>
                    <?php require 'script.php';?>
                </p>
            </form>
        </div>
        <hr>
        <footer>
            <div>
            </div>
            <p>Galinschii Ion &copy 2022</p>
        </footer>
    </body>
</html>