<?php 
session_start();

require('./includes/flash.php');
require_once('./constructor/database.php'); 
require_once('./constructor/serie.php');
require_once('./constructor/book.php');

$allSeries = series::seriesAll();
$allBooks= books::booksAll();
$countSeries = series::seriesAll();
$countWriter = books::countWriter();
$countStrips = books::countStrips();
// Button research
if(isset($_POST['research'])){
    if(!empty($_POST['searchSerie'])){
        $allSeries = series::seriesSearch();
    }
    elseif(!empty($_POST['searchOrigin'])){
        $allSeries = series::seriesOrigin();
    }
    else{
        $allSeries = series::seriesAll();
    }
}
if(!empty($_POST['searchSerie']) && !empty($_POST['searchOrigin'])){
    $allSeries = series::seriesOriginSearch();
}

// Button randomSearch
if(isset($_POST['randomSearch'])){
    $allSeries = series::randomSearch();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BD MEDIA | Raphaël Alcantara</title>
    <link rel="stylesheet" href="./styles/global.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Infant:wght@500&family=Kameron&family=Roboto:wght@700&display=swap" rel="stylesheet">
</head>
<body>

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
                        <div class="div1"> <form action="index.php" method="post"><input type="text" class="inputSerie" name="searchOrigin" placeholder="Ecrivez l'origine de la série"> </div>
                        <div class="div2"><input type="text" class="inputSerie" name="searchSerie" placeholder="Ecrivez le nom de la série"> </div>
                        <div class="div3"> <input class="submitSerie"name="research" type="submit" value="Rechercher">   </form> </div>
                        <div class="div4"><form action="index.php" method="post"> <input class="randomSubmitSerie" type="submit" name="randomSearch" value="Recherchez une série aléatoire"></form> </div>
                    </div>
            </div>

                <h2 id="ListeDeSérie">Liste des séries</h2>
                <div class="containerListSerie">
                    <div class="div1">
                    <table>
                        <thead>
                            <tr>
                                <td><h3>Origine</h3></td>
                                <td><h3>Titre</h3></td>
                            </tr>

                        </thead>
                        <tbody>
                            <?php foreach($allSeries as $a):?>
                            <tr>
                                <td><?php echo $a->getOrigin();?></td>
                                <td> <a href="albumLocation.php?id=<?= $a->getId()?>"><?php echo $a->getTitle();?></a></td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                    <?php
                        if(isset($_SESSION['flash'])) {
                         $message = $_SESSION['flash'];
                         unset($_SESSION['flash']);
                         echo "<b>$message</b>";
                        }?>
                    </div>
                    
                    <div class="div2">
                     
                       <div class="statistiques">
                            <h3>Statistiques</h3>
                            <div class="miniContainer" id="containerBlue"> <p>Nombre de series :  <b><?= count($countSeries);?></b></b></div>
                            <div class="miniContainer" id="containerBlue"> <p>Nombre d'albums :  <b><?= count($allBooks);?></b> </p></div>
                            <div class="miniContainer" id="containerOrange"> <p>Nombre d'auteurs : <b> <?php foreach($countWriter as $cw){echo ' '.$cw;}?></b> </p></div>
                            <div class="miniContainer" id="containerRed"> <p>Nombre de Planches : <b><?php foreach($countStrips as $cs){echo ' '.$cs;}?></b> </p></div>
                       </div>
                    </div>
                </div>
         
        </div>

    </main>
</body>
</html>