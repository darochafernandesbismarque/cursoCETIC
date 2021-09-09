<?php

class ConexaoSispes
{
    public static function conectarSispes()
    {
        $conexao = null;
        $host = "172.17.2.4";
        $base = "sispes";
        $usuario = "sismatbel_apl";
        $passwd = "6nn0ca6666";

        try {
            $conexao = new PDO('mysql:host=' . $host . ';dbname=' . $base, $usuario, $passwd, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        } catch (PDOException $e) {
            echo "Erro" . $e->getMessage();
        }
        return $conexao;
    }

    public static function consultarSispes($sql)
    {
        $conexao = ConexaoSispes::conectarSispes();
        $stmt    = $conexao->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
