<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>firstpage</title>
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
    <!-- Navigation-->
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

    <style>
        .userconfig{
            text-align: center;
            font-size: 150%;
            line-height: 2;
            margin-top: 2%;
        }
        .changeUser:hover{
            color: #6c757d;
        }
    </style>

    <div class="userconfig">
        <a class="changeUser" href="changeUserName.php" style="text-decoration:none;">變更使用者名稱</a><br>
        <a class="changeUser" href="changeUserPassword.php" style="text-decoration:none;">變更使用者密碼</a><br>
        <a class="changeUser" href="changeGmailPassword.php" style="text-decoration:none;">變更g-mail APP密碼</a><br>
        <a class="changeUser" href="create.php" style="text-decoration:none;" target = "_block">建立管理者帳號</a><br>
        <a class="changeUser" href="../index.php" style="text-decoration:none;">登出</a>
    </div>
</body>
</html>