<?php
require '../php/function.php';
if(isset($_SESSION["id"])) 
{
    $id = $_SESSION["id"];
    $id_user = $_SESSION['id_user'];
    $admin = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user JOIN account USING (id_user) WHERE id_user = $id"));
	$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user JOIN account USING (id_user) WHERE id_user = '$id_user'"));

    if($admin['admin']==0)
    {
        header("Location: ../php/logout.php");
    }
}
else{
    header("Location: ../php/login.php");
  }
?>
