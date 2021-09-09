<?php
include "../library/tipodocumento.php";

if (isset($_REQUEST['descritivo'])) {

    $descritivo = $_REQUEST['descritivo'];

    try {
        tipodocumento::inserir($descritivo);
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_tipo_documento.php?ok=inserir' >";
        exit;
    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        exit;
    }
}


if (isset($_REQUEST['deletar']) and $_REQUEST['deletar'] == true and is_numeric($_REQUEST['id'])) {

    $id = $_REQUEST['id'];

    try {
        tipodocumento::delete($id);
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_tipo_documento.php?ok=delete' >";
        exit;
    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_tipo_documento.php?ok=error' >";
        exit;
    }
}


if (isset($_REQUEST['atualizar'])) {

     $descr = $_REQUEST['descritivoAtualizado']; 
     $id    = $_REQUEST['idAtualizar']; 

     try{
        tipodocumento::atualizar($descr, $id);
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_tipo_documento.php?ok=atualizar' >";
        exit;
    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        exit;
    }
}

