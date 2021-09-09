<?php
include "../library/fornecedor.php";

if (isset($_REQUEST['nome'])) {

    $nome         = $_REQUEST['nome'];
    $razaosocial  = $_REQUEST['razaosocial'];
    $logradouro   = $_REQUEST['logradouro'];
    $bairro       = $_REQUEST['bairro'];
    $id_municipio = $_REQUEST['cidade'];
    $email        = $_REQUEST['email'];
    $telefone     = $_REQUEST['telefone'];

    try {
        fornecedor::inserir($nome, $razaosocial, $logradouro, $bairro, $id_municipio, $email, $telefone);
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_fornecedor.php?ok=inserir' >";
        exit;
    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        exit;
    }
}


if (isset($_REQUEST['deletar']) and $_REQUEST['deletar'] == true and is_numeric($_REQUEST['id'])) {

    $id = $_REQUEST['id'];

    try {
        fornecedor::delete($id);
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_fornecedor.php?ok=delete' >";
        exit;
    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        echo "<meta http-equiv='refresh' content='0;URL=../_cadastrar_fornecedor.php?ok=error' >";
        exit;
    }
}


if (isset($_REQUEST['atualizar'])) {

    $id           = $_REQUEST['idAtualizar'];
    $nome         = $_REQUEST['nomeAtualizado'];
    $razaosocial  = $_REQUEST['razaosocialAtualizado'];
    $logradouro   = $_REQUEST['logradouroAtualizado'];
    $bairro       = $_REQUEST['bairroAtualizado'];
    $id_municipio = $_REQUEST['cidade'];
    $email        = $_REQUEST['emailAtualizado'];
    $telefone     = $_REQUEST['telefoneAtualizado'];

    try {
        fornecedor::atualizar($nome, $razaosocial, $logradouro, $bairro, $id_municipio, $email, $telefone, $id);
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_fornecedor.php?ok=atualizar' >";
        exit;
    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        exit;
    }
}