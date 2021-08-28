<?php 
session_start();
include("baza.php");
$veza = spojiSeNaBazu();
$id_azuriranja_korisnik = $_GET["id"];
$greska = "";
$poruka = "";

if(isset($_POST["submit"])){

    $tip_korisnika = $_POST["tip_korisnika_id"];
    $korIme = $_POST["korime"];
    $lozinka = $_POST["lozinka"];
    $ime = $_POST["ime"];
    $prezime = $_POST["prezime"];
    $email = $_POST["email"];
    $blokiran = $_POST["blokiran"];
    $slika = $_POST["slika"];

    if(!isset($korIme) || empty($korIme)){
        $greska = "Niste unijeli korisničko ime! <br>";
    }
    if(!isset($lozinka) || empty($lozinka)){
        $greska = "Niste unijeli lozinku! <br>";
    }
    if(!isset($ime) || empty($ime)){
        $greska = "Niste unijeli ime! <br>";
    }
    if(!isset($prezime) || empty($prezime)){
        $greska = "Niste unijeli prezime! <br>";
    }
    if(!isset($email) || empty($email)){
       $greska = "Niste unijeli email! <br>";
    }
    if(!isset($email)){
        $greska = "Niste unijeli sliku! <br>";
     }

    
    if(empty($greska)){
      
        $upit = "UPDATE korisnik SET tip_korisnika_id='{$tip_korisnika}', ime = '{$ime}', prezime = '{$prezime}', email = '{$email}', korisnicko_ime='{$korIme}',
        lozinka = '{$lozinka}', blokiran = '{$blokiran}', slika = '{$slika}' WHERE korisnik_id = '{$id_azuriranja_korisnik}'";
        izvrsiUpit($veza,$upit);
        $poruka = "Ažurirali ste korisnika pod ključem: $id_azuriranja_korisnik";
        header("Location: admin.php?");
exit();
            }

}

$upit = "SELECT * FROM korisnik WHERE korisnik_id = '{$id_azuriranja_korisnik}'";
$rezultat = izvrsiUpit($veza,$upit);
$rezultat_ispis = mysqli_fetch_array($rezultat);

$upit = "SELECT * FROM tip_korisnika";
$rezultat_tipovi = izvrsiUpit($veza,$upit);

zatvoriVezuNaBazu($veza);
?>
<!DOCTYPE html>
<html>

<head>

</head>
<meta charset="utf-8">
<title>Ažuriraj korisnika</title>
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
    <?php

     echo "<h2 style= 'color: red; text-align:center;'>Ažuriranje korisnika pod ID: $id_azuriranja_korisnik </h2>";
                ?>

        <div style="width: 370px; height: 220px; background-color: #b0ee91; margin-top: 50px; margin-left: 670px; border: rgb(25, 162, 143) solid 2px;text-align: right; padding-right: 20px">
            <form id="azuriraj_forma" name="forma_azuriraj"method="POST" action="
            <?php echo $_SERVER["PHP_SELF"]."?id={$id_azuriranja_korisnik}";?>"  enctype="multipart/form-data">
            <label for="tip_korisnika_id">Tip korisnika: </label>
               <select name = "tip_korisnika_id"> 
                    <?php 
                    while($red = mysqli_fetch_array($rezultat_tipovi)){
                        echo "<option value='{$red["tip_korisnika_id"]}'";
                        echo ">{$red["naziv"]}</option>";
                    }
                    
                    ?>
               </select>
                <br/>
                <label for="korime">Korisničko ime: </label>
                <input name="korime" id="korime" type="text" value="<?php echo $rezultat_ispis["korisnicko_ime"] ?>" />
                <br/>
                <label for="lozinka">Lozinka: </label>
                <input name="lozinka" id="lozinka" type="password" value="<?php echo $rezultat_ispis["lozinka"] ?>"/>
                <br/>
                <label for="ime">ime: </label>
                <input name="ime" id="ime" type="text" value="<?php echo $rezultat_ispis["ime"] ?>" />
                <br/>
                <label for="prezime">prezime: </label>
                <input name="prezime" id="prezime" type="text" value="<?php echo $rezultat_ispis["prezime"] ?>"  />
                <br/>
                <label for="email">Email: </label>
                <input name="email" id="email" type="email"  value="<?php echo $rezultat_ispis["email"] ?>" />
                <br/>
                <label for="blokiran">Blokiran: </label>
                <input type="radio" name="blokiran" value= "1" <?php if  ($rezultat_ispis["blokiran"] == 1){ echo "checked";} ?> />Da
                <input type="radio" name="blokiran" value= "0" <?php if  ($rezultat_ispis["blokiran"] == 0){ echo "checked";} ?> />Ne
                <br/>
                <input type="hidden" name="MAX_SIZE_FILE" value = "300000"/>
                <label for="slika">Slika: </label>
                <input name="slika" id="slika" type="file"  value="" />
                <br/>
                <input type="submit" name="submit" id="submit" value="Ažuriraj" />
            </form>

        </div>
        <div  style="width: 350px; margin-top: 10px; margin-left: 630px;text-align: center;">
                <?php
                echo "<p style= 'color: red'> $greska </p>";
                echo "<p style= 'color: green'> $poruka </p>";
               

                ?>
                <br>
        </div>
    </section>

</body>

</html>