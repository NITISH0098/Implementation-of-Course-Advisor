<?php
$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path. "/workspace/DBHandler/DBStudentDetails.php";

$dbo = new DBStudentDetails();

$action = $_REQUEST['action'];

if ( !empty($action)) 
{
    if ( $action == "loadAssignedStudents") 
     {
        $termYear = $_POST['termYear'];
        $termType = $_POST['termType'];
        $sessionID = $dbo->getSessionID($termYear,$termType);
        $studentList = $dbo->getStudents($sessionID,$termYear,$termType);
        echo json_encode($studentList);
        exit();
     }

   
    if($action == "getStudentDetails"){

        $termYear = $_POST['termYear'];
        $termType = $_POST['termType'];
        $studentId = $_POST['studentId'];

        $sessionID = $dbo->getSessionID($termYear,$termType);
        $rv = $dbo->getCGPA($sessionID,$studentId);
        echo json_encode($rv);
        exit();
      }

    if($action == "getCompletedCourses"){
        $termYear = $_POST['termYear'];
        $termType = $_POST['termType'];
        $studentId = $_POST['studentId'];

        $sessionID = $dbo->getSessionID($termYear,$termType);
        $completedCourseList = $dbo->getCCL($sessionID,$studentId);

        echo json_encode($completedCourseList);
        exit();
     }
    
    if($action == "getUnsuccessfulCourses"){
        $termYear = $_POST['termYear'];
        $termType = $_POST['termType'];
        $studentId = $_POST['studentId'];

        $sessionID = $dbo->getSessionID($termYear,$termType);
        $UcompletedCourseList = $dbo->getUCL($sessionID,$studentId);
        echo json_encode($UcompletedCourseList);
        exit();
    }

    if($action == "getCurrentCourses"){
        $termYear = $_POST['termYear'];
        $termType = $_POST['termType'];
        $studentId = $_POST['studentId'];

        $sessionID = $dbo->getSessionID($termYear,$termType);
        $currentList = $dbo->getCL($sessionID,$studentId);

        echo json_encode($currentList);
        exit();
    }

    if($action == "getSessionHTML")
    {
         
        $rv = $dbo->getSessionDetails();
        echo json_encode($rv);
        exit();
    }

    if($action == "onClickAccept")
     {
        $termYear = $_POST['termYear'];
        $termType = $_POST['termType'];
        $studentId = $_POST['studentId'];
        $facultyId = $_POST['facultyId'];
       
        $sessionID = $dbo->getSessionID($termYear,$termType);
        $rv = $dbo->getVerified($sessionID,$studentId);
        $mail = $dbo->getSmail($studentId);
      //MAIL WILL BE SENT TO THE STUDENT FOR BEING ACCEPTED
        $receiver = $mail[0]['semail'];
        $subject = "Email Test via PHP using Localhost";
        $body = "Hi, there...This is a test email send from Localhost.";
        $sender = "From:unofficialpurpose11@gmail.com";
        if(mail($receiver, $subject, $body, $sender)){
           // echo "Email sent successfully to $receiver";
        }else{
           // echo "Sorry, failed while sending mail!";
        }
          echo json_encode($rv);
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
 

}
