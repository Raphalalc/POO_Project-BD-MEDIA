<?php 
require_once('./constructor/database.php'); 
require_once('./constructor/serie.php');
require_once('./constructor/book.php');

$allSeries = series::seriesAll();
$allBooks = books::booksAll();

// SERIES
// Modify and display series
if(isset($_POST['addSeries']) || isset($_POST['updateSeries'])){
    $url= "";
    $t = new series($_POST);
    if($t->isValid())
    $t->save();
    else{
        $url = "?error=1";
    }
    
    header('Location: admin.php'.$url);
    exit();
}

// Delete series
elseif(isset($_POST['deleteSeries'])){
    $t = new series($_POST['id']);
    $t->delete();
    
    header('Location: admin.php');
    exit();
}


// Allbum
// Modify and display books
if(isset($_POST['addBooks']) || isset($_POST['updateAlbum'])){
    $url = "";
    $b = new books($_POST);
    if($b->isValid())
    $b->save();
    else{
        $url = "?error=1";
    }
    header('Location: admin.php'.$url);
    exit();
}
// Delete books
elseif(isset($_POST['deleteAlbum'])){
    $b = new books($_POST['id']);
    $b->delete();
    
    header('Location: admin.php');
    exit();
}

// Add image
if(isset($_POST['addImage'])){
    $b = new books($_POST);
    $b-> image($_FILES['cover']);

header('Location: admin.php'.$url);
exit();
}


if(isset($_POST['filterBooks'])){
    $allBooks = books::booksBySerie_ID();
}
elseif(isset($_POST['noFilter'])){
    $allBooks = books::booksAll();
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/global.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Infant:wght@500&family=Kameron&family=Roboto:wght@700&display=swap" rel="stylesheet">
    <title>BD MEDIA | Page admin </title>
</head>
<body>
<header>
      
</header>
<div class="containerAdminPage">
       <h2>Formulaire pour ajouter une série</h2>

    <form action="admin.php" method="post">
    
       <input type="text" name="origin" placeholder="Écrivez l'origine de la série">
       <input type="text" name="title" placeholder="Écrivez le titre de la série">
       <input class="submit" type="submit" name="addSeries" value="Ajouter">
   </form>
 

            <h2>Liste des séries</h2>
            <div class="containerTable">
    <table  class="tableAdmin">
        <thead>
            <tr>
                <td>ID</td>
                <td>Created</td>
                <td>Updated</td>
                <td>Title</td>
                <td>Origin</td>
                <td>Modify</td>
                <td>Delete</td>
                <td>Add album</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach($allSeries as $a):?>
            <tr>
                <td><?php echo $a->getId();?></td>
                <td><?php echo $a->getCreated();?></td>
                <td><?php echo $a->getUpdated();?></td>
                <td><?php echo $a->getTitle();?></td>
                <td><?php echo $a->getOrigin();?></td>
                <td>
                    <!-- Form update button -->
                <a href="admin.php?edit=<?= $a->getId()?>">Modify</a>
                </td>
                <td>
                    <!-- Form delete button -->
                    <form method="post">
                    <input type="hidden" name="id" value="<?= $a->getId()?>">
                    <input type="submit" class="deleteButton" name="deleteSeries" value="Delete">
                    </form>
                </td>
                    <!-- Form Ajouter album -->
                <td>
                    <a href="admin.php?ajout=<?= $a->getId()?>">Add album</a>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    </div>

    <?php if(!empty($_GET['edit'])): 
    $o = new series($_GET['edit']);?>
   
    <h2>Formulaire pour modifier une série</h2>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                <section>
                    <input type="hidden" name="id" value="<?= $o->getId()?>">
                    <label for="id">Id</label>
                    <input type="text" name="id" placeholder="id" value="<?=  $o->getId()?>" readonly="readonly">
                </section>
                <section>
                    <label for="title">Title</label>
                    <input type="text" name="title" placeholder="title" value="<?= $o->getTitle()?>">
                </section>
                <section>
                    <label for="origin">Origin</label>
                    <input type="text" name="origin" placeholder="origin" value="<?= $o->getOrigin()?>">
                </section>
                <section>
                    <input class="submit" type="submit" name="updateSeries" value="Modifier">
                </section>
            <?php endif;?>
        </form>


<?php if(!empty($_GET['ajout'])): 
 $o = new series($_GET['ajout']);?>
<h2>Formulaire pour ajouter un album</h2>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
    <?= "Id : ".'<b>'. $o->getId() .'</b>'?>
    <input type="hidden" name="serie_id"  value="<?= $o ->getId()?>">
    <input type="text" name="title" placeholder="title"  maxlength="200"  value="<?=$o->getTitle()?>" >
    <input type="text" name="num" placeholder="num"  maxlength="5" >
    <input type="text" name="writer" placeholder="writer"  maxlength="100">
    <input type="text" name="illustrator" placeholder="illustrator"  maxlength="100" > 
    <input type="text" name="editor" placeholder="editor" maxlength="100"   >
    <input type="number" name="releaseyear" placeholder="releaseyear" min="1976" maxlength="2100">
    <input type="number" name="strips" placeholder="strips" maxlength="5" >
    <input type="hidden"  min="0" max="1" name="cover" placeholder="cover"  value="./assets/img/imageNotFound.png">
    <input type="hidden"  min="0" max="1" name="rep" placeholder="rep"  value="0">
    <input  class="submit" type="submit" name="addBooks" value="Ajouter un album " >
</form>
<?php endif;?>

        <div class="containerTable">
        <h2>Liste des albums
            <form action="admin.php" method="post">
            <input class="submit" type="submit" name="noFilter" value="Filtrer par ID">
            </form>
            
            <form action="admin.php" method="post">
            <input class="submit" type="submit" name="filterBooks" value="Filtrer par série_id">
            </form>
     </h2>
        <table class="tableAdmin">
            <thead >
                <tr>
                    <td >Id</td>
                    <td>Created</td>
                    <td>Updated</td>
                    <td>Serie_id</td>
                    <td>Title</td>
                    <td>Num</td>
                    <td>Writer</td>
                    <td>Illustrator</td>
                    <td>Editor</td>
                    <td>Releaseyear</td>
                    <td>Strips</td>
                    <td>Cover</td>
                    <td>Rep</td>
                    <td>Modify</td>
                    <td>Add Image</td>
                    <td>Delete</td>
                </tr>
            </thead>
            <tbody>
            <?php foreach($allBooks as $a):?>
                <tr>
                    <td><?php echo $a->getId();?></td>
                    <td><?php echo $a->getCreated();?></td>
                    <td><?php echo $a->getUpdated();?></td>
                    <td><?php echo $a->getSerie_id();?></td>
                    <td><?php echo $a->getTitle();?></td>
                    <td><?php echo $a->getNum();?></td>
                    <td><?php echo $a->getWriter();?></td>
                    <td><?php echo $a->getIllustrator();?></td>
                    <td><?php echo $a->getEditor();?></td>
                    <td><?php echo $a->getReleaseyear();?></td>
                    <td><?php echo $a->getStrips();?></td>
                    <td><?php echo $a->getCover();?></td>
                    <td><?php echo $a->getRep();?></td>
                    <!-- Redirection Modify album -->
                    <td> <a href="admin.php?editAlbum=<?= $a->getId()?>">Modify</a></td>
                    
                    <!-- Redirection Add image -->
                    <td>
                        <a href="admin.php?addImage=<?= $a->getId()?>">Add Image</a>
                    </td>
                    <!-- Delete album  -->
                    <td>
                            <form method="post">
                            <input type="hidden" name="id" value="<?= $a->getId()?>">
                            <input type="submit" class="deleteButton" name="deleteAlbum" value="Delete">
                            </form>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
        <!-- Modify Album -->
        <?php if(!empty($_GET['editAlbum'])): 
        $o = new books($_GET['editAlbum']);?>
      
        <h2>Formulaire pour modifier un album</h2>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            
                <input type="hidden" name="id" value="<?= $o->getId()?>">
                <input type="hidden" name="serie_id" value="<?= $o->getSerie_id()?>">
            <section>
                <label for="id">Id</label>
                <input type="text" name="title" placeholder="Id" value="<?= $o->getId() ?>"  readonly="readonly">
            </section>
            <section>
                <label for="title">Title</label>
                <input type="text" name="title" placeholder="title" maxlength="200" value="<?= $o->getTitle()?>">
            </section>
            <section>
                <label for="num"  >Num</label>
                <input type="text" name="num" placeholder="num" maxlength="5" value="<?= $o->getNum()?>">
            </section>
            <section>
                <label for="writer">Writer</label>
                <input type="text" name="writer" placeholder="writer" maxlength="100" value="<?= $o->getWriter()?>">
            </section>
            <section>
                <label for="illustrator">Illustrator</label>
                <input type="text" name="illustrator" placeholder="illustrator" maxlength="100" value="<?= $o->getIllustrator()?>">
            </section>
            <section>
                <label for="editor">Editor</label>
                <input type="text" name="editor" placeholder="editor" maxlength="100" value="<?= $o->getEditor()?>">
            </section>
            <section>
                <label for="releaseyear">Releaseyear</label>
                <input type="number" min="1976" maxlength="2100" name="releaseyear" placeholder="releaseyear" value="<?= $o->getReleaseyear()?>">
            </section>
            <section>
                <label for="strips">Strips</label>
                <input type="number" name="strips" placeholder="strips" maxlength="5" value="<?= $o->getStrips()?>">
            </section>
            <section>
                <label for="cover">Cover</label>
                <input type="text" name="cover" placeholder="cover" maxlength="30"value="<?= $o->getCover()?>">
            </section>
            <section>
                <label for="rep">Rep</label>
                <input type="number"  min="0" max="1" name="rep"  name="rep" placeholder="rep" value="<?= $o->getRep()?>">
            </section>
                <input class="submit" type="submit" name="updateAlbum" value="Modifier l'album">
        </form>
        <?php endif;?>

        <!-- Form Image -->
        <?php if(!empty($_GET['addImage'])):
        $o = new books($_GET['addImage']);?>
     
        <h2>Formulaire pour ajouter une image</h2>
        <form  action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $o->getId()?>">
                <input type="hidden" name="serie_id" value="<?= $o->getSerie_id()?>">
                <input type="file" name="cover" multiple />
                <input type="hidden"  min="0" max="1" name="rep"  name="rep" placeholder="rep" value="1">
                <input class="submit" type="submit" name="addImage" value="Ajouter une image">
        </form>
        <?php endif;?>
        </div>
</body>
</html>