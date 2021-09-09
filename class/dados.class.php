<?php
include 'dadossispes.class.php';
class Dados extends Consulta
{
	/*Lista opms por filtro*/
	public	function opmsAll()
	{
		return  ejecutarSQL::consultar("SELECT cod_opm,abrev_opm FROM opm where flag_opm is null or flag_opm='' order by abrev_opm asc");
	}

	/*Lista pedidos por filtro*/
	public	function fornecedorAll()
	{
		return  ejecutarSQL::consultar("SELECT * FROM fornecedor");
	}
	/*Lista opms por filtro*/
	public	function userAll($opm)
	{

		$filtro = $opm == 499 ? '' : 'and u.opm=' . $opm;
		return ejecutarSQL::consultar("SELECT u.id,abrev_opm,rg FROM usuario u,tabopm o where u.opm=o.cod_opm $filtro order by opm desc");
	}
	/*Lista tipos de materiais*/
	public	function tipoMatAll()
	{
		return ejecutarSQL::consultar("SELECT * FROM tipomaterial");
	}
	/*Ultima determinção*/
	public	function ultDeter()
	{
		return  mysqli_fetch_array(ejecutarSQL::consultar("SELECT documento FROM pedido where tipo_doc=3 order by id_pedido desc limit 1"))[0];
	}
}
