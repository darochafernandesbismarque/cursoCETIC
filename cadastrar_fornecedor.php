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
    <title>Cadastro de Fornecedor</title>

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

    <script>
    $(function() {
        $("#telefone").mask("(99)9999-9999");
        $("#cnpj").mask("99.999.999/9999-99");
        $input.focus().val($input.val());

    });

    $(document).ready(function() {
        var senha_autorizacao = NumeroAleatorio() + formataData(d1);
        $("#clinica_responsavel").val(clinica_responsavel);
    })

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
    </script>

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
    include_once 'library/fornecedor.php';
    include_once 'library/estado.php';
    include 'inc/NavLateral.php';
    ?>
    <div class='content-page-container full-reset custom-scroll-containers'>
        <?php
        include 'inc/NavUserInfo.php';
        ?>
        <div class='container'>
            <div class='page-header'>
                <h1 class='all-tittles'>SisMatOdonto <small> Cadastrar Fornecedor</small></h1>
            </div>
        </div>

        <?php if (!isset($_REQUEST['editar'])) { ?>

        <div class='container-fluid'>
            <form method='POST' action='controller/fornecedor_controller.php'>

                <div class='full-reset row representative-resul'>

                    <div class='col-xs-12 col-sm-6'>
                        <label>Nome do Fornecedor</label>
                        <input type='text' class='form-control text-center  tooltips-general' name='nome' id='nome'
                            data-toggle='tooltip' data-placement='top' title='Nome do Fornecedor' required>
                        <br>
                    </div>

                    <div class='col-xs-12 col-sm-6'>
                        <label>Razão Social</label>
                        <div class='group-material'>
                            <input type='text' class='form-control text-center  tooltips-general' name='razaosocial'
                                id='razaosocial' data-toggle='tooltip' data-placement='top'
                                title='Razão Social do Fornecedor' required>
                        </div>
                    </div>

                    <div class='col-xs-12 col-sm-6'>
                        <label>Estado</label>
                        <select class="form-control" id="estado" name="estado">
                            <option selected disabled aria-required="">Estado</option>
                            <?php
                                $estado = estado::consultar("SELECT * from estado order by descricao");
                                foreach ($estado as $e) {
                                    echo '<option value="' . $e["id"] . '">' . $e["descricao"] . '</option>';
                                } ?>
                        </select>
                    </div>

                    <div class='col-xs-12 col-sm-6'>
                        <label>Municipio</label>
                        <select class="form-control" id="cidade" name="cidade">

                        </select>
                        <br>
                    </div>

                    <div class='col-xs-12 col-sm-6'>
                        <label>Bairro</label>
                        <div class='group-material'>
                            <input type='text' class='form-control text-center  tooltips-general' name='bairro'
                                id='bairro' data-toggle='tooltip' data-placement='top' title='Bairro' required>
                        </div>
                    </div>

                    <div class='col-xs-12 col-sm-6'>
                        <label>Endereco</label>
                        <input type='text' class='form-control text-center  tooltips-general' name='logradouro'
                            id='logradouro' data-toggle='tooltip' data-placement='top' title='Endereco' required>
                        <br>
                    </div>

                    <div class='col-xs-12 col-sm-6'>
                        <label>CNPJ</label>
                        <div class='group-material'>
                            <input type='text' class='form-control text-center  tooltips-general' name='cnpj' id='cnpj'
                                data-toggle='tooltip' data-placement='top' title='cnpj' required>
                        </div>
                    </div>

                    <div class='col-xs-12 col-sm-6'>
                        <label>Telefone</label>
                        <input type='text' class='form-control text-center  tooltips-general' name='telefone'
                            id='telefone' data-toggle='tooltip' data-placement='top' title='Telefone' required>
                        <br>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <label for="exampleFormControlTextarea1" class="form-label">E-mail</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="email"
                            id="email"></textarea>
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
                    <font color="black">Fornecedores Cadastrados</font>
                </h1>
            </div>
        </center>

        <section id="direita">

            <table id="example" class="table table-striped col-md-12" align="center"
                style="background-color:#fff;  max-width: 1700px; position: relative; padding:30px; border: solid 1px #dee2e6;">

                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Razão Social</th>
                        <th scope="col">Logradouro</th>
                        <th scope="col">Bairro</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Municipio</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Telefone</th>

                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <?php
                    //$fornecedor = fornecedor::consultar("SELECT * FROM fornecedor WHERE ativo = 1");

                    $fornecedor = fornecedor::consultar("SELECT m.descricao as municipiodescricao, m.id, m.descricao, m.id_estado, f.id as idfornecedor, f.nome, f.razaosocial, f.logradouro,
                    f.bairro, f.id_municipio, f.email, f.email, f.telefone, f.ativo, e.id, e.descricao
                    FROM fornecedor AS f inner JOIN 
                    municipio AS m ON f.id_municipio = m.id
                    INNER JOIN estado AS e ON e.id = m.id_estado
                    WHERE ativo = 1");
                    ?>
                <tbody>

                    <?php
                        foreach ($fornecedor as $listarFornecedor) {
                        ?>
                    <tr>

                        <td>
                            <?php
                                    echo $listarFornecedor['idfornecedor'];
                                    ?>
                        </td>

                        <td>
                            <?php
                                    echo $listarFornecedor['nome'];
                                    ?>
                        </td>

                        <td>
                            <?php
                                    echo $listarFornecedor['razaosocial'];
                                    ?>
                        </td>

                        <td>
                            <?php
                                    echo $listarFornecedor['logradouro'];
                                    ?>
                        </td>

                        <td>
                            <?php
                                    echo $listarFornecedor['bairro'];
                                    ?>
                        </td>
                        <td>
                            <?php
                                    echo $listarFornecedor['descricao'];
                                    ?>
                        </td>

                        <td>
                            <?php
                                    echo $listarFornecedor['municipiodescricao'];
                                    ?>
                        </td>

                        <td>
                            <?php
                                    echo $listarFornecedor['email'];
                                    ?>
                        </td>

                        <td>
                            <?php
                                    echo $listarFornecedor['telefone'];
                                    ?>
                        </td>

                        <td>
                            <a
                                href="cadastrar_fornecedor.php?editar=true&idEditar=<?php echo $listarFornecedor['idfornecedor']; ?>">
                                <button type="" class="btn btn-warning"><i class="fas fa-user-edit"></i>&nbsp; Editar
                                </button></a>
                        </td>
                        <td>
                            <a
                                href="controller/fornecedor_controller.php?deletar=true&id=<?php echo $listarFornecedor['idfornecedor']; ?>">
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
            //$Fornecedor = fornecedor::consultar("SELECT * FROM fornecedor WHERE ativo = 1 AND id = '$idEditar'");

            $Fornecedor = fornecedor::consultar("SELECT f.id, f.nome, f.razaosocial, f.logradouro, f.bairro, f.id_municipio, f.email, f.telefone, m.id, m.descricao AS descricaoMunicipio, m.id_estado, e.id, e.descricao
            FROM fornecedor AS f INNER JOIN municipio AS m
            ON f.id_municipio = m.id   INNER JOIN estado AS e
            ON m.id_estado = e.id WHERE f.ativo = 1 AND f.id = '$idEditar'");

            foreach ($Fornecedor as $ttt) {
            ?>
        <!-- ATUALIZAR undaidemedida -->
        <div class='container-fluid'>
            <form method='post' action='controller/fornecedor_controller.php'>
                <div class='row'>
                    <div class='col-xs-12 col-sm-6'>
                        <label>Fornecedor</label>
                        <div class='group-material'>

                        </div>
                    </div>
                </div>

                <div class='full-reset row representative-resul'>
                    <div class="col">
                        <div class="row">
                            <div class='col-sm-6'>
                                <label>Nome</label>
                                <input type='text' value="<?php echo $ttt['nome']; ?>"
                                    class='form-control text-center  tooltips-general' name='nomeAtualizado' id='nome'
                                    data-toggle='tooltip' data-placement='top' title='Nome do Fornecedor' required>
                            </div>

                            <div class='col-sm-6'>

                                <label>Razao Social</label>
                                <input type='text' value="<?php echo $ttt['razaosocial']; ?>"
                                    class='form-control text-center  tooltips-general' name='razaosocialAtualizado'
                                    id='descricao' data-toggle='tooltip' data-placement='top'
                                    title='Nome da Razão Social' required>
                            </div>

                            <div class='col-sm-6'>
                                <label>Endereço</label>
                                <input type='text' value="<?php echo $ttt['logradouro']; ?>"
                                    class='form-control text-center  tooltips-general' name='logradouroAtualizado'
                                    id='logradouro' data-toggle='tooltip' data-placement='top'
                                    title='Endereço Fornecedor' required>
                            </div>

                            <div class='col-sm-6'>
                                <label>Bairro</label>
                                <input type='text' value="<?php echo $ttt['bairro']; ?>"
                                    class='form-control text-center  tooltips-general' name='bairroAtualizado'
                                    id='bairro' data-toggle='tooltip' data-placement='top' title='Bairro do Fornecedor'
                                    required>
                            </div>

                            <div class='col-xs-12 col-sm-6'>
                                <label>Estado</label>
                                <select class="form-control" id="estado" name="estado">
                                    <!-- <option selected disabled aria-required="">Estado</option> -->
                                    <?php
                                            echo '<option value="' . $ttt["id"] . '">' . $ttt["descricao"] . '</option>';

                                            $estado = estado::consultar("SELECT * from estado order by descricao");
                                            foreach ($estado as $e) {
                                                echo '<option  autofocus value="' . $e["id"] . '">' . $e["descricao"] . '</option>';
                                            } ?>
                                </select>
                            </div>

                            <div class='col-xs-12 col-sm-6'>
                                <label>Municipio</label>
                                <select class="form-control" id="cidade" name="cidade">

                                    <?php echo '<option value="' . $ttt["id"] . '">' . $ttt["descricaoMunicipio"] . '</option>'; ?>

                                </select>
                                <br>
                            </div>

                            <div class='col-sm-6'>
                                <label>Email</label>
                                <input type='text' value="<?php echo $ttt['email']; ?>"
                                    class='form-control text-center  tooltips-general' name='emailAtualizado' id='email'
                                    data-toggle='tooltip' data-placement='top' title='E-mail do Fornecedor' required>
                            </div>

                            <div class='col-sm-6'>
                                <label>Telefone</label>
                                <input type='text' value="<?php echo $ttt['telefone']; ?>"
                                    class='form-control text-center  tooltips-general' name='telefoneAtualizado'
                                    id='telefone' data-toggle='tooltip' data-placement='top'
                                    title='Telefone do Fornecedor' required>
                            </div>

                        </div><!-- row -->
                        <?php } ?>
                        <br>

                        <input hidden name="atualizar">
                        <input hidden name="idAtualizar" value="<?php echo $idEditar; ?>">

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
            </form>
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
    setTimeout(function() {
        window.location.href = "cadastrar_fornecedor.php";
    }, 1500);
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
if (isset($_REQUEST['ok']) and $_REQUEST['ok'] == 'inserir') {
    echo '<script>inserir()</script>';
    exit;
}
if (isset($_REQUEST['ok']) and $_REQUEST['ok'] == 'atualizar') {
    echo '<script>atualizar()</script>';
    exit;
}
if (isset($_REQUEST['ok']) and $_REQUEST['ok'] == 'delete') {
    echo '<script>del()</script>';
    exit;
}
if (isset($_REQUEST['ok']) and $_REQUEST['ok'] == 'error') {
    echo '<script>error()</script>';
    exit;
}
?>
<script>
$("#estado").on("change", function() {
    var idEstado = $("#estado").val();

    $.ajax({
        url: 'ajax_cidades.php',
        type: 'POST',
        data: {
            id: idEstado
        },
        beforeSend: function() {
            $("#cidade").html("<option>carregando...</option>");
        },
        success: function(data) {
            $("#cidade").html(data);
        }
    })
})
</script>