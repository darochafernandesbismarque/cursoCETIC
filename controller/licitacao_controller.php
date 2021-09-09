<?php
include "../library/licitacao.php";


if (isset($_REQUEST['descricao'])) {

    $descricao        = $_REQUEST['descricao'];
    $sei_processo     = $_REQUEST['sei_processo'];
    $numero_ata       = $_REQUEST['numero_ata'];
    $quantidade_ata   = $_REQUEST['quantidade_ata'];
    $validade         = $_REQUEST['validade'];

    try {
        licitacao::inserir($descricao, $sei_processo, $numero_ata, $quantidade_ata, $validade);
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_licitacao.php?ok=inserir' >";
        exit;
    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        exit;
    }
}



if (isset($_REQUEST['deletar']) and $_REQUEST['deletar'] == true and is_numeric($_REQUEST['id'])) {

    $id = $_REQUEST['id'];

    try {
        licitacao::delete($id);
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_licitacao.php?ok=delete' >";
        exit;
    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_licitacao.php?ok=error' >";
        exit;
    }
}


if (isset($_REQUEST['atualizar'])) {

    $id               = $_REQUEST['idAtualizar'];
    $descricao        = $_REQUEST['descricaoAtualizado'];
    $sei_processo     = $_REQUEST['sei_processoAtualizado'];
    $numero_ata       = $_REQUEST['numero_ataAtualizado'];
    $quantidade_ata   = $_REQUEST['quantidade_ataAtualizado'];
    $validade         = $_REQUEST['validadeAtualizado'];



    try {
        licitacao::atualizar($descricao, $sei_processo, $numero_ata, $quantidade_ata, $validade, $id);
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_licitacao.php?ok=atualizar' >";
        exit;
    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        exit;
    }
}