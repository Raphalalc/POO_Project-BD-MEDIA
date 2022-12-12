<?php
    class books extends database{
        protected $id;
        protected $created;
        protected $updated;
        protected $serie_id;
        protected $title;
        protected $num;
        protected $writer;
        protected $illustrator;
        protected $editor;
        protected $releaseyear;
        protected $strips;
        protected $cover;
        protected $rep;
       
        public function __construct($d){
            parent::__construct();

            if(is_array($d)){
                $this->hydrate($d);
            }
            else if(is_int($d) || (int) $d>0){
                $d=(int)$d;
                $r = $this->prepare('SELECT * FROM books WHERE id = :i');
                $r->execute([':i' => $d]);
                
                if($r->rowCount() > 0)
                $this->hydrate($r->fetch(PDO::FETCH_ASSOC));	

            }
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

        public function setSerie_id($serie_id){
            $this->serie_id = (int)$serie_id;
        }

        public function setTitle($t){
            $this->title = (string)$t;
        }

        public function setNum($n){
            $this->num = (string)$n;
        }

        public function setWriter($w){
            $this->writer = (string)$w;
        }

        public function setIllustrator($i){
            $this->illustrator = (string)$i;
        }

        public function setEditor($e){
            $this->editor = (string)$e;
        }

        public function setReleaseyear($r){
            $this->releaseyear = (int)$r;
        }

        public function setStrips($s){
            $this->strips = (int)$s;
        }

        public function setCover($c){
            $this->cover = (string)$c;
        }

        public function setRep($r){
            $this->rep = (string)$r;
        }

        //Get

        public function getId(){
            return $this->id;
        }

        public function getCreated(){
            return $this->created;
        }

        public function getUpdated(){
            return $this->updated;
        }

        public function getSerie_id(){
            return $this->serie_id;
        }

        public function getTitle(){
            return $this->title;
        }

        public function getNum(){
            return $this->num;
        }

        public function getWriter(){
            return $this->writer;
        }

        public function getIllustrator(){
            return $this->illustrator;
        }

        public function getEditor(){
            return $this->editor;
        }

        public function getReleaseyear(){
            return $this->releaseyear;
        }

        public function getStrips(){
            return $this->strips;
        }

        public function getCover(){
            return $this->cover;
        }

        public function getRep(){
            return $this->rep;
        }
       
        public function save(){
            if($this->id > 0){
                $r = $this->prepare('UPDATE books SET serie_id = :s, title = :t, num = :n, writer = :w, illustrator = :i, editor = :e, releaseyear = :r, strips = :st, cover = :c, rep = :re WHERE id = :id');
                $r->execute([
                    ':id' => $this->id,
                    ':s' => $this->serie_id,
                    ':t' => $this->title,
                    ':n' => $this->num,
                    ':w' => $this->writer,
                    ':i' => $this->illustrator,
                    ':e' => $this->editor,
                    ':r' => $this->releaseyear,
                    ':st' => $this->strips,
                    ':c' => $this->cover,
                    ':re' => $this->rep
                ]);
            }
            else{
            $r = $this->prepare('INSERT INTO books (serie_id, title, num, writer, illustrator, editor, releaseyear, strips, cover, rep) VALUES (:s, :t, :n, :w, :i, :e, :r, :st, :c, :re)');
            $r->execute([
                ':s' => $this->serie_id,
                ':t' => $this->title,
                ':n' => $this->num,
                ':w' => $this->writer,
                ':i' => $this->illustrator,
                ':e' => $this->editor,
                ':r' => $this->releaseyear,
                ':st' => $this->strips,
                ':c' => $this->cover,
                ':re' => $this->rep
            ]);              
            }
        }

        function saveDataWithImage(){
            $r = $this->prepare('INSERT INTO books (serie_id, title, num, writer, illustrator, editor, releaseyear, strips, cover, rep) VALUES (:s, :t, :n, :w, :i, :e, :r, :st, :c, :re)');
            $this->cover= "assets/data/".$this->cover;
            $r->execute([
                ':s' => $this->serie_id,
                ':t' => $this->title,
                ':n' => $this->num,
                ':w' => $this->writer,
                ':i' => $this->illustrator,
                ':e' => $this->editor,
                ':r' => $this->releaseyear,
                ':st' => $this->strips,
                ':c' => $this->cover,
                ':re' => $this->rep
            ]);              
        } 

        public function isValid(){
           if(empty($this->title) || empty($this->num) || empty($this->writer) || empty($this->illustrator) || empty($this->editor) || empty($this->releaseyear) || empty($this->strips)){
               return false;
           }
           else{
               return true;
           }
        }

        public function delete(){
            $r = $this->prepare('DELETE FROM books WHERE id = :id');
            $r->execute([':id' => $this->id]);
        }
       
        public static function booksAll(){
            $db = new database();
            $r = $db->query('SELECT * FROM books ORDER BY id DESC');
            $books = [];
            while($d = $r->fetch(PDO::FETCH_ASSOC)){
                $books[] = new books($d);
            }
            return $books;
        }
        public static function countWriter(){
            $db = new database();
            $r = $db->query('SELECT COUNT(DISTINCT writer) FROM books');
            $count = $r->fetch(PDO::FETCH_ASSOC);
            return $count;
        }

        public static function countStrips(){
            $db = new database();
            $r = $db->query('SELECT SUM(strips) FROM books');
            $count = $r->fetch(PDO::FETCH_ASSOC);
            return $count;
        }

        public static function booksJoinSerie(){
            $db = new database();
            $r = $db->query("SELECT s.*, b.* FROM `books` b INNER JOIN `series` s ON b.`serie_id` = s.`id` WHERE b.`serie_id` = $_GET[id]");
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

        public static function booksBySerie_ID(){
            $db = new database();
            $r = $db->query("SELECT * FROM `books` ORDER BY `serie_id` DESC");
            $books = [];
            while($d = $r->fetch(PDO::FETCH_ASSOC)){
                $books[] = new books($d);
            }
            return $books;
        }
        
        public function image(){
            if(isset($_FILES['cover']) && $_FILES['cover']['error'] == 0){
                if($_FILES['cover']['size'] <= 1000000){
                    $infosfichier = pathinfo($_FILES['cover']['name']);
                    $extension_upload = $infosfichier['extension'];
                    $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                    if(in_array($extension_upload, $extensions_autorisees)){
                        move_uploaded_file($_FILES['cover']['tmp_name'], 'assets/data/' . basename($_FILES['cover']['name']));
                        $this->cover = "assets/data/".$_FILES['cover']['name'];
                   
                        $r = $this->prepare('UPDATE books SET cover = :c, rep = :re WHERE id = :id');
                        $r->execute([
                            ':id' => $this->id,
                            ':c' => $this->cover,
                            ':re' => $this->rep
                        ]);
                    }
                }
            }
        }
        public function mooveFolderImage(){
            if(isset($_FILES['cover']) && $_FILES['cover']['error'] == 0){
                if($_FILES['cover']['size'] <= 1000000){
                    $infosfichier = pathinfo($_FILES['cover']['name']);
                    $extension_upload = $infosfichier['extension'];
                    $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                    if(in_array($extension_upload, $extensions_autorisees)){
                        move_uploaded_file($_FILES['cover']['tmp_name'], 'assets/data/' . basename($_FILES['cover']['name']));
                    }
                }
            }
        }
    }
       
       
    ?>