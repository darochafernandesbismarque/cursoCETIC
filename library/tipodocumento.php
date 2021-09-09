<?php
error_reporting(E_ALL);

include_once 'Consulta.php';
include_once 'Conexao.php';

class tipodocumento extends Consulta
{
    public static function inserir($descritivo)
    {
        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("INSERT INTO tipodocumento SET descritivo = :descritivo");
		$cmd->bindValue(":descritivo", $descritivo);
		$cmd->execute();
    }

    public static function delete($idExcluir){

        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("UPDATE tipodocumento SET ativo = 0 WHERE id = :id");
		$cmd->bindValue(":id", $idExcluir);
		$cmd->execute();
    }

    public static function atualizar($descr, $id){

        $conexao = Conexao::conectar();
        
        $cmd = $conexao->prepare("UPDATE tipodocumento SET descritivo = :descritivo WHERE id = :id");
		$cmd->bindValue(":descritivo", $descr);
        $cmd->bindValue(":id", $id);
		$cmd->execute();
    }
}