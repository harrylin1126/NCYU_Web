<?php 

session_start(); 

include "DBconnection.php";

if (isset($_POST['uname']) && isset($_POST['password'])) {

    function validate($data){

       $data = trim($data);

       $data = stripslashes($data);

       $data = htmlspecialchars($data);

       return $data;

    }

    $uname = validate($_POST['uname']);

    $pass = validate($_POST['password']);

    if (empty($uname)) {

        header("Location: index.php?error=使用者名稱不得為空");

        exit();

    }else if(empty($pass)){

        header("Location: index.php?error=密碼不得為空");

        exit();

    }else{

        $sql = "SELECT * FROM users WHERE account='$uname' AND password='$pass'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {

            $row = mysqli_fetch_assoc($result);

            if ($row['account'] === $uname && $row['password'] === $pass) {

                $_SESSION['account'] = $row['account'];

                $_SESSION['uname'] = $row['uname'];

                if ($row['permission'] === '1'){

                    header("Location: ./manager/home.php");
                } else{
                    header("Location: ./user/home.php");
                }

                exit();

            }else{

                header("Location: index.php?error=使用者名稱或密碼錯誤");

                exit();

            }

        }else{

            header("Location: index.php?error=使用者名稱或密碼錯誤");

            exit();

        }

    }

}else{

    header("Location: index.php");

    exit();

}