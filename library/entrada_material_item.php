<?php
error_reporting(E_ALL);

include_once 'Consulta.php';
include_once 'Conexao.php';

class entradaMaterialItem extends Consulta
{
    public static function inserir($material, $validade, $lote, $valor_unitario, $quantidade, $id_nota)
    {
        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("INSERT INTO entradamaterialitem SET quantidade = :quantidade, validade = :validade, lote = :lote,
                                  valorunitario = :valor_unitario, id_entradamanterial = :id_entradamanterial, id_material = :id_material");

        $cmd->bindValue(":quantidade", $quantidade);
        $cmd->bindValue(":validade", $validade);
        $cmd->bindValue(":lote", $lote);
        $cmd->bindValue(":valor_unitario", $valor_unitario);
        $cmd->bindValue(":id_entradamanterial", $id_nota);
        $cmd->bindValue(":id_material", $material);
        $cmd->execute();
    }

    public static function delete($idExcluir)
    {
        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("UPDATE entradamaterialitem SET ativo = 0 WHERE id = :id");
        $cmd->bindValue(":id", $idExcluir);
        $cmd->execute();
    }
}