<?php
   $path = $_SERVER['DOCUMENT_ROOT'];
   require_once $path. "/workspace/DBHandler/DBStudentDetails.php";
  
   $dbo = new DBStudentDetails();

   $action = $_POST["action"];

   if($action=="loginHandlerHOD")
       {
          $un = $_POST["username"];
          $pw = $_POST["password"];
          $id = $dbo->getHID($un,$pw);
          $status = "";
          if($id==-1)
             {
                $status="ERROR";
                if(!isset($_SESSION)) 
                      { 
                           session_start(); 
                      } 
                session_destroy();
             }
          else
             {
            if(!isset($_SESSION)) 
                { 
                  session_start(); 
                } 
             $_SESSION['hid']=$id;
             $_SESSION['set']= 1;
             $_SESSION['loginAs']= "hod";
             $status="OK";
             } 
            $rv = array("status"=>$status);
            echo json_encode($rv);
            exit();     
      }
    
    if($action=="loginHandlerFaculty")
      {
          $un = $_POST["username"];
          $pw = $_POST["password"];
          $result = $dbo->getFID($un,$pw);
          $status = "";
          $id = $result[0]['id'];
          if($id==-1)
              {
                $status="ERROR";
                if(!isset($_SESSION)) 
                     { 
                         session_start(); 
                     } 
                session_destroy();
              }
        else
        {
          if(!isset($_SESSION)) 
             { 
              session_start(); 
            } 
           $_SESSION['fid']=$result[0]['fid'];
           $_SESSION['fname'] = $result['fname'][0];
           $_SESSION['dname'] = $result['dname'][0];
           $_SESSION['set']= 1;
           $_SESSION['loginAs']= "faculty";
           $status="OK";
        }
           $rv = array("status"=>$status);
           echo json_encode($rv);
          exit();     
       }

?>