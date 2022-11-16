<?php 
require_once('./constructor/database.php'); 
require_once('./constructor/serie.php');
require_once('./constructor/book.php');

$BooksJoinSeries = database:: booksJoinSerie();
$Serie = database:: SerieGetId();
$BooksImage = database:: booksImage();

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
                    <p><b>Editeur : </b> <?= $bJoinS->getEditor() ?></p>
                    <?php break;?>
                    <?php endforeach; ?>
                <button>Ajouter un album</button>
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