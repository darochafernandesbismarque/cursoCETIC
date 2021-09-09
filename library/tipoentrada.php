<?php
error_reporting(E_ALL);

include_once 'Consulta.php';
include_once 'Conexao.php';

class tipoentrada extends Consulta
{
    public static function inserir($descricao)
    {
        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("INSERT INTO tipoentrada SET descricao = :descricao");
        $cmd->bindValue(":descricao", $descricao);
        $cmd->execute();
    }

    public static function delete($idExcluir)
    {

        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("UPDATE tipoentrada SET ativo = 0 WHERE id = :id");
        $cmd->bindValue(":id", $idExcluir);
        $cmd->execute();
    }

    public static function atualizar($descr, $id)
    {

        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("UPDATE tipoentrada SET descricao = :descricao WHERE id = :id");
        $cmd->bindValue(":descricao", $descr);
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }
}