<?php 

session_start();

           ?>

<!DOCTYPE html>
<html>

<head>

</head>
<meta charset="utf-8">
<title>O autoru</title>
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

        <div style="width: 500px; height: 350px; background-color: #b0ee91; margin-top: 100px; margin-left: 500px; border: rgb(25, 162, 143) solid 2px;">
            <img id="autor" src="slike/autor.jpg" alt="autor" />

            <p><b>Marko Vukosav</b></p>
            <p>JMBAG: 0016139927</p>
            <p>Email: Mvukosav@foi.hr</p>
            <p>Varaždin</p>
            <p>Godina upisa: 2020/2021</p>
        </div>

    </section>


</body>

</html>