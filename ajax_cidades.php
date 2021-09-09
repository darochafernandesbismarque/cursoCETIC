<?php
include_once 'library/configserver.php';
include_once 'library/consulsql.php';
include_once 'library/fornecedor.php';
include_once 'library/material.php';
include_once 'library/Consulta.php';
include_once 'library/fornecedor.php';
include_once 'library/estado.php';

$cidades = Consulta::consultar("SELECT * FROM municipio WHERE id_estado = '" .$_POST['id']."'");

foreach($cidades as $c){
    echo '<option value="' . $c["id"] . '">'.$c['descricao'].'</option>';
}
?>