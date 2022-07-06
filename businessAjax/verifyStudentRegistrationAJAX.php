<?php
$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path . "/workspace/DBHandler/DBStudentDetails.php";

$dbo = new DBStudentDetails();

$action = $_REQUEST['action'];

if (!empty($action)) {
  if ($action == "setSessionVariable") {
    $termYear = $_POST['termYear'];
    $termType = $_POST['termType'];
    $studentId = $_POST['studentId'];
    $studentName = $_POST['studentName'];

    if (!isset($_SESSION)) {
      session_start();
    }
    $_SESSION['termYear'] = $termYear;
    $_SESSION['termType'] = $termType;
    $_SESSION['studentId'] = $studentId;
    $_SESSION['studentName'] = $studentName;
    echo json_encode($studentName);
    exit();
  }
  if ($action == "loadAssignedStudents") {
    $termYear = $_POST['termYear'];
    $termType = $_POST['termType'];

    $sessionID = $dbo->getSessionID($termYear, $termType);
    if (!isset($_SESSION)) {
      session_start();
    }
    $_SESSION['sessionID'] = $sessionID;
    $studentList = $dbo->getStudents($sessionID, $termYear, $termType);
    echo json_encode($studentList);
    exit();
  }


  if ($action == "getStudentDetails") {

    $termYear = $_POST['termYear'];
    $termType = $_POST['termType'];
    $studentId = $_POST['studentId'];

    $sessionID = $dbo->getSessionID($termYear, $termType);
    $rv = $dbo->getCGPA($sessionID, $studentId);
    echo json_encode($rv);
    exit();
  }

  if ($action == "getCompletedCourses") {
    $termYear = $_POST['termYear'];
    $termType = $_POST['termType'];
    $studentId = $_POST['studentId'];

    $sessionID = $dbo->getSessionID($termYear, $termType);
    $completedCourseList = $dbo->getCCL($sessionID, $studentId);

    echo json_encode($completedCourseList);
    exit();
  }

  if ($action == "getUnsuccessfulCourses") {
    $termYear = $_POST['termYear'];
    $termType = $_POST['termType'];
    $studentId = $_POST['studentId'];

    $sessionID = $dbo->getSessionID($termYear, $termType);
    $UcompletedCourseList = $dbo->getUCL($sessionID, $studentId);
    echo json_encode($UcompletedCourseList);
    exit();
  }

  if ($action == "getCurrentCourses") {
    $termYear = $_POST['termYear'];
    $termType = $_POST['termType'];
    $studentId = $_POST['studentId'];
    $recSessionID = $_POST['recSessionID'];

    $sessionID = $dbo->getSessionID($termYear, $termType);
    $currentList = $dbo->getCL($sessionID, $studentId,$recSessionID);
    echo json_encode($currentList);
    exit();
  }

  if ($action == "getSessionHTML") {

    $rv = $dbo->getSessionDetails();
    echo json_encode($rv);
    exit();
  }

  if ($action == "onClickAccept") {
    $termYear = $_POST['termYear'];
    $termType = $_POST['termType'];
    $studentId = $_POST['studentId'];
    $facultyId = $_POST['facultyId'];

    $sessionID = $dbo->getSessionID($termYear, $termType);
    $rv = $dbo->getVerified($sessionID, $studentId);
    $mail = $dbo->getSmail($studentId,$facultyId);
    //MAIL WILL BE SENT TO THE STUDENT FOR BEING ACCEPTED
    $receiver = $mail['semail'];
    $fname = $mail['fname'];
    $email = $mail['femail'];
    $subject = "COURSE ACCEPTED";
    $body = "YOUR COURSES ARE ACCEPTED BY THE '" . $fname. "', CONTACT AT '" . $email. "' FOR MORE DETAILS";
    $sender = "From:unofficialpurpose11@gmail.com";
    if (mail($receiver, $subject, $body, $sender)) {
       $msg= "Email sent successfully to $receiver";
    } else {
      $msg= "Sorry, failed while sending mail!";
    }
    echo json_encode($msg);
  }

  if ($action == "onClickRemove") {
    $termYear = $_POST['termYear'];
    $termType = $_POST['termType'];
    $studentId = $_POST['studentId'];
    $courseId = $_POST['courseId'];

    $removeCourseList = $dbo->removeCourses($studentId,$courseId);
    echo json_encode($removeCourseList);
  }
}
