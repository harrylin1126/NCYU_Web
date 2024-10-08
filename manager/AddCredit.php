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
    <?php
        if (isset($_POST["Insert"])) 
        {
            include 'DBconnection.php';
            function validate($data){
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
            $activityName = validate($_POST["activityName"]);
            $activityIntroduction = validate($_POST["activityIntroduction"]);
            $beginTime = validate($_POST["beginTime"]);
            $endTime = validate($_POST["endTime"]);
            $activityLocation = validate($_POST["activityLocation"]);
            $owner = validate($_SESSION['account']);
            $type = '1';

            if (empty($activityName)) 
            {
                header("Location: AddActivity.php?error=微學分課程名稱不得為空");
                exit();
            }
            elseif (empty($activityIntroduction))
            {
                header("Location: AddActivity.php?error=微學分課程介紹不得為空");
                exit();
            }
            elseif (empty($beginTime))
            {
                header("Location: AddActivity.php?error=微學分課程開始時間不得為空");
                exit();
            }
            elseif (empty($endTime))
            {
                header("Location: AddActivity.php?error=微學分課程結束時間不得為空");
                exit();
            }
            elseif (empty($activityLocation))
            {
                header("Location: AddActivity.php?error=微學分上課地點不得為空");
                exit();
            }
            else
            {   
                $y = 10;
                $Strings = '0123456789abcdefghijklmnopqrstuvwxyz';
                $signin_code = substr(str_shuffle($Strings), 0, $y);
                $sql = "INSERT INTO lessons ";
                $sql.= "VALUES (NULL, '";
                $sql.= $activityName."','".$activityIntroduction."','".$beginTime."','";
                $sql.= $endTime."','".$activityLocation."','".$owner."','".$type."','".$signin_code."')";

                mysqli_query($conn, 'SET NAMES utf8'); 
                if ( mysqli_query($conn, $sql) ){ // 執行SQL指令
                    mysqli_close($conn); 
                    echo '<p style="color: blue;">' . "新增活動成功" . '</p>';
                }
                else{
                    die("資料庫新增記錄失敗<br/>");
                    mysqli_close($conn); 
                }
            }
        }
    ?>

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

    <div>
        <form action="AddCredit.php" method="post">
            <div class="mb-3">
                <label for="formGroupExampleInput" class="form-label">微學分課程名稱:</label>
                <input type="text" name="activityName" id="formGroupExampleInput" class="form-control"><br>
            </div>
            <div class="mb-3">
                <label for="formGroupExampleInput" class="form-label">微學分課程簡介:</label>
                <textarea rows=3 cols=10 name="activityIntroduction" placeholder="輸入簡介" id="formGroupExampleInput" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label for="formGroupExampleInput" class="form-label">微學分課程開始日期/時間</label>
                <input type="datetime-local" name="beginTime" id="formGroupExampleInput" class="form-control"><br>
            </div>
            <div class="mb-3">
                <label for="formGroupExampleInput" class="form-label">微學分課程結束日期/時間</label>
                <input type="datetime-local" name="endTime" id="formGroupExampleInput" class="form-control"><br>
            </div>
            <div class="mb-3">
                <label for="formGroupExampleInput" class="form-label">微學分上課地點:</label>
                <input type="text" name="activityLocation" id="formGroupExampleInput" class="form-control"><br>
            </div>
            <div class="mb-3">
                <input type="submit"  class="btn btn-primary" value="送出" name="Insert">
            </div>
        </form>
    </div>
</body>
</html>