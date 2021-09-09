<?php
include_once 'Consulta.php';

class usuario extends Consulta
{
    public static function inserir($rg, $status, $id_nivelusuario, $opmNum)
    {
        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("INSERT INTO usuario SET rg = :rg, status = :status, id_nivelusuario = :id_nivelusuario, opm = :opm");
		$cmd->bindValue(":rg", $rg);
        $cmd->bindValue(":status", $status);
        $cmd->bindValue(":id_nivelusuario", $id_nivelusuario);
        $cmd->bindValue(":opm", $opmNum);
		$cmd->execute();
    }
}
