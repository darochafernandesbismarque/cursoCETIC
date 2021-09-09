<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SisAb - RELATÓRIOS</title>

  <script type="text/javascript" src="js/jscript.js"></script>
  <script type="text/javascript" src="js/jquery-1.4.2.js"></script>

  <?php
  session_start();

  $LinksRoute = "./";
  include './inc/links.php';
  $opm_logado       = $_SESSION['UserOPM'];
  if ($opm_logado <> 164) {/*se usuario nao for dabst distribuição, redireciona para outro arquivo*/
    header("Location: dashboard0pm.php");
  }
  ?>
</head>

<body>
  <script src="Highcharts/code/highcharts.js"></script>
  <script src="Highcharts/code/modules/exporting.js"></script>
  <script src="Highcharts/code/modules/export-data.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

  <?php

  include 'library/configserver.php';
  include 'library/consulsql.php';
  /*Se não tiver sessão é deslogado do sistema*/
  if ($_SESSION['UserRG'] == '') {
    header("Location: process/logout.php");
    exit();
  }
  /*Cria condição para lista de um material especifico*/
  if ($_GET['id']) {
    $id_material_consulta   = $_GET['id'];
    $idMaterialEntrada       = 'and id_material=' . $id_material_consulta;
    $idMaterialSaida          = 'and id_material_saida=' . $id_material_consulta;
    $idget                    = '?id=' . $id_material_consulta;
  } else {
    $idMaterialEntrada       = '';
    $idMaterialSaida         = '';
    $id_material_consulta   = '';
  }

  //Excluyi uma entarda de Material reduzindo do estoque
  if (isset($_POST['excluir'])) {
    $id_material  = $_POST['idmat'];
    $identrada    = $_POST['identrada'];
    $qnt          = $_POST['qnt'];
    $date_now     = date('d-m-Y H:i:s');
    $obs          = ' em ' . $date_now . ', Obs: ' . strtoupper($_POST['obs']);

    $rguser =  $_SESSION['UserRG'];
    /*
      $estoque    = mysqli_fetch_array(ejecutarSQL::consultar("SELECT qnt_atual FROM entrada  
            where id_entrada='$identrada'"))[0];

      $qntfinal   = $estoque - $qnt;
*/
    $tabela     = "entrada";
    $campos     = "status='2',rg_status='$rguser',obs='$obs'";
    $condicion  = "id_entrada='$identrada'";
    $retorno2     = consultasSQL::UpdateSQL($tabela, $campos, $condicion);
  }

  include 'inc/NavLateral.php';
  ?>
  <script type="text/javascript">
    function excluir(id, idmat, qnt) {
      $("#identrada").val(id);
      $("#idmat").val(idmat);
      $("#qnt").val(qnt);
      $('#excluir').modal('show');
    }
  </script>
  <div class="content-page-container full-reset custom-scroll-containers">
    <?php
    include 'inc/NavUserInfo.php';
    $qntsaida      = 0;
    $qntentrada    = 0;
    /*Filtro de movimentões a serem exibidas  */
    if (isset($_POST['enviar'])) {

      $datainic = !empty($_POST['dt_inic']) ? $_POST['dt_inic'] : strftime('%Y-%m-%d', strtotime('-1 Month'));
      $datafim  = !empty($_POST['dt_fim']) ? $_POST['dt_fim'] : date("Y-m-d");

      $destino  = explode(",", $_POST['destino'])[0] == "A10" ? '' : 'and destino=' . explode(",", $_POST['destino'])[0];

      $destino_desc  = explode(",", $_POST['destino'])[0] == "A10" ? '' : ', ' . explode(",", $_POST['destino'])[1];

      $fornecedor = empty(explode(",", $_POST['fornecedor'])[0]) ? '' : 'and id_fornecedor=' . explode(",", $_POST['fornecedor'])[0];

      $fornecedor_desc = empty(explode(",", $_POST['fornecedor'])[0]) ? '' : ', ' . explode(",", $_POST['fornecedor'])[1];

      $tipoverba  = empty($_POST['tipoverba']) ? '' : 'and tipo_verba=' . $_POST['tipoverba'];

      $idMaterialSaida =  empty($_POST['idmaterial']) ? '' : 'and id_material_saida=' . $_POST['idmaterial'];
      $idMaterialEntrada =  empty($_POST['idmaterial']) ? '' : 'and id_material=' . $_POST['idmaterial'];
      $id_material_consulta = empty($_POST['idmaterial']) ? '' : $_POST['idmaterial'];
      $origem   = $opm_logado;
    } else {
      $datainic = strftime('%Y-%m-%d', strtotime('-15 days'));
      $datafim   = date("Y-m-d");
      $destino  = '';
      $origem   = $opm_logado;
    }
    /*Lista as entradas de acordo com os filtros*/
    $qryentrada = "SELECT m.descricao,qnt,qnt_atual,data,f.descricao as fornecedor,vl_uni,vl_total,nf,status,rg_status,obs,user, e.id,id_material,validade FROM entrada e,material m,fornecedor f WHERE data BETWEEN '$datainic' AND '$datafim' $idMaterialEntrada  $fornecedor $tipoverba and e.id_material=m.id and opm='$opm_logado' and id_fornecedor=f.id  order by e.id desc";

    $_SESSION['qryentrada'] = $qryentrada;

    $queryentrada = ejecutarSQL::consultar($qryentrada);

    if ($id_material_consulta != '') {
      $querydesc = ejecutarSQL::consultar("SELECT descricao FROM material WHERE id='$id_material_consulta' ");
      $desc     = mysqli_fetch_assoc($querydesc);
    }

    /*Lista pedidos de acordo com os filtros*/
    $qrypedidos = "SELECT * FROM pedido s,material m, tabopm o, tipodoc t WHERE data_pedidos BETWEEN '$datainic' AND '$datafim' and opm='$origem' and status<>3 $destino  $idMaterialSaida and s.id_material_saida=m.id and s.destino=o.cod_opm and t.id=s.tipo_doc order by s.id_pedido desc";

    $querypedidos       = ejecutarSQL::consultar($qrypedidos);

    /*Lista saidas de acordo com os filtros*/
    $qrysaida = "SELECT * FROM saida s,material m, tabopm o, tipodoc t WHERE data_saida BETWEEN '$datainic' AND '$datafim' and opm='$origem' $destino  $idMaterialSaida and s.id_material_saida=m.id and s.destino=o.cod_opm and t.id=s.tipo_doc order by id_saida desc";

    $qrysaidaxls = "SELECT * FROM saida s,material m, tabopm o WHERE data_saida BETWEEN '$datainic' AND '$datafim' and opm='$origem' $destino  $idMaterialSaida and s.id_material_saida=m.id and status<>2 and s.destino=o.cod_opm  order by id_saida desc";
    $_SESSION['qrysaida'] = $qrysaidaxls;

    $querysaida       = ejecutarSQL::consultar($qrysaida);


    if ($id_material_consulta != '') {
      $estoque    = mysqli_fetch_array(ejecutarSQL::consultar("SELECT sum(e.qnt_atual)as estoque 
            FROM  entrada e  
            where id_material='$id_material_consulta'"))[0];
      $_SESSION['qntestoque'] = $estoque;
    }
    /*Soma todas entradas de acordo com filtro aplicado*/
    if ($contador       = mysqli_fetch_array(ejecutarSQL::consultar("SELECT sum(e.qnt) FROM entrada e,material m WHERE data BETWEEN '$datainic' AND '$datafim' $idMaterialEntrada and e.id_material=m.id and opm='$opm_logado' and status<>2"))) {
      $qntentrada    = $contador[0];
      $_SESSION['qntentrada'] = $qntentrada;
    }

    /*Soma todas saidas de acordo com filtro aplicado*/
    if ($contador2      = mysqli_fetch_array(ejecutarSQL::consultar("SELECT sum(qnt_saida) FROM  saida s, material m WHERE data_saida BETWEEN '$datainic' AND '$datafim' and status<>2 and s.id_material_saida=m.id $destino $idMaterialSaida"))[0]) {
      $qntsaida        = $contador2;
      $_SESSION['qntsaida'] = $qntsaida;
    }

    include 'library/conexao.php';

    $qrygrafico = "SELECT sum(s.qnt_saida) as total, s.destino,o.abrev_opm FROM  saida as s,tabopm as o, material m WHERE s.destino in (SELECT destino FROM  saida ) and data_saida BETWEEN '$datainic' AND '$datafim' $destino  $idMaterialSaida  and s.destino=o.cod_opm and s.id_material_saida=m.id and s.status<>2 group by s.destino";

    $queryopms  = ejecutarSQL::consultar("SELECT cod_opm,abrev_opm FROM opm where is_odonto=1 order by abrev_opm desc");
    ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"> </script>
    <script type="text/javascript">
      /*Gera grafico de pizza*/
      google.charts.load('current', {
        'packages': ['corechart']
      });
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Unidade', 'Quantidade'],
          <?php
          $result = ejecutarSQL::consultar($qrygrafico);
          while ($dado = mysqli_fetch_assoc($result)) {
            echo "['" . $dado['abrev_opm'] . "'," . $dado['total'] . "],";
          } ?>
        ]);

        var options = {
          title: 'DISTRIBUIÇÃO de : <?php echo mb_strimwidth($desc["descricao"], 0, 35, "..."); ?>'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>

    <script type="text/javascript">
      /*Gera grafico de linhas*/
      google.charts.load('current', {
        packages: ['corechart', 'line']
      });
      google.charts.setOnLoadCallback(drawLineColors);

      function drawLineColors() {
        var data = new google.visualization.DataTable();
        data.addColumn('number', 'X');
        data.addColumn('number', '');

        data.addRows([
          <?php
          $result = ejecutarSQL::consultar($qrygrafico);
          $i = 1;
          while ($dado = mysqli_fetch_assoc($result)) {

            echo "[" . $i . "," . $dado['total'] . "],";
            $i++;
          } ?>
        ]);

        var options = {
          hAxis: {
            title: ''
          },
          vAxis: {
            title: 'Quantidades Saídas'
          },
          colors: ['#a52714']
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>

    <div class="container">
      <div class="page-header">
        <h1 class="all-tittles">Movimentação de Materiais <small>
            <?php echo mb_strimwidth($desc['descricao'], 0, 30, "..."); ?></small></h1>
      </div>
    </div>
    <!-- DIV DO FILTRO -->
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center " id="filtros">
      <div class="container-fluid">

        <div class="row ">
          <form method="post" action="<?php echo $idget; ?>">
            <div class="col-xs-12 col-sm-2">
              <label>Data Inicio</label>
              <div class="group-material">
                <input type="date" class="form-control" name="dt_inic" maxlength="80" data-toggle="tooltip" data-placement="top" title="Material">
              </div>
            </div>
            <div class="col-xs-12 col-sm-2">
              <label>Data Fim</label>
              <div class="group-material">
                <input type="date" class="form-control" name="dt_fim" id="lote" data-toggle="tooltip" data-placement="top" title="Material">
              </div>
            </div>

            <div class="col-xs-12 col-sm-1">
              <label>Tipo Verba</label>
              <div class="group-material">
                <select class="selectpicker form-control" name="tipoverba">
                  <option value="">TODOS</option>
                  <option value="1">Aquisiçao SEPM</option>
                  <option value="2">Doação</option>
                  <option value="3">Transferência Financeira</option>
                  <option value="4">Adiantamento Financeiro</option>
                </select>
              </div>
            </div>

            <div class="col-xs-12 col-sm-2">
              <label>Fornecedor</label>
              <div class="group-material">
                <select class=" selectpicker form-control" data-live-search="true" name="fornecedor">
                  <option value="">TODOS</option>
                  <?php
                  $queryforn = ejecutarSQL::consultar("SELECT * FROM fornecedor");
                  while ($forn = mysqli_fetch_array($queryforn)) {
                    echo '<option value="' . $forn["id"] . ',' . mb_strimwidth($forn["descricao"], 0, 10, "...") . '">' . $forn["descricao"] . '</option>';
                  } ?>
                </select>
              </div>
            </div>

            <div class="col-xs-12 col-sm-1">
              <label>DESTINO</label>
              <div class="group-material">
                <select class="selectpicker form-control" data-size="20" data-live-search="true" name="destino" required>
                  <option value="A10">TODAS</option>
                  <?php while ($opms  = mysqli_fetch_array($queryopms)) {
                    echo '<option value="' . $opms["cod_opm"] . ',' . $opms["abrev_opm"] . '">' . $opms["abrev_opm"] . '</option>';
                  } ?>
                </select>
              </div>
            </div>
            <div class="col-xs-12 col-sm-3">
              <label>Material</label>
              <div class="group-material">
                <select class="selectpicker form-control" data-size="20" data-live-search="true" name="idmaterial" id="idmaterial" onChange="javascript: ValidaMat();">
                  <option value="">&nbsp;&nbsp; - -TODOS- - </option>
                  <?php $querymaterial  = ejecutarSQL::consultar("SELECT * FROM material  order by descricao asc");
                  while ($material = mysqli_fetch_assoc($querymaterial)) {
                    echo '<option value="' . $material["id"] . '"> ' . mb_strimwidth($material['descricao'], 0, 60, "...") . '</option>';
                  } ?>
                </select>
              </div>
            </div>
            <div class="col-xs-12 col-sm-1 text-center">
              <button type="submit" class="btn btn-primary" name="enviar"><i class="glyphicon glyphicon-filter"></i></button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- FIM DIV DO FILTRO -->
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
      <p>
        <a class="btn btn-primary " data-toggle="collapse" href="#saidas" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">&nbsp;&nbsp;<b>RESERVAS</b></a>
        <a class="btn btn-primary " data-toggle="collapse" href="#pedidos" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">&nbsp;&nbsp;<b>SAÍDAS</b></a>
        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#entradas" aria-expanded="false"><i class="zmdi zmdi-square-right zmdi-hc-fw"></i>&nbsp;&nbsp;<b>ENTRADAS</b></button>
        <a class="btn btn-danger " data-toggle="collapse" href="#saidas-excluidas" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">&nbsp;&nbsp;<b>MATERIAIS Á VENCER</a>
        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#graficos" aria-expanded="false" aria-controls="multiCollapseExample2" <?php if (!$id_material_consulta) {
                                                                                                                                                                    echo "disabled";
                                                                                                                                                                  } ?>>&nbsp;&nbsp;<b>GRÁFICOS</b></button>
        <?php if ($id_material_consulta) {
          echo '<a href="gerar-planilha-mod40.php' . $idget . '" ><img title="Gerar Modelo 40" src="assets/icons/excel.jpg" width="50" height="35" ></a>';
        } ?>

      </p>
    </div>
    <!--LEGENDA DE STATUS-->
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
      <button class="btn" title="Estoque Disponível" style="color:#298A08"><i class="glyphicon glyphicon-ok-sign"></i></button>&nbsp;Confirmado Recebimento&nbsp;&nbsp;
      <button class="btn" title="Estoque Mínimo" style="color:#FCC900"><i class="glyphicon glyphicon-exclamation-sign"></i></button>&nbsp;Pendente Confirmação&nbsp;&nbsp;
      <button class="btn" title="Estoque indisponível" style="color:#FF0000"><i class="glyphicon glyphicon-remove-sign"></i></button>&nbsp;Excluído
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
      <div class="col-md-8 col-md-offset-2  collapse multi-collapse" id="saidas-excluidas">
        <h1 class="all-tittles"><small>MATERIAIS Á VENCER EM 15 DIAS </small></h1>
        <div class="table-responsive">
          <div class="div-table" style="margin:0 !important;">
            <div class="div-table-row div-table-row-list" style="background-color:#DFF0D8; font-weight:bold;">
              <div class="div-table-cell" style="width: 20%;">DATA ENTRADA</div>
              <div class="div-table-cell" style="width: 40%;">MATERIAL</div>
              <div class="div-table-cell" style="width: 10%;">QUANTIDADE</div>
              <div class="div-table-cell" style="width: 20%;">VENCIMENTO</div>
            </div>
          </div>
          <div style="max-height: 250px">
            <?php
            /*Lista materiais com validade em até 15 dias*/
            $qrysaida2 = "SELECT m.descricao,qnt,data,f.descricao as fornecedor,nf,status, validade FROM entrada e, material m, fornecedor f WHERE validade BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 15 DAY) and e.id_material=m.id and opm='$opm_logado' and id_fornecedor=f.id  order by e.validade desc";
            $querysaida2    = ejecutarSQL::consultar($qrysaida2);
            if (mysqli_num_rows($querysaida2) >= 1) {
              $total = 0;
              while ($saidastotal2 = mysqli_fetch_assoc($querysaida2)) {
            ?>
                <ul id="itemContainer" class="list-unstyled">
                  <li>
                    <div class="table-responsive">
                      <div class="div-table" style="margin:0 !important;">
                        <div class="div-table-row div-table-row-list">
                          <div class="div-table-cell" style="width: 20%;"><?php echo date('d-m-Y', strtotime($saidastotal2['data'])); ?></div>
                          <div class="div-table-cell" style="width: 40%;"><?php echo $saidastotal2['descricao']; ?></div>
                          <div class="div-table-cell" style="width: 10%;"><?php echo $saidastotal2['qnt']; ?></div>
                          <div class="div-table-cell" style="width: 20%; color: red;"><?php echo date('d-m-Y', strtotime($saidastotal2['validade'])); ?></div>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
                <div class="holder"></div>
            <?php }
            } else {
              echo '<h2 class="text-center all-tittles">Não há registros</h2>';
            } ?>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
      <br>
      <button class="btn" data-toggle="collapse" data-target="#filtros" title="Filtros" style="background-color:#FFFFFF;"><i class="glyphicon glyphicon-filter"></i> &nbsp;
        <label class="a"> <?php echo "Pesquisa do dia  " . date("d-m", strtotime($datainic)) . "   ao  " . date("d-m", strtotime($datafim)) . '  ' . $destino_desc . ' ' . $fornecedor_desc; ?></label> </button>
    </div>
    <div>
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  collapse multi-collapse text-center" id="entradas">
        <h1 class="all-tittles"><small>ENTRADAS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "Total : " . $qntentrada; ?></small></h1>
        <div class="div-table" style="margin:0 !important;">
          <div class="div-table-row div-table-row-list" style="background-color:#DFF0D8; font-weight:bold;">
            <div class="div-table-cell" style="width: 7%;">DATA</div>
            <div class="div-table-cell" style="width: 25%;">DESCRIÇÃO</div>
            <div class="div-table-cell" style="width: 4%;">ENT</div>
            <div class="div-table-cell" style="width: 4%;">ATUAL</div>
            <div class="div-table-cell" style="width: 8%;">VALIDADE</div>
            <div class="div-table-cell" style="width: 7%;">VL IND</div>
            <div class="div-table-cell" style="width: 7%;">VL TOTAL</div>
            <div class="div-table-cell" style="width: 8%;">DOC.</div>
            <div class="div-table-cell" style="width: 8%;">FORNECEDOR</div>
            <div class="div-table-cell" style="width: 5%;">LOGIN</div>
            <div class="div-table-cell" style="width: 7%;">STATUS</div>
          </div>
        </div>

        <div class="table-responsive">
          <div style="height: 400px;">
            <?php
            if (mysqli_num_rows($queryentrada) >= 1) {
              while ($entradadadostotal = mysqli_fetch_assoc($queryentrada)) {
                $style  = $entradadadostotal['status'] == 2 ? 'text-decoration: line-through;' : ''; ?>
                <ul id="itemContainer" class="list-unstyled">
                  <li>
                    <div class="table-responsive">
                      <div class="div-table" style="margin:0 !important;<?php echo $style; ?>">
                        <div class="div-table-row div-table-row-list">
                          <div class="div-table-cell" style="width: 7%;"><?php echo date('d-m-Y', strtotime($entradadadostotal['data'])); ?></div>
                          <div class="div-table-cell" style="width: 25%;" title="<?php echo $entradadadostotal['descricao']; ?>"><?php echo mb_strimwidth($entradadadostotal['descricao'], 0, 40, "..."); ?></div>
                          <div class="div-table-cell" style="width: 4%;"><?php echo $entradadadostotal['qnt']; ?></div>
                          <div class="div-table-cell" style="width: 4%;"><?php echo $entradadadostotal['qnt_atual']; ?></div>
                          <div class="div-table-cell" style="width: 8%;"><?php
                                                                          $validade = $entradadadostotal['validade'] == '0000-00-00' ? 'Não Inf.' : date('d-m-Y', strtotime($entradadadostotal['validade']));
                                                                          echo $validade; ?></div>
                          <div class="div-table-cell" style="width: 7%;"><?php echo $entradadadostotal['vl_uni']; ?></div>
                          <div class="div-table-cell" style="width: 7%;"><?php echo $entradadadostotal['vl_total']; ?></div>
                          <div class="div-table-cell tooltips-general" style="width: 8%;"><?php echo $entradadadostotal['nf']; ?></div>
                          <div class="div-table-cell tooltips-general" title="<?php echo $entradadadostotal['fornecedor']; ?>" style="width: 8%;"><?php echo mb_strimwidth($entradadadostotal['fornecedor'], 0, 13, ".."); ?></div>
                          <div class="div-table-cell" style="width: 5%;"><?php echo $entradadadostotal['user']; ?></div>
                          <div class="div-table-cell" style="width: 5%;">
                            <?php if ($entradadadostotal['status'] == 2) {
                              echo '<button class="btn  tooltips-general" title="Exclída por ' . $entradadadostotal['rg_status'] . ' ' . $entradadadostotal['obs'] . '  Nº ' . $entradadadostotal['id_entrada'] . '" style="color:#FF0000"><i class="glyphicon glyphicon-remove-sign"></i></button>';
                            };
                            if ($entradadadostotal['status'] == 1) {
                              echo '<button class="btn" title="" style="color:#FCC900"><i class="glyphicon glyphicon-exclamation-sign"></i></button>';
                            };
                            if ($entradadadostotal['status'] == 3) {
                              $mod = 'title="Esse registro não pode ser excluído pois já teve retirada!"';
                              if ($entradadadostotal['qnt'] == $entradadadostotal['qnt_atual']) {
                                $mod = 'data-target="#excluir" title="Clique se deseja Excluír."';
                              }
                              echo '<button class="btn  tooltips-general"  style="color:#298A08" data-toggle="modal"' . $mod . '   onclick="excluir(' . $entradadadostotal['id_entrada'] . ',' . $entradadadostotal['id_material'] . ',' . $entradadadostotal['qnt'] . ')"><i class="glyphicon glyphicon-ok-sign"></i></button>';
                            };
                            ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
                <div class="holder"></div>
            <?php }
            } else {
              echo '<h2 class="text-center all-tittles">Não há registros de entradas no Sistema</h2>';
            } ?>
            <div class="div-table-row div-table-row-list" style="background-color:#DFF0D8; font-weight:bold;">
              <?php if ($estoque) { ?>
                <div class="div-table-cell" style="width: 30%;">&nbsp;&nbsp;&nbsp;&nbsp; ESTOQUE ATUAL :</div>
                <div class="div-table-cell" style="width: 30%;"><b><?php echo $estoque; ?></b></div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>

      <?php if ($id_material_consulta and !$destino and mysqli_num_rows($querysaida) >= 1) { ?>
        <div class="col-xs-12  collapse in text-center" id="graficos">
          <label>
            <h4><b>Saídas do Material <?php echo mb_strimwidth($desc['descricao'], 0, 45, "..."); ?></b></h4>
          </label>
          <div id="chart_div"></div>
          <div class="col-sm-offset-1" id="piechart" style="width: 1200px; height: 600px;"></div>
        </div>
      <?php } ?>

      <div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 collapse multi-collapse in text-center" id="pedidos">
          <h1 class="all-tittles"><small><a href="dashboard.php" title="Clique para limpar os filtros!"> RESERVAS</a></small></h1>
          <div class="table-responsive">
            <div class="div-table" style="margin:0 !important;">
              <div class="div-table-row div-table-row-list" style="background-color:#DFF0D8; font-weight:bold;">
                <div class="div-table-cell" style="width: 10%;">RESERVA</div>
                <div class="div-table-cell" style="width: 10%;">DESTINO</div>
                <div class="div-table-cell" style="width: 10%;">DATA</div>
                <div class="div-table-cell" style="width: 5%;">DOC.</div>
                <div class="div-table-cell" style="width: 20%;">DESCRIÇÃO</div>
                <div class="div-table-cell" style="width: 5%;">QUANT</div>
                <div class="div-table-cell" style="width: 10%;">VL IND</div>
                <div class="div-table-cell" style="width: 10%;">VL TOTAL</div>
                <div class="div-table-cell" style="width: 10%;">LOGIN</div>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <div style="height:400px;">
              <?php if (mysqli_num_rows($querypedidos) >= 1) {
                while ($saidastotal = mysqli_fetch_assoc($querypedidos)) {
                  $style  = $saidastotal['status'] == 2 ? 'text-decoration: line-through;' : ''; ?>
                  <ul id="itemContainer" class="list-unstyled">
                    <li>
                      <div class="table-responsive">
                        <div class="div-table" style="margin:0 !important;<?php echo $style; ?>">
                          <div class="div-table-row div-table-row-list">
                            <div class="div-table-cell " style="width: 10%;">
                              <a href="distribuir_pedido.php?id=<?php echo $saidastotal['pedido']; ?>">
                                <button class="btn btn-primary  tooltips-general" type="button" title="<?php echo $saidastotal['obs'] ?>"></><?php echo $saidastotal['pedido']; ?></button></a>
                            </div>
                            <div class="div-table-cell" style="width: 10%;"><b><?php echo $saidastotal['abrev_opm']; ?></b></div>
                            <div class="div-table-cell" style="width: 10%;"><?php echo date('d-m-Y', strtotime($saidastotal['data_pedidos'])); ?></div>
                            <div class="div-table-cell" style="width: 5%;"><?php echo $saidastotal['descritivo'] . '  ' . $saidastotal['documento']; ?></div>
                            <div class="div-table-cell" style="width: 20%;" title="<?php echo $saidastotal['descricao']; ?>"><b><?php echo mb_strimwidth($saidastotal['descricao'], 0, 25, "..."); ?></b></div>
                            <div class="div-table-cell" style="width: 5%;"><b><?php echo $saidastotal['qnt_saida']; ?></b></div>
                            <div class="div-table-cell" style="width: 10%;"><b><?php echo $saidastotal['valor_individual']; ?></b></div>
                            <div class="div-table-cell" style="width: 10%;"><b><?php echo $saidastotal['val_total']; ?></b></div>
                            <div class="div-table-cell" style="width: 10%;"><b><?php echo $saidastotal['user_saida']; ?></b></div>
                          </div>
                        </div>
                    </li>
                  </ul>
                  <div class="holder"></div>
              <?php }
              } else {

                echo '<h2 class="text-center all-tittles">Não há reservas no Sistema</h2>';
              } ?>
            </div>
          </div>
        </div>
      </div>
      <div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 collapse multi-collapse in text-center" id="saidas">
          <h1 class="all-tittles"><small><a href="dashboard.php" title="Clique para limpar os filtros!"> SAÍDAS</a>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "TOTAL : " . $qntsaida; ?></small></h1>
          <div class="table-responsive">
            <div class="div-table" style="margin:0 !important;">
              <div class="div-table-row div-table-row-list" style="background-color:#DFF0D8; font-weight:bold;">
                <div class="div-table-cell" style="width: 5%;">PEDIDO</div>
                <div class="div-table-cell" style="width: 10%;">DATA</div>
                <div class="div-table-cell" style="width: 10%;">DOC.</div>
                <div class="div-table-cell" style="width: 20%;">DESCRIÇÃO</div>
                <div class="div-table-cell" style="width: 5%;">QUANT</div>
                <div class="div-table-cell" style="width: 5%;">VL IND</div>
                <div class="div-table-cell" style="width: 10%;">VL TOTAL</div>
                <div class="div-table-cell" style="width: 10%;">DESTINO</div>
                <div class="div-table-cell" style="width: 10%;">LOGIN</div>
                <div class="div-table-cell" style="width: 5%;">STATUS</div>
                <div class="div-table-cell" style="width: 10%;">MOD60</div>

              </div>
            </div>
          </div>
          <div class="table-responsive">
            <div style="height:400px;">
              <?php if (mysqli_num_rows($querysaida) >= 1) {
                while ($saidastotal = mysqli_fetch_assoc($querysaida)) {
                  $style  = $saidastotal['status'] == 2 ? 'text-decoration: line-through;' : ''; ?>
                  <ul id="itemContainer" class="list-unstyled">
                    <li>
                      <div class="table-responsive">
                        <div class="div-table" style="margin:0 !important;<?php echo $style; ?>">
                          <div class="div-table-row div-table-row-list">
                            <div class="div-table-cell " style="width: 5%;">
                              <a href="distribuir_pedido.php?id=<?php echo $saidastotal['pedido']; ?>">
                                <button class="btn btn-primary  tooltips-general" type="button"></><?php echo $saidastotal['pedido']; ?></button></a>
                            </div>
                            <div class="div-table-cell" style="width: 10%;"><?php echo date('d-m-Y', strtotime($saidastotal['data_saida'])); ?></div>
                            <div class="div-table-cell" style="width: 10%;"><?php echo $saidastotal['descritivo'] . '  ' . $saidastotal['documento']; ?></div>
                            <div class="div-table-cell" style="width: 20%;" title="<?php echo $saidastotal['descricao']; ?>"><b><?php echo mb_strimwidth($saidastotal['descricao'], 0, 25, "..."); ?></b></div>
                            <div class="div-table-cell" style="width: 5%;"><b><?php echo $saidastotal['qnt_saida']; ?></b></div>
                            <div class="div-table-cell" style="width: 5%;"><b><?php echo $saidastotal['valor_individual']; ?></b></div>
                            <div class="div-table-cell" style="width: 10%;"><b><?php echo $saidastotal['val_total']; ?></b></div>
                            <div class="div-table-cell" style="width: 10%;"><b><?php echo $saidastotal['abrev_opm']; ?></b></div>
                            <div class="div-table-cell" style="width: 10%;"><b><?php echo $saidastotal['user_saida']; ?></b></div>
                            <div class="div-table-cell" style="width: 5%;">
                              <?php if ($saidastotal['status'] == 2) { //EXCLUIDO
                                echo '<button class="btn  tooltips-general" title="Exclída por ' . $saidastotal['rg_status'] . '&nbsp;' . $saidastotal['obs'] . '" style="color:#FF0000"><i class="glyphicon glyphicon-remove-sign"></i></button>';
                              };
                              if ($saidastotal['status'] == 1) { //Pendente de confirmaçao
                                echo '<button class="btn  tooltips-general" title="Aguardando confirmaçao de recebimento da unidade de destino!" style="color:#FCC900"><i class="glyphicon glyphicon-exclamation-sign"></i></button>';
                              };
                              if ($saidastotal['status'] == 3) { //Confirmado
                                echo '<button class="btn  tooltips-general" title="Confirmado recebimento por ' . $saidastotal['rg_status'] . '..." style="color:#298A08"><i class="glyphicon glyphicon-ok-sign"></i></button>';
                              };
                              ?>
                            </div>
                            <div class="div-table-cell " style="width:10%;">
                              <?php if ($saidastotal['destino'] < 500) {
                                echo '<a href="modelo60.php?id=' . $saidastotal[m60] . '" target="_blank">';
                              } ?>
                              <input class="btn btn-primary  tooltips-general" type="button" style="width: 100%" value="<?php echo $saidastotal['m60']; ?>"></></a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                  </ul>
                  <div class="holder"></div>
              <?php }
              } else {

                echo '<h2 class="text-center all-tittles">Não há registros de saídas no Sistema</h2>';
              } ?>
            </div>
          </div>
        </div>
      </div>
      <!--Modal de exclusão de entrada-->
      <div class="modal fade" id="excluir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title text-center a" style="color: red;">ATENÇÃO!!</h1>
              <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="post" action="">
                <div class="container-fluid text-center">
                  <div class="col-xs-12 col-sm-12 a">
                    <label>DESEJA EXCLUIR ESTE REGISTRO?</label><BR>
                    <label>Informe abaixo o Motivo.</label><BR>
                    <textarea name="obs" style="width: 100%" required></textarea>
                    <input type="hidden" id="identrada" name="identrada">
                    <input type="hidden" id="idmat" name="idmat">
                    <input type="hidden" id="qnt" name="qnt">
                  </div>
                </div>
            </div>
            <div class="modal-footer">
              <p align="center">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><b>X</b> &nbsp;&nbsp;Cancelar</button>
                <button type="submit" class="btn btn-danger" name="excluir" title="excluir Registro"><i class="glyphicon glyphicon glyphicon-trash"></i> &nbsp;&nbsp; EXCLUIR</button>
              </p>
            </div>
            </form>
          </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script>
          window.jQuery || document.write('<script src="/docs/4.4/assets/js/vendor/jquery.slim.min.js"><\/script>')
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>


        <style>
          .table-overflow {
            height: 300px;
            overflow-y: auto;
          }

          .a {
            font: bold 18px arial, sans-serif;
          }
        </style>
      </div>
      <br><br><br><br>
      <?php //include './inc/footer.php'; 
      ?>
</body>

<br><br>

</html>