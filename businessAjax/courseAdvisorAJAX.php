<?php
$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path. "/workspace/DBHandler/DBStudentDetails.php";

$dbo = new DBStudentDetails();

$action = $_REQUEST['action'];

if ( !empty($action)) {
    if($action == "loadSemester"){
        $termYear = $_POST['termYear'];
        $termType = $_POST['termType'];
        $progId = $_POST['progId'];
        $rv = $dbo->getSemDetails($progId);
        echo json_encode($rv);
        exit();  
    }

    if($action == "getProgramHTML")
    {
        $rv = $dbo->getProgramDetails();
        echo json_encode($rv);
        exit();
    }

    if($action == "getSessionHTML")
    {
         
        $rv = $dbo->getSessionDetails();
        echo json_encode($rv);
        exit();
    }

    if($action == "loadStudent"){

        $termYear = $_POST['termYear'];
        $termType = $_POST['termType'];
        $progId = $_POST['progId'];
        $semId = $_POST['semId'];

        $sessionId = $dbo->getSessionID($termYear,$termType);
        $rv = $dbo->loadSemStudents($sessionId,$progId, $semId);
        echo json_encode($rv);
        exit(); 
    }

    // if($action == "loadFaculty"){
    //     $rv = $dbo->loadFaculty();
    //     echo json_encode($rv);
    //     exit(); 
    // }
    
    
    if($action == "onClickAccept")
     {
        $termYear = $_POST['termYear'];
        $termType = $_POST['termType'];
        $studentId = $_POST['studentId'];
        $facultyId = $_POST['facultyId'];

        if(!empty($termYear) && !empty($termType) && !empty($studentId) && !empty($facultyId))
          {
              echo json_encode(1);
          }
        else
          {
              echo json_encode(0);
          }
     }

     if($action == "onClickRemove")
     {
        $termYear = $_POST['termYear'];
        $termType = $_POST['termType'];
        $studentId = $_POST['studentId'];
        $courseId = $_POST['courseId'];

        if(!empty($termYear) && !empty($termType) && !empty($studentId) && !empty($courseId))
          {
              echo json_encode(1);
          }
        else
          {
              echo json_encode(0);
          }
     }

     if($action == "assignFaculty")
        {
            $facultyId = $_POST['facultyId'];
            $studentId = $_POST['studentId'];

           $result = $dbo->assignFaculty($facultyId,$studentId);
           echo json_encode($result);
        }
 

}
