<?php
sleep(1);
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MatOdonto - INICIO</title>
  <?php

  session_start();
  $LinksRoute = "./";
  include_once './inc/links.php';
  $opm_logado   = $_SESSION['UserOPM'];
  $nivelusuario = $_SESSION['nivelusuario'];
  ?>
  <script type="text/javascript">
    function retiramsg() {
      setTimeout(function() {
        $("#msg").slideUp('slow', function() {});
      }, 3500);
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
  include_once 'library/fornecedor.php';
  include_once 'library/tipodocumento.php';
  include 'inc/NavLateral.php';
  if ($_SESSION['UserRG'] == '') {
    header("Location: process/logout.php");
    exit();
  }
  //Confirma recebimento Material
  if (isset($_POST['confirma'])) {

    $m60    = $_POST['confirma'];

    $result = Materiais::entradaMaterial($m60);

    $_SESSION['msg'] =  "<div class='alert alert-success' role='alert'> <b>Recebimento confirmado!!</b><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-labelhidden='true'>&times;</span> </button></div>";

    echo '<script type="text/javascript">retiramsg();</script>';
  }


  //Filtros para consulta    
  if (isset($_POST['enviar'])) {
    $like       = empty($_POST['consulta']) ? '' : "and descricao like'%" . $_POST['consulta'] . "%'";
    $separa     = explode(",", $_POST['tipo']);
    $descricao  = $separa[1];
    $tipo       = $separa[0] == 0 ? "" : "and id_tipomaterial=" . $separa[0];

    if (!empty($_POST['unidade'])) {
      $idopm      = explode(',', $_POST['unidade'])[0];
      $opm_filtro = " and id_opm =" . explode(',', $_POST['unidade'])[0];
      $opm_desc   = explode(',', $_POST['unidade'])[1];
    }
  }

  if (empty($opm_filtro)) {
    $opm_filtro = "and id_opm =" . $opm_logado;
    $opm_desc   = $_SESSION['UserOPMDesc'];
    $idopm      =  $opm_logado;
  }

  /*Lista as saidas com status pendente e destino da unidade do usuario logado*/



  $result = saida::consultar("SELECT 
                                DISTINCT m60,
                                data_saida 
                              FROM 
                                saida 
                              where 
                                status=1 
                              and 
                                destino=' $opm_logado ' 
                              and 
                                destino <> 164 
                              order by id desc");


  include_once 'inc/NavLateral.php';

  ?>


  <div class="content-page-container full-reset custom-scroll-containers">
    <?php
    include_once 'inc/NavUserInfo.php';

    ?>

    <div class="container">
      <div class="page-header">
        <h1 class="all-tittles"> SisMatOdonto <small> Estoque de Material Odontológico</small></h1>
      </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" id="filtros">
      <div id="msg">
        <?php //echo $_SESSION['msg'];
        unset($_SESSION['msg']);
        ?>
      </div>
      <div class="row ">
        <form method="post" action="home.php">
          <div class="col-xs-12 col-sm-1 col-sm-offset-1">
            <label>Unidade</label>
          </div>
          <div class="col-xs-12 col-sm-2 ">
            <div class="group-material">
              <select class="selectpicker form-control" data-size="20" data-live-search="true" name="unidade">
                <?php
                echo '<option value="' . $idopm . ',' . $opm_desc . '">' . $opm_desc . '</option>';
                if ($nivelusuario == '2' or $_SESSION['nivel'] == 10) {

                  $queryopms = Consulta::consultar("SELECT id, cod_opm, abrev_opm FROM opm where flag_opm is null or flag_opm='' order by abrev_opm asc");

                  foreach ($queryopms as $key => $value) {
                    echo '<option value="' . $value["id"] . ',' . $value["abrev_opm"] . '">' . $value["abrev_opm"] . '</option>';
                  }
                } else {
                  echo '<option value="164,DGO">DGO</option>';
                  echo '<option value="' . $opm_logado . ',PRÓPRIA">PRÓPRIA</option>';
                }


                ?>

              </select>
            </div>
          </div>


          <div class="col-xs-12 col-sm-1">
            <label>TIPO MATERIAL</label>
          </div>
          <div class="col-xs-12 col-sm-2 ">
            <div class="group-material">

              <select class=" selectpicker form-control a" title="selecione" id="classe" name="tipo">
                <?php

                $result = tipomaterial::consultar("SELECT * FROM tipomaterial");

                foreach ($result as $resultado) {
                  echo '<option value="' . $resultado["id"] . ',' . $resultado["descr"] . '">' . $resultado["descr"] . '</option>';
                }
                ?>
              </select>
            </div>
          </div>
          <div class="col-xs-12 col-sm-1">
            <label>MATERIAL</label>
          </div>
          <div class="col-xs-12 col-sm-2 ">
            <div class="group-material">
              <input type="text" class="material-control tooltips-general a text-center" name="consulta" maxlength="20" data-toggle="tooltip" data-placement="top" title="parte do nome do material">
            </div>
          </div>
          <div class="col-xs-12 col-sm-2 text-center">
            <button type="submit" class="btn" name="enviar" style="background-color:#FFFFFF;"><i class="glyphicon glyphicon-filter"></i> &nbsp;Filtrar</button>
          </div>
        </form>
      </div>
    </div>
    <br>
    <div class="container">
      <div class="page-header">
        <h1 class="all-tittles"></h1>
      </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
      <button class="btn" title="Estoque Disponível" style="color:#298A08"><i class="glyphicon glyphicon-ok-sign"></i></button>Estoque Disponível&nbsp;&nbsp;
      <button class="btn" title="Estoque Mínimo" style="color:#FCC900"><i class="glyphicon glyphicon-exclamation-sign"></i></button>Estoque Mínimo&nbsp;&nbsp;Estoque
      indisponível&nbsp;&nbsp;&nbsp;&nbsp;
      <a href="gerar_planilha_estoque.php"><img title="Gerar Planilha" src="assets/icons/excel.jpg" width="50" height="35"></a>Estoque da Unidade
    </div>

    <?php

    $filtro = "";

    if (isset($like))
      $filtro = " $like ";

    if (isset($tipo))
      $filtro = " $tipo ";

    $resultd = material::consultar("SELECT 
                                      m.descricao,
                                      m.estoqueminimo,
                                      SUM(e.quantidade)AS estoque, 
                                      m.id,t.descr 
                                  FROM  
                                      material m,
                                      entrada e,
                                      tipomaterial t 
                                  WHERE 
                                    e.id_material=m.id 
                                    AND 
                                    e.quantidade<>0
                                    AND 
                                    t.id = m.id_tipomaterial
                                    $filtro $opm_filtro                                  
                                  group by e.id_material");

    if (sizeof($resultd) > 0) {

      $resum = '&nbsp;&nbsp;&nbsp;';

      echo '<section class="full-reset text-center" style="padding: 5px 0;">';

      foreach ($resultd as $key => $dadoscautela) {

        $resum = pedido::consultar("SELECT 
                                      sum(qnt_saida) as reserva 
                                    FROM 
                                      pedido 
                                    where 
                                      id='$dadoscautela[id]' 
                                      and 
                                      status=1");

        $resum = $resum[0]['reserva'];

        $resum = $resum > 0 ? 'Pedido : ' . $resum : '&nbsp;&nbsp;&nbsp;';

    ?>

        <article class="tile tooltips-general" data-num="<?php echo $dadoscautela['id']; ?>" title="<?php echo $dadoscautela['descricao']; ?>">
          <?php
          if ($dadoscautela['estoque'] <= $dadoscautela['estoqueminimo']) {
            $icon = 'glyphicon glyphicon-exclamation-sign';
            $color = '#FCC900';
          } else {
            $icon = "glyphicon glyphicon-ok-sign";
            $color = '#298A08';
          }
          echo '<a href="dashboard.php?id=' . $dadoscautela['id'] . '">
                    <div class="tile-num full-reset" style="font-size: 22px;color:' . $color . '"><b>' . mb_strimwidth($dadoscautela['descricao'], 0, 27, "...") . '</b></div>'; ?>
          <div><b><?php
                  if ($opm_logado == '164' or  $_SESSION['nivel'] == 10) {
                    echo  $resum;
                  } ?></b>
          </div>
          <div class="tile-num full-reset"><?php
                                            if ($opm_logado == '164' or  $_SESSION['nivel'] == 10) {
                                              echo number_format($dadoscautela['estoque'], 0, ',', '.');
                                            }
                                            if ($opm_filtro != 'and opm=164' and $opm_logado != '164') {
                                              echo number_format($dadoscautela['estoque'], 0, ',', '.');
                                            } ?>
          </div>
          </a>
        </article>

    <?php }
      echo '</section>';
    } else {
      echo '<br><br><br><br><br><br><h2 class="text-center all-tittles">Não há Itens para consulta realizada!</h2><br><br><br>';
      $resultd = null;
    }
    ?>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <?php include_once './inc/footer.php'; ?>
  </div>



  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class='alert alert-danger text-center' role='alert'> <b>ATENÇÃO!<br>Você deve confirmar o
              recebimento de todos modelos 60 abaixo!!<br></b><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-labelhidden='true'>&times;</span>
            </button><br><a href="/assets/video/sisab.wmv"> <b>Assistir Tutorial.</b></a></div>
          <!-- <h1 class="modal-title text-center" >Confirme o Recebimento do Material abaixo: </h1>-->
        </div>
        <div class="modal-body">

          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="saidas">
            <div class="table-responsive">
              <div class="div-table" style="margin:0 !important;">
                <div class="div-table-row div-table-row-list" style="background-color:#DFF0D8; font-weight:bold;">
                  <div class="div-table-cell" style="width: 15%;">DATA SAÍDA</div>
                  <div class="div-table-cell" style="width: 70%;">MOD60</div>
                  <div class="div-table-cell" style="width: 15%;"></div>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <div style="height:200px;overflow-y:auto;">
                <?php
                while ($saidastotal = mysqli_fetch_assoc($qrysaida)) {
                ?>
                  <ul id="itemContainer" class="list-unstyled">
                    <li>
                      <div class="table-responsive">
                        <div class="div-table" style="margin:0 !important;">
                          <div class="div-table-row div-table-row-list">
                            <div class="div-table-cell" style="width: 15%;">
                              <b><?php echo date('d-m-Y', strtotime($saidastotal['data_saida'])); ?></b>
                            </div>
                            <div class="div-table-cell " style="width: 70%;"><a href="modelo60.php?id=<?php echo $saidastotal['m60']; ?>" target="_blank"><button class="btn btn-primary  tooltips-general" type="button" style="width: 70%;"></>
                                  <?php echo $saidastotal['m60']; ?></button></a></div>
                            <form method="post" class="text-center" action="home.php" style="width: 17%;">
                              <button type="submit" class="btn btn-success" name="confirma" value="<?php echo $saidastotal['m60']; ?>">Recebido</button>
                            </form>
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

          <button class="btn btn-secondary" data-dismiss="modal">Confirmar Depois</button>

        </div>
      </div>
    </div>
  </div>


</body>

</html>