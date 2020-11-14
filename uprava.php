<?php
session_start();
include 'funkce.php';
opravneniA();
Menu();

$db = spojeni();
$dotaz = "SELECT * FROM uzivatele WHERE id='" . $_GET['id'] . "'";
$data = $db->query($dotaz);
$zaznam = mysqli_fetch_array($data);


if (isset($_POST["sended"])) {
    if (empty($_POST["jmeno"]) || empty($_POST["prijmeni"])) {
        echo "<p class='hlaska'>Vyplňte formulář</p>";
    }elseif (empty($_POST["heslo"])) {
        $jmeno = htmlspecialchars($_POST["jmeno"]);
        $prijmeni = htmlspecialchars($_POST["prijmeni"]);
        uprav($_GET['id'], $jmeno, $prijmeni, "");
    } else {
        $jmeno = htmlspecialchars($_POST["jmeno"]);
        $prijmeni = htmlspecialchars($_POST["prijmeni"]);
        $hesloN = htmlspecialchars($_POST["heslo"]);
        $heslo = password_hash($hesloN, PASSWORD_BCRYPT);
        uprav($_GET['id'], $jmeno, $prijmeni, $heslo);
    }
}
?>

<form action="" method="POST">
    <h1 class='nadpis' id="prvni">Úprava uživatele</h1>
    <input type="text" name="jmeno"  required value="<?php echo $zaznam['jmeno']; ?>">
    <input type="text" name="prijmeni" required value="<?php echo $zaznam['prijmeni']; ?>">
    <input type="password" name="heslo" placeholder="Heslo">
    <input type="submit" name="sended" class="send" value="Odeslat">
</form>
