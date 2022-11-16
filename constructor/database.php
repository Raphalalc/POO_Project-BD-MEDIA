<?php 

    class database extends PDO{
      
      protected $connected = false;

      public function __construct(){
        if(!$this->connected){
          
            try{
                parent::__construct('mysql:host=localhost;charset=utf8;dbname=bande_dessinee', 'root', '');
                $this->connected = true;
            }catch(PDOException $e){
               print 'Erreur : '.$e->getMessage();
               exit();
            }
        }
      }
      
      public function hydrate(array $d){
        //on sait que $d est un tableau associatif, donc 
        // on parocurt le tableau en utilisant ses clés
        foreach($d as $key => $value){
          //on constitue le nom de la méthode à appeler
          $setter = 'set'.ucfirst($key);
        
          if(method_exists($this, $setter)){
            $this->$setter(trim($value));
          }
        }
      }
      
      public static function booksJoinSerie(){
        $db = new database();
        $r = $db->query(" SELECT s.*, b.* FROM `books` b INNER JOIN `series` s ON b.`serie_id` = s.`id` WHERE b.`serie_id` = $_GET[id]");
        $books = [];
        while($d = $r->fetch(PDO::FETCH_ASSOC)){
            $books[] = new books($d);
        }
        return $books;
    }

    public static function booksImage(){
        $db = new database();
        $r = $db->query(" SELECT `cover` FROM `books` WHERE `serie_id` = $_GET[id] ORDER BY `created` DESC");
        $books = [];
        while($d = $r->fetch(PDO::FETCH_ASSOC)){
            $books[] = new books($d);
        }
        return $books;
    }
    public static function SerieGetId(){
        $db = new database();
        $r = $db->query("SELECT * FROM series WHERE id = $_GET[id]");
        $serie = [];
        while($d = $r->fetch(PDO::FETCH_ASSOC)){
            $serie[] = new series($d);
        }
        return $serie;
    }

}
    