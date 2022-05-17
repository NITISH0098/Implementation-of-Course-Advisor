<?php
   $path = $_SERVER['DOCUMENT_ROOT'];
   require_once $path. "/workspace/DBHandler/DBStudentDetails.php";
  
   $dbo = new DBStudentDetails();

   $action = $_POST["action"];

   if($action=="generateMail")
       {
          $un = $_POST["username"];
          $rv = $dbo->checkEmail($un);
          $status = "";
          if($rv[0]['fid']==-1)
             {
                $status="ERROR";
             }
          else
             {
             $status="OK";
             if(!isset($_SESSION))
               {
                   session_start();
               }
                   $otp = rand(145672, 999999);
                   $_SESSION['otp']=$otp;
                   $_SESSION['fid']=$rv[0]['fid'];
               
              //MAIL WILL BE SENT TO THE STUDENT FOR BEING ACCEPTED
                 $receiver = $un;
                 $subject = "OTP FOR NEW PASSWORD";
                 $body = "The otp is: '" . $otp. "'";
                 $sender = "From:unofficialpurpose11@gmail.com";
                if(mail($receiver, $subject, $body, $sender)){
                      // echo "Email sent successfully to $receiver";
                }
                else{
                    // echo "Sorry, failed while sending mail!";
                }
            } 
             $rv1 = array("status"=>$status);
            echo json_encode($rv1);
            exit();     
      }
    
    if($action=="verifyOTP")
      {
          $pw = $_POST["otp"];
          if(!isset($_SESSION))
          {
              session_start();
          }
                $status = "";
                if($pw==$_SESSION['otp'])
                      {
                             $status="OK";
                             unset($_SESSION['otp']);
                      }
                 else
                      {
                             $status="ERROR";
                      }
           $rv = array("status"=>$status);
           echo json_encode($rv);
          exit();     
       }
   if($action=="updatePassword")
     {
         $pw = $_POST["password"];
         if(!isset($_SESSION))
         {
             session_start();
         }
         $fid = $_SESSION['fid'];
         $rv = $dbo->updatePassword($pw,$fid);
         if($rv=="true")
           {
               $status="OK";
           }
        else
          {
              $status="ERROR";
          }
        $rv1 = array("status"=>$status);
         echo json_encode($rv1);
     }
?>