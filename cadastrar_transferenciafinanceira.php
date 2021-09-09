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
    <title>Cadastro de Transferências Financeiras</title>

    <script type='text/javascript'>
    </script><!-- data table com exportação-->
    <script type="text/javascript" src="js/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="js/jszip.min.js"></script>
    <script type="text/javascript" src="js/pdfmake.min.js"></script>
    <script type="text/javascript" src="js/vfs_fonts.js"></script>
    <script type="text/javascript" src="js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="js/buttons.print.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css
">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css
">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css"
        integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
    <script src="js/jquery.maskedinput.js" type="text/javascript"></script>
    <script src="js/jquery.maskedinput.min.js" type="text/javascript"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1,  user-scalable=no">

</head>

<!-- DATA TABLE COLOCAR ID=EXAMPLE DENTRO DO TABLE-->

<body overflow: hidden;">
    <!-- data table com exportação-->
    <script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: []
        });
    });
    </script>
    <!-- data table com exportação-->

    <?php
    include_once 'library/configserver.php';
    include_once 'library/consulsql.php';
    include_once 'library/usuario.php';
    include_once 'library/opm.php';
    include_once 'library/fornecedor.php';
    include_once 'library/material.php';
    include_once 'library/tipomaterial.php';
    include_once 'library/tipodocumento.php';
    include_once 'library/Consulta.php';
    include_once 'library/usb.php';
    include_once 'library/transferenciafinanceira.php';

    include 'inc/NavLateral.php';
    ?>
    <div class='content-page-container full-reset custom-scroll-containers'>
        <?php
        include 'inc/NavUserInfo.php';
        ?>
        <div class='container'>
            <div class='page-header'>
                <h1 class='all-tittles'>SisMatOdonto <small> Cadastrar Transferência Financeira</small></h1>
            </div>
        </div>

        <?php if (!isset($_REQUEST['editar'])) { ?>

        <div class='container-fluid'>
            <form method='POST' action='controller/transferenciafinanceira_controller.php'>

                <div class='full-reset row representative-resul'>


                    <div class='col-xs-12 col-sm-6'>
                        <label>Descrição</label>
                        <input type='text' class='form-control text-center  tooltips-general' name='descricao'
                            id='descricao' data-toggle='tooltip' data-placement='top' title='Descrição da transferencia'
                            required>
                        <br>
                    </div>

                    <div class='col-xs-12 col-sm-6'>
                        <label>N° PROCESSO SEI</label>
                        <div class='group-material'>
                            <input type='text' class='form-control text-center  tooltips-general' name='sei_processo'
                                id='sei_processo' data-toggle='tooltip' data-placement='top'
                                title='sei_processo do tipo da transferencia' required>
                        </div>
                    </div>



                </div>
                <br><br>

                <div>
                    <center>

                        <button type='reset' class='btn btn-light' id="limpar" style='margin-right: 20px;'><i
                                class='glyphicon glyphicon-erase'></i> &nbsp;
                            &nbsp;
                            Limpar</button>

                        <button type='submit' id='btn_enviar' name='enviar' class='btn btn-primary'
                            style='margin-right: 20px;'><i class='glyphicon glyphicon-floppy-saved'
                                style='margin-right: 20px;'></i> &nbsp;
                            &nbsp;
                            Salvar</button>


                        <a href="cadastros.php" <button type='link' class='btn btn-danger'
                            style='margin-right: 20px;'><i class='glyphicon glyphicon-arrow-left'></i> &nbsp;
                            &nbsp;
                            Voltar</button></a>
                    </center>
                </div>



            </form>

        </div>

        <span id='erro'></span>

        <br><br>

        <center>
            <div class="alert alert-secondary  col-md-12" role="alert" align="center">
                <h1>
                    <font color="black">Transferências Cadastradas</font>
                </h1>
            </div>
        </center>

        <section id="direita">

            <table id="example" class="table table-striped col-md-12" align="center"
                style="background-color:#fff;  max-width: 1700px; position: relative; padding:30px; border: solid 1px #dee2e6;">

                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Sei Processo</th>
                        <th scope="col"></th>
                        <th scope="col"></th>


                    </tr>

                </thead>

                <?php
                    $Transferenciafinanceira = transferenciafinanceira::consultar("SELECT * FROM transferenciafinanceira WHERE ativo = 1");
                    ?>
                <tbody>

                    <?php
                        foreach ($Transferenciafinanceira as $listarTransferenciafinanceira) {
                        ?>
                    <tr>
                        <th scope="row"><?php echo $listarTransferenciafinanceira['id']; ?></th>
                        <td><?php
                                    echo $listarTransferenciafinanceira['descricao'];
                                    ?></td>

                        <td><?php
                                    echo $listarTransferenciafinanceira['sei_processo'];
                                    ?></td>
                        <td>
                            <a
                                href="cadastrar_transferenciafinanceira.php?editar=true&idEditar=<?php echo $listarTransferenciafinanceira['id']; ?>">
                                <button type="" class="btn btn-warning"><i class="fas fa-user-edit"></i>&nbsp; Editar
                                </button></a>
                        </td>
                        <td>
                            <a
                                href="controller/transferenciafinanceira_controller.php?deletar=true&id=<?php echo $listarTransferenciafinanceira['id']; ?>">
                                <button type="" class="btn btn-danger"> <i class="fas fa-trash-alt"></i>&nbsp; Delete
                                </button></a>
                        </td>

                    </tr>

                    <?php } ?>

                </tbody>
            </table>

        </section>
        </center>

        <?php } ?>
        <?php if (isset($_REQUEST['editar']) and $_REQUEST['editar'] == true) { ?>

        <?php
            $idEditar = $_REQUEST['idEditar'];
            $Transferenciafinanceira = transferenciafinanceira::consultar("SELECT * FROM transferenciafinanceira WHERE ativo = 1 AND id = '$idEditar'");

            foreach ($Transferenciafinanceira as $ttt) {
            ?>
        <!-- ATUALIZAR Material -->
        <div class='container-fluid'>
            <form method='post' action='controller/transferenciafinanceira_controller.php'>
                <div class='row'>
                    <div class='col-xs-12 col-sm-6'>
                        <label>Descrição do Material</label>
                        <div class='group-material'>

                        </div>
                    </div>
                </div>

                <div class='full-reset row representative-resul'>
                    <div class="col">
                        <center>



                            <div class='col-sm-6'>
                                <label>Descrição</label>
                                <input type='text' value="<?php echo $ttt['descricao']; ?>"
                                    class='form-control text-center  tooltips-general' name='descritivoAtualizado'
                                    id='descricao' data-toggle='tooltip' data-placement='top' title='Nome da descrição'
                                    required>
                            </div>
                            <div class='col-sm-6'>

                                <label>N° Processo Sei</label>
                                <input type='text' value="<?php echo $ttt['sei_processo']; ?>"
                                    class='form-control text-center  tooltips-general' name='sei_processoAtualizado'
                                    id='sei_processo' data-toggle='tooltip' data-placement='top'
                                    title='Numero sei_processo' required>

                            </div>
                            <?php  } ?>
                            <br>
                            <br>

                            <input hidden name="atualizar">
                            <input hidden name="idAtualizar" value="<?php echo $idEditar; ?>">
                            <br><br>

                            <button type='reset' class='btn btn-light' id="limpar" style='margin-right: 20px;'><i
                                    class='glyphicon glyphicon-erase'></i> &nbsp;
                                &nbsp;
                                Limpar</button>


                            <button type='submit' id='btn_enviar' name='enviar' class='btn btn-primary'
                                style='margin-right: 20px;'><i class='glyphicon glyphicon-floppy-saved'
                                    style='margin-right: 20px;'></i> &nbsp;
                                &nbsp;
                                Atualizar</button>

                            <a href="cadastros.php" <button type='link' class='btn btn-danger'
                                style='margin-right: 20px;'><i class='glyphicon glyphicon-arrow-left'></i> &nbsp;
                                &nbsp;
                                Voltar</button></a>
                    </div>
                </div>
        </div>

        <span id='erro'></span>
        </form>
        <!-- ATUALIZAR DOCUMENTO -->
        <?php  } ?>

    </div>

</body>

</html>

<script type="text/javascript">
function inserir() {

    Swal.fire(
        'Documento inserido com sucesso!',
        'Sucesso!',
        'success'
    )
}
</script>

<script type="text/javascript">
function atualizar() {

    Swal.fire(
        'Documento atualizado com sucesso!',
        'Sucesso!',
        'success'
    )
}
</script>

<script type="text/javascript">
function del() {

    Swal.fire(
        'Documento deletado com sucesso!',
        'Sucesso!',
        'success'
    )
}
</script>

<script type="text/javascript">
function error() {

    Swal.fire(
        'ERRO',
        'Erro na Operação!',
        'error'
    )
}
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<?php
if ($_REQUEST['ok'] == 'inserir') {
    echo '<script>inserir()</script>';
    exit;
}

if ($_REQUEST['ok'] == 'atualizar') {
    echo '<script>atualizar()</script>';
    exit;
}

if ($_REQUEST['ok'] == 'delete') {
    echo '<script>del()</script>';
    exit;
}

if ($_REQUEST['ok'] == 'error') {
    echo '<script>error()</script>';
    exit;
}
?>