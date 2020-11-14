<?php

function spojeni() {
    $db = new mysqli("localhost", "root", "", "iwww");
    if ($db->errno > 0)
        die("Nefunguje");
    $db->set_charset("utf8");
    return $db;
}

function registrace() {
    $db = spojeni();
    if (isset($_POST["sended"])) {
        if (empty($_POST["jmeno"]) || empty($_POST["prijmeni"]) || empty($_POST["heslo"]) || empty($_POST["email"])) {
            echo "Vyplň formulář";
        } else {
            $jmeno = $_POST["jmeno"];
            $prijmeni = $_POST["prijmeni"];
            $email = $_POST["email"];
            $heslo = password_hash($_POST["heslo"], PASSWORD_BCRYPT);
            $chyba = 0;


            $sql = "SELECT * FROM uzivatele WHERE email='" . $email . "'";
            if ($data = $db->query($sql)) {
                if ($data->num_rows > 0) {
                    $chyba = 1;
                }
            }

            if ($chyba == 1) {
                echo "Tento email již je v naší databázi.";
            } else {
                $sql5 = "INSERT INTO `uzivatele` (`jmeno`,`prijmeni`, `heslo`, `email`) VALUES (?,?,?,?);";
                if ($stmt = $db->prepare($sql5)) {
                    $stmt->bind_param("ssss", $jmeno, $prijmeni, $heslo, $email);
                    $stmt->execute();
                    $id = $stmt->insert_id;

                    echo "<p class= 'hlaska'>Jste zaregistrováni, můžete se přihlásit</p>";
                }
            }
        }
    }
}

function prihlaseni() {
    $db = spojeni();
    if (!empty($_POST["email1"]) && !empty($_POST["heslo1"])) {
        $email = $_POST["email1"];
        $heslo = $_POST["heslo1"];

        $stmt = $db->prepare("select * from uzivatele where email=? limit 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $zaznam = $result->fetch_assoc();

        if (password_verify($heslo, $zaznam["heslo"])) {
            $_SESSION["login"] = $zaznam["email"];
            rozrazeni();
        } else {
            echo "<p class= 'hlaska'>Zadali jste špatné údaje, zkuste to prosím znovu.</p>";
        }
    }
}

function rozrazeni() {
    $db = spojeni();
    if (!isset($_SESSION["login"])) {
        header("Location: index.php");
    } else {
        $dotaz = "select * from uzivatele where email='{$_SESSION["login"]}' limit 1";
        $data = mysqli_query($db, $dotaz);
        $zaznam = mysqli_fetch_array($data);
        if ($zaznam["opravneni"] == "0") {
            header("Location: uzivatel.php");
        } else if ($zaznam["opravneni"] == "1") {
            header("Location: admin.php");
        }
    }
}

function opravneniA() {
    $db = spojeni();
    if (!isset($_SESSION["login"])) {
        header("Location: index.php");
    } else {
        $dotaz = "select * from uzivatele where email='{$_SESSION["login"]}' limit 1";
        $data = mysqli_query($db, $dotaz);
        $zaznam = mysqli_fetch_array($data);
        if ($zaznam["opravneni"] != "1") {
            header("Location: uzivatel.php");
        }
    }
}

function opravneniU() {
    $db = spojeni();
    if (!isset($_SESSION["login"])) {
        header("Location: index.php");
    } else {
        $dotaz = "select * from uzivatele where email='{$_SESSION["login"]}' limit 1";
        $data = mysqli_query($db, $dotaz);
        if (!$zaznam = mysqli_fetch_array($data)) {
            header("Location: index.php");
        }
    }
}

function Menu() {
    $db = spojeni();
    if (isset($_SESSION["login"])) {
        $dotaz = "select * from uzivatele where email='{$_SESSION["login"]}' limit 1";
        $data = mysqli_query($db, $dotaz);
        $zaznam = mysqli_fetch_array($data);
        if ($zaznam["opravneni"] == "0") {
            include 'header_user.php';
        } else if ($zaznam["opravneni"] == "1") {
            include 'header_admin.php';
        }
    } else {
        include 'header.php';
    }
}

function VypisUzivatelu() {
    $db = spojeni();
    $sql = "SELECT uzivatele.jmeno as jmeno, uzivatele.prijmeni as prijmeni, uzivatele.email as email, uzivatele.id as idU FROM uzivatele WHERE uzivatele.opravneni = 0 ORDER by uzivatele.prijmeni";
    if ($data = $db->query($sql)) {
        if ($data->num_rows > 0) {

            echo "<table>";
            echo "<tr><th>Jméno</th><th>Příjmení</th><th>Email</th><th>Upravit</th><th>Smazat</th></tr>";
            while ($row = $data->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['jmeno']}</td>";
                echo "<td>{$row['prijmeni']}</td>";
                echo "<td>{$row['email']}</td>";
                echo"<td><a href='uprava.php?id=$row[idU]'>Upravit</a></td>";
                echo"<td><a href='mazani.php?id=$row[idU]'>Smazat</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else
            echo "<p class='hlaska'>Nejsou tu žádní uživatelé.</p>";
    }
}

function smaz($id) {
    $db = spojeni();
    $sql = "DELETE FROM uzivatele WHERE id = $id";
    if ($db->query($sql) === TRUE) {
        echo "Odstraněno";
    } else {
        echo "Záznam neexistuje";
    }
}

function uprav($id, $jmeno, $prijmeni, $heslo) {
    $db = spojeni();
    if ($heslo == "") {
        $sql = "UPDATE uzivatele SET jmeno = ?, prijmeni = ? WHERE id = $id";
        if ($stmt = $db->prepare($sql)) {
            $stmt->bind_param("ss", $jmeno, $prijmeni);
            $stmt->execute();
            header("Location: vypis_uzivatelu.php");
        } else {
            echo "<p>Nefunguje</p>";
        }
    } else {
        $sql = "UPDATE uzivatele SET jmeno = ?, prijmeni = ?, heslo = ? WHERE id = $id";
        if ($stmt = $db->prepare($sql)) {
            $stmt->bind_param("sss", $jmeno, $prijmeni, $heslo);
            $stmt->execute();
            header("Location: vypis_uzivatelu.php");
        } else {
            echo "<p>Nefunguje</p>";
        }
    }
}
