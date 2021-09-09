 <?php
	session_start();
	include_once('library/configserver.php');
	include 'library/consulsql.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Lista</title>
	<head>
	<body>
		<?php
		if(isset($_GET['id'])){
        	$id_material 		= $_GET['id'];
        	$idMaterialEntrada 	= 'and id_material='.$id_material;
        	$idMaterialSaida 	= 'and id_material_saida='.$id_material;
        }else{
        	$idMaterialEntrada 	='';
        	$idMaterialSaida 	='';
        }

        if(isset($_SESSION['filtroXls']) && $_SESSION['filtroXls'] != null){
        	$val = $_SESSION['filtroXls'];
        	$filtroXls = explode('.', $val);
        
        	$datainic  = $filtroXls[0];
        	$datafim   = $filtroXls[1];
        	$desst     = $filtroXls[2];        
        	
        }else{
        	$datainic 	= strftime('%Y-%m-%d', strtotime('-1 Month'));
        	$datafim 	= date("Y-m-d");
        }
		
		//Definimos o nome do arquivo que será exportado
		$arquivo = 'relatorio-siscods.xls';
		
		// Criamos uma tabela HTML com o formato da planilha
		$html = '';
		$html .= '<table border="1">';
		$html .= '<tr>';
		$html .= '<td style="text-align:center"; colspan="9"><h3>Planilha de Movimentacoes de Materiais</h3></td>';
		$html .= '</tr>';
		
		
		$html .= '<tr>';
		//$html .= '<td><b>MOVIMENTAÇÃO</b></td>';
		$html .= '<td><b>DATA</b></td>';
		$html .= '<td><b>DESCRICAO</b></td>';
		$html .= '<td><b>QUANTIDADE</b></td>';
		$html .= '<td><b>VAL. UNITARIO</b></td>';
		$html .= '<td><b>VAL. TOTAL</b></td>';
		$html .= '<td><b>DOCUMENTO</b></td>';
		$html .= '<td><b>NUMERO</b></td>';
		$html .= '<td><b>DATA</b></td>';
		$html .= '<td><b>DESTINO</b></td>';
		
		$html .= '</tr>';
		
		$queryentrada =$_SESSION['qryentrada'];
		$resultado_queryentrada =  ejecutarSQL::consultar($queryentrada);
		$num_rows_entrada=mysqli_num_rows($resultado_queryentrada);

		$querysaida =  $_SESSION['qrysaida'];
		$resultado_querysaida = ejecutarSQL::consultar($querysaida);

	if($num_rows_entrada>0){
		$html .= '<td colspan="9"><h3>ENTADAS</h3></td>';
		
		while($row_queryentrada = mysqli_fetch_assoc($resultado_queryentrada)){
			$html .= '<tr style"text-align:center;">';
			//$html .= '<td>ENTRADA</td>';
			$html .= '<td>'.date('d-m-Y', strtotime($row_queryentrada["data"])).'</td>';
			$html .= '<td>'.mb_strimwidth($row_queryentrada['descricao'], 0, 60, "...").'</td>';
			$html .= '<td>'.$row_queryentrada["qnt"].'</td>';
			$html .= '<td>'.$row_queryentrada["vl_unit"].'</td>';
			$html .= '<td>'.$row_queryentrada["vl_total"].'</td>';
			$html .= '<td>'.$row_queryentrada["documento"].'</td>';
			$html .= '<td>'.$row_queryentrada["nf"].'</td>';
			$html .= '<td>'.'00/00/0000'.'</td>';
			$html .= '<td></td>';
			$html .= '</tr>';
			;
		}
	}		
		$html .= '<td style="text-align:center"; colspan="9"><h3>SAIDAS</h3></td>';
		while($row_querysaida = mysqli_fetch_assoc($resultado_querysaida)){
			$html .= '<tr>';
			//$html .= '<td>SAÍDA</td>';
			$html .= '<td>'.date('d-m-Y', strtotime($row_querysaida["data_saida"])).'</td>';
			$html .= '<td>'.$row_querysaida["descricao"].'</td>';
			$html .= '<td>'.$row_querysaida["qnt_saida"].'</td>';
			$html .= '<td>'.$row_querysaida["valor_individual"].'</td>';
			$html .= '<td>'.$row_querysaida["val_total"].'</td>';
			$html .= '<td>'.$row_querysaida["tipo_doc"].'</td>';
			$html .= '<td>'.$row_querysaida["documento"].'</td>';
			$html .= '<td>'.$row_querysaida["dt_doc"].'</td>';
			$html .= '<td>'.$row_querysaida["abrev_opm"].'</td>';
			$html .= '</tr>';
			;
		}
		
		// Configurações header para forçar o download
		header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
		header ("Content-type: application/x-msexcel");
		header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
		header ("Content-Description: PHP Generated Data" );
		// Envia o conteúdo do arquivo
		echo $html;
		//unset($_SESSION['filtroXls']);
		exit; ?>
	</body>
</html>