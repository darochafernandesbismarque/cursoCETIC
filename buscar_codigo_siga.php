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
    <title>Consulta Siga</title>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
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
                <h1 class='all-tittles'>SisMatOdonto <small> Buscar Siga</small></h1>
            </div>
        </div>

        <div class='container-fluid'>
            <form method='post' action='cadastrar_material.php'>
                <div class='row'>
                    <div class='col-sm-12'>
                        <div class='col-sm-2'>

                        </div>
                        <div class='col-sm-6'>
                            <label>Siga</label>
                            <div class='group-material'>
                                <input type='text' class='form-control text-center  tooltips-general' name='codSiga' id='codSiga' data-toggle='tooltip' data-placement='top' placeholder="Entre com Código Siga" title='Digite o código do Siga' required>
                            </div>
                        </div>
                        <div class='col-sm-1'>
                            <label>&nbsp;</label><br>
                            <a href="consulta_siga.php">
                                <button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Não sabe o código SIGA, clique!">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search tooltips-general" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                    </svg> &nbsp;
                                    Consultar Siga
                                </button>
                            </a>
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
                                Entrar</button>

                            <a href="cadastros.php"> <button type='text' onclick="voltarPaginaAnterior()" class='btn btn-danger' style='margin-right: 20px;'><i class='glyphicon glyphicon-arrow-left'></i> &nbsp;
                                    &nbsp;
                                    Voltar</button></a>

                        </center>
                    </div>

                    <span id='erro'></span>
                    <br>

                    <center><img id="load" src="https://i.gifer.com/YVPG.gif" width="300" border="0" </center>
                </div>
        </div>
        </form>
    </div>
    </div>
</body>

</html>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

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

<script type="text/javascript">
    function erro() {
        Swal.fire(
            'Nenhum item foi encontrado',
            'Verifique e tente novamente!',
            'error'
        )
    }
</script>

<script type="text/javascript">
    function inserir() {
        Swal.fire(
            'Material inserido com sucesso!',
            'Sucesso!',
            'success'
        )
    }
</script>

<script type="text/javascript">
    function voltarPaginaAnterior() {
        window.location.href="cadastros.php";  
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<?php
if ($_REQUEST['ok'] == 'inserir') {
    echo '<script>inserir()</script>';
    exit;
}

if ($_REQUEST['erro'] == 'erro') {
    echo '<script>erro()</script>';
    exit;
}
?>
<script type="text/javascript">
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>