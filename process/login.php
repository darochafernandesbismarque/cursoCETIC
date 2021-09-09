<?php
include_once '../library/Consulta.php';
include_once '../library/opm.php';
include './Requisicao.php';
include '../library/configserver.php';
include '../library/usuario.php';
include '../library/consulsql.php';

session_start();

/* Informa o nível dos erros que serão exibidos */
error_reporting(E_ALL);

$cpf   = consultasSQL::CleanStringText($_POST['cpf']);
$senha = consultasSQL::CleanStringText($_POST['senha']);

$result = Requisicao::requestPostApi('Auth', array(
    'cpf' => $cpf,
    'senha' => $senha
));

if ($result->status == 200) {
    $payload  = Requisicao::getInfoPlayloader($result->Authorization);

    $_SESSION['desc_gh']     = $payload['desc_gh'];
    $_SESSION['nome']        = $payload['nome'];
    $_SESSION['UserOPMDesc'] = $payload['abrev_opm'];
    $_SESSION['Authorization'] = $result->Authorization;

    $checkAdmin = usuario::consultar("SELECT * FROM usuario WHERE rg ='$payload[rg]' and status=1")[0];

    $fila = $checkAdmin;

    if (sizeof($checkAdmin) > 0) {

        $_SESSION['UserRG']       = $fila['rg'];
        $_SESSION['UserOPM']      = $fila['opm'];
        $_SESSION['nivelusuario'] = $fila['id_nivelusuario'];

        $_SESSION['OPMDesc'] = opm::consultar("SELECT abrev_opm FROM opm WHERE cod_opm_novo = '$fila[opm]'")[0]['abrev_opm'];

        echo '<script type="text/javascript"> window.location="../home.php"; </script>';
    } else {
        $_SESSION['error'] = "Voce Não Possui Acesso ao Sistema!";
        echo '<script type="text/javascript"> window.location="../index.php"; </script>';
    }
} else {
    $_SESSION['error'] = "Senha e/ou Usuário Inválidos!";
    echo '<script type="text/javascript"> window.location="../index.php"; </script>';
    // session_destroy();     
}
