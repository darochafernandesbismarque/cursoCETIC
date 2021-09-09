<?php
include "../library/tipomaterial.php";

if (isset($_REQUEST['descr'])) {

    $descr = $_REQUEST['descr'];

    try {
        tipomaterial::inserir($descr);
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_tipo_material.php?ok=inserir' >";
        exit;
    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        exit;
    }
}


if (isset($_REQUEST['deletar']) and $_REQUEST['deletar'] == true and is_numeric($_REQUEST['id'])) {

    $id = $_REQUEST['id'];

    try {
        tipomaterial::delete($id);
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_tipo_material.php?ok=delete' >";
        exit;
    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_tipo_material.php?ok=error' >";
        exit;
    }
}


if (isset($_REQUEST['atualizar'])) {

    $descricao = $_REQUEST['descritivoAtualizado'];
    $id    = $_REQUEST['idAtualizar'];

    try {
        tipomaterial::atualizar($descricao, $id);
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_tipo_material.php?ok=atualizar' >";
        exit;
    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        exit;
    }
}