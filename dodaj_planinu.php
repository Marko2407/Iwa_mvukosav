<?php 
session_start();
include("baza.php");
$veza = spojiSeNaBazu();
$id_nova_planina = "";
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

    if(empty($greska)){
        $upit = "INSERT INTO planina (naziv, opis, lokacija, geografska_sirina, geografska_duzina) 
        VALUES ('{$naziv}','{$opis}','{$lokacija}','{$sirina}','{$duzina}')";
        izvrsiUpit($veza,$upit);
        $id_nova_planina = mysqli_insert_id($veza);

    

        foreach ($_POST['moderatori'] as $moderator){
            $upit_moderator = "INSERT INTO moderator (korisnik_id, planina_id) VALUES ({$moderator},{$id_nova_planina})";
           izvrsiUpit($veza,$upit_moderator);
           }
           
        $poruka = 'planina je dodana! pod ključem "{$id_nova_planina}"';
        header("Location: admin.php?planina=1");
        exit();
    }

}

$upit = "SELECT * FROM planina";
$rezultat_planina = izvrsiUpit($veza,$upit);
$red_planina_id = mysqli_fetch_array($rezultat_planina);


$upit = "SELECT * FROM korisnik WHERE  tip_korisnika_id = 1 OR tip_korisnika_id = 0 ";
$rezultat_moderatori = izvrsiUpit($veza,$upit);
zatvoriVezuNaBazu($veza);
?>
<!DOCTYPE html>
<html>

<head>

</head>
<meta charset="utf-8">
<title>Planinu</title>
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
        <div style="width: 400px; height: auto; background-color: #b0ee91; margin-top: 250px; margin-left: 600px; border: rgb(25, 162, 143) solid 2px;text-align: right; padding: 10px; padding-right: 20px">
            <form id="dodaj_planinu" name="forma_dodaj_planinu"method="POST" action="<?php echo $_SERVER["PHP_SELF"] ?>">
                <label for="naziv">Naziv: </label>
                <input name="naziv" id="naziv" type="text" />
                <br/>
                <label for="opis">Opis: </label>
                <input name="opis" id="opis" type="text" />
                <br/>
                <label for="lokacija">Lokacija: </label>
                <input name="lokacija" id="lokacija" type="text" />
                <br/>
                <label for="geografska_sirina">Geografska širina: </label>
                <input name="geografska_sirina" id="geografska_sirina" type="number"  min= 0 step = any />
                <br/>
                <label for="geografska_duzina">Geografska dužina: </label>
                <input name="geografska_duzina" id="geografska_duzina" type="number" min= 0 step = any />
                <br/>
                <label for="moderatori[]">Moderatori: </label>
                
                <?php
                    while ($red = mysqli_fetch_array($rezultat_moderatori)) {
                        echo "<input multiple type='checkbox' id='moderatori[]' name='moderatori[]' value='{$red['korisnik_id']}'";
                        echo ">{$red["korisnicko_ime"]}<br>";
                    }
                ?>
        
            <br>
                <input type="submit" name="submit" id="submit" value="Dodaj" />
            </form>
        </div>
    </section>

</body>

</html>