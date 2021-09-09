<?php

class Materiais
{
	/*Lista pedidos por filtro*/
	public	function listaPedidos($filtro)
	{
		return  ejecutarSQL::consultar("SELECT * FROM pedido s,material m, tabopm o,tipodoc t WHERE $filtro s.id_material_saida=m.id and s.destino=o.cod_opm and t.id=s.tipo_doc order by id_pedido desc");
	}

	/*Busca reserva por numero*/
	public	function getReserva($num)
	{
		return  ejecutarSQL::consultar("SELECT id_material_saida,tipo_doc,s.id_entrada,s.dt_doc,s.documento,s.status,s.user_saida,s.destino,data_pedidos,val_total,s.documento,s.dt_doc,abrev_opm,m.descricao,s.valor_individual,s.ult_estoque, s.qnt_saida,u.descricao as unidade FROM pedido s,material m, tabopm o,unid_medida u WHERE pedido='$num' and s.id_material_saida=m.id and s.destino=o.cod_opm and u.id=m.medida");
	}
	public	function listaMaterialOpm($opm)
	{
		return  ejecutarSQL::consultar("SELECT m.siga,m.descricao,m.id,e.vl_uni,e.qnt_atual,e.id_material,t.descr,e.id 
		      FROM  material m,entrada e ,tipomaterial t 
		      where e.id_material=m.id 
		      and t.id = m.id_tipomaterial
		      and status=3 
		      and e.qnt_atual>0 and id_opm =$opm");
	}

	/*Cria a reserva de materiais*/
	public	function criaReservaMaterial($dados)
	{

		$pm_logado  = $_SESSION['UserRG'];
		$opm_logado = $_SESSION['UserOPM'];

		$ultpedido = mysqli_fetch_array(ejecutarSQL::consultar("SELECT pedido FROM pedido where opm='$opm_logado' order by id_pedido desc limit 1"))[0];

		if ($ultpedido) {
			$partes = explode('/', $ultpedido);
			$parte =  $partes[1] == date("Y") ? $partes[0] + 1 : '1';
		} else {
			$parte = '1';
		}
		for ($count = 0; $count < count($_POST["idmaterial"]); $count++) {
			$destino        = $_POST['destino'];
			$separa         = explode(";", $_POST['idmaterial'][$count]);
			$idmaterial     = $separa[0];
			$id_entrada     = $separa[4];
			$estoque        =  mysqli_fetch_array(ejecutarSQL::consultar("SELECT qnt_atual FROM entrada  where id_entrada= '$id_entrada'"))[0];
			$qnt            = str_replace('.', '', $_POST['qnt'])[$count];

			$vl_individual  = $_POST['vl_individual'][$count];
			$vl_total       = $qnt * $vl_individual;
			$data_hoje      = date("Y-m-d");
			$numsol         = $parte . '/' . date("Y");

			$tipo_doc       = $_POST['tipo_doc'][$count];
			$documento      = $_POST['documento'][$count];
			$dt_doc         = $_POST['dt_doc'][$count];

			$tabela = 'pedidos';
			$campos = "data_pedidos,id_material_saida,ult_estoque,qnt_saida,valor_individual,destino,val_total,documento,user_saida,pedido,tipo_doc,dt_doc,status,opm,id_entrada";
			$valores = "'$data_hoje','$idmaterial','$estoque','$qnt','$vl_individual','$destino','$vl_total','$documento','$pm_logado','$numsol','$tipo_doc','$dt_doc',1,'$opm_logado','$id_entrada'";

			$id_insert = consultasSQL::InsertSQL($tabela, $campos, $valores);

			$qntfinal = $estoque - $qnt;

			$tabela = 'entrada';
			$campos = "qnt_atual='$qntfinal'";
			$condicion = "id_entrada='$id_entrada'";
			$id_insert = consultasSQL::UpdateSQL($tabela, $campos, $condicion);
		}
		return true;
	}

	public	function excluirReservaMaterial($dados)
	{
		$opm_logado = $_SESSION['UserOPM'];
		$pedido = $_POST['reserva'];
		$obs    = $_POST['obs'];

		$qry = ejecutarSQL::consultar("SELECT qnt_saida,id_material_saida,id_entrada FROM pedido where pedido= '$pedido'");
		while ($material =  mysqli_fetch_assoc($qry)) {

			$estoque        =  mysqli_fetch_array(ejecutarSQL::consultar("SELECT qnt_atual FROM entrada  where id_entrada= '$material[id_entrada]'"))[0];
			$estoquenew = $estoque + $material['qnt_saida'];

			$tabela   = 'entrada';
			$campos   = "qnt_atual=" . $estoquenew;
			$condicion = "id_entrada= '$material[id_entrada]'";

			if (consultasSQL::UpdateSQL($tabela, $campos, $condicion)) {
				$tabela   = 'pedidos';
				$campos   = "status='2',obs='$obs'";
				$condicion = "pedido='$pedido'";
				consultasSQL::UpdateSQL($tabela, $campos, $condicion);
			}
		}
		return true;
	}

	public	function consumoMaterial($dados)
	{
		$opm_logado = $_SESSION['UserOPM'];
		$pm_logado  = $_SESSION['UserRG'];

		for ($count = 0; $count < count($_POST["idmaterial"]); $count++) {
			$destino        = $_POST['destino'];
			$separa         = explode(";", $_POST['idmaterial'][$count]);
			//$vl_total     = $_POST['vl_total'][$count];
			$idmaterial     = $separa[0];
			$vl_uni     	= $separa[2];
			$id_entrada     = $separa[4];
			$qnt            = str_replace('.', '', $_POST['qnt'])[$count];
			$vl_total     	= $vl_uni * $qnt;

			//$estoque      =  mysqli_fetch_array(ejecutarSQL::consultar("SELECT qnt_atual FROM entrada  where id_entrada= '$id_entrada'"))[0];
			$estoque        =  entrada::consultar("SELECT qnt_atual FROM entrada  where id_entrada= '$id_entrada'")[0];

			$data_hoje      = date("Y-m-d");
			$numsol         = 'Baixa-Material'; //$parte.'/'.$opm_logado.'/'.date("Y");  

			$tabela = 'saida';
			$campos = "data_saida,id_material_saida,ult_estoque,qnt_saida,destino,user_saida,m60,status,opm,id_entrada,valor_individual,val_total,tipo_doc";
			$valores = "'$data_hoje','$idmaterial','$estoque','$qnt','$destino','$pm_logado','$numsol',3,'$opm_logado','$id_entrada','$vl_uni','$vl_total',3";

			if (consultasSQL::InsertSQL($tabela, $campos, $valores)) {
				$qntfinal = $estoque - $qnt;
				$tabela = 'entrada';
				$campos = "qnt_atual='$qntfinal'";
				$condicion = "id_entrada='$id_entrada'";
				$id_insert = consultasSQL::UpdateSQL($tabela, $campos, $condicion);
			}
		}
		return $numsol;
	}

	/*Entrada de material confirmado recebimento*/
	public static	function entradaMaterial($m60)
	{
		$opm_logado = $_SESSION['UserOPM'];

		$pendente = ejecutarSQL::consultar("SELECT * FROM saida where destino='$opm_logado' and m60='$m60'");
		$dados = mysqli_fetch_array($pendente);
		//var_dump($dados);
		//exit;
		while ($dados = mysqli_fetch_array($pendente)) {

			$idmaterial    = $dados['id_material_saida'];
			$qnt           = $dados['qnt_saida'];

			$vl_individual = $dados['valor_individual'];
			$vl_total      = $dados['val_total'];
			$pm_logado     = $_SESSION['UserRG'];
			$data_hoje     = date("Y-m-d");
			$tipo_doc      = '4'; //Modelo 60

			$numeracao     = $dados['m60'];
			$dt_doc        = $dados['dt_doc'];
			$destino       = $dados['destino'];
			$fornecedor    = '99'; //DGO;

			//ENTRADA
			$tabela = 'entrada';
			$campos = "id_fornecedor,id_material,qnt,qnt_atual,vl_uni,vl_total,user,data,documento,nf,dt_doc,tipo_verba,und_medida,opm,validade,rg_conferente";
			$valores = "'$fornecedor','$idmaterial','$qnt','$qnt','$vl_individual','$vl_total','$pm_logado','$data_hoje','$tipo_doc','$numeracao','$dt_doc','1','1','$destino','0000-00-00',''";

			consultasSQL::InsertSQL($tabela, $campos, $valores);

			$tabela = 'saida';
			$condicion = "m60='$m60' and destino=" . $opm_logado;
			$campos = "status=3,rg_status=" . $_SESSION['UserRG'];
			consultasSQL::UpdateSQL($tabela, $campos, $condicion);
		}

		return true;
	}

	/*Lista todos materiais por filtro*/
	public	function listaMaterialFiltro($filtro, $opm)
	{
		return  ejecutarSQL::consultar("SELECT m.descricao,m.min,sum(e.qnt_atual)as estoque, m.id,t.descr 
            FROM  material m,entrada e ,tipomaterial t 
            where e.id_material=m.id 
            and e.qnt_atual<>0
            and t.id = m.id_tipomaterial
            $filtro $opm
            group by e.id_material");

		/*
		 return  ejecutarSQL::consultar("SELECT m.descricao, e.estoque, m.id, e.min,t.descr FROM  material m,estoque_opm e ,tipomaterial t where e.id_material=m.id and t.id = m.id_tipomaterial and e.estoque<>0 $filtro"); */
	}
}
