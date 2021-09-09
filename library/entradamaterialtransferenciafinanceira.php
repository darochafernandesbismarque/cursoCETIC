<?php
error_reporting(E_ALL);

include_once 'Consulta.php';
include_once 'Conexao.php';

class entradamaterialtransferenciafinanceira extends Consulta
{
    public static function inserir($id_entradamaterial, $id_transferenciafinanceira)
    {
        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("INSERT INTO entradamaterialtransferenciafinanceira SET id_entradamaterial = :id_entradamaterial, 
                                                                                        id_transferenciafinanceira = :id_transferenciafinanceira");
        $cmd->bindValue(":id_entradamaterial", $id_entradamaterial);
        $cmd->bindValue(":id_transferenciafinanceira", $id_transferenciafinanceira);
        $cmd->execute();

    }

}