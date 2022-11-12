<?php 
require_once('database.php'); 
require_once('serie.php');
require_once('book.php');

// Modify and display series
if(isset($_POST['addSeries']) || isset($_POST['update'])){
    $url= "";
    $t = new series($_POST);
    if($t->isValid())
    $t->save();
    else{
        $url = "?error=1";
    }
    
    header('Location: index.php'.$url);
    exit();
}

// Delete series
elseif(isset($_POST['deleteSeries'])){
    $t = new series($_POST['id']);
    $t->delete();
    
    header('Location: index.php');
    exit();
}

if(isset($_POST['addBooks'])){
    $url= "";
    $t = new books($_POST);
    if($t->isValid())
    $t->save();
   
    else{
        $url = "?error=1";
    }
    header('Location: index.php'.$url);
    exit();
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/global.css">
    <title>Bande dessinée website</title>
</head>
<body>
    <div class="circle"></div>
    <?php $allSeries = series::seriesAll();?>
    <?php $allBooks = books::booksAll();?>
    <table>
        <thead>
            <tr>
                <td>ID</td>
                <td>Created</td>
                <td>Updated</td>
                <td>Title</td>
                <td>Origin</td>
                <td>Modify</td>
                <td>Delete</td>
            </tr>

        </thead>
        <tbody>
            <h2>Liste de séries</h2>
            <?php foreach($allSeries as $a):?>
            <tr>
                <td><?php echo $a->getId();?></td>
                <td><?php echo $a->getCreated();?></td>
                <td><?php echo $a->getUpdated();?></td>
                <td><?php echo $a->getTitle();?></td>
                <td><?php echo $a->getOrigin();?></td>
                <td>
                    <!-- Form update button -->
                <a href="index.php?edit=<?= $a->getId()?>">Modify</a>
                </td>
                <td>
                    <!-- Form delete button -->
                    <form method="POST">
                    <input type="hidden" name="id" value="<?= $a->getId()?>">
                    <input type="submit" name="deleteSeries" value="Supprimer">
                    </form>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
   

    <h1>Bienvenue dans mon site série</h1>

    <h2>Formulaire pour ajouter une série</h2>
 <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
    <label for="title">Title</label>
    <input type="text" name="title" placeholder="title">
    <label for="origin">Origin</label>
    <input type="text" name="origin" placeholder="origin">
    <input  type="submit" name="addSeries" value="Ajouter">
</form>
    <?php if(!empty($_GET['edit'])): 
    $o = new series($_GET['edit']);?>
    <h2>Formulaire pour modifier une série</h2>

    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">

   <?= "Id : ".'<b>'. $o->getId() .'</b>'?>
    <label for="title">Title</label>
    <input type="text" name="title" placeholder="title" value="<?= $o->getTitle()?>">
    <label for="origin">Origin</label>
    <input type="text" name="origin" placeholder="origin" value="<?= $o->getOrigin()?>">
    <input type="hidden" name="id" value="<?= $o->getId()?>">
    <input  type="submit" name="update" value="Modifier">
    <?php endif;?>
</form>

</body>
</html>