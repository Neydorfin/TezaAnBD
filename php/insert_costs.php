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
        <link href="../css/login-style.css" rel="stylesheet" type="text/css">
        <title>Cost Analysis</title>
    </head>
    <body>
        <header>
            <a href="index.php"><h1>Cost Analysis</h1></a>
            <a href="account.php"><?php echo $user["user_fname"]?>  <?php echo $user["user_lname"]?> : <?php echo $user["balance"]?></a>
        </header>
        <hr>
        <div class="login_form">
            <form action="" method="POST" >
                <input type="hidden" id="action" value="insert_cost">
                <h2>Insert</h2>
                <ul>
                    <li>
                        <label for="">Costs</label>
                    </li>
                    <li>
                        <select name="costs" id="costs">
                        <?php 
                            $sql = mysqli_query ($conn, "SELECT * FROM obj_chelt");

                            while ($result = mysqli_fetch_array($sql)){
                            echo ' <option value="'.$result['id_obj_chelt'].'">'.ucwords($result['obj_chelt']).'</option>';
                            }?>
                        </select>
                    </li>
                    <li>
                        <label for="">Sum</label>
                    </li>
                    <li>
                        <input type="text" name="sum" id="sum">
                    </li>
                    <li>
                        <label for="">Date</label>
                    </li>
                    <li>
                        <input type="date" name="date" id="date" value="<?php echo date("Y-m-d");?>">
                    </li>
                    <li>
                        <button type="button" class="input_submit" onclick="submitData();" id="submit">Insert</button>
                        <p class="hidden" id="error">Error</p>
                    </li>
                </ul>
                    <?php require 'insert.php'; ?>
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