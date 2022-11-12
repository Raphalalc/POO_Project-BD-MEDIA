<?php 
    class series extends Database {

        protected $id;
        protected $created;
        protected $updated;
        protected $title;
        protected $origin;

        public function __construct($d){
            parent::__construct();

            if(is_array($d)){
                $this->hydrate($d);
            }
            else if(is_int($d) || (int) $d>0){
                $d=(int)$d;
                $r = $this->prepare('SELECT * FROM series WHERE id = :i');
                $r->execute([':i' => $d]);
                
                if($r->rowCount() > 0)
                $this->hydrate($r->fetch(PDO::FETCH_ASSOC));	
                
                
            }
            //
        }

        // SET
        public function setId($id){
            $this->id = (int)$id;
        }

        public function setCreated($created){
            $this->created = (string)$created;
        }

        public function setUpdated($updated){
            $this->updated =(string)$updated;
        }

        public function setTitle($t){
            $this->title = (string)$t;
        }

        public function setOrigin($o){
            $this->origin = ucfirst(strtolower($o));
        }

        //Get

        public function getId(){
            return $this->id;
        }

        public function getCreated(){
            return $this->created;
        }

        public function getUpdated(){
            $d = new DateTime($this->updated);
            return $d->format('d/m/Y h:i:s' );
        }

        public function getTitle(){
            return $this->title;
        }
        
        public function getOrigin(){
            return $this->origin;
        }
        
        public function save(){
            if($this->id > 0){
                $r = $this->prepare('UPDATE series SET title = :t, origin = :o, updated = NOW() WHERE id = :i');
                $r->execute([
                    ':t' => $this->title,
                    ':o' => $this->origin,
                    ':i' => $this->id
                ]);
            }
            else{
                $r = $this->prepare('INSERT INTO series (title, origin, created, updated) VALUES (:t, :o, NOW(), NOW())');
                $r->execute([
                    ':t' => $this->title,
                    ':o' => $this->origin
                ]);
                // $this->id = $this->lastInsertId();
            }
        }
        public function isValid(){
            if(empty($this->title) && empty($this->origin)){
                return false;
            }
            return true;
        }

        public function delete(){
            if(!empty($this->id)){
                $r = $this->prepare('DELETE FROM series WHERE id = :i');
                $r->execute([':i' => $this->id]);
            }
        }

        public function update(){
            if(!empty($this->id)){
                $r = $this->prepare('UPDATE series SET title = :t, origin = :o, updated = NOW() WHERE id = :i');
                $r->execute([
                    ':t' => $this->title,
                    ':o' => $this->origin,
                    ':i' => $this->id
                ]);
            }
        }

        public static function seriesAll(){
            $db = new Database();
            $r = $db->query('SELECT * FROM series');
            $series = [];
            while($d = $r->fetch(PDO::FETCH_ASSOC)){
                $series[] = new series($d);
            }
            return $series;
        }
    }