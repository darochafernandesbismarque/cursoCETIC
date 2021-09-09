<?php
include "../library/entrada_material_item.php";

if (isset($_REQUEST['enviarTipoDocumento'])) {

    $material       = $_REQUEST['material'];
    $validade       = $_REQUEST['validade'];
    $lote           = $_REQUEST['lote'];
    $valor_unitario = $_REQUEST['valor_unitario'];
    $quantidade     = $_REQUEST['quantidade'];
    $fornecedor     = $_REQUEST['fornecedor'];
    $id_nota        = $_REQUEST['id_nota'];

    $novo_material = explode("-", $material);
    $novo_material_inserir = $novo_material[0]; 

    /*
    echo "<span style='color:red';>quantidade - </span>" . $quantidade . "<br>";
    echo "<span style='color:red';>validade  - </span>" . $validade . "<br>";
    echo "<span style='color:red';>lote - </span>" . $lote . "<br>";
    echo "<span style='color:red';>valor unitario - </span>" . $valor_unitario . "<br>";
    echo "<span style='color:red';>material  - </span>" . $material . "<br>";
    echo "<span style='color:red';>fornecedor - </span>" . $fornecedor . "<br>";
    exit; 
    */

    try {
        entradaMaterialItem::inserir($novo_material_inserir, $validade, $lote, $valor_unitario, $quantidade, $id_nota);
        echo "<meta http-equiv='refresh' content='0;URL=../entrada_material_item.php'>";
        exit;
    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        exit;
    }
}


if (isset($_REQUEST['deletar']) and $_REQUEST['deletar'] == true and is_numeric($_REQUEST['id'])) {

    $id = $_REQUEST['id']; 

    try {
        entradaMaterialItem::delete($id);
        echo "<meta http-equiv='refresh' content='0;URL=../entrada_material_item.php?ok=delete' >";
        exit;
    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        echo "<meta http-equiv='refresh' content='0;URL=../entrada_material_item.php?ok=error' >";
        exit;
    }
}