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
			$opm_logado   = $_SESSION['UserOPM'];
			$resultd = ejecutarSQL::consultar("SELECT m.descricao,m.min,sum(e.qnt_atual)as estoque,(select sum(qnt_saida) FROM pedido where status=1 and m.id=id_material_saida)as reserva, m.id,t.descr 
            FROM  material m,entrada e ,tipomaterial t 
            where e.id_material=m.id 
            and e.qnt_atual<>0
            and t.id = m.id_tipomaterial
            and status=3 
			and opm=$opm_logado
            group by e.id_material");
			//Definimos o nome do arquivo que será exportado
			$arquivo = 'estoque-matodonto.xls';

			// Criamos uma tabela HTML com o formato da planilha
			$html = '';
			$html .= '<table>';
			$html .= '<tr>';
			$html .= '<td style="text-align:center"; colspan="2"><h3>Estoque de Materiais  ' . utf8_decode($_SESSION['UserOPMDesc']) . '</h3></td>';
			$html .= '</tr>';


			$html .= '<tr>';
			//$html .= '<td><b>TIPO</b></td>';
			$html .= '<td><b>DESCRICAO</b></td>';
			$html .= '<td><b>ESTOQUE</b></td>';
			//$html .= '<td><b>VAL. UNITARIO</b></td>';
			//$html .= '<td><b>VAL. TOTAL</b></td>';

			$html .= '</tr>';

			$num_resultd = mysqli_num_rows($resultd);

			if ($num_resultd > 0) {
				while ($row_resultd = mysqli_fetch_assoc($resultd)) {

					$html .= '<tr>';
					//$html .= '<td>'.utf8_decode($row_resultd["descr"]).'</td>';
					$html .= '<td>' . utf8_decode(mb_strimwidth($row_resultd['descricao'], 0, 60, "...")) . '</td>';
					$html .= '<td>' . number_format($row_resultd['estoque'], 0, ',', '.') . '</td>';
					//$html .= '<td>'.$row_resultd["vl_unit"].'</td>';
					//$html .= '<td>'.$row_resultd["estoque"]*$row_resultd["vl_unit"].'</td>';
					$html .= '</tr>';;
				}
			}

			$html .= '<tr><td colspan="2"><td></tr><tr>';
			$html .= '<td style="text-align:center"; colspan="2">Gerado em ' . date("d-m-Y H:i") . '</td>';
			$html .= '</tr>';
			// Configurações header para forçar o download
			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
			header("Cache-Control: no-cache, must-revalidate");
			header("Pragma: no-cache");
			header("Content-type: application/x-msexcel");
			header("Content-Disposition: attachment; filename=\"{$arquivo}\"");
			header("Content-Description: PHP Generated Data");
			// Envia o conteúdo do arquivo
			echo $html;
			//unset($_SESSION['filtroXls']);
			exit; ?>
 	</body>

 </html>