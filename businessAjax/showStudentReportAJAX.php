<?php
if (!isset($_SESSION)) {
  session_start();
}
$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path. "/workspace/DBHandler/DBStudentDetails.php";
require('../CourseAdvisor/PDFmaker/fpdf.php');

$dbo = new DBStudentDetails();

$action = $_REQUEST['action'];

if ( !empty($action)) {
    if($action == "findStudentAndShowReport"){
        $rollno = $_POST['rollno'];
        $rv = $dbo->getStudentReport($rollno);
        
        $status = $rv['status'];
        if($status=="YES")
         {
             $admitYear = $rv['headerDetails']['admitYear'];
             $nos = $rv['headerDetails']['nos'];
        //For Generating the pdf
        $pdf = new fpdf('l','mm','A4');
        $count = 0;
        $paperPerSemesterCount=0;
        $creditCompleted = 0;
        $totalGradePoint = 0;
        $cgpa = 0;
        $length= count($rv['results']);
        for($i=$admitYear;$i<($admitYear+$nos);$i++)
        {
            $tempCredit = 0;
            $tempGradePoint = 0;
            $pdf->AddPage();
        
            //setting up font for the page
            $pdf->SetFont('Arial','B',14);
            $pdf->Cell(270,10,'GRADE CARD',0,1,'C');
          
            //creating blank spaces
            $pdf->Cell(130,10,'',0,1,'R');
          
            //Header Details
            $pdf->SetFont('Courier','',14);
          
            $pdf->Cell(40,10,'Department',0,0);
            $pdf->Cell(130,10,": ".$rv['headerDetails']['Department'],0,1);
            $pdf->Cell(40,10,'Programme',0,0);
            $pdf->Cell(130,10,": ".$rv['headerDetails']['Programme'],0,1);
            $pdf->Cell(40,10,'RollNo',0,0);
            $pdf->Cell(110,10,": ".$rv['headerDetails']['rollno'],0,0);
            $pdf->Cell(40,10,'TERM',0,0);
            $pdf->Cell(120,10,": ".$rv['sessions'][$count]['termYear']." ".$rv['sessions'][$count]['termType']." SEMESTER",0,1);
            $pdf->Cell(40,10,'Name',0,0);
            $pdf->Cell(110,10,": ".$rv['headerDetails']['sname'],0,0);
            $pdf->Cell(40,10,'SEMESTER',0,0);
            $pdf->Cell(110,10,": ".$count+1,0,1);$count++;
                       
            //table header
            $pdf->SetFont('Courier','B',14);
            $pdf->Line(10,70,270,70);
            $pdf->Cell(40,10,'Course Code',0,0);
            $pdf->Cell(120,10,'Course Title',0,0);
            $pdf->Cell(15,10,'L',0,0);
            $pdf->Cell(15,10,'T',0,0);
            $pdf->Cell(15,10,'P',0,0);
            $pdf->Cell(15,10,'Cr',0,0);
            $pdf->Cell(15,10,'Grade Secured',0,1);
            $pdf->Line(10,80,270,80);
    
            //For printing the semester subjects
            $pdf->SetFont('Courier','',14);
                if($rv['results'][$paperPerSemesterCount]['grade']=="NA")
                  {
                    $pdf->Cell(40,10,'RESULTS ARE NOT DECLARED YET',0,1);break;
                  }
                else{
                    while($rv['results'][$paperPerSemesterCount]['sessionID']==$i)
                    {
                        $pdf->Cell(40,10,$rv['results'][$paperPerSemesterCount]['ccode'],0,0);
                        $pdf->Cell(120,10,$rv['results'][$paperPerSemesterCount]['cname'],0,0);
                        $pdf->Cell(15,10,$rv['results'][$paperPerSemesterCount]['l'],0,0);
                        $pdf->Cell(15,10,$rv['results'][$paperPerSemesterCount]['t'],0,0);
                        $pdf->Cell(15,10,$rv['results'][$paperPerSemesterCount]['p'],0,0);
                        $pdf->Cell(15,10,$rv['results'][$paperPerSemesterCount]['cr'],0,0); 
                       
                          $tempCredit += $rv['results'][$paperPerSemesterCount]['cr'];
                         
                        
                               
                        $pdf->Cell(15,10,$rv['results'][$paperPerSemesterCount]['grade'],0,1);
                           $grade = $rv['results'][$paperPerSemesterCount]['grade'];
                           if ($grade == 'O') {
                            $gPoint = 10;
                          } else if ($grade == 'A+') {
                            $gPoint= 9;
                          } else if ($grade == 'A') {
                            $gPoint= 8;
                          } else if ($grade == 'B+') {
                            $gPoint= 7;
                          } else if ($grade == 'B') {
                            $gPoint= 6;
                          } else if ($grade == 'C') {
                            $gPoint= 5;
                          }else if($grade == 'P'){
                            $gPoint= 4;
                          }
                          $tempGradePoint += $gPoint * $rv['results'][$paperPerSemesterCount]['cr'];

                        $paperPerSemesterCount++;
                        if($paperPerSemesterCount == $length)
                         {
                           break;
                         }
                    }
                    $creditCompleted = $creditCompleted + $tempCredit;
                    $totalGradePoint = $totalGradePoint + $tempGradePoint;
                    if($tempCredit!=0){
                        $sgpa = round(($tempGradePoint / $tempCredit), 2);
                    }
                    else{
                        $sgpa=0;
                    }
                  
                    if($i==$admitYear)
                     {
                        $cgpa = $sgpa;
                     }
                    else
                     {
                         $cgpa = ($cgpa+$sgpa)/2;
                         $cgpa = round($cgpa,2);
                     }
                      //for printing the footer details
                      $pdf->SetFont('Courier','B',14);
                      $pdf->Cell(15,5,'',0,1);
                      $pdf->cell(50,10,'Credit Counted: ',0,0);
                      $pdf->cell(40,10,$tempCredit,0,0);
                      $pdf->cell(70,10,'Total GP Earned: ',0,0,'R');
                      $pdf->cell(40,10,$tempGradePoint,0,0);
                      $pdf->cell(50,10,'SGPA: ',0,0,'R');
                      $pdf->cell(20,10,$sgpa,0,1);
                       
                      $pdf->Cell(15,5,'',0,1);
                      $pdf->cell(50,10,'Credit Completed: ',0,0);
                      $pdf->cell(40,10,$creditCompleted,0,0);
                      $pdf->cell(70,10,'Total GP Earned: ',0,0,'R');
                      $pdf->cell(40,10,$totalGradePoint,0,0);
                      $pdf->cell(50,10,'CGPA: ',0,0,'R');
                      $pdf->cell(20,10,$cgpa,0,1);

                }        
        }
    
        //$path = 'C:\xampp\htdocs\tempPDF\tempPDF.pdf';
        $pathpdf = $path."/workspace/CourseAdvisor/marksheet.pdf";
        
       //  $path = 'D:\TU\tempPDF\tempPDF.pdf';
        $pdf->Output('F',$pathpdf,true);
      // $pdf->Output('D','temp.pdf');
       //$pdf->Output('temp.pdf','I');
        //pdf ended

      
        $rv[0]['path'] = 'marksheet.pdf';
        echo json_encode($rv);
        exit();  
    }
 else
   {
    echo json_encode($rv);
        exit();  
   }
}
}

?>
