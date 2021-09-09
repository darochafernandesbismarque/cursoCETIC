<?php
error_reporting(E_ALL);
include "Conexao.php";

class Consulta
{
    public static function consultar($sql)
    {
        $conexao = Conexao::conectar();
        $stmt =  $conexao->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
