<?php
session_start();
error_reporting(0);
include_once 'library/Consulta.php';

$idNota = $_SESSION['id_nota'];

$valor_total = consulta::consultar("SELECT valortotal from entradamaterial WHERE id = '$idNota'");
foreach($valor_total as $valor)
{
    $valor_total_nota = $valor['valortotal'];
    $valor_total_nota2 = str_replace('.', '', $valor_total_nota);
}

$valor = consulta::consultar("SELECT SUM(valorunitario * quantidade) as Valor from entradamaterialitem WHERE id_entradamanterial = '$idNota' AND ativo = 1");
$valortotal = 0;
foreach ($valor as $v) {
$valortotal += $v["Valor"];
}

/*
echo $valor_total_nota2;
echo "<br>";
echo $valortotal;
exit;

if($valor_total_nota2 <> $valortotal){
    echo "Valor diferente da nota!";
}
else {

*/

unset( $_SESSION['nota_numero_rand'] );  
header('location: receber_material.php');

//}
?>