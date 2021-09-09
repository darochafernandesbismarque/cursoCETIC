<?php
error_reporting(E_PARSE);
include_once 'library/configserver.php';

class ejecutarSQL
{
    public static function conectar()
    {
        if (!$con =  mysqli_connect(SERVER, USER, PASS, BD)) {
            die("Erro no servidor, verifique seus dados adfa");
        }

        mysqli_set_charset($con, 'utf8');
        return $con;
    }
    public static function consultar($query)
    {
        mysqli_query("SET AUTOCOMMIT=0;", ejecutarSQL::conectar());
        mysqli_query("BEGIN;", ejecutarSQL::conectar());
        if (!$consul = mysqli_query(ejecutarSQL::conectar(), $query)) {
            die(mysqli_error() . ' Error ao Executar  a consulta SQL');
            mysqli_query("ROLLBACK;", ejecutarSQL::conectar());
        } else {
            mysqli_query("COMMIT;", ejecutarSQL::conectar());
        }
        return $consul;
    }
}

class consultasSQL
{
    public static function limpiarCadena($valor)
    {
        $valor = str_ireplace("<script>", "", $valor);
        $valor = str_ireplace("</script>", "", $valor);
        $valor = str_ireplace("--", "", $valor);
        $valor = str_ireplace("^", "", $valor);
        $valor = str_ireplace("[", "", $valor);
        $valor = str_ireplace("]", "", $valor);
        $valor = str_ireplace("\\", "", $valor);
        $valor = str_ireplace("=", "", $valor);
        return $valor;
    }
    public static function CleanStringText($val)
    {
        $data = addslashes($val);
        $datos = consultasSQL::limpiarCadena($data);
        return $datos;
    }
    public static function InsertSQL($tabela, $campos, $valores)
    {
        if (!$consul = ejecutarSQL::consultar("insert into $tabela ($campos) VALUES($valores) ")) {
            die("Ocorreu um Erro ao Salvar os Dados");
        }
        return true;
    }
    public static function DeleteSQL($tabela, $condicion)
    {
        if (!$consul = ejecutarSQL::consultar("delete from $tabela where $condicion")) {
            die("Ocorreu um Erro ao Deletar os Dados");
        }
        return $consul;
    }
    public static function UpdateSQL($tabela, $campos, $condicion)
    {
        if (!$consul = ejecutarSQL::consultar("update $tabela set $campos where $condicion")) {
            die("Ocorreu um Erros ao Alterar os Dados");
        }
        return $consul;
    }
}
