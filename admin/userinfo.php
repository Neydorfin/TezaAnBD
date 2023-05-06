<?php 
    require "log.php";
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
        <h2>Info about <?php echo $user['user_fname'], " ", $user['user_lname'] ?></h2>
            <table>
                <caption><h2>LAST 15 ACTION</h2></caption>
                <tr>
                    <th>Id</th>
                    <th>Object</th>
                    <th>New Suma</th>
                    <th>New Date</th>
                    <th>Old Suma</th>
                    <th>Old Data</th>
                    <th>Action</th>
                </tr>
                <?php
                    $sql = mysqli_query($conn,"SELECT * FROM (SELECT * FROM user_logs  WHERE id_user = '$id_user' ORDER BY id_log DESC LIMIT 15) t1 ORDER BY t1.id_log ASC");
                    while($log = mysqli_fetch_assoc($sql)):?>
                <tr>
                    <td><?php echo $log['id_log'];?></td>
                    <td><?php echo $log['object'];?></td>
                    <td><?php echo $log['new_suma'];?></td>
                    <td><?php echo $log['new_date'];?></td>
                    <td><?php echo $log['old_suma'];?></td>
                    <td><?php echo $log['old_date'];?></td>
                    <td><?php echo $log['action'];?></td>
                </tr>
            <?php endwhile;?>
            </table>
            <div class="btn-con">
                <a href="export_data.php">
                <button type="submit" class="download" id="<?php echo $id_user;?>" onclick="export_log(this.id);">Download Full Logs of user <?php echo $user['user_fname'], " ", $user['user_lname'] ?></button>
                </a>
            </div>
        <hr>
        <footer>
            <div>
            </div>
            <p>Galinschii Ion &copy 2022</p>
        </footer>
        <?php require "scripts.php"?>
    </body>
</html>