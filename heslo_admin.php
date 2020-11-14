<?php
session_start();
include 'funkce.php';
opravneniA();
Menu();
?>
<form method="POST" action="" class="form">
<h1 class='nadpis'>Změna hesla</h1>
<input type="password" name="stare_heslo" placeholder="Staré heslo" required >
<input type="password" name="heslo" placeholder="Nové heslo" required>
<input type="password" name="heslo1" placeholder="Nové heslo znovu" required>
<input type="submit" name="sended" value="Odeslat">
</form>
<p class="hlaska">Po změně údajů, se budete muset znovu přihlásit :)</p>
<?php
$db = spojeni();
      $dotaz2="select * from uzivatele where email='{$_SESSION["login"]}' limit 1";   
      $data2=mysqli_query($db,$dotaz2);
      $zaznam2=mysqli_fetch_array($data2);
      $stare_heslo = $zaznam2["heslo"];                             

if(isset($_POST["sended"])){
    if(empty($_POST["heslo"])){
        echo "Vyplň formulář :)";
    }else{
        $hesloS=  htmlspecialchars($_POST["stare_heslo"]);
        $hesloN=  htmlspecialchars($_POST["heslo"]);
        $hesloN1=  htmlspecialchars($_POST["heslo1"]);
        
        if(password_verify($hesloS, $stare_heslo)&&$hesloN==$hesloN1){
       
 $sql = "UPDATE uzivatele SET heslo = ? WHERE email = '".$_SESSION["login"]."'";
                        if($stmt = $db->prepare($sql))
                        {
                        $heslo = password_hash($hesloN, PASSWORD_BCRYPT);
			$stmt->bind_param("s", $heslo);
			$stmt->execute();
                        }else{
                        echo "<p>Nefunguje</p>";
}
    unset($_SESSION["login"]);  
   header("Location: index.php");
}else{
    echo "<p class='hlaska'>Zadali jste špatné údaje, zkuste to prosím znovu.</p>";
}
}
}
?>
