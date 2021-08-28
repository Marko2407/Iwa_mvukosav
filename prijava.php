<?php 
session_start();

if (isset($_GET["odjava"])){
       session_destroy();
       header("Location: index.php");
                        exit();
}

include("baza.php");
 
$veza = spojiSeNaBazu();

if(isset($_POST["submit"])){
    $greska = "";
    $poruka = "";
    $korIme = $_POST["korime"];
    $korLozinka = $_POST["lozinka"];

    if(isset($korIme) && !empty($korIme) &&
         isset($korLozinka) && !empty($korLozinka)){
                $upit = "SELECT * FROM korisnik WHERE korisnicko_ime ='{$korIme}'AND lozinka='{$korLozinka}'";
                $rezultat = izvrsiUpit($veza,$upit);    
                $prijava = false;
                while($red = mysqli_fetch_array($rezultat)){
                    $_SESSION['tip'] = $red['tip_korisnika_id'];
                    $_SESSION['ime'] = $red['ime'];
                    $_SESSION['blok'] = $red['blokiran'];
                    $_SESSION['prezime'] = $red['prezime'];
                    $_SESSION['id'] = $red[0];
                   
                    $prijava = true;
                    
                }


             if($prijava){
                        $poruka = "Korisnik ulogiran";
                        header("Location: index.php");
                        exit();
             }
             else {
                 $greska = "Korisničko ime i/ili lozinka nije ispravna";
             }
}
else {
                $greska = "Korisničko ime i/ili lozinka nisu uneseni";
}
}

zatvoriVezuNaBazu($veza);
?>

<!DOCTYPE html>
<html>

<head>

</head>
<meta charset="utf-8">
<title>Prijava</title>
<link rel="stylesheet" type="text/css" href="design.css">


<body>

    <header>
        <nav>
        <?php 
           include "meni.php";
           ?>
        </nav>
    </header>
    <section>
        <div style="width: 350px; height: 130px; background-color: #b0ee91; margin-top: 250px; margin-left: 600px; border: rgb(25, 162, 143) solid 2px;">
            <form id="prijava_forma" name="forma_za_prijavu"method="POST" action="<?php echo $_SERVER["PHP_SELF"] ?>">
                <label for="korime">Korisničko ime: </label>
                <input name="korime" id="korime" type="text" />
                <br/>
                <label for="lozinka">Lozinka: </label>
                <input name="lozinka" id="lozinka" type="password" />
                <br/>
                <input type="submit" name="submit" id="submit" value="Prijavi se" />
            </form>
        </div>
        <div>
          <?php
                if(isset($greska)){
                    echo "<p style='color:red'>$greska</p>";
                }
                if(isset($_COOKIE['kolacic'])){
                    echo "<p style='color: green'>{$_COOKIE['kolacic']}</p>";
                }
          ?>    
        </div>

    </section>

</body>

</html>