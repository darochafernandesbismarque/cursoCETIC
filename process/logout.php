<?php
include '../library/configserver.php';
include '../library/consulsql.php';
session_start();
$hora=date("H:i:s");
//consultasSQL::UpdateSQL("bitacora", "Salida='$hora'", "Codigo='".$_SESSION['codeBit']."'");
session_unset();
session_destroy();
session_write_close();
//setcookie($rg_rumb_lpd, '', time());
//setcookie($rg_rumb, '', time());
header("Location: ../index.php"); 