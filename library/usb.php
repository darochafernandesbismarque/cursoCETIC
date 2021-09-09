<?php
error_reporting(E_ALL);

include_once 'Consulta.php';
include_once 'Conexao.php';

class usb extends Consulta
{
    public static function inserir($descricao, $abreviacao)
    {
        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("INSERT INTO usb SET descricao = :descricao, abreviacao = :abreviacao");
        $cmd->bindValue(":descricao", $descricao);
        $cmd->bindValue(":abreviacao", $abreviacao);

        $cmd->execute();
    }

    public static function delete($idExcluir)
    {

        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("UPDATE usb SET ativo = 0 WHERE id = :id");
        $cmd->bindValue(":id", $idExcluir);
        $cmd->execute();
    }

    public static function atualizar($descr,  $abreviacaoAtualizado, $id)
    {

        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("UPDATE usb SET descricao = :descricao, abreviacao = :abreviacao WHERE id = :id");
        $cmd->bindValue(":descricao", $descr);
        $cmd->bindValue(":abreviacao", $abreviacaoAtualizado);
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }
}