<?php
include "../library/transferenciafinanceira.php";

if (isset($_REQUEST['descricao'])) {

    $descricao = $_REQUEST['descricao'];
    $sei_processo     = $_REQUEST['sei_processo'];

    try {
        transferenciafinanceira::inserir($descricao, $sei_processo);
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_transferenciafinanceira.php?ok=inserir' >";
        exit;
    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        exit;
    }
}


if (isset($_REQUEST['deletar']) and $_REQUEST['deletar'] == true and is_numeric($_REQUEST['id'])) {

    $id = $_REQUEST['id'];

    try {
        transferenciafinanceira::delete($id);
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_transferenciafinanceira.php?ok=delete' >";
        exit;
    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_transferenciafinanceira.php?ok=error' >";
        exit;
    }
}


if (isset($_REQUEST['atualizar'])) {

    $id                   = $_REQUEST['idAtualizar'];
    $descritivoAtualizado = $_REQUEST['descritivoAtualizado'];
    $sei_processoAtualizado      = $_REQUEST['sei_processoAtualizado'];



    try {
        transferenciafinanceira::atualizar($descritivoAtualizado, $sei_processoAtualizado, $id);
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_transferenciafinanceira.php?ok=atualizar' >";
        exit;
    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        exit;
    }
}