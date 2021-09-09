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
            buttons: [
            ]
        });
    });
    </script>
    <!-- data table com exportação-->
    <?php
    include_once 'library/configserver.php';
    include_once 'library/Consulta.php';
    include_once 'library/consulsql.php';
    include_once 'library/material.php';
    include_once 'library/classe.php';
    include_once 'library/tipomaterial.php';
    include_once 'library/unidademedida.php';
    include_once 'library/saida.php';
    include_once 'library/usuario.php';
    include_once 'library/pedido.php';
    include_once 'library/opm.php';
    include_once 'library/fornecedor.php';
    include_once 'class/materiais.class.php';
    include_once 'controller/entrada_material_controller.php';
    include_once 'library/entrada.php';
    include_once 'library/tipoentrada.php';
    include_once 'class/dados.class.php';
    include 'inc/NavLateral.php';

    if ($_SESSION['UserOPM'] == '') {
        header('Location: process/logout.php');
        exit();
    }

    function alertas($texto, $tipo)
    {
        $_SESSION['msg'] = "<div class='alert alert-" . $tipo . "' role='alert'> <b>" . $texto . '</b></div>';
        echo '<script type="text/javascript">retiramsg();</script>';
    }
?>
    <div class='content-page-container full-reset custom-scroll-containers'>

        <?php include 'inc/NavUserInfo.php';    ?>
        <div class='container'>
            <div class='page-header'>
                <h1 class='all-tittles'>SisMatOdonto <small> Entrada de Material</small></h1>
            </div>
        </div>
        <div id='msg'>
<?php
//echo $_SESSION['msg'];
//unset( $_SESSION['msg'] );
?>
        </div>
        <br>
        <div class='container-fluid'>
            <form method='post' action='controller/entrada_material_controller.php'>
                <div class='row'>
                    <div class='col-xs-12 col-sm-4'>
                        <label>Tipo Entrada</label>
                        <div class='group-material'>

                        <input type="hidden" name="id_opm" value="<?php echo $opm_logado; ?>"> 

                            <select class="form-control" title='Selecione o Material' name='material' id='lote'
                                onChange='javascript: ValidaMat();' required>
                                <?php
                                $rsd  = tipoentrada::consultar("SELECT * FROM tipoentrada where ativo = 1");

                                foreach ($rsd as $material) {
                                    echo '<option id="' . $material['id'] .'" value="' . $material['id'] .'">'. $material['descricao'].'</option>';
                                }
                                ?>
                            </select>
                            <span class='bar'></span>
                            <span id='validaMat'>
                                <p style='color:red;'><b>* </b></P>
                            </span>
                        </div>
                    </div>

                    <div class='col-xs-12 col-sm-4'>
                        <label>Validade</label>
                        <div class='group-material'>
                            <input type='date' class='selectpicker  form-control text-center  tooltips-general'
                                name='validade' id='valiade' maxlength='20' data-toggle='tooltip' value='00/00/0000'
                                data-placement='top' title='Informe a data de Vencimento do Material (OPCIONAL)'>
                        </div>
                    </div>

                    <div class='col-xs-12 col-sm-4'>
                        <label>Classe</label>
                        <div class='group-material'>


                            <select class="form-control" name='tipoMaterial' id="tipoMaterial">
                                <?php
                                $tipoClasse = classe::consultar("SELECT * FROM ClasseSiga");
                                foreach ($tipoClasse as $tipoCla) {
                                    echo "<option>$tipoCla[descricao]</option>";
                                }
                                ?>
                            </select>
                        </div>

                    </div>
                </div>

                <div class='row'>
                    <div class='col-xs-12 col-sm-4'>
                        <label>Unidade Medida</label>
                        <select class="form-control" name='unidadeMedida' id="unidadeMedida">
                            <?php
                            $unMed = unidademedida::consultar("SELECT id, descricao FROM unidademedida");
                            foreach ($unMed as $med) {
                                echo '<option value="'. $med['id'].'">' .$med['descricao'].'</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class='col-xs-12 col-sm-4'>
                        <label>Origem</label>
                        <div class='group-material'>
                            <select class="form-control" name='tipoverba' id='tipoverba'
                                onChange='javascript:AquisicaoDiv();'>
                                <?php if ($opm_logado == 164) {
                                ?>
                                <option value='1'>Aquisiçao SEPM</option>
                                <option value='2'>Doação</option> <?php }
                                                                        ?>
                                <option value='3'>Transferência Financeira</option>
                                <option value='4'>Adiantamento Financeiro</option>
                                <option value='99'>Estoque Inicial</option>
                            </select>
                        </div>
                    </div>

                    <div class='col-xs-12 col-sm-4'>
                        <label>&nbsp;Fornecedor
                        </label>

                        <div class='group-material'>
                            <select class="form-control" name='fornecedor' required>
                                <?php
                                $queryforn = fornecedor::consultar("SELECT * FROM fornecedor");
                                foreach ($queryforn as $forn) {
                                    echo '<option value="' . $forn['id'] . '">' . $forn['nome'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class='row'>
                    <div class='col-xs-12 col-sm-4' id='processo'>
                        <label>Nº Processo</label>
                        <div class='group-material'>
                            <input type='text' class=' form-control text-center tooltips-general' name='processo'
                                data-toggle='tooltip' data-placement='top' title='Digite o nº do processo de aquisição'>
                        </div>
                    </div>
                    <div class='col-xs-12 col-sm-4'>
                        <label>Nº ATA</label>
                        <div class='group-material'>
                            <input type='number' step='0.01' class=' form-control text-center tooltips-general' id='ata'
                                name='ata' data-toggle='tooltip' data-placement='top'
                                title='Digite o nº da ATA do processo de aquisição!'>
                        </div>
                    </div>
                    <div class='col-xs-12 col-sm-4'>
                        <label>Nº Contrato</label>
                        <div class='group-material'>
                            <input type='number' class=' form-control text-center tooltips-general' min='1' step='1'
                                name='contrato' id='contrato' maxlength='10' data-toggle='tooltip' data-placement='top'
                                title='Digite o nº do contrato de aquisição'>
                        </div>
                    </div>

                </div>
                <div class='row'>
                    <div class='col-xs-12 col-sm-4'>
                        <label>Nº Empenho</label>
                        <div class='group-material'>
                            <input type='number' step='0.01' class=' form-control text-center tooltips-general'
                                id='empenho' name='empenho' data-toggle='tooltip' data-placement='top' title='Empenho'>
                            <span class='highlight'></span>
                            <span class='bar'></span>
                        </div>
                    </div>

                    <div class='col-xs-12 col-sm-4 '>
                        <label>Valor Unitário</label>
                        <div class='group-material'>
                            <input type='number' step='0.01' class=' form-control text-center tooltips-general'
                                id='vlrunt' name='vl_uni' data-toggle='tooltip' data-placement='top' title='Classe'
                                required>

                        </div>
                    </div>

                    <div class='col-xs-12 col-sm-4'>
                        <label>Quantidade</label>
                        <div class='group-material'>
                            <input type='number' class=' form-control text-center tooltips-general' min='1' step='1'
                                name='qnt' id='qnt_rec' maxlength='10' data-toggle='tooltip' data-placement='top'
                                title='Quantidade Recebida' onBlur='javascript: CalcVlTotal();' required>
                            <span class='highlight'></span>
                            <span class='bar'></span>
                        </div>
                    </div>

                </div>

                <div class='row'>
                    <div class='col-xs-12 col-sm-4'>
                        <label>Valor Total</label>
                        <div class='group-material'>
                            <input type='number' step='0.01' class=' form-control text-center tooltips-general'
                                id='vl_total' name='vl_total' data-toggle='tooltip' data-placement='top'
                                title='Valor Total' required>
                            <span class='highlight'></span>
                            <span class='bar'></span>
                        </div>
                    </div>

                    <div class='col-xs-12 col-sm-4'>
                        <label>Tipo Documento</label>
                        <div class='group-material'>
                            <select class="form-control" name='tipodoc' required>
                                <option value='1'>Nota Fiscal</option>
                                <option value='2'>Termo de Doacao</option>
                                <option value='3'>Danf</option>
                                <option value='4'>Estoque Inicial</option>
                            </select>
                        </div>
                    </div>
                    <div class='col-xs-12 col-sm-4'>
                        <label>Número Documento</label>
                        <div class='group-material'>
                            <input type='text' class=' form-control text-center tooltips-general' name='ndoc'
                                maxlength='70' value='00' data-toggle='tooltip' data-placement='top'
                                title='Número do Documento'>
                        </div>
                    </div>
                    <div class='col-xs-12 col-sm-4'>
                        <label>Data Documento</label>
                        <div class='group-material'>
                            <input type='date' class='selectpicker  form-control text-center tooltips-general'
                                name='dtdoc' id='dtdoc' maxlength='20' data-toggle='tooltip' value='25/09/2020'
                                data-placement='top' title='Data do Documento'>
                        </div>
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


                        <a href="home.php" <button type='link' class='btn btn-danger' style='margin-right: 20px;'><i
                                class='glyphicon glyphicon-arrow-left'></i> &nbsp;
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
                    <font color="black">Estoque de Materiais</font>
                </h1>
            </div>
        </center>

        <section id="direita">

            <table id="example" class="table table-striped col-md-12" align="center"
                style="background-color:#fff;  max-width: 1700px; position: relative; padding:30px; border: solid 1px #dee2e6;">

                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">id_fornecedor</th>
                        <th scope="col">id_material</th>
                        <th scope="col">qnt</th>
                        <th scope="col">vl_uni</th>
                        <th scope="col">vl_total</th>
                        <th scope="col">data</th>
                        <th scope="col">nf</th>
                        <th scope="col">tipo_verba</th>
                        <th scope="col">documento</th>
                        <th scope="col">und_medida</th>
                        <th scope="col">id_opm</th>
                        <th scope="col">status</th>
                        <th scope="col">validade</th>
                        <th scope="col">dt_doc</th>
                        <th scope="col">obs</th>
                        <th scope="col">contrato</th>
                        <th scope="col">empenho</th>
                        <th scope="col">ata</th>
                        <th scope="col">processo</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>

                <?php
                $entradaMaterial = entradamaterial::consultar("SELECT * FROM entrada");
                ?>
                <tbody>

                    <?php
                    foreach ($entradaMaterial as $listarEntraMaterial) {
                    ?>
                    <tr>
                        <th scope="row"><?php echo $listarEntraMaterial['id']; ?></th>
                        <td><?php
                                echo $listarEntraMaterial['id_fornecedor'];
                                ?>
                        </td>

                        <td><?php
                                echo $listarEntraMaterial['id_material'];
                                ?>
                        </td>

                        <td><?php
                                echo $listarEntraMaterial['quantidade'];
                                ?>
                        </td>

                        <td><?php
                                echo $listarEntraMaterial['valor_unitario'];
                                ?>
                        </td>

                        <td><?php
                                echo $listarEntraMaterial['valor_total'];
                                ?>
                        </td>

                        <td><?php
                                echo $listarEntraMaterial['data'];
                                ?>
                        </td>

                        <td><?php
                                echo $listarEntraMaterial['notafiscal'];
                                ?>
                        </td>

                        <td><?php
                                echo $listarEntraMaterial['tipo_verba'];
                                ?>
                        </td>

                        <td><?php
                                echo $listarEntraMaterial['documento'];
                                ?>
                        </td>

                        <td><?php
                                echo $listarEntraMaterial['und_medida'];
                                ?>
                        </td>

                        <td><?php
                                echo $listarEntraMaterial['id_opm'];
                                ?>
                        </td>

                        <td><?php
                                echo $listarEntraMaterial['status'];
                                ?>
                        </td>

                        <td><?php
                                echo $listarEntraMaterial['validade'];
                                ?>
                        </td>

                        <td>
                            <?php
                                echo $listarEntraMaterial['data_documento'];
                                ?></td>
                                
                        <td><?php
                                echo $listarEntraMaterial['observacao'];
                                ?>
                        </td>


                        <td><?php
                                echo $listarEntraMaterial['contrato'];
                                ?>
                        </td>

                        <td><?php
                                echo $listarEntraMaterial['empenho'];
                                ?></td>


                        <td><?php
                                echo $listarEntraMaterial['ata'];
                                ?>
                        </td>

                        <td><?php
                                echo $listarEntraMaterial['processo'];
                                ?>
                        </td>

                        <td><a
                                href="receber_material.php?editar=true&idEditar=<?php echo $listarEntraMaterial['id']; ?>">
                                <button type="" class="btn btn-warning"><i class="fas fa-user-edit"></i>&nbsp; Editar
                                </button></a>
                        </td>
                        <td>
                            <a
                                href="controller/unidade_medida_controller.php?deletar=true&id=<?php echo $listarEntraMaterial['id']; ?>">
                                <button type="" class="btn btn-danger"> <i class="fas fa-trash-alt"></i>&nbsp; Delete
                                </button></a>
                        </td>
                    </tr>

                    <?php } ?>
                </tbody>
            </table>
        </section>
        </center>


</body>
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