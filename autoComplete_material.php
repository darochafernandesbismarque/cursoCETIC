<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
include 'library/configserver.php';
include 'library/consulsql.php';
$opm_pm = $_SESSION['UserOPM'];
/*
*	Lista todos materiais cadastrados;
*/
$q = strtolower($_GET["q"]);
if (!$q) return;

$rsd  = ejecutarSQL::consultar("	SELECT m.descricao,t.descr,m.id, u.id as idum, u.descricao as descum, m.vl_unit 
							FROM  material m ,tipomaterial t, unid_medida u
											where  m.descricao  LIKE '%$q%'
											and m.id_tipomaterial=t.id
											and u.id=m.medida");

while ($rs = mysqli_fetch_array($rsd)) {
	$id = $rs['id'];
	$material = $rs['descricao'];
	$class = $rs['descr'];
	$qnt = $rs['estoque'];
	$idundmed = $rs['idum'];
	$descunmed = $rs['descum'];
	$vlunit = $rs['vl_unit'];

	echo "$material|$id|$class|$qnt|$idundmed|$descunmed|$vlunit\n";
}
