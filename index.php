<?php
sleep(1);
session_start();
include './inc/links.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>MatOdonto</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <meta name="viewport"
        content="width=device-width, user-scable=no, initial-scale=1, maximun-scale=1, minimum-scale=1">
    <link rel="shotcut icon" type="image/x-icon" href=" pmerj.png" />
    <link href="https://file.myfontastic.com/mhSBD4FxMhWWkou6Gm7T2V/icons.css" rel="stylesheet" type="icons.css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>

    <script src='process/formvalidation.js'></script>

</head>

<body>
    <img src="assets/img/background.jpeg" style="width: 100%;height: 100%; position: absolute;">
    <div class="row" style="position: absolute;
    top: 170px;
    left: 50%;
    width: 460px;
    height: 460px;
    padding: 20px;
    margin-left: -250px; /* por causa do posicionamento absoluto temos que usar margem negativa para centralizar o site */
    background: #FFF; /* fundo branco para navegadores que não suportam rgba */
    background: rgba(255,255,255,0.3);">
        <div>
            <center>
                <h3>LOGIN</h3>
            </center>

            <form name="login" id="login" action="process/login.php" method="post" <style opacity: 30%;>
                <div class="form-field  ">
                    <i class="material-icons left">supervisor_account</i>
                    <b>
                        <label for="inputEmail3" class="col-sm-2 col-form-label-color">
                            <font color='black'>Usuário</font>
                        </label>
                    </b>
                    <input color='black' name="cpf" id='cpf' type="text" width="20" maxlength="20"
                        placeholder="Digite seu Usuário" aria-label="Usuário do SEI" required>
                    <i class="material-icons left">vpn_key</i>
                    <b>
                        <label for="inputPassword3" class="col-sm-3 col-form-label ">
                            <font color='black'>Senha do SEI</font>
                        </label>
                    </b>
                    <BR>
                    <div class="col-sm-12">
                        <input name="senha" id='senha' type="password" width="20" maxlength="20"
                            title="Digite senha de acesso ao SEI" placeholder="Senha do SEI" aria-label="Senha do SEI"
                            color="black" required>
                        <br>
                        <?php
                        if (isset($_SESSION['error'])) {
                            echo "<b><center><font color='#FF0000' > " . $_SESSION['error'] . " </font></center></b>";
                            session_unset();
                        }
                        ?>

                        <div align="center">
                            <button href="home.php" type="submit" name="btn-entrar" id="btn-entrar"
                                class="waves-effect btn waves-effect waves-light primary"
                                style="font-size:22px; ">Entrar</button>
                        </div>
                        <br>

                        <CENTER>
                            <font color="black" size="2"><b> &COPY;</b> 2021 CETIC / DESENVOLVIMENTO<br>
                                2.0.0<br>

                        </CENTER>
                        <br>

                        <DIV>

                            <center><img id="load" src="https://i.gifer.com/YVPG.gif" width="300" border="0" </center>


                        </DIV>

                    </div>
                </div>
                <br>
                <br>
            </form>
        </div>
    </div>


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
</body>

</html>