<?php 
include("baza.php");
session_start();
$veza = spojiSeNaBazu();


if(isset($_POST["submit"])){
    $upit_blok = "UPDATE korisnik SET blokiran= 1 WHERE korisnik_id= {$_GET['id']}"; 
    izvrsiUpit($veza, $upit_blok); 
    $upit_slike_blok = "UPDATE slika SET status = 0 WHERE korisnik_id= {$_GET['id']}";
    izvrsiUpit($veza, $upit_slike_blok);
    header("Location: planina_odabrana_slika.php");
    exit();

}

if(isset($_GET['id']) && isset($_GET['id_planine']) ){
    $slika = "SELECT * FROM slika WHERE korisnik_id = {$_GET['id']} AND planina_id = {$_GET['id_planine']} AND  status= 1";
    $rezultat_slike = izvrsiUpit($veza,$slika);
}

zatvoriVezuNaBazu($veza);
 ?>

<!DOCTYPE html>
<html lang="hr">

<head>

</head>
<meta charset="utf-8">
<title>Planine korisnika </title>
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

    
        <form id="blokiraj_forma"  method="POST" action="<?php echo $_SERVER["PHP_SELF"]."?id={$_GET['id']}";?>"  style="margin-top: 10px; text-align: center "  >
        <input type="submit" name="submit" id="submit" value="Blokiraj korisnika" />
        </form>
     
       
<?php
if(isset($rezultat_slike)){
while($red = mysqli_fetch_array($rezultat_slike)) { 
    

    echo "<div class='slika'><a href='odabrana_slika.php?id_slika={$red['slika_id']}&id_planina={$red['planina_id']}&id_korisnik={$red['korisnik_id']}'><img src='{$red['url']}' width='700' height = '400'  ><a>
            <h1>'{$red['naziv']}'</h1>
            <p>'{$red['opis']}'</p>
    </div>" ;
         } } ?>
     
 
    </section>

</body>

</html>