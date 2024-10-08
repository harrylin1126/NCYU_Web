<?php
session_start(); 
include('DBconnection.php');
$lid = $_GET['lid'];
$begin_date = $_GET['begin_date'];
$end_date = $_GET['end_date'];
date_default_timezone_set('Asia/Taipei');
$DateAndTime = date('Y-m-d');
$account = $_SESSION['account'];
$sql = "SELECT * from participate WHERE lesson_id = '$lid' AND user_account = '$account'";
$result = mysqli_query($conn,$sql);
$sql1 = "SELECT blacklist FROM users WHERE account = '$account'";
$black = mysqli_query($conn,$sql1);
$blacklist = mysqli_fetch_row($black);
if($blacklist[0] == 1){
    echo '<script type="text/javascript">';
    echo 'function showAlertAndRedirect() {';
    echo '  alert("您在黑名單內，無法報名");';
    echo '  window.location.href = "activity.php";';
    echo '}';
    echo 'window.onload = showAlertAndRedirect;';
    echo '</script>';
    exit();
}elseif (mysqli_num_rows($result) === 1){
    echo '<script type="text/javascript">';
    echo 'function showAlertAndRedirect() {';
    echo '  alert("不得重複報名");';
    echo '  window.location.href = "activity.php";';
    echo '}';
    echo 'window.onload = showAlertAndRedirect;';
    echo '</script>';
    exit();
}
elseif(strtotime($begin_date) - 259200 <= strtotime($DateAndTime)){
    echo '<script type="text/javascript">';
    echo 'function showAlertAndRedirect() {';
    echo '  alert("報名已截止");';
    echo '  window.location.href = "activity.php";';
    echo '}';
    echo 'window.onload = showAlertAndRedirect;';
    echo '</script>';
    exit();
}

$sql = "SELECT lessons.begin_date,lessons.end_date
        FROM (participate INNER JOIN users on participate.user_account = users.account)
        INNER JOIN lessons on participate.lesson_id = lessons.lid
        WHERE participate.user_account = '$account'";
$show_date = [];
if ($result2 = mysqli_query($conn,$sql))
{   
    $count = 0;
    while ($row = mysqli_fetch_row($result2))
    {
        array_push($show_date,[]);
        array_push($show_date[$count],$row[0],$row[1]);
        $count++;
    }
}
for($i = 0; $i < count($show_date); $i++){
    if(!((strtotime($show_date[$i][0]) <= strtotime($begin_date) && (strtotime($show_date[$i][1]) <= strtotime($begin_date)))
        ||(strtotime($show_date[$i][0]) >= strtotime($end_date) && (strtotime($show_date[$i][1]) >= strtotime($end_date)))) ){
        echo '<script type="text/javascript">';
        echo 'function showAlertAndRedirect() {';
        echo '  alert("衝堂");';
        echo '  window.location.href = "activity.php";';
        echo '}';
        echo 'window.onload = showAlertAndRedirect;';
        echo '</script>';
        exit();
    }
}
$sql ="INSERT INTO participate (lesson_id, user_account, signin)";
$sql.="VALUES ('";
$sql.=$lid."','".$account."','";
$sql.='0'."')";
    
mysqli_query($conn, 'SET NAMES utf8'); 
if ( mysqli_query($conn, $sql) ){ // 執行SQL指令
    mysqli_close($conn); 
    echo '<script type="text/javascript">';
    echo 'function showAlertAndRedirect() {';
    echo '  alert("報名成功");';
    echo '  window.location.href = "activity.php";';
    echo '}';
    echo 'window.onload = showAlertAndRedirect;';
    echo '</script>';
}
else{
    die("資料庫新增記錄失敗<br/>");
    mysqli_close($conn); 
}
?>