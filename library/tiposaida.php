<?php
error_reporting(E_ALL);

include_once 'Consulta.php';
include_once 'Conexao.php';

class tiposaida extends Consulta
{
    public static function inserir($descricao)
    {
        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("INSERT INTO tiposaida SET descricao = :descricao");
        $cmd->bindValue(":descricao", $descricao);
        $cmd->execute();
    }

    public static function delete($idExcluir)
    {

        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("UPDATE tiposaida SET ativo = 0 WHERE id = :id");
        $cmd->bindValue(":id", $idExcluir);
        $cmd->execute();
    }

    public static function atualizar($descr, $id)
    {

        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("UPDATE tiposaida SET descricao = :descricao WHERE id = :id");
        $cmd->bindValue(":descricao", $descr);
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }
}