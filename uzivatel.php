<?php
@session_start();
include "funkce.php";
$db=spojeni();
opravneniU();
Menu();
?>

<h1>Je přihlášen uživatel: <b><?php echo $_SESSION["login"]; ?></h1>