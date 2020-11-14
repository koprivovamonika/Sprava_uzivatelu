<meta charset="UTF-8">
<?php
session_start();
include "funkce.php";
opravneniA();

smaz($_GET["id"]);
header("Location: vypis_uzivatelu.php");
?>
