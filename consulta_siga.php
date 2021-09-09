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
    <title>Consulta Siga</title>

    <script type='text/javascript'>
    </script><!-- data table com exportação-->
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
    

    </script>
</head>
<!-- DATA TABLE COLOCAR ID=EXAMPLE DENTRO DO TABLE-->

<body>
    <!-- data table com exportação-->
    <script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [
            ]
        });
    });
    </script>
    <!-- data table com exportação-->

    <?php
    include_once 'library/configserver.php';
    include_once 'library/consulsql.php';
    include_once 'library/usuario.php';
    include_once 'library/opm.php';
    include_once 'library/fornecedor.php';
    include_once 'library/itemSiga.php';
    include 'inc/NavLateral.php';
    ?>
    <div class='content-page-container full-reset custom-scroll-containers'>
        <?php
        include 'inc/NavUserInfo.php';
        ?>
        <div class='container'>
            <div class='page-header'>
                <h1 class='all-tittles'>SisMatOdonto <small> Buscar Siga</small></h1>
            </div>
        </div>

        <div class='container-fluid'>
            <form method='post' action='consulta_siga.php'>
                <div class='row'>

                    <div class='col-xs-12 col-sm-3'>
                        <label></label>
                        <div class='group-material'>
                        </div>
                    </div>

                    <div class='col-xs-12 col-sm-6'>
                        <label>Siga</label>
                        <div class='group-material'>
                            <input type='text' class='form-control text-center  tooltips-general' name='consultaSIGA' id='consultaSIGA'
                                data-toggle='tooltip' data-placement='top' placeholder="Digite código ou nome do SIGA"
                                title='Consultar SIGA CADASTRADO' required>
                        </div>
                    </div>
                </div>

                <div class='full-reset row representative-resul'>
                    <div class="col">
                        <center>
                            <button type='reset' class='btn btn-light' style='margin-right: 20px;'><i
                                    class='glyphicon glyphicon-erase'></i> &nbsp;
                                &nbsp;
                                Limpar</button>

                            <button type='submit' id='btn-entrar' name='enviar' class='btn btn-primary'
                                style='margin-right: 20px;'><i class='glyphicon glyphicon-floppy-saved'
                                    style='margin-right: 20px;'></i> &nbsp;
                                &nbsp;
                                Entrar</button>

                            <a href="buscar_codigo_siga.php" <button type='link' class='btn btn-danger'
                                style='margin-right: 20px;'><i class='glyphicon glyphicon-arrow-left'></i> &nbsp;
                                &nbsp;
                                Voltar</button></a>
                        </center>
                        <span id='erro'></span>
                        <br>

                        <center><img id="load" src="https://i.gifer.com/YVPG.gif" width="300" border="0" </center>
                    </div>
                </div>
            </form>
        </div>
        

        <?php

?>

<section id="direita">

<table id="example" class="table table-striped col-md-12" align="center"
    style="background-color:#fff;  max-width: 1600px; position: relative; padding:30px; border: solid 1px #dee2e6;">

    <thead>
        <tr>
            <th scope="col">Id Item</th>
            <th scope="col">Cód Item</th>
            <th scope="col">Id Artigo</th>
            <th scope="col">Artigo</th>
            <th scope="col">Id Classe</th>
            <th scope="col">Classe</th>
            <th scope="col">Id Família</th>
            <th scope="col">Família</th>
            <th scope="col">Id Tipo</th>
            <th scope="col">Tipo</th>
        </tr>
    </thead>

    <?php
        ?>
    <tbody>

<?php
if(isset($_REQUEST['consultaSIGA'])){

$consultaSIGA = $_REQUEST['consultaSIGA'];

$consulta = itemSiga::consultar("SELECT
i.idItem,
i.codigoitem,
i.descricao,
a.idArtigo,
a.descricao AS artigo,
c.idClasse,
c.descricao AS classe,
f.idFamilia,
f.descricao AS familia,
t.idTipo,
t.descricao AS tipo
FROM
ItemSiga i
INNER JOIN ArtigoSiga a ON a.idArtigoSiga = i.idArtigoSiga
INNER JOIN ClasseSiga c ON c.idClasseSiga = a.idClasseSiga
INNER JOIN FamiliaSiga f ON f.idFamiliaSiga = c.idFamiliaSiga
INNER JOIN TipoSiga t ON t.idTipoSiga = f.idTipoSiga
WHERE
i.descricao like '%$consultaSIGA%'");       

//print_r($consulta);        
                            
    foreach($consulta as $consultar){
?>
        <tr>
            <td>
                <?php
                        echo $consultar['idItem'];
                        ?>
            </td>
            <td>
                <?php
                        $strin = $consultar['codigoitem'];
                        $ler = str_replace('.', '', $strin);
                        echo $ler;
                        ?>
            </td>

            <td><?php
                        echo $consultar['idArtigo'];
                        ?>
            </td>

            <td><?php
                        echo $consultar['artigo'];
                        ?>
            </td>

            <td><?php
                        echo $consultar['idClasse'];
                        ?>
            </td>
            <td><?php
                        echo $consultar['classe'];
                        ?>
            </td>
            <td><?php
                        echo $consultar['idFamilia'];
                        ?>
            </td>
            <td><?php
                        echo $consultar['familia'];
                        ?>
            </td>
               <td><?php
                        echo $consultar['idTipo'];
                        ?>
            </td>
            <td><?php
                        echo $consultar['tipo'];
                        ?>
            </td>
        </tr>
        <?php } } ?>

    </tbody>
</table>

</section>

    </div>
    
</body>
</html>
<script type="text/javascript">
$(document).ready(function() {
    $('#load').hide();
        $('#btn-entrar').click(function() {
            $('#load').show();
            setTimeout(function() {
                $('#load').hide();

        }, 3000);
    });
});
</script>