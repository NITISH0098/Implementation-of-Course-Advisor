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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOD DASHBOARD</title>
    <link rel="stylesheet" href="/workspace/global/css/style1.css">
    <link rel="stylesheet" href="/workspace/global/css/bootstrap.min.css">
    <link rel="stylesheet" href="/workspace/global/css/font-awesome.min.css">
    <link rel="stylesheet" href="/workspace/global/css/arindamNitish.css">
</head>

<body>
    <main>
    <div class="logoutDiv">
    <button type="button" class="btn btn-secondary" id="btnBack" disabled>&laquo;BACK</button>
    <button type="button" class="btn btn-danger" id="btnLogOut">Logout</button>
    </div>
        <div class="container">
            <div class="row">
                <div class="col addPaddingSm" style="margin: auto;">
                    <div class="container">
                        <div class="row rowMargin">

                            <div class="col text-center">
                                        <h4>
                                        <span class="display-4">
                                        Welcome,
                                        <?php
                                        if (!isset($_SESSION)) {
                                            session_start();
                                        }
                                        print($_SESSION['fname'])
                                        ?>
                                        </span>
                                    </h4>
                                    <br>
                                <div class="container">
                                    <div class="row darkfont">
                                        <span class="justify-content-center " style="font-size: 20px;color:#2f3e46;">
                                            Department of :- <?php
                                                                print($_SESSION['dname']);
                                                                ?>
                                        </span>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="row">
                                    <div class="col d-flex justify-content-center colRow">
                                        <div class="Button" id="buttonGrade">
                                            <div class="text-center">
                                                COURSE & FACULTY 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col d-flex justify-content-center colRow">
                                        <div class="Button" id="buttonCourseAdvisor">
                                            <div class="text-center">
                                                COURSE ADVISOR 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col d-flex justify-content-center colRow">
                                        <div class="Button" id="buttonStudentReport">
                                            <div class="text-center">
                                                STUDENTS REPORT
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <hr class="new4">
    <div>

        <!-- JS, Popper.js, and jQuery -->
        <script src="/workspace/global/js/jquery.min.js"></script>
        <script src="/workspace/global/js/popper.min.js"></script>
        <script src="/workspace/global/js/bootstrap.min.js"></script>
        <script src="/workspace/global/js/bootstrap.min.js"></script>
        <script src="/workspace/CourseAdvisor/js/HodDashboardJS.js"></script>
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