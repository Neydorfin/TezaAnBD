<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
</style>
<table>
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
        $sql = mysqli_query($conn,"SELECT * FROM user_logs  WHERE id_user = '$id_user'");
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