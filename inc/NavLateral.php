<?php



if (isset($_POST['caduser'])) {
    if ($_POST['rg'] <> '') {

        $rg         =  str_replace('.', '', $_POST['rg']);

        $qruser = usuario::consultar("SELECT * FROM usuario where rg ='$rg'");

        if (sizeof($qruser) > 0) {
            echo  '<script type="text/javascript">alert("Usuário ' . $rg . ' Já cadastrado!!")</script>';
        } else {
            $opm        = $_POST['unidade'];
            $pass       = md5($rg . $rg);
            $tabela     = 'user';
            $campos     = "rg,pass,opm,status";
            $valores    = "'$rg','$pass','$opm',1";

            if ($id_insert = consultasSQL::InsertSQL($tabela, $campos, $valores)) {
                echo  '<script type="text/javascript">alert("Usuário ' . $rg . ' Cadastrado com Sucesso!!")</script>';
            } else {
                echo  '<script type="text/javascript">alert(" Erro ao Cadastrar!")</script>';
            }
        }
    } else {
        echo  '<script type="text/javascript">alert("Informe o RG!")</script>';
    }
}



if (isset($_POST['del-user'])) {
    $rg        =   $_SESSION['UserRG'];
    $idUser    =   $_POST['id_user'];

    $tabela   = "user";
    $condicao = "Id='$idUser'";

    if (consultasSQL::DeleteSQL($tabela, $condicao)) {
        echo  '<script type="text/javascript">alert("USUARIO Excluído com Sucesso!!")</script>';
    } else {
        echo  '<script type="text/javascript">alert("Falha ao Excluir Usuário!")</script>';
    }
}

if (isset($_POST['senhanew'])) {
    $rg        =   $_SESSION['UserRG'];
    $pass      =   md5($_POST['novasenha']);

    $tabela    = 'user';
    $campos    = "pass='$pass'";
    $condicion = "rg='$rg'";

    if ($id_insert = consultasSQL::UpdateSQL($tabela, $campos, $condicion)) {
        echo  '<script type="text/javascript">alert("Senha Alterada com Sucesso!!")</script>';
    } else {
        echo  '<script type="text/javascript">alert(" Erro ao Alterar senha!")</script>';
    }
}


?>


<div class="navbar-lateral full-reset">
    <div class="visible-xs font-movile-menu mobile-menu-button"></div>
    <div class="full-reset container-menu-movile custom-scroll-containers">
        <div class="logo full-reset all-tittles" style="background-color:#2B3D51;">
            <i class="visible-xs zmdi zmdi-close pull-left mobile-menu-button"
                style="line-height: 55px; cursor: pointer; padding: 0 10px; margin-left: 7px;"></i>
            Sistema de Material odontologico
        </div>
        <div class="full-reset" style="background-color:#2B3D51; padding: 10px 0; color:#fff;">
            <figure>
                <img src="assets/img/brasao2.png" alt="MatOdonto" class="img-responsive center-box" style="width:60%;">
            </figure>
            <p class="text-center" style="padding-top: 15px;">Odontológico</p>
        </div>
        <div class="full-reset nav-lateral-list-menu">
            <ul class="list-unstyled">
                <li><a href="home.php"><i class="glyphicon glyphicon-level-up"></i>&nbsp;Estoque de Material</a></li>
                <li><a href="receber_material.php"><i class="glyphicon glyphicon-share-alt"></i>&nbsp;&nbsp;Entrada
                        Material</a></li>
                <li><a href="saida_material_item.php"><i class="glyphicon glyphicon-tint"></i>&nbsp;&nbsp;Saída de
                        Material</a></li>
                <?php
                if ($_SESSION['nivelusuario']  == 2) { ?>
                <li><a href="distribuir_material.php"><i
                            class="glyphiconglyphicon glyphicon-pencil"></i>&nbsp;&nbsp;Pedido de Material</a>
                </li>

                <li><a href="dashboard.php"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp; Relatórios DGO</a>
                </li>
                <?php } ?>
                <li><a href="dashboard0pm.php"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp; Relatórios OPM
                    </a></li>
                <li><a href="cadastros.php"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;
                        Cadastros </a></li>
            </ul>
        </div>
    </div>
</div>

<!-- MODAL TROCAR SENHA-->
<div class="modal fade" id="trocarsenha" tabindex="-1" role="dialog" aria-labelledby="cadastrousuario"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="distribuir_material.php">
                <div class="modal-header text-center">
                    <h1 class="modal-title a" id="cadastrousuario">Digite a sua nova senha!</h1>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="password" class="form-control a" id="newsenha" name="novasenha" autofocus="true"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="subimit" class="btn btn-primary" name="senhanew">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="caduserm" tabindex="-1" role="dialog" aria-labelledby="cadastrousuario"
    aria-hidden="true">
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
                            <div class="div-table-row div-table-row-list"
                                style="background-color:#DFF0D8; font-weight:bold;">
                                <div class="div-table-cell" style="width: 15%;">DATA</div>
                                <div class="div-table-cell" style="width: 5%;">DOC.</div>
                                <div class="div-table-cell" style="width: 15%;">MOD60</div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <div style="height:200px;overflow-y:auto;">

                            <?php

                            $querymaterial  = usuario::consultar("SELECT u.id,abrev_opm,rg FROM usuario u,opm o where u.opm = o.cod_opm order by rg asc");

                            foreach ($querymaterial as $material) {

                                $style  = $material['status'] == 2 ? 'text-decoration: line-through;' : ''; ?>
                            <ul id="itemContainer" class="list-unstyled">
                                <li>
                                    <div class="table-responsive">
                                        <div class="div-table" style="margin:0 !important;<?php echo $style; ?>">
                                            <div class="div-table-row div-table-row-list">
                                                <div class="div-table-cell" style="width: 10%;">
                                                    <b><?php echo $material['rg']; ?></b>
                                                </div>
                                                <div class="div-table-cell" style="width: 10%;">
                                                    <b><?php echo $material['abrev_opm']; ?></b>
                                                </div>

                                                <div class="div-table-cell " style="width: 10%;"><button
                                                        class="btn btn-primary  tooltips-general" type="button"
                                                        title=""></><?php echo $material['abrev_opm']; ?>;?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="holder">
                            </div>
                            <?php }
                            ?>
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



<!-- MODAL CADASTRAR USUARIO-->
<div class="modal fade bd-example-modal-lg" id="caduser" tabindex="-1" role="dialog" aria-labelledby="cadastrousuario"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header text-center">
                <h1 class="modal-title a" id="cadastrousuario">Cadastrar Usuário</h1>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <form method="POST" action="distribuir_material.php">
                            <div class="col-xs-12 col-sm-12">
                                <div class="col-xs-12 col-sm-1">
                                    <label>NOME</label>
                                </div>

                                <div class="col-xs-12 col-sm-3 ">
                                    <div class="group-material">
                                        <input type="text" class="material-control tooltips-general a" name="nome">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-1">
                                    <label>RG</label>
                                </div>

                                <div class="col-xs-12 col-sm-2 ">
                                    <div class="group-material">
                                        <input type="text" class="material-control tooltips-general a" name="rg">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-3">
                                    <label>POSTO/GRADUAÇÃO</label>
                                </div>

                                <div class="col-xs-12 col-sm-2">
                                    <div class="group-material">
                                        <input type="text" class="material-control tooltips-general a"
                                            name="posto_graduacao">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-3">
                                </div>

                                <div class="col-xs-12 col-sm-1">
                                    <label>Unidade</label>
                                </div>
                                <div class="col-xs-12 col-sm-4 ">
                                    <div class="group-material">
                                        <select class="selectpicker form-control" name="unidade"
                                            data-live-search="true">
                                            <option value="">Selecione</option>
                                            <?php

                                            $queryopms = opm::consultar("SELECT id, cod_opm, abrev_opm FROM opm where is_odonto=1 order by abrev_opm desc");

                                            foreach ($queryopms as $opm) {
                                                echo '<option value="' . $opm["id"] . '">' . $opm["abrev_opm"] . '</option>';
                                            }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-2">
                                    <button type="submit" class="btn btn-primary" name="caduser"><i
                                            class="glyphicon glyphicon glyphicon-refresh"></i> &nbsp;&nbsp;
                                        Salvar</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="col-lg- col-md-10 col-md-10 col-md-offset-1 text-center">
                            <div class="table-responsive ">
                                <div class="div-table ">
                                    <div class="div-table-row" style="background-color:#DFF0D8; font-weight:bold;">
                                        <div class="div-table-cell" style="width:40%;">RG</div>
                                        <div class="div-table-cell" style="width: 40%;">Unidade</div>
                                        <div class="div-table-cell" style="width: 20%;"></div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <div style="height:200px;overflow-y:auto;">
                                        <?php
                                        $querymaterial = opm::consultar("SELECT u.id,abrev_opm,rg, u.status FROM usuario u,opm o where u.opm=o.cod_opm order by opm desc");

                                        foreach ($querymaterial as $material) {

                                            $style  = $material['status'] == 2 ? 'text-decoration: line-through;' : ''; ?>

                                        <ul id="itemContainer" class="list-unstyled">
                                            <li>
                                                <div class="table-responsive">
                                                    <div class="div-table"
                                                        style="margin:0 !important;<?php echo $style; ?>">
                                                        <div class="div-table-row div-table-row-list">
                                                            <div class="div-table-cell" style="width: 40%;">
                                                                <b><?php echo $material['rg']; ?></b>
                                                            </div>
                                                            <div class="div-table-cell" style="width: 40%;">
                                                                <b><?php echo $material['abrev_opm']; ?></b>
                                                            </div>

                                                            <form action="distribuir_material.php" method="post">
                                                                <input type="hidden" name="id_user"
                                                                    value="<?php echo $material['Id']; ?>">
                                                                <div class="div-table-cell" style="width: 20%;">
                                                                    <input class="btn btn-danger" type="submit"
                                                                        value="Excluir" name="del-user">
                                                                </div>
                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="holder"></div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div><br><br>
                            <div class=' alert alert-success text-center' role='alert'>Após Cadastrar Usuário a senha
                                inicial será o rg duas vezes!!<br>Ex: Se o rg for <b>100181</b>, a senha será
                                <b>100181100181</b>.<button type='button' class='close' data-dismiss='alert'
                                    aria-label='Close'> <span aria-labelhidden='true'>&times;</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <p>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- fim MODAL CADASTRAR USUARIO-->

<style>
.table-overflow {
    height: 60px;

}

.a {
    font: bold 15px arial, sans-serif;
}
</style>