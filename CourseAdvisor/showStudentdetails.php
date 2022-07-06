<?php
session_start();
if (!$_SESSION['set']) {
  header('location:/workspace/CourseAdvisor/login.php');
}
header("refresh");
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <!-- FOR AUTO REFRESH THE PAGE ONLY ONCE -->
<script type='text/javascript'>

(function()
{
  if( window.localStorage )
  {
    if( !localStorage.getItem('firstLoad') )
    {
      localStorage['firstLoad'] = true;
      window.location.reload();
    }  
    else
      localStorage.removeItem('firstLoad');
  }
})();

</script>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <meta http-equiv="refresh" content="1"> -->
  <title>SHOW STUDENT DETAILS</title>
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
  <!-- mainContainer makefullscreen -->

  <div class="row rowMargin">
    <div class="col text-center text-info display-4">
      <span>
        Details of
        <?php if (!isset($_SESSION)) {
          session_start();
        }
        echo ($_SESSION['studentName']) ?></span>
    </div>
  </div>
  <div class="row">
    <div class="col text-center" style="font-size: 20px;">
      <span>
        Selected Session:
        <?php
        if (!isset($_SESSION)) {
          session_start();
        }
        echo ($_SESSION['termYear']);
        echo (" ");
        echo ($_SESSION['termType']);
        ?>
      </span>
    </div>
  </div>
  <br>
  <div class="wrapper" style="margin-left: 2%; margin-right:8%">
    <div class="row">
      <div class="col-xl-4 col-md-3">
        <aside>
          <div id="sidebar" class="nav-collapse">
            <!-- sidebar menu start-->
            <ul class="sidebar-menu" id="nav-accordion">
              <li class="Statistics">
                <div>
                  <span>Student Statistics</span>
                </div>
              </li>
              <li class="CompletedCourse">
                <div>
                  <span>Completed Courses</span>
                </div>
              </li>
              <li class="IncompletedCourses">
                <div>
                  <span>Incompleted Courses</span>
                </div>
              </li>
              <li class="CurrentCourses">
                <div>
                  <span>Current Courses</span>
                </div>
              </li>
              </li>
            </ul>
            <!-- sidebar menu end-->
          </div>
        </aside>
      </div>
      <div class="col-xl-8 col-md-9 mainContent">

      </div>
    </div>
  </div>
  <!-- <nav id="pagination">
    </nav>
    <input type="hidden" name="currentpage" id="currentpage" value="1"> -->




  <div>
    <!-- JS, Popper.js, and jQuery -->
    <script src="/workspace/global/js/jquery.min.js"></script>
    <script src="/workspace/global/js/popper.min.js"></script>
    <script src="/workspace/global/js/bootstrap.min.js"></script>
    <script src="/workspace/global/js/bootstrap.min.js"></script>
    <script src="js/showStudentdetailsJS.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  </div>
  <div id="overlay" style="display:none;">
    <div class="spinner-border text-danger" style="width: 3rem; height: 3rem;"></div>
    <br />
    Please Wait. It might take a few minutes.
  </div>
  <input type="hidden" name="facultyId" id="facultyId" value=<?php
                                                            if (!isset($_SESSION)) {
                                                              session_start();
                                                            }
                                                            echo ($_SESSION['fid']);
                                                            ?>>
  <input type="hidden" name="sessionID" id="sessionID" value=<?php
                                                            if (!isset($_SESSION)) {
                                                              session_start();
                                                            }
                                                            echo ($_SESSION['sessionID']);
                                                            ?>>
  <input type="hidden" name="term_type" id="termType" value=<?php
                                                            if (!isset($_SESSION)) {
                                                              session_start();
                                                            }
                                                            echo ($_SESSION['termType']);
                                                            ?>>
  <input type="hidden" name="term_year" id="termYear" value=<?php
                                                            if (!isset($_SESSION)) {
                                                              session_start();
                                                            }
                                                            echo ($_SESSION['termYear']);
                                                            ?>>
  <input type="hidden" name="studentName" id="studentName" value=<?php
                                                                  if (!isset($_SESSION)) {
                                                                    session_start();
                                                                  }
                                                                  echo ($_SESSION['studentName']);
                                                                  ?>>
  <input type="hidden" name="studentId" id="studentId" value=<?php
                                                              if (!isset($_SESSION)) {
                                                                session_start();
                                                              }
                                                              echo ($_SESSION['studentId']);
                                                              ?>>


</body>

</html>