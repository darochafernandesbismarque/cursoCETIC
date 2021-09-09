<?php
error_reporting(E_ALL);

include_once 'Consulta.php';
include_once 'Conexao.php';

class licitacao extends Consulta
{
    public static function inserir($descricao, $sei_processo, $numero_ata, $quantidade_ata, $validade)
    {
        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("INSERT INTO licitacao
                                         SET descricao = :descricao, 
                                         sei_processo = :sei_processo, 
                                         numero_ata = :numero_ata,
                                         quantidade_ata = :quantidade_ata,
                                         validade = :validade");
        $cmd->bindValue(":descricao", $descricao);
        $cmd->bindValue(":sei_processo", $sei_processo);
        $cmd->bindValue(":numero_ata", $numero_ata);
        $cmd->bindValue(":quantidade_ata", $quantidade_ata);
        $cmd->bindValue(":validade", $validade);

        $cmd->execute();
    }

    public static function delete($idExcluir)
    {

        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("UPDATE licitacao SET ativo = 0 WHERE id = :id");
        $cmd->bindValue(":id", $idExcluir);
        $cmd->execute();
    }

    public static function atualizar($descricaoAtualizado, $sei_processoAtualizado, $numero_ataAtualizado, $quantidadeAtualizado, $validadeAtualizado, $id) {

        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("UPDATE licitacao 
                                                SET descricao      = :descricao,
                                                    sei_processo   = :sei_processo,
                                                    numero_ata     = :numero_ata,
                                                    quantidade_ata = :quantidade_ata,
                                                    validade       = :validade
                                                WHERE id           = :id");
        $cmd->bindValue(":descricao",    $descricaoAtualizado);
        $cmd->bindValue(":sei_processo", $sei_processoAtualizado);
        $cmd->bindValue(":numero_ata",   $numero_ataAtualizado);
        $cmd->bindValue(":quantidade_ata",   $quantidadeAtualizado);
        $cmd->bindValue(":validade",     $validadeAtualizado);
        $cmd->bindValue(":id",           $id);

        $cmd->execute();
    }
}