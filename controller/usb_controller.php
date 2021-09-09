<?php
include "../library/usb.php";

if (isset($_REQUEST['descricao'])) {

    $descricao = $_REQUEST['descricao'];
    $abreviacao     = $_REQUEST['abreviacao'];

    try {
        usb::inserir($descricao, $abreviacao);
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_unidades_usb.php?ok=inserir' >";
        exit;
    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        exit;
    }
}


if (isset($_REQUEST['deletar']) and $_REQUEST['deletar'] == true and is_numeric($_REQUEST['id'])) {

    $id = $_REQUEST['id'];

    try {
        usb::delete($id);
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_unidades_usb.php?ok=delete' >";
        exit;
    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_unidades_usb.php?ok=error' >";
        exit;
    }
}


if (isset($_REQUEST['atualizar'])) {

    $id                   = $_REQUEST['idAtualizar'];
    $descritivoAtualizado = $_REQUEST['descritivoAtualizado'];
    $abreviacaoAtualizado      = $_REQUEST['abreviacaoAtualizado'];



    try {
        usb::atualizar($descritivoAtualizado, $abreviacaoAtualizado, $id);
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_unidades_usb.php?ok=atualizar' >";
        exit;
    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        exit;
    }
}