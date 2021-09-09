<?php
ob_start();
session_start();
define("FPDF_FONTPATH","font/");
require_once("fpdf/fpdf.php");
include_once('library/conexao.php');

setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

$solicitacao =$_GET['id']; 	
$querysaida = "SELECT m.descricao, u.descricao as unidade,abrev_opm, qnt_saida, abrev,desc_opm FROM saida s,material m,tabopm o, unid_medida u WHERE m60='$solicitacao' and s.id_material_saida=m.id and u.id=m.medida and s.destino=o.cod_opm " ;
$resultado_querysaida = mysqli_query($conn, $querysaida);
	
?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<?php

	$pdf=ob_get_clean();

class PDF extends FPDF
{

function Header()

{
	$solicitacao =$_GET['id']; 	
/*	$querysaida1 = "SELECT desc_opm FROM saida s,tabopm o WHERE m60='$solicitacao'  and s.destino=o.cod_opm " ;
$queryopm = mysqli_query($conn, $querysaida1);
$row_opm = mysqli_fetch_assoc($queryopm);
var_dump($row_opm);*/

	$this->Image('pmerj.jpg',100,5,20,0,'jpg');
    $this->SetFont('times','',11);
	$this->Ln(15);
	$titulo='Governo do Estado do Rio de Janeiro';
	$titulo1='Secretaria de Estado de Polícia Militar';
	$titulo2=$row_opm["desc_opm"];
	$titulo3='C.I. PMERJ/31° BPM N° '.$solicitacao;
	$titulo4='Para : Diretor da Diretoria de Abastecimento';
	$titulo5='De   : Comandante do 31° BPM';
	$titulo6='Asunto : Solicitação de informação sobre estoque de material';

 	$datenow='Rio de Janeiro,  '.strftime('%d de %B de %Y', strtotime('today'));
 	//$data do banco ; strftime('%A, %d de %B de %Y', strtotime($row_artigo['data']));	
	
	$this->Cell(200,5,$titulo,0,0,'C');
	$this->Ln(4);
	$this->Cell(200,5,$titulo1,0,0,'C');
    $this->Ln(4);
	$this->Cell(200,5,$titulo2,0,0,'C');
	$this->Ln(10);
	$this->Ln(6);
	$this->Cell(50,5,$titulo3,0,0,'');
	$this->Cell(200,5,$datenow,0,0,'C');
	$this->Ln(6);
	$this->Cell(50,5,$titulo4,0,0,'');
	$this->Ln(6);
	$this->Cell(50,5,$titulo5,0,0,'');
	$this->Ln(6);
	$this->Cell(50,5,$titulo6,0,0,'');
	$this->Ln(10);
	
	
}
function Footer()
{
    $this->SetY(-15);
	$this->SetTextColor(255,0,0);
	$this->Cell(20,0);
    $this->SetFont('Arial','B',10);
	$this->Cell(0,0,'',1,0,'C');
	$this->SetTextColor(0,0,0);
	$this->Ln();
    $this->SetFont('Times','I',9);
	//$data=date('d/m/Y');
    $this->Cell(0,10,'Rua Evaristo da Veiga, Nº 78 - Bairro Centro, Rio de Janeiro/RJ, CEP 20.031-040 Telefone: 2333-2563',0,0,'C');
}
}
$resultado_querysaida1 = mysqli_query($conn, $querysaida);
$resutado1=mysqli_fetch_assoc($resultado_querysaida1);

$titulo7='  							 Este comandante solicita informações sobre a existencia do material abaixo, conforme cumprimento  ';
 $titulo8='do item V, art. 12, do decreto n 3.147 de 28 de abril de 1980.';

$comandante='WALLACE BARBOSA DE SOUZA - TCEL PM';
$unidade='Comandante do '.$resutado1["desc_opm"];
$idfuncional='ID 50186302';

$chefe='WALLACE BARBOSA DE SOUZA - MAJ PM';
$idfuncional2='ID 50186345';

$nexiste='Não existe em estoque de almoxarifado em '.$data=date("d/m/Y").' o(s) material(is) correspondentes aos intens _________';
$sexiste='Existe em estoque de almoxarifado em '.$data=date("d/m/Y").' o(s) material(is) correspondentes aos intens _________';

$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetAuthor('Barbosa - CETIC - Desenvolvimento');
$pdf->SetKeywords('Dabst - Diretoria de abastecimento');
$pdf->SetTitle('SOLICITAÇÃO DE ESTOQUE DE MERCADORIA');
$pdf->SetFont('Arial','',7);
$pdf->SetTextColor(0,0,0);

$pdf->SetFillColor(200,200,200);
$pdf->SetTextColor(0);
$pdf->SetFont('times', '', 9);
$i=1;

$pdf->Cell(190,5,$titulo7,0,0,'C');
$pdf->Ln(4);
$pdf->Cell(100,5,$titulo8,0,0,'');
$pdf->Ln(10);

$pdf->SetFont('Arial','B',9);
$pdf->SetLineWidth(0);
$pdf->Cell(20,5,'ITEM',1,0,'C');
$pdf->Cell(100,5,'ESPECIFICAÇÃO',1,0,'C');
$pdf->Cell(40,5,'UNIDADE',1,0,'C');
$pdf->Cell(40,5,'QUANTIDADE',1,0,'C');

$pdf->Ln(4);

$pdf->SetFont('times','',9);


while($row_querysaida = mysqli_fetch_assoc($resultado_querysaida)){	
	$pdf->Cell(20,10, $i,'LR',0,'C');
	$pdf->Cell(100,10,$row_querysaida["descricao"],'LR',0,'C');
	$pdf->Cell(40,10,$row_querysaida["unidade"],'LR',0,'C');
	$pdf->Cell(40,10,$row_querysaida["qnt_saida"],'LR',0,'C');
	$pdf->Ln(10);
	$i++;		
}

$pdf->Cell(200,0,"",1,0);
$pdf->Ln(20);
$pdf->Cell(200,5,$comandante,0,0,'C');
$pdf->Ln(5);
$pdf->Cell(200,5,$unidade,0,0,'C');
$pdf->Ln(5);
$pdf->Cell(200,5,$idfuncional,0,0,'C');

$pdf->Ln(10);
$pdf->Cell(200,5,'Por Ordem:',0,0,'');

$pdf->Ln(10);
$pdf->Cell(200,5,$chefe,0,0,'C');
$pdf->Ln(5);
$pdf->Cell(200,5,'CHEFE P/4',0,0,'C');
$pdf->Ln(5);
$pdf->Cell(200,5,$idfuncional2,0,0,'C');
$pdf->Ln(15);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(200,5,'GABINETE DO DIRETOR DA DAbst',0,0,'C');
$pdf->Ln(15);
$pdf->SetFont('times','',9);
$pdf->Cell(200,5,$nexiste,0,0,'');
$pdf->Ln(5);
$pdf->Cell(200,5,$sexiste,0,0,'');

$unidade= mysqli_fetch_assoc($resultado_querysaida);

$pdf->Output('sol-estoque.pdf','I');
?>
</html>