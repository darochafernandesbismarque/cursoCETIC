<?php

session_start();
	include 'library/configserver.php';
	include 'library/consulsql.php';
	class modelo60{

	 	public	function listaMateriais($numero){
	 		$query = "SELECT s.status,s.user_saida,s.destino,data_saida,m60,abrev_opm,m.descricao,
				s.ult_estoque, s.qnt_saida,u.descricao as unidade
				FROM saida s,material m, tabopm o,unid_medida u 
				WHERE m60='$numero' and s.id_material_saida=m.id and s.opm=o.cod_opm and u.id=m.medida";
			
	 		return  ejecutarSQL::consultar($query);
	 
		}
		public	function listaQnt($numero){
		/*Lista id e quantidade dos materiais do documento*/
 			$qrym60="SELECT s.id_material_saida,s.qnt_saida,s.id_entrada,s.opm from saida s,material m WHERE s.m60 ='$numero' and s.id_material_saida=m.id";

 			return ejecutarSQL::consultar($qrym60);
		}

		public	function excluirmod60($numero,$obs){

			$rs  = modelo60::listaQnt($numero);

			while ($result = mysqli_fetch_array($rs)){
	    	
	    	$tabela = 'saida';
	    	$condicion="m60='$numero'"; 
	    	$campos	= "status=2,obs='$obs',rg_status=".$_SESSION['UserRG'];

	        if($retorno = consultasSQL::UpdateSQL($tabela, $campos, $condicion)){
	        	  
	        	$qnt 			= $result['qnt_saida'];
	    		$id_material 	= $result['id_material_saida'];
	    		$opm        	= $result['opm'];
	    		$estoque 		= mysqli_fetch_array(ejecutarSQL::consultar("SELECT estoque from estoque_opm where id_material='$id_material' and opm='$opm'"))[0];

	    		$qntfinal 		= $estoque + $qnt;

	    		$tabela    		= "estoque_opm";
	    		$campos 		= "estoque='$qntfinal'";
	    		$condicion      = "id_material='$id_material' and opm='$opm'"; 
	    		
	    		return consultasSQL::UpdateSQL($tabela, $campos, $condicion);
	        } 	
		}
	}
}