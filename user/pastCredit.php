<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" type="text/css" />
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body>
    <nav class="navbar navbar-light bg-light static-top">
        <div class="container">
            <a  href="home.php" ><img src="assets/img/csielogo.jpg" style="height:50%;width: 50%;"></a>
            <a class="topic" href="activity.php" style="font-size: 15pt;font-weight: bold;">活動</a>
            <a class="topic" href="credit.php" style="font-size: 15pt;font-weight: bold;">微學分</a>
            <a href="userconfig.php" style="font-size: 15pt;font-weight: bold;">   
            <?php 
                include('DBconnection.php');  //這是引入剛剛寫完，用來連線的.php
                $presentuser = $_SESSION['uname'];
                echo  $presentuser ;
            ?>
            </a>
        </div>
    </nav>

    <?php
        include 'DBconnection.php';
        date_default_timezone_set('Asia/Taipei');
        $DateAndTime = date('Y-m-d');
        $show_all_credit=[];
        $sql = "SELECT lname,begin_date,introduction,place from lessons WHERE type=1 ORDER by begin_date DESC";
        if ($result = mysqli_query($conn,$sql))
        {
            $count = 0;
            while ($row = mysqli_fetch_row($result))
            {
                if (strtotime($row[1]) < strtotime($DateAndTime))
                {
                    array_push($show_all_credit,[]);
                    array_push($show_all_credit[$count],$row[0],$row[1],$row[2],$row[3]);
                    $count++;
                }
            }
        }
    ?>

    <div class="container" style="margin-top:1%;">
        <table style="border:3px #cccccc solid;" cellpadding="10" border='1'>
            <?php
                if (count($show_all_credit) == 0)
                {
                    echo "<tr>";
                    echo "<td class='col-1' style='text-align: center;'>目前沒有過往微學分課程訊息</td><br>";
                    echo "</tr>";
                }
                else
                {
                    echo "<tr>";
                    echo "<td class='col-1' style='text-align: center;'>微學分名稱</td>";
                    echo "<td class='col-1' style='text-align: center;'>開課日期時間</td>";
                    echo "<td class='col-3' style='text-align: center;'>微學分簡介</td>";
                    echo "<td class='col-1' style='text-align: center;'>開課地點</td>";
                    echo "</tr>";
                    for ($i = 0; $i<count($show_all_credit); $i++)
                    {
                        echo "<tr>";
                        echo "<td class='col-1' style='text-align: center;'>".$show_all_credit[$i][0]."</td>";
                        echo "<td class='col-1' style='text-align: center;'>".$show_all_credit[$i][1]."</td>";
                        echo "<td class='col-3' style='text-align: center;'>".$show_all_credit[$i][2]."</td>";
                        echo "<td class='col-1' style='text-align: center;'>".$show_all_credit[$i][3]."</td>";
                        echo "</tr>";
                    }
                }
            ?>
        </table>
    </div>
</body>
</html>