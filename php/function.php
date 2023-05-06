<?php
session_start();
  require 'config.php';

if(isset($_POST["action"])){
  if($_POST["action"] == "register"){
      register();
    }
    else if($_POST["action"] == "login"){
      login();
    }
    else if($_POST["action"] == "insert_cost"){
      insertCost();
    }
    else if($_POST["action"] == "insert_venit"){
      insertVenit();
    }
    else if($_POST["action"] == "edit"){
      editAccount();
    }
    else if($_POST["action"] == "calc"){
      calculate();
    }
    else if($_POST["action"] == "index"){
      getIndex();
    }
    else if($_POST["action"] == "deleteCalc"){
      deleteCalc();
    }
    else if($_POST["action"] == "editChelt"){
      editChelt();
    }
    else if($_POST["action"] == "editVenit"){
      editVenit();
    }
    else if($_POST["action"] == "deleteVenit"){
      deleteVenit();
    }
    else if($_POST["action"] == "deleteChelt"){
      deleteChelt();
    }
    else if($_POST["action"] == "userinfo")
    {
        userinfo();
    }
  }



function register()
{
    global $conn;
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $conf_pass = $_POST['conf_pass'];

    if(empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($conf_pass))
    {
        echo("Please Fill Out The Form!");
        exit;
    }

    if($password != $conf_pass)
    {
        echo("The passwords don't match!");
        exit;
    }

    $user = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");
    if(mysqli_num_rows($user) > 0)
    {
        echo("This email is already used");
        exit;
    }


    $query = "INSERT INTO user VALUES('', '$first_name', '$last_name', '$email', '$password')";
    mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'"));
    $id = $user['id_user'];
    echo("Register Succesful");
    $datemy = mysqli_fetch_assoc(mysqli_query($conn, "SELECT DISTINCT CONCAT(MONTHNAME(date), ' ' , YEAR(date)) AS year_and_month FROM cheltuieli ORDER BY date DESC LIMIT 1;"));
    $_SESSION["register"] = true;
    $_SESSION["id"] = $id;
    $_SESSION["i"] = 1;
    $_SESSION["mothYear"] = $datemy['year_and_month'];
}


function login()
{
    global $conn;
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(empty($email) || empty($password))
    {
        echo("Please Fill Out The Form!");
        exit;
    }
    $user = mysqli_query($conn, "SELECT * FROM user JOIN account USING (id_user) WHERE email = '$email'");
    $datemy = mysqli_fetch_assoc(mysqli_query($conn, "SELECT DISTINCT CONCAT(MONTHNAME(date), ' ' , YEAR(date)) AS year_and_month FROM cheltuieli ORDER BY date DESC LIMIT 1;"));
    
    if(mysqli_num_rows($user) > 0){

        $row = mysqli_fetch_assoc($user);
    
        if($password == $row['password']){
          $_SESSION["login"] = true;
          $_SESSION["id"] = $row["id_user"];
          $_SESSION["i"] = 1;
          $_SESSION["mothYear"] = $datemy['year_and_month'];
          if($row['admin'])
          {
            $_SESSION["id"] = $row["id_user"];
            echo("admin");
            exit;
          }
          echo "Login Successful";
        }
        else{
          echo "Wrong Password";
          exit;
        }
      } 
      else{
        echo "User Not Registered";
        exit;
      }
}

function insertCost()
  {
    global $conn;
    $id = $_SESSION["id"];
    $costs = $_POST['costs'];
    $sum = $_POST['sum'];
    $date = $_POST['date'];

    if(empty($costs) || empty($sum) || empty($date))
    {
        echo("Please Fill Out The Form!");
        exit;
    }
    $sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM cheltuieli WHERE date = '$date' and id_obj_chelt = '$costs'"));

    if(!empty($sql))
    {
      $id_chelt = $sql['id_chelt'];
      $query = "UPDATE cheltuieli SET suma = suma + '$sum' WHERE id_chelt = '$id_chelt'";
      mysqli_query($conn, $query);
      echo("Insertion Succesful");
      exit;
    }
    $query = "INSERT INTO cheltuieli VALUES('', '$id', '$costs', '$sum', '$date')";
    mysqli_query($conn, $query);
    echo("Insertion Succesful");
  }

  function insertVenit()
  {
    global $conn;
    $id = $_SESSION["id"];
    $costs = $_POST['costs'];
    $sum = $_POST['sum'];
    $date = $_POST['date'];

    if(empty($costs) || empty($sum) || empty($date))
    {
        echo("Please Fill Out The Form!");
        exit;
    }
    $sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM venit WHERE date = '$date' and id_obj_venit = '$costs'"));

    if(!empty($sql))
    {
      $id_venit = $sql['id_venit'];
      $query = "UPDATE venit SET suma = suma + '$sum' WHERE id_venit = '$id_venit'";
      mysqli_query($conn, $query);
      echo("Insertion Succesful");
      exit;
    }
    $query = "INSERT INTO venit  VALUES('', '$id', '$costs', '$sum', '$date')";
    mysqli_query($conn, $query);
    echo("Insertion Succesful");
  }


function getIndex()
{
  $i = $_POST['index'];
  $mothYear = $_POST['monthYear'];
  $_SESSION["i"] = $i;
  $_SESSION["mothYear"] = $mothYear;
  echo $mothYear, ' ', $i;
}

function editAccount()
{
  global $conn;
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $date = $_POST['date'];
  $id_user = $_SESSION["id"];
    if(empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($date))
    {
        echo("Please Fill Out The Form!");
        exit;
    }

    $query = "UPDATE user SET user_fname = '$first_name', user_lname = '$last_name', email = '$email', password = '$password' WHERE id_user = '$id_user'";
    mysqli_query($conn, $query);
    echo("Editing");
    $query = "UPDATE account SET  date = '$date' WHERE id_user = '$id_user'";
    mysqli_query($conn, $query);
    echo("Editing");
}

function calculate()
{
  global $conn;
  $id_user = $_SESSION["id"];
  $suma = $_POST['suma'];
  $percent = $_POST['percent'];
  $obj_colect = $_POST['colect'];
  
  if(empty($suma) || empty($percent) || empty($obj_colect) || empty($id_user))
  {
      exit;
  }

  $query = "INSERT INTO colect VALUES('', '$id_user', '$obj_colect', '$suma', '$percent')";
  mysqli_query($conn, $query);
  echo("Calculate");
}

function deleteCalc()
{
  global $conn;
  $id_calc = $_POST['id_colect'];
  echo($id_calc);
  if(empty( $id_calc))
  {
    exit;
  }
  $query = "DELETE FROM `colect` WHERE id_colect = $id_calc";
  mysqli_query($conn, $query);
  echo("Delete");
}

function editChelt()
{
  global $conn;
  $obj_chelt = $_POST['obj_chelt'];
  $suma = $_POST['suma'];
  $date = $_POST['date'];
  $id_chelt = $_POST['id_chelt'];
  $query = "UPDATE cheltuieli SET id_obj_chelt = $obj_chelt,suma = $suma, cheltuieli.date = '$date' WHERE id_chelt = $id_chelt";
  mysqli_query($conn, $query);
  echo("Edit");

}

function editVenit()
{
  global $conn;
  $id_venit = $_POST['id_venit'];
  $obj_venit = $_POST['obj_venit'];
  $suma = $_POST['suma'];
  $date = $_POST['date'];
  $query = "UPDATE venit SET id_obj_venit = '$obj_venit',suma = '$suma', venit.date = '$date' WHERE id_venit = '$id_venit'";
  mysqli_query($conn, $query);
  echo("Edit");
}


function deleteVenit()
{
  global $conn;
  $id_venit = $_POST['id_venit'];
  echo($id_venit);
  if(empty( $id_venit))
  {
    exit;
  }
  $query = "DELETE FROM venit WHERE id_venit = $id_venit";
  mysqli_query($conn, $query);
  echo("Delete");
}

function deleteChelt()
{
  global $conn;
  $id_chelt = $_POST['id_chelt'];
  if(empty( $id_chelt))
  {
    exit;
  }
  $query = "DELETE FROM `cheltuieli` WHERE id_chelt = $id_chelt";
  mysqli_query($conn, $query);
  echo("Delete");
}

function userinfo()
{
  $_SESSION['id_user'] = $_POST['id_user'];

  echo "userinfo";
}