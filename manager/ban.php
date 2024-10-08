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
    <input type="button" value="黑名單更新" onclick="location.href='blackedit.php'" style="width:10%;"><br>
    
    <?php
    $sql = "SELECT * FROM users WHERE blacklist = 1 ";
    $result = $conn->query($sql);
    echo "<h2 style= 'text-align: center;'>黑名單一覽</h2>";
    echo "<table class='black-table' style='width: 75%; margin: 0 auto;' border='1'>";
    echo "<colgroup>";
    echo "<col style='width: 20%;'>"; // 三個欄位均分 75% 的寬度
    echo "<col style='width: 60%;'>";
    echo "<col style='width: 20%;'>";
    echo "</colgroup>";
    echo "<tr><th style='font-size: 20px; border: 1px solid black;'>使用者名稱</th>";
    echo "    <th style='font-size: 20px; border: 1px solid black;'>Email</th>";
    echo "    <th style='font-size: 20px; border: 1px solid black;'>系級</th></tr>";

    if ($result->num_rows > 0) {
       
        
        
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td style='border: 1px solid black;'>" . $row["uname"] . "</td>"; // 假設欄位為 username，根據你的資料庫欄位調整
            echo "<td style='border: 1px solid black;'>" . $row["account"] . "</td>"; // 假設欄位為 email，根據你的資料庫欄位調整
            echo "<td style='border: 1px solid black;'>" . $row["grade"] . "</td>"; // 假設欄位為 other_info，根據你的資料庫欄位調整
            echo "</tr>";
        }
        echo "</table>";
    } 
   
        
    ?>
    
    

</body>
</html>