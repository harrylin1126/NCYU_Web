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
        $show_all_apply=[];
        $ACCOUNT = $_SESSION['account'];
        $sql = "SELECT lessons.lname,lessons.begin_date,lessons.introduction,lessons.place,lessons.type,lessons.lid, lessons.end_date
                FROM (participate INNER JOIN users on participate.user_account = users.account)
                INNER JOIN lessons on participate.lesson_id = lessons.lid
                WHERE participate.user_account = '$ACCOUNT'
                ORDER BY type, begin_date";
        if ($result = mysqli_query($conn,$sql))
        {
            $count = 0;
            while ($row = mysqli_fetch_row($result))
            {
                if (strtotime($row[1]) >= strtotime($DateAndTime))
                {
                    array_push($show_all_apply,[]);
                    array_push($show_all_apply[$count],$row[0],$row[1],$row[2],$row[3],$row[4],$row[5], $row[6]);
                    $count++;
                }
            }
        }
    ?>
    <div class="container" style="margin-top:1%;">
        <table style="border:3px #cccccc solid;" cellpadding="10" border='1'>
            <?php
                if (count($show_all_apply) == 0)
                {
                    echo "<tr>";
                    echo "<td class='col-1' style='text-align: center;'>目前沒有報名活動或微學分</td><br>";
                    echo "</tr>";
                }
            else
            {
                echo "<tr>";
                echo "<td class='col-1' style='text-align: center;'>名稱</td>";
                echo "<td class='col-1' style='text-align: center;'>開始時間</td>";
                echo "<td class='col-1' style='text-align: center;'>結束時間</td>";
                echo "<td class='col-3' style='text-align: center;'>簡介</td>";
                echo "<td class='col-1' style='text-align: center;'>地點</td>";
                echo "<td class='col-1' style='text-align: center;'>備註</td>";
                echo "<td class='col-1' style='text-align: center;'>取消</td>";
                echo "<td class='col-1' style='text-align: center;'>點名</td>";
                echo "</tr>";
                for ($i = 0; $i<count($show_all_apply); $i++)
                {
                    if ($show_all_apply[$i][4] == 0)
                    {
                        echo "<tr>";
                        echo "<td class='col-1' style='text-align: center;'>".$show_all_apply[$i][0]."</td>";
                        echo "<td class='col-1' style='text-align: center;'>".$show_all_apply[$i][1]."</td>";
                        echo "<td class='col-1' style='text-align: center;'>".$show_all_apply[$i][6]."</td>";
                        echo "<td class='col-3' style='text-align: center;'>".$show_all_apply[$i][2]."</td>";
                        echo "<td class='col-1' style='text-align: center;'>".$show_all_apply[$i][3]."</td>";
                        echo "<td class='col-1' style='text-align: center;'>活動</td>";
                        echo "<td class='col-1' style='text-align: center;'>"."<a href=\"cancel.php?lid=".$show_all_apply[$i][5].
                        "\"style=\"text-decoration:none\">取消報名</a>"."</td>";
                        echo "<td class='col-1' style='text-align: center;'>"."<a href=\"signin.php?lessonid=".$show_all_apply[$i][5].
                        "\"style=\"text-decoration:none\">點名</a>"."</td>";
                        echo "</tr>";
                    }
                    elseif ($show_all_apply[$i][4] == 1)
                    {
                        echo "<tr>";
                        echo "<td class='col-1' style='text-align: center;'>".$show_all_apply[$i][0]."</td>";
                        echo "<td class='col-1' style='text-align: center;'>".$show_all_apply[$i][1]."</td>";
                        echo "<td class='col-1' style='text-align: center;'>".$show_all_apply[$i][6]."</td>";
                        echo "<td class='col-3' style='text-align: center;'>".$show_all_apply[$i][2]."</td>";
                        echo "<td class='col-1' style='text-align: center;'>".$show_all_apply[$i][3]."</td>";
                        echo "<td class='col-1' style='text-align: center;'>微學分</td>";
                        echo "<td class='col-1' style='text-align: center;'>"."<a href=\"cancel.php?lid=".$show_all_apply[$i][5].
                        "\"style=\"text-decoration:none\">取消報名</a>"."</td>";
                        echo "<td class='col-1' style='text-align: center;'>"."<a href=\"signin.php?lessonid=".$show_all_apply[$i][5].
                        "\"style=\"text-decoration:none\">點名</a>"."</td>";
                        echo "</tr>";
                        
                    }
                }
            }
            ?>
        </table>
    </div>
</body>
</html>