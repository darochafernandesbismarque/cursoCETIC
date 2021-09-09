<?php
error_reporting(E_ALL);

include_once 'Consulta.php';
include_once 'Conexao.php';

class entradamaterial extends Consulta
{
    public static function inserir($id_fornecedor, $id_material, $qnt, $vl_uni, $vl_total, $nf, $tipo_verba, $documento, $und_medida, $id_opm, $status,
                                   $validade, $dt_doc, $obs, $contrato, $empenho, $ata, $processo)
    {
        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("INSERT INTO entrada SET descritivo = :descritivo, id_fornecedor = :id_fornecedor, id_material = :id_material, quantidade =:quantidade,
                                                          valor_unitario = :valor_unitario, valor_total = :valor_total, notafiscal = :notafiscal,
                                                          tipo_verba = :tipo_verba, documento = :documento, und_medida = :und_medida,
                                                          id_opm = :id_opm, status = :status, validade = :validade, data_documento = :data_documento, observacao = :observacao,
                                                          contrato = :contrato, empenho = :empenho, ata = :ata, processo = :processo");
		$cmd->bindValue(":id_fornecedor", $id_fornecedor);
        $cmd->bindValue(":id_material", $id_material);
        $cmd->bindValue(":quantidade", $qnt);
        $cmd->bindValue(":valor_unitario", $vl_uni);
        $cmd->bindValue(":valor_total", $vl_total);
        $cmd->bindValue(":notafiscal", $nf);
        $cmd->bindValue(":tipo_verba", $tipo_verba);
        $cmd->bindValue(":documento", $documento);
        $cmd->bindValue(":und_medida", $und_medida);
        $cmd->bindValue(":id_opm", $id_opm);
        $cmd->bindValue(":status", $status);
        $cmd->bindValue(":validade", $validade);
        $cmd->bindValue(":data_documento", $dt_doc);
        $cmd->bindValue(":observacao", $obs);
        $cmd->bindValue(":contrato", $contrato);
        $cmd->bindValue(":empenho", $empenho);
        $cmd->bindValue(":ata", $ata);
        $cmd->bindValue(":processo", $processo);
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