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
        <link href="../css/login-style.css" rel="stylesheet" type="text/css">
        <title>Cost Analysis</title>
    </head>
    <body>
        <header>
            <a href="../index.html"><h1>Cost Analysis</h1></a>
            <a href="login.php"><button>Login</button></a>
        </header>
        <hr>
        <div class="login_form">
            <form action="" method="POST" >
                <input type="hidden" id="action" value="login">
                <h2>Login</h2>
                <ul>
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
                        <button type="button" class="input_submit" onclick="submitData();" id="submit">Login</button>
                        <p class="hidden" id="error">Error</p>
                    </li>
                </ul>
                <p>If don't have accaunt.
                    <a href="signUp.php" class="a_reg">Register</a>
                    <?php require 'script.php'; ?>
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