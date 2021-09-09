<?php
error_reporting(E_ALL);

include_once 'Consulta.php';
include_once 'Conexao.php';

class entradamaterialadiantamentofinanceiro extends Consulta
{
    public static function inserir($id_entradamaterial, $id_adiantamentofinanceiro)
    {
        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("INSERT INTO entradamaterialadiantamentofinanceiro SET id_entradamaterial = :id_entradamaterial, 
                                                                                        id_adiantamentofinanceiro = :id_adiantamentofinanceiro");
        $cmd->bindValue(":id_entradamaterial", $id_entradamaterial);
        $cmd->bindValue(":id_adiantamentofinanceiro", $id_adiantamentofinanceiro);
        $cmd->execute();

    }

}