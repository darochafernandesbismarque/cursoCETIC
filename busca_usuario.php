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
    <title>Consulta Usuário</title>

    <script type='text/javascript'>
    </script>
</head>

<body>
    <?php
    include_once 'library/configserver.php';
    include_once 'library/consulsql.php';
    include_once 'library/usuario.php';
    include_once 'library/opm.php';
    include_once 'library/fornecedor.php';
    include 'inc/NavLateral.php';
    ?>
    <div class='content-page-container full-reset custom-scroll-containers'>
        <?php
        include 'inc/NavUserInfo.php';
        ?>
        <div class='container'>
            <div class='page-header'>
                <h1 class='all-tittles'>SisMatOdonto <small> Buscar Usuário</small></h1>
            </div>
        </div>

        <div class='container-fluid'>
            <form method='post' action='cadastrar_usuario.php'>
                <div class='row'>

                    <div class='col-xs-12 col-sm-3'>
                        <label></label>
                        <div class='group-material'>
                        </div>
                    </div>

                    <div class='col-xs-12 col-sm-6'>
                        <label>RG</label>
                        <div class='group-material'>
                            <input type='text' class='form-control text-center  tooltips-general' name='rg' id='rg' data-toggle='tooltip' data-placement='top' placeholder="Digite seu rg" title='Digite o rg do usuário' required>
                        </div>
                    </div>
                </div>

                <div class='full-reset row representative-resul'>
                    <div class="col">
                        <center>
                            <button type='reset' class='btn btn-light' style='margin-right: 20px;'><i class='glyphicon glyphicon-erase'></i> &nbsp;
                                &nbsp;
                                Limpar</button>

                            <button type='submit' id='btn-entrar' name='enviar' class='btn btn-primary' style='margin-right: 20px;'><i class='glyphicon glyphicon-floppy-saved' style='margin-right: 20px;'></i> &nbsp;
                                &nbsp;
                                Buscar</button>

                            <a href="cadastros.php" <button type='link' class='btn btn-danger' style='margin-right: 20px;'><i class='glyphicon glyphicon-arrow-left'></i> &nbsp;
                                &nbsp;
                                Voltar</button></a>
                        </center>

                        <span id='erro'></span>
                        <br>

                        <center><img id="load" src="https://i.gifer.com/YVPG.gif" width="300" border="0" </center>

                    </div>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#load').hide();
            $('#btn-entrar').click(function() {
                $('#load').show();
                setTimeout(function() {
                    $('#load').hide();
                }, 3000);
            });
        });
    </script>

</body>
<script type="text/javascript">
    function inserir() {
        Swal.fire(
            'Usuário inserido com sucesso!',
            'Sucesso!',
            'success'
        )
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

</html>

<?php
if ((isset($_REQUEST['ok']) and ($_REQUEST['ok'] == 'inserir'))) {
    echo '<script>inserir()</script>';
    exit;
}
?>