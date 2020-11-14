<?php
@session_start();
include "funkce.php";
$db=spojeni();
opravneniA();
Menu();
?>

<h1>Je přihlášen administrátor: <b><?php echo $_SESSION["login"]; ?></h1>
