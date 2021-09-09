<?php
ob_start();
error_reporting(0);
session_start();
$pm_logado  = $_SESSION['UserRG'];
$opm_logado = $_SESSION['UserOPM'];
$codSiga    = $_REQUEST['codSiga'];
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

    <?php
    // include_once 'library/Conexao.php';
    //include_once 'library/configserver.php';
    include_once 'library/Consulta.php';
    include_once 'library/consulsql.php';
    include_once 'library/itemSiga.php';
    include_once 'library/tipomaterial.php';
    include_once 'library/saida.php';
    include_once 'library/usuario.php';
    include_once 'library/material.php';
    include_once 'library/pedido.php';
    include_once 'library/opm.php';
    include_once 'library/unidademedida.php';
    include_once 'class/materiais.class.php';
    include_once 'class/dados.class.php';

    if ($_SESSION['UserRG'] == '') {
        header("Location: process/logout.php");
        exit();
    }
    function alertas($texto, $tipo)
    {
        $_SESSION["msg"] = "<div class='alert alert-" . $tipo . "' role='alert'> <b>" . $texto . "</b><button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
           </button></div>";

        echo '<script type="text/javascript">retiramsg();</script>';
    }
    include 'inc/NavLateral.php';
    ?>
    <div class="content-page-container full-reset custom-scroll-containers">
        <?php include 'inc/NavUserInfo.php'; ?>
        <div class="container">
            <div class="page-header">
                <h1 class="all-tittles">SisMatOdonto <small>Cadastro de Material</small></h1>
            </div>
        </div>
        <?php if (!isset($_REQUEST['editar'])) { ?>

        <div class='container-fluid'>
            <form method='POST' action='controller/material_controller.php'>
                <div class='full-reset row representative-resul'>
                    <div class="alert alert-secondary  col-md-12" role="alert" align="center">
                        <h6>
                            <div class='col-xs-12 col-sm-3'>
                                <label>Item SIGA</label>

                                <?php
                                    $siga = itemSiga::consultar("SELECT
i.idItem,
i.codigoitem,
i.descricao,
a.idArtigo,
a.descricao AS artigo,
c.idClasse,
c.descricao AS classe,
f.idFamilia,
f.descricao AS familia,
t.idTipo,
t.descricao AS tipo
FROM
ItemSiga i
INNER JOIN ArtigoSiga a ON a.idArtigoSiga = i.idArtigoSiga
INNER JOIN ClasseSiga c ON c.idClasseSiga = a.idClasseSiga
INNER JOIN FamiliaSiga f ON f.idFamiliaSiga = c.idFamiliaSiga
INNER JOIN TipoSiga t ON t.idTipoSiga = f.idTipoSiga
WHERE
idItem = '$codSiga'");

                                    if (isset($_REQUEST['enviar'])) {
                                        if (count($siga) < 1) {
                                            header("location: buscar_codigo_siga.php?erro=erro");
                                            exit;
                                        }
                                    }

                                    foreach ($siga as $listar) {
                                    ?>

                                <input type='text' value="<?php echo $listar['idItem'] ?>"
                                    class='form-control text-center  tooltips-general' name='itemSIGA' id='itemSIGA'
                                    data-toggle='tooltip' data-placement='top' title='Código Item SIGA' disabled>
                                <br>
                            </div>

                            <div class='col-xs-12 col-sm-9'>
                                <label>Descrição SIGA</label>
                                <div class='group-material'>
                                    <input type='text' value="<?php echo $listar['descricao'] ?>"
                                        class='form-control text-center  tooltips-general' name='descricaoSIGA'
                                        id='descricaoSIGA' data-toggle='tooltip' data-placement='top'
                                        title='Descrição SIGA' disabled>
                                </div>
                            </div>

                            <div class='col-xs-12 col-sm-3'>
                                <label>Artigo SIGA</label>
                                <div class='group-material'>
                                    <input type='text' value="<?php echo $listar['artigo'] ?>"
                                        class='form-control text-center  tooltips-general' name='artigoSIGA'
                                        id='artigoSIGA' data-toggle='tooltip' data-placement='top'
                                        title='ID Artigo SIGA' disabled>
                                </div>
                            </div>

                            <div class='col-xs-12 col-sm-5'>
                                <label>Classe</label>
                                <div class='group-material'>
                                    <input type='text' value="<?php echo $listar['classe'] ?>"
                                        class='form-control text-center  tooltips-general' name='classe' id='classe'
                                        data-toggle='tooltip' data-placement='top' title='ID Artigo SIGA' disabled>
                                </div>
                            </div>

                            <div class='col-xs-12 col-sm-4'>
                                <label>Familia</label>
                                <div class='group-material'>
                                    <input type='text' value="<?php echo $listar['familia'] ?>"
                                        class='form-control text-center  tooltips-general' name='familia' id='familia'
                                        data-toggle='tooltip' data-placement='top' title='Bairro' disabled>
                                </div>
                            </div>
                            <?php } ?>
                    </div>
                    <span id='erro'></span>
                    <center>

                        <font color="black"></font>
                        </h6>
                </div>
                </center>

                <?php
                    $itemsiga = itemSiga::consultar("SELECT IdItemSiga FROM ItemSiga WHERE IdItemSiga = '$codSiga'");
                    foreach ($itemsiga as $ii) {
                    ?>
                <input type="hidden" name="itemSIGA" value="<?php echo $ii['IdItemSiga']; ?>">
                <?php } ?>

                <div class='full-reset row representative-resul'>

                    <div class='col-xs-12 col-sm-3'>
                        <label>Código EAN</label>
                        <input type='text' autofocus class='form-control text-center  tooltips-general' name='codigoEAN'
                            id='codigoEAN' data-toggle='tooltip' data-placement='top' title='Código Item SIGA' required>
                        <br>
                    </div>

                    <div class='col-xs-12 col-sm-3'>
                        <label>Código Interno</label>
                        <input type='text' autofocus class='form-control text-center  tooltips-general'
                            name='codigointerno' id='codigointerno' data-toggle='tooltip' data-placement='top'
                            title=' codigointerno' required>
                        <br>
                    </div>

                    <div class='col-xs-12 col-sm-6'>
                        <label>Descrição Produto</label>
                        <div class='group-material'>
                            <input type='text' class='form-control text-center  tooltips-general'
                                name='descricaoProduto' id='descricaoProduto' data-toggle='tooltip' data-placement='top'
                                title='Descrição SIGA' required>
                        </div>
                    </div>

                    <div class='col-xs-12 col-sm-3'>
                        <label>Unidade Medida</label>
                        <select class="form-control" name='unidadeMedida' id="unidadeMedida">
                            <?php
                                $unMed = unidademedida::consultar("SELECT id, descricao FROM unidademedida WHERE ativo = 1");
                                foreach ($unMed as $med) {
                                    echo "<option value='$med[id]'>$med[descricao]</option>";
                                }
                                ?>
                        </select>

                    </div>

                    <div class='col-xs-12 col-sm-3'>
                        <label>Tipo de Material</label>
                        <select class="form-control" name='idTipoMaterial' id="idTipoMaterial">
                            <?php
                                $tipoMaterial = tipomaterial::consultar("SELECT * FROM tipomaterial where ativo = 1");
                                foreach ($tipoMaterial as $tipoMat) {
                                    echo "<option value='$tipoMat[id]'>$tipoMat[descr]</option>";
                                }
                                ?>
                        </select>

                    </div>

                    <div class='col-xs-12 col-sm-2'>
                        <label>Estoque Mínimo</label>
                        <div class='group-material'>
                            <input type='text' class='form-control text-center  tooltips-general' name='estoqueMinimo'
                                id='estoqueMinimo' data-toggle='tooltip' data-placement='top' title='Bairro' required>
                        </div>
                    </div>


                    <div class="form-check">

                        <label class="form-check-label" for="flexCheckIndeterminate">
                            Produto Obsoleto<p>
                        </label>
                        <H6><input class="form-check-input" type="checkbox" value="1" id="flexCheckIndeterminate"
                                name="obsoleto"></H6>
                    </div>
                </div>
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

                        <a href="buscar_codigo_siga.php" <button type='link' class='btn btn-danger'
                            style='margin-right: 20px;'><i class='glyphicon glyphicon-arrow-left'></i> &nbsp;
                            &nbsp;
                            Voltar</button></a>
                    </center>
                    <br><br>
                </div>
            </form>
        </div>

        <center>
            <div class="alert alert-secondary  col-md-12" role="alert" align="center">
                <h1>
                    <font color="black">Materiais Cadastrados</font>
                </h1>
            </div>
        </center>

        <section id="direita">

            <table id="example" class="table table-striped col-md-12" align="center"
                style="background-color:#fff;  max-width: 1700px; position: relative; padding:30px; border: solid 1px #dee2e6;">

                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Código Interno</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Estoque Mínimo</th>
                        <th scope="col">ID Tipo Material</th>
                        <th scope="col">ID Medida</th>
                        <th scope="col">ID Item Siga</th>
                        <th scope="col">Obsoleto</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <?php
                    $material = itemSiga::consultar("SELECT * FROM material WHERE ativo = 1");
                    ?>
                <tbody>

                    <?php
                        foreach ($material as $listarMaterial) {
                        ?>
                    <tr>
                        <th scope="row"><?php echo $listarMaterial['id']; ?></th>
                        <td><?php
                                    echo $listarMaterial['codigointerno'];
                                    ?>
                        </td>

                        <td><?php
                                    echo $listarMaterial['descricao'];
                                    ?>
                        </td>

                        <td><?php
                                    echo $listarMaterial['estoqueminimo'];
                                    ?>
                        </td>

                        <td><?php
                                    echo $listarMaterial['id_tipomaterial'];
                                    ?>
                        </td>

                        <td><?php
                                    echo $listarMaterial['id_medida'];
                                    ?>
                        </td>

                        <td><?php
                                    echo $listarMaterial['id_item_siga'];
                                    ?>
                        </td>

                        <td><?php
                                    echo $listarMaterial['obsoleto'];
                                    ?>
                        </td>

                        <td>
                            <a href="cadastrar_material.php?editar=true&idEditar=<?php echo $listarMaterial['id']; ?>">
                                <button type="" class="btn btn-warning"><i class="fas fa-user-edit"></i>&nbsp; Editar
                                </button></a>
                        </td>
                        <td>
                            <a
                                href="controller/material_controller.php?deletar=true&id=<?php echo $listarMaterial['id']; ?>">
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
            $Material = material::consultar("SELECT * FROM material WHERE ativo = 1 AND id = '$idEditar'");

            foreach ($Material as $ttt) {
            ?>
        <!-- ATUALIZAR unidademedida -->
        <div class='container-fluid'>
            <form method='post' action='controller/material_controller.php'>
                <div class='row'>
                    <div class='col-xs-12 col-sm-6'>
                        <label>Material</label>
                        <div class='group-material'>

                        </div>
                    </div>
                </div>

                <div class='full-reset row representative-resul'>
                    <div class="col">
                        <center>
                            <div class="row">

                                <div class='col-sm-6'>

                                    <input hidden name="atualizar" value="">
                                    <input hidden name="idAtualizar" value="<?php echo $idEditar; ?>">

                                    <label>Código Interno</label>
                                    <input type='text' value="<?php echo $ttt['codigointerno']; ?>"
                                        class='form-control text-center  tooltips-general'
                                        name='codigointernoAtualizado' id='codigointerno' data-toggle='tooltip'
                                        data-placement='top' title='Código Interno' required>
                                </div>

                                <div class='col-sm-6'>
                                    <label>Descrição</label>
                                    <input type='text' value="<?php echo $ttt['descricao']; ?>"
                                        class='form-control text-center  tooltips-general' name='descricaoAtualizado'
                                        id='descricao' data-toggle='tooltip' data-placement='top' title='Descricao'
                                        required>
                                </div>

                                <div class='col-sm-6'>
                                    <label>Estoque Mínimo</label>
                                    <input type='text' value="<?php echo $ttt['estoqueminimo']; ?>"
                                        class='form-control text-center  tooltips-general'
                                        name='estoqueminimoAtualizado' id='estoqueminimo' data-toggle='tooltip'
                                        data-placement='top' title='estoqueminimo' required>
                                </div>

                                <div class='col-sm-6'>
                                    <label>Id Tipo Material</label>
                                    <input type='text' value="<?php echo $ttt['id_tipomaterial']; ?>"
                                        class='form-control text-center  tooltips-general'
                                        name='id_tipomaterialAtualizado' id='id_tipomaterial' data-toggle='tooltip'
                                        data-placement='top' title='id tipo material' required disabled>
                                </div>

                                <div class='col-sm-6'>
                                    <label>Id Medida</label>
                                    <input type='text' value="<?php echo $ttt['id_medida']; ?>"
                                        class='form-control text-center  tooltips-general' name='id_medidaAtualizado'
                                        id='id_medida' data-toggle='tooltip' data-placement='top' title='id medida'
                                        required disabled>
                                </div>

                                <div class='col-sm-6'>
                                    <label>Id Item Siga</label>
                                    <input type='text' value="<?php echo $ttt['id_item_siga']; ?>"
                                        class='form-control text-center  tooltips-general' name='id_item_sigaAtualizado'
                                        id='id_item_siga' data-toggle='tooltip' data-placement='top'
                                        title='id_item_siga' required disabled>
                                </div>


                                <div class="form-check">

                                    <label class="form-check-label" for="flexCheckIndeterminate">
                                        Produto Obsoleto<p>
                                    </label>
                                    <H6><input class="form-check-input" type="checkbox"
                                            value="<?php echo $ttt['obsoleto']; ?>" id="flexCheckIndeterminate"
                                            name="obsoletoAtualizado"></H6>
                                </div>




                            </div><!-- row -->
                            <?php } ?>
                            <br>

                            <button type='reset' class='btn btn-light' id="limpar" style='margin-right: 20px;'><i
                                    class='glyphicon glyphicon-erase'></i> &nbsp;
                                &nbsp;
                                Limpar</button>

                            <button type='submit' id='btn_enviar' name='enviarATUALIZAR' class='btn btn-primary'
                                style='margin-right: 20px;'><i class='glyphicon glyphicon-floppy-saved'
                                    style='margin-right: 20px;'></i> &nbsp;
                                &nbsp;
                                Atualizar</button>

                            <a href="buscar_codigo_siga.php" <button type='link' class='btn btn-danger'
                                style='margin-right: 20px;'><i class='glyphicon glyphicon-arrow-left'></i> &nbsp;
                                &nbsp;
                                Voltar</button></a>
            </form>
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