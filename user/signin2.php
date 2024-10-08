<?php
session_start();
if (isset($_POST["Insert"])) 
{
    include 'DBconnection.php';
    $signcode = $_POST["signin_code"];
    $lid = $_POST["id"];
    $userAccount =  $_SESSION['account'];
    $sql = "SELECT sign_code, begin_date, end_date from lessons WHERE lid = '$lid'";
    if (empty($signcode))
    {
        header("Location: signin.php?error=簽到碼不得為空&lessonid=$lid");
        exit();
    }
    else
    {
        if ( $result = mysqli_query($conn, $sql) ){ // 執行SQL指令
            $row = mysqli_fetch_row($result);
            $result = $row[0];
            $begin_date = $row[1];
            $end_date = $row[2];
            date_default_timezone_set('Asia/Taipei');
            $now = date('Y/m/d H:i:s');
            if(strtotime($now) <= strtotime($begin_date) || strtotime($now) >= strtotime($end_date)){
                echo '<script type="text/javascript">';
                echo 'function showAlertAndRedirect() {';
                echo '  alert("還未到課堂時間");';
                echo '  window.location.href = "apply.php";';
                echo '}';
                echo 'window.onload = showAlertAndRedirect;';
                echo '</script>';
            }
            elseif($signcode == $result)
            {   
                $sql = "UPDATE participate SET signin= 1  WHERE user_account='".$userAccount."'AND lesson_id='".$lid."'";
                mysqli_query($conn, 'SET NAMES utf8');
                mysqli_query($conn, $sql);
                echo '<script type="text/javascript">';
                echo 'function showAlertAndRedirect() {';
                echo '  alert("簽到成功");';
                echo '  window.location.href = "apply.php";';
                echo '}';
                echo 'window.onload = showAlertAndRedirect;';
                echo '</script>';
                mysqli_close($conn); 
            }
            else{
                header("Location: signin.php?error=簽到碼錯誤&lessonid=$lid");
            }
                    //exit();
        }
        else{
            die("資料庫新增記錄失敗<br/>");
            mysqli_close($conn); 
        }
    }
}
?>
