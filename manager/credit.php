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
            <a class="topic" href="ban.php" style="font-size: 15pt;font-weight: bold;">黑名單</a>
            <a href="userconfig.php" style="font-size: 15pt;font-weight: bold;">   
            <?php 
                include('DBconnection.php');  //這是引入剛剛寫完，用來連線的.php
                $presentuser = $_SESSION['uname'];
                echo  $presentuser ;
            ?>
            </a>
        </div>
    </nav>

    <style>
        input{
            border:0;
            background-color:#003C9D;
            color:#fff;
            border-radius:10px;
            margin-left:1%;
            margin-top:1%;
        }
    </style>
    <div class="try" style="style='padding-left:10px;'">
        <input type="button" value="新增微學分" onclick="location.href='AddCredit.php'" style="width:10%;"><br>
    </div>
    <?php
        include 'DBconnection.php';
        date_default_timezone_set('Asia/Taipei');
        $DateAndTime = date('Y-m-d');
        $show_all_credit=[];
        $sql = "SELECT lname,begin_date,introduction,place,lid,type from lessons WHERE type=1 ORDER by begin_date DESC";
        if ($result = mysqli_query($conn,$sql))
        {
            $count = 0;
            while ($row = mysqli_fetch_row($result))
            {
                if (strtotime($row[1]) >= strtotime($DateAndTime))
                {
                    array_push($show_all_credit,[]);
                    array_push($show_all_credit[$count],$row[0],$row[1],$row[2],$row[3],$row[4],$row[5]);
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
                    echo "<td class='col-1' style='text-align: center;'>目前沒有新的微學分課程訊息</td><br>";
                    echo "</tr>";
                }
                else
                {
                    echo "<tr>";
                    echo "<td class='col-1' style='text-align: center;border:1px #cccccc solid;'>課程名稱</td>";
                    echo "<td class='col-1' style='text-align: center;border:1px #cccccc solid;'>課程時間</td>";
                    echo "<td class='col-3' style='text-align: center;border:1px #cccccc solid;'>課程簡介</td>";
                    echo "<td class='col-1' style='text-align: center;border:1px #cccccc solid;'>地點</td>";
                    echo "<td class='col-1' style='text-align: center;border:1px #cccccc solid;'>簽到狀況</td>";
                    echo "<td class='col-1' style='text-align: center;border:1px #cccccc solid;'>寄送郵件</td>";
                    echo "<td class='col-1' style='text-align: center;border:1px #cccccc solid;'>刪除</td>";
                    echo "<td class='col-1' style='text-align: center;border:1px #cccccc solid;'>結束點名</td>";
                    echo "</tr>";
                    for ($i = 0; $i<count($show_all_credit); $i++)
                    {
                        echo "<tr>";
                        echo "<td class='col-1' style='text-align: center;border:1px #cccccc solid;'>".$show_all_credit[$i][0]."</td>";
                        echo "<td class='col-1' style='text-align: center;border:1px #cccccc solid;'>".$show_all_credit[$i][1]."</td>";
                        echo "<td class='col-3' style='text-align: center;border:1px #cccccc solid;'>".$show_all_credit[$i][2]."</td>";
                        echo "<td class='col-1' style='text-align: center;border:1px #cccccc solid;'>".$show_all_credit[$i][3]."</td>";
                        echo "<td class='col-1' style='text-align: center;border:1px #cccccc solid;'>"."<a href=\"signin.php?lid=".$show_all_credit[$i][4]
                        ."&type=".$show_all_credit[$i][5]."\"style=\"text-decoration:none\">簽到狀況</a>"."</td>";
                        echo "<td class='col-1' style='text-align: center;border:1px #cccccc solid;'>"."<a href=\"multiemail.php?lid=".$show_all_credit[$i][4]
                        ."&type=".$show_all_credit[$i][5]."\"target=\"_blank"."\"style=\"text-decoration:none\">寄信</a>"."</td>";
                        echo "<td class='col-1' style='text-align: center;border:1px #cccccc solid;'>"."<a href=\"delete.php?lid=".$show_all_credit[$i][4]
                        ."&type=".$show_all_credit[$i][5]."\"style=\"text-decoration:none\">刪除微學程</a>"."</td>";
                        echo "<td class='col-1' style='text-align: center;border:1px #cccccc solid;'><a href=./unsigncre.php?var=".$show_all_credit[$i][4]." style='text-decoration:none;'    id='disableLink'>結束點名</a></td>";
                       
                        echo "</tr>";
                    }
                }
            ?>
            
    

        </table>
    </div>
    <a href="pastCredit.php" style="text-decoration:none; margin-left: 8%;">查看過往微學分</a>
</body>
</html>