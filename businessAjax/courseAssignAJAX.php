<?php
$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path. "/workspace/DBHandler/DBStudentDetails.php";

 $dbo = new DBStudentDetails();
 
$action = $_REQUEST['action'];

if(!empty($action)){
    if($action == "getSessionHTML")
    {
         
        $rv = $dbo->getSessionDetails();
        echo json_encode($rv);
        exit();
    }

    if($action == "loadCoursesAndFaculty"){
        $termYear = $_POST['termYear'];
        $termType = $_POST['termType'];

        $sessionId = $dbo->getSessionID($termYear,$termType);
        if (!isset($_SESSION)) {
            session_start();
          }
          $_SESSION['sessionID'] = $sessionId;
        $getCourseAndFaculty = $dbo->getCourseAndFaculty($sessionId);
        echo json_encode($getCourseAndFaculty);
        exit();  
    }

    if($action == "allFaculty"){

        $getFaculty = $dbo->getFaculty();
        echo json_encode($getFaculty);
        exit();  
    }
    if($action == "updateFacultyCourseRelation")
    {
        $courseId = $_POST['courseID'];
        $selectedFaculties = $_POST['facultySelected'];
       // $array = json_decode(json_encode($selectedFaculties), true);
        $sessionId = $_POST['sessionId'];
        $rv = $dbo->insertFacultyCourseRelation($courseId,$selectedFaculties ,$sessionId);
        echo json_encode($rv);
        exit();
    }
    if($action == "deleteFacultyCourseRelation")
      {
          $courseId = $_POST['courseID'];
          $sessionId = $_POST['sessionId'];
          $rv = $dbo->deleteFacultyCourseRelation($courseId,$sessionId);
          echo json_encode($rv);
          exit();
      }
}
?>
