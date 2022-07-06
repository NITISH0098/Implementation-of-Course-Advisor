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
  <title>VERIFY COURSE ADVISOR</title>
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
  <main class=" container">
    <div class="row rowMargin">
      <div class="col">
        <span class="d-flex justify-content-center text-info display-4 " >ASSIGN COURSE ADVISORS</span>
      </div>
    </div>
    <div class="row" style="margin-bottom: 2%; margin-top: 2%">
      <div class="col-2 fontStyle">
        PROGRAM
      </div>
      <div class="col-3 fullHeight" id="ddlSelectProgram" >
     
      </div>

      <div class="col-2 fontStyle">
        SESSION 
      </div>
      <div class="col-3 fullHeight" id="ddlSelectSession" >
     
      </div>
      <button class="btn btn-info fontStyle" id="selectSem">Semester</button>
    </div>
    <div class="row" id="showSem" style="margin-bottom: 2%;padding-top:10px;">

    </div>
    <div id="showStudents";>
         
    </div>


    <nav id="pagination">
    </nav>
    <input type="hidden" name="currentpage" id="currentpage" value="1">
  </main>


  <hr class="new4">
  <div>

    <!-- JS, Popper.js, and jQuery -->
    <script src="/workspace/global/js/jquery.min.js"></script>
    <script src="/workspace/global/js/popper.min.js"></script>
    <script src="/workspace/global/js/bootstrap.min.js"></script>
    <script src="/workspace/global/js/bootstrap.min.js"></script>
    <script src="/workspace/CourseAdvisor/js/courseAdvisorJS.js"></script>
  </div>
  <div id="overlay" style="display:none;">
    <div class="spinner-border text-danger" style="width: 3rem; height: 3rem;"></div>
    <br />
    Please Wait. It might take a few minutes.
  </div>
  <input type="hidden" name="facultyId" id="facultyId" value="22">
  <input type="hidden" name="term_type" id="termYear" value="SPRING">
  <input type="hidden" name="term_year" id="termType" value="2021">
  <input type="hidden" name="program" id="programId" value="11">
  <input type="hidden" name="currentDeptId" id="currentDeptId" value="-2">
  <input type="hidden" name="studentId" id="studentId" value="-2">


</body>

</html>