<?php
$rootPath = $_SERVER["DOCUMENT_ROOT"];
require_once $rootPath . "/workspace/DBHandler/DatabaseConnection.php";


class DBStudentDetails
{

  public function getSessionDetails()
  {
    $dbo = new DatabaseConnection();
    $cmd = "SELECT * FROM sessiontable";
    $template = $dbo->conn->prepare($cmd);
    $template->execute();

    $sessionTable = $template->fetchAll(PDO::FETCH_ASSOC);
    return $sessionTable;
  }
  public function getSessionID($termYear, $termType)
  {
    $dbo = new DatabaseConnection();

    //Query for retrieving the id
    $cmd = "SELECT sessionID FROM sessiontable WHERE termYear=:ty and termType=:tt";
    $template = $dbo->conn->prepare($cmd);
    $template->execute([":ty" => $termYear, ":tt" => $termType]);
    $sessionId = $template->fetchAll(PDO::FETCH_ASSOC);
    $id = $sessionId[0]['sessionID'];

    return $id;
  }

  public function getProgramDetails()
  {
    $dbo = new DatabaseConnection();
    $cmd = "SELECT * FROM programdetails";
    $template = $dbo->conn->prepare($cmd);
    $template->execute();

    $programTable = $template->fetchAll(PDO::FETCH_ASSOC);
    return $programTable;
  }

  // public function getProgramID($termYear,$termType)
  // {
  //   $dbo = new DatabaseConnection();

  //   //Query for retrieving the id
  //   $cmd = "SELECT pid FROM programdetails WHERE termYear=:ty and termType=:tt";
  //   $template = $dbo->conn->prepare($cmd);
  //   $template->execute([":ty" => $termYear, ":tt"=>$termType]);
  //   $sessionId = $template->fetchAll(PDO::FETCH_ASSOC);
  //   $id= $sessionId[0]['sessionID'];

  //   return $id;
  // }
  public function getSemDetails($progId)
  {
    $dbo = new DatabaseConnection();
    $cmd = "SELECT nos FROM programdetails WHERE pid =$progId";
    $template = $dbo->conn->prepare($cmd);
    $template->execute();

    $programTable = $template->fetchAll(PDO::FETCH_ASSOC);
    $nos = $programTable[0]["nos"];
    return $nos;
  }

  public function loadSemStudents($sessionId, $progId, $semId)
  {
    $dbo = new DatabaseConnection();
    $cmd = "SELECT * FROM studenttable where pid = $progId";
    $template = $dbo->conn->prepare($cmd);
    $template->execute();
    $programTable = $template->fetchAll(PDO::FETCH_ASSOC);
    $j = count($programTable);

    $mainArray = [];
    $k = 0;
    for ($i = 0; $i < $j; $i++) {

      if (($sessionId - $programTable[$i]["admitYear"]) + 1 == $semId) {
        $mainArray["student"][$k] = $programTable[$i]["sname"];
        $mainArray["sid"][$k] = $programTable[$i]["sid"];
        $fid = $programTable[$i]['fid'];
        if ($fid == 0) {
          $mainArray["facultyName"][$k] = "-1";
        } else {
          $cmd = "SELECT fname FROM facultydetails WHERE fid= $fid";
          $template = $dbo->conn->prepare($cmd);
          $template->execute();
          $facultyName = $template->fetchAll(PDO::FETCH_ASSOC);
          $mainArray["facultyName"][$k] = $facultyName[0]['fname'];
        }

        $k++;
      }
    }
    if (count($mainArray) == 0) {
      return $mainArray;
    } else {
      if (!isset($_SESSION)) {
        session_start();
      }
      $did = $_SESSION['did'];
      $dbo = new DatabaseConnection();  //not needed    
      $cmd = "SELECT * FROM facultydetails WHERE did=$did";
      $template = $dbo->conn->prepare($cmd);
      $template->execute();
      $data = $template->fetchAll(PDO::FETCH_ASSOC);

      $j = count($data);
      $facultyList = array();
      for ($i = 0; $i < $j; $i++) {
        $facultyList["faculty"][$i] = $data[$i]['fname'];
        $facultyList["fid"][$i] = $data[$i]['fid'];
        $facultyList["currentSession"] = $sessionId;
      }

      $mainArray = array_merge($mainArray, $facultyList);
    }

    return $mainArray;
  }

  public function loadFaculty()
  {
    if (!isset($_SESSION)) {
      session_start();
    }
    $did = $_SESSION['did'];
    $dbo = new DatabaseConnection();
    $cmd = "SELECT * FROM facultydetails WHERE did=$did";
    $template = $dbo->conn->prepare($cmd);
    $template->execute();
    $data = $template->fetchAll(PDO::FETCH_ASSOC);
    return $data;
  }

  public function assignFaculty($facultyId, $studentId)
  {
    $dbo = new DatabaseConnection();
    $cmd = "UPDATE studenttable SET fid=$facultyId WHERE sid = $studentId";
    $template = $dbo->conn->prepare($cmd);
    $template->execute();
    $data = $template->fetchAll(PDO::FETCH_ASSOC);
    return ($data);
  }

  public function getStudents($sessionId)
  {
    $dbo = new DatabaseConnection();
    $emptyArray = [];
    $cmd = "SELECT studentID,isVerified FROM registrationtable WHERE sessionID=$sessionId";
    $template = $dbo->conn->prepare($cmd);
    $template->execute();

    if ($template->rowCount() == 0) {
      return $emptyArray;
    } else {

      $data = $template->fetchAll(PDO::FETCH_ASSOC);

      $j = count($data);
      $isVerified = array();
      for ($i = 0; $i < $j; $i++) {
        $sakalakaboomboom = $data[$i]['studentID'];
        $isVerified[$sakalakaboomboom] = $data[$i]['isVerified'];
      }

      $mainArray = [];
      if (!isset($_SESSION)) {
        session_start();
      }
      $FID = $_SESSION['fid'];

      for ($i = 0; $i < $j; $i++) {
        $studentID = intval($data[$i]['studentID']);
        $cmd = "SELECT sid,sname,senroll FROM studenttable WHERE sid =$studentID and fid = $FID";
        $template = $dbo->conn->prepare($cmd);
        $template->execute();
        $data3 = $template->fetchAll(PDO::FETCH_ASSOC);
        $mainArray = array_merge($mainArray, $data3);
      }

      foreach ($mainArray as &$i) {
        $i["status"] = $isVerified[$i["sid"]];
      }

      return $mainArray;
    }
  }

  public function getCCL($sessionId, $studentID)
  {

    $dbo = new DatabaseConnection();
    $cmd = "SELECT cid,courseCategory,grade FROM studentsessiontable WHERE sid=:sid and sessionID<:sesid and grade not in('F','X')";
    $template = $dbo->conn->prepare($cmd);
    $template->execute([":sid" => $studentID, ":sesid" => $sessionId]);

    if ($template->rowCount() > 0) {
      $details = $template->fetchAll(PDO::FETCH_ASSOC);

      $j = count($details);
      $courseCategory = array();
      for ($i = 0; $i < $j; $i++) {
        $courseCategory[$i + 1] = $details[$i]['courseCategory'];
      }

      $grade = array();
      for ($i = 0; $i < $j; $i++) {
        $grade[$i + 1] = $details[$i]['grade'];
      }

      $mainArray = array();
      for ($i = 0; $i < $j; $i++) {
        $cid = intval($details[$i]['cid']);
        $cmd = "SELECT * FROM coursetable WHERE cid=:cid";
        $template = $dbo->conn->prepare($cmd);
        $template->execute([":cid" => $cid]);
        $Cdetails = $template->fetchAll(PDO::FETCH_ASSOC);
        $mainArray = array_merge($mainArray, $Cdetails);
      }
      $countC = 1;
      foreach ($mainArray as &$i) {
        $i["category"] = $courseCategory[$countC];
        $countC++;
      }
      $countC = 1;
      foreach ($mainArray as &$i) {
        $i["grade"] = $grade[$countC];
        $countC++;
      }
    } else {
      $mainArray = [];
    }
    return $mainArray;
  }


  public function getUCL($sessionId, $studentID)
  {
    $dbo = new DatabaseConnection();
    $cmd = "SELECT cid,courseCategory,grade FROM studentsessiontable WHERE sid=:sid and sessionID<=:sesid and grade in('F','X')";
    $template = $dbo->conn->prepare($cmd);
    $template->execute([":sid" => $studentID, ":sesid" => $sessionId]);

    if ($template->rowCount() > 0) {
      $details = $template->fetchAll(PDO::FETCH_ASSOC);

      $j = count($details);
      $courseCategory = array();
      for ($i = 0; $i < $j; $i++) {
        $courseCategory[$i + 1] = $details[$i]['courseCategory'];
      }

      $grade = array();
      for ($i = 0; $i < $j; $i++) {
        $grade[$i + 1] = $details[$i]['grade'];
      }

      $mainArray = array();
      for ($i = 0; $i < $j; $i++) {
        $cid = intval($details[$i]['cid']);
        $cmd = "SELECT * FROM coursetable WHERE cid=:cid";
        $template = $dbo->conn->prepare($cmd);
        $template->execute([":cid" => $cid]);
        $Cdetails = $template->fetchAll(PDO::FETCH_ASSOC);
        $mainArray = array_merge($mainArray, $Cdetails);
      }
      $countC = 1;
      foreach ($mainArray as &$i) {
        $i["category"] = $courseCategory[$countC];
        $countC++;
      }
      $countC = 1;
      foreach ($mainArray as &$i) {
        $i["grade"] = $grade[$countC];
        $countC++;
      }
    } else {
      $mainArray = [];
    }
    return $mainArray;
  }

  public function getCL($sessionId, $studentID, $recSessionID)
  {
    $dbo = new DatabaseConnection();
    $cmd = "SELECT cid,courseCategory,grade FROM studentsessiontable WHERE sid=:sid and sessionID=:sesid";
    $template = $dbo->conn->prepare($cmd);
    $template->execute([":sid" => $studentID, ":sesid" => $sessionId]);

    if ($template->rowCount() > 0) {
      $details = $template->fetchAll(PDO::FETCH_ASSOC);

      $j = count($details);
      $courseCategory = array();
      for ($i = 0; $i < $j; $i++) {
        $courseCategory[$i + 1] = $details[$i]['courseCategory'];
      }

      $grade = array();
      for ($i = 0; $i < $j; $i++) {
        $grade[$i + 1] = $details[$i]['grade'];
      }

      $mainArray = array();
      for ($i = 0; $i < $j; $i++) {
        $cid = intval($details[$i]['cid']);
        $cmd = "SELECT * FROM coursetable WHERE cid=:cid";
        $template = $dbo->conn->prepare($cmd);
        $template->execute([":cid" => $cid]);
        $Cdetails = $template->fetchAll(PDO::FETCH_ASSOC);
        $mainArray = array_merge($mainArray, $Cdetails);
      }
      $countC = 1;
      foreach ($mainArray as &$i) {
        $i["category"] = $courseCategory[$countC];
        $countC++;
      }
      $countC = 1;
      foreach ($mainArray as &$i) {
        $i["grade"] = $grade[$countC];
        $countC++;
      }

      $countSession = "SELECT * from sessiontable";
      $templateCountSession = $dbo->conn->prepare($countSession);
      $templateCountSession->execute();

      $rtableCountSession = $templateCountSession->rowCount();
      if ($recSessionID == $rtableCountSession) {
        //$mainArray[0]['totalSessionCount'] = "Yes";
        $countC = 1;
        foreach ($mainArray as &$i) {
          $i["totalSessionCount"] = "Yes";
          $countC++;
        }
      } else {
        // $mainArray[0]['totalSessionCount'] ="No";
        $countC = 1;
        foreach ($mainArray as &$i) {
          $i["totalSessionCount"] = "No";
          $countC++;
        }
      }
    } else {
      $mainArray = [];
    }
    return $mainArray;
  }
  public function getCGPA($sessionID, $studentID)
  {
    $dbo = new DatabaseConnection();
    $cmd = "SELECT cid,grade FROM studentsessiontable WHERE sid=:sid and sessionID <=:sesid and grade not in('F','X','NA')";
    $template = $dbo->conn->prepare($cmd);
    $template->execute([":sid" => $studentID, ":sesid" => $sessionID]);

    if ($template->rowCount() > 0) {

      $details = $template->fetchAll(PDO::FETCH_ASSOC);
      $j = count($details);

      $cid = array();
      for ($i = 0; $i < $j; $i++) {
        $cid[$i + 1] = $details[$i]['grade'];
      }

      $mainArray = array();
      for ($i = 0; $i < $j; $i++) {
        $cid1 = intval($details[$i]['cid']);
        $cmd = "SELECT cr FROM coursetable WHERE cid=:cid";
        $template = $dbo->conn->prepare($cmd);
        $template->execute([":cid" => $cid1]);
        $Cdetails = $template->fetchAll(PDO::FETCH_ASSOC);
        $mainArray = array_merge($mainArray, $Cdetails);
      }

      $sgpa = 1;
      $totalCredit = 0;
      $totalGrade = 1;
      for ($i = 0; $i < count($mainArray); $i++) {
        $totalCredit += $mainArray[$i]["cr"];
      }

      $gPoint = array();
      //$gPoint = array("O"=>10, "A+" => 10, "A" => 10, "B+" => 10, "B" => 10, "C" => 10);

      for ($i = 0; $i < $j; $i++) {
        if ($cid[$i + 1] == 'O') {
          $gPoint[$i] = 10;
        } else if ($cid[$i + 1] == 'A+') {
          $gPoint[$i] = 9;
        } else if ($cid[$i + 1] == 'A') {
          $gPoint[$i] = 8;
        } else if ($cid[$i + 1] == 'B+') {
          $gPoint[$i] = 7;
        } else if ($cid[$i + 1] == 'B') {
          $gPoint[$i] = 6;
        } else if ($cid[$i + 1] == 'C') {
          $gPoint[$i] = 5;
        } else if ($cid[$i + 1] == 'P') {
          $gPoint[$i] = 4;
        } else if ($cid[$i + 1] == 'NA') {
          $gPoint[$i] = 0;
        }
      }

      for ($i = 0; $i < count($mainArray); $i++) {
        $totalGrade += $mainArray[$i]["cr"] * $gPoint[$i];
      }

      $sgpa = round(($totalGrade / $totalCredit), 2);

      $CGPA = array();
      for ($i = 0; $i < 2; $i++) {
        $CGPA[0] = $sgpa;
        $CGPA[1] = $totalCredit;
      }
    } else {
      $CGPA = [];
    }

    return $CGPA;
  }

  public function getFID($un, $pn)
  {
    $dbo = new DatabaseConnection();
    $cmd = "SELECT id,fid FROM facultylogindetails WHERE username=:uid and password=:pwd";

    $password = md5($pn);
    $template = $dbo->conn->prepare($cmd);
    $template->execute([":uid" => $un, ":pwd" => $password]);

    if ($template->rowCount() > 0) {
      $rtable = $template->fetchAll(PDO::FETCH_ASSOC);
      // $id=$rtable[0]['id'];
      $id = $rtable;
      $fid = $rtable[0]['fid'];
      $cmd1 = "SELECT fname, did FROM facultydetails WHERE fid=$fid";
      $template1 = $dbo->conn->prepare($cmd1);
      $template1->execute();
      if ($template1->rowCount() > 0) {
        $rtable1 = $template1->fetchAll(PDO::FETCH_ASSOC);
        $id['fname'][0] = $rtable1[0]['fname'];
        $did = $rtable1[0]['did'];
        if (!isset($_SESSION)) {
          session_start();
        }
        $_SESSION['did'] = $did;
        $cmd2 = "SELECT dname FROM departmentdetails WHERE did = $did";
        $template2 = $dbo->conn->prepare($cmd2);
        $template2->execute();
        if ($template2->rowCount() > 0) {
          $rtable2 = $template2->fetchAll(PDO::FETCH_ASSOC);
          $id['dname'][0] = $rtable2[0]['dname'];
        }
      }
    } else {
      $id = array("0" => array("id" => "-1"));
    }
    return $id;
  }
  public function getHID($un, $pn)
  {
    $dbo = new DatabaseConnection();
    $cmd = "SELECT hid,fid,did FROM hoddetails WHERE username=:uid and password=:pwd";
    $template = $dbo->conn->prepare($cmd);
    $password = md5($pn);
    $template->execute([":uid" => $un, ":pwd" => $password]);

    if ($template->rowCount() > 0) {
      $rtable = $template->fetchAll(PDO::FETCH_ASSOC);
      //$hid=$rtable[0]['hid'];
      $id = array();
      $id['hid'][0] = $rtable[0]['hid'];
      $fid = $rtable[0]['fid'];
      $did = $rtable[0]['did'];

      $cmd1 = "SELECT dname FROM departmentdetails WHERE did=$did";
      $template1 = $dbo->conn->prepare($cmd1);
      $template1->execute();
      $rtable1 = $template1->fetchAll(PDO::FETCH_ASSOC);
      $dname = $rtable1[0]['dname'];
      $id['dname'][0] = $dname;

      $cmdforHodName = "SELECT fname FROM facultydetails WHERE fid=:fid";
      $template2 = $dbo->conn->prepare($cmdforHodName);
      $template2->execute([":fid" => $fid]);
      $rtable2 = $template2->fetchAll(PDO::FETCH_ASSOC);
      $hname = $rtable2[0]['fname'];

      $id['hname'][0] = $hname;


      if (!isset($_SESSION)) {
        session_start();
      }
      $_SESSION['did'] = $did;
    } else {
      $id = array("hid" => array("0" => "-1"));
    }
    return $id;
  }

  public function getVerified($sessionID, $studentId)
  {
    $dbo = new DatabaseConnection();
    $cmd = "UPDATE registrationtable SET IsVerified='Y' WHERE sessionID=$sessionID AND studentID=$studentId";
    $template = $dbo->conn->prepare($cmd);
    $template->execute();
    $rv = $template->fetchAll(PDO::FETCH_ASSOC);
    return $rv;
  }
  public function getSmail($studentId, $fid)
  {
    $dbo = new DatabaseConnection();
    $cmd = "SELECT s.semail,f.fname,f.email FROM studenttable As s,facultydetails As f  WHERE s.sid =:sid and f.fid=:fid";
    $template = $dbo->conn->prepare($cmd);
    $template->execute([":sid" => $studentId, ":fid" => $fid]);
    $rv = $template->fetchAll(PDO::FETCH_ASSOC);
    $array = array("semail" => $rv[0]['semail'], "fname" => $rv[0]['fname'], "femail" => $rv[0]['email']);
    return $array;
  }
  public function checkEmail($un)
  {
    $dbo = new DatabaseConnection();
    $cmd = "SELECT fid FROM facultydetails WHERE email = '" . $un . "'";
    $template = $dbo->conn->prepare($cmd);
    $template->execute();
    if ($template->rowCount() > 0) {
      $rtable = $template->fetchAll(PDO::FETCH_ASSOC);
      $rv = array("0" => array("fid" => $rtable[0]['fid']));
    } else {
      $rv = array("0" => array("fid" => "-1"));
    }
    return $rv;
  }

  public function updatePassword($pw, $fid)
  {
    $dbo = new DatabaseConnection();
    $cmd = "UPDATE facultylogindetails SET password =$pw WHERE fid=:fid";
    $template = $dbo->conn->prepare($cmd);
    $rv = $template->execute([":fid" => $fid]);
    return $rv;
  }
  public function getStudentCourse($sessionId, $courseId)
  {
    $dbo = new DatabaseConnection();
    $cmd = "SELECT sid,grade FROM studentsessiontable WHERE sessionID=$sessionId and cid=$courseId";
    $template = $dbo->conn->prepare($cmd);
    $template->execute();
    if ($template->rowCount() > 0) {
      $rtable = $template->fetchAll(PDO::FETCH_ASSOC);
      $id = array();
      $id1 = array();
      for ($i = 0; $i < count($rtable); $i++) {
        $id[$i] = $rtable[$i]['sid'];
        $cmd1 = "SELECT sname,sid FROM studenttable WHERE sid = $id[$i]";
        $template1 = $dbo->conn->prepare($cmd1);
        $template1->execute();
        if ($template1->rowCount() > 0) {
          $rtable1 = $template1->fetchAll(PDO::FETCH_ASSOC);
          $id1['sname'][$i] = $rtable1[0]['sname'];
          $id1['sid'][$i] = $rtable1[0]['sid'];
          $id1['grade'][$i] = $rtable[$i]['grade'];
        }
      }
    }
    /*  else {
         $id1 = array("0" => array("id" => "-1"));
       } */
    return $id1;
  }

  public function getCourseName($fid, $sessionID)
  {
    // $dbo = new DatabaseConnection();
    // $id = array();
    // //extracting the courses against a faculty
    // $cmdForCourse = "SELECT cname,cid FROM coursetable WHERE fid=$fid AND sessionID=$sessionID";
    // $template = $dbo->conn->prepare($cmdForCourse);
    // $template->execute();
    // if ($template->rowCount() > 0) {
    //   $rtable3 = $template->fetchAll(PDO::FETCH_ASSOC);
    //   for ($i = 0; $i < $template->rowCount(); $i++) {
    //     $id['cid'][$i] = $rtable3[$i]['cid'];
    //     $id['cname'][$i] = $rtable3[$i]['cname'];
    //   }
    // }
    // return $id;
    $dbo = new DatabaseConnection();
    $id = array();
    //extracting the courses against a faculty
    $cmdForCourse = "SELECT cid FROM facultycourserelation WHERE fid=$fid AND sessionID=$sessionID";
    $template = $dbo->conn->prepare($cmdForCourse);
    $template->execute();
    if ($template->rowCount() > 0) {
      $rtable = $template->fetchAll(PDO::FETCH_ASSOC);
      for ($i = 0; $i < $template->rowCount(); $i++) {
        $id['cid'][$i] = $rtable[$i]['cid'];
        $cid = $rtable[$i]['cid'];
        $cmdForCourseName = "SELECT cname FROM coursetable WHERE cid = $cid";
        $template1 = $dbo->conn->prepare($cmdForCourseName);
        $template1->execute();
        if ($template1->rowCount() > 0) {
          $rtable2 = $template1->fetchAll(PDO::FETCH_ASSOC);
          $id['cname'][$i] = $rtable2[0]['cname'];
        }
      }
    }
    return $id;
  }
  public function assignGrade($grade, $courseId, $studentId)
  {
    $dbo = new DatabaseConnection();
    $cmd = "UPDATE studentsessiontable SET grade=:grade WHERE sid = :studentId and cid = :courseId";
    $template = $dbo->conn->prepare($cmd);
    $template->execute([":grade" => $grade, ":studentId" => $studentId, ":courseId" => $courseId]);
    $data = $template->fetchAll(PDO::FETCH_ASSOC);
    return ($data);
  }
  public function getStudentsForGrade($sessionId, $courseId)
  {
    $dbo = new DatabaseConnection();
    $countSession = "SELECT sessionID from sessiontable";
    $templateCountSession = $dbo->conn->prepare($countSession);
    $templateCountSession->execute();

    $rtableCountSession = $templateCountSession->rowCount();

    $cmd = "SELECT sid,grade,sessionID FROM studentsessiontable WHERE sessionID=$sessionId and cid=$courseId";
    $template = $dbo->conn->prepare($cmd);
    $template->execute();
    if ($template->rowCount() > 0) {
      $rtable = $template->fetchAll(PDO::FETCH_ASSOC);


      $id = array();
      $id1 = array();
      $numberOfStudent = 0;
      $j = 0;
      for ($i = 0; $i < count($rtable); $i++) {
        $id[$i] = $rtable[$i]['sid'];
        //FOR CHECKING IF THE STUDENT IS ACCEPTED BY THE COURSE ADVISOR
        $cmdForVerify = "SELECT rid FROM registrationtable WHERE sessionID=$sessionId and studentID= $id[$i] and isVerified='Y'";
        $templateForVerify = $dbo->conn->prepare($cmdForVerify);
        $templateForVerify->execute();
        if ($templateForVerify->rowCount() > 0) {
          $cmd1 = "SELECT sname FROM studenttable WHERE sid = $id[$i]";
          $template1 = $dbo->conn->prepare($cmd1);
          $template1->execute();
          if ($template1->rowCount() > 0) {
            $rtable1 = $template1->fetchAll(PDO::FETCH_ASSOC);
            $id1['sname'][$j] = $rtable1[0]['sname'];
            $id1['grade'][$j] = $rtable[$j]['grade'];
            // added by Arindam
            $id1['sid'][$j] = $rtable[$j]['sid'];
            $j++;
          }
          $numberOfStudent++;
        }
      }
      $id1['sessionID'][0] = $rtable[0]['sessionID'];
      $id1['totalSessionId'][0] = $rtableCountSession;
      $id1['numberOfStudent'][0] = $numberOfStudent;
    }
    return $id1;
  }

  public function removeCourses($studentID, $courseID)
  {
    $dbo = new DatabaseConnection();
    $cmd = "DELETE FROM studentsessiontable WHERE sid=:sid and cid=:cid";
    $template = $dbo->conn->prepare($cmd);
    $template->execute([":sid" => $studentID, ":cid" => $courseID]);
  }
  public function getStudentReport($rollno)
  {
    $dbo = new DatabaseConnection();
    $cmdForFindStudent = "SELECT sid,sname,senroll,admitYear,pid from studenttable where senroll=:rollno";
    $template = $dbo->conn->prepare($cmdForFindStudent);
    $template->execute([":rollno" => $rollno]);
    $mainArray = array();
    if ($template->rowCount() > 0) {
      $rtable = $template->fetchAll(PDO::FETCH_ASSOC);
      $pid = $rtable[0]['pid'];
      $rollno = $rtable[0]['senroll'];
      $sname = $rtable[0]['sname'];
      $sid = $rtable[0]['sid'];
      $admitYear = $rtable[0]['admitYear'];
      //For finding the department and programName
      $cmdForFindDepartment = "SELECT did,pname,nos from programdetails WHERE pid=:pid";
      $template = $dbo->conn->prepare($cmdForFindDepartment);
      $template->execute([":pid" => $pid]);
      $rtable1 = $template->fetchAll(PDO::FETCH_ASSOC);
      $did = $rtable1[0]['did'];
      $pname = $rtable1[0]['pname'];
      $nos = $rtable1[0]['nos'];

      $cmdForFindDepartmentNAME = "SELECT dname from departmentdetails WHERE did=:did";
      $template = $dbo->conn->prepare($cmdForFindDepartmentNAME);
      $template->execute([":did" => $did]);
      $rtable2 = $template->fetchAll(PDO::FETCH_ASSOC);
      $dname = $rtable2[0]['dname'];

      //for printing the results
      $cmdForResult = "SELECT s.sessionID,s.cid,s.courseCategory,s.grade,c.cname,c.ccode,c.l,c.t,c.p,c.cr FROM studentsessiontable as s,coursetable as c where sid=:sid and c.cid=s.cid";
      $template = $dbo->conn->prepare($cmdForResult);
      $template->execute([":sid" => $sid]);
      $rtable3 = $template->fetchAll(PDO::FETCH_ASSOC);

      //for finding the term year and term type
      $cmdForSession = "SELECT termYear,termType FROM sessiontable WHERE sessionID BETWEEN $admitYear and 5";
      $template = $dbo->conn->prepare($cmdForSession);
      $template->execute();
      $rtable4 = $template->fetchAll(PDO::FETCH_ASSOC);

      $mainArray = array("headerDetails" => array("Department" => $dname, "Programme" => $pname, "rollno" => $rollno, "sname" => $sname, "nos" => $nos, "admitYear" => $admitYear), "status" => "YES", "results" => $rtable3, "sessions" => $rtable4);
    } else {
      $mainArray = array("status" => "NO");
    }
    return $mainArray;
  }
  public function getCourseAndFaculty($sessionId)
  {
    $dbo = new DatabaseConnection();
    $details = array();
    $facultyNcourseName = array();
    $cmdForSessionCount = "SELECT sessionID from sessiontable";
    $templateCount = $dbo->conn->prepare($cmdForSessionCount);
    $templateCount->execute();
    $rtableCount = $templateCount->fetchAll(PDO::FETCH_ASSOC);
    $countSession = count($rtableCount);
    $details['SessionCount'][0] = $countSession;
    $details['currentSessionId'][0] = $sessionId;

    $cmd = "SELECT cid,fid from facultycourserelation WHERE sessionID=:sessionId";
    $template = $dbo->conn->prepare($cmd);
    $template->execute([":sessionId" => $sessionId]);
    if ($template->rowCount() > 0) {
      $rtable = $template->fetchAll(PDO::FETCH_ASSOC);

      for ($i = 0; $i < count($rtable); $i++) {
        $facultyNcourseName["previous"]["cid"][$i] = $rtable[$i]["cid"];
        $cid = $rtable[$i]["cid"];
        $cmdForCourseName = "SELECT cname from coursetable WHERE cid= $cid";
        $template1 = $dbo->conn->prepare($cmdForCourseName);
        $template1->execute();
        if ($template1->rowCount() > 0) {
          $rtable1 = $template1->fetchAll(PDO::FETCH_ASSOC);
          $facultyNcourseName["previous"]["cname"][$i] = $rtable1[0]["cname"];
        }

        $facultyNcourseName["previous"]["fid"][$i] = $rtable[$i]["fid"];
        $fid = $rtable[$i]["fid"];
        $cmdForFacultyName = "SELECT fname from facultydetails WHERE fid= $fid";
        $template2 = $dbo->conn->prepare($cmdForFacultyName);
        $template2->execute();
        if ($template2->rowCount() > 0) {
          $rtable2 = $template2->fetchAll(PDO::FETCH_ASSOC);
          $facultyNcourseName["previous"]["fname"][$i] = $rtable2[0]["fname"];
        }
      }
    }

    $cmdForAllcourse = "SELECT cname,cid FROM coursetable";
    $templateForAllcourse = $dbo->conn->prepare($cmdForAllcourse);
    $templateForAllcourse->execute();
    if ($templateForAllcourse->rowCount() > 0) {
      $rtableForAllcourse = $templateForAllcourse->fetchAll(PDO::FETCH_ASSOC);
      for ($i = 0; $i < count($rtableForAllcourse); $i++) {
        $details["cid"][$i] = $rtableForAllcourse[$i]["cid"];
        $details["cname"][$i] = $rtableForAllcourse[$i]["cname"];
      }
    }

    $cmdForAllFaculty = "SELECT fname,fid from  facultydetails";
    $templateForAllFaculty = $dbo->conn->prepare($cmdForAllFaculty);
    $templateForAllFaculty->execute();
    if ($templateForAllFaculty->rowCount() > 0) {
      $rtableForAllFaculty = $templateForAllFaculty->fetchAll(PDO::FETCH_ASSOC);
      for ($i = 0; $i < count($rtableForAllFaculty); $i++) {
        $details["fid"][$i] = $rtableForAllFaculty[$i]["fid"];
        $details["FacultyName"][$i] = $rtableForAllFaculty[$i]["fname"];
      }
    }

    $mainArray = array();
    $mainArray = array_merge($details, $facultyNcourseName);
    return $mainArray;
  }

  public function getFaculty()
  {
    $dbo = new DatabaseConnection();
    if (!isset($_SESSION)) {
      session_start();
    }
    $did = $_SESSION['did'];
    $cmdForAllFaculty = "SELECT fname,fid from  facultydetails WHERE did=:did";
    $template = $dbo->conn->prepare($cmdForAllFaculty);
    $template->execute([":did" => $did]);
    if ($template->rowCount() > 0) {
      $rtable = $template->fetchAll(PDO::FETCH_ASSOC);
      for ($i = 0; $i < count($rtable); $i++) {
        $details1[$i]["fid"] = $rtable[$i]["fid"];
        $details1[$i]["FacultyName"] = $rtable[$i]["fname"];
      }
    }
    return $details1;
  }

  public function insertFacultyCourseRelation($courseId, $selectedFaculties, $sessionID)
  {
    $dbo = new DatabaseConnection();
    for ($i = 0; $i < count($selectedFaculties); $i++) {
      $value = $selectedFaculties[$i];
      $cmdForInsertFaculty = "INSERT into facultycourserelation VALUES('$courseId','$value','$sessionID')";
      $template = $dbo->conn->prepare($cmdForInsertFaculty);
      $template->execute();
    }
    return "YES";
  }
  public function deleteFacultyCourseRelation($courseId, $sessionId)
  {
    $dbo = new DatabaseConnection();
    $cmdForDelete = "DELETE from facultycourserelation WHERE cid=:cid and sessionID=:sid";
    $template = $dbo->conn->prepare($cmdForDelete);
    $template->execute([":cid" => $courseId, ":sid" => $sessionId]);
    return "YES";
  }
}