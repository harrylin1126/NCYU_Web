<?php
session_start(); 
include('DBconnection.php');
$lid = $_GET['lid'];
$type = $_GET['type'];
$sql ="DELETE FROM lessons WHERE lid = '$lid'";
mysqli_query($conn, 'SET NAMES utf8'); 
if ( mysqli_query($conn, $sql) ){ // 執行SQL指令
    mysqli_close($conn); 
    echo '<script type="text/javascript">';
    echo 'function showAlertAndRedirect() {';
    if($type == 1){
        echo '  alert("刪除微學程成功");';
        echo '  window.location.href = "credit.php";';
    }
    else{
        echo '  alert("刪除活動成功");';
        echo '  window.location.href = "activity.php";';
    }
    echo '}';
    echo 'window.onload = showAlertAndRedirect;';
    echo '</script>';
}
else{
    die("資料庫刪除記錄失敗<br/>");
    mysqli_close($conn); 
}
?>