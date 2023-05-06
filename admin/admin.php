<?php
require '../php/function.php';
if(isset($_SESSION["id"])) 
{
    $id = $_SESSION["id"];
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user JOIN account USING (id_user) WHERE id_user = $id"));
    if($user['admin']==0)
    {
        header("Location: ../php/logout.php");
    }
}
else{
    header("Location: ../php/login.php");
  }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="../image/icon.png" type="image/x-icon">
        <link href="../css/admin-style.css" rel="stylesheet" type="text/css">
        <title>Cost Analysis</title>
    </head>
    <body>
        <header>
            <a href="admin.php"><h1>Cost Analysis</h1></a>
            <a href="../php/logout.php">Logout</a>
        </header>
        <hr>
        <h2>Hello <?php echo $user['user_fname'] ?> </h2>
        <?php 
            $sql = mysqli_query($conn,"SELECT * FROM `user` JOIN account USING (id_user) ORDER BY id_user;");
        ?>
        <table>
            <caption><h3>USERS</h3></caption>
            <tr>
                <th>Id User</th>
                <th>First name</th>
                <th>Last name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Date</th>
                <th>Balance</th>
            </tr>
            <?php while($users = mysqli_fetch_assoc($sql)):?>
                <tr>
                    <td><?php echo $users['id_user'] ?></td>
                    <td><?php echo $users['user_fname'] ?></td>
                    <td><?php echo $users['user_lname'] ?></td>
                    <td><button type="button" class="user" id="<?php echo $users['id_user'] ?>" onclick="userinfo(this.id);"><?php echo $users['email'] ?></button></td>
                    <td><?php echo $users['password'] ?></td>
                    <td><?php echo $users['date'] ?></td>
                    <td><?php echo $users['balance'] ?></td>
                </tr>

            <?php endwhile;?>
        </table>
        

        <table>
            <caption>
                <h3>Costs</h3>
            </caption>
            <tr>
                <th>Id</th>
                <th>Object</th>
                <th>Edit</th>
                <th>Remove</th>
            </tr>
            <?php 
                $sql = mysqli_query($conn,"SELECT * FROM obj_chelt WHERE id_obj_chelt != 12");
                while($obj = mysqli_fetch_assoc($sql)):?>
                <tr>
                    <form method="POST">
                        <td>
                            <?php echo $obj['id_obj_chelt']?>
                        </td>
                        <td>
                            <input type="text" id="chelt<?php echo $obj["id_obj_chelt"]?>" value="<?php echo $obj['obj_chelt'] ?>">
                        </td>
                        <td>
                            <button type='submit' class='edit' onclick='editOBJChelt(this.id);' id = "<?php echo $obj["id_obj_chelt"]?>"> &#9998 </button>
                        </td>
                        <td>
                            <button type='submit' class='delete' onclick='deleteOBJChelt(this.id);' id = "<?php echo $obj["id_obj_chelt"]?>"> &#10006</button>
                        </td>
                    </form>
                </tr>
                <?php endwhile;
                $sql = mysqli_query($conn,"SELECT * FROM obj_chelt WHERE id_obj_chelt = 12");
                $obj = mysqli_fetch_assoc($sql)
                ?>
                 <tr>
                    <td>
                        <?php echo $obj['id_obj_chelt'] ?>
                    </td>
                    <td>
                        <?php echo $obj['obj_chelt'] ?>
                    </td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <form method="POST" action="">
                        <td></td>
                        <td><input class="insert" type="text" id="insertC"></td>
                        <td><button type='button' onclick="insetOBJchelt();" id="submit">Insert</button></td>
                    </form>
                </tr>
        </table>

        <table>
            <caption>
                <h3>Income</h3>
            </caption>
            <tr>
                <th>Id</th>
                <th>Object</th>
                <th>Edit</th>
                <th>Remove</th>
            </tr>
            <?php 
                $sql = mysqli_query($conn,"SELECT * FROM obj_venit WHERE id_obj_venit != 6");
                while($obj = mysqli_fetch_assoc($sql)):?>
                <tr>
                    <form method="POST">
                        <td>
                            <?php echo $obj['id_obj_venit'] ?>
                        </td>
                        <td>
                            <input type="text" id="venit<?php echo $obj["id_obj_venit"]?>" value="<?php echo $obj['obj_venit'] ?>">
                        </td>
                        <td>
                            <button type='button' class='edit' onclick='editOBJVenit(this.id);' id = "<?php echo $obj["id_obj_venit"]?>"> &#9998 </button>
                        </td>
                        <td>
                            <button type='button' class='delete' onclick='deleteOBJVenit(this.id);' id = "<?php echo $obj["id_obj_venit"]?>"> &#10006</button>
                        </td>
                    </form>
                </tr>
            <?php endwhile;
                $sql = mysqli_query($conn,"SELECT * FROM obj_venit WHERE id_obj_venit = 6");
                $obj = mysqli_fetch_assoc($sql)
            ?>
                
                <tr>
                    <td>
                        <?php echo $obj['id_obj_venit'] ?>
                    </td>
                    <td>
                        <?php echo $obj['obj_venit'] ?>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <form method="POST" action="">
                        <td></td>
                        <td><input class="insert" type="text" id="insertV"></td>
                        <td><button type='button' onclick="insetOBJvenit();" id="submit">Insert</button></td>
                    </form>
                </tr>
        </table>
        <hr>
        <footer>
            <div>
            </div>
            <p>Galinschii Ion &copy 2022</p>
        </footer>
        <?php require "scripts.php"?>
    </body>
</html>