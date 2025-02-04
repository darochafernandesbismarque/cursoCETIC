<?php
require './fpdf/fpdf.php';
include '../library/configServer.php';
include '../library/consulSQL.php';
include '../library/SelectMonth.php';
$loanCode=consultasSQL::CleanStringText($_GET['loanCode']);
$selectInstitution=ejecutarSQL::consultar("SELECT * FROM institucion");
$dataInstitution=mysql_fetch_array($selectInstitution);
$selectLoan=ejecutarSQL::consultar("SELECT * FROM prestamo WHERE CodigoPrestamo='".$loanCode."'");
$dataLoan=mysql_fetch_array($selectLoan);
$selectBook=ejecutarSQL::consultar("SELECT * FROM libro WHERE CodigoLibro='".$dataLoan['CodigoLibro']."'");
$dataBook=mysql_fetch_array($selectBook);
$selectUser=ejecutarSQL::consultar("SELECT * FROM prestamovisitante WHERE CodigoPrestamo='".$loanCode."'");
$dataUser=mysql_fetch_array($selectUser);
if($dataLoan['FechaSalida']!=""){
    $SelectDayFS=date("d",strtotime($dataLoan['FechaSalida']));
    $SelectMonthFS=date("m",strtotime($dataLoan['FechaSalida']));
    $SelectYearFS=date("Y",strtotime($dataLoan['FechaSalida']));
    $SelectMontNameFS=CalMonth::CurrentMonth($SelectMonthFS);
    $SelectDateFS=$SelectDayFS.' de '.$SelectMontNameFS.' de '.$SelectYearFS;
    $SelectDayFE=date("d",strtotime($dataLoan['FechaEntrega']));
    $SelectMonthFE=date("m",strtotime($dataLoan['FechaEntrega']));
    $SelectYearFE=date("Y",strtotime($dataLoan['FechaEntrega']));
    $SelectMontNameFE=CalMonth::CurrentMonth($SelectMonthFE);
    $SelectDateFE=$SelectDayFE.' de '.$SelectMontNameFE.' de '.$SelectYearFE;
}else{
    $SelectDateFS="";
    $SelectDateFE="";
}
class PDF extends FPDF{
}
$pdf=new PDF('P','mm','Letter');
$pdf->AddPage();
$pdf->SetFont("Times","",20);
$pdf->SetMargins(25,20,25);
$pdf->SetFillColor(0,255,255);
$pdf->Image('../assets/img/slv.png',25,16,20,20);
$pdf->Image('../assets/img/ins.png',170,16,18,20);
$pdf->Ln(10);
$pdf->Cell (0,5,utf8_decode($dataInstitution['Nombre']),0,1,'C');
$pdf->Ln(5);
$pdf->SetFont("Times","b",17);
$pdf->Cell (0,5,utf8_decode('Solicitud de libros para visitantes'),0,1,'C');
$pdf->Ln(20);
$pdf->SetFont("Times","b",12);
$pdf->Cell (18,5,utf8_decode('Nombre: '),0);
$pdf->SetFont("Times","",12);
$pdf->Cell (140,5,utf8_decode($dataUser['Nombre']),0);
$pdf->Ln(9);
$pdf->SetFont("Times","b",12);
$pdf->Cell (58,5,utf8_decode('Institución de donde nos visita: '),0);
$pdf->SetFont("Times","",12);
$pdf->Cell (99,5,utf8_decode($dataUser['Institucion']),0);
$pdf->Ln(9);
$pdf->SetFont("Times","b",12);
$pdf->Cell (9,5,utf8_decode('Tel: '),0);
$pdf->SetFont("Times","",12);
$pdf->Cell (120,5,utf8_decode($dataUser['Telefono']),0);
$pdf->Ln(17);
$pdf->SetFont("Times","b",12);
$pdf->Cell (36,5,utf8_decode('Nombre del Libro: '),0);
$pdf->SetFont("Times","",12);
$pdf->Cell (120,5,utf8_decode($dataBook['Titulo']),0);
$pdf->Ln(9);
$pdf->SetFont("Times","b",12);
$pdf->Cell (32,5,utf8_decode('Autor del Libro: '),0);
$pdf->SetFont("Times","",12);
$pdf->Cell (119,5,utf8_decode($dataBook['Autor']),0);
$pdf->Ln(9);
$pdf->SetFont("Times","b",12);
$pdf->Cell (32,5,utf8_decode('Código de libro: '),0);
$pdf->SetFont("Times","",12);
$pdf->Cell (119,5,utf8_decode($dataLoan['CorrelativoLibro']),0);
$pdf->Ln(17);
$pdf->SetFont("Times","b",12);
$pdf->Cell (30,5,utf8_decode('Fecha solicitud: '),0);
$pdf->SetFont("Times","",11);
$pdf->Cell (44,5,utf8_decode($SelectDateFS),0);
$pdf->SetFont("Times","b",12);
$pdf->Cell (28,5,utf8_decode('Fecha entrega: '),0);
$pdf->SetFont("Times","",11);
$pdf->Cell (39,5,utf8_decode($SelectDateFE),0);
$pdf->Ln(12);
$pdf->SetFont("Times","b",12);
$pdf->Cell (20,5,utf8_decode('N de DUI: '),0);
$pdf->SetFont("Times","",12);
$pdf->Cell (45,5,utf8_decode($dataUser['DUI']),0);
$pdf->SetFont("Times","b",12);
$pdf->Cell (6,5,utf8_decode('F:'),0);
$pdf->Cell (60,5,utf8_decode('_________________________'),0);
$pdf->Ln(17);
$pdf->SetFont("Times","",12);
$pdf->Cell (0,5,utf8_decode('Nota: Señor/a visitante para solicitar libros de biblioteca deberá presentar su propio'),0);
$pdf->Ln(7);
$pdf->Cell (0,5,utf8_decode('Documento de identificación Único, asi también se le hace del conocimiento que los'),0);
$pdf->Ln(7);
$pdf->Cell (0,5,utf8_decode('prestamos son internos, ya que no podrá sacar los libros de la institución, y si el libro'),0);
$pdf->Ln(7);
$pdf->Cell (0,5,utf8_decode('sufre daños en el tiempo que esta a su responsabilidad deberá responder por ellos.'),0);
$pdf->Ln(25);
$pdf->Cell (83,5,utf8_decode('___________________________'),0,0,'C');
$pdf->Cell (83,5,utf8_decode('___________________________'),0,0,'C');
$pdf->Ln(7);
$pdf->Cell (83,5,utf8_decode('Lic. Ernesto Abarca'),0,0,'C');
$pdf->Cell (83,5,utf8_decode('Lic. Rosa Mirna Mejía López'),0,0,'C');
$pdf->Ln(7);
$pdf->Cell (83,5,utf8_decode('Director Inst. Nac. de Sensuntepeque'),0,0,'C');
$pdf->Cell (83,5,utf8_decode('Bibliotecaria'),0,0,'C');
$pdf->Output('N-'.$loanCode,'I');
mysql_free_result($selectLoan);
mysql_free_result($selectBook);
mysql_free_result($selectUser);
mysql_free_result($selectInstitution);