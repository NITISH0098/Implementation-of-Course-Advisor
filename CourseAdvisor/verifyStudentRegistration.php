<?php
session_start();
if (!$_SESSION['set']) {
    header('location:/workspace/CourseAdvisor/login.php');
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VerifyStudentRegistration</title>
  <link rel="stylesheet" href="/workspace/global/css/style1.css">
  <link rel="stylesheet" href="/workspace/global/css/bootstrap.min.css">
  <link rel="stylesheet" href="/workspace/global/css/font-awesome.min.css">
  <link rel="stylesheet" href="/workspace/global/css/arindamNitish.css">
</head>

<body>
  <header>
  </header>
  <div class="logoutDiv">
  <button type="button" class="btn btn-secondary" id="btnBack">&laquo;BACK</button>
    <button type="button" class="btn btn-danger" id="btnLogOut">Logout</button>
  </div>
    <br>
  <main class=" container ">     <!-- mainContainer makefullscreen -->
    <div class="row rowMargin">
      <div class="col">
        <span class="d-flex justify-content-center text-info display-4">VERIFY STUDENTS COURSE REGISTRATION</span>
      </div>
    </div>
    <div class="row" style="margin-bottom: 2%; margin-top:2%">
      <div class="col-6" style="display:flex;justify-content:center" >
        SESSION 
      </div>
      <div class="col-6" id="ddlSelectSession" >
     
      </div>
    </div>
    <div class="row" style="margin-bottom: 2%;">
      <div class="col-12" id="divMainContainer">
        
      </div>
    </div>


    <nav id="pagination">
    </nav>
    <input type="hidden" name="currentpage" id="currentpage" value="1">
  </main>


 
  <div>

    <!-- JS, Popper.js, and jQuery -->
    <script src="/workspace/global/js/jquery.min.js"></script>
    <script src="/workspace/global/js/popper.min.js"></script>
    <script src="/workspace/global/js/bootstrap.min.js"></script>
    <script src="/workspace/global/js/bootstrap.min.js"></script>
    <script src="js/verifyStudentRegistrationJS.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  </div>
  <div id="overlay" style="display:none;">
    <div class="spinner-border text-danger" style="width: 3rem; height: 3rem;"></div>
    <br />
    Please Wait. It might take a few minutes.
  </div>
  <input type="hidden" name="facultyId" id="facultyId" value="22">
  <input type="hidden" name="term_type" id="termYear" value="SPRING">
  <input type="hidden" name="term_year" id="termType" value="2021">
  <input type="hidden" name="currentDeptId" id="currentDeptId" value="-2">
  <input type="hidden" name="studentId" id="studentId" value="-2">


</body>

</html>