<?php
session_start();

$pm_logado            = $_SESSION['UserRG'];
$opm_logado           = $_SESSION['UserOPM'];
$opm_logado = $_SESSION['UserOPM'];
if ($opm_logado <> 164) {/*se usuario nao for dabst distribuição, redireciona para outro arquivo*/
  header("Location: distribuir_material_opm.php");
}

if (!empty($_POST['rgretirada'])) {
  $_SESSION['rgretirada'] = str_replace('.', '', $_POST['rgretirada']);
}
/*se Não tiver RG, redireciona para pagina anterior*/
if (empty($_SESSION['rgretirada'])) {
  echo "<script>javascript:history.back(-1)</script>";
}
$LinksRoute = "./";
include './inc/links.php';
include 'library/configserver.php';
include 'library/consulsql.php';
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
      /*Envia seção selecionada por GET*/
      var t = document.getElementById("destino");
      var itemSelecionado = t.options[t.selectedIndex].value;

      window.location = "distribuir_material.php?opm=" + itemSelecionado;
    }

    function ValidaMat() {
      var e = document.getElementById("idmaterial");
      var itemSelecionado = e.options[e.selectedIndex].value;
      var retorno = itemSelecionado.split(";");
      document.getElementById('vl_ind').value = retorno[2];
      document.getElementById('add-campo').disabled = false;
    }

    var itens = 0;

    function habilitaEnviar() {
      itens++;
      span = document.getElementById("validaMat");
      if (itens >= 20) {
        document.getElementById('add-campo').disabled = true;
        span.innerHTML = "<div class='alert alert-danger' role='alert'> <b>Não é possivel incluir mais itens, favor gerar uma nova retirada.</b>";
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

  include 'inc/NavLateral.php';


  /*Se não tiver sessão é deslogado do sistema*/
  if ($_SESSION['UserRG'] == '') {
    header("Location: process/logout.php");
    exit();
  }

  if (!empty($_GET['opm'])) {/*Busca ultimos registros se tiver destino selecionado*/
    $separa     = explode(",", $_GET['opm']);
    $opm_select = $separa[0];
    $opm_desc   = $separa[1];

    $datainic = strftime('%Y-%m-%d', strtotime('-1 Month'));
    $datafim  = date("Y-m-d");
    /*Lista registros dos ultimos 30 dias*/
    $qrysaida = ejecutarSQL::consultar("SELECT * FROM saida s,material m, tabopm o WHERE s.data_saida BETWEEN '$datainic' and '$datafim' and destino='$opm_select' and s.id_material_saida=m.id and s.destino=o.cod_opm  order by id_saida desc");
  }
  /*Lista materiais do estoque*/

  $querymaterial  = ejecutarSQL::consultar("SELECT m.siga,m.descricao,m.id,e.vl_uni,e.qnt_atual,e.id_material,t.descr,e.id 
      FROM  material m,entrada e ,tipomaterial t 
      where e.id_material=m.id 
      and t.id = m.id_tipomaterial
      and status=3 
      and e.qnt_atual>0 and opm ='$opm_logado' $tipo");

  $_SESSION['msg'] = (mysqli_num_rows($querymaterial) < 1) ? '<div class="alert alert-danger text-center a"> <b>Nenhum Material Encontrado!</b>' : '';

  if (isset($_POST['enviar'])) {/*Insere distribuição na tabela saida e diminui estoque da unidade*/

    $ultsolicitacao = mysqli_fetch_array(ejecutarSQL::consultar("SELECT m60 FROM saida where opm='$opm_logado' and m60<>'ACERTO' order by id_saida desc limit 1"))[0];

    $partes = explode('/', $ultsolicitacao);

    $parte =  $partes[2] == date("Y") ? $partes[0] + 1 : '1';

    for ($count = 0; $count < count($_POST["idmaterial"]); $count++) {
      $rgretirada     = $_POST['rgretirada'];
      $destino        = $_POST['destino'];
      $separa         = explode(";", $_POST['idmaterial'][$count]);
      $idmaterial     = $separa[0];
      $id_entrada     = $separa[4];

      $est_ent       =  mysqli_fetch_array(ejecutarSQL::consultar("SELECT qnt_atual FROM entrada  where id_entrada='$id_entrada'"))[0];

      $vl_individual  = $_POST['vl_individual'][$count];
      $vl_total       = $_POST['vl_total'][$count];
      $qnt            = str_replace('.', '', $_POST['qnt'])[$count];
      $data_hoje      = date("Y-m-d");
      $numsol         = $parte . '/' . $opm_logado . '/' . date("Y");

      $tipo_doc       = $_POST['tipo_doc'][$count];
      $documento      = $_POST['documento'][$count];
      $dt_doc         = $_POST['dt_doc'][$count];

      if ($destino == '164') {
        $numsol = 'ACERTO';
      }

      $tabela = 'saida';
      $campos = "data_saida,id_material_saida,ult_estoque,qnt_saida,id_entrada,valor_individual,destino,val_total,documento,user_saida,m60,tipo_doc,dt_doc,rg_retirada,status,opm";
      $valores = "'$data_hoje','$idmaterial','$est_ent','$qnt','$id_entrada','$vl_individual','$destino','$vl_total','$documento','$pm_logado','$numsol','$tipo_doc','$dt_doc','$rgretirada',1,'$opm_logado'";

      $id_insert = consultasSQL::InsertSQL($tabela, $campos, $valores);

      $new_est_ent = $est_ent - $qnt;

      $tabela = 'entrada';
      $campos = "qnt_atual='$new_est_ent'";
      $condicion = "id_entrada='$id_entrada'";
      $id_insert = consultasSQL::UpdateSQL($tabela, $campos, $condicion);
    }
    if ($id_insert) {
      echo "<script type='text/javascript'>window.open('modelo60.php?id=" . $numsol . "','_blank');</script>";
    } else {
      $_SESSION['msg'] =  "<div class='alert alert-danger' role='alert'> <b>Falha ao cadastrar!!</b><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-labelhidden='true'>&times;</span> </button></div>";
      echo '<script type="text/javascript">retiramsg();</script>';
    }
    unset($_POST['enviar']);
  }
  ?>
  <div class="content-page-container full-reset custom-scroll-containers">
    <?php include 'inc/NavUserInfo.php'; ?>
    <div class="container">
      <div class="validaMat"></div>
      <div class="page-header">
        <h1 class="all-tittles">SisMatOdonto <small> Distribuiçao de Material</small></h1>
      </div>
    </div>

    <div class="container-fluid text-center" style="margin: 0px 0;">
      <img src="<?php echo "http://172.16.0.1/fotos/" . $_SESSION['rgretirada'] . ".bmp"; ?>" alt="foto PM" class="img-responsive img-rounded center-box" align="text-center" style="max-width:150px;">
      <strong>RG: <?php echo $_SESSION['rgretirada']; ?></strong>
    </div>
    <?php if (mysqli_num_rows($qrysaida) > 0) { ?>
      <div class="col-xs-12 col-sm-12 alert alert-warning text-center" role="alert">
        <button class="btn" data-toggle="modal" data-target="#modalExemplo" title="Clique para ver sa´das anteriores!" style="background-color:#FFFFFF;"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> &nbsp;
          <label><b> <?php echo "Saídas do dia  " . date("d-m", strtotime($datainic)) . "   ao  " . date("d-m", strtotime($datafim)); ?></b></label> </button>
      </div>
    <?php } ?>
    <br>
    <div class="container-fluid">
      <form method="post" action="distribuir_material.php">
        <span id="validaMat"></span>

        <div class="row text-center">

          <div class="col-xs-12 col-sm-2 col-sm-offset-1">
            <label>Destino</label>
            <div class="group-material">
              <select class="selectpicker form-control" data-size="10" data-live-search="true" name="destino" onchange="buscaOpm();" id="destino">
                <?php
                echo '<option value="' . $opm_select . '" >' . $opm_desc . '</option>';
                $queryopms = ejecutarSQL::consultar("SELECT cod_opm_novo,abrev_opm FROM opm where flag_opm is null order by abrev_opm asc ");
                while ($opms = mysqli_fetch_array($queryopms)) {
                  echo '<option value="' . $opms["cod_opm_novo"] . ',' . $opms["abrev_opm"] . '" >' . $opms["abrev_opm"] . '</option>';
                } ?>
              </select>
              <span id="valiMat"></span>
            </div>
          </div>
          <div class="col-xs-12 col-sm-2 col-sm-offset-1">
            <label>Tipo Documento</label>
            <div class="group-material ">
              <select class="selectpicker form-control " title="Selecione" id="tipo_doc" required>
                <option value="1">SEI </option>
                <option value="2">BOL PM </option>
                <option value="3">DETERMINAÇÃO</option>
              </select>
              <span id="valiMat"></span>
            </div>
          </div>

          <div class="col-xs-12 col-sm-2 ">
            <label>N. Documento</label>
            <div class="group-material">
              <input type="number" class="material-control text-center " data-placement="top" placeholder="Numero Documento" id="documento">
              <span id="valiMat"></span>
            </div>
          </div>

          <div class="col-xs-12 col-sm-2 col-sm-offset-1">
            <label>Data Documento</label>
            <div class="group-material">
              <input type="date" class="selectpicker form-control a" title="Data" id="dt_doc">
              <span id="valiMat"></span>
            </div>
          </div>

        </div>
        <div id="msg"><?php echo $_SESSION['msg'];
                      unset($_SESSION['msg']); ?></div>
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
                    <select class="selectpicker form-control show-tick " data-dropup-auto="false" data-live-search="true" title="Selecione o Material" id="idmaterial" onChange="javascript: ValidaMat();">
                      <?php
                      while ($material = mysqli_fetch_assoc($querymaterial)) {
                        echo '<option value="' . $material["id_material"] . ';' . $material["qnt_atual"] . ';' . $material["vl_uni"] . ';' . $material["descricao"] . ';' . $material["id_entrada"] . '"  data-subtext="&nbsp;&nbsp;/&nbsp;&nbsp;' . $material["qnt_atual"] . '">' . $material["siga"] . '/&nbsp;&nbsp;' . mb_strimwidth($material['descricao'], 0, 30, "...") . '&nbsp;&nbsp;/&nbsp;&nbsp;R$ : ' . $material["vl_uni"] . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                </td>
                <td>
                  <div class="group-material">
                    <input type="number" class="form-control text-center a" id="qnt" onKeyPress="javascript: Multiplica();" onblur="javascript: Multiplica();" data-placement="top" title="Quantidade">
                  </div>
                </td>
                <td>
                  <div class="group-material">
                    <input type="text" class="form-control text-center a " id="vl_ind" data-placement="top" title="Valor Unitário">
                  </div>
                </td>
                <td>
                  <div class="group-material">
                    <input type="text" class="form-control text-center a" id="vl_total" data-placement="top" title="Valor Total">
                  </div>
                </td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="8" style="text-align: left;">
                  <button class="btn btn-large btn-success" type="button" id="add-campo" onclick="javascript: habilitaEnviar();"><i class="glyphicon glyphicon-plus"></i>Incluir Item</button>
                </td>
              </tr>
            </tfoot>
          </table>
          <h3 class="all-tittles text-center">Itens a serem Retirados</h3>
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg- col-md-12 col-md-12  text-center">
              <div class="table-responsive">
                <div class="div-table">
                  <div class="div-table-row div-table-row-list " style="background-color:#DFF0D8; font-weight:bold;">
                    <div class="div-table-cell" style="width: 40%">
                      MATERIAL
                    </div>
                    <div class="div-table-cell" style="width: 10%">
                      Quantidade
                    </div>
                    <div class="div-table-cell" style="width: 10%">
                      Valor
                    </div>
                    <div class="div-table-cell" style="width: 10%">
                      Valor total
                    </div>
                    <div class="div-table-cell" style="width: 15%">
                      N° Documento
                    </div>
                    <div class="div-table-cell" style="width: 10%">
                      Data Doc.
                    </div>
                    <div class="div-table-cell" style="width: 5%">
                      <i class="glyphicon glyphicon-trash"></i>
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
            <button type="reset" class="btn btn-info" style="margin-right: 20px;"><i class="glyphicon glyphicon-erase"></i> &nbsp;&nbsp; Limpar</button>
            <button type="submit" name="enviar" id="btn_enviar" class="btn btn-primary" disabled><i class="glyphicon glyphicon-floppy-saved"></i> &nbsp;&nbsp; Salvar</button>
          </p>
        </div>
      </form>
    </div>

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="modalExemplo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title text-center">Saídas</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="saidas">
              <div class="table-responsive">
                <div class="div-table" style="margin:0 !important;">
                  <div class="div-table-row div-table-row-list" style="background-color:#DFF0D8; font-weight:bold;">
                    <div class="div-table-cell" style="width: 15%;">DATA</div>
                    <div class="div-table-cell" style="width: 5%;">DOC.</div>
                    <div class="div-table-cell" style="width: 30%;">DESCRIÇÃO</div>
                    <div class="div-table-cell" style="width: 10%;">QUANT</div>
                    <div class="div-table-cell" style="width: 10%;">LOGIN</div>
                    <div class="div-table-cell" style="width: 5%;">STATUS</div>
                    <div class="div-table-cell" style="width: 15%;">MOD60</div>
                  </div>
                </div>
              </div>
              <div class="table-responsive">
                <div style="height:200px;overflow-y:auto;">
                  <?php
                  while ($saidastotal = mysqli_fetch_assoc($qrysaida)) {
                    $style  = $saidastotal['status'] == 2 ? 'text-decoration: line-through;' : ''; ?>
                    <ul id="itemContainer" class="list-unstyled">
                      <li>
                        <div class="table-responsive">
                          <div class="div-table" style="margin:0 !important;<?php echo $style; ?>">
                            <div class="div-table-row div-table-row-list">
                              <div class="div-table-cell" style="width: 15%;"><b><?php echo date('d-m-Y', strtotime($saidastotal['data_saida'])); ?></b></div>
                              <div class="div-table-cell" style="width: 5%;"><b><?php echo $saidastotal['documento']; ?></b></div>
                              <div class="div-table-cell" style="width: 30%;" title="<?php echo $saidastotal['descricao']; ?>"><b><?php echo mb_strimwidth($saidastotal['descricao'], 0, 40, "..."); ?></b></div>
                              <div class="div-table-cell" style="width: 10%;"><b><?php echo $saidastotal['qnt_saida']; ?></b></div>
                              <div class="div-table-cell" style="width: 10%;"><b><?php echo $saidastotal['user_saida']; ?></b></div>
                              <div class="div-table-cell" style="width: 5%;">
                                <?php
                                if ($saidastotal['status'] == 1) { //Pendente de confirmaçao
                                  echo '<button class="btn  tooltips-general" title="Aguardando confirmaçao de recebimento da unidade de destino!" style="color:#FCC900"><i class="glyphicon glyphicon-exclamation-sign"></i></button>';
                                };
                                if ($saidastotal['status'] == 3) { //Confirmado
                                  echo '<button class="btn  tooltips-general" title="Confirmado recebimento por ' . $saidastotal['rg_status'] . '..." style="color:#298A08"><i class="glyphicon glyphicon-ok-sign"></i></button>';
                                };
                                ?>
                              </div>
                              <div class="div-table-cell " style="width: 10%;"><a href="modelo60.php?id=<?php echo $saidastotal['m60']; ?>" target="_blank"><button class="btn btn-primary  tooltips-general" type="button" title="<?php
                                                                                                                                                                                                                                    if ($saidastotal['status'] == 2) {
                                                                                                                                                                                                                                      echo 'Exclída por ' . $saidastotal['rg_status'] . '&nbsp;&nbsp;Obs:&nbsp;' . $saidastotal['obs'];
                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                    ?>"></><?php echo $saidastotal['m60']; ?></button></a></div>
                            </div>
                          </div>
                        </div>
                      </li>
                    </ul>
                    <div class="holder"></div>
                  <?php } ?>
                </div>
              </div>
            </div>


          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          </div>
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
    var tipo_doc = document.querySelector('#tipo_doc');
    var documento = document.querySelector('#documento');
    var dt_doc = document.querySelector('#dt_doc');
    var arr = [];

    $("#add-campo").click(function() {
      if (id.value == "" || qnt.value == "" || vl_total.value == "" || tipo_doc.value == "" || documento.value == "" || dt_doc.value == "") {
        span.innerHTML = "<div class='alert alert-danger text-center a' role='alert'> <b>Favor Preencher todos os campos!</b>";
      } else {
        var retorno = id.value.split(";");
        // if(arr.indexOf(retorno[0])==-1){//COMPARA SE ID JÁ FOI ADICIONADO ANTES
        //  arr.push(retorno[0]);//ARMAZENA ID JÁ SELECIONADOS NO COMBO

        $("#lista").append('<li> <div class="table-responsive"><div class="div-table" style="margin:0 !important;"> <div class="div-table-row div-table-row-list" > <div class="div-table-cell "  style="width: 40%"><input type="text" class="form-control text-center" value="' + retorno[3] + '"  id="desc" title="' + retorno[3] + '"><input class="form-control " type="hidden"  name="idmaterial[]" value="' + id.value + '"></div> <div class="div-table-cell" style="width: 10%" ><input  class="form-control text-center" value="' + qnt.value + '" name="qnt[]"  type="text"></div><div class="div-table-cell" style="width: 10%" ><input class="form-control text-center" value="' + vl_ind.value + '" name="vl_individual[]"  type="text"></div><div class="div-table-cell " style="width: 10%"><input class="form-control text-center" type="number"  value="' + vl_total.value + '"  name="vl_total[]" > </div><input class="form-control" value="' + tipo_doc.value + '" name="tipo_doc[]"  type="hidden" ><div class="div-table-cell" style="width: 15%"> <input type="text" class="form-control text-center"  value="' + documento.value + '" name="documento[]"></div><div class="div-table-cell" style="width: 10%"><input class="form-control text-center"   value="' + dt_doc.value + '" name="dt_doc[]"  type="text" ></div><div class="div-table-cell"   style="width: 5%;" ><button class="btn btn-large btn-danger" onclick="RemoveTableRow(this)" type="button"><i class="glyphicon glyphicon-trash"></i></button></div> </div>  </div> </div>  </li> ');

        id.value = '';
        vl_ind.value = '';
        vl_total.value = "";
        qnt.value = "";
        span.innerHTML = "";
        /*}else{
           span.innerHTML="<div class='alert alert-danger text-center a' role='alert'> <b>Esse item já foi selecionado!</b>";
        }  */
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