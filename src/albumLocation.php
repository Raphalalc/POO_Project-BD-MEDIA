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
    $b->mooveFolderImage($_FILES['cover']);
}

if(isset($_POST['test'])){
    $id = $_GET['id'];
    $b = new books($_POST);
    if($b->isValid()){
    $b->saveDataWithImage();
    header('Location: albumLocation.php?id='.$id);
    exit();
}
    else{
        flashForm("Veuillez remplir tous les champs");
    }
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/global.css">
    <title>BD MEDIA | Album Location</title>
</head>
<body>
    <header class="headerLocation">
        <a href="index.php">Menu principal</a>
        <img src="./assets/img/bugs.png" alt="bugs bunny">
    </header>

  <div class="albumContainer">
        <div class="albumContainerHead"> 
       <?php foreach($Serie as $s): ?>
                <h2><?= $s->getTitle() ?></h2>
      <?php endforeach; ?>
        </div>
  
        <?php if(isset($_POST['addAlbum'])|| isset($_POST['addImage'])):
            $s = new series($_GET['id']);?>
           
           <div class="formularAlbum">
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="cover" >
            <input type="hidden"  min="0" max="1" name="rep"  name="rep" placeholder="rep" value="1">
            <input class="submit" type="submit" name="addImage" value="Enregistrer l'image">
        
        </form>
        <form  method="post">
            <input type="hidden" name="serie_id"  value="<?= $_GET['id'] ?>">
            <div class="parent">
            <div class="div1"> 
      

                <label for="title">Titre</label>
                <input type="text" name="title" placeholder="title"  maxlength="200"  value="<?=$s->getTitle()?>" >
      
                <label for="num">Identifaint</label>
                <input type="text" name="num" placeholder="45312"  maxlength="5" >
     
                <label for="writer">L'écrivain</label>
                <input type="text" name="writer" placeholder="Philippe Chappuis"  maxlength="100" >
       
                <label for="illustrator">Illustrateur</label>
                <input type="text" name="illustrator" placeholder="Philippe Chappuis"   maxlength="100" > 
            </div>
            <div class="div2"> 
                <label for="editor">Éditeur</label>
                <input type="text" name="editor" placeholder="Casterman" maxlength="100">
       
                <label for="releaseyear">Date de création</label>
                <input type="number" name="releaseyear" placeholder="2007" min="1976" maxlength="2100">
      
                <label for="stris">Planches</label>
                <input type="number" name="strips" placeholder="220" maxlength="5">
                </div>
            </div>
       
      
            <input type="hidden"  min="0" max="1" name="rep" placeholder="rep"  value="1">
           
            <label for="stris">Remettre l'image correspondante</label>
            <input type="file" name="cover" placeholder="cover" value="./assets/img/imageNotFound.png" required>
            <input  class="submit" type="submit" name="test" value="Ajouter un album " >
        </form>
    </div>
       
        <?php endif; ?>
   

            <div class="parent" id="presentation">
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
                        <input id="addAlbum" type="submit" name="addAlbum" value="Ajouter un album"> 
                    </form>
                    <?php
                        if(isset($_SESSION['flashForm'])) {
                        $message = $_SESSION['flashForm'];
                        unset($_SESSION['flashForm']);
                        echo "<b>$message</b>";}
                    ?>
            </div>
        </div>

        <div class="parent" id="Lire">
        <div class="div1">  <h2>A LIRE AUSSI</h2></div>
        </div>
        
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