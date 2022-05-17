<?php
$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path. "/workspace/DBHandler/DBStudentDetails.php";

$dbo = new DBStudentDetails();

$action = $_REQUEST['action'];

if ( !empty($action)){
    if($action == "getCourses"){
        if(!isset($_SESSION)) 
        { 
         session_start(); 
       } 
     $fid = $_SESSION['fid'];
     $rv = $dbo->getCourseName($fid);
     echo json_encode($rv);
     exit();
    }

    if($action == "getSessionHTML1")
    {
         
        $rv = $dbo->getSessionDetails();
        echo json_encode($rv);
        exit();
    }
    if($action == "loadStudent"){
        $termYear = $_POST['termYear'];
        $termType = $_POST['termType'];
        $courseId = $_POST['courseId'];

        $sessionId = $dbo->getSessionID($termYear,$termType);
         $rv = $dbo->getStudentCourse($sessionId,$courseId);
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