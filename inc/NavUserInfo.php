<nav class="navbar-user-top full-reset">
    <ul class="list-unstyled full-reset">
        <li><a type="button" style="color:#fff;" href="process/logout.php"><i class="glyphicon glyphicon-log-out"></i>&nbsp;&nbsp;Sair</a></li>

        <figure>
            <?php
            echo '<img src="http://172.16.0.1/fotos/' . $_SESSION["UserRG"] . '.bmp" alt="user-picture" class="img-responsive img-circle center-box">';
            ?>
        </figure>


        <li style="color:#fff; cursor:default;">
            <span class="all-tittles"> <?php echo $_SESSION['desc_gh'] . '&nbsp;&nbsp;-&nbsp;&nbsp;' . $_SESSION['nome'] . '&nbsp;&nbsp;RG : ' . $_SESSION['UserRG'] . '&nbsp;&nbsp;&nbsp;&nbsp;' . $_SESSION['UserOPMDesc']; ?></span>
        </li>

        <li class="mobile-menu-button visible-xs" style="float: left !important;">
            <i class="zmdi zmdi-menu"></i>
        </li>

        <li class="desktop-menu-button hidden-xs" style="float: left !important;color:#fff;">
            <span class="all-tittles"> <?php echo $_SESSION['OPMDesc']; ?></span>
        </li>
    </ul>
</nav>