<?php
include ('DBconnection.php');
$account = $_POST['accounts'];

$sql = "SELECT blacklist FROM users WHERE account = '$account'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // 輸出資料每一行
    $row = $result->fetch_assoc();
    $bool= $row['blacklist'];
       
}
if ($bool == '0')
{
    $sql2 = "UPDATE users SET blacklist = 1 WHERE users.account = '$account' ";
    $conn->query($sql2);
}
else{
    $sql2 = "UPDATE users SET blacklist = 0  WHERE users.account = '$account' ";
    $conn->query($sql2);
    $sql3 = "UPDATE users SET counter = 0  WHERE users.account = '$account' ";
    $conn->query($sql3);
}
?>