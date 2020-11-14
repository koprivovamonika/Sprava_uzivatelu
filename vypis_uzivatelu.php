<?php
session_start();
include 'funkce.php';
opravneniA();
Menu();

echo "<h1 class='nadpis'>Výpis uživatelů</h1>";
VypisUzivatelu();

?>
