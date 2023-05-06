<?php
require 'function.php';
if(isset($_SESSION["id"])) 
{
    $id = $_SESSION["id"];
    $mothYear = $_SESSION['mothYear'];
    $i = $_SESSION['i'];
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user JOIN account USING (id_user) WHERE id_user = $id"));
    $venit = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(suma) AS sum FROM venit WHERE id_user = $id"));
    $costs = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(suma) AS sum FROM cheltuieli WHERE id_user = $id"));
    $balance = $venit['sum'] - $costs['sum'];
    $query = "UPDATE account SET balance = $balance WHERE id_user = $id";
    mysqli_query($conn, $query);
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
        <script src="../js/plotly.min.js"></script>
        <link href="../css/main-style.css" rel="stylesheet" type="text/css">
        <title>Cost Analysis</title>
    </head>
    <body>
    <script src="../js/jquery-3.6.1.min.js"></script> 
        <header>
            <a href="index.php"><h1>Cost Analysis</h1></a>
            <a href="account.php"><?php echo $user["user_fname"]?>  <?php echo $user["user_lname"]?> : <?php echo $user["balance"]?></a>
        </header>
            <hr>
            <h1 class="cap">Costs</h1>
            <div class="month_cost">
            <table>
                <caption>
                    <?php
                        $sql = mysqli_query($conn, "SELECT DISTINCT CONCAT(MONTHNAME(date), ' ' , YEAR(date)) AS year_and_month FROM cheltuieli WHERE id_user = $id ORDER BY date;");
                        $month = [];
                        while ($result = mysqli_fetch_assoc($sql)){
                            array_push($month, $result);
                    }
                    ?>
                    <script>
                        $(document).ready(function (){
                            var month = <?php echo json_encode($month); ?>;
                            var i = <?php echo json_encode($i); ?>;
                            $(".month_label").text(month[month.length - i]['year_and_month']);
                            $('#prev').click(function(){
                                 if (i != month.length) {
                                    i++;
                                    $(".month_label").text(month[month.length - i]['year_and_month']);
                                    getIndex(month[month.length - i]['year_and_month'], i);
                                    console.log(month[month.length - i]['year_and_month'], i);
                                }
                                });
                                $('#next').click(function(){
                                if (i != 1) {
                                    i--;
                                    $(".month_label").text(month[month.length - i]['year_and_month']);
                                    console.log(month[month.length - i]['year_and_month'], i);
                                    getIndex(month[month.length - i]['year_and_month'], i);
                                }
                            });
                        });
                    </script>
                    <button id="prev">&lt</button>
                    <label for="" class="month_label" id="month_label">Month</label>
                    <button id="next">&gt</button>
                    <a href="insert_costs.php"><button class="ins">&#10010 Insert</button></a>
                </caption>
                <tr>
                    <th>Object Cost</th>
                    <th>Suma</th>
                    <th>Data</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                    <?php
                        $qwerty = "SELECT * FROM cheltuieli LEFT JOIN obj_chelt USING (id_obj_chelt) WHERE CONCAT(MONTHNAME(date), ' ' , YEAR(date)) = '$mothYear' and id_user = $id ORDER BY cheltuieli.date;";
                        $sql = mysqli_query($conn, $qwerty);
                        while ($result = mysqli_fetch_array($sql)): ?>
                        <tr>
                            <form method = 'POST'>
                                <td>
                                    <select id='obj_chelt<?php echo $result["id_chelt"]?>'><?php echo option($result['id_obj_chelt']);?></select>
                                </td>
                                <td>
                                    <input class='inpdata' type='text' id='suma<?php echo $result["id_chelt"]?>' value='<?php echo $result['suma']?>'>
                                </td>
                                <td>
                                    <input class='inpdata' type='date' id='date<?php echo $result["id_chelt"]?>' value='<?php echo $result['date']?>'>
                                </td>
                                <td>
                                    <button type='submit' class='edit' onclick='editChelt(this.id);' id = "<?php echo $result["id_chelt"]?>"> &#9998 </button>
                                </td>
                                <td>
                                    <button type='submit' class='delete' onclick='deleteChelt(this.id);'  id = "<?php echo $result["id_chelt"]?>"> &#10006</button>
                                </td>
                            </form>
                        </tr>
                        <?php endwhile;?>
                <tr>
                    <th>Total</th>
                    <?php
                        $qwerty = "SELECT SUM(suma) AS sum FROM cheltuieli WHERE id_user = $id AND CONCAT(MONTHNAME(date), ' ' , YEAR(date)) = '$mothYear';";
                        $sql = mysqli_fetch_array(mysqli_query($conn, $qwerty));
                    ?>
                    <th><?php echo $sql['sum']; ?></th>
                    <th class="empty"></th>
                </tr>
            </table>

            <div class="chart">
                <?php
                    $obj =[];
                    $sum =[];
                    $sql =mysqli_query($conn, "SELECT obj_chelt FROM cheltuieli LEFT JOIN obj_chelt USING (id_obj_chelt) WHERE id_user = $id and CONCAT(MONTHNAME(date), ' ' , YEAR(date)) = '$mothYear' GROUP BY (id_obj_chelt) ORDER BY cheltuieli.date;");
                    while($result = mysqli_fetch_column($sql)){
                        array_push($obj, ucwords($result));
                    }
                    
                    $sql =mysqli_query($conn, "SELECT SUM(suma) AS sum FROM cheltuieli WHERE id_user = $id and CONCAT(MONTHNAME(date), ' ' , YEAR(date)) = '$mothYear' GROUP BY (id_obj_chelt) ORDER BY cheltuieli.date;");
                    while($result = mysqli_fetch_column($sql)){
                        array_push($sum, $result);
                    }
                    
                ?>
                <div id="costChart" style="width:70%;height:auto;"></div>
                            
                <script>
                    var data = [{
                        values: <?php echo json_encode($sum); ?>,
                        labels: <?php echo json_encode($obj); ?>,
                        type: 'pie'
                        }];

                        var layout = {
                        paper_bgcolor: 'rgba(255, 255, 255, 0)',
                        font: {
                            family: 'Trebuchet MS, Lucida Sans Unicode, Lucida Grande, Lucida Sans, Arial, sans-serif',
                            size: 18,
                            color: '#f2f2f2'
                        }
                        };

                        Plotly.newPlot('costChart', data, layout);
                </script> 
                
            </div>
           </div>
           <hr>
           <h1 class="cap">Income</h1>
           <div class="month_venit">
            <table>
                <caption>
                    <label for="" class="month_label" id="month_label">Month</label>
                    <a href="insert_venit.php"><button class="ins">&#10010 Insert</button></a>
                </caption>
                <tr>
                    <th>Object Income</th>
                    <th>Suma</th>
                    <th>Data</th>
                    <th>Edit</th>
                    <th class='buttons'>Delete</th>
                    <?php
                        $qwerty = "SELECT * FROM venit LEFT JOIN obj_venit USING (id_obj_venit) WHERE CONCAT(MONTHNAME(date), ' ' , YEAR(date)) = '$mothYear' and id_user = $id ORDER BY venit.date;";
                        $sql = mysqli_query($conn, $qwerty);
                        while ($result = mysqli_fetch_array($sql)): ?>
                            <tr>
                                <form method = ''>
                                    <td>
                                        <select id='obj_venit<?php echo $result["id_venit"]?>'><?php echo optionV($result['id_obj_venit']);?></select>
                                    </td>
                                    <td>
                                        <input class='inpdata' type='text' id='sumaV<?php echo $result["id_venit"]?>' value='<?php echo $result['suma']?>'>
                                    </td>
                                    <td>
                                        <input class='inpdata' type='date' id='dateV<?php echo $result["id_venit"]?>' value='<?php echo $result['date']?>'>
                                    </td>
                                    <td>
                                        <button type='submit' class='edit' onclick='editVenit(this.id);' id = "<?php echo $result["id_venit"]?>"> &#9998 </button>
                                    </td>
                                    <td>
                                        <button type='submit' class='delete' onclick='deleteVenit(this.id);'  id = "<?php echo $result["id_venit"]?>"> &#10006</button>
                                    </td>
                                </form>
                            </tr>
                            <?php endwhile;?>
                </tr>
                <tr>
                    <th>Total</th>
                    <?php
                        $qwerty = "SELECT SUM(suma) AS sum FROM venit WHERE id_user = $id AND CONCAT(MONTHNAME(date), ' ' , YEAR(date)) = '$mothYear';";
                        $sql = mysqli_fetch_array(mysqli_query($conn, $qwerty));
                    ?>
                    <th><?php echo $sql['sum']; ?></th>
                    <th class="empty"></th>
                </tr>
            </table>
            <div class="chart">
                <?php
                    $obj =[];
                    $sum =[];
                    $sql =mysqli_query($conn, "SELECT obj_venit FROM venit LEFT JOIN obj_venit USING (id_obj_venit) WHERE id_user = $id and CONCAT(MONTHNAME(date), ' ' , YEAR(date)) = '$mothYear' GROUP BY (id_obj_venit) ORDER BY venit.date;");
                    while($result = mysqli_fetch_column($sql)){
                        array_push($obj, ucwords($result));
                    }
                    
                    $sql =mysqli_query($conn, "SELECT SUM(suma) AS sum FROM venit WHERE id_user = $id and CONCAT(MONTHNAME(date), ' ' , YEAR(date)) = '$mothYear' GROUP BY (id_obj_venit) ORDER BY venit.date;");
                    while($result = mysqli_fetch_column($sql)){
                        array_push($sum, $result);
                    }
                    
                ?>
                <div id="venitChart" style="width:70%;height:auto;"></div>
                            
                <script>
                    var data = [{
                        values: <?php echo json_encode($sum); ?>,
                        labels: <?php echo json_encode($obj); ?>,
                        type: 'pie'
                        }];

                        var layout = {
                        paper_bgcolor: 'rgba(255, 255, 255, 0)',
                        font: {
                            family: 'Trebuchet MS, Lucida Sans Unicode, Lucida Grande, Lucida Sans, Arial, sans-serif',
                            size: 18,
                            color: '#f2f2f2'
                        }
                        };

                        Plotly.newPlot('venitChart', data, layout);
                </script>
                
            </div>
           </div>
           <hr>
           <div class="chartCV">
                <table class="tableCalc">
                    <caption>
                        <h2>Calculate Colecting</h2>
                    </caption>
                    <tr>
                        <th>Name</th>
                        <th>Sum</th>
                        <th>Percent %</th>
                        <th>Sum / month</th>
                        <th class="buttons">Delete</th>
                    </tr>
                        <?php
                            $venit = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(suma) / COUNT(DISTINCT MONTHNAME(venit.date))  AS income FROM venit WHERE id_user = $id;"));
                            $chelt = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(suma) / COUNT(DISTINCT MONTHNAME(cheltuieli.date)) AS costs FROM cheltuieli WHERE id_user = $id;"));
                            if(!empty($venit) || !empty($chelt))
                            {
                                $sql = mysqli_query($conn, "SELECT * FROM colect WHERE id_user = $id");
                                if(!empty($sql))
                                {
                                    while($colect = mysqli_fetch_assoc($sql)):
                                        $calc = ($venit['income'] - $chelt['costs'])/100 * $colect['procent'];
                                        if($calc != 0)
                                        {
                                            $mon = $colect['suma']/$calc;
                                        }
                                        else    
                                        {
                                            $mon = $colect['suma']/1;
                                        }
                                        ?>
                                            <tr>
                                                <td><?php echo $colect['obj_colect']?></td>
                                                <td><?php echo $colect['suma']?></td>
                                                <td><?php echo $colect['procent']?></td>
                                                <td><?php echo round($calc)."/".round($mon);?></td>
                                                <td class="buttons">    
                                                    <form action="">
                                                        <button class="delete" onclick="deleteCalc(this.id);" id="<?php echo $colect['id_colect']?>">&#10006</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endwhile;
                                }
                            }
                            else
                            {
                                exit;
                            }
                        ?>
                        
                    <tr>
                        <script>
                            
                        </script>
                        <form action="">
                            <input type="hidden" id="action" value="calc">
                            <td><input type="text" id="colect"></td>
                            <td><input type="text" id="suma"></td>
                            <td><input type="text" id="percent"></td>
                            <td><button class="calc" type="button" onclick="calcCollect();">Calculate</button></td>
                            <td class="empty"></td>
                        </form>
                        <?php require 'calcScript.php'; ?>
                    </tr>
                </table>
                <?php
                    $objV =[];
                    $sumV =[];
                    $sql =mysqli_query($conn, "SELECT  MONTHNAME(venit.date) as month, SUM(suma) AS sum FROM venit WHERE id_user = $id and YEAR(date) = YEAR(NOW()) GROUP BY (month) ORDER BY MONTH(date) ASC;");
                    while($result = mysqli_fetch_assoc($sql)){
                        array_push($objV, ucwords($result['month']));
                        array_push($sumV, ucwords($result['sum']));
                    }
                    
                    $objC =[];
                    $sumC =[];
                    $sql =mysqli_query($conn, "SELECT  MONTHNAME(cheltuieli.date) as month, SUM(suma) AS sum FROM cheltuieli WHERE id_user = $id and YEAR(date) = YEAR(NOW()) GROUP BY (month) ORDER BY MONTH(date) ASC;");
                    while($result = mysqli_fetch_assoc($sql)){
                        array_push($objC, ucwords($result['month']));
                        array_push($sumC, ucwords($result['sum']));
                    }
                    
                ?>
                <div id="chartCostsTotal"></div>
                <script>
                        var costs = {
                        type: 'scatter',
                        name:"Costs",
                        x: <?php echo json_encode($objC); ?>,
                        y: <?php echo json_encode($sumC); ?>,
                        marker: {
                            color: '#FFA2C8',
                            line: {
                                width: 2.5
                            }
                        }
                        };

                        var venit = {
                        type: 'scatter',
                        name: "Income",
                        x: <?php echo json_encode($objV); ?>,
                        y: <?php echo json_encode($sumV); ?>,
                        marker: {
                            color: '#C8A2C8',
                            line: {
                                width: 2.5
                            }
                        }
                        };

                        var data = [costs , venit];

                        var layout = { 
                        title: 'Costs',
                        font: {size: 18}
                        };

                        var config = {responsive: true}


                        Plotly.newPlot('chartCostsTotal',  data, layout, config);
                </script>
                <br>
           </div>
        <hr>
        <footer>
            <div>
            </div>
            <p>Galinschii Ion &copy 2022</p>
        </footer>
</body>
</html>

<?php
function option($var)
{
    global $conn;
    $sqli = mysqli_query ($conn, "SELECT * FROM obj_chelt");
    $option = '';
    while ($resulti = mysqli_fetch_array($sqli)){
        if ($var == $resulti['id_obj_chelt']) {
            $option = $option.' <option selected value="'.$resulti['id_obj_chelt'].'">'.ucwords($resulti['obj_chelt']).'</option>';
        }
        else{
            $option = $option.' <option value="'.$resulti['id_obj_chelt'].'">'.ucwords($resulti['obj_chelt']).'</option>';
        }
    };
    return $option;
}

function optionV($var)
{
    global $conn;
    $sqli = mysqli_query ($conn, "SELECT * FROM obj_venit");
    $option = '';
    while ($resulti = mysqli_fetch_array($sqli)){
        if ($var == $resulti['id_obj_venit']) {
            $option = $option.' <option selected value="'.$resulti['id_obj_venit'].'">'.ucwords($resulti['obj_venit']).'</option>';
        }
        else{
            $option = $option.' <option value="'.$resulti['id_obj_venit'].'">'.ucwords($resulti['obj_venit']).'</option>';
        }
    };
    return $option;
}