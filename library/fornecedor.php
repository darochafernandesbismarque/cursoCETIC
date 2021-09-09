<?php
error_reporting(E_ALL);

include_once 'Consulta.php';
include_once 'Conexao.php';

class fornecedor extends Consulta
{
    public static function inserir($nome, $razaosocial, $logradouro, $bairro, $id_municipio, $email, $telefone)
    {
        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("INSERT INTO
                                         fornecedor
                                                 SET
                                                  nome         = :nome, 
                                                  razaosocial  = :razaosocial,
                                                  logradouro   = :logradouro,
                                                  bairro       = :bairro,
                                                  id_municipio = :id_municipio,
                                                  email        = :email,
                                                  telefone     = :telefone  ");
        $cmd->bindValue(":nome", $nome);
        $cmd->bindValue(":razaosocial", $razaosocial);
        $cmd->bindValue(":logradouro", $logradouro);
        $cmd->bindValue(":bairro", $bairro);
        $cmd->bindValue(":id_municipio", $id_municipio);
        $cmd->bindValue(":email", $email);
        $cmd->bindValue(":telefone", $telefone);
        $cmd->execute();
    }

    public static function delete($idExcluir)
    {

        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("UPDATE fornecedor SET ativo = 0 WHERE id = :id");
        $cmd->bindValue(":id", $idExcluir);
        $cmd->execute();
    }

    public static function atualizar($nomeAtualizado, $razaosocialAtualizado, $logradouroAtualizado, $bairroAtualizado, $id_municipioAtualizado, $emailAtualizado, $telefoneAtualizado, $id)
    {

        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("UPDATE fornecedor 
                                                  SET
                                                  nome         = :nome, 
                                                  razaosocial  = :razaosocial,
                                                  logradouro   = :logradouro,
                                                  bairro       = :bairro,
                                                  id_municipio = :id_municipio,
                                                  email        = :email,
                                                  telefone     = :telefone WHERE id = :id");

        $cmd->bindValue(":nome", $nomeAtualizado);
        $cmd->bindValue(":razaosocial", $razaosocialAtualizado);
        $cmd->bindValue(":logradouro", $logradouroAtualizado);
        $cmd->bindValue(":bairro", $bairroAtualizado);
        $cmd->bindValue(":id_municipio", $id_municipioAtualizado);
        $cmd->bindValue(":email", $emailAtualizado);
        $cmd->bindValue(":telefone", $telefoneAtualizado);
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }
}