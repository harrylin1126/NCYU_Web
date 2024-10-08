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
    <?php
        if (isset($_POST["Insert"])) 
        {
            include 'DBconnection.php';
            $nameAfterChange = $_POST["nameAfterChange"];
            $userAccount =  $_SESSION['account'];
            $sql = "UPDATE users SET uname='".$nameAfterChange."' WHERE account='".$userAccount."'";
            mysqli_query($conn, 'SET NAMES utf8');
            if (empty($nameAfterChange))
            {
                header("Location: changeUserName.php?error=名稱不得為空");
                exit();
            }
            else
            {
                if ( mysqli_query($conn, $sql) ){ // 執行SQL指令
                    mysqli_close($conn); 
                    echo '<script type="text/javascript">';
                    echo 'function showAlertAndRedirect() {';
                    echo '  alert("更改名稱成功，請重新登入");';
                    echo '  window.location.href = "../index.php";';
                    echo '}';
                    echo 'window.onload = showAlertAndRedirect;';
                    echo '</script>';
                    exit();
                }
                else{
                    die("資料庫新增記錄失敗<br/>");
                    mysqli_close($conn); 
                }
            }
        }
    ?>

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
        .changeUserName{
            transform: scale(2,2);
            text-align: center;
            margin-left: 50%;
            margin-top: 5%; 
        }
    </style>

    <div class="changeUserName">
        <form action="changeUserName.php" method="post">
            <div class="col-md-6">
                <label>更改名稱:</label><br>
                <input type="text" name="nameAfterChange"><br>
            </div>
            <div class="col-md-6" style="transform: scale(0.5,0.5)">
                <input type="submit" value="送出" name="Insert">
            </div>
        </form>
    </div>

    <?php
    // 檢查是否存在 error 參數
    if (isset($_GET['error'])) {
        $errorMessage = $_GET['error'];
        echo '<br><p style="color: red;">' . htmlspecialchars($errorMessage) . '</p>';
    }
    ?>
</body>
</html>