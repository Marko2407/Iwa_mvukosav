<?php 
session_start();
include("baza.php");
$veza = spojiSeNaBazu();
$id_azuriranja_planine = $_GET["id"];
$greska = "";
$poruka = "";


if(isset($_POST["submit"])){

    $naziv = $_POST["naziv"];
    $opis = $_POST["opis"];
    $lokacija = $_POST["lokacija"];
    $sirina = $_POST["geografska_sirina"];
    $duzina = $_POST["geografska_duzina"];


    if(!isset($naziv) || empty($naziv)){
        $greska = "Niste unijeli naziv! <br>";
    }
    if(!isset($opis) || empty($opis)){
        $greska = "Niste unijeli opis! <br>";
    }
    if(!isset($lokacija) || empty($lokacija)){
        $greska = "Niste unijeli lokaciju! <br>";
    }
    if(!isset($sirina) || empty($sirina)){
        $greska = "Niste unijeli geografsku sirinu! <br>";
    }

     if(!isset($duzina) || empty($duzina)){
        $greska = "Niste unijeli geografsku duzinu! <br>";
     }
     if(!isset($_POST['moderatori'])){
        $greska = "Niste odabrali moderatora! <br>";
     }
    
    if(empty($greska)){
     
        $upit = "UPDATE planina SET naziv='{$naziv}', opis = '{$opis}', lokacija = '{$lokacija}', geografska_sirina = '{$sirina}', geografska_duzina='{$duzina}'
         WHERE planina_id = '{$id_azuriranja_planine}'";
        izvrsiUpit($veza,$upit);

        $upit = "DELETE FROM moderator WHERE planina_id = {$id_azuriranja_planine}";
        izvrsiUpit($veza,$upit);
        
        foreach ($_POST['moderatori'] as $moderator){
         $upit_moderator = "INSERT INTO moderator (korisnik_id, planina_id) VALUES ({$moderator}, {$id_azuriranja_planine})";
        izvrsiUpit($veza,$upit_moderator);
        }
        
        $poruka = "Ažurirali ste planinu pod ključem: $id_azuriranja_planine";
        header("Location: admin.php?planina=1");
        exit();
            }

}

$upit = "SELECT * FROM planina WHERE planina_id = '{$id_azuriranja_planine}'";
$rezultat = izvrsiUpit($veza,$upit);
$rezultat_ispis = mysqli_fetch_array($rezultat);

$upit_moderatori = "SELECT * FROM korisnik WHERE  tip_korisnika_id = 1 OR tip_korisnika_id = 0 ";
$rezultat_moderatori = izvrsiUpit($veza,$upit_moderatori);

zatvoriVezuNaBazu($veza);
?>
<!DOCTYPE html>
<html>

<head>

</head>
<meta charset="utf-8">
<title>Ažuriraj planinu</title>
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

     echo "<h2 style= 'color: red; text-align:center;'>Ažuriranje planine pod ID: $id_azuriranja_planine </h2>";
                ?>
    <div style="width: 400px; height: auto; background-color: #b0ee91; margin-top: 250px; margin-left: 600px; border: rgb(25, 162, 143) solid 2px;text-align: right; padding: 10px; padding-right: 20px">
            <form id="dodaj_planinu" name="forma_dodaj_planinu"method="POST" action="
            <?php echo $_SERVER["PHP_SELF"]."?id={$id_azuriranja_planine}"; ?>">
                <label for="naziv">Naziv: </label>
                <input name="naziv" id="naziv" type="text"  value="<?php echo $rezultat_ispis["naziv"] ?>" />
                <br/>
                <label for="opis">Opis: </label>
                <input name="opis" id="opis" type="text" value="<?php echo $rezultat_ispis["opis"]?>" />
                <br/>
                <label for="lokacija">Lokacija: </label>
                <input name="lokacija" id="lokacija" type="text" value="<?php echo $rezultat_ispis["lokacija"]?>" />
                <br/>
                <label for="geografska_sirina">Geografska širina: </label>
                <input name="geografska_sirina" id="geografska_sirina" type="number" step=any value="<?php echo $rezultat_ispis["geografska_sirina"]?>" />
                <br/>
                <label for="geografska_duzina">Geografska dužina: </label>
                <input name="geografska_duzina" id="geografska_duzina" type="number" step=any value="<?php echo $rezultat_ispis["geografska_duzina"]?>"  />
                <br/>
                <label for="moderatori[]">Moderatori: </label>
                
                <?php
                    while ($red = mysqli_fetch_array($rezultat_moderatori)) {
                        echo "<input multiple type='checkbox' id='moderatori[]' name='moderatori[]' value='{$red['korisnik_id']}'";
                        echo ">{$red["korisnicko_ime"]}<br>";
                    }
                ?>
            <br>
                    <br>
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