<?php 
session_start();

include("baza.php");
$veza = spojiSeNaBazu();
$greska = "";
$poruka = "";
$planine = "SELECT * FROM planina";
$rezultat_planine = izvrsiUpit($veza,$planine);


if(isset($_POST["submit"])){

   
    $naziv_fotografije = $_POST["naziv_fotografije"];
    $opis_slike = $_POST["opis_slike"];
    $datum_i_vrijeme = date("Y.m.d H:i:s",strtotime($_POST['datum_i_vrijeme']));
    $naziv_planine = $_POST["naziv_planine"];
    $url_fotografije = $_POST["url_fotografije"];

    

    if($_SESSION["blok"] == 1){
        $greska = "Blokirani ste! <br>";
    }
    if(!isset($naziv_fotografije) || empty($naziv_fotografije)){
        $greska = "Niste unijeli naziv fotografije! <br>";
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
        $upit = "INSERT INTO slika (planina_id, korisnik_id, naziv, url, opis, datum_vrijeme_slikanja, status) 
        VALUES ('{$naziv_planine}','{$_SESSION['id']}','{$naziv_fotografije}','{$url_fotografije}','{$opis_slike}','{$datum_i_vrijeme}',1)";
        izvrsiUpit($veza,$upit);
        $id_novi_korisnik = mysqli_insert_id($veza);
        $poruka = 'Fotografija je dodana!';
        header("Location: profil.php?id=1");
        exit();
       }  
    }


$upit = "SELECT * FROM slika WHERE korisnik_id = {$_SESSION['id']} ";
$rezultat = izvrsiUpit($veza,$upit);
$red = mysqli_fetch_array($rezultat);
zatvoriVezuNaBazu($veza);
?>
<!DOCTYPE html>
<html>

<head>

</head>
<meta charset="utf-8">
<title>Profil</title>
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
    <?php echo "<h1 style= 'text-align:center;'>Korisnik: {$_SESSION['ime']} {$_SESSION['prezime']}</h1>" ?>
        <div style="width: 350px; height: 200px; background-color: #b0ee91; margin-left: 38%; border: rgb(25, 162, 143) solid 2px;text-align: right; padding: 20px">
        <h2 style= "text-align:center;">Dodaj novu sliku </h2>
        <form id="dodaj_novog_forma" name="forma_dodaj"method="POST" action="<?php echo $_SERVER["PHP_SELF"] ?>">
                <label for="naziv_fotografije">Naziv fotografije: </label>
                <input name="naziv_fotografije" id="naziv_fotografije" type="text" />
                <br/>
                <label for="opis_slike">Opis slike: </label>
                <input name="opis_slike" id="opis_slike" type="text" />
                <br/>
                <label for="datum_i_vrijeme">Datum i vrijeme: </label>
                <input name="datum_i_vrijeme" id="datum_i_vrijeme" type="text"  placeholder="dd.mm.gggg hh:mm:ss" />
                <br/>
                <label for="naziv_planine">Naziv planine: </label>
                <select id="naziv_planine" name="naziv_planine">

<option value="" > --odaberi--
<?php
while($red_planine = mysqli_fetch_array($rezultat_planine)) {
echo "<option value={$red_planine['planina_id']}>{$red_planine['naziv']}</option>";
}
?>
</select>
           <br/>
           <label for="url_fotografije">URL fotografije: </label>
                <input name="url_fotografije" id="url_fotografije" type="text" />
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
        
       
        <?php
        while($red = mysqli_fetch_array($rezultat)) { 
            if($red['status'] == 1){
                    $status = "javna slika";
            }else $status = "privatna slika";

    echo "<div class='slika'><a href='odabrana_slika.php?id_slika={$red['slika_id']}&id_planina={$red['planina_id']}&id_korisnik={$red['korisnik_id']}'><img src='{$red['url']}' width='700' height = '400'  ><a>
            <h1>{$red['naziv']} ($status)</h1>
            <p>'{$red['opis']}'</p>
            <button type='button' ><a href='azuriranje_slike.php?slika_id={$red['slika_id']} '>Ažuriraj</a></button>
    </div>" ;
         }  ?>
     

    </section>

</body>

</html>