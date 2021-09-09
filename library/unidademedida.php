<?php
error_reporting(E_ALL);

include_once 'Consulta.php';
include_once 'Conexao.php';

class unidademedida extends Consulta
{
    public static function inserir($descricao, $abrev)
    {
        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("INSERT INTO unidademedida SET descricao = :descricao, abrev = :abrev");
        $cmd->bindValue(":descricao", $descricao);
        $cmd->bindValue(":abrev", $abrev);
        $cmd->execute();
    }

    public static function delete($idExcluir)
    {

        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("UPDATE unidademedida SET ativo = 0 WHERE id = :id");
        $cmd->bindValue(":id", $idExcluir);
        $cmd->execute();
    }

    public static function atualizar($descritivoAtualizado, $abrevAtualizado, $id)
    {

        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("UPDATE unidademedida SET descricao = :descricao, abrev = :abrev WHERE id = :id");
        $cmd->bindValue(":descricao", $descritivoAtualizado);
        $cmd->bindValue(":abrev", $abrevAtualizado);
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }
}