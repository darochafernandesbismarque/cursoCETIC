<?php
session_start();
include "../library/tipo_entrada_material.php";
include "../library/entradamaterialadiantamentofinanceiro.php";
include "../library/entradamaterialtransferenciafinanceira.php";
include "../library/entradamateriallicitacao.php";

$_SESSION['nota_numero_rand'] = $_REQUEST['nota_numero_rand'];

if (isset($_REQUEST['enviarTipoDocumento'])) {

    $tipoentrada     = $_REQUEST['tipoentrada'];
    $fornecedor      = $_REQUEST['fornecedor'];
    $datadocumento   = $_REQUEST['datadocumento'];
    $tipodocumento   = $_REQUEST['tipodocumento'];
    $valortotal      = $_REQUEST['valortotal'];
    $id_usb          = 6;
    $dataentrada     = date("Y-m-d");

    $enviarTipoDocumento        = $_REQUEST['enviarTipoDocumento'];

    $id_adiantamentofinanceiro  = $_REQUEST['adiantamentofinanceiro'];
    $id_transferenciafinanceira = $_REQUEST['transferenciafinanceira'];
    $id_licitacao               = $_REQUEST['licitacao'];


    try {
        tipoentradamaterial::inserir($tipoentrada, $fornecedor, $datadocumento, $tipodocumento, $valortotal, $dataentrada, $id_usb);
        echo "<meta http-equiv='refresh' content='0;URL=../entrada_material_item.php'>";

    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        exit;
    }
  
    
    $ultimoID = tipoentradamaterial::consultar("SELECT id from entradamaterial ORDER BY id DESC LIMIT 1");
      foreach($ultimoID as $id){
      $id_entradamaterial =  $id['id'];
    }

    if(isset($_REQUEST['enviarTipoDocumento']) AND $_REQUEST['enviarTipoDocumento'] == 'adiantamentofinanceiro'){
      
      try {
        entradamaterialadiantamentofinanceiro::inserir($id_entradamaterial, $id_adiantamentofinanceiro);
        echo "<meta http-equiv='refresh' content='0;URL=../entrada_material_item.php'>";
      } catch (PDOException $e) {
          echo "Erro" . $e->getMessage();
          exit;
      }
    } 


    if(isset($_REQUEST['enviarTipoDocumento']) AND $_REQUEST['enviarTipoDocumento'] == 'transferenciafinanceira'){
       
      try {
        entradamaterialtransferenciafinanceira::inserir($id_entradamaterial, $id_transferenciafinanceira);
        echo "<meta http-equiv='refresh' content='0;URL=../entrada_material_item.php'>";
      } catch (PDOException $e) {
          echo "Erro" . $e->getMessage();
          exit;
      }
    }  


    if(isset($_REQUEST['enviarTipoDocumento']) AND $_REQUEST['enviarTipoDocumento'] == 'licitacao'){
       
      try {
        entradamateriallicitacao::inserir($id_entradamaterial, $id_licitacao);
        echo "<meta http-equiv='refresh' content='0;URL=../entrada_material_item.php'>";
      } catch (PDOException $e) {
          echo "Erro" . $e->getMessage();
          exit;
      }
    } 

} 