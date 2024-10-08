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
            border-radius: 10px;
            margin-left:1%;
            margin-top:1%;
        }
    </style>

    <input type="button" value="新增活動" onclick="location.href='AddActivity.php'" style="width:10%;"><br>

    <?php
        include 'DBconnection.php';
        date_default_timezone_set('Asia/Taipei');
        $DateAndTime = date('Y-m-d');
        $show_all_student=[];
        $lid = $_GET['lid'];
        $sql = "SELECT users.unumber, users.uname, users.grade, users.account, users.phone,participate.signin from 
                (users inner join participate on users.account = participate.user_account)
                where participate.lesson_id = '$lid'" ;
        if ($result = mysqli_query($conn,$sql))
        {
            $count = 0;
            while ($row = mysqli_fetch_row($result))
            {
                array_push($show_all_student,[]);
                array_push($show_all_student[$count],$row[0],$row[1],$row[2],$row[3], $row[4], $row[5]);
                $count++;
            }
        }
        $sql = "SELECT sign_code from lessons WHERE lid = '$lid'";
        if ($result = mysqli_query($conn,$sql)){
            $row = mysqli_fetch_row($result);
            $result = $row[0];
            echo "<div style = 'text-align: center; font-weight: bold;'>"."簽到碼：".$result."</div><br>";
        }
    ?>

    <div class="container" style="margin-top:1%;">
        <table style="border:3px #cccccc solid;" cellpadding="10" border='1'>
            <?php
                if (count($show_all_student) == 0)
                {
                    echo "<tr>";
                    echo "<td class='col-1' style='text-align: center;'>此活動尚未有人報名</td><br>";
                    echo "</tr>";
                }
            else
            {
                echo "<tr>";
                echo "<td class='col-1' style='text-align: center;border:1px #cccccc solid;'>學號</td>";
                echo "<td class='col-1' style='text-align: center;border:1px #cccccc solid;'>姓名</td>";
                echo "<td class='col-3' style='text-align: center;border:1px #cccccc solid;'>系級</td>";
                echo "<td class='col-1' style='text-align: center;border:1px #cccccc solid;'>E-mail</td>";
                echo "<td class='col-1' style='text-align: center;border:1px #cccccc solid;'>電話</td>";
                echo "<td class='col-1' style='text-align: center;border:1px #cccccc solid;'>簽到狀況</td>";
                echo "</tr>";
                for ($i = 0; $i<count($show_all_student); $i++)
                {
                    echo "<tr>";
                    echo "<td class='col-1' style='text-align: center;border:1px #cccccc solid;'>".$show_all_student[$i][0]."</td>";
                    echo "<td class='col-1' style='text-align: center;border:1px #cccccc solid;'>".$show_all_student[$i][1]."</td>";
                    echo "<td class='col-1' style='text-align: center;border:1px #cccccc solid;'>".$show_all_student[$i][2]."</td>";
                    echo "<td class='col-1' style='text-align: center;border:1px #cccccc solid;'>"."<a href=\"email.php?address=".$show_all_student[$i][3]
                        ."\"target=\" _block"."\"style=\"text-decoration:none\">".$show_all_student[$i][3]."</a>"."</td>";
                    echo "<td class='col-1' style='text-align: center;border:1px #cccccc solid;'>".$show_all_student[$i][4]."</td>";
                    if($show_all_student[$i][5] == 0){
                        echo "<td class='col-1' style='text-align: center;border:1px #cccccc solid;'>"."尚未簽到"."</td>";
                    }
                    else{
                        echo "<td class='col-1' style='text-align: center;border:1px #cccccc solid;'>"."已簽到"."</td>";
                    }
                    echo "</tr>";
                }
            }
            ?>
        </table>
    </div>
    <a href="pastActivity.php" style="text-decoration:none; margin-left: 8%;">查看過往活動</a>
</body>
</html>