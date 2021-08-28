<?php 

session_start();

include("baza.php");
$veza = spojiSeNaBazu();

$upit_javne = "SELECT k.ime as ime, k.prezime as prezime, COUNT(*) as broj_slika FROM korisnik k, slika s WHERE status=1 and k.korisnik_id=s.korisnik_id GROUP BY k.korisnik_id ORDER BY k.prezime";
$rez_javne = izvrsiUpit($veza, $upit_javne);
$upit_privatne = "SELECT k.ime as ime, k.prezime as prezime, COUNT(*) as broj_slika FROM korisnik k, slika s WHERE status=0 and k.korisnik_id=s.korisnik_id GROUP BY k.korisnik_id ORDER BY k.prezime";
$rez_privatno = izvrsiUpit($veza, $upit_privatne);

zatvoriVezuNaBazu($veza);
           ?>

<!DOCTYPE html>
<html>

<head>

</head>
<meta charset="utf-8">
<title>Statistika</title>
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

    <div>
        <table border = "1" style="width: 350px; height: 170px; background-color: #b0ee91; margin-top: 10px; margin-left: 350px; border: rgb(25, 162, 143) solid 2px;text-align: right;">
            <caption style = "font-size: 1.5em;padding: 5px">Ispis javnih slika</caption>
            <thead>
                <tr>
                    <th>Ime</th>
                    <th> Prezime</th>
                    <th> Broj javnih slika</th>
                    
                </tr>
            </thead>
            <tbody >
                <?php
                if($rez_javne){
                    while($red = mysqli_fetch_array($rez_javne)){
                        echo "<tr>";
                        echo "<td>{$red["ime"]}</td>";
                        echo "<td>{$red["prezime"]}</td>";
                        echo "<td>{$red["broj_slika"]}</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
        <br>
        </div>

        <div>
        <table border = "1" style="width: 350px; height: 170px; background-color: #b0ee91; margin-top: 10px; margin-left: 1px; border: rgb(25, 162, 143) solid 2px;text-align: right;">
            <caption style = "font-size: 1.5em;padding: 5px">Ispis privatnih slika</caption>
            <thead>
                <tr>
                    <th>Ime</th>
                    <th> Prezime</th>
                    <th> Broj javnih slika</th>
                    
                </tr>
            </thead>
            <tbody >
                <?php
                if($rez_privatno){
                    while($red = mysqli_fetch_array($rez_privatno)){
                        echo "<tr>";
                        echo "<td>{$red["ime"]}</td>";
                        echo "<td>{$red["prezime"]}</td>";
                        echo "<td>{$red["broj_slika"]}</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
        <br>
        </div>
        
    </section>


</body>

</html>