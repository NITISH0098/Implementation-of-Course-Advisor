<?php
  require('../CourseAdvisor/PDFmaker/fpdf.php');
  $pdf = new fpdf('l','mm','A4');
  $pdf->AddPage();
  
  //setting up font for the page
  $pdf->SetFont('Arial','B',14);
  $pdf->Cell(270,10,'GRADE CARD',0,1,'C');

  //creating blank spaces
  $pdf->Cell(130,10,'',0,1,'R');

  //Header Details
  $pdf->SetFont('Courier','',14);

  $pdf->Cell(40,10,'School',0,0);
  $pdf->Cell(130,10,': Engineering',0,1);
  $pdf->Cell(40,10,'Department',0,0);
  $DNAME = ": Computer Science and Engineering";
  $pdf->Cell(130,10,$DNAME,0,1);
  $pdf->Cell(40,10,'Programme',0,0);
  $pdf->Cell(130,10,': Master of Computer Application',0,1);
  $pdf->Cell(40,10,'RollNo',1,0);
  $pdf->Cell(110,10,': CSM20053',1,0);
  $pdf->Cell(40,10,'TERM',1,0);
  $pdf->Cell(120,10,': 2020 AUTUMN SEMESTER',1,1);
  $pdf->Cell(40,10,'Name',0,0);
  $pdf->Cell(110,10,': Chow Rohit Chowlik',0,0);
  $pdf->Cell(40,10,'SEMESTER',0,0);
  $pdf->Cell(110,10,': 1',0,1);


  //table header
  $pdf->SetFont('Courier','B',14);
  $pdf->Line(10,80,270,80);
  $pdf->Cell(40,10,'Course Code',0,0);
  $pdf->Cell(120,10,'Course Title',0,0);
  $pdf->Cell(15,10,'L',0,0);
  $pdf->Cell(15,10,'T',0,0);
  $pdf->Cell(15,10,'P',0,0);
  $pdf->Cell(15,10,'Cr',0,0);
  $pdf->Cell(15,10,'Grade Secured',0,0);
  $pdf->Line(10,90,270,90);
  


  $pdf->Output('D','TEMP.pdf');
 // unlink('C:\xampp\htdocs\tempPDF\csm20053.pdf');

?>