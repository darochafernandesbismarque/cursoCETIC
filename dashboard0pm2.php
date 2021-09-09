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
  $opm_logado = $_SESSION['UserOPM'];
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

    $rguser     =  $_SESSION['UserRG'];

    $estoque    = mysqli_fetch_array(ejecutarSQL::consultar("SELECT estoque from estoque_opm where id_material='$id_material' and opm='$opm_logado'"))[0];

    $qntfinal   = $estoque - $qnt;

    $tabela     = "estoque_opm";
    $campos     = "estoque='$qntfinal'";
    $condicion  = "id_material='$id_material' and opm='$opm_logado'";

    $retorno    = consultasSQL::UpdateSQL($tabela, $campos, $condicion);

    $tabela     = "entrada";
    $campos     = "status='2',rg_status='$rguser',obs='$obs'";
    $condicion  = "id_entrada='$identrada'";

    $retorno2     = consultasSQL::UpdateSQL($tabela, $campos, $condicion);
  }

  //   include 'inc/NavLateral.php';
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
      // $destino  = $_POST['destino']=="A10" ?'':'and destino='.$_POST['destino'];
      $destino  = explode(",", $_POST['destino'])[0] == "A10" ? '' : 'and destino=' . explode(",", $_POST['destino'])[0];

      $destino_desc  = explode(",", $_POST['destino'])[0] == "A10" ? '' : ', ' . explode(",", $_POST['destino'])[1];

      $fornecedor = empty(explode(",", $_POST['fornecedor'])[0]) ? '' : 'and id_fornecedor=' . explode(",", $_POST['fornecedor'])[0];

      $fornecedor_desc = empty(explode(",", $_POST['fornecedor'])[0]) ? '' : ', ' . explode(",", $_POST['fornecedor'])[1];
      //$fornecedor = empty($_POST['fornecedor'])?'':'and id_fornecedor='.$_POST['fornecedor'];
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
    $qryentrada = "SELECT m.descricao,qnt,data,f.descricao as fornecedor,vl_uni,vl_total,nf,status,user, id_entrada,id_material FROM entrada e,material m,fornecedor f WHERE data BETWEEN '$datainic' AND '$datafim' $idMaterialEntrada  $fornecedor $tipoverba and e.id_material=m.id and opm='$opm_logado' and id_fornecedor=f.id  order by e.id desc";

    $_SESSION['qryentrada'] = $qryentrada;

    $queryentrada = ejecutarSQL::consultar($qryentrada);

    if ($id_material_consulta != '') {
      $querydesc = ejecutarSQL::consultar("SELECT descricao FROM material WHERE id='$id_material_consulta' ");
      $desc     = mysqli_fetch_assoc($querydesc);
    }
    /*Lista saidas de acordo com os filtros*/
    $qrysaida = "SELECT * FROM saida s,material m, tabopm o, tipodoc t WHERE data_saida BETWEEN '$datainic' AND '$datafim' and opm='$origem' $destino  $idMaterialSaida and s.id_material_saida=m.id and s.destino=o.cod_opm and t.id=s.tipo_doc order by id_saida desc";

    $qrysaidaxls = "SELECT * FROM saida s,material m, tablocal o WHERE data_saida BETWEEN '$datainic' AND '$datafim' and opm='$origem' $destino  $idMaterialSaida and s.id_material_saida=m.id and status<>2 and s.destino=o.cod_local  order by id_saida desc";
    $_SESSION['qrysaida'] = $qrysaidaxls;

    $querysaida       = ejecutarSQL::consultar($qrysaida);

    /*    if ($id_material_consulta!='') {                
            //  $estoque         = mysqli_fetch_array(ejecutarSQL::consultar("SELECT estoque FROM estoque_opm WHERE id_material='$id_material_consulta' and opm='$opm_logado'"))[0];
              $_SESSION['qntestoque']= $estoque;
            }*/
    /*Soma todas saidas de acordo com filtro aplicado*/
    if ($contador       = mysqli_fetch_array(ejecutarSQL::consultar("SELECT sum(e.qnt) FROM entrada e,material m WHERE data BETWEEN '$datainic' AND '$datafim' $idMaterialEntrada and e.id_material=m.id and opm='$opm_logado' and status<>2"))) {
      $qntentrada    = $contador[0];
      $_SESSION['qntentrada'] = $qntentrada;
    }

    /*Soma todas saidas de acordo com filtro aplicado*/
    if ($contador2      = mysqli_fetch_array(ejecutarSQL::consultar("SELECT sum(qnt_saida) FROM  saida s, material m WHERE data_saida BETWEEN '$datainic' AND '$datafim' and s.id_material_saida=m.id $destino $idMaterialSaida"))[0]) {
      $qntsaida        = $contador2;
      $_SESSION['qntsaida'] = $qntsaida;
    }

    include 'library/conexao.php';
    $qrygrafico = "SELECT sum(s.qnt_saida) as total, s.destino,o.desc_local FROM  saida as s,tablocal as o, material m WHERE s.destino in (SELECT destino FROM  saida where opm='$origem' ) and data_saida BETWEEN '$datainic' AND '$datafim' and opm='$origem' $destino  $idMaterialSaida  and s.destino=o.cod_local and s.id_material_saida=m.id and o.cod_opm=s.opm and s.status<>2 group by s.destino";

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
            echo "['" . $dado['desc_local'] . "'," . $dado['total'] . "],";
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
              <label>Verba/Entrada</label>
              <div class="group-material">
                <select class="selectpicker form-control" name="tipoverba">
                  <option value="">TODOS</option>
                  <?php if ($opm_logado == 253) { ?>
                    <option value="1">Aquisiçao SEPM</option>
                    <option value="2">Doação</option> <?php } ?>
                  <option value="3">Transferência Financeira</option>
                  <option value="4">Adiantamento Financeiro</option>
                </select>
              </div>
            </div>

            <div class="col-xs-12 col-sm-2">
              <label>Fornecedor/Entrada</label>
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
              <label>Destino/Saída</label>
              <div class="group-material">
                <select class="selectpicker form-control" data-size="20" data-live-search="true" name="destino" required>
                  <option value="A10">TODAS</option>
                  <?php
                  //  echo '<option value="'.$opm_select.'" >'.$opm_desc.'</option>';
                  $queryopms = ejecutarSQL::consultar("SELECT * FROM tablocal where cod_opm='$opm_logado' order by desc_local ");
                  while ($opms = mysqli_fetch_array($queryopms)) {
                    echo '<option value="' . $opms["cod_local"] . ',' . $opms["desc_local"] . '" >' . $opms["desc_local"] . '</option>';
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

    <br>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
      <button class="btn" data-toggle="collapse" data-target="#filtros" title="Filtros" style="background-color:#FFFFFF;"><i class="glyphicon glyphicon-filter"></i> &nbsp;
        <label class="a"> <?php echo "Pesquisa do dia  " . date("d-m", strtotime($datainic)) . "   ao  " . date("d-m", strtotime($datafim)) . '  ' . $destino_desc . ' ' . $fornecedor_desc; ?></label> </button>
    </div>
    <br>
    <div class="container">
      <div class="page-header">
        <h1 class="all-tittles"></h1>
      </div>
    </div>
    <!-- FIM DIV DO FILTRO -->
    <br>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
      <p>
        <a class="btn btn-primary " data-toggle="collapse" href="#saidas" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">&nbsp;&nbsp;<b>SAÍDAS</b></a>
        <!-- <a class="btn btn-primary " data-toggle="collapse" href="#saidas-excluidas" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">&nbsp;&nbsp;<b>EXCLUÍDOS</a>-->
        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#entradas" aria-expanded="false"><i class="zmdi zmdi-square-right zmdi-hc-fw"></i>&nbsp;&nbsp;<b>ENTRADAS</b></button>

        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#graficos" aria-expanded="false" aria-controls="multiCollapseExample2" <?php if (!$id_material_consulta) {
                                                                                                                                                                    echo "disabled";
                                                                                                                                                                  } ?>>&nbsp;&nbsp;<b>GRÁFICOS</b></button>
        <?php if ($id_material_consulta and $opm_logado == 253) {
          echo '<a href="gerar-planilha-mod40.php' . $idget . '" ><img title="Gerar Planilha" src="assets/icons/excel.jpg" width="50" height="35" ></a>';
        } ?>
      </p>
    </div>
    <!--LEGENDA DE STATUS-->
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
      <button class="btn" title="Estoque Disponível" style="color:#298A08"><i class="glyphicon glyphicon-ok-sign"></i></button>&nbsp;Confirmado Recebimento&nbsp;&nbsp;
      &nbsp;&nbsp;
      <button class="btn" title="Estoque indisponível" style="color:#FF0000"><i class="glyphicon glyphicon-remove-sign"></i></button>&nbsp;Excluído
    </div>
    <div>
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  collapse multi-collapse text-center" id="entradas">
        <h1 class="all-tittles"><small>ENTRADAS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small></h1>
        <div class="div-table" style="margin:0 !important;">
          <div class="div-table-row div-table-row-list" style="background-color:#DFF0D8; font-weight:bold;">
            <div class="div-table-cell" style="width: 10%;">DATA</div>
            <div class="div-table-cell" style="width: 25%;">DESCRIÇÃO</div>
            <div class="div-table-cell" style="width: 10%;">QUANT</div>
            <div class="div-table-cell" style="width: 7%;">VL IND</div>
            <div class="div-table-cell" style="width: 10%;">VL TOTAL</div>
            <div class="div-table-cell" style="width: 10%;">DOC.</div>
            <div class="div-table-cell" style="width: 8%;">FORNECEDOR</div>
            <div class="div-table-cell tooltips-general" title="LOGIN ou RG de quem retirou a mercadoria no DAbst" style="width: 10%;">LOGIN</div>
            <div class="div-table-cell" style="width: 10%;">STATUS</div>
          </div>
        </div>
        <!--Inicio entrada DAbst/Distribuiçao-->
        <div class="table-responsive">
          <div>
            <?php

            $qrysaida = "SELECT * FROM saida s,material m, tabopm o WHERE data_saida BETWEEN '$datainic' AND '$datafim' and opm='253' and destino='$opm_logado'  $idMaterialSaida and s.id_material_saida=m.id and s.destino=o.cod_opm  order by id_saida desc";
            $querysaidaDabst       = ejecutarSQL::consultar($qrysaida);

            if (mysqli_num_rows($querysaidaDabst) >= 1) {
              while ($saidastotal = mysqli_fetch_assoc($querysaidaDabst)) {
                $style  = $saidastotal['status'] == 2 ? 'text-decoration: line-through;' : ''; ?>
                <ul id="itemContainer" class="list-unstyled">
                  <li>
                    <div class="table-responsive">
                      <div class="div-table" style="margin:0 !important;<?php echo $style; ?>">
                        <div class="div-table-row div-table-row-list">
                          <div class="div-table-cell" style="width: 10%;"><?php echo date('d-m-Y', strtotime($saidastotal['data_saida'])); ?></div>
                          <div class="div-table-cell" style="width: 25%;" title="<?php echo $saidastotal['descricao']; ?>"><?php echo mb_strimwidth($saidastotal['descricao'], 0, 45, "..."); ?></div>
                          <div class="div-table-cell" style="width: 10%;"><?php echo $saidastotal['qnt_saida']; ?></div>
                          <div class="div-table-cell" style="width: 7%;"><?php echo $saidastotal['valor_individual']; ?></div>
                          <div class="div-table-cell" style="width: 10%;"><?php echo $saidastotal['val_total']; ?></div>
                          <div class="div-table-cell" style="width: 10%;"><?php echo $saidastotal['documento']; ?></div>
                          <div class="div-table-cell" style="width: 8%;">DAbst</div>
                          <div class="div-table-cell" style="width: 10%;"><?php echo $saidastotal['rg_retirada']; ?></div>
                          <div class="div-table-cell" style="width: 10%;">
                            <?php if ($saidastotal['status'] == 2) { //EXCLUIDO
                              echo '<button class="btn  tooltips-general" title="Exclída por ' . $saidastotal['rg_status'] . '&nbsp;obs: ' . $saidastotal['obs'] . '" style="color:#FF0000"><i class="glyphicon glyphicon-remove-sign"></i></button>';
                            };
                            if ($saidastotal['status'] == 1) { //Pendente de confirmaçao
                              echo '<button class="btn  tooltips-general" title="Aguardando confirmaçao de recebimento da unidade de destino!" style="color:#FCC900"><i class="glyphicon glyphicon-exclamation-sign"></i></button>';
                            };
                            if ($saidastotal['status'] == 3) { //Confirmado
                              echo '<button class="btn  tooltips-general" title="Confirmado recebimento por ' . $saidastotal['rg_status'] . '..." style="color:#298A08"><i class="glyphicon glyphicon-ok-sign"></i></button>';
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
            } ?>
          </div>
        </div>
        <!--fim entrada DAbst/Distribuiçao-->

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
                          <div class="div-table-cell" style="width: 10%;"><?php echo date('d-m-Y', strtotime($entradadadostotal['data'])); ?></div>
                          <div class="div-table-cell" style="width: 25%;" title="<?php echo $entradadadostotal['descricao']; ?>"><?php echo mb_strimwidth($entradadadostotal['descricao'], 0, 45, "..."); ?></div>
                          <div class="div-table-cell" style="width: 10%;"><?php echo $entradadadostotal['qnt']; ?></div>
                          <div class="div-table-cell" style="width: 7%;"><?php echo $entradadadostotal['vl_uni']; ?></div>
                          <div class="div-table-cell" style="width: 10%;"><?php echo $entradadadostotal['vl_total']; ?></div>
                          <div class="div-table-cell tooltips-general" style="width: 10%;"><?php echo $entradadadostotal['nf']; ?></div>
                          <div class="div-table-cell tooltips-general" style="width: 8%;"><?php echo mb_strimwidth($entradadadostotal['fornecedor'], 0, 13, ".."); ?></div>
                          <div class="div-table-cell" style="width: 10%;"><?php echo $entradadadostotal['user']; ?></div>
                          <div class="div-table-cell " style="width: 10%;">
                            <?php if ($entradadadostotal['status'] == 2) {
                              echo '<button class="btn  tooltips-general" title="Exclída por ' . $entradadadostotal['rg_status'] . ' ' . $entradadadostotal['obs'] . '" style="color:#FF0000"><i class="glyphicon glyphicon-remove-sign"></i></button>';
                            };
                            if ($entradadadostotal['status'] == 1) {
                              echo '<button class="btn" title="" style="color:#FCC900"><i class="glyphicon glyphicon-exclamation-sign"></i></button>';
                            };
                            if ($entradadadostotal['status'] == 3) {
                              echo '<button class="btn  tooltips-general" title="Clique se deseja Excluír." style="color:#298A08" onclick="excluir(' . $entradadadostotal['id_entrada'] . ',' . $entradadadostotal['id_material'] . ',' . $entradadadostotal['qnt'] . ')"><i class="glyphicon glyphicon-ok-sign"></i></button>';
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
            } ?>
            <!-- <div class="div-table-row div-table-row-list" style="background-color:#DFF0D8; font-weight:bold;">
          <div class="div-table-cell" style="width: 30%;">TOTAL:</div>
          <div class="div-table-cell" style="width: 30%;"><?php echo $qntentrada; ?></div>
          <?php // if($estoque){ 
          ?>
          <div class="div-table-cell" style="width: 30%;">&nbsp;&nbsp;&nbsp;&nbsp; ESTOQUE ATUAL :</div>
          <div class="div-table-cell" style="width: 30%;"><b><?php echo $estoque; ?></b></div>
        <?php // } 
        ?>
        </div>-->
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
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 collapse multi-collapse in text-center" id="saidas">
          <h1 class="all-tittles"><small><a href="dashboard.php" title="Clique para limpar os filtros!"> SAÍDAS</a></small></h1>
          <div class="table-responsive">
            <div class="div-table" style="margin:0 !important;">
              <div class="div-table-row div-table-row-list" style="background-color:#DFF0D8; font-weight:bold;">
                <div class="div-table-cell" style="width: 10%;">DATA</div>
                <div class="div-table-cell" style="width: 20%;">DESCRIÇÃO</div>
                <div class="div-table-cell" style="width: 10%;">QUANT</div>
                <div class="div-table-cell" style="width: 10%;">VL IND</div>
                <div class="div-table-cell" style="width: 10%;">VL TOTAL</div>
                <div class="div-table-cell" style="width: 10%;">DESTINO</div>
                <div class="div-table-cell" style="width: 10%;">LOGIN</div>
                <div class="div-table-cell" style="width: 10%;">STATUS</div>
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
                            <div class="div-table-cell" style="width: 10%;"><?php echo date('d-m-Y', strtotime($saidastotal['data_saida'])); ?></div>
                            <div class="div-table-cell" style="width: 20%;" title="<?php echo $saidastotal['descricao']; ?>"><?php echo mb_strimwidth($saidastotal['descricao'], 0, 25, "..."); ?></div>
                            <div class="div-table-cell" style="width: 10%;"><?php echo $saidastotal['qnt_saida']; ?></div>
                            <div class="div-table-cell" style="width: 10%;"><?php echo $saidastotal['valor_individual']; ?></div>
                            <div class="div-table-cell" style="width: 10%;"><?php echo $saidastotal['val_total']; ?></div>
                            <div class="div-table-cell" style="width: 10%;"><?php echo $saidastotal['desc_local']; ?></div>
                            <div class="div-table-cell" style="width: 10%;"><?php echo $saidastotal['user_saida']; ?></div>
                            <div class="div-table-cell" style="width: 10%;">
                              <?php if ($saidastotal['status'] == 2) { //EXCLUIDO
                                echo '<button class="btn  tooltips-general" title="Exclída por ' . $saidastotal['rg_status'] . '&nbsp;obs: ' . $saidastotal['obs'] . '" style="color:#FF0000"><i class="glyphicon glyphicon-remove-sign"></i></button>';
                              };
                              if ($saidastotal['status'] == 3) { //Confirmado
                                echo '<button class="btn  tooltips-general" style="color:#298A08"><i class="glyphicon glyphicon-ok-sign"></i></button>';
                              };
                              ?>
                            </div>
                            <div class="div-table-cell " style="width: 5%;"><a href="modelo60Opm.php?id=<?php echo $saidastotal['m60']; ?>" target="_blank"><button class="btn btn-primary  tooltips-general" type="button" title="<?php
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
              <?php }
              } else {

                echo '<h2 class="text-center all-tittles">Não há registros de saídas no Sistema</h2>';
              } ?>
            </div>
          </div>
        </div>
      </div>



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
                <?php if ($_SESSION['nivel'] == 3) { ?>
                  <button type="submit" class="btn btn-danger" name="excluir" title="excluir Registro"><i class="glyphicon glyphicon glyphicon-trash"></i> &nbsp;&nbsp; EXCLUIR</button>
                <?php } else {
                  echo '<div style="color: red;"><b>Para excluão solicite ao chefe de seção!!</b></div>';
                } ?>
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