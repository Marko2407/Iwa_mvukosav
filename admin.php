<?php 

session_start();

include_once("baza.php");
$veza = spojiSeNaBazu();
$upit = "SELECT * FROM korisnik";
$rezultat = izvrsiUpit($veza,$upit);


$upit_planine = "SELECT * FROM planina";
$planine = izvrsiUpit($veza,$upit_planine);
zatvoriVezuNaBazu($veza);
           ?>

<!DOCTYPE html>
<html>

<head>

</head>
<meta charset="utf-8">
<title>Admin</title>
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

    <div id="admin_nav">
    <a  id = "a" href="dodaj_novog_korisnika.php">Registriraj novog korisnika</a>
	<a  href="dodaj_planinu.php">Dodaj novu planinu</a>
    <a  href="statistika.php">Statistika</a>
    </div>
    <div>
        <table border = "1" style="width: 350px; height: auto; background-color: #b0ee91; margin-top: 10px; margin-left: -155px; border: rgb(25, 162, 143) solid 2px;text-align: right;">
            <caption style = "font-size: 1.5em;padding: 5px">Ispis svih korisnika</caption>
            <thead>
                <tr>
                    <th>Korisnik ID</th>
                    <th> Blokiran</th>
                    <th> Tip korisnika</th>
                    <th> ime</th>
                    <th> Prezime</th>
                    <th> Email</th>
                    <th> Korisničko ime</th>
                    <th> Lozinka</th>
                    <th>Slika</th>
                    <th>Ažuriraj</th>
                </tr>
            </thead>
            <tbody >
                <?php
                if($rezultat){
                    while($red = mysqli_fetch_array($rezultat)){
                        echo "<tr>";
                        echo "<td>{$red[0]}</td>";
                        echo "<td>{$red["blokiran"]}</td>";
                        echo "<td>{$red["tip_korisnika_id"]}</td>";
                        echo "<td>{$red["ime"]}</td>";
                        echo "<td>{$red["prezime"]}</td>";
                        echo "<td>{$red["email"]}</td>";
                        echo "<td>{$red["korisnicko_ime"]}</td>";
                        echo "<td>{$red["lozinka"]}</td>";
                        echo "<td><img src='{$red["slika"]}' alt='{$red["slika"]}' width='40' height = '40'  ></td>";
                        echo "<td><a href='azuriranje_korisnika.php?id={$red[0]} '>Ažuriraj</a></td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
        <br>
        </div>
        <div>
        <table border = "1" style="width: 900px; height: 170px; background-color: #b0ee91; margin-top: 10px; margin-left: -22px; border: rgb(25, 162, 143) solid 2px;text-align: right;">
            <caption style = "font-size: 1.5em;padding: 5px">Ispis svih planina</caption>
            <thead>
                <tr>
                    <th>Planina ID</th>
                    <th> Naziv</th>
                    <th> Opis</th>
                    <th> Lokacija</th>
                    <th> Geografska širina</th>
                    <th> Geografska dužina</th>
                    <th>Ažuriraj</th>
                </tr>
            </thead>
            <tbody >
                <?php
                if($planine){
                    while($red = mysqli_fetch_array($planine)){
                        echo "<tr>";
                        echo "<td>{$red[0]}</td>";
                        echo "<td>{$red[1]}</td>";
                        echo "<td>{$red[2]}</td>";
                        echo "<td>{$red[3]}</td>";
                        echo "<td>{$red[4]}</td>";
                        echo "<td>{$red[5]}</td>";
                        echo "<td><a href='azuriranje_planine.php?id={$red[0]} '>Ažuriraj</a></td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
            </div>


    </section>


</body>

</html>