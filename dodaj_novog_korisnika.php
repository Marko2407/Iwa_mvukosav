<?php 
session_start();
include("baza.php");
$veza = spojiSeNaBazu();
$id_novi_korisnik = "";
$greska = "";
$poruka = "";

if(isset($_POST["submit"])){

    $tip_korisnika = $_POST["tipKorisnika"];
    $korIme = $_POST["korime"];
    $lozinka = $_POST["lozinka"];
    $ime = $_POST["ime"];
    $prezime = $_POST["prezime"];
    $email = $_POST["email"];
    

    $blokiran = $_POST["blokiran"];

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
    if(isset($korIme) && !empty($korIme)){
                $upit = "SELECT * FROM korisnik WHERE korisnicko_ime ='{$korIme}'";
                $rezultat = izvrsiUpit($veza,$upit);    
                while($red = mysqli_fetch_array($rezultat)){
                    $greska = "Korisničko ime već postoji!";
                }
            }
    if(empty($greska)){
        $upit = "INSERT INTO korisnik (blokiran, tip_korisnika_id, korisnicko_ime, lozinka, ime, prezime, email, slika) 
        VALUES ('{$blokiran}','{$tip_korisnika}','{$korIme}','{$lozinka}','{$ime}','{$prezime}','{$email}', '{$_POST["slika"]}')";
        izvrsiUpit($veza,$upit);
        $id_novi_korisnik = mysqli_insert_id($veza);
        $poruka = 'Korisnik je dodan! pod ključem "{$id_novi_korisnik}"';
        header("Location: admin.php?korisnik=1");
        exit();
    }

}

$upit = "SELECT * FROM korisnik";
$rezultat = izvrsiUpit($veza,$upit);
zatvoriVezuNaBazu($veza);
?>
<!DOCTYPE html>
<html>

<head>

</head>
<meta charset="utf-8">
<title>Dodaj novog korisnika</title>
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
        <div style="width: 370px; height: auto; background-color: #b0ee91; margin-top: 250px; margin-left: 600px; border: rgb(25, 162, 143) solid 2px;text-align: right; padding-right: 20px">
            <form id="dodaj_novog_forma" name="forma_dodaj"method="POST" action="<?php echo $_SERVER["PHP_SELF"] ?>" enctype="multipart/form-data">
            <label for="tipKorisnika">Tip korisnika: </label>
                <input name="tipKorisnika" id="tipKorisnika" value= "0" type="radio" /> Admin
                <input name="tipKorisnika" id="tipKorisnika" value= "1" type="radio" />  Moderator
                <input name="tipKorisnika" id="tipKorisnika" value= "2"  checked="checked" type="radio" />  Korisnik
                <br/>
                <label for="korime">Korisničko ime: </label>
                <input name="korime" id="korime" type="text" />
                <br/>
                <label for="lozinka">Lozinka: </label>
                <input name="lozinka" id="lozinka" type="password" />
                <br/>
                <label for="ime">ime: </label>
                <input name="ime" id="ime" type="text" />
                <br/>
                <label for="prezime">prezime: </label>
                <input name="prezime" id="prezime" type="text" />
                <br/>
                <label for="email">Email: </label>
                <input name="email" id="email" type="email" />
                <br/>
                <input type="hidden" name="MAX_SIZE_FILE" value = "300000"/>
                <label for="slika">Slika: </label>
                <input name="slika" id="slika" type="file"  />
                <br/>
                <label for="blokiran">Blokiran korisnik: </label>
                <input name="blokiran" id="blokiran" value= "0" type="radio"  checked="checked" /> Ne
                <input name="blokiran" id="blokiran" value= "1" type="radio" />  Da
                <br/>
                <input type="submit" name="submit" id="submit" value="Dodaj" />
            </form>
        </div>
        <div  style="width: 350px; margin-top: 10px; margin-left: 630px;text-align: center;">
                <?php
                echo "<p style='color: red'> $greska </p>";
                echo"<p style='color: green'> $poruka </p>";
                ?>
                <br>
        </div>
        

    </section>

</body>

</html>