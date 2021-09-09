<?php
ob_start();
session_start();
define("FPDF_FONTPATH", "fonts/");
require_once("fpdf/fpdf.php");
include '../library/consulsql.php';
include '../library/configserver.php';
//include '../class/materiais.class.php';

setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$sol = $_GET['sol'];
?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<?php
$query = "SELECT id_material_saida,tipo_doc,s.id_entrada,s.dt_doc,s.documento,s.status,s.user_saida,s.destino,data_pedidos,val_total,s.documento,s.dt_doc,o.abrev_opm,m.descricao,s.valor_individual,s.ult_estoque, s.qnt_saida,u.descricao as unidade FROM pedido s,material m, tabopm o,unid_medida u WHERE pedido='$sol' and s.id_material_saida=m.id and s.destino=o.cod_opm and u.id=m.medida";
$resultado_querysaida = ejecutarSQL::consultar($query);
$resutado1 = mysqli_fetch_array(ejecutarSQL::consultar($query));

$pdf = ob_get_clean();

class PDF extends FPDF
{

	function Header()

	{

		$this->Image('rj.jpg', 100, 5, 20, 0, 'jpg');
		$this->SetFont('times', '', 11);
		$this->Ln(15);
		$titulo = 'Governo do Estado do Rio de Janeiro';
		$titulo1 = 'Secretaria de Estado de Pol�cia Militar';
		$titulo2 = $row_opm["desc_opm"];
		$titulo3 = 'RESERVA N� ' . $_GET['sol'];
		$titulo4 = 'Para : ' . $resutado1['abrev_opm'];
		$titulo5 = 'De   : DGO';
		$titulo6 = 'Assunto : Solicita��o de Material';

		$datenow = 'Rio de Janeiro,  ' . strftime('%d de %B de %Y', strtotime('today'));

		$this->Cell(200, 5, $titulo, 0, 0, 'C');
		$this->Ln(4);
		$this->Cell(200, 5, $titulo1, 0, 0, 'C');
		$this->Ln(4);
		$this->Cell(200, 5, $titulo2, 0, 0, 'C');
		$this->Ln(10);
		$this->Ln(6);
		$this->SetFont('Arial', 'B', 10);
		$this->Cell(50, 5, $titulo3, 0, 0, '');
		$this->SetFont('times', '', 11);
		$this->Cell(200, 5, $datenow, 0, 0, 'C');
		$this->Ln(6);
		$this->Cell(50, 5, $titulo4, 0, 0, '');
		$this->Ln(6);
		$this->Cell(50, 5, $titulo5, 0, 0, '');
		$this->Ln(6);
		$this->Cell(50, 5, $titulo6, 0, 0, '');
		$this->Ln(10);
	}
	function Footer()
	{
		$this->SetY(-15);
		$this->SetTextColor(255, 0, 0);
		$this->Cell(20, 0);
		$this->SetFont('Arial', 'B', 10);
		$this->Cell(0, 0, '', 1, 0, 'C');
		$this->SetTextColor(0, 0, 0);
		$this->Ln();
		$this->SetFont('Times', 'I', 9);
		//$data=date('d/m/Y');
		$this->Cell(0, 10, 'Rua Evaristo da Veiga, N� 78 - Bairro Centro, Rio de Janeiro/RJ, CEP 20.031-040 Telefone: 2333-2563', 0, 0, 'C');
	}
}

$titulo7 = '  							 Este comandante solicita informa��es sobre a existencia do material abaixo, conforme cumprimento  ';
$titulo8 = 'do item V, art. 12, do decreto n 3.147 de 28 de abril de 1980.';


$pdf = new PDF('P', 'mm', 'Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetAuthor('Barbosa - CETIC - Desenvolvimento');
$pdf->SetKeywords('DGO');
$pdf->SetTitle('SOLICITA��O DE ESTOQUE DE MERCADORIA');
$pdf->SetFont('Arial', '', 7);
$pdf->SetTextColor(0, 0, 0);

$pdf->SetFillColor(200, 200, 200);
$pdf->SetTextColor(0);
$pdf->SetFont('times', '', 9);
$i = 1;

//$pdf->Cell(190,5,$titulo7,0,0,'C');
$pdf->Ln(4);
//$pdf->Cell(100,5,$titulo8,0,0,'');
$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 9);
$pdf->SetLineWidth(0);
$pdf->Cell(20, 5, 'ITEM', 1, 0, 'C');
$pdf->Cell(100, 5, 'ESPECIFICA��O', 1, 0, 'C');
$pdf->Cell(40, 5, 'UNIDADE', 1, 0, 'C');
$pdf->Cell(40, 5, 'QUANTIDADE', 1, 0, 'C');

$pdf->Ln(4);

$pdf->SetFont('times', '', 9);

while ($row_querysaida = mysqli_fetch_assoc($resultado_querysaida)) {
	$pdf->Cell(20, 10, $i, 'LR', 0, 'C');
	$pdf->Cell(100, 10, $row_querysaida["descricao"], 'LR', 0, 'C');
	$pdf->Cell(40, 10, $row_querysaida["unidade"], 'LR', 0, 'C');
	$pdf->Cell(40, 10, $row_querysaida["qnt_saida"], 'LR', 0, 'C');
	$pdf->Ln(10);
	$i++;
}

$pdf->Cell(200, 0, "", 1, 0);
$pdf->Ln(20);




$pdf->Output('sol-estoque.pdf', 'I');
?>

</html>