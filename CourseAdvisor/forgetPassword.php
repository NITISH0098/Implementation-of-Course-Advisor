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
 <div class="logoutDiv">
    <button type="button" class="btn btn-secondary" id="btnBack">&laquo;BACK</button>
 </div>
    <div class="center">
        <h1>Forget Password</h1>
        
        <div class="form" id="replace">
            <div class="txt-field">
                <input  type="text" id="txtID" required>
                <span></span>
                <label for="">Email</label>
            </div>
            <div id="overlay" style="display:none;">
             <div class="spinner-border text-danger" style="width: 3rem; height: 3rem;"></div>
               <br/>
                   Please Wait. It might take a few minutes.
              </div>
            <div class="txt-field">
                <input type="password" id="txtPassword"  required>
                <span></span>
                <label for="">OTP</label>
            </div>
            <div id="lblErrorMessage"></div> 
            <div class="loginButton">
            <input type="submit" value="Generate OTP" id="gotp">
            <input type="submit" value="Verify OTP" id="votp">
            </div>
        </div>
       
  
    </div>
    
    <script src="/workspace/global/js/jquery.min.js"></script>
    <script src="/workspace/global/js/popper.min.js"></script>
    <script src="/workspace/global/js/bootstrap.min.js"></script>
    <script src="/workspace/CourseAdvisor/js/forgetPassword.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>

</html>