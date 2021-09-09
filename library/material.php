<?php
error_reporting(E_ALL);
include_once 'Consulta.php';
include_once 'Conexao.php';

class material extends Consulta
{
    public static function inserir($itemSIGA, $codigoEAN, $descricaoProduto, $unidadeMedida, $tipoMaterial, $estoqueMinimo, $obsoleto)
    {
        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("INSERT INTO
                                         material
                                                 SET
                                                 id_item_siga     = :itemSIGA, 
                                                 codigointerno    = :codigoEAN,
                                                 descricao        = :descricaoProduto,
                                                 id_medida        = :unidadeMedida,
                                                 id_tipoMaterial  = :tipoMaterial,
                                                 estoqueminimo    = :estoqueMinimo,
                                                 obsoleto         = :obsoleto");
        $cmd->bindValue(":itemSIGA", $itemSIGA);
        $cmd->bindValue(":codigoEAN", $codigoEAN);
        $cmd->bindValue(":descricaoProduto", $descricaoProduto);
        $cmd->bindValue(":unidadeMedida", $unidadeMedida);
        $cmd->bindValue(":tipoMaterial", $tipoMaterial);
        $cmd->bindValue(":estoqueMinimo", $estoqueMinimo);
        $cmd->bindValue(":obsoleto", $obsoleto);

        $cmd->execute();
    }

    public static function delete($idExcluir)
    {

        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("UPDATE material SET ativo = 0 WHERE id = :id");
        $cmd->bindValue(":id", $idExcluir);
        $cmd->execute();
    }

    public static function atualizar($id, $codigointerno, $descricao, $estoqueminimo, $obsoleto)
    {
        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("UPDATE material 
                                                  SET 
                                                  codigointerno   = :codigointerno,
                                                  descricao       = :descricao,
                                                  estoqueminimo   = :estoqueminimo,
                                                  obsoleto        = :obsoleto
                                                  WHERE id = :id");

        $cmd->bindValue(":codigointerno", $codigointerno);
        $cmd->bindValue(":descricao", $descricao);
        $cmd->bindValue(":estoqueminimo", $estoqueminimo);
        $cmd->bindValue(":obsoleto", $obsoleto);

        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }
}