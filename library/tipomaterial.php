<?php
error_reporting(E_ALL);

include_once 'Consulta.php';
include_once 'Conexao.php';

class tipomaterial extends Consulta
{
    public static function inserir($descr)
    {
        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("INSERT INTO tipomaterial SET descr = :descr");
        $cmd->bindValue(":descr", $descr);
        $cmd->execute();
    }

    public static function delete($idExcluir)
    {

        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("UPDATE tipomaterial SET ativo = 0 WHERE id = :id");
        $cmd->bindValue(":id", $idExcluir);
        $cmd->execute();
    }

    public static function atualizar($descricao, $id)
    {

        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("UPDATE tipomaterial SET descr = :descr WHERE id = :id");
        $cmd->bindValue(":descr", $descricao);
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }
}