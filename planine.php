<?php 

session_start();
include("baza.php");
$veza = spojiSeNaBazu();

$upit_moderator_planine = "SELECT p.planina_id as planina_id, p.naziv as planina FROM planina p, moderator m WHERE m.planina_id=p.planina_id AND m.korisnik_id = {$_SESSION['id']}";
$rezultat_moderator_planine = izvrsiUpit($veza,$upit_moderator_planine);


if(!empty( $_GET['id_planine'])){
    $id_planine = $_GET['id_planine'];
  $upit_planine_slike= "SELECT k.ime as ime,k.korisnik_id as id, k.prezime as prezime, s.naziv as slika, s.url as url FROM korisnik k, slika s WHERE s.korisnik_id=k.korisnik_id AND s.status=1 AND s.planina_id={$id_planine}";
$rezultat_planine_slike = izvrsiUpit($veza,$upit_planine_slike);  
}



zatvoriVezuNaBazu($veza);
           ?>

<!DOCTYPE html>
<html lang="hr">

<head>

</head>
<meta charset="utf-8">
<title>Početna</title>
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

    

   
<div class= 'planine_naziv'>
    
    <?php
while($red = mysqli_fetch_array($rezultat_moderator_planine)) { 
    echo "<a class= 'nazivh1' href='planine.php?id_planine={$red['planina_id']}'><p>{$red['planina']}</p><a>" ;
}  ?>
         </div>


         <div>
        <table border = "1" style="width: 700px; height: 170px; background-color: #b0ee91; margin-top: 10px; margin-left: 25%; border: rgb(25, 162, 143) solid 2px;text-align: right;">
            <caption style = "font-size: 1.5em;padding: 5px">Ispis svih planina</caption>
            <thead>
                <tr>
                    <th>naziv slike</th>
                    <th> Ime</th>
                    <th> Prezime</th>
                </tr>
            </thead>
            <tbody >
                <?php
                if(isset($rezultat_planine_slike)){
                    while($red = mysqli_fetch_array($rezultat_planine_slike)){
                        echo "<tr>";
                        echo "<td>{$red['slika']}</td>";
                        echo "<td>{$red['ime']}</td>";
                        echo "<td><a href='planina_odabrana_slika.php?id={$red['id']}&&id_planine={$id_planine} '>{$red['prezime']}</a></td>";
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