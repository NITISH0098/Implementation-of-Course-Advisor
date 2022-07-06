<?php
$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path. "/workspace/DBHandler/DBStudentDetails.php";

$dbo = new DBStudentDetails();

$action = $_REQUEST['action'];

if ( !empty($action)){
    // if($action == "getCourses"){
    //     if(!isset($_SESSION)) 
    //     { 
    //      session_start(); 
    //    } 
    //  $fid = $_SESSION['fid'];
    //  $rv = $dbo->getCourseName($fid);
    //  echo json_encode($rv);
    //  exit();
    // }

    if($action == "getSessionHTML")
    {
         
        $rv = $dbo->getSessionDetails();
        echo json_encode($rv);
        exit();
    }

    if($action == "loadCourses"){
        if(!isset($_SESSION)){
            session_start();
        }
        $fid =$_SESSION['fid'];
        $termYear = $_POST['termYear'];
        $termType = $_POST['termType'];

        $sessionId = $dbo->getSessionID($termYear,$termType);
         $rv = $dbo->getCourseName($fid,$sessionId);
        echo json_encode($rv);
        exit();
    }

    if($action == "loadStudents"){
        $termYear = $_POST['termYear'];
        $termType = $_POST['termType'];
        $courseId = $_POST['courseId'];
        $sessionId = $dbo->getSessionID($termYear,$termType);
        $rv = $dbo->getStudentsForGrade($sessionId,$courseId);
        echo json_encode($rv);
        exit();
    }

    if($action == "assignGrade")
    {
        $grade = $_POST['grade'];
        $courseId = $_POST['courseId'];
        $studentId = $_POST['studentId'];

       $result = $dbo->assignGrade($grade,$courseId,$studentId);
       echo json_encode($result);
    }
}
?>