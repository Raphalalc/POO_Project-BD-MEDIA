<?php 
include('./includes/flash.php');

require_once('./constructor/database.php'); 
require_once('./constructor/serie.php');
require_once('./constructor/book.php');

$BooksJoinSeries = books:: booksJoinSerie();
$BooksImage = books:: booksImage();
$Serie = series:: SerieGetId();

if(isset($_POST['addImage'])){
    $id = $_GET['id'];
    $b = new books($_POST);
    $b->image($_FILES['cover']);
    header('Location: albumLocation.php?id='.$id);
exit();
}

if(isset($_POST['test'])){
    $id = $_GET['id'];
    $b = new books($_POST);
    $b->image($_FILES['cover']);
    header('Location: albumLocation.php?id='.$id);
exit();
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/global.css">
    <title>Album Locationt</title>
</head>
<body>
    <header class="headerLocation">
        <a href="index.php">Home Page</a>
        <img src="./assets/img/bugs.png" alt="bugs bunny">
    </header>

  <div class="albumContainer">
        <div class="albumContainerHead"> 
       <?php foreach($Serie as $s): ?>
                <h2><?= $s->getTitle() ?></h2>
      <?php endforeach; ?>
        </div>
        <div class="albumContainerForm">
        <form method="post" enctype="multipart/form-data">
                <input type="file" name="cover" multiple />
                <input type="hidden"  min="0" max="1" name="rep"  name="rep" placeholder="rep" value="1">
                <input class="submit" type="submit" name="addImage" value="Ajouter une image">
        </form>

        <?php if(isset($_POST['addAlbum'])):
            $s = new series($_GET['id']);?>
            <form  method="post">
            <input type="hidden" name="serie_id"  value="<?= $_GET['id'] ?>">
            <input type="text" name="title" placeholder="title"  maxlength="200"  value="<?=$s->getTitle()?>" >
            <input type="text" name="num" placeholder="num"  maxlength="5" >
            <input type="text" name="writer" placeholder="writer"  maxlength="100"  value="testwrite" >
            <input type="text" name="illustrator" placeholder="illustrator"  maxlength="100" value="testillustrator"> 
            <input type="text" name="editor" placeholder="editor" maxlength="100"   value="testeditor" >
            <input type="number" name="releaseyear" placeholder="releaseyear" min="1976" maxlength="2100">
            <input type="number" name="strips" placeholder="strips" maxlength="5"  value="testStrips" >
            <input type="file" name="cover" placeholder="cover" value="./assets/img/imageNotFound.png">
            <input type="hidden"  min="0" max="1" name="rep" placeholder="rep"  value="0">
            <input  class="submit" type="submit" name="test" value="Ajouter un album " >
</form>
       
   
            <?php endif; ?>
        
        </div>

            <div class="parent">
                <div class="div1">    
                    <?php foreach($BooksImage as $bImage): ?>
                       
                        <img class="rectangleImage" src="<?= $bImage->getCover()?>"  alt="tome"> 
                    
                        <?php break; ?>
                        
                    <?php endforeach; ?>
            

                </div>
                <div class="div2">         
                <p><b>Origine : </b> <?php foreach($Serie as $s): ?><?= $s->getOrigin() ?></h2><?php endforeach; ?></p>
                    <p><b> Nombre de tomes : </b><?= sizeof($BooksJoinSeries ) ?></p>
                    <?php foreach($BooksJoinSeries as $bJoinS): ?>
                    <p><b>L'écrivain : </b><?= $bJoinS->getWriter() ?></p>
                    <p><b>L'illustrateur : </b><?= $bJoinS->getIllustrator() ?></p>
                    <p><b>Éditeur : </b> <?= $bJoinS->getEditor() ?></p>
                    
               
                    
                    <?php break;?>
                    <!-- form test -->
                    <?php endforeach; ?>
                    <form action="" method="post">
                        <input type="submit" name="addAlbum" value="Ajouter un album formulaire"> 
                    </form>
                    <?php
                        if(isset($_SESSION['flashForm'])) {
                        $message = $_SESSION['flashForm'];
                        unset($_SESSION['flashForm']);
                        echo "<b>$message</b>";}
                    ?>
                    
            </div>
        </div>
    
        
        <h2 class="Lire">A LIRE AUSSI</h2>
        <?php foreach($BooksJoinSeries as $bJoinS): ?>
            <div class="parent" id="border-bottom">
                    <div class="div1" id="lireDiv1">
    
                        <img class="squareImage" src="<?= $bJoinS->getCover()?>" alt="tome"> 
                 
                    </div>
                <div class="div2" id="lireDiv2"> 
                    <p><b>Title : </b> <?= $bJoinS->getTitle() ?></p>
                    <p><b>Identifiant: </b> <?= $bJoinS->getNum() ?></p>
                    <p><b>Nombre de planches : </b> <?= $bJoinS->getStrips() ?></p>
                    <p><b>Date de création : </b> <?= $bJoinS->getReleaseyear() ?></p>
                </div>
            </div>
            <?php 
            if(sizeof($BooksJoinSeries) >1){ echo '<div class="dottedLine"></div>';}
            ?>
        <?php endforeach; ?>

    </div>

</body>
</html>