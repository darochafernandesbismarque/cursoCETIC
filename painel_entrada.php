<?php
error_reporting(0);
session_start();
$pm_logado   = $_SESSION['UserRG'];
$opm_logado = $_SESSION['UserOPM'];
$LinksRoute = './';
include './inc/links.php';
?>
<!DOCTYPE html>
<html lang='pt-BR'>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Entrada</title>

    <script type='text/javascript'>
    </script>
</head>
<style>
a:hover {
    text-decoration: none;
}
</style>

<body>


    <?php
    include_once 'library/configserver.php';
    include_once 'library/consulsql.php';
    include_once 'library/usuario.php';
    include_once 'library/opm.php';
    include_once 'library/fornecedor.php';
    include_once 'library/material.php';
    include_once 'library/tipomaterial.php';
    include_once 'library/tipodocumento.php';
    include_once 'library/usb.php';
    include 'inc/NavLateral.php';
    ?>
    <div class='content-page-container full-reset custom-scroll-containers'>
        <?php
        include 'inc/NavUserInfo.php';
        ?>
        <div class='container'>
            <div class='page-header'>
                <h1 class='all-tittles'>SisMatOdonto <small>Painel ---</small></h1>
            </div>
        </div>

        <div class='container-fluid'>

            <form method='post' action=''>



                <div class='row'>


                    <div class='col-xs-12 col-sm-6'>

                        <center> <a href="cadastrar_tipo_documento.php"><button type="button"
                                    class="btn btn-primary btn-lg btn-block" align="center">Aquisição<br> <svg
                                        xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor"
                                        class="bi bi-file-earmark-plus-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM8.5 7v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 1 0z" />
                                    </svg></button></a></center>
                    </div>

                    <div class='col-xs-12 col-sm-6'>

                        <center> <a href="receber_material.php"><button type="button"
                                    class="btn btn-primary btn-lg btn-block" align="center">Outros<br> <svg
                                        xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor"
                                        class="bi bi-rulers" viewBox="0 0 16 16">
                                        <path
                                            d="M1 0a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h5v-1H2v-1h4v-1H4v-1h2v-1H2v-1h4V9H4V8h2V7H2V6h4V2h1v4h1V4h1v2h1V2h1v4h1V4h1v2h1V2h1v4h1V1a1 1 0 0 0-1-1H1z" />
                                    </svg></button></a></center>
                    </div>




                </div>
                <br>

                <div class='row'>

                    <div class='col-xs-12 col-sm-1'>
                    </div>

                </div>



                <div class='row'>

                    <div class='col-xs-12 col-sm-4'>

                        <center> <a href="cadastrar_transferenciafinanceira.php"><button type="button"
                                    class="btn btn-warning btn-lg btn-block" align="center">Transferência financeira
                                    <br> <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80"
                                        fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
                                        <path
                                            d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z" />
                                        <path
                                            d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                    </svg></button></a></center>

                    </div>

                    <div class='col-xs-12 col-sm-4'>

                        <center> <a href="cadastrar_licitacao.php"><button type="button"
                                    class="btn btn-warning btn-lg btn-block" align="center">Licitação<br> <svg
                                        xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor"
                                        class="bi bi-cart-plus" viewBox="0 0 16 16">
                                        <path
                                            d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z" />
                                        <path
                                            d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                    </svg></button></a></center>

                    </div>


                    <div class='col-xs-12 col-sm-4'>

                        <center> <a href="cadastrar_adiantamentofinanceiro.php"><button type="button"
                                    class="btn btn-warning btn-lg btn-block" align="center">Adiantamento financeiro<br>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor"
                                        class="bi bi-cart-plus" viewBox="0 0 16 16">
                                        <path
                                            d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z" />
                                        <path
                                            d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                    </svg></button></a></center>


                    </div>
                </div>
                <br>

            </form>




        </div>
    </div>
</body>

</html>