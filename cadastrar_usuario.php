<?php
sleep(1);
error_reporting(0);
session_start();
if(isset($_REQUEST['rg'])){
    $rg = $_REQUEST['rg'];
}
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
    <title>Cadastro de Usuário</title>
    <script type='text/javascript'>
    </script>
</head>

<body>
    <?php
    include_once 'class/dadossispes.class.php';
    include_once 'library/configserver.php';
    include_once 'library/consulsql.php';
    include_once 'library/usuario.php';
    include_once 'library/opm.php';
    include_once 'library/fornecedor.php';
    include 'inc/NavLateral.php';
    ?>
    <div class='content-page-container full-reset custom-scroll-containers'>
        <?php
        include 'inc/NavUserInfo.php';
        ?>
        <div class='container'>
            <div class='page-header'>
                <h1 class='all-tittles'>SisMatOdonto <small> Cadastrar Usuário</small></h1>
            </div>
        </div>

<?php
$dadospm = ConexaoSispes::consultarSispes("SELECT * FROM vw_sismatbel where rg = '$rg'");

foreach($dadospm as $dados){
?>
        <div class='container-fluid'>
            <form method='post' action='controller/usuario_controller.php'>
                <div class='row'>
                    <div class='col-xs-12 col-sm-6'>
                        <label>RG</label>
                        <div class='group-material'>
                            <input type='text' value="<?php echo $dados['rg']; ?>" class='form-control text-center  tooltips-general' name='rg' id='rg'
                                data-toggle='tooltip' data-placement='top' title='rg do usuário' required>
                        </div>
                    </div>
                    <div class='col-xs-12 col-sm-6'>
                        <label for="exampleFormControlSelect1">Status</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="status">
                            <option selected disabled aria-required="">Status</option>
                            <option value="0">Ativo</option>
                            <option value="1">Inativo</option>
                        </select>
                    </div>
                </div>

                <div class='row'>
                <div class='col-xs-12 col-sm-6'>
                <label>Id Nivel Usuário</label>

                <select class="material-control tooltips-general" id="classe" name="nivelUsuario"
                                data-toggle="tooltip" data-placement="top" title="Classe" required>
                                <option value="">Selecione</option>
<?php
$usuario = usuario::consultar("SELECT * FROM nivelusuario");
foreach($usuario as $u){
  echo '<option value="' . $u["id"] . '">' . $u['descricao'] . '</option>';
}
?>
<input hidden value="<?php echo $dados['opm_pm_pega'] ?>" name="opmNum">
                </select>
                    </div>
                    <div class='col-xs-12 col-sm-6'>
                        <label>Opm</label>
                        <div class='group-material'>
                            <input type='text' value="<?php echo $dados['opm']; ?>"  class='form-control text-center  tooltips-general' name='opm' id='opm'
                                data-toggle='tooltip' data-placement='top' title='opm' required>
                        </div>
                    </div>
                </div>
         
<?php } ?>

                <div class='full-reset row representative-resul'>
                    <div class="col">
                        <center>
                            <button type='reset' class='btn btn-light' style='margin-right: 20px;'><i
                                    class='glyphicon glyphicon-erase'></i> &nbsp;
                                &nbsp;
                                Limpar</button>

                            <button type='submit' id='btn_enviar' name='cadastrarUsuario' class='btn btn-success'
                                style='margin-right: 20px;'><i class='glyphicon glyphicon-floppy-saved'
                                    style='margin-right: 20px;'></i> &nbsp;
                                &nbsp;
                                Salvar</button>

                            <a href="cadastros.php" <button type='link' class='btn btn-danger'
                                style='margin-right: 20px;'><i class='glyphicon glyphicon-arrow-left'></i> &nbsp;
                                &nbsp;
                                Voltar</button></a>
                        </center>

                        <span id='erro'></span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>