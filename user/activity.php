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
    <style>
        .activity_table{
            text-align: center;
        }
    </style>
    <nav class="navbar navbar-light bg-light static-top">
        <div class="container">
            <a href="home.php" ><img src="assets/img/csielogo.jpg" style="height:50%;width: 50%;"></a>
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
        $show_all_activity=[];
        $sql = "SELECT lname,begin_date,introduction,place,lid,end_date from lessons WHERE type=0 ORDER by begin_date DESC";
        if ($result = mysqli_query($conn,$sql))
        {
            $count = 0;
            while ($row = mysqli_fetch_row($result))
            {
                if (strtotime($row[1]) >= strtotime($DateAndTime))
                {
                    array_push($show_all_activity,[]);
                    array_push($show_all_activity[$count],$row[0],$row[1],$row[2],$row[3], $row[4], $row[5]);
                    $count++;
                }
            }
        }
    ?>

    <div class="container" style="margin-top:1%;">
        <table style="border:3px #cccccc solid;" cellpadding="10" border='1'>
            <?php
                if (count($show_all_activity) == 0)
                {
                    echo "<tr>";
                    echo "<td class='col-1' style='text-align: center;'>目前沒有新的活動訊息</td><br>";
                    echo "</tr>";
                }
            else
            {
                echo "<tr>";
                echo "<td class='col-1' style='text-align: center;'>活動名稱</td>";
                echo "<td class='col-1' style='text-align: center;'>活動開始時間</td>";
                echo "<td class='col-1' style='text-align: center;'>活動結束時間</td>";
                echo "<td class='col-3' style='text-align: center;'>活動簡介</td>";
                echo "<td class='col-1' style='text-align: center;'>活動地點</td>";
                echo "<td class='col-1' style='text-align: center;'>報名</td>";
                echo "</tr>";
                for ($i = 0; $i<count($show_all_activity); $i++)
                {
                    echo "<tr>";
                    echo "<td class='col-1' style='text-align: center;'>".$show_all_activity[$i][0]."</td>";
                    echo "<td class='col-1' style='text-align: center;'>".$show_all_activity[$i][1]."</td>";
                    echo "<td class='col-1' style='text-align: center;'>".$show_all_activity[$i][5]."</td>";
                    echo "<td class='col-3' style='text-align: center;'>".$show_all_activity[$i][2]."</td>";
                    echo "<td class='col-1' style='text-align: center;'>".$show_all_activity[$i][3]."</td>";
                    echo "<td class='col-1' style='text-align: center;'>"."<a href=\"signup.php?lid=".$show_all_activity[$i][4].
                    "&begin_date=".$show_all_activity[$i][1]."&end_date=".$show_all_activity[$i][5]."\"style=\"text-decoration:none\">報名</a>"."</td>";
                    echo "</tr>";
                }
            }
            ?>
        </table>
    </div>
    <a href="apply.php" style="text-decoration:none; margin-left: 8%;">查看已報名活動、微學分</a><br>
    <a href="pastActivity.php" style="text-decoration:none; margin-left: 8%;">查看過往活動</a>
</body>
</html>