<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<title>login</title>
<link rel="stylesheet" type="text/css" href="./css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex align-items-center justify-content-center h-100">
      <div class="col-md-8 col-lg-7 col-xl-6">
      <br><br><br><br><br><br>
        <img src="./css/NCYU.png"
          class="img-fluid" alt="Phone image">
      </div>
      <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
        <form action="login.php" method="post">
          <!-- Email input -->
          <br><br><br><br><br><br><br><br>
          <div class="form-outline mb-4">
            <label class="form-label" for="form1Example13">Email address</label>
            <input type="email" name = "uname" id="form1Example13" class="form-control form-control-lg" />
            
          </div>

          <!-- Password input -->
          <div class="form-outline mb-4">
            <label class="form-label" for="form1Example23">Password</label>
            <input type="password" name = "password" id="form1Example23" class="form-control form-control-lg" /> 
          </div>
          <?php
            // index.php

            // 檢查是否存在 error 參數
            if (isset($_GET['error'])) {
                $errorMessage = $_GET['error'];
                echo '<p style="color: red;">' . htmlspecialchars($errorMessage) . '</p>';
                        }
            ?>

          <!-- Submit button -->
          <button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>
          <div>
            <a href="create.php">註冊</a>
          </div>

        </form>
      </div>
    </div>
  </div>
</section>
</body>
</html>