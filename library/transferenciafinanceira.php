<?php
error_reporting(E_ALL);

include_once 'Consulta.php';
include_once 'Conexao.php';

class transferenciafinanceira extends Consulta
{
    public static function inserir($descricao, $sei_processo)
    {
        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("INSERT INTO transferenciafinanceira SET descricao = :descricao, sei_processo = :sei_processo");
        $cmd->bindValue(":descricao", $descricao);
        $cmd->bindValue(":sei_processo", $sei_processo);

        $cmd->execute();
    }

    public static function delete($idExcluir)
    {

        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("UPDATE transferenciafinanceira SET ativo = 0 WHERE id = :id");
        $cmd->bindValue(":id", $idExcluir);
        $cmd->execute();
    }

    public static function atualizar($descr,  $sei_processoAtualizado, $id)
    {

        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("UPDATE transferenciafinanceira SET descricao = :descricao, sei_processo = :sei_processo WHERE id = :id");
        $cmd->bindValue(":descricao", $descr);
        $cmd->bindValue(":sei_processo", $sei_processoAtualizado);
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }
}