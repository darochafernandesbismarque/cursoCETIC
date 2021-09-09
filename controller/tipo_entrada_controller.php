<?php
include "../library/tipoentrada.php";

if (isset($_REQUEST['descricao'])) {

    $descricao = $_REQUEST['descricao'];


    try {
        tipoentrada::inserir($descricao);
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_tipo_entrada.php?ok=inserir' >";
        exit;
    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        exit;
    }
}


if (isset($_REQUEST['deletar']) and $_REQUEST['deletar'] == true and is_numeric($_REQUEST['id'])) {

    $id = $_REQUEST['id'];

    try {
        tipoentrada::delete($id);
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_tipo_entrada.php?ok=delete' >";
        exit;
    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_tipo_entrada.php?ok=error' >";
        exit;
    }
}


if (isset($_REQUEST['atualizar'])) {

    $id                   = $_REQUEST['idAtualizar'];
    $descritivoAtualizado = $_REQUEST['descritivoAtualizado'];



    try {
        tipoentrada::atualizar($descritivoAtualizado, $id);
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_tipo_entrada.php?ok=atualizar' >";
        exit;
    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        exit;
    }
}