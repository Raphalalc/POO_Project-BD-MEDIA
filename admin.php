<?php 
require_once('./constructor/database.php'); 
require_once('./constructor/serie.php');
require_once('./constructor/book.php');

// SELECT s.*, b.* FROM `books` b INNER JOIN `series` s ON b.`serie_id` = s.`id`


// Modify and display series
if(isset($_POST['addSeries']) || isset($_POST['update'])){
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

if(isset($_POST['addBooks'])){
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
                <td>Ajouter Album</td>
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
                <a href="admin.php?edit=<?= $a->getId()?>">Modify</a>
                </td>
                <td>
                    <!-- Form delete button -->
                    <form method="post">
                    <input type="hidden" name="id" value="<?= $a->getId()?>">
                    <input type="submit" name="deleteSeries" value="Supprimer">
                    </form>
                   <!-- form Ajouter album -->
                </td>
                <td>
                    <a href="admin.php?ajout=<?= $a->getId()?>">Ajouter Album</a>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
   

    <h1>Bienvenue dans mon site série</h1>

    <h2>Formulaire pour ajouter une série</h2>
 <form action="admin.php" method="post">
    <label for="origin">Origin</label>
    <input type="text" name="origin" placeholder="origin">
    <label for="title">Title</label>
    <input type="text" name="title" placeholder="title">
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
        <table>
            <thead>
                <tr>
                    
                        <td>Id</td>
                        <td>Created</td>
                        <td>Updated</td>
                        <td>Serie_id</td>
                        <td>Title</td>
                        <td>Num</td>
                        <td>Write</td>
                        <td>Illustrator</td>
                        <td>Editor</td>
                        <td>Releaseyear</td>
                        <td>Strips</td>
                        <td>Cover</td>
                        <td>Rep</td>
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
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
        <?php if(!empty($_GET['ajout'])): 
         $o = new books($_GET['ajout']);?>
        <h2>Formulaire pour ajouter un album</h2>
            <form action="admin.php" method="post">
            <input type="text" name="serie_id" value="<?= $_GET['ajout']?>">
       
            <input type="text" name="title" placeholder="title"  maxlength="200"  value="title" >
        
            <input type="text" name="num" placeholder="num"  maxlength="5" >
        
            <input type="text" name="writer" placeholder="writer"  maxlength="100"  value="testwrite" >
     
            <input type="text" name="illustrator" placeholder="illustrator"  maxlength="100"   value="testillustrator"> 
         
            <input type="text" name="editor" placeholder="editor" maxlength="100"   value="testeditor" >
        
            <input type="number" name="releaseyear" placeholder="releaseyear" maxlength="5"  value="2000">
         
            <input type="number" name="strips" placeholder="strips" maxlength="5"  value="testStrips" >
         
            <input type="text" name="cover" placeholder="cover"  maxlength="30"  value="testcover">
        
            <input type="number"  min="0" max="1" name="rep" placeholder="rep"  value="title">
            
            <input  type="submit" name="addBooks" value="Ajouter un album " >
        </form>
        <?php endif;?>
</body>
</html>