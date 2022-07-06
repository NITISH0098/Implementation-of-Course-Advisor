<?php
session_start();
if (!$_SESSION['set']) {
  header('location:/workspace/CourseAdvisor/login.php');
}
if(file_exists('C:\xampp\htdocs\tempPDF\tempPDF.pdf'))
      {unlink('C:\xampp\htdocs\tempPDF\tempPDF.pdf');}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>STUDENT REPORT</title>
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
  <main class=" container ">
    <!-- mainContainer makefullscreen -->
    <div class="row rowMargin">
      <div class="col">
        <span class="d-flex justify-content-center text-info display-4">STUDENT'S REPORT</span>
      </div>
    </div>
    <br>
  <div class="row" style="margin-left: 350px">
    <input class="col-sm-4" type="text"  id="rollnoID"  placeholder="Enter Enrollment No">
    <button  type="submit" class=" col-sm-2 btn btn-primary" id="btnShowPdf" style="margin-left: 20px;">Submit</button>   <div id="lblErrorMessage" style="margin-left: 20px;"> </div>
  
  </div>


    <div id="showStudentReport">
         
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
    <script src="/workspace/CourseAdvisor/js/studentReportJS.js"></script>
  </div>
  <div id="overlay" style="display:none;">
    <div class="spinner-border text-danger" style="width: 3rem; height: 3rem;"></div>
    <br />
    Please Wait. It might take a few minutes.
  </div>
  <input type="hidden" name="facultyId" id="facultyId" value="22">
  <input type="hidden" name="term_type" id="termYear" value="SPRING">
  <input type="hidden" name="term_year" id="termType" value="2021">
  <input type="hidden" name="course" id="courseId" value="48">
  <input type="hidden" name="currentDeptId" id="currentDeptId" value="-2">
  <input type="hidden" name="studentId" id="studentId" value="-2">


</body>

</html>