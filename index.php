<?php 
require_once('database.php'); 
require_once('serie.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./styles/global.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Infant:wght@500&family=Kameron&family=Roboto:wght@700&display=swap" rel="stylesheet">
</head>
<body>
<?php $allSeries = series::seriesAll();?>
    <header>
        <div class="headerPage">
            <div class="menu"><a href="admin.php">Page admin</a></div>
            <div class="title"><h1>BD MEDIA</h1></div>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="researchSerie">
                <h2>Rechercher une série</h2>
                    <div class="parent">
                        <div class="div1"> <form action="index.php" method="post"><input type="text" class="inputSerie" name="searchSerie" placeholder="Ecrivez le nom de la série"> </div>
                        <div class="div2"><input type="text" class="inputSerie" name="search" placeholder="Ecrivez l'origine de la série"> </div>
                        <div class="div3"> <input class="submitSerie"name="research" type="submit" value="Rechercher">   </form> </div>
                        <div class="div4"><form action="index.php" method="post"> <input class="inputRandomSerie" type="text" name="randomSerie"  placeholder="Rechercher une sérié aléatoire" ></div>
                        <div class="div5"><input class="randomSubmitSerie" type="submit" name="randomSearch" value="?"> </form></div>
                    </div>
            </div>

                <h2>Liste des séries</h2>
                <div class="containerListSerie">
                    <div class="div1"></p>
                    <table>
                        <thead>
                            <tr>
                                <td>Origin</td>
                                <td>Title</td>
                            </tr>

                        </thead>
                        <tbody>
                            <?php foreach($allSeries as $a):?>
                            <tr>
                                <td><?php echo $a->getOrigin();?></td>
                                <td><?php echo $a->getTitle();?></td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                    </div>
                    
                    <div class="div2">
                       <div class="statistique">
                            <h3>Statistiques</h3>
                            <!-- <p>Nombre de séries : <?php echo series::countSeries();?></p> -->
                            <p>Nombre de séries par origine : </p>
                            <p>Nombre de séries par année : </p>
                       </div>
                    </div>
                </div>
         
        </div>
    </main>
</body>
</html>