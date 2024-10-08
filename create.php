<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>create account</title>
<link rel="stylesheet" type="text/css" href="./css/bootstrap.css">
</head>
<body>
<?php
// 是否是表單送回
if (isset($_POST["Insert"])) {
   // 開啟MySQL的資料庫連接
   include "DBconnection.php";
   function validate($data){

      $data = trim($data);

      $data = stripslashes($data);

      $data = htmlspecialchars($data);

      return $data;

   }
   $account = validate($_POST["account"]);
   $verify = explode("@",$account);
   $Password = validate($_POST["password"]);
   $checked = validate($_POST["checked"]);
   $uname = validate($_POST["Name"]);
   $unumber = validate($_POST["unumber"]);
   $grade = validate($_POST["grade"]);
   $phone = validate($_POST["phone"]);

   $sql = "SELECT * FROM users WHERE account= $account";
   
   if (empty($phone)){
      $phone = NULL;
   }
   //$result = mysqli_query($conn, $sql);
   /*if (mysqli_num_rows($result) === 1) {
      header("Location: create.php?error=Email已使用過");

      exit();
   }else*/
   if (empty($account)) {

      header("Location: create.php?error=email不得為空");

      exit();
   }elseif (empty($unumber)){
      header("Location: create.php?error=學號不得為空");

      exit();

   }elseif (empty($Password)){
      header("Location: create.php?error=密碼不得為空");

      exit();

   }elseif (empty($checked)){
      header("Location: create.php?error=確認密碼不得為空");

      exit();

   }elseif (empty($uname)){
      header("Location: create.php?error=姓名不得為空");

      exit();

   }elseif (empty($grade)){
      header("Location: create.php?error=系級不得為空");

      exit();

   }elseif ($Password != $checked){
      header("Location: create.php?error=密碼與確認密碼不同");

      exit();

   }elseif($verify[1] != "g.ncyu.edu.tw"){
      header("Location: create.php?error=需使用g.ncyu.edu.tw之電郵地址");

      exit();
   }else{
      // 建立新增記錄的SQL指令字串
      $sql ="INSERT INTO users (account, password, uname, unumber, grade, phone, permission, blacklist)";
      $sql.="VALUES ('";
      $sql.=$account."','".$Password."','";
      $sql.=$uname."','".$unumber."','";
      $sql.=$grade."','".$phone."','";
      $sql.='0'."','".'0'."')";
      //送出UTF8編碼的MySQL指令
      mysqli_query($conn, 'SET NAMES utf8'); 
      if ( mysqli_query($conn, $sql) ){ // 執行SQL指令
         mysqli_close($conn); 
         echo '<p style="color: blue;">' . "註冊成功" . '</p>';
      }
      else{
         die("資料庫新增記錄失敗<br/>");
         mysqli_close($conn); 
      }
   }

}
?>

<form class="row g-3" action="create.php" method="post">
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label">Email</label>
    <input type="email" name = "account" class="form-control" id="inputEmail4">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">學號</label>
    <input type="text" name = "unumber" class="form-control" id="inputPassword4">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">建立密碼</label>
    <input type="password" name = "password" class="form-control" id="inputPassword4">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">確認密碼</label>
    <input type="password" name = "checked" class="form-control" id="inputPassword4">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">姓名</label>
    <input type="text" name = "Name" class="form-control" id="inputPassword4">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">系級</label>
    <input type="text" name = "grade" class="form-control" id="inputPassword4">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">電話</label>
    <input type="text" name = "phone" class="form-control" id="inputPassword4">
  </div>
  <div class="col-12">
   <br>
    <input type="submit" name = "Insert" class="btn btn-primary"/>
  </div>
</form>

<?php
   // 檢查是否存在 error 參數
   if (isset($_GET['error'])) {
      $errorMessage = $_GET['error'];
      echo '<br><p style="color: red;">' . htmlspecialchars($errorMessage) . '</p>';
   }
?>
<div>
   <br><a href="index.php">回到登入頁面</a>
</div>
</body>
</html>