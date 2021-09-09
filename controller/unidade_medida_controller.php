<?php
include "../library/unidademedida.php";

if (isset($_REQUEST['descricao'])) {

     $descricao = $_REQUEST['descricao'];  
     $abrev     = $_REQUEST['abrev'];

    try {
        unidademedida::inserir($descricao, $abrev);
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_unidade_medida.php?ok=inserir' >";
        exit;
    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        exit;
    }
}


if (isset($_REQUEST['deletar']) and $_REQUEST['deletar'] == true and is_numeric($_REQUEST['id'])) {

    $id = $_REQUEST['id'];

    try {
        unidademedida::delete($id);
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_unidade_medida.php?ok=delete' >";
        exit;
    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_unidade_medida.php?ok=error' >";
        exit;
    }
}


if (isset($_REQUEST['atualizar'])) {

    $id                   = $_REQUEST['idAtualizar'];
    $descritivoAtualizado = $_REQUEST['descritivoAtualizado'];
    $abrevAtualizado      = $_REQUEST['abrevAtualizado'];

    try {
        unidademedida::atualizar($descritivoAtualizado, $abrevAtualizado, $id);
        echo "<meta http-equiv='refresh' content='0;URL=../cadastrar_unidade_medida.php?ok=atualizar' >";
        exit;
    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        exit;
    }
}