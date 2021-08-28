<?php 
session_start();

include("baza.php");
$veza = spojiSeNaBazu();
$greska = "";
$poruka = "";
$id_azuriranja_slika = $_GET["slika_id"];


if(isset($_POST["submit"])){

   
    $naziv_fotografije = $_POST["naziv_fotografije"];
    $opis_slike = $_POST["opis_slike"];
    $datum_i_vrijeme = date("Y.m.d H:i:s",strtotime($_POST['datum_i_vrijeme']));
    $naziv_planine = $_POST["naziv_planine"];
    $url_fotografije = $_POST["url_fotografije"];
    $status_slike = $_POST["status"];



    if(!isset($naziv_fotografije) || empty($naziv_fotografije)){
        $greska = "Niste unijeli naziv fotografije! <br>";
    }
    if(!isset($opis_slike) || empty($opis_slike)){
        $greska = "Niste unijeli opis slike ! <br>";
    }
    if(!isset($datum_i_vrijeme) || empty($datum_i_vrijeme)){
        $greska = "Niste unijeli datum i vrijeme ! <br>";
    }
    if(!isset($naziv_planine) || empty($naziv_planine)){
        $greska = "Niste odabrali naziv planine! <br>";
    }
    if(!isset($url_fotografije) || empty($url_fotografije)){
        $greska = "Niste unijeli URL! <br>";
    }

    if(empty($greska)){

        $upit_azuriraj = "UPDATE slika SET 
        naziv='{$naziv_fotografije}',
        planina_id = '{$naziv_planine}',
        url='{$url_fotografije}',
        opis='{$opis_slike}', 
        datum_vrijeme_slikanja='{$datum_i_vrijeme}', 
        status='{$status_slike}'
        WHERE slika_id = '{$id_azuriranja_slika}'";
        $rezultat = izvrsiUpit($veza,$upit_azuriraj);
        $poruka = "Ažurirali ste planinu pod ključem: $id_azuriranja_slika";
        header("Location: profil.php?slika=1");
        exit();
       }  
    }
$planine = "SELECT * FROM planina";
$rezultat_planine = izvrsiUpit($veza,$planine);
$upit = "SELECT * FROM slika WHERE slika_id = {$id_azuriranja_slika} ";
$rezultat = izvrsiUpit($veza,$upit);
$red = mysqli_fetch_array($rezultat);
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
    <?php echo "<h1 style= 'text-align:center;'>Slika id: {$id_azuriranja_slika}</h1>" ?>

        <div style="width: 350px; height: 200px; background-color: #b0ee91; margin-left: 38%; border: rgb(25, 162, 143) solid 2px;text-align: right; padding: 20px">
        <h2 style= "text-align:center;">Ažuriraj sliku </h2>
        <form id="dodaj_novog_forma" name="forma_dodaj"method="POST" action="
        <?php echo $_SERVER["PHP_SELF"]."?slika_id={$id_azuriranja_slika}";?>">
                <label for="naziv_fotografije">Naziv fotografije: </label>
                <input name="naziv_fotografije" id="naziv_fotografije" type="text" value="<?php echo $red["naziv"] ?>"/>
                <br/>
                <label for="opis_slike">Opis slike: </label>
                <input name="opis_slike" id="opis_slike" type="text" value="<?php echo $red["opis"] ?>" />
                <br/>
                <label for="datum_i_vrijeme">Datum i vrijeme: </label>
                <input name="datum_i_vrijeme" id="datum_i_vrijeme" type="text"  placeholder="dd.mm.gggg hh:mm:ss" value="<?php echo $red["datum_vrijeme_slikanja"] ?>" />
                <br/>
               
               
                <label for="naziv_planine">Naziv planine: </label>
                <select id="naziv_planine" name="naziv_planine">

                <option value="" > --odaberi--
                <?php
                while($red_planine = mysqli_fetch_array($rezultat_planine)) {
                echo "<option value='{$red_planine["planina_id"]}'";
                if($red['planina_id'] == $red_planine['planina_id']){
                    echo "selected ='selected'";
                }
                echo ">{$red_planine["naziv"]}</option>";
                }
                ?>
                </select>
           <br/>
           <label for="url_fotografije">URL fotografije: </label>
                <input name="url_fotografije" id="url_fotografije" type="text" value="<?php echo $red["url"] ?>"/>
                <br/>



            <label for="status">Status: </label>
                <input type="radio" name="status" value= "1" <?php if  ($red["status"] == 1){ echo "checked";} ?> />Javna
                <input type="radio" name="status" value= "0" <?php if  ($red["status"] == 0){ echo "checked";} ?> />Privatna
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