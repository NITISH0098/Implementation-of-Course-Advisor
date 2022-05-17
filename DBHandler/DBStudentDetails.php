<?php
$rootPath = $_SERVER["DOCUMENT_ROOT"];
require_once $rootPath."/workspace/DBHandler/DatabaseConnection.php";

// $dbo = new DatabaseConnection();
// $grade = 'A';
// $studentId = 1;
// $cmd = "UPDATE studentsessiontable SET grade=:grade WHERE sid = :studentId";
// $template = $dbo->conn->prepare($cmd);
// $template->execute([":grade"=>$grade,":studentId"=>$studentId]);
// $data = $template->fetchAll(PDO::FETCH_ASSOC);

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
     
    public function getSessionID($termYear,$termType)
       {
        $dbo = new DatabaseConnection();
      
        //Query for retrieving the id
        $cmd = "SELECT sessionID FROM sessiontable WHERE termYear=:ty and termType=:tt";
        $template = $dbo->conn->prepare($cmd);
        $template->execute([":ty" => $termYear, ":tt"=>$termType]);
        $sessionId = $template->fetchAll(PDO::FETCH_ASSOC);
        $id= $sessionId[0]['sessionID'];

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
    public function getSemDetails($progId){
      $dbo = new DatabaseConnection();
      $cmd = "SELECT nos FROM programdetails WHERE pid =$progId";
      $template = $dbo->conn->prepare($cmd);
      $template->execute();

      $programTable = $template->fetchAll(PDO::FETCH_ASSOC);
      $nos = $programTable[0]["nos"];
       return $nos;
      }

    public function loadSemStudents($sessionId,$progId, $semId){
      $dbo = new DatabaseConnection();
      $cmd = "SELECT * FROM studenttable where pid = $progId" ;
      $template = $dbo->conn->prepare($cmd);
      $template->execute();
      $programTable = $template->fetchAll(PDO::FETCH_ASSOC);
      $j=count($programTable);
  
      $mainArray = [];
      $k=0;
      for($i = 0 ; $i < $j ; $i++){

      if(($sessionId - $programTable[$i]["admitYear"])+1 == $semId){
        $mainArray["student"][$k] = $programTable[$i]["sname"];
        $mainArray["sid"][$k] = $programTable[$i]["sid"];
        $fid = $programTable[$i]['fid'];
        if($fid == -1)
          {
            $mainArray["facultyName"][$k]= "-1";
          }
        else{
          $cmd = "SELECT fname FROM facultydetails WHERE fid= $fid";
          $template = $dbo->conn->prepare($cmd);
          $template->execute();
          $facultyName = $template->fetchAll(PDO::FETCH_ASSOC);
        $mainArray["facultyName"][$k]= $facultyName[0]['fname'];
        }
         
        $k++;
      }
     }
     if(count($mainArray)==0)
      {
        return $mainArray;
      }
     else
     {
      if(!isset($_SESSION)) 
      { 
          session_start(); 
      } 
      $did = $_SESSION['did'];
      $dbo = new DatabaseConnection();      
      $cmd = "SELECT * FROM facultydetails WHERE did=$did";
      $template = $dbo->conn->prepare($cmd);
      $template->execute();
      $data = $template->fetchAll(PDO::FETCH_ASSOC);
  
      $j=count($data);
      $facultyList = array();
      for($i=0; $i<$j; $i++)
      {
      $facultyList["faculty"][$i] = $data[$i]['fname'];
      $facultyList["fid"][$i] = $data[$i]['fid'];
      }
  
      $mainArray = array_merge($mainArray,$facultyList);
     }
   
      return $mainArray;
      }

    public function loadFaculty()
      {
         if(!isset($_SESSION)) 
         { 
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
  
    public function assignFaculty($facultyId,$studentId)
      {
        $dbo = new DatabaseConnection();      
        $cmd = "UPDATE studenttable SET fid=$facultyId WHERE sid = $studentId";
        $template = $dbo->conn->prepare($cmd);
        $template->execute();
        $data = $template->fetchAll(PDO::FETCH_ASSOC);
        return($data);
      }

    public function getStudents($sessionId)
      {
        $dbo = new DatabaseConnection();
        $emptyArray=[];        
        $cmd = "SELECT studentID,isVerified FROM registrationtable WHERE sessionID=$sessionId";
        $template = $dbo->conn->prepare($cmd);
        $template->execute();
        
        if($template->rowCount()==0){
          return $emptyArray;
        }
        else{
       
        $data = $template->fetchAll(PDO::FETCH_ASSOC);
        
         $j=count($data);
         $isVerified = array();
        for($i=0; $i<$j; $i++)
        {
             $isVerified[$i+1] = $data[$i]['isVerified'];
        }

        $mainArray=[];
        if(!isset($_SESSION)) 
        { 
            session_start(); 
        } 
        $FID = $_SESSION['fid'];

        for($i=0;$i<$j;$i++)
           {
            $studentID = intval($data[$i]['studentID']);
            $cmd = "SELECT sid,sname,senroll FROM studenttable WHERE sid =$studentID and fid = $FID";
            $template = $dbo->conn->prepare($cmd);
            $template->execute();
            $data3 = $template->fetchAll(PDO::FETCH_ASSOC);
            $mainArray=array_merge($mainArray,$data3);
           }

           foreach($mainArray as &$i){
                 $i["status"] = $isVerified[$i["sid"]];
           }
        
        return $mainArray;
        }
       }

    public function getCCL($sessionId,$studentID)
     { 
         
        $dbo = new DatabaseConnection();      
        $cmd = "SELECT cid,courseCategory,grade FROM studentsessiontable WHERE sid=:sid and sessionID<:sesid and grade not in('F','X')";
        $template = $dbo->conn->prepare($cmd);
        $template->execute([":sid" => $studentID, ":sesid"=>$sessionId]);
    
        if($template->rowCount()>0){
            $details = $template->fetchAll(PDO::FETCH_ASSOC);

            $j=count($details);
            $courseCategory = array();
           for($i=0; $i<$j; $i++)
                {
                $courseCategory[$i+1] = $details[$i]['courseCategory'];
                }
            
            $grade = array();
                for($i=0; $i<$j; $i++)
                     {
                     $grade[$i+1] = $details[$i]['grade'];
                     }
          
            $mainArray = array();
            for($i=0;$i<$j;$i++)
              {
                  $cid = intval($details[$i]['cid']);
                  $cmd = "SELECT * FROM coursetable WHERE cid=:cid";
                  $template = $dbo->conn->prepare($cmd);
                  $template->execute([":cid" => $cid]);
                  $Cdetails = $template->fetchAll(PDO::FETCH_ASSOC);
                  $mainArray = array_merge($mainArray,$Cdetails);
              }
              $countC=1;
              foreach($mainArray as &$i){
                $i["category"] = $courseCategory[$countC];
                $countC++;
               }
              $countC=1;
               foreach($mainArray as &$i){
                $i["grade"] = $grade[$countC];
                $countC++;
               }
        }
        else
          {
            $mainArray=[];
          }
        return $mainArray;
     }

    
     public function getUCL($sessionId,$studentID)
     {
      $dbo = new DatabaseConnection();      
      $cmd = "SELECT cid,courseCategory,grade FROM studentsessiontable WHERE sid=:sid and sessionID<=:sesid and grade in('F','X')";
      $template = $dbo->conn->prepare($cmd);
      $template->execute([":sid" => $studentID, ":sesid"=>$sessionId]);
  
      if($template->rowCount()>0){
          $details = $template->fetchAll(PDO::FETCH_ASSOC);

          $j=count($details);
          $courseCategory = array();
         for($i=0; $i<$j; $i++)
              {
              $courseCategory[$i+1] = $details[$i]['courseCategory'];
              }
          
          $grade = array();
              for($i=0; $i<$j; $i++)
                   {
                   $grade[$i+1] = $details[$i]['grade'];
                   }
        
          $mainArray = array();
          for($i=0;$i<$j;$i++)
            {
                $cid = intval($details[$i]['cid']);
                $cmd = "SELECT * FROM coursetable WHERE cid=:cid";
                $template = $dbo->conn->prepare($cmd);
                $template->execute([":cid" => $cid]);
                $Cdetails = $template->fetchAll(PDO::FETCH_ASSOC);
                $mainArray = array_merge($mainArray,$Cdetails);
            }
            $countC=1;
            foreach($mainArray as &$i){
              $i["category"] = $courseCategory[$countC];
              $countC++;
             }
            $countC=1;
             foreach($mainArray as &$i){
              $i["grade"] = $grade[$countC];
              $countC++;
             }
      }
      else
      {
        $mainArray=[];
      }
      return $mainArray;
     }

    public function getCL($sessionId,$studentID){
      $dbo = new DatabaseConnection();      
      $cmd = "SELECT cid,courseCategory,grade FROM studentsessiontable WHERE sid=:sid and sessionID=:sesid";
      $template = $dbo->conn->prepare($cmd);
      $template->execute([":sid" => $studentID, ":sesid"=>$sessionId]);
  
      if($template->rowCount()>0){
          $details = $template->fetchAll(PDO::FETCH_ASSOC);

          $j=count($details);
          $courseCategory = array();
         for($i=0; $i<$j; $i++)
              {
              $courseCategory[$i+1] = $details[$i]['courseCategory'];
              }
          
          $grade = array();
              for($i=0; $i<$j; $i++)
                   {
                   $grade[$i+1] = $details[$i]['grade'];
                   }
        
          $mainArray = array();
          for($i=0;$i<$j;$i++)
            {
                $cid = intval($details[$i]['cid']);
                $cmd = "SELECT * FROM coursetable WHERE cid=:cid";
                $template = $dbo->conn->prepare($cmd);
                $template->execute([":cid" => $cid]);
                $Cdetails = $template->fetchAll(PDO::FETCH_ASSOC);
                $mainArray = array_merge($mainArray,$Cdetails);
            }
            $countC=1;
            foreach($mainArray as &$i){
              $i["category"] = $courseCategory[$countC];
              $countC++;
             }
            $countC=1;
             foreach($mainArray as &$i){
              $i["grade"] = $grade[$countC];
              $countC++;
             }
      }
      else
      {
        $mainArray=[];
      }
      return $mainArray;
      }  
    public function getCGPA($sessionId, $studentID)
      {
      $dbo = new DatabaseConnection();
      $cmd = "SELECT cid,grade FROM studentsessiontable WHERE sid=:sid and sessionID <=:sesID and grade not in('F','X')";
      $template = $dbo->conn->prepare($cmd);
      $template->execute([":sid" => $studentID, ":sesID" => $sessionId]);
  
  
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
      
      }
      
      else{
        $CGPA = [];
      }
  
      return $CGPA;
      }

    public function getFID($un,$pn){
        $dbo = new DatabaseConnection();
        $cmd = "SELECT id,fid FROM facultylogindetails WHERE username=:uid and password=:pwd";
  
  
        $template = $dbo->conn->prepare($cmd);
        $template->execute([":uid" => $un, ":pwd" => $pn]);
    
        if ($template->rowCount() > 0) {
          $rtable = $template->fetchAll(PDO::FETCH_ASSOC);
          // $id=$rtable[0]['id'];
          $id=$rtable;
          $fid = $rtable[0]['fid'];
          $cmd1 = "SELECT fname, did FROM facultydetails WHERE fid=$fid";
          $template1 = $dbo->conn->prepare($cmd1);
          $template1->execute();
          if($template1->rowCount() > 0){
            $rtable1 = $template1->fetchAll(PDO::FETCH_ASSOC);
            $id['fname'][0]=$rtable1[0]['fname'];
            $did = $rtable1[0]['did'];
            $cmd2 = "SELECT dname FROM departmentdetails WHERE did = $did";
            $template2 = $dbo->conn->prepare($cmd2);
          $template2->execute();
          if($template2->rowCount()>0){
            $rtable2 = $template2->fetchAll(PDO::FETCH_ASSOC);
            $id['dname'][0] = $rtable2[0]['dname'];
          }
          } 
          }
      else
        {
          $id = array("0"=>array("id"=>"-1"));
          
        }
      return $id;
      }
    public function getHID($un,$pn){
      $dbo = new DatabaseConnection();
      $cmd = "SELECT id,hid FROM hodlogindetails WHERE username=:uid and password=:pwd";
      $template = $dbo->conn->prepare($cmd);
      $template->execute([":uid" => $un, ":pwd" => $pn]);
  
     if ($template->rowCount() > 0) {
      $rtable = $template->fetchAll(PDO::FETCH_ASSOC);
      $id=$rtable[0]['id'];
      $did=$rtable[0]['hid'];
      $cmd1 = "SELECT did FROM hoddetails WHERE did=$did";
      $template1 = $dbo->conn->prepare($cmd1);
      $template1->execute();
      $rtable1 = $template1->fetchAll(PDO::FETCH_ASSOC);
        
      if(!isset($_SESSION)) 
      { 
          session_start(); 
      } 
      $_SESSION['did']= $rtable1[0]['did'];
  
      }
     else
      {
        $id=-1;
      }
     return $id;    
     }
  
  
  
  












    public function getVerified($sessionID,$studentId){
        $dbo = new DatabaseConnection();
        $cmd = "UPDATE registrationtable SET IsVerified='Y' WHERE sessionID=$sessionID AND studentID=$studentId";
        $template = $dbo->conn->prepare($cmd);
        $template->execute();
        $rv = $template->fetchAll(PDO::FETCH_ASSOC);
        return $rv;
      }
    public function  getSmail($studentId)
      {
        $dbo = new DatabaseConnection();
        $cmd = "SELECT semail FROM studenttable WHERE sid = $studentId";
        $template = $dbo->conn->prepare($cmd);
        $template->execute();
        $rv = $template->fetchAll(PDO::FETCH_ASSOC);
        return $rv;
      }
    public function checkEmail($un)
     {
      $dbo = new DatabaseConnection();
      $cmd = "SELECT fid FROM facultydetails WHERE email = '" . $un. "'";
      $template = $dbo->conn->prepare($cmd);
      $template->execute();
      if ($template->rowCount() > 0)
      {
        $rtable = $template->fetchAll(PDO::FETCH_ASSOC);
        $rv =array("0"=>array("fid"=>$rtable[0]['fid'])) ;
      }
      else
        {
          $rv = array("0"=>array("fid"=>"-1"));
        }
      return $rv;
     } 

    public function updatePassword($pw,$fid)
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
           if($template1->rowCount()>0){
             $rtable1 = $template1->fetchAll(PDO::FETCH_ASSOC);
             $id1['sname'][$i]=$rtable1[0]['sname'];
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

  public function getCourseName($fid)
     {
    $dbo = new DatabaseConnection();
    $id = array();
    //extracting the courses against a faculty
    $cmdForCourse = "SELECT cname,cid FROM coursetable WHERE fid=$fid";
    $template = $dbo->conn->prepare($cmdForCourse);
    $template->execute();
    if ($template->rowCount() > 0) {
      $rtable3 = $template->fetchAll(PDO::FETCH_ASSOC);
      for ($i = 0; $i < $template->rowCount(); $i++) {
        $id['cid'][$i] = $rtable3[$i]['cid'];
        $id['cname'][$i] = $rtable3[$i]['cname'];
      }
    } else {
      $id = array("0" => array("id" => "-1"));
    }
    return $id;
   }
    public function assignGrade($grade,$courseId,$studentId){
      $dbo = new DatabaseConnection();
      $cmd = "UPDATE studentsessiontable SET grade=:grade WHERE sid = :studentId and cid = :courseId";
      $template = $dbo->conn->prepare($cmd);
      $template->execute([":grade"=>$grade,":studentId"=>$studentId,":courseId"=>$courseId]);
      $data = $template->fetchAll(PDO::FETCH_ASSOC);      
      return($data);
    }
    }
?>