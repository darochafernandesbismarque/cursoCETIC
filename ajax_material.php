<?php
include_once 'library/configserver.php';
include_once 'library/consulsql.php';
include_once 'library/fornecedor.php';
include_once 'library/material.php';
include_once 'library/Consulta.php';
include_once 'library/fornecedor.php';
include_once 'library/estado.php';

$like = $_REQUEST['id'];
$material = Consulta::consultar("SELECT * FROM material WHERE descricao LIKE '$like%'");
foreach ($material as $m) {
    //echo '<option value="' . $m['id'] . " - " . $m['descricao'] .'">' . $m['descricao'] . '</option>';
    echo '<option value="' . $m['id'] . "-" . $m['descricao'] .'"> </option>';
}
?>