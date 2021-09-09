<?php 

	include './inc/links.php';
	include 'class/mod60.class.php'; 
	session_start();
	$mod60 =$_GET['id'];

 	$sqlgeral= modelo60::listaMateriais($mod60); 
 	$dadosgeral1 = mysqli_fetch_array($sqlgeral);
 	
 	$user = $dadosgeral1['user_saida'];
 	$rgretira = $dadosgeral1['rg_retirada'];

 	$dadospm = buscaDadosPm($rgretira);
 //	$dadospm['nome']='wallace barbosa';
 	$dadospm['rg']='100181';
	$dadosuser = buscaDadosPm($user);
 	//$dadosuser['nome_escala']='Barbosa';
 	//$dadosuser['gh']='CB';
 
 	function buscaDadosPm($rg){
/*Conecta no banco sispes e busca os dados do policial na view*/
    $conexaosispes =mysqli_connect(SERVER,USER,PASS,BD_) or trigger_error(mysqli_error(),E_USER_ERROR);
 
      $sqll = "SELECT * FROM vw_sismatbel where rg = '$rg'" ;
      $result = mysqli_query($conexaosispes,$sqll) or die("Erro no banco de dados!"); 
      return mysqli_fetch_array($result);       
    }     

 	if(isset($_POST['excluir'])){
 		$obs = strtoupper($_POST['obs']);
/*Lista id e quantidade dos materiais do documento*/
	   	 $rs=modelo60::listaQnt($mod60);
	    while ($result = mysqli_fetch_array($rs)){
	    	$tabela = 'saida';
	    	$condicion="m60='$mod60'"; 
	    	$campos	= "status=2,obs='$obs',rg_status=".$_SESSION['UserRG'];
/*Muda o status da saida*/
	        if($retorno = consultasSQL::UpdateSQL($tabela, $campos, $condicion)){  
	        	$qnt 			= $result['qnt_saida'];
	    		$id_material 	= $result['id_material_saida'];
	    		$opm        	= $result['opm'];
	    		$id_entrada     = $result['id_entrada'];
	    		
	    		$est_ent       =  mysqli_fetch_array(ejecutarSQL::consultar("SELECT qnt_atual FROM entrada  where id_entrada='$id_entrada'"))[0];

	    		$qntfinal 		= $est_ent + $qnt;
	    		$tabela    		= "entrada";
	    		$campos 		= "qnt_atual='$qntfinal'";
	    		$condicion      = "id_entrada='$id_entrada'"; 
/*Aumenta o estoque do material */	    		
	    		$retorno2 		= consultasSQL::UpdateSQL($tabela, $campos, $condicion);
	        } 	
	    } 
	    echo '<script type="text/javascript"> window.location="modelo60.php?id='.$mod60.'"; </script>';
    }    
?>
<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:w="urn:schemas-microsoft-com:office:word"
xmlns:m="http://schemas.microsoft.com/office/2004/12/omml"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Word.Document>
<meta name=Generator content="Microsoft Word 12">
<meta name=Originator content="Microsoft Word 12">
 <title>Modelo 60</title> 
<link rel=File-List href="">
<link rel=themeData href="">
<link rel=colorSchemeMapping
href="">

<style>
<!--
 @font-face
	{font-family:Mangal;
	panose-1:2 4 5 3 5 2 3 3 2 2;
	mso-font-charset:0;
	mso-generic-font-family:roman;
	mso-font-pitch:variable;
	mso-font-signature:32771 0 0 0 1 0;}
@font-face
	{font-family:"Cambria Math";
	panose-1:2 4 5 3 5 4 6 3 2 4;
	mso-font-charset:0;
	mso-generic-font-family:roman;
	mso-font-pitch:variable;
	mso-font-signature:-1610611985 1107304683 0 0 159 0;}
@font-face
	{font-family:Calibri;
	panose-1:2 15 5 2 2 2 4 3 2 4;
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:-1610611985 1073750139 0 0 159 0;}
@font-face
	{font-family:"Microsoft YaHei";
	panose-1:2 11 5 3 2 2 4 2 2 4;
	mso-font-charset:134;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:-2147483001 672087122 22 0 262175 0;}
@font-face
	{font-family:"\@Microsoft YaHei";
	panose-1:2 11 5 3 2 2 4 2 2 4;
	mso-font-charset:134;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:-2147483001 672087122 22 0 262175 0;}
@font-face
	{font-family:NSimSun;
	panose-1:2 1 6 9 3 1 1 1 1 1;
	mso-font-charset:134;
	mso-generic-font-family:modern;
	mso-font-pitch:fixed;
	mso-font-signature:3 680460288 22 0 262145 0;}
@font-face
	{font-family:"\@NSimSun";
	panose-1:2 1 6 9 3 1 1 1 1 1;
	mso-font-charset:134;
	mso-generic-font-family:modern;
	mso-font-pitch:fixed;
	mso-font-signature:3 680460288 22 0 262145 0;}
@font-face
	{font-family:"Liberation Serif";
	mso-font-alt:"Times New Roman";
	mso-font-charset:0;
	mso-generic-font-family:roman;
	mso-font-pitch:variable;
	mso-font-signature:0 0 0 0 0 0;}
@font-face
	{font-family:"Liberation Sans";
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:0 0 0 0 0 0;}

 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-parent:"";
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	mso-hyphenate:none;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Liberation Serif","serif";
	mso-fareast-font-family:NSimSun;
	mso-bidi-font-family:Mangal;
	mso-font-kerning:1.5pt;
	mso-fareast-language:ZH-CN;
	mso-bidi-language:HI;}
p.MsoList, li.MsoList, div.MsoList
	{mso-style-unhide:no;
	mso-style-parent:"Text body";
	margin-top:0cm;
	margin-right:0cm;
	margin-bottom:7.0pt;
	margin-left:0cm;
	line-height:115%;
	mso-pagination:widow-orphan;
	mso-hyphenate:none;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Liberation Serif","serif";
	mso-fareast-font-family:NSimSun;
	mso-bidi-font-family:Mangal;
	mso-font-kerning:1.5pt;
	mso-fareast-language:ZH-CN;
	mso-bidi-language:HI;}
p.Standard, li.Standard, div.Standard
	{mso-style-name:Standard;
	mso-style-unhide:no;
	mso-style-parent:"";
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	mso-hyphenate:none;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Liberation Serif","serif";
	mso-fareast-font-family:NSimSun;
	mso-bidi-font-family:Mangal;
	mso-font-kerning:1.5pt;
	mso-fareast-language:ZH-CN;
	mso-bidi-language:HI;}
p.Heading, li.Heading, div.Heading
	{mso-style-name:Heading;
	mso-style-unhide:no;
	mso-style-parent:Standard;
	mso-style-next:"Text body";
	margin-top:12.0pt;
	margin-right:0cm;
	margin-bottom:6.0pt;
	margin-left:0cm;
	mso-pagination:widow-orphan;
	page-break-after:avoid;
	mso-hyphenate:none;
	text-autospace:ideograph-other;
	font-size:14.0pt;
	font-family:"Liberation Sans","sans-serif";
	mso-fareast-font-family:"Microsoft YaHei";
	mso-bidi-font-family:Mangal;
	mso-font-kerning:1.5pt;
	mso-fareast-language:ZH-CN;
	mso-bidi-language:HI;}
p.Textbody, li.Textbody, div.Textbody
	{mso-style-name:"Text body";
	mso-style-unhide:no;
	mso-style-parent:Standard;
	margin-top:0cm;
	margin-right:0cm;
	margin-bottom:7.0pt;
	margin-left:0cm;
	line-height:115%;
	mso-pagination:widow-orphan;
	mso-hyphenate:none;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Liberation Serif","serif";
	mso-fareast-font-family:NSimSun;
	mso-bidi-font-family:Mangal;
	mso-font-kerning:1.5pt;
	mso-fareast-language:ZH-CN;
	mso-bidi-language:HI;}
p.Caption, li.Caption, div.Caption
	{mso-style-name:Caption;
	mso-style-unhide:no;
	mso-style-parent:Standard;
	margin-top:6.0pt;
	margin-right:0cm;
	margin-bottom:6.0pt;
	margin-left:0cm;
	mso-pagination:widow-orphan no-line-numbers;
	mso-hyphenate:none;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Liberation Serif","serif";
	mso-fareast-font-family:NSimSun;
	mso-bidi-font-family:Mangal;
	mso-font-kerning:1.5pt;
	mso-fareast-language:ZH-CN;
	mso-bidi-language:HI;
	font-style:italic;}
p.Index, li.Index, div.Index
	{mso-style-name:Index;
	mso-style-unhide:no;
	mso-style-parent:Standard;
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan no-line-numbers;
	mso-hyphenate:none;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Liberation Serif","serif";
	mso-fareast-font-family:NSimSun;
	mso-bidi-font-family:Mangal;
	mso-font-kerning:1.5pt;
	mso-fareast-language:ZH-CN;
	mso-bidi-language:HI;}
p.TableContents, li.TableContents, div.TableContents
	{mso-style-name:"Table Contents";
	mso-style-unhide:no;
	mso-style-parent:Standard;
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan no-line-numbers;
	mso-hyphenate:none;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Liberation Serif","serif";
	mso-fareast-font-family:NSimSun;
	mso-bidi-font-family:Mangal;
	mso-font-kerning:1.5pt;
	mso-fareast-language:ZH-CN;
	mso-bidi-language:HI;}
span.SpellE
	{mso-style-name:"";
	mso-spl-e:yes;}
span.GramE
	{mso-style-name:"";
	mso-gram-e:yes;}
.MsoChpDefault
	{mso-style-type:export-only;
	mso-default-props:yes;
	font-size:12.0pt;
	mso-ansi-font-size:12.0pt;
	mso-bidi-font-size:12.0pt;
	mso-ascii-font-family:"Liberation Serif";
	mso-fareast-font-family:NSimSun;
	mso-hansi-font-family:"Liberation Serif";
	mso-bidi-font-family:Mangal;
	mso-font-kerning:1.5pt;
	mso-fareast-language:ZH-CN;
	mso-bidi-language:HI;}
.MsoPapDefault
	{mso-style-type:export-only;
	mso-hyphenate:none;
	text-autospace:ideograph-other;}
 /* Page Definitions */
 @page
	{mso-footnote-separator:url("") fs;
	mso-footnote-continuation-separator:url("") fcs;
	mso-endnote-separator:url("") es;
	mso-endnote-continuation-separator:url("") ecs;}
@page WordSection1
	{size:595.3pt 841.9pt;
	margin:42.5pt 42.5pt 42.5pt 42.5pt;
	mso-header-margin:36.0pt;
	mso-footer-margin:36.0pt;
	mso-paper-source:0;}
div.WordSection1
	{page:WordSection1;}
-->
</style>

<style media="print">
/* Para deixar o botão invisível na hora da impressão */
.botao {display: none;}
</style>

</head>

<body lang=PT-BR style='tab-interval:35.45pt'>

	<script type="text/javascript">
		function editar(idfuncional,nome,autorizador){
	        $("#nomeinput").val(nome.toUpperCase() +"\n ID "+idfuncional); 
	        $("#nomeinput2").val(nome.toUpperCase()+" ID "+idfuncional); 
	        $("#inputautorizador").val(autorizador.toUpperCase());
	        $("#inputautorizador2").val(autorizador.toUpperCase());
	        $('#modalExemplo').modal('hide');         
      } 
	</script>

<div class=WordSection1>

<p class=Standard align=center style='text-align:center'><b><span
style='font-size:10.0pt;mso-bidi-font-size:8.0pt;font-family:"Calibri","sans-serif"'>SERVIÇO<span
style='mso-spacerun:yes'>     </span>PÚBLICO<span style='mso-spacerun:yes'>    
</span>ESTADUAL<o:p></o:p></span></b></p>

<p align="center">

<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 width=680
 style='margin-left:2.25pt;border-collapse:collapse;mso-table-layout-alt:fixed;
 mso-yfti-tbllook:1184;mso-padding-alt:0cm .5pt 0cm .5pt'>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes'>
  <td width=132 colspan=2 valign=top style='width:99.2pt;border-top:solid black 1.0pt;
  border-left:solid black 1.0pt;border-bottom:none;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><b><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>AUTORIZO<o:p></o:p></span></b></p>
  </td>
  <td width=412 colspan=4 valign=top style='width:308.85pt;border-top:solid black 1.0pt;
  border-left:solid black 1.0pt;border-bottom:none;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><b><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>SOLICITAÇÃO DE
  MATERIAL Nº</span></b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
  <?php echo $dadosgeral1['m60'];//.'&nbsp;&nbsp;&nbsp;&nbsp;'.$_SESSION['tipo']; ?><o:p></o:p></span></p>
  </td>
  <td width=136 colspan=2 valign=top style='width:102.25pt;border:solid black 1.0pt;
  border-bottom:none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>VISTO<o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:1'>
  <td width=132 colspan=2 valign=top style='width:99.2pt;border-top:none;
  border-left:solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:
  none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><o:p>&nbsp;</o:p></span></p>
  <p class=TableContents align=center style='text-align:center'><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>______________________<o:p></o:p></span></p>
  </td>
  <td width=412 colspan=4 valign=top style='width:308.85pt;border-top:none;
  border-left:solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:
  none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents style='tab-stops:8.5pt'><span style='font-size:8.0pt;
  font-family:"Calibri","sans-serif"'><span style='mso-tab-count:1'>      </span>DO:
  <span style='mso-tab-count:1'>        </span><span style='mso-tab-count:
  5'><?php echo $dadosgeral1['abrev_opm']; ?>                                                                                                      </span><o:p></o:p></span></p>
  <p class=TableContents style='tab-stops:8.5pt'><span style='font-size:8.0pt;
  font-family:"Calibri","sans-serif"'><span style='mso-tab-count:1'>      </span>AO:<span
  style='mso-tab-count:1'>          </span>Chefe <span class=SpellE></span><span
  style='mso-tab-count:4'>DGO                                                                                     </span><o:p></o:p></span></p>
  </td>
  <td width=136 colspan=2 valign=top style='width:102.25pt;border:solid black 1.0pt;
  border-top:none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><o:p>&nbsp;</o:p></span></p>
  <p class=TableContents align=center style='text-align:center'><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><?php echo utf8_encode($dadosuser['gh']).' '. $dadosuser['nome_escala']; ?><o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:2'>
  <td width=57 rowspan=2 style='width:42.6pt;border-top:none;border-left:solid black 1.0pt;
  border-bottom:solid black 1.0pt;border-right:none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><b><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>Nº ORDEM<o:p></o:p></span></b></p>
  </td>
  <td width=344 colspan=2 rowspan=2 style='width:257.75pt;border-top:none;
  border-left:solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:
  none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><b><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>Especificação<o:p></o:p></span></b></p>
  <p class=TableContents align=center style='text-align:center'><b><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>(ORDEM ALFABÉTICA)<o:p></o:p></span></b></p>
  </td>
  <td width=49 rowspan=2 style='width:36.8pt;border-top:none;border-left:solid black 1.0pt;
  border-bottom:solid black 1.0pt;border-right:none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><b><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>UNI-<o:p></o:p></span></b></p>
  <p class=TableContents align=center style='text-align:center'><span
  class=SpellE><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>DADE</span></b></span><b><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><o:p></o:p></span></b></p>
  </td>
  <td width=134 colspan=3 style='width:100.25pt;border-top:none;border-left:
  solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><b><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>QUANT.<o:p></o:p></span></b></p>
  </td>
  <td width=97 rowspan=2 style='width:72.9pt;border:solid black 1.0pt;
  border-top:none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><b><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>OBSERVAÇÃO<o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:3'>
  <td width=50 valign=top style='width:37.15pt;border-top:none;border-left:
  solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><span
  class=SpellE><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>EXIS</span></b></span><b><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>-<o:p></o:p></span></b></p>
  <p class=TableContents align=center style='text-align:center'><b><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>TENTE<o:p></o:p></span></b></p>
  </td>
  <td width=45 valign=top style='width:33.75pt;border-top:none;border-left:
  solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><b><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>PE-<o:p></o:p></span></b></p>
  <p class=TableContents align=center style='text-align:center'><b><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>DIDA<o:p></o:p></span></b></p>
  </td>
  <td width=39 valign=top style='width:29.35pt;border-top:none;border-left:
  solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><span
  class=SpellE><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>ATEN</span></b></span><b><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>-<o:p></o:p></span></b></p>
  <p class=TableContents align=center style='text-align:center'><b><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>DIDA<o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:4'>
   <td width=57 valign=top style='width:42.6pt;border-top:none;border-left:solid black 1.0pt;
  border-bottom:solid black 1.0pt;border-right:none;padding:2.75pt 2.75pt 2.75pt 2.75pt;text-align: center;'>
  <p class=TableContents align=center style='text-align:center'><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><o:p><?php 
  	$sqlgeral= modelo60::listaMateriais($mod60);
	$count=1;
	while ($dadosgeral = mysqli_fetch_array($sqlgeral)) {	
	echo $count.'<br>';
	$count++;
	} ?></o:p></span></p>
 <?php for ($i=0; $i < 20-$count; $i++) {?> 
  <p class=TableContents align=center><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><o:p>&nbsp;</o:p></span></p>
  <?php } ?>  
  </td>
  <td width=344 colspan=2 valign=top style='width:257.75pt;border-top:none;
  border-left:solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:
  none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><o:p><?php
	$sqldesc = modelo60::listaMateriais($mod60);
  	while ($dados = mysqli_fetch_array($sqldesc)) { 
  	$style  = $dados['status']==2?'text-decoration: line-through;':'';   
    echo '<divi style="width:344px;text-align:center;'.$style.'">'.mb_strimwidth($dados['descricao'],0,60, "...").'</div><br>';} ?>
    </o:p></span></p>
      <p class=TableContents align=center style='position: absolute;top:340px;text-align:center'><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><o:p><?php echo '<br><br><divi style="bottom: 0;width:344px;text-align:center;">'.$dadosgeral1['descritivo'].' Nº.&nbsp;&nbsp;'.$dadosgeral1['documento'].' - '.date("d-m-y", strtotime($dadosgeral1['dt_doc'])).'</div><br>'; ?>
    </o:p></span></p>
  </td>
  <td width=49 valign=top style='width:36.8pt;border-top:none;border-left:solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><o:p><?php
  $sqlmedida =modelo60::listaMateriais($mod60);
	while ($dados = mysqli_fetch_array($sqlmedida)) {
   echo $dados['unidade'].'<br>'; }?></o:p></span></p>
  </td>
  <td width=50 valign=top style='width:37.15pt;border-top:none;border-left:
  solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><o:p><?php $sqlmedida = modelo60::listaMateriais($mod60);
	while ($dados = mysqli_fetch_array($sqlmedida)) {
     echo 'X<br>';}?></o:p></span></p>
  </td>
  <td width=45 valign=top style='width:33.75pt;border-top:none;border-left:
  solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><o:p>&nbsp;</o:p></span></p>
  </td>
  <td width=39 valign=top style='width:29.35pt;border-top:none;border-left:
  solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><o:p>
  <?php $sqlmedida =modelo60::listaMateriais($mod60);
	while ($dadosmedida = mysqli_fetch_array($sqlmedida)) {
   	echo $dadosmedida['qnt_saida'].'<br>';
   	 }?></o:p></span></p>
  </td>
  <td width=97 valign=top style='width:72.9pt;border:solid black 1.0pt;
  border-top:none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><o:p><?php $sqlmedida =modelo60::listaMateriais($mod60);
	while ($dadosmedida = mysqli_fetch_array($sqlmedida)) {
   	echo "R$  ".$dadosmedida['valor_individual'].'<br>';
   	 }?></o:p></span></p>
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
echo strftime("%d de %B de %Y", strtotime($dadosgeral1['data_saida']));?><o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:6'>
  <td width=450 colspan=4 valign=top style='width:337.15pt;border-top:none;
  border-left:solid black 1.0pt;border-bottom:none;border-right:solid black 1.0pt;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents style='tab-stops:13.65pt'><span style='font-size:8.0pt;
  font-family:"Calibri","sans-serif"'><span style='mso-tab-count:1'>         </span><span
  class=GramE>……..</span>………………..<span style='mso-tab-count:1'>         </span>_____________________________________________________<o:p></o:p></span></p>
  </td>
  <td width=231 colspan=4 valign=top style='width:173.15pt;border-top:none;
  border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  mso-border-left-alt:solid black 1.0pt;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><span
  style='font-size:7.0pt;mso-bidi-font-size:8.0pt;font-family:"Calibri","sans-serif"'>LOCAL
  E DATA<o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:7;mso-yfti-lastrow:yes'>
  <td width=450 colspan=4 valign=top style='width:337.15pt;border:solid black 1.0pt;
  border-top:none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><span data-toggle="modal" data-target="#modalExemplo"  data-dismiss="modal"
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><o:p><input type="text" id="nomeinput2" style='font-size:8.0pt; 
  font-family:"Calibri","sans-serif";border: none;width: 100%;text-align: center;' placeholder="NOME E IDFUNCIONAL" value="<?php 
  if($dadosgeral1['destino']<500){ echo utf8_encode($dadospm['gh']).'  '.utf8_encode($dadospm['nome_escala']).' - RG: '.$dadospm['rg'];
}else{echo utf8_encode(' RG/ID FUNCIONAL: '.$dadospm['rg']);} ?>"/></o:p></span></p>
  </td>
  <td width=231 colspan=4 valign=top style='width:173.15pt;border-top:none;
  border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  mso-border-left-alt:solid black 1.0pt;padding:2.75pt 2.75pt 2.75pt 2.75pt' >
  <p class=TableContents align=center style='text-align:center'><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"' ><o:p><input type="text" id="inputautorizador" style='font-size:8.0pt; 
  font-family:"Calibri","sans-serif";border: none;width: 150pt;text-align: center;' /></o:p></span></p>
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
"Calibri","sans-serif"'>…………………………………………………………………………………………………………………………………………………………………………………………………………………………………………………….</span></span><span
style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><o:p></o:p></span></p>


<p class=Standard><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><o:p>&nbsp;</o:p></span></p>

<p class=Standard align=center style='text-align:center'><b><span
style='font-size:10.0pt;mso-bidi-font-size:8.0pt;font-family:"Calibri","sans-serif"'>SERVIÇO<span
style='mso-spacerun:yes'>     </span>PÚBLICO<span style='mso-spacerun:yes'>    
</span>ESTADUAL<o:p></o:p></span></b></p>

<p align="center">

<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 width=680
 style='margin-left:2.25pt;border-collapse:collapse;mso-table-layout-alt:fixed;
 mso-yfti-tbllook:1184;mso-padding-alt:0cm .5pt 0cm .5pt'>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes'>
  <td width=132 colspan=2 valign=top style='width:99.2pt;border-top:solid black 1.0pt;
  border-left:solid black 1.0pt;border-bottom:none;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><b><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>AUTORIZO<o:p></o:p></span></b></p>
  </td>
  <td width=412 colspan=4 valign=top style='width:308.85pt;border-top:solid black 1.0pt;
  border-left:solid black 1.0pt;border-bottom:none;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><b><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>SOLICITAÇÃO DE
  MATERIAL Nº</span></b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>
  <?php echo $dadosgeral1['m60'].'&nbsp;&nbsp;&nbsp;&nbsp;'.$_SESSION['tipo']; ?><o:p></o:p></span></p>
  </td>
  <td width=136 colspan=2 valign=top style='width:102.25pt;border:solid black 1.0pt;
  border-bottom:none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>VISTO<o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:1'>
  <td width=132 colspan=2 valign=top style='width:99.2pt;border-top:none;
  border-left:solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:
  none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><o:p>&nbsp;</o:p></span></p>
  <p class=TableContents align=center style='text-align:center'><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>______________________<o:p></o:p></span></p>
  </td>
  <td width=412 colspan=4 valign=top style='width:308.85pt;border-top:none;
  border-left:solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:
  none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents style='tab-stops:8.5pt'><span style='font-size:8.0pt;
  font-family:"Calibri","sans-serif"'><span style='mso-tab-count:1'>      </span>DO:
  <span style='mso-tab-count:1'>        </span><span style='mso-tab-count:
  5'><?php echo $dadosgeral1['abrev_opm']; ?>                                                                                                      </span><o:p></o:p></span></p>
  <p class=TableContents style='tab-stops:8.5pt'><span style='font-size:8.0pt;
  font-family:"Calibri","sans-serif"'><span style='mso-tab-count:1'>      </span>AO:<span
  style='mso-tab-count:1'>          </span>Chefe <span class=SpellE></span><span
  style='mso-tab-count:4'>DGO </span><o:p></o:p></span></p>
  </td>
  <td width=136 colspan=2 valign=top style='width:102.25pt;border:solid black 1.0pt;
  border-top:none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><o:p>&nbsp;</o:p></span></p>
  <p class=TableContents align=center style='text-align:center'><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><?php echo utf8_encode($dadosuser['gh']).' '. $dadosuser['nome_escala']; ?><o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:2'>
  <td width=57 rowspan=2 style='width:42.6pt;border-top:none;border-left:solid black 1.0pt;
  border-bottom:solid black 1.0pt;border-right:none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><b><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>Nº ORDEM<o:p></o:p></span></b></p>
  </td>
  <td width=344 colspan=2 rowspan=2 style='width:257.75pt;border-top:none;
  border-left:solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:
  none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><b><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>Especificação<o:p></o:p></span></b></p>
  <p class=TableContents align=center style='text-align:center'><b><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>(ORDEM ALFABÉTICA)<o:p></o:p></span></b></p>
  </td>
  <td width=49 rowspan=2 style='width:36.8pt;border-top:none;border-left:solid black 1.0pt;
  border-bottom:solid black 1.0pt;border-right:none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><b><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>UNI-<o:p></o:p></span></b></p>
  <p class=TableContents align=center style='text-align:center'><span
  class=SpellE><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>DADE</span></b></span><b><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><o:p></o:p></span></b></p>
  </td>
  <td width=134 colspan=3 style='width:100.25pt;border-top:none;border-left:
  solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><b><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>QUANT.<o:p></o:p></span></b></p>
  </td>
  <td width=97 rowspan=2 style='width:72.9pt;border:solid black 1.0pt;
  border-top:none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><b><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>OBSERVAÇÃO<o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:3'>
  <td width=50 valign=top style='width:37.15pt;border-top:none;border-left:
  solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><span
  class=SpellE><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>EXIS</span></b></span><b><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>-<o:p></o:p></span></b></p>
  <p class=TableContents align=center style='text-align:center'><b><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>TENTE<o:p></o:p></span></b></p>
  </td>
  <td width=45 valign=top style='width:33.75pt;border-top:none;border-left:
  solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><b><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>PE-<o:p></o:p></span></b></p>
  <p class=TableContents align=center style='text-align:center'><b><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>DIDA<o:p></o:p></span></b></p>
  </td>
  <td width=39 valign=top style='width:29.35pt;border-top:none;border-left:
  solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><span
  class=SpellE><b><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>ATEN</span></b></span><b><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>-<o:p></o:p></span></b></p>
  <p class=TableContents align=center style='text-align:center'><b><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'>DIDA<o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:4'>
  <td width=57 valign=top style='width:42.6pt;border-top:none;border-left:solid black 1.0pt;
  border-bottom:solid black 1.0pt;border-right:none;padding:2.75pt 2.75pt 2.75pt 2.75pt;text-align: center;'>
  <p class=TableContents align=center style='text-align:center'><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><o:p><?php 
  	$sqlgeral=modelo60::listaMateriais($mod60);
	$count=1;
	while ($dadosgeral = mysqli_fetch_array($sqlgeral)) {	
	echo $count.'<br>';
	$count++;
	} ?></o:p></span></p>
 <?php for ($i=0; $i < 20-$count; $i++) {?> 
  <p class=TableContents align=center><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><o:p>&nbsp;</o:p></span></p>
  <?php } ?>  
  </td>
  </td>
  <td width=344 colspan=2 valign=top style='width:257.75pt;border-top:none;
  border-left:solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:
  none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
 <p class=TableContents align=center style='text-align:center'><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><o:p><?php
	$sqldesc = modelo60::listaMateriais($mod60);
  	while ($dados = mysqli_fetch_array($sqldesc)) { 
  	$style  = $dados['status']==2?'text-decoration: line-through;':'';   
    echo '<divi style="width:344px;text-align:center;'.$style.'">'.mb_strimwidth($dados['descricao'],0,60, "...").'</div><br>';}
	//echo '<br><br><divi style="bottom: 0;width:344px;text-align:center;">Autorização N.&nbsp;&nbsp;'.$dadosgeral1['documento'].' - '.date("d-m-y", strtotime($dadosgeral1['dt_doc'])).'</div><br>'; ?>
    </o:p></span></p>
      <p class=TableContents align=center style='position: absolute;top:820px;text-align:center'><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><o:p><?php echo '<br><br><divi style="bottom: 0;width:344px;text-align:center;">'.$dadosgeral1['descritivo'].' Nº.&nbsp;&nbsp;'.$dadosgeral1['documento'].' - '.date("d-m-y", strtotime($dadosgeral1['dt_doc'])).'</div><br>'; ?>
    </o:p></span></p>
  </td>
  <td width=49 valign=top style='width:36.8pt;border-top:none;border-left:solid black 1.0pt;
  border-bottom:solid black 1.0pt;border-right:none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><o:p><?php
  $sqlmedida =modelo60::listaMateriais($mod60);
	while ($dados = mysqli_fetch_array($sqlmedida)) {
   echo $dados['unidade'].'<br>'; }?></o:p></span></p>
  </td>
  <td width=50 valign=top style='width:37.15pt;border-top:none;border-left:
  solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><o:p><?php $sqlmedida = modelo60::listaMateriais($mod60);
	while ($dados = mysqli_fetch_array($sqlmedida)) {
   	//echo $dados['ult_estoque'].'<br>';
 	echo 'X<br>';}?></o:p></span></p>
  </td>
  <td width=45 valign=top style='width:33.75pt;border-top:none;border-left:
  solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><o:p>&nbsp;</o:p></span></p>
  </td>
  <td width=39 valign=top style='width:29.35pt;border-top:none;border-left:
  solid black 1.0pt;border-bottom:solid black 1.0pt;border-right:none;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><o:p>
  <?php $sqlmedida =modelo60::listaMateriais($mod60);
	while ($dadosmedida = mysqli_fetch_array($sqlmedida)) {
   	echo $dadosmedida['qnt_saida'].'<br>';
   	 }?></o:p></span></p>
  </td>
  <td width=97 valign=top style='width:72.9pt;border:solid black 1.0pt;
  border-top:none;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><o:p><?php $sqlmedida =modelo60::listaMateriais($mod60);
	while ($dadosmedida = mysqli_fetch_array($sqlmedida)) {
   	echo "R$  ".$dadosmedida['valor_individual'].'<br>';
   	 }?></o:p></span></p>
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
echo ucfirst( strftime("%d de %B de %Y", strtotime($dadosgeral1['data_saida']))); ?><o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:6'>
  <td width=450 colspan=4 valign=top style='width:337.15pt;border-top:none;
  border-left:solid black 1.0pt;border-bottom:none;border-right:solid black 1.0pt;
  padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents style='tab-stops:13.65pt'><span style='font-size:8.0pt;
  font-family:"Calibri","sans-serif"'><span style='mso-tab-count:1'>         </span><span
  class=GramE>……..</span>………………..<span style='mso-tab-count:1'>         </span>_____________________________________________________<o:p></o:p></span></p>

  </td>
  <td width=231 colspan=4 valign=top style='width:173.15pt;border-top:none;
  border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  mso-border-left-alt:solid black 1.0pt;padding:2.75pt 2.75pt 2.75pt 2.75pt'>
  <p class=TableContents align=center style='text-align:center'><span
  style='font-size:7.0pt;mso-bidi-font-size:8.0pt;font-family:"Calibri","sans-serif"'>LOCAL
  E DATA<o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:7;mso-yfti-lastrow:yes'>
  <td width=450 colspan=4 valign=top style='width:337.15pt;border:solid black 1.0pt;
  border-top:none;padding:2.75pt 2.75pt 2.75pt 2.75pt'> 
  <p class=TableContents align=center style='text-align:center'><span style='mso-tab-count:1'></span><span
  class=GramE></span><span style='mso-tab-count:1'></span><span data-toggle="modal" data-target="#modalExemplo"  data-dismiss="modal"
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><o:p><input type="text" id="nomeinput" style='font-size:8.0pt;
  font-family:"Calibri","sans-serif";border: none;width: 100%;text-align: center;' placeholder="NOME E IDFUNCIONAL" value="<?php 
  if($dadosgeral1['destino']<500){ echo utf8_encode($dadospm['gh']).'  '.utf8_encode($dadospm['nome_escala']).' - RG: '.$dadospm['rg'];
  }else{echo utf8_encode(' RG/ID FUNCIONAL: '.$dadospm['rg']);} ?>" readonly /></o:p></span></p>
  </td>
  <td width=231 colspan=4 valign=top style='width:173.15pt;border-top:none;
  border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  mso-border-left-alt:solid black 1.0pt;padding:2.75pt 2.75pt 2.75pt 2.75pt' >
  <p class=TableContents align=center style='text-align:center'><span
  style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><o:p><input type="text" id="inputautorizador2" style='font-size:8.0pt; 
  font-family:"Calibri","sans-serif";border: none;width: 150pt;text-align: center;' /></o:p></span></p>
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
		//$dadosgeral1['status']=2;
		if($dadosgeral1['status']==2){
			$disabled="disabled";
			$status = 'title="Excluido pelo usuário : '.$_SESSION["UserRG"].'"';
		}?>
<button type="button" class="btn btn-danger" <?php echo $disabled; ?> data-toggle="modal" data-target="#excluir"  data-dismiss="modal"><i class="glyphicon glyphicon-trash" ></i></button>
<?php //} ?>
<button onclick="self.print()" id="btn_imprime"  class="btn btn-primary" alt="Imprimir"  ><i class="glyphicon glyphicon-print"></i>&nbsp;</button></p>
</div>



<p class=Standard><span style='font-size:8.0pt;font-family:"Calibri","sans-serif"'><o:p>&nbsp;</o:p></span></p>

</div>
<!--MODAL EXCLUIR-->
  <div class="modal fade" id="modalExemplo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-center a" >Dados de policial que está retirando.</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid text-center" >
       
          <div class="col-xs-12 col-sm-12 ">
            <div class="col-xs-12 col-sm-2">
              <label>Nome</label>
            </div>
          <div class="col-xs-12 col-sm-12 ">
            <div class="group-material">
              <input type="text" class="material-control tooltips-general a" name="nome" id="nome" required>             
              <span class="bar"></span>       
            </div>
          </div>
        
          <div class="col-xs-12 col-sm-3">
            <label>Id Funciona</label>
          </div>
          <div class="col-xs-12 col-sm-12 ">
            <div class="group-material">
              <input type="text" class="material-control tooltips-general a" name="idfuncional" id="idfuncional"   required>             
              <span class="bar"></span>       
            </div>
          </div>
          <div class="col-xs-12 col-sm-3">
            <label>OBS</label>
          </div>
          <div class="col-xs-12 col-sm-12 ">
            <div class="group-material">
              <input type="text" class="material-control tooltips-general a" name="autorizador" id="autorizador"   required>             
              <span class="bar"></span>       
            </div>
          </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
   
        <button  class="btn btn-primary" name="atualizar" onclick='editar(idfuncional.value,nome.value,autorizador.value)'><i class="glyphicon glyphicon glyphicon-refresh"></i> &nbsp;&nbsp; Atualizar</button>
      </div>
    
    </div>
  </div>
</div>
</div> 
<!--FIM MODAL EXCLUIR-->

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
      	<form method="post" action="?id=<?php echo $mod60;?>">
	        <div class="container-fluid text-center" >
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
        #noprint { display:none; } 
    }
    .a{font: bold 18px arial, sans-serif;}
</style>
</body>

</html>
