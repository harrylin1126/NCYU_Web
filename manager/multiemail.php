<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
?>
<!DOCTYPE html>
<html>  
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
<?php
$account = $_SESSION["account"];
if (isset($_GET["lid"])) {
   $lid = $_GET["lid"]; // 取得收件地址
}
else
   $lid = "";

if (isset($_POST["Send"])) {
   include 'DBconnection.php';
   $sql = "SELECT mail_password FROM users WHERE account= '$account'";
   if ( $result = mysqli_query($conn, $sql) ){
      $row = mysqli_fetch_row($result);
      $password = $row[0];
   }
   $lid = $_POST["lesson_id"];
   $sql = "SELECT users.account
            FROM (participate INNER JOIN users on participate.user_account = users.account)
            INNER JOIN lessons on participate.lesson_id = lessons.lid
            WHERE participate.lesson_id = '$lid'";
   if ($result = mysqli_query($conn,$sql))
   {  
      $email_set = [];
      $count = 0;
      while ($row = mysqli_fetch_row($result))
      {
         array_push($email_set,[]);
         array_push($email_set[$count],$row[0]);
         $count++;
      }
   }     
   $from = $_POST["From"];
   $subject = $_POST["Subject"];
   $body = $_POST["TextBody"];
   $mail = new PHPMailer(true);
   try {
      //Server settings
      $mail->isSMTP();
      $mail->Host       = 'smtp.gmail.com';
      $mail->SMTPAuth   = true;
      $mail->Username   = $from;
      $mail->Password   = $password;
      $mail->SMTPSecure = 'ssl';    
      $mail->Port       = 465;
      
      //Recipients
      $mail->setFrom($from);
      for ($i = 0; $i<count($email_set); $i++){
         $mail->addCC($email_set[$i][0]);
      }
      

      //Content
      $mail->isHTML(true);
      $mail->Subject = $subject;
      $mail->Body    = $body;
   
      $mail->send();
      echo "郵件已經成功的寄出! <br/>";
   } catch (Exception $e) {
      //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
   }
}
?>

<form class="row g-3" action="multiemail.php" method="post">
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label">收件者</label>
    <input type="text" class="form-control" id="inputEmail4" name="To" readonly value="有參加活動的學生" >
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">寄件者</label>
    <input type="text" class="form-control" id="inputPassword4" name="From" value="<?php echo $account ?>">
  </div>
  <div class="col-12">
    <label for="inputAddress" class="form-label">主旨</label>
    <input type="text" class="form-control" id="inputAddress" name="Subject">
  </div>
  <div class="col-12">
    <label for="inputAddress2" class="form-label">郵件內容</label>
    <textarea class="form-control" id="inputAddress2" name="TextBody"></textarea>
  </div>
  <div class="col-12">
    <button type="submit" name="Send" class="btn btn-primary">寄信</button>
  </div>
</form>
</body>
</html>