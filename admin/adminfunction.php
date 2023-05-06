<?php
require '../php/config.php';

if(isset($_POST["action"])){
    if($_POST["action"] == "insertC")
    {
        insertC();
    }
    else if($_POST["action"] == "insertV")
    {
        insertV();
    }
    else if($_POST["action"] == "editOBJVenit")
    {
        editOBJVenit();
    }
    else if($_POST["action"] == "deleteOBJVenit")
    {
        deleteOBJVenit();
    }
    else if($_POST["action"] == "editOBJChelt")
    {
        editOBJchelt();
    }
    else if($_POST["action"] == "deleteOBJChelt")
    {
        deleteOBJchelt();
    }
    
}




function insertC()
{
    global $conn;
    $obj = $_POST['object'];

    if(empty($obj))
    {
        echo("Please Fill Out The Form!");
        exit;
    }

    $qwert = "INSERT INTO obj_chelt VALUES('', '$obj')";
    mysqli_query($conn, $qwert);
    echo "Insert";
}

function insertV()
{
    global $conn;
    $obj = $_POST['object'];

    if(empty($obj))
    {
        echo("Please Fill Out The Form!");
        exit;
    }

    $qwert = "INSERT INTO obj_venit VALUES('', '$obj')";
    mysqli_query($conn, $qwert);
    echo "Insert";
}

function editOBJVenit()
{
    global $conn;
    $obj = $_POST['object'];
    $id_obj = $_POST['id_obj'];

    $qwert = "UPDATE obj_venit SET obj_venit = '$obj' WHERE id_obj_venit = '$id_obj'";
    mysqli_query($conn, $qwert);
    echo "Edit";
}

function deleteOBJVenit()
{
    global $conn;
    $id_obj = $_POST['id_obj'];

    $qwert = "UPDATE venit SET id_obj_venit = 6 WHERE id_obj_venit = '$id_obj'";
    mysqli_query($conn, $qwert);
    $qwerty = "DELETE FROM obj_venit WHERE id_obj_venit = '$id_obj'";
    mysqli_query($conn, $qwerty);
    echo "Delete";
}

function editOBJChelt()
{
    global $conn;
    $obj = $_POST['object'];
    $id_obj = $_POST['id_obj'];

    $qwert = "UPDATE obj_chelt SET obj_chelt = '$obj' WHERE id_obj_chelt = '$id_obj'";
    mysqli_query($conn, $qwert);
    echo "Edit";
}

function deleteOBJChelt()
{
    global $conn;
    $id_obj = $_POST['id_obj'];

    $qwert = "UPDATE cheltuieli SET id_obj_chelt = 12 WHERE id_obj_chelt = '$id_obj'";
    mysqli_query($conn, $qwert);
    $qwerty = "DELETE FROM obj_chelt WHERE id_obj_chelt = '$id_obj'";
    mysqli_query($conn, $qwerty);
    echo "Delete";
}

