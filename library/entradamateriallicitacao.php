<?php
error_reporting(E_ALL);

include_once 'Consulta.php';
include_once 'Conexao.php';

class entradamateriallicitacao extends Consulta
{
    public static function inserir($id_entradamaterial, $id_licitacao)
    {
        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("INSERT INTO entradamateriallicitacao SET id_entradamaterial = :id_entradamaterial, 
                                                                           id_licitacao = :id_licitacao");
        $cmd->bindValue(":id_entradamaterial", $id_entradamaterial);
        $cmd->bindValue(":id_licitacao", $id_licitacao);
        $cmd->execute();

    }

}