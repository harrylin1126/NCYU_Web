

<?php
if(isset($_GET['var'])) {
    $receivedVar = $_GET['var'];
    // 使用 $receivedVar 做您需要的操作
  
} else {
    echo "未收到变量值";
}
 include('DBconnection.php');
 $sql = "SELECT user_account FROM participate WHERE lesson_id = $receivedVar AND signin = 0";

 $result = $conn->query($sql);
 if ($result->num_rows > 0) {
    
        
        
    while($row = $result->fetch_assoc()) {
       $user_account = $row["user_account"]; 
       $counter_sql= "SELECT counter FROM users WHERE account = '$user_account' ";
       $count_result = $conn->query($counter_sql);
       if ($count_result->num_rows > 0) {

       }
        while ($count_row = $count_result->fetch_assoc()) {
            $counter = $count_row["counter"];
            $counter = $counter+1;
            $update_sql = "UPDATE users SET counter = $counter WHERE account = '$user_account'";
            $conn->query($update_sql);
            $update_signin = "UPDATE participate SET signin = 2 WHERE lesson_id = $receivedVar AND user_account = '$user_account'";
            $conn->query($update_signin);
        }
        
    }
    
}

?>

<?php
include('DBconnection.php');
$blacklistupdate = "UPDATE users SET blacklist = 1 WHERE counter >= 3";
$conn->query($blacklistupdate);
?>


<script>
    alert("已結束點名");
    window.location.href = "activity.php";
</script>

