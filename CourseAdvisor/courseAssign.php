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
  <title>COURSE ASSIGN</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="/workspace/global/css/style1.css">
  <link rel="stylesheet" href="/workspace/global/css/bootstrap.min.css">
  <link rel="stylesheet" href="/workspace/global/css/font-awesome.min.css">
  <link rel="stylesheet" href="/workspace/global/css/arindamNitish.css">
</head>

<body>
  <header>
  </header>
  <div class="logoutDiv">
   <button type="button" class="btn btn-secondary" id="btnBack" >&laquo;BACK</button>
    <button type="button" class="btn btn-danger" id="btnLogOut">Logout</button>
    </div>
  <main class=" container">
    <div class="row rowMargin">
      <div class="col">
        <span class="d-flex justify-content-center text-info display-4 " ><?php
                                                                print($_SESSION['dname']);
                                                                ?></span>
      </div>
    </div>
    <div class="row" style="margin-bottom: 2%; margin-top: 2%">
    <div class="col-5 fontStyle">
        SESSION 
      </div>
      <div class="col-3 fullHeight" id="SelectSession" >
     
      </div>

      <!-- <button class="btn btn-info fontStyle" id="selectSem">Semester</button> -->
    </div>

    <div class="row" id="showDetails" style="margin-bottom: 2%;padding-top:10px;">

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
    <script src="/workspace/CourseAdvisor/js/courseAssignJS.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->

    <!-- bootstrap Modal -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<!-- for multipleSelect -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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