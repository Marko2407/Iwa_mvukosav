<?php 
include("baza.php");
session_start();
$veza = spojiSeNaBazu();
$planine = "SELECT * FROM planina";
$rezultat_planine = izvrsiUpit($veza,$planine);
$slika = "SELECT * FROM slika WHERE `status` = 1";

if(isset($_GET['id_planina'])){
    $slika = "SELECT * FROM slika WHERE planina_id = '{$_GET['id_planina']}' AND status= 1";
}
if(isset($_POST["submit"])){
$planina = $_POST['planine'];
$datum_vrijeme_od = date("Y-m-d H:i:s",strtotime($_POST['datumOd']));
$datum_vrijeme_do = date("Y-m-d H:i:s",strtotime($_POST['datumDo']));
if(isset($planina)  && isset($datum_vrijeme_od) && !empty($datum_vrijeme_od) &&  isset($datum_vrijeme_do) && !empty($datum_vrijeme_do)){
    if($datum_vrijeme_do == "1970-01-01 01:00:00" ){
        $datum_vrijeme_do = date("Y-m-d H:i:s",strtotime("2031-01-01 01:00:00"));
        }
        $slika = "SELECT * FROM slika WHERE  planina_id={$planina} AND status= 1 AND datum_vrijeme_slikanja BETWEEN '{$datum_vrijeme_od}' AND '{$datum_vrijeme_do}'"; 
    if($planina == ""){
            $slika = "SELECT * FROM slika WHERE  datum_vrijeme_slikanja BETWEEN '{$datum_vrijeme_od}' AND '{$datum_vrijeme_do}' AND status= 1"; 
        }
    }
    
else $slika = "SELECT * FROM `slika` WHERE `status` = 1";
 } 
 
$rezultat_slike = izvrsiUpit($veza,$slika);
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

        <form id="filter" name="filter" method="POST" action="<?php echo $_SERVER['PHP_SELF']?>">

        <label for="planine">Planine: </label>
            <select id="planine" name="planine">

                    <option value="" > --odaberi--
            <?php
            while($red_planine = mysqli_fetch_array($rezultat_planine)) {
             echo "<option value={$red_planine['planina_id']}>{$red_planine['naziv']}</option>";
            }
             ?>
            </select>
            <label>Datum od: </label>
            <input name="datumOd" type="text"  placeholder="dd.mm.gggg hh:mm:ss">
            <label> Datum do: </label>
            <input name="datumDo" type="text" placeholder="dd.mm.gggg hh:mm:ss">
            <button name="submit" type="submit">Traži</button>

        </form>
       
<?php
while($red = mysqli_fetch_array($rezultat_slike)) { 
    

    echo "<div class='slika'><a href='odabrana_slika.php?id_slika={$red['slika_id']}&id_planina={$red['planina_id']}&id_korisnik={$red['korisnik_id']}'><img src='{$red['url']}' width='700' height = '400'  ><a>
            <h1>'{$red['naziv']}'</h1>
            <p>'{$red['opis']}'</p>
    </div>" ;
         }  ?>
     
    </section>

</body>

</html>