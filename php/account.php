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
        <link href="../css/account-style.css" rel="stylesheet" type="text/css">
        <title>Cost Analysis</title>
    </head>
    <body>
        <header>
            <a href="index.php"><h1>Cost Analysis</h1></a>
            <a href=""><?php echo $user["user_fname"]?>  <?php echo $user["user_lname"]?> : <?php echo $user["balance"]?></a>
        </header>
        <hr>
        <?php
            $account = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user LEFT JOIN account USING (id_user) WHERE id_user = $id;"));
            $showimg = base64_encode($account['foto']);
            ?>
            <div class="content">
                <div class="foto">
                    <form action="account.php" method="POST" enctype="multipart/form-data">
                        <img src="data:image/jpeg;base64,<?=$showimg ?>" id="upl">
                        <input type="file" accept="image/*" id="my_file" style="display: none;" onchange="loadFile(event)" name="upload"s>
                        <?php
                            if(!empty($_FILES['upload']['tmp_name']))
                            {
                                $img = addslashes(file_get_contents($_FILES['upload']['tmp_name']));
                                $qwerty = "UPDATE account SET foto = '$img' WHERE id_user = '$id'";
                                mysqli_query($conn, $qwerty);
                                echo '<script>window.location="account.php"</script>';
                            }
                            ?>
                            <input type='submit' value='Upload' name='button'>
                            
                    </form>
                    </div>
                <div class="info">
                    <table>
                        <caption>User Info</caption>
                        <tr>
                            <td>First Name</td>
                            <td><?php echo $account["user_fname"]?></td>
                        </tr>
                        <tr>
                            <td>Last Name</td>
                            <td><?php echo $account["user_lname"]?></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td><?php echo $account["email"]?></td>
                        </tr>
                        <tr>
                            <td>Data of birth</td>
                            <td><?php echo $account["date"]?></td>
                        </tr>
                        <tr>
                            <td>Balance</td>
                            <td><?php echo $account["balance"]?></td>
                        </tr>
                        <tr>
                            <td class="empty"></td>
                            <td><a href="edit_acc.php"><button>Edit</button></a></td>
                        </tr>
                        <tr>
                            <td class="empty"></td>
                            <td><a href="logout.php"><button>Logout</button></a></td>
                        </tr>
                    </table>
                    
                </div>
            </div>
            <hr>
            <script src="../js/jquery-3.6.1.min.js"></script>
<script>
    $("#upl").click(function() {
        $("input[id='my_file']").click();
    });

    var loadFile = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('output');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
    };
</script>
        <footer>
            <div>
            </div>
            <p>Galinschii Ion &copy 2022</p>
        </footer>
    </body>
</html>