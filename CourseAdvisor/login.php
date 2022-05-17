<?php
if(isset($_SESSION['set']))
  {
      if($_SESSION['loginAs']=='faculty')
        {
            header('location:/workspace/CourseAdvisor/dashboard.php');
        }
      if($_SESSION['loginAs']=='hod')
       {
        header('location:/workspace/CourseAdvisor/courseAdvisor.php');
       }
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/workspace/global/css/bootstrap.min.css">
    <link rel="stylesheet" href="/workspace/global/css/font-awesome.min.css">
    <link rel="stylesheet" href="/workspace/global/css/arindamNitish.css">
</head>

<body>
    <div class="center">
        <h1>Login</h1>
        
        <div class="form">
            <div class="txt-field">
                <input  type="text" id="txtID" required>
                <span></span>
                <label for="">Username</label>
            </div>

            <div class="txt-field">
                <input type="password" id="txtPassword" required>
                <span></span>
                <label for="">Password</label>
            </div>
            <div id="lblErrorMessage"></div> 
            <div class="loginButton">
            <input type="submit" value="HOD" id="btnLogin1">
            <input type="submit" value="FACULTY" id="btnLogin2">
            </div>
            <div class="pass" id="forgetPwd">
                Forgot Password?
            </div>
        </div>
    </div>


    <script src="/workspace/global/js/jquery.min.js"></script>
    <script src="/workspace/global/js/popper.min.js"></script>
    <script src="/workspace/global/js/bootstrap.min.js"></script>
    <script src="/workspace/CourseAdvisor/js/login.js"></script>
</body>

</html>