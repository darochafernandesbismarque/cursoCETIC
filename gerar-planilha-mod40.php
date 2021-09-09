 <?php
	session_start();
	include_once('library/configserver.php');
	include 'library/consulsql.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf_8">
		<title>Lista</title>
	<head>
	<body>
		<?php
		$queryentrada           = $_SESSION['qryentrada'];
		$resultado_queryentrada =  ejecutarSQL::consultar($queryentrada);
		$num_rows_entrada       =mysqli_num_rows($resultado_queryentrada);

		$querysaida           =  $_SESSION['qrysaida'];
		$resultado_querysaida = ejecutarSQL::consultar($querysaida);

		$descricao = mysqli_fetch_assoc($resultado_querysaida);

		//Definimos o nome do arquivo que será exportado
		$arquivo = 'mod40-matodonto.xls';
		
		// Criamos uma tabela HTML com o formato da planilha
		$html = '';
		$html .= '<table border="1">';
		$html .= '<tr>';
		$html .= '<td style="text-align:center;"   colspan="3"><h3>MATERIAL :'.mb_strimwidth($descricao['descricao'], 0, 60, "...").'</h3></td>';
		$html .= '<td style="text-align:center;"  colspan="9"><h3>ESTOQUE ATUAL</h3></td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td style="text-align:center;"  colspan="3"><h3>GRUPO: </h3></td>';
		$html .= '<td style="text-align:center;" ><b>EXISTENCIA</b></td>'; 
		$html .= '<td style="text-align:center;" ><b>'.number_format($_SESSION['qntestoque'], 0, ',', '.').'</b></td>';
		$html .= '<td style="text-align:center;" ></td>';
		$html .= '<td style="text-align:center;" ><h3>VALOR<br> UNITARIO </h3></td>';
		$html .= '<td style="text-align:center;" ><h3>'.$descricao['valor_individual'].'</h3></td>';
		$html .= '<td style="text-align:center;" ><h3></h3></td>';
		$html .= '<td style="text-align:center;" ><h3>VALOR <br>TOTAL</h3></td>';
		$html .= '<td style="text-align:center;" ><h3>'.$_SESSION['qntestoque']*$descricao['valor_individual'].'</h3></td>';
		$html .= '<td style="text-align:center;" ><h3></h3></td>';
		$html .= '</tr>';
		
		$html .= '<tr>';

		$html .= '<td style="text-align:center;" colspan="3"></td>';
		$html .= '<td style="text-align:center;"colspan="3"><h4><b>ENTRADA DE MATERIAIS</b></h4></td>';

		$html .= '<td style="text-align:center;"  colspan="3"><h4><b>SAIDAS DE MATERIAIS</b></h4></td>';
		$html .= '<td style="text-align:center;"  colspan="3"><b>ESTOQUE DIARIO</b></td>';
		
		$html .= '</tr>';
		$html .= '<tr>';

		$html .= '<td style="text-align:center;" ><h4><b>DATA</b></h4></td>';
		$html .= '<td style="text-align:center;" ><h4><b>DOCUMENTO: TIPO/N.</b></h4></td>';
		$html .= '<td style="text-align:center;" ><b>PROCEDENCIA OU <br>DESTINO</b></td>';
		$html .= '<td style="text-align:center;" ><b>QUANTIDADE</b></td>';
		$html .= '<td style="text-align:center;" ><b>VALOR UNITARIO</b></td>';
		$html .= '<td style="text-align:center;" ><b>VALOR TOTAL</b></td>';
		
		$html .= '<td style="text-align:center;" ><b>QUANTIDADE</b></td>';
		$html .= '<td style="text-align:center;" ><b>PEDIDO</b></td>';
		$html .= '<td style="text-align:center;" ><b>VALOR TOTAL</b></td>';
		
		$html .= '<td style="text-align:center;" ><b>EXISTENCIA</b></td>';
		$html .= '<td style="text-align:center;" ><b>VALOR UNITARIO</b></td>';
		$html .= '<td style="text-align:center;" ><b>VALOR TOTAL</b></td>';
		
		$html .= '</tr>';
		$resultado_querysaida2 = ejecutarSQL::consultar($querysaida);
		while($row_querysaida = mysqli_fetch_assoc($resultado_querysaida2)){
			$html .= '<tr>';
			//$html .= '<td>SAÍDA</td>';
			$html .= '<td>'.date('d-m-Y', strtotime($row_querysaida["data_saida"])).'</td>';
			$html .= '<td>Num.'.$row_querysaida["documento"].'</td>';
			$html .= '<td>'.utf8_decode($row_querysaida["abrev_opm"]).'</td>';
			
			$html .= '<td></td>';
			$html .= '<td></td>';
			$html .= '<td></td>';

			$html .= '<td>'.$row_querysaida["qnt_saida"].'</td>';
			$html .= '<td>x</td>';
			$html .= '<td>'.$row_querysaida["val_total"].'</td>';
			
			$html .= '<td>'.($row_querysaida["ult_estoque"]-$row_querysaida["qnt_saida"]).'</td>';
			$html .= '<td>'.$row_querysaida["valor_individual"].'</td>';
			$html .= '<td>'.($row_querysaida["ult_estoque"]-$row_querysaida["qnt_saida"])*$row_querysaida["valor_individual"].'</td>';
			
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