<?php
include './inc/links.php';
include 'class/mod60Opm.class.php';
include 'class/dadossispes.class.php';

session_start();
$mod60 = $_GET['id'];
$sqlgeral     = modelo60::listaMateriais($mod60);

$dadosgeral1   = mysqli_fetch_assoc($sqlgeral);

$user       = $dadosgeral1['user_saida'];
$rgretira     = $dadosgeral1['rg_retirada'];
$rgconferente   = $dadosgeral1['rg_conferente'];

$dadospm     = DadosSispes::buscaDadosPm($rgretira);
$dadosuser     = DadosSispes::buscaDadosPm($user);
$pmconferente  = DadosSispes::buscaDadosPm($rgconferente);

/*
 	$dadosuser['nome_escala']='barbosa';
 	$dadosuser['gh']='cel';

 	$dadospm['nome_escala'] ='barbosa2';
 	$dadospm['gh']='cb';
 	$dadospm['rg']='100181';

 	$pmconferente['nome_escala']='Jeremias';
 	$pmconferente['gh']='CB';
 */

if (isset($_POST['excluir'])) {
  $obs = strtoupper($_POST['obs']);

  if (modelo60::excluirmod60($mod60, $obs)) {
    echo '<script type="text/javascript"> window.location="modelo60.php?id=' . $mod60 . '"; </script>';
  }
}
?>
<html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns:m="http://schemas.microsoft.com/office/2004/12/omml" xmlns="http://www.w3.org/TR/REC-html40">

<head>
  <meta http-equiv=Content-Type content="text/html; charset=windows-1252">
  <meta name=ProgId content=Word.Document>
  <meta name=Generator content="Microsoft Word 12">
  <meta name=Originator content="Microsoft Word 12">
  <title>Modelo 60</title>
  <link rel=File-List href="">
  <link rel=themeData href="">
  <link rel=colorSchemeMapping href="">
  <link rel="stylesheet" type="text/css" href="css/dasboardinicial.css" />


  <style media="print">
    /* Para deixar o botão invisível na hora da impressão */
    .botao {
      display: none;
    }
  </style>

</head>

<body lang=PT-BR style='tab-interval:35.45pt'>

  <script type="text/javascript">
    function editar(idfuncional, nome, autorizador) {
      $("#nomeinput").val(nome.toUpperCase() + "\n ID " + idfuncional);
      $("#nomeinput2").val(nome.toUpperCase() + " ID " + idfuncional);
      $("#inputautorizador").val(autorizador.toUpperCase());
      $("#inputautorizador2").val(autorizador.toUpperCase());
      $('#modalExemplo').modal('hide');
    }
  </script>

  <div class=WordSection1>

    <p class=Standard align=center style='text-align:center'><b><span style='font-size:10.0pt;mso-bidi-font-size:8.0pt;font-family:"Calibri","sans-serif"'>SERVIÇO<span style='mso-spacerun:yes'>     </span>PÚBLICO<span style='mso-spacerun:yes'>    
          </span>ESTADUAL<o:p></o:p></span></b></p>

    <p align="center">

    <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 width=680 style='margin-left:2.25pt;border-collapse:collapse;mso-table-layout-alt:fixed;
 mso-yfti-tbllook:1184;mso-padding-alt:0cm .5pt 0cm .5pt'>
      <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes'>
        <td width=132 colspan=2 valign=top style='width:99.2pt;border-top:solid black 1.0pt;
  border-left:solid black 1.0pt;border-bottom:none;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>AUTORIZO<o:p></o:p></span></b></p>
        </td>
        <td width=412 colspan=4 valign=top style='width:308.85pt;border-top:solid black 1.0pt;
  border-left:solid black 1.0pt;border-bottom:none;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>SOLICITAÇÃO DE
                MATERIAL Nº</span></b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
              <?php echo $dadosgeral1['m60']; //.'&nbsp;&nbsp;&nbsp;&nbsp;'.$_SESSION['tipo']; 
              ?><o:p></o:p></span></p>
        </td>
        <td width=136 colspan=2 valign=top style='width:102.25pt;border:solid black 1.0pt;
  border-bottom:none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>VISTO<o:p></o:p></span></p>
        </td>
      </tr>
      <tr style='mso-yfti-irow:1'>
        <td width=132 colspan=2 valign=top style='width:99.2pt;border-top:none;
  border-left:solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:
  none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
              <o:p>&nbsp;</o:p>
            </span></p>
          <p class=TableContents align=center style='text-align:center'><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>______________________<o:p></o:p></span></p>
        </td>
        <td width=412 colspan=4 valign=top style='width:308.85pt;border-top:none;
  border-left:solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:
  none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents style='tab-stops:8.5pt'><span style='font-size:8.0pt;
  font-family:"Calibri","sans-serif"'><span style='mso-tab-count:1'>      </span>DO:
              <span style='mso-tab-count:1'>        </span><span style='mso-tab-count:
  5'><?php echo $dadosgeral1['abrev_opm']; ?>                                                                                                      </span>
              <o:p></o:p>
            </span></p>
          <p class=TableContents style='tab-stops:8.5pt'><span style='font-size:8.0pt;
  font-family:"Calibri","sans-serif"'><span style='mso-tab-count:1'>      </span>AO:<span style='mso-tab-count:1'>          </span><?php echo $dadosgeral1['abrev_opm']; ?></o:p></span></p>
        </td>
        <td width=136 colspan=2 valign=top style='width:102.25pt;border:solid black 1.0pt;
  border-top:none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
              <o:p>&nbsp;</o:p>
            </span></p>
          <p class=TableContents align=center style='text-align:center'><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><?php echo utf8_encode($dadosuser['gh']) . ' ' . utf8_encode($dadosuser['nome_escala']); ?><o:p></o:p></span></p>
        </td>
      </tr>
      <tr style='mso-yfti-irow:2'>
        <td width=57 rowspan=2 style='width:42.6pt;border-top:none;border-left:solid black 1.0pt;
  border-bottom:solid black 1.0pt;border-right:none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>Nº ORDEM<o:p></o:p></span></b></p>
        </td>
        <td width=344 colspan=2 rowspan=2 style='width:257.75pt;border-top:none;
  border-left:solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:
  none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>Especificação<o:p></o:p></span></b></p>
          <p class=TableContents align=center style='text-align:center'><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>(ORDEM ALFABÉTICA)<o:p></o:p></span></b></p>
        </td>
        <td width=49 rowspan=2 style='width:36.8pt;border-top:none;border-left:solid black 1.0pt;
  border-bottom:solid black 1.0pt;border-right:none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>UNI-<o:p></o:p></span></b></p>
          <p class=TableContents align=center style='text-align:center'><span class=SpellE><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>DADE</span></b></span><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
                <o:p></o:p>
              </span></b></p>
        </td>
        <td width=134 colspan=3 style='width:100.25pt;border-top:none;border-left:
  solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>QUANT.<o:p></o:p></span></b></p>
        </td>
        <td width=97 rowspan=2 style='width:72.9pt;border:solid black 1.0pt;
  border-top:none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>OBSERVAÇÃO<o:p></o:p></span></b></p>
        </td>
      </tr>
      <tr style='mso-yfti-irow:3'>
        <td width=50 valign=top style='width:37.15pt;border-top:none;border-left:
  solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><span class=SpellE><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>EXIS</span></b></span><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>-<o:p></o:p></span></b></p>
          <p class=TableContents align=center style='text-align:center'><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>TENTE<o:p></o:p></span></b></p>
        </td>
        <td width=45 valign=top style='width:33.75pt;border-top:none;border-left:
  solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>PE-<o:p></o:p></span></b></p>
          <p class=TableContents align=center style='text-align:center'><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>DIDA<o:p></o:p></span></b></p>
        </td>
        <td width=39 valign=top style='width:29.35pt;border-top:none;border-left:
  solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><span class=SpellE><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>ATEN</span></b></span><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>-<o:p></o:p></span></b></p>
          <p class=TableContents align=center style='text-align:center'><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>DIDA<o:p></o:p></span></b></p>
        </td>
      </tr>
      <tr style='mso-yfti-irow:4'>
        <td width=57 valign=top style='width:42.6pt;border-top:none;border-left:solid black 1.0pt;
  border-bottom:solid black 1.0pt;border-right:none;padding:2.75pt 2.75pt 2.75pt 2.75pt;text-align: center;'>
          <p class=TableContents align=center style='text-align:center'><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
              <o:p><?php
                    $sqlgeral = modelo60::listaMateriais($mod60);
                    $count = 1;
                    while ($dadosgeral = mysqli_fetch_array($sqlgeral)) {
                      echo $count . '<br>';
                      $count++;
                    } ?></o:p>
            </span></p>
          <?php for ($i = 0; $i < 20 - $count; $i++) { ?>
            <p class=TableContents align=center><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
                <o:p>&nbsp;</o:p>
              </span></p>
          <?php } ?>
        </td>
        <td width=344 colspan=2 valign=top style='width:257.75pt;border-top:none;
  border-left:solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:
  none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
              <o:p><?php
                    $sqldesc = modelo60::listaMateriais($mod60);
                    while ($dados = mysqli_fetch_array($sqldesc)) {
                      $style  = $dados['status'] == 2 ? 'text-decoration: line-through;' : '';
                      echo '<divi style="width:344px;text-align:center;' . $style . '">' . mb_strimwidth($dados['descricao'], 0, 60, "...") . '</div><br>';
                    } ?>
              </o:p>
            </span></p>
          <p class=TableContents align=center style='position: absolute;top:340px;text-align:center'><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
              <o:p>
              </o:p>
            </span></p>
        </td>
        <td width=49 valign=top style='width:36.8pt;border-top:none;border-left:solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
              <o:p><?php
                    $sqlmedida = modelo60::listaMateriais($mod60);
                    while ($dados = mysqli_fetch_array($sqlmedida)) {
                      echo $dados['unidade'] . '<br>';
                    } ?></o:p>
            </span></p>
        </td>
        <td width=50 valign=top style='width:37.15pt;border-top:none;border-left:
  solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
              <o:p><?php $sqlmedida = modelo60::listaMateriais($mod60);
                    while ($dados = mysqli_fetch_array($sqlmedida)) {
                      echo 'X<br>';
                    } ?></o:p>
            </span></p>
        </td>
        <td width=45 valign=top style='width:33.75pt;border-top:none;border-left:
  solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
              <o:p>&nbsp;</o:p>
            </span></p>
        </td>
        <td width=39 valign=top style='width:29.35pt;border-top:none;border-left:
  solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
              <o:p>
                <?php $sqlmedida = modelo60::listaMateriais($mod60);
                while ($dadosmedida = mysqli_fetch_array($sqlmedida)) {
                  echo $dadosmedida['qnt_saida'] . '<br>';
                } ?></o:p>
            </span></p>
        </td>
        <td width=97 valign=top style='width:72.9pt;border:solid black 1.0pt;
  border-top:none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
              <o:p><?php $sqlmedida = modelo60::listaMateriais($mod60);
                    while ($dadosmedida = mysqli_fetch_array($sqlmedida)) {
                      echo "R$  " . $dadosmedida['vl_unit'] . '<br>';
                    } ?></o:p>
            </span></p>
        </td>
      </tr>
      <tr style='mso-yfti-irow:5'>
        <td width=450 colspan=4 valign=top style='width:337.15pt;border-top:none;
  border-left:solid black 1.0pt;border-bottom:none;border-right:solid black 1.0pt;
  mso-border-top-alt:solid black 1.0pt;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents style='tab-stops:14.65pt'><span style='font-size:8.0pt;
  font-family:"Calibri","sans-serif"'><span style='mso-tab-count:1'>          </span>RECEBI
              OS ARTIGOS CONSTANTES DESTE PEDIDO<o:p></o:p></span></p>
        </td>
        <td width=231 colspan=4 valign=bottom style='width:173.15pt;border-top:none;
  border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  mso-border-bottom-alt:solid black .25pt;mso-border-right-alt:solid black 1.0pt;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents style='tab-stops:14.3pt'><span style='font-size:8.0pt;
  font-family:"Calibri","sans-serif"'><span style='mso-tab-count:1'>          </span>Niterói, <?php setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
                                                                                              echo strftime("%d de %B de %Y", strtotime($dadosgeral1['data_saida'])) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $dadosgeral1['hora']; ?><o:p></o:p></span></p>
        </td>
      </tr>
      <tr style='mso-yfti-irow:6'>
        <td width=450 colspan=4 valign=top style='width:337.15pt;border-top:none;
  border-left:solid black 1.0pt;border-bottom:none;border-right:solid black 1.0pt;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents style='tab-stops:13.65pt'><span style='font-size:8.0pt;
  font-family:"Calibri","sans-serif"'><span style='mso-tab-count:1'>         </span><span class=GramE>……..</span>………………..<span style='mso-tab-count:1'>         </span>_____________________________________________________<o:p></o:p></span></p>
        </td>
        <td width=231 colspan=4 valign=top style='width:173.15pt;border-top:none;
  border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  mso-border-left-alt:solid black 1.0pt;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><span style='font-size:7.0pt;mso-bidi-font-size:8.0pt;font-family:"Calibri","sans-serif"'>
              <o:p></o:p>
            </span></p>
        </td>
      </tr>
      <tr style='mso-yfti-irow:7;mso-yfti-lastrow:yes'>
        <td width=450 colspan=4 valign=top style='width:337.15pt;border:solid black 1.0pt;
  border-top:none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><span data-toggle="modal" data-target="#modalExemplo" data-dismiss="modal" style='font-size:9.0pt;font-family:"Calibri","sans-serif"'>
              <o:p></o:p>
            </span></p>
        </td>
        <td width=231 colspan=4 valign=top style='width:173.15pt;border-top:none;
  border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  mso-border-left-alt:solid black 1.0pt;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
              <o:p></o:p>
            </span></p>
        </td>
      </tr>
      <![if !supportMisalignedColumns]>
      <tr height=0>
        <td width=80 style='border:none'></td>
        <td width=75 style='border:none'></td>
        <td width=248 style='border:none'></td>
        <td width=49 style='border:none'></td>
        <td width=46 style='border:none'></td>
        <td width=42 style='border:none'></td>
        <td width=42 style='border:none'></td>
        <td width=97 style='border:none'></td>
      </tr>
      <![endif]>
    </table>
    <p align="center" class=Standard><span class=GramE><span style='font-size:8.0pt;font-family:
"Calibri","sans-serif"'>…………………………………………………………………………………………………………………………………………………………………………………………………………………………………………………….</span></span><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
        <o:p></o:p>
      </span></p>

    <p class=Standard><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
        <o:p>&nbsp;</o:p>
      </span></p>

    <p class=Standard align=center style='text-align:center'><b><span style='font-size:10.0pt;mso-bidi-font-size:8.0pt;font-family:"Calibri","sans-serif"'>SERVIÇO<span style='mso-spacerun:yes'>     </span>PÚBLICO<span style='mso-spacerun:yes'>    
          </span>ESTADUAL<o:p></o:p></span></b></p>

    <p align="center">

    <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 width=680 style='margin-left:2.25pt;border-collapse:collapse;mso-table-layout-alt:fixed;
 mso-yfti-tbllook:1184;mso-padding-alt:0cm .5pt 0cm .5pt'>
      <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes'>
        <td width=132 colspan=2 valign=top style='width:99.2pt;border-top:solid black 1.0pt;
  border-left:solid black 1.0pt;border-bottom:none;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>AUTORIZO<o:p></o:p></span></b></p>
        </td>
        <td width=412 colspan=4 valign=top style='width:308.85pt;border-top:solid black 1.0pt;
  border-left:solid black 1.0pt;border-bottom:none;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>SOLICITAÇÃO DE
                MATERIAL Nº</span></b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
              <?php echo $dadosgeral1['m60'] . '&nbsp;&nbsp;&nbsp;&nbsp;' . $_SESSION['tipo']; ?><o:p></o:p></span></p>
        </td>
        <td width=136 colspan=2 valign=top style='width:102.25pt;border:solid black 1.0pt;
  border-bottom:none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>VISTO<o:p></o:p></span></p>
        </td>
      </tr>
      <tr style='mso-yfti-irow:1'>
        <td width=132 colspan=2 valign=top style='width:99.2pt;border-top:none;
  border-left:solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:
  none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
              <o:p>&nbsp;</o:p>
            </span></p>
          <p class=TableContents align=center style='text-align:center'><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>______________________<o:p></o:p></span></p>
        </td>
        <td width=412 colspan=4 valign=top style='width:308.85pt;border-top:none;
  border-left:solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:
  none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents style='tab-stops:8.5pt'><span style='font-size:8.0pt;
  font-family:"Calibri","sans-serif"'><span style='mso-tab-count:1'>      </span>DO:
              <span style='mso-tab-count:1'>        </span><span style='mso-tab-count:
  5'><?php echo $dadosgeral1['abrev_opm']; ?>                                                                                                      </span>
              <o:p></o:p>
            </span></p>
          <p class=TableContents style='tab-stops:8.5pt'><span style='font-size:8.0pt;
  font-family:"Calibri","sans-serif"'><span style='mso-tab-count:1'>      </span>AO:<span style='mso-tab-count:1'>          </span><?php echo $dadosgeral1['abrev_opm']; ?></span>
            <o:p></o:p></span>
          </p>
        </td>
        <td width=136 colspan=2 valign=top style='width:102.25pt;border:solid black 1.0pt;
  border-top:none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
              <o:p>&nbsp;</o:p>
            </span></p>
          <p class=TableContents align=center style='text-align:center'><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><?php echo utf8_encode($dadosuser['gh']) . ' ' . utf8_encode($dadosuser['nome_escala']); ?><o:p></o:p></span></p>
        </td>
      </tr>
      <tr style='mso-yfti-irow:2'>
        <td width=57 rowspan=2 style='width:42.6pt;border-top:none;border-left:solid black 1.0pt;
  border-bottom:solid black 1.0pt;border-right:none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>Nº ORDEM<o:p></o:p></span></b></p>
        </td>
        <td width=344 colspan=2 rowspan=2 style='width:257.75pt;border-top:none;
  border-left:solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:
  none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>Especificação<o:p></o:p></span></b></p>
          <p class=TableContents align=center style='text-align:center'><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>(ORDEM ALFABÉTICA)<o:p></o:p></span></b></p>
        </td>
        <td width=49 rowspan=2 style='width:36.8pt;border-top:none;border-left:solid black 1.0pt;
  border-bottom:solid black 1.0pt;border-right:none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>UNI-<o:p></o:p></span></b></p>
          <p class=TableContents align=center style='text-align:center'><span class=SpellE><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>DADE</span></b></span><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
                <o:p></o:p>
              </span></b></p>
        </td>
        <td width=134 colspan=3 style='width:100.25pt;border-top:none;border-left:
  solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>QUANT.<o:p></o:p></span></b></p>
        </td>
        <td width=97 rowspan=2 style='width:72.9pt;border:solid black 1.0pt;
  border-top:none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>OBSERVAÇÃO<o:p></o:p></span></b></p>
        </td>
      </tr>
      <tr style='mso-yfti-irow:3'>
        <td width=50 valign=top style='width:37.15pt;border-top:none;border-left:
  solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><span class=SpellE><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>EXIS</span></b></span><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>-<o:p></o:p></span></b></p>
          <p class=TableContents align=center style='text-align:center'><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>TENTE<o:p></o:p></span></b></p>
        </td>
        <td width=45 valign=top style='width:33.75pt;border-top:none;border-left:
  solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>PE-<o:p></o:p></span></b></p>
          <p class=TableContents align=center style='text-align:center'><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>DIDA<o:p></o:p></span></b></p>
        </td>
        <td width=39 valign=top style='width:29.35pt;border-top:none;border-left:
  solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><span class=SpellE><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>ATEN</span></b></span><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>-<o:p></o:p></span></b></p>
          <p class=TableContents align=center style='text-align:center'><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>DIDA<o:p></o:p></span></b></p>
        </td>
      </tr>
      <tr style='mso-yfti-irow:4'>
        <td width=57 valign=top style='width:42.6pt;border-top:none;border-left:solid black 1.0pt;
  border-bottom:solid black 1.0pt;border-right:none;padding:2.75pt 2.75pt 2.75pt 2.75pt;text-align: center;'>
          <p class=TableContents align=center style='text-align:center'><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
              <o:p><?php
                    $sqlgeral = modelo60::listaMateriais($mod60);
                    $count = 1;
                    while ($dadosgeral = mysqli_fetch_array($sqlgeral)) {
                      echo $count . '<br>';
                      $count++;
                    } ?></o:p>
            </span></p>
          <?php for ($i = 0; $i < 20 - $count; $i++) { ?>
            <p class=TableContents align=center><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
                <o:p>&nbsp;</o:p>
              </span></p>
          <?php } ?>
        </td>
        </td>
        <td width=344 colspan=2 valign=top style='width:257.75pt;border-top:none;
  border-left:solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:
  none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
              <o:p><?php
                    $sqldesc = modelo60::listaMateriais($mod60);
                    while ($dados = mysqli_fetch_array($sqldesc)) {
                      $style  = $dados['status'] == 2 ? 'text-decoration: line-through;' : '';
                      echo '<divi style="width:344px;text-align:center;' . $style . '">' . mb_strimwidth($dados['descricao'], 0, 60, "...") . '</div><br>';
                    } ?>
              </o:p>
            </span></p>
          <p class=TableContents align=center style='position: absolute;top:820px;text-align:center'><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
              <o:p></o:p>
            </span></p>
        </td>
        <td width=49 valign=top style='width:36.8pt;border-top:none;border-left:solid black 1.0pt;
  border-bottom:solid black 1.0pt;border-right:none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
              <o:p><?php
                    $sqlmedida = modelo60::listaMateriais($mod60);
                    while ($dados = mysqli_fetch_array($sqlmedida)) {
                      echo $dados['unidade'] . '<br>';
                    } ?></o:p>
            </span></p>
        </td>
        <td width=50 valign=top style='width:37.15pt;border-top:none;border-left:
  solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
              <o:p><?php $sqlmedida = modelo60::listaMateriais($mod60);
                    while ($dados = mysqli_fetch_array($sqlmedida)) {
                      //echo $dados['ult_estoque'].'<br>';
                      echo 'X<br>';
                    } ?></o:p>
            </span></p>
        </td>
        <td width=45 valign=top style='width:33.75pt;border-top:none;border-left:
  solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
              <o:p>&nbsp;</o:p>
            </span></p>
        </td>
        <td width=39 valign=top style='width:29.35pt;border-top:none;border-left:
  solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
              <o:p>
                <?php $sqlmedida = modelo60::listaMateriais($mod60);
                while ($dadosmedida = mysqli_fetch_array($sqlmedida)) {
                  echo $dadosmedida['qnt_saida'] . '<br>';
                } ?></o:p>
            </span></p>
        </td>
        <td width=97 valign=top style='width:72.9pt;border:solid black 1.0pt;
  border-top:none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
              <o:p><?php $sqlmedida = modelo60::listaMateriais($mod60);
                    while ($dadosmedida = mysqli_fetch_array($sqlmedida)) {
                      echo "R$  " . $dadosmedida['vl_unit'] . '<br>';
                    } ?></o:p>
            </span></p>
        </td>
      </tr>
      <tr style='mso-yfti-irow:5'>
        <td width=450 colspan=4 valign=top style='width:337.15pt;border-top:none;
  border-left:solid black 1.0pt;border-bottom:none;border-right:solid black 1.0pt;
  mso-border-top-alt:solid black 1.0pt;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents style='tab-stops:14.65pt'><span style='font-size:8.0pt;
  font-family:"Calibri","sans-serif"'><span style='mso-tab-count:1'>          </span>RECEBI
              OS ARTIGOS CONSTANTES DESTE PEDIDO<o:p></o:p></span></p>
        </td>
        <td width=231 colspan=4 valign=bottom style='width:173.15pt;border-top:none;
  border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  mso-border-bottom-alt:solid black .25pt;mso-border-right-alt:solid black 1.0pt;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents style='tab-stops:14.3pt'><span style='font-size:8.0pt;
  font-family:"Calibri","sans-serif"'><span style='mso-tab-count:1'>          </span>Niterói,<?php setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
                                                                                              echo ucfirst(strftime("%d de %B de %Y", strtotime($dadosgeral1['data_saida']))); ?><o:p></o:p></span></p>
        </td>
      </tr>
      <tr style='mso-yfti-irow:6'>
        <td width=450 colspan=4 valign=top style='width:337.15pt;border-top:none;
  border-left:solid black 1.0pt;border-bottom:none;border-right:solid black 1.0pt;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents style='tab-stops:13.65pt'><span style='font-size:8.0pt;
  font-family:"Calibri","sans-serif"'><span style='mso-tab-count:1'>         </span><span class=GramE>……..</span>………………..<span style='mso-tab-count:1'>         </span>_____________________________________________________<o:p></o:p></span></p>

        </td>
        <td width=231 colspan=4 valign=top style='width:173.15pt;border-top:none;
  border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  mso-border-left-alt:solid black 1.0pt;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><span style='font-size:7.0pt;mso-bidi-font-size:8.0pt;font-family:"Calibri","sans-serif"'>
              <o:p></o:p>
            </span></p>
        </td>
      </tr>
      <tr style='mso-yfti-irow:7;mso-yfti-lastrow:yes'>
        <td width=450 colspan=4 valign=top style='width:337.15pt;border:solid black 1.0pt;
  border-top:none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><span style='mso-tab-count:1'></span><span class=GramE></span><span style='mso-tab-count:1'></span><span data-toggle="modal" data-target="#modalExemplo" data-dismiss="modal" style='font-size:9.0pt;font-family:"Calibri","sans-serif"'>
              <o:p></o:p>
            </span></p>
        </td>
        <td width=231 colspan=4 valign=top style='width:173.15pt;border-top:none;
  border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  mso-border-left-alt:solid black 1.0pt;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
          <p class=TableContents align=center style='text-align:center'><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
              <o:p></o:p>
            </span></p>
        </td>
      </tr>
      <![if !supportMisalignedColumns]>
      <tr height=0>
        <td width=80 style='border:none'></td>
        <td width=75 style='border:none'></td>
        <td width=248 style='border:none'></td>
        <td width=49 style='border:none'></td>
        <td width=46 style='border:none'></td>
        <td width=42 style='border:none'></td>
        <td width=42 style='border:none'></td>
        <td width=97 style='border:none'></td>
      </tr>
      <![endif]>
    </table>
    <br><br>
    <div id="noprint">
      <p align="center">
        <?php


        if ($dadosgeral1['status'] == 2) {
          $disabled = "disabled";
          $status = 'title="Excluido pelo usuário : ' . $_SESSION["UserRG"] . '"';
        }

        ?>
        <button type="button" class="btn btn-danger" <?php echo $disabled; ?> data-toggle="modal" data-target="#excluir" data-dismiss="modal"><i class="glyphicon glyphicon-trash"></i></button>

        <button onclick="self.print()" id="btn_imprime" class="btn btn-primary" alt="Imprimir"><i class="glyphicon glyphicon-print"></i>&nbsp;</button>
      </p>
    </div>
    <p class=Standard><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
        <o:p>&nbsp;</o:p>
      </span></p>
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
          <form method="post" action="?id=<?php echo $mod60; ?>">
            <div class="container-fluid text-center">
              <div class="col-xs-12 col-sm-12 a">
                <label>DESEJA REALMENTE EXCLUIR ESTE DOCUMENTO?</label><BR>
                <label>TODOS OS ITENS SERÃO EXCUIDOS.</label>
                <label>Informe abaixo o Motivo.</label><BR>
                <textarea name="obs" style="width: 100%" required></textarea>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <p align="center">
            <button type="button" class="btn btn-primary" data-dismiss="modal"><b>X</b> &nbsp;&nbsp;Cancelar</button>

            <button type="submit" class="btn btn-danger" name="excluir" title="excluir Modelo60"><i class="glyphicon glyphicon glyphicon-trash"></i> &nbsp;&nbsp; EXCLUIR</button>
          </p>
        </div>
        </form>
      </div>
    </div>

    <style>
      @media print {
        #noprint {
          display: none;
        }
      }

      .a {
        font: bold 18px arial, sans-serif;
      }
    </style>
</body>

</html>