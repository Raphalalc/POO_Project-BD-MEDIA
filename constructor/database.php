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
}
    