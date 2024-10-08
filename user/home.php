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
            include('DBconnection.php');  //這是引入剛剛寫完，用來連線的.php
            date_default_timezone_set('Asia/Taipei');
            $DateAndTime = date('Y-m-d');
            $show_activity = [[],[],[]]; 
            $sql1 = "SELECT lname,begin_date,introduction from lessons WHERE type=0 ORDER by begin_date DESC";
            if ($result1 = mysqli_query($conn,$sql1))
            {
                $count = 0;
                while ($row = mysqli_fetch_row($result1))
                {
                    if ($count > 2) break;
                    if (strtotime($row[1]) >= strtotime($DateAndTime))
                    {
                        array_push($show_activity[$count],$row[0],$row[1],$row[2]);
                        $count++;
                    }
                }
            }
            $show_credit = [[],[],[]];
            $sql2 = "SELECT lname,begin_date,introduction from lessons WHERE type=1 ORDER by begin_date DESC";
            if ($result2 = mysqli_query($conn,$sql2))
            {
                $count = 0;
                while ($row = mysqli_fetch_row($result2))
                {
                    if ($count > 2) break;
                    if (strtotime($row[1]) >= strtotime($DateAndTime))
                    {
                        array_push($show_credit[$count],$row[0],$row[1],$row[2]);
                        $count++;
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
                $presentuser = $_SESSION['uname'];
                echo  $presentuser ;
            ?>
            </a>
            </div>
        </nav>
        <style>
            .pressbutton{
                color: #18c0c3; 
                text-decoration:none;
            }
            .pressbutton:hover{
                color: #6c757d;
            }
        </style>
        <!-- Image Showcases-->
        <section class="showcase">
            <div class="container-fluid p-0">
                <div class="row g-0">
                    <div class="col-lg-6 order-lg-2 text-white showcase-img" style="background-image: url('assets/img/csiebuilding.jpg')"></div>
                    <div class="col-lg-6 order-lg-1 my-auto showcase-text">
                        <h2>近期活動</h2>
                        <p class="lead mb-0">
                            <table style="border:3px #cccccc solid;" cellpadding="10" border='1'>
                            <?php 
                                if ($show_activity[0] == NULL)
                                {
                                    echo "目前沒有新的活動訊息<br>";
                                }
                                else
                                {
                                    for ($i =0;$i < 3; $i++)
                                    {
                                        if ($show_activity[$i] != NULL)
                                        {
                                            echo "<tr>";
                                            echo "<td class='col-1' style='text-align: center;border:1px #cccccc solid;'>".$show_activity[$i][0]."</td>";
                                            echo "<td class='col-1' style='text-align: center;border:1px #cccccc solid;'>".$show_activity[$i][1]."</td>";
                                            echo "<td class='col-3' style='text-align: center;border:1px #cccccc solid;'>".$show_activity[$i][2]."</td>";            
                                            echo "</tr>";
                                        }
                                    } 
                                }
                            ?>
                            </table>
                        </p>
                        <a class="pressbutton" href="activity.php">活動一覽</a>
                    </div>
                </div>
                <div class="row g-0">
                    <div class="col-lg-6 text-white showcase-img" style="background-image: url('assets/img/ncyu.jpg')"></div>
                    <div class="col-lg-6 my-auto showcase-text">
                        <h2>微學分課程</h2>
                        <p class="lead mb-0">
                            <table style="border:3px #cccccc solid;" cellpadding="10" border='1'>
                            <?php 
                                if ($show_credit[0] == NULL)
                                {
                                    echo "目前沒有新的微學分課程訊息<br>";
                                }
                                else
                                {
                                    for ($i =0;$i < 3; $i++)
                                    {
                                        if ($show_credit[$i] != NULL)
                                        {
                                            echo "<tr>";
                                            echo "<td class='col-1' style='text-align: center;border:1px #cccccc solid;'>".$show_credit[$i][0]."</td>";
                                            echo "<td class='col-1' style='text-align: center;border:1px #cccccc solid;'>".$show_credit[$i][1]."</td>";
                                            echo "<td class='col-3' style='text-align: center;border:1px #cccccc solid;'>".$show_credit[$i][2]."</td>";            
                                            echo "</tr>";
                                        }
                                    } 
                                }
                            ?>
                            </table>
                        </p>
                        <a class="pressbutton" href="credit.php">微學分一覽</a>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>
