<?php
require 'function.php';
if(isset($_SESSION["id"])) 
{
    $id = $_SESSION["id"];
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user JOIN account USING (id_user) WHERE id_user = $id"));
}
else{
    header("Location: login.php");
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
            <a href="index.php"><h1>Cost Analysis</h1></a>
            <a href="account.php"><?php echo $user["user_fname"]?>  <?php echo $user["user_lname"]?> : <?php echo $user["balance"]?></a>
        </header>
        <hr>
        <div class="login_form">
            <form action="" method="POST">
                <input type="hidden" id="action" value="edit">
                <h2>Edit</h2>
                <ul>
                    <li>
                        <label for="">First Name</label>
                    </li>
                    <li>
                        <input type="text" name="first_name" id="first_name" value="<?php echo $user['user_fname']?>">
                    </li>
                    <li>
                        <label for="">Last Name</label>
                    </li>
                    <li>
                        <input type="text" name="last_name" id="last_name" value="<?php echo $user['user_lname']?>">
                    </li>
                    <li>
                        <label for="">Email</label>
                    </li>
                    <li>
                        <input type="email" name="email" id="email" value="<?php echo $user['email']?>">
                    </li>
                    <li>
                        <label for="">Password</label>
                    </li>
                    <li>
                        <input type="text" name="password" id="password" value="<?php echo $user['password']?>">
                    </li>
                    <li>
                        <label for="">Date</label>
                    </li>
                    <li>
                        <input type="date" name="date" id="date" value="<?php echo $user['date']?>">
                    </li>
                    <li>
                        <button type="button" class="input_submit" onclick="editAccount();">Apply</button> <br>
                        <p class="hidden" id="error">Error</p>
                    </li>
                </ul>
                <?php require 'editScript.php';?>
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