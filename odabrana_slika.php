<?php 

include("baza.php");
session_start();
$veza = spojiSeNaBazu();
$id_slika = $_GET['id_slika'];
$id_planina = $_GET['id_planina'];
$id_korisnika = $_GET['id_korisnik'];

$slika = "SELECT * FROM slika WHERE slika_id = '{$id_slika}'";
$rezultat = izvrsiUpit($veza,$slika);

$planina = "SELECT * FROM planina  WHERE planina_id = '{$id_planina}'";
$rezultat_planina = izvrsiUpit($veza,$planina);

$korisnik = "SELECT * FROM korisnik  WHERE korisnik_id = '{$id_korisnika }'";
$rezultat_korisnik = izvrsiUpit($veza,$korisnik);

zatvoriVezuNaBazu($veza);

           ?>

<!DOCTYPE html>
<html>

<head>

</head>
<meta charset="utf-8">
<title>Detalji slike</title>
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

        <div style="width: 700px; height: 780px; background-color: #b0ee91; margin-top: 50px;  margin-bottom: 50px; margin-left:25%; border: rgb(25, 162, 143) solid 2px;">
           
        

        <?php

        $red = mysqli_fetch_array($rezultat);
        $red_planina= mysqli_fetch_array($rezultat_planina);
        $red_korisnik= mysqli_fetch_array($rezultat_korisnik);
        $datum = date("d.m.Y H:i:s",strtotime($red['datum_vrijeme_slikanja']));
        echo "

        <div><a href='index.php?id_planina={$red['planina_id']}'><img src='{$red['url']}'  width='700' height = '400'><a>
            <p><b>Naziv slike:</b> {$red['naziv']}</p>
            <p><b>Opis slike:</b> {$red['opis']}</p>
            <p><b>Datum i vrijeme slikanja:</b> $datum </p>
            <p><b>Naziv planine:</b> {$red_planina['naziv']}</p>
            <p><b>Opis planine:</b> {$red_planina['opis']}</p>
            <p><b>Lokacija:</b> {$red_planina['lokacija']}</p>
            <p><b>Geografska širina:</b> {$red_planina['geografska_sirina']}</p>
            <p><b>Geografska dužina:</b> {$red_planina['geografska_duzina']}</p>
            <p><b>Ime i prezime:</b> {$red_korisnik['ime']}<a href='planina_odabrana_slika.php?id={$id_korisnika}&&id_planine={$id_planina}'> {$red_korisnik['prezime']} </a></p>
    </div>" ;

    ?>

    </section>


</body>

</html>