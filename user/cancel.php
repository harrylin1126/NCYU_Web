<?php
session_start(); 
include('DBconnection.php');
$lid = $_GET['lid'];
$account = $_SESSION['account'];
$sql ="DELETE FROM participate WHERE lesson_id = '$lid' AND user_account = '$account'";
mysqli_query($conn, 'SET NAMES utf8'); 
if ( mysqli_query($conn, $sql) ){ // 執行SQL指令
    mysqli_close($conn); 
    echo '<script type="text/javascript">';
    echo 'function showAlertAndRedirect() {';
    echo '  alert("取消報名成功");';
    echo '  window.location.href = "apply.php";';
    echo '}';
    echo 'window.onload = showAlertAndRedirect;';
    echo '</script>';
}
else{
    die("資料庫刪除記錄失敗<br/>");
    mysqli_close($conn); 
}
?>