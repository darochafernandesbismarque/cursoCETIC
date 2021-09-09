<?php
include "configserver.php";

class Conexao
{
    public static function conectar()
    {
        $conexao = null;
        $host = SERVER;
        $base = BD;
        $usuario = USER;
        $passwd = PASS;

        try {
            $conexao = new PDO('mysql:host=' . $host . ';dbname=' . $base, $usuario, $passwd, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        } catch (PDOException $e) {
            echo "Erro" . $e->getMessage();
        }

        return $conexao;
    }
}
