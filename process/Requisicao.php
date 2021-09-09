<?php
/* Informa o nível dos erros que serão exibidos */
error_reporting(E_ALL);

/* Habilita a exibição de erros */
ini_set("display_errors", 1);

class Requisicao
{
    //private static  $urlapi = 'http://api.cetic/'; 
    private static  $urlapi = 'https://api.pmerj.rj.gov.br/'; // 

    public static function getInfoPlayloader($autorization)
    {
        $token = explode('.', $autorization);
        $payload = base64_decode($token[1]);
        return json_decode($payload, true);
    }

    public static function requestPostApi($rota, $dado)
    {
        $url = Requisicao::$urlapi . $rota;
        $postdata = http_build_query($dado);

        $opts = array(
            'http' =>
            
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );

        $context = stream_context_create($opts);

        $stream = fopen($url, 'r', false, $context);
        $result = stream_get_contents($stream);
        fclose($stream);
        return json_decode($result);
    }

    public static function requestGetApi($rota, $token)
    {
        $url = Requisicao::$urlapi . $rota;
        $opts = array(
            'http' =>
            array(
                'method' => 'GET',
                'max_redirects' => '0',
                'ignore_errors' => '1',
                'header' => 'Authorization: bearer ' . $token
            )
        );

        $context = stream_context_create($opts);
        $stream = fopen($url, 'r', false, $context);

        $result = stream_get_contents($stream);
        fclose($stream);
        return json_decode($result, true);
    }
}
