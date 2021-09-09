<?php
include "../library/material.php";

if (isset($_REQUEST['enviar'])) {

    $itemSIGA         = $_REQUEST['itemSIGA'];
    $codigoEAN        = $_REQUEST['codigoEAN'];
    $descricaoProduto = $_REQUEST['descricaoProduto'];
    $idUnidadeMedida  = $_REQUEST['unidadeMedida'];
    $idTipoMaterial   = $_REQUEST['idTipoMaterial'];
    $estoqueMinimo    = $_REQUEST['estoqueMinimo'];
    $obsoleto    = $_REQUEST['obsoleto'];


    try {
        material::inserir($itemSIGA, $codigoEAN, $descricaoProduto, $idUnidadeMedida, $idTipoMaterial, $estoqueMinimo, $obsoleto);
        echo "<meta http-equiv='refresh' content='0;URL=../buscar_codigo_siga.php?ok=inserir' >";
        exit;
    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        exit;
    }
}

if (isset($_REQUEST['deletar']) and $_REQUEST['deletar'] == true and is_numeric($_REQUEST['id'])) {

    $id = $_REQUEST['id'];

    try {
        material::delete($id);
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_material.php?ok=delete' >";
        exit;
    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        echo "<meta http-equiv='refresh' content='0;URL=../_cadastrar_material.php?ok=error' >";
        exit;
    }
}

if (isset($_REQUEST['atualizar'])) {

    $id            = $_REQUEST['idAtualizar'];
    $codigointerno = $_REQUEST['codigointernoAtualizado'];
    $descricao     = $_REQUEST['descricaoAtualizado'];
    $estoqueminimo = $_REQUEST['estoqueminimoAtualizado'];
    $estoqueminimo = $_REQUEST['obsoletoAtualizado'];
    try {
        material::atualizar($id, $codigointerno, $descricao, $estoqueminimo, $obsoleto);
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_material.php?ok=atualizar' >";
        exit;
    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        exit;
    }
}