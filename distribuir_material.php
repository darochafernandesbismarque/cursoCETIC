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
    <title>Saída de Material</title>

    <script type='text/javascript'></script><!-- data table com exportação-->
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

    <script language="javascript">
    function moeda(a, e, r, t) {
        let n = "",
            h = j = 0,
            u = tamanho2 = 0,
            l = ajd2 = "",
            o = window.Event ? t.which : t.keyCode;
        if (13 == o || 8 == o)
            return !0;
        if (n = String.fromCharCode(o),
            -1 == "0123456789".indexOf(n))
            return !1;
        for (u = a.value.length,
            h = 0; h < u && ("0" == a.value.charAt(h) || a.value.charAt(h) == r); h++)
        ;
        for (l = ""; h < u; h++)
            -
            1 != "0123456789".indexOf(a.value.charAt(h)) && (l += a.value.charAt(h));
        if (l += n,
            0 == (u = l.length) && (a.value = ""),
            1 == u && (a.value = "0" + r + "0" + l),
            2 == u && (a.value = "0" + r + l),
            u > 2) {
            for (ajd2 = "",
                j = 0,
                h = u - 3; h >= 0; h--)
                3 == j && (ajd2 += e,
                    j = 0),
                ajd2 += l.charAt(h),
                j++;
            for (a.value = "",
                tamanho2 = ajd2.length,
                h = tamanho2 - 1; h >= 0; h--)
                a.value += ajd2.charAt(h);
            a.value += r + l.substr(u - 2, u)
        }
        return !1
    }
    </script>
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
    include_once 'controller/entrada_material_item_controller.php';

    include_once 'controller/usb.php';

    include_once 'library/entrada.php';
    include_once 'library/entrada_material.php';
    include_once 'library/tipoentrada.php';
    include_once 'library/usb.php';

    include_once 'library/tipodocumento.php';
    include_once 'library/tipo_entrada_material.php';
    include_once 'library/entrada_material_item.php';
    include_once 'library/transferenciafinanceira.php';
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
                <h1 class='all-tittles'>SisMatOdonto <small> Saída de Material</small></h1>
            </div>
        </div>
        <div id='msg'>
            <?php
            $query = tipoentradamaterial::consultar("SELECT id FROM entradamaterial order by id desc limit 1");
            foreach ($query as $q) {
                $idNota = $_SESSION['id_nota'] = $q['id'];
            }
            ?>
        </div>
        <br>
        <div class='container-fluid'>
            <form method='post' action='controller/entrada_material_item_controller.php'>
                <div class='row'>
                    <div class='col-xs-12 col-sm-10'>
                        <label>USB </label>
                        <div class='group-material'>
                            <select class="form-control" name='fornecedor' required>
                                <?php
                                $queryforn = usb::consultar("SELECT * FROM usb");
                                foreach ($queryforn as $forn) {
                                    echo '<option value="' . $forn['id'] . '">' . $forn['descricao'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>


                    <div class='col-xs-12 col-sm-4'>

                        <label>Material </label>

                        <div class='group-material'>
                            <input type="text" name="material" id="material" class="form-control" list="item"><br>
                            <datalist name="item" id="item"></datalist>
                        </div>
                    </div>

                    <div class='col-xs-12 col-sm-4'>
                        <label>Quantidade</label>
                        <div class='group-material'>
                            <input type="hidden" name="id_opm" value="<?php echo $opm_logado; ?>">
                            <input type="text" class=' form-control text-center tooltips-general' name="quantidade"
                                value="">

                            <span class='bar'></span>
                            <span id='validaMat'>
                                <p style='color:red;'><b> * </b></P>
                            </span>
                        </div>
                    </div>


                </div>

                <div class='row'>

                    <input type="hidden" name="id_nota" value="<?php echo $_SESSION['id_nota']; ?>" </div>
                    <center>
                        <div class='row'>
                            <div class="col-sm-2'">

                                <center>
                                    <button type='reset' class='btn btn-light' id="limpar"
                                        style='margin-right: 20px;'><i class='glyphicon glyphicon-erase'></i> &nbsp;
                                        &nbsp;
                                        Limpar</button>
                            </div>

                            <div class="col-sm-2'">
                                <button type='submit' id='btn_enviar' name='enviarTipoDocumento' class='btn btn-primary'
                                    style='margin-right: 20px;'><i class='glyphicon glyphicon-floppy-saved'
                                        style='margin-right: 20px;'></i>Incluir Item</button>
                            </div>
                            <div class="col-sm-2'">

                                <a href="home.php" <button type='link' class='btn btn-danger'
                                    style='margin-right: 20px;'><i class='glyphicon glyphicon-arrow-left'></i> &nbsp;
                                    &nbsp;
                                    Voltar</button></a>
                            </div>

                            <div class="col-sm-2'">
                                <button onclick="sair()" type="button" class="btn btn-success"> <svg
                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-bookmark-check-fill" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5zm8.854-9.646a.5.5 0 0 0-.708-.708L7.5 7.793 6.354 6.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z" />
                                    </svg> &nbsp; FINALIZAR PEDIDO</button>
                            </div>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <!--<div class="col-sm-3'">
                            <div class="alert alert-primary" role="alert"
                                style="width: 350px; height:40px; line-height:80%;">
                                <?php
                                /*$valor = entradaMaterialItem::consultar("SELECT SUM(valorunitario * quantidade) as Valor
                                         from entradamaterialitem WHERE id_entradamanterial = '$idNota' AND ativo = 1");

                                $valortotal = 0;
                                foreach ($valor as $v) {
                                    $valortotal += $v["Valor"];
                                }

                                echo "Valor total da nota:   <b> R$ " . number_format($valortotal, 2, ',', '.') . "</b>";
                                */ ?>
                                <input type="hidden" id="valor_total"
                                    value="<?php echo number_format($valortotal, 2, ',', '.') ?>" </div>
                            </div>-->


                            <br><br>
                        </div>
                    </center>
                </div>
            </form>
        </div>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<table id="example" class="table table-striped col-md-12" align="center"
    style="background-color:#fff;  max-width: 1700px; position: relative; padding:30px; border: solid 1px #dee2e6;">

    <thead>
        <tr>
            <th scope="col">Descrição</th>
            <th scope="col">Quantidade</th>
            <th scope="col">Valor unitário</th>
            <th scope="col">Valor</th>
            <th scope="col">Lote</th>
            <th scope="col">Validade</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <?php
    $material = entradaMaterialItem::consultar("SELECT * FROM material AS M JOIN entradamaterialitem AS E ON E.id_material = M.id 
                                                                WHERE E.id_entradamanterial = $idNota AND E.ativo = 1");
    ?>
    <tbody>
        <?php
        foreach ($material as $listarMaterial) {
        ?>
        <tr>
            <td><?php echo $listarMaterial['descricao']; ?></td>
            <td><?php echo $listarMaterial['quantidade']; ?></td>
            <td><?php echo "R$ " . $listarMaterial['valorunitario']; ?></td>
            <td><?php $total = $listarMaterial['valorunitario'] * $listarMaterial['quantidade'];
                    echo "R$ " . number_format($total, 2, ',', '.'); ?></td>
            <td><?php echo $listarMaterial['lote']; ?></td>

            <td><?php $val = $listarMaterial['validade'];
                    $validade_nova = explode('-', $val);
                    echo $validade_nova['2'] . "-" . $validade_nova['1'] . "-" . $validade_nova['0'] ?></td>
            <td>
                <a
                    href="controller/entrada_material_item_controller.php?deletar=true&id=<?php echo $listarMaterial['id']; ?>">
                    <button type="" class="btn btn-danger"> <i class="fas fa-trash-alt"></i>
                    </button></a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

</br></br>

<script>
$("#material").keyup(function() {
    var material = $("#material").val();

    $.ajax({
        url: 'ajax_material.php',
        type: 'POST',
        data: {
            id: material
        },
        beforeSend: function() {
            $("#material").html("carregando...");
        },
        success: function(data) {
            $("#item").html(data);
        }
    })
})
</script>

<script>
function sair() {
    var valor_total = $("#valor_total").val();

    Swal.fire({
        title: 'Deseja realmente finalizar a nota?',
        text: "O valor total de R$ " + valor_total + " confere com a nota?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'SIM!',
        cancelButtonText: 'CANCELAR!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'finalizar_entrada_nota.php';
        } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'danger')
        }
    })
}
</script>