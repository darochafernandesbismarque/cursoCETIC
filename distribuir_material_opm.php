<?php
session_start();
$pm_logado           = $_SESSION['UserRG'];
$opm_logado          = $_SESSION['UserOPM'];

$LinksRoute = "./";

include './inc/links.php';
include 'library/configserver.php';
include 'library/consulsql.php';
//include 'class/materiais.class.php';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Distribuir</title>
    <script type="text/javascript" src="js/jquery-1.4.2.js"></script>
    <script type="text/javascript">
    function buscaOpm() {
        var t = document.getElementById("destino");
        var itemSelecionado = t.options[t.selectedIndex].value;

        window.location = "distribuir_material_opm.php?opm=" + itemSelecionado;
    }

    function ValidaMat() {
        var e = document.getElementById("idmaterial");
        var itemSelecionado = e.options[e.selectedIndex].value;
        var retorno = itemSelecionado.split(";");
        document.getElementById('vl_ind').value = retorno[2];
        document.getElementById('qnt').placeholder = 'Disponível : ' + retorno[1];
        document.getElementById('add-campo').disabled = false;
    }

    var itens = 0;

    function habilitaEnviar() {
        itens++;
        span = document.getElementById("validaMat");
        if (itens >= 20) {
            document.getElementById('add-campo').disabled = true;
            span.innerHTML =
                "<div class='alert alert-danger' role='alert'> <b>Não é possivel incluir mais itens, favor gerar uma nova retirada.</b>";
        }

        var idmaterial = document.getElementById("idmaterial");
        if (idmaterial.value) {
            btn_enviar.disabled = false;
        }
    }

    function retiramsg() {
        setTimeout(function() {
            $("#msg").slideUp('slow', function() {});
        }, 2500);
    }

    function Multiplica() {
        var vl_uni = document.getElementById("vl_ind").value;
        var qnt = document.getElementById("qnt").value;
        x = vl_uni * qnt;

        document.getElementById('vl_total').value = x.toFixed(2);
    }
    </script>
</head>

<body>
<?php
  include_once 'library/configserver.php';
  include_once 'library/Consulta.php';
  include_once 'library/consulsql.php';
  include_once 'library/material.php';
  include_once 'library/tipomaterial.php';
  include_once 'library/saida.php';
  include_once 'library/usuario.php';
  include_once 'library/pedido.php';
  include_once 'library/opm.php';
  include_once 'class/materiais.class.php';
  include_once 'class/dados.class.php';
  include      'inc/NavLateral.php';

  /*Se não tiver sessão é deslogado do sistema*/
  if ($_SESSION['UserRG'] == '') {
    header("Location: process/logout.php");
    exit();
  }

  if (!empty($_GET['opm'])) {
    $separa     = explode(",", $_GET['opm']);
    $opm_select = $separa[0];
    $opm_desc   = $separa[1];
  }
  /*Lista materiais do estoque*/
  /*$querymaterial  = Materiais::listaMaterialOpm($opm_logado);
  $_SESSION['msg'] = (mysqli_num_rows($querymaterial) < 1) ? '<div class="alert alert-danger text-center a"> <b>Nenhum Material Encontrado!</b>' : '';
  /*Insere consumo na tabela saida e diminui estoque da unidade*/
  if (isset($_POST['enviar'])) {

    $dados = $_POST;

    $inserir = material::consumoMaterial($dados);

    //if ($numsol = Materiais::consumoMaterial($dados)) {
      //$_SESSION['msg'] =  "<div class='alert alert-success' role='alert'> <b>Consumo registrado com sucesso!!</b><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-labelhidden='true'>&times;</span> </button></div>";
       //echo '<script type="text/javascript">retiramsg();</script>';
       //echo "<script type='text/javascript'>window.open('modelo60Opm.php?id=".$numsol."','_blank');</script>"; 
    //} else {
      //$_SESSION['msg'] =  "<div class='alert alert-danger' role='alert'> <b>Falha ao registrar consumo!!</b><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-labelhidden='true'>&times;</span> </button></div>";
      //echo '<script type="text/javascript">retiramsg();</script>';
    //}
    unset($_POST['enviar']);
  }
  ?>
    <div class="content-page-container full-reset custom-scroll-containers">
        <?php include 'inc/NavUserInfo.php'; ?>
        <div class="container">
            <div class="validaMat"></div>
            <div class="page-header">
                <h1 class="all-tittles">Sistema de Abastecimento <small> Distribuiçao de Material</small></h1>
            </div>
        </div>

        <br>
        <div class="container-fluid">
            <form method="post" action="distribuir_material_opm.php">
                <span id="validaMat"></span>

                <div class="row text-center">
                    <div class="col-xs-12 col-sm-2 col-sm-offset-5">
                        <label>Tipo de Saída de Material</label>
                        <div class="group-material">
                            <select class="selectpicker form-control" data-size="10" data-live-search="true"
                                name="destino" id="destino" required>
                                <option value="503">CONSUMO INTERNO</option>
                                <option value="504">INSERVÍVEL</option>
                                <option value="505">ACIDENTE</option>
                                <option value="505">TRANSFERÊNCIA PARA OUTRA USB</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="products-table" class="table table-hover table-bordered">
                        <tbody id="tabela">
                                  <tr>
                                <th class="text-center" style="width: 45%;">Siga/Descrição/Valor/Estoque</th>
                                <th>Quantidade</th>
                                <th>Valor</th>
                                <th>Valor total</th>
                            </tr>
                            <tr>
                                <td>
                                    <div class="group-material">
                                        <select class="selectpicker form-control show-tick " data-dropup-auto="false"
                                            data-live-search="true" title="Selecione o Material" id="idmaterial"
                                            onChange="javascript: ValidaMat();">
<?php
$materiais = material::consultar("SELECT * FROM entrada AS E JOIN material AS M ON E.id_material = M.id");

foreach($materiais as $m){
echo '<option value="' . $m["id_material"] . ';' . $m["qnt_atual"] . ';' . $m["vl_uni"] . ';' . $m["descricao"] 
. ';' . $m["id_entrada"] . '">' . $m["siga"] . '/&nbsp;&nbsp;' . mb_strimwidth($m['descricao'], 0, 30, "...") 
. '&nbsp;&nbsp;/&nbsp;&nbsp;R$ : ' . $m["vl_uni"] . '&nbsp;&nbsp;/&nbsp;&nbsp;' . $m["qnt_atual"] . '</option>';
}

?>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="group-material">
                                        <input type="number" onkeypress="return event.charCode >= 48" min="1"
                                            class="form-control text-center a" id="qnt"
                                            onKeyPress="javascript: Multiplica();" onblur="javascript: Multiplica();"
                                            data-placement="top" title="Quantidade">
                                    </div>
                                </td>
                                <td>
                                    <div class="group-material">
                                        <input type="text" class="form-control text-center a " id="vl_ind"
                                            data-placement="top" title="Valor Unitário">
                                    </div>
                                </td>
                                <td>
                                    <div class="group-material">
                                        <input type="text" class="form-control text-center a" id="vl_total"
                                            data-placement="top" title="Valor Total">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8" style="text-align: left;">
                                    <button class="btn btn-large btn-success" type="button" id="add-campo"
                                        onclick="javascript: habilitaEnviar();"><i
                                            class="glyphicon glyphicon-plus"></i>Incluir Item</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <h3 class="all-tittles text-center">Itens a serem Retirados</h3>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="col-lg- col-md-12 col-md-12  text-center">
                            <div class="table-responsive">
                                <div class="div-table">
                                    <div class="div-table-row div-table-row-list "
                                        style="background-color:#DFF0D8; font-weight:bold;">
                                        <div class="div-table-cell" style="width: 40%">
                                            MATERIAL
                                        </div>
                                        <div class="div-table-cell" style="width: 10%">
                                            Quantidade
                                        </div>
                                        <div class="div-table-cell" style="width: 20%">
                                            Valor
                                        </div>
                                        <div class="div-table-cell" style="width: 20%">
                                            Valor total
                                        </div>
                                        <!--<div class="div-table-cell" style="width: 15%"> 
                      Tipo de Doc.
                    </div>-->
                                        <div class="div-table-cell" style="width: 10%">
                                            Remover
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <ul id="itemContainer" class="list-unstyled">
                                        <div id="lista" class="text-center"></div>
                                    </ul>
                                    <div class="holder"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br><br><br>
                <div class="full-reset representative-resul">
                    <input type="hidden" name="rgretirada" value="<?php echo $_SESSION['rgretirada']; ?>">
                    <p class="text-center">
                        <button type="reset" class="btn btn-light" style="margin-right: 20px;"><i
                                class="glyphicon glyphicon-erase"></i> &nbsp;&nbsp; Limpar</button>
                        <button type="submit" name="enviar" id="btn_enviar" class="btn btn-success" disabled><i
                                class="glyphicon glyphicon-floppy-saved"></i> &nbsp;&nbsp; Salvar</button>
                    </p>
                </div>
            </form>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="cad-secao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title text-center a" id="exampleModalLabel">Cadastrar Seção</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid text-center">
                            <form method="post" action="receber_material.php">
                                <div class="col-xs-12 col-sm-4">
                                    <label>Nome da Seção</label>
                                </div>
                                <div class="col-xs-12 col-sm-12 ">
                                    <div class="group-material">
                                        <input type="text" class="material-control tooltips-general a" name="nome"
                                            data-toggle="tooltip" data-placement="top" title="Fornecedor" required>
                                        <span class="bar"></span>
                                    </div>
                                </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="reset" class="btn btn-info"><i class="glyphicon glyphicon-erase"></i> &nbsp;&nbsp;
                            Limpar</button>
                        <button type="submit" class="btn btn-primary" name="cadfornecedor"><i
                                class="glyphicon glyphicon-floppy-saved"></i> &nbsp;&nbsp; Salvar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <script>
    var id = document.querySelector('#idmaterial');
    var qnt = document.querySelector('#qnt');
    var vl_ind = document.querySelector('#vl_ind');
    var vl_total = document.querySelector('#vl_total');
    var arr = [];



    $("#add-campo").click(function() {
        if (id.value == "" || qnt.value == "" || vl_total.value == "") {
            span.innerHTML =
                "<div class='alert alert-danger text-center a' role='alert'> <b>Favor Preencher todos os campos!</b>";
        } else {
            var retorno = id.value.split(";");
            // if(arr.indexOf(retorno[0])==-1){//COMPARA SE ID JÁ FOI ADICIONADO ANTES
            //arr.push(retorno[0]);//ARMAZENA ID JÁ SELECIONADOS NO COMBO

            $("#lista").append(
                ' <li> <div class="table-responsive"> <div class="div-table" style="margin:0 !important;"> <div class="div-table-row div-table-row-list" > <div class="div-table-cell "  style="width: 40%"><input type="text" class="form-control text-center" value="' +
                retorno[3] + '"  id="desc" title="' + retorno[3] +
                '"><input class="form-control " type="hidden"  name="idmaterial[]" value="' + id.value +
                '" ></div> <div class="div-table-cell" style="width: 10%" ><input  class="form-control text-center" value="' +
                qnt.value + '" type="number" name="qnt[]" max="' + retorno[1] +
                '" onblur="javascript: Multiplica2();" ></div><div class="div-table-cell" style="width: 20%" ><input class="form-control text-center" value="' +
                vl_ind.value +
                '" name="vl_individual[]"  type="text"></div><div class="div-table-cell " style="width: 20%"><input class="form-control text-center" type="number"  value="' +
                vl_total.value +
                '"  name="vl_total[]" > </div><div class="div-table-cell"   style="width: 10%;" ><button class="btn btn-large btn-danger" onclick="RemoveTableRow(this)" type="button"><i class="glyphicon glyphicon-trash"></i></button></div> </div>  </div> </div>  </li> '
            );

            id.value = '';
            vl_ind.value = '';
            vl_total.value = "";
            qnt.value = "";
            span.innerHTML = "";
        }
    });

    RemoveTableRow = function(handler) {
        itens--;
        span.innerHTML = "";
        document.getElementById('add-campo').disabled = false;
        var tr = $(handler).closest('li');
        tr.fadeOut(400, function() {
            tr.remove();
        });
        return false;
    };
    </script>

    <style>
    select {
        font: 15px arial, sans-serif;
    }
    </style>

</body>

</html>