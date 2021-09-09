<?php
include_once '../library/usuario.php';

if (isset($_REQUEST['cadastrarUsuario'])) {

 $rg              = $_REQUEST['rg'];
 $status          = $_REQUEST['status'];
 $id_nivelUsuario = $_REQUEST['nivelUsuario'];
 $opmNum          = $_REQUEST['opmNum'];

try {
    usuario::inserir($rg, $status, $id_nivelUsuario, $opmNum);
    echo "<meta http-equiv='refresh' content='0;URL=../busca_usuario.php?ok=inserir' >";
    exit;
} catch (PDOException $e) {
    echo "Erro" . $e->getMessage();
    exit;
}
}
?>