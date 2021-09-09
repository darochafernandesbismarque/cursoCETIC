<?php
error_reporting(0);
    session_start();
    unset($_SESSION['rgretirada']);
    $pm_logado            = $_SESSION['UserRG'] ;
    $opm_logado           = $_SESSION['UserOPM'];
    $opm_logado = $_SESSION['UserOPM'];
      if ($opm_logado<>164) {
        header("Location: distribuir_material_opm.php");
      }
    $LinksRoute="./";
    include './inc/links.php'; 
    include 'library/configserver.php';
    include 'library/consulsql.php';
    include 'class/materiais.class.php';
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Distribuir</title>
      <script type="text/javascript" src="js/jquery-1.4.2.js"></script>
      <script type="text/javascript"> 
        function retiramsg(){            
          setTimeout(function(){
          $("#msg").slideUp('slow',function(){});
          },2500);
        }
      </script>
  </head>
  <body>
  <?php   
   include 'inc/NavLateral.php'; 
      if ($_SESSION['UserRG']=='') { header("Location: process/logout.php");
      exit();   
    }
  
    if (!empty($_POST['rgretirada'])) {
      $_SESSION['rgretirada'] = str_replace('.', '',$_POST['rgretirada']);
    }

    if(isset($_POST['enviar'])){
      $ultsolicitacao = mysqli_fetch_array(ejecutarSQL::consultar("SELECT m60 FROM saida where opm='$opm_logado' and m60<>'Baixa-Material' order by id_saida desc limit 1"))[0];
      $partes = explode('/',$ultsolicitacao);
    
      $parte =  $partes[2]==date("Y")? $partes[0]+1:'1'; 

        for($count = 0; $count < count($_POST["idmaterial"]); $count++)
        {        
        $rgretirada     = $_POST['rgretirada'];
        $destino        = $_POST['destino'];
        $pedido         = $_POST['pedido'];

        $idmaterial     = $_POST['idmaterial'][$count];
        $id_entrada     = $_POST['id_entrada'][$count];
        $estoque        =  mysqli_fetch_array(ejecutarSQL::consultar("SELECT qnt_atual FROM entrada  where id_entrada= '$id_entrada'"))[0];
        $vl_individual  = $_POST['vl_individual'][$count];
        $vl_total       = $_POST['vl_total'][$count];
        $qnt            = str_replace('.', '',$_POST['qnt'])[$count];
        $data_hoje      = date("Y-m-d");
        $numsol         = $destino=='164'?'Acerto Estoque': $parte.'/'.$opm_logado.'/'.date("Y"); 
  
        $tipo_doc       = $_POST['tipo_doc'][$count];
        $documento      = $_POST['documento'][$count];
        $dt_doc         = $_POST['dt_doc'][$count];

        $tabela='saida';
        $campos="pedido,data_saida,id_material_saida,ult_estoque,qnt_saida,valor_individual,destino,val_total,documento,user_saida,m60,tipo_doc,dt_doc,rg_retirada,status,opm,id_entrada";
        $valores="'$pedido','$data_hoje','$idmaterial','$estoque','$qnt','$vl_individual','$destino','$vl_total','$documento','$pm_logado','$numsol','$tipo_doc','$dt_doc','$rgretirada',1,'$opm_logado','$id_entrada'"; 

          echo "campos : ".$valores;
         
        if(consultasSQL::InsertSQL($tabela, $campos, $valores)){
         
        $tabela='pedidos';
        $campos="status='3'";
        $condicion="pedido='$pedido'";          
        $id_insert=consultasSQL::UpdateSQL($tabela, $campos, $condicion); }                    
      }
        if($id_insert and $destino=='164'){
            $_SESSION['msg']=  "<div class='alert alert-success' role='alert'> <b>Estoque de Material Acertado!</b><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-labelhidden='true'>&times;</span> </button></div>";
               echo '<script type="text/javascript">retiramsg();</script>'; 
        }elseif($id_insert){
           echo "<script type='text/javascript'>window.open('modelo60.php?id=".$numsol."','_blank');</script>"; 

          echo '<script>
        window.location.href="dashboard.php";
    </script>';
        }else{
          $_SESSION['msg']=  "<div class='alert alert-danger' role='alert'> <b>Falha ao cadastrar!!</b><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-labelhidden='true'>&times;</span> </button></div>";
          echo '<script type="text/javascript">retiramsg();</script>';        
        }
      unset($_POST['enviar']);
    }
//Exclui reserva
    if(isset($_POST['excluir'])){ 
      $dados = $_POST;
     Materiais::excluirReservaMaterial($dados);
    }
 
  //Carrega dados da reserva 
    if (isset($_GET['id'])) { 
      $pedido = $_GET['id'];  
     
      $sqlgeral = Materiais::getReserva($pedido);
      $dadosgeral1 = mysqli_fetch_array($sqlgeral);
    }else{
      echo "<script>javascript:history.back(-1)</script>";
    }
    ?>  
    <div class="content-page-container full-reset custom-scroll-containers">

    <script type="text/javascript">
    function excluir(idmat){
      $("#nreserva").val(idmat); 
      $('#excluir').modal('show');         
      } 
    </script>

      <?php  include 'inc/NavUserInfo.php' ;?>
      <div class="container">
        <div class="validaMat"></div>
          <div class="page-header">
            <h1 class="all-tittles">Sistema de Abastecimento <small> Distribuiçao de Material</small></h1>
          </div>
      </div>
      
      <div class="container-fluid text-center"  style="margin: 0px 0;">
        <?php if ($dadosgeral1['status']==1) { ?>
        <img src="<?php echo "http://172.16.0.1/fotos/". $_SESSION['rgretirada'].".bmp"; ?>" alt="Selecione RG do PM" class="img-responsive img-rounded center-box" align ="text-center" style="max-width:150px;"><br> 
        <button class="btn btn-primary" data-toggle="modal"  data-target="#modalRg" >RG : <?php echo $_SESSION['rgretirada']; ?></button>
        <?php }else{echo "<b style='color:red;'>Pedido Indisponível</b>";} ?>        
      </div>
      <?php if (mysqli_num_rows($qrysaida)>0) {?>
         <div class="col-xs-12 col-sm-12 alert alert-warning text-center" role="alert">
          <button class="btn" data-toggle="modal"  data-target="#modalExemplo"  title="Clique para ver sa´das anteriores!" style="background-color:#FFFFFF;"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> &nbsp;
          <label ><b> <?php echo "Saídas do dia  ".date("d-m", strtotime($datainic))."   ao  ".date("d-m", strtotime($datafim)); ?></b></label> </button>
        </div>
        <?php } ?>
      <br>
      <div class="container-fluid" >
      <form   method="post" action="distribuir_pedido.php">
        <span id ="validaMat"></span>
        <div class="row text-center">
          <div class="col-xs-12 col-sm-2 col-sm-offset-1">
            <label>Confecionado Por:</label>
            <div class="group-material">
              <input type="text" class="material-control text-center a"  value="<?php echo $dadosgeral1['user_saida']; ?>" readonly>
            </div>
          </div>

          <div class="col-xs-12 col-sm-3 ">
            <label>Destino</label>
            <div class="group-material">
              <input type="text" class="material-control text-center a"  value="<?php echo $dadosgeral1['abrev_opm']; ?>" readonly>
              <input type="hidden" name="tipo_doc" value="<?php echo $dadosgeral1['tipo_doc']; ?>" >
              <input type="hidden" name="pedido" value="<?php echo $pedido; ?>" id="idmat">
              <input type="hidden" name="destino" value="<?php echo $dadosgeral1['destino']; ?>">
            </div>
          </div>
           
          <div class="col-xs-12 col-sm-3">
            <label>N. Documento</label>
            <div class="group-material">
              <input type="number" class="material-control text-center a" value="<?php echo $dadosgeral1['documento']; ?>" name="documento" readonly >     
            </div>
          </div>   
            
          <div class="col-xs-12 col-sm-3 ">
            <label>Data Documento</label>
            <div class="group-material">
              <input type="text" class="material-control text-center a" value="<?php echo date('d-m-Y', strtotime($dadosgeral1['dt_doc'])); ?>" name="dt_doc" readonly>     
            </div>
          </div>
           <!--<div class="col-xs-12 col-sm-2 ">
            <label>RG Conferente</label>
            <div class="group-material">
              <input type="text" class="material-control text-center a"  name="conferente" >     
            </div>
          </div> -->            
        </div>
        <div id="msg"><?php echo $_SESSION['msg']; unset($_SESSION['msg']);?></div> 
        <div class="table-responsive">
          <h3 class="all-tittles text-center"><?php echo "RESERVA Nº ".$pedido; ?></h3> 
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
            <div class="col-lg- col-md-12 col-md-12  text-center" >
              <div class="table-responsive">
                <div class="div-table" > 
                  <div class="div-table-row div-table-row-list " style="background-color:#DFF0D8; font-weight:bold;">   
                    <div class="div-table-cell" style="width: 50%" >
                      MATERIAL
                    </div>
                    <div class="div-table-cell" style="width: 10%">
                      Quantidade
                    </div>
                    <div class="div-table-cell" style="width: 10%" >
                      Valor
                    </div>
                    <div class="div-table-cell" style="width: 15%">
                      Valor total
                    </div>
                    <div class="div-table-cell" style="width: 15%"> 
                      N° Documento
                    </div>
                  </div>  
                </div>
                <div >
                <ul id="itemContainer" class="list-unstyled">
              <?php  $querypedidos=Materiais::getReserva($pedido);
                while ($saidastotal = mysqli_fetch_assoc($querypedidos)){?>
                    <li>
                      <div class="table-responsive">
                        <div class="div-table" style="margin:0 !important;"> 
                          <div class="div-table-row div-table-row-list" > 
                            <div class="div-table-cell "  style="width: 50%">
                              <input type="text" class="form-control text-center a" value="<?php echo mb_strimwidth($saidastotal['descricao'],0,60, "...") ?>"  id="desc" readonly>
                              <input type="hidden"  name="idmaterial[]" value="<?php echo $saidastotal['id_material_saida']; ?>" >
                            </div> 
                            <div class="div-table-cell" style="width: 10%" >
                              <input  class="form-control text-center a" value="<?php echo $saidastotal['qnt_saida']; ?>" name="qnt[]"  type="text" readonly>
                            </div>
                            <div class="div-table-cell" style="width: 10%" >
                              <input class="form-control text-center a"  value="<?php echo $saidastotal['valor_individual']; ?>" name="vl_individual[]"  type="text" readonly>
                            </div>
                            <div class="div-table-cell " style="width: 15%; ">
                              <input class="form-control text-center a"  type="number" value="<?php echo $saidastotal['val_total']; ?>"  name="vl_total[]" readonly> 
                            </div>
                            <input value="<?php echo $saidastotal['tipo_doc']; ?>" name="tipo_doc[]"  type="hidden" >
                            <div class="div-table-cell" style="width: 15%"> 
                              <input type="text" class="form-control text-center a"  value="<?php echo $saidastotal['documento'] ?>" name="documento[]" readonly>
                            </div>
                            <div class="div-table-cell" >
                              <input class="form-control text-center"   value="<?php echo $saidastotal['dt_doc']; ?>" name="dt_doc[]"  type="hidden" >
                              <input class="form-control text-center"   value="<?php echo $saidastotal['id_entrada']; ?>" name="id_entrada[]"  type="hidden" >
                            </div>
                          </div>  
                        </div> 
                      </div>  
                    </li>
<?php } ?>
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
            <?php
             if (!empty($_SESSION['rgretirada']) and $dadosgeral1['status']==1) {
             ?>
            <button type="submit" name="enviar" id="btn_enviar" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i> &nbsp;&nbsp; Gerar Modelo 60</button>
          <?php }?>
          </p> 
        </div>
      </form>
      <?php if ($dadosgeral1['status']==1) { ?>
      <p class="text-center"><button class="btn btn-danger" title="Clique se deseja Excluír." data-toggle="modal" data-target="#excluir"  onclick="excluir('<?php echo $pedido; ?>')"><i class="glyphicon glyphicon-remove-sign"></i> &nbsp;&nbsp; Cancelar Reserva</button></p><?php } ?>
      </div>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="modalExemplo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title text-center" >Saídas</h1>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="saidas" >
        <div class="table-responsive" >
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
            while ($saidastotal = mysqli_fetch_assoc($qrysaida)){
            $style  = $saidastotal['status']==2?'text-decoration: line-through;':''; ?>
          <ul id="itemContainer" class="list-unstyled">
            <li>
              <div class="table-responsive">
                <div class="div-table" style="margin:0 !important;<?php echo $style; ?>" >
                  <div class="div-table-row div-table-row-list">
                    <div class="div-table-cell" style="width: 15%;"><b><?php echo date('d-m-Y', strtotime($saidastotal['data_saida']));?></b></div>
                    <div class="div-table-cell" style="width: 5%;"><b><?php echo $saidastotal['documento'];?></b></div>
                    <div class="div-table-cell" style="width: 30%;" title="<?php echo $saidastotal['descricao']; ?>"><b><?php echo mb_strimwidth($saidastotal['descricao'], 0, 40, "...");?></b></div>
                    <div class="div-table-cell" style="width: 10%;"><b><?php echo $saidastotal['qnt_saida'];?></b></div>
                    <div class="div-table-cell" style="width: 10%;"><b><?php echo $saidastotal['user_saida'];?></b></div>
                    <div class="div-table-cell" style="width: 5%;">
                    <?php
                    if ($saidastotal['status']==1) {//Pendente de confirmaçao
                      echo '<button class="btn  tooltips-general" title="Aguardando confirmaçao de recebimento da unidade de destino!" style="color:#FCC900"><i class="glyphicon glyphicon-exclamation-sign"></i></button>';
                    } ;
                    if ($saidastotal['status']==3) {//Confirmado
                      echo '<button class="btn  tooltips-general" title="Confirmado recebimento por '.$saidastotal['rg_status'].'..." style="color:#298A08"><i class="glyphicon glyphicon-ok-sign"></i></button>';
                    } ;
                    ?>
                    </div>
                    <div class="div-table-cell " style="width: 10%;"><a  href="modelo60.php?id=<?php echo $saidastotal['m60'];?>" target="_blank"><button  class="btn btn-primary  tooltips-general" type="button" title="<?php
                    if ($saidastotal['status']==2) {
                      echo 'Exclída por '.$saidastotal['rg_status'].'&nbsp;&nbsp;Obs:&nbsp;'.$saidastotal['obs'];
                    }
                     ?>" ></><?php echo $saidastotal['m60'];?></button></a></div>
                  </div>
                </div>
              </div>
            </li>
          </ul><div class="holder"></div>
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

<div class="modal fade" id="modalRg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="POST" action="distribuir_pedido.php?id=<?php echo $pedido; ?>">
        <div class="modal-header text-center">
          <h1 class="modal-title a" id="exampleModalLabel">Digite o Rg do Policial que fará a retirada</h1>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label"></label>
            <input type="text" class="form-control a" id="rgretirada" name="rgretirada" autofocus="true" placeholder="Digite o RG" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="subimit" class="btn btn-primary">Consultar</button>
        </div>
      </form>
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
        <form method="POST" action="">
          <div class="container-fluid text-center" >
              <div class="col-xs-12 col-sm-12 a">
                <label>DESEJA CANCELAR ESSA RESERVA?</label><BR> 
                <label>Informe abaixo o Motivo.</label><BR>
                <textarea name="obs" style="width: 100%" required></textarea> 
                <input type="hidden" id="nreserva" name="reserva"> 
              </div>
          </div>
      </div>
        <div class="modal-footer">
          <p align="center">
          <button type="button" class="btn btn-primary" data-dismiss="modal"><b>X</b> &nbsp;&nbsp;Cancelar</button>
          <button type="submit"  class="btn btn-danger" name="excluir" title="excluir Registro"><i class="glyphicon glyphicon glyphicon-trash"></i> &nbsp;&nbsp; EXCLUIR</button>
          </p>
        </div>
        </form>  
    </div>
</div>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <style>
      select{font: 15px arial, sans-serif;}
    </style>
  </body>
</html>