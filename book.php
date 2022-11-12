<?php

    class books extends database{
        protected $id;
        protected $created;
        protected $updated;
        protected $serie_id;
        protected $title;
        protected $num;
        protected $write;
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

        public function setSerie_id($serie_id){
            $this->serie_id = (int)$serie_id;
        }

        public function setTitle($t){
            $this->title = (string)$t;
        }

        public function setNum($n){
            $this->num = (int)$n;
        }

        public function setWrite($w){
            $this->write = (string)$w;
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

        public function getWrite(){
            return $this->write;
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
                $r = $this->prepare('UPDATE books SET updated = NOW(), serie_id = :s, title = :t, num = :n, write = :w, illustrator = :i, editor = :e, releaseyear = :r, strips = :st, cover = :c, rep = :r WHERE id = :i');
                $r->execute([
                    ':i' => $this->id,
                    ':s' => $this->serie_id,
                    ':t' => $this->title,
                    ':n' => $this->num,
                    ':w' => $this->write,
                    ':i' => $this->illustrator,
                    ':e' => $this->editor,
                    ':r' => $this->releaseyear,
                    ':st' => $this->strips,
                    ':c' => $this->cover,
                    ':r' => $this->rep
                ]);
            }
            else{
                $r = $this->prepare('INSERT INTO books (created, updated, serie_id, title, num, write, illustrator, editor, releaseyear, strips, cover, rep) VALUES (NOW(), NOW(), :s, :t, :n, :w, :i, :e, :r, :st, :c, :r)');
                $r->execute([
                    ':s' => $this->serie_id,
                    ':t' => $this->title,
                    ':n' => $this->num,
                    ':w' => $this->write,
                    ':i' => $this->illustrator,
                    ':e' => $this->editor,
                    ':r' => $this->releaseyear,
                    ':st' => $this->strips,
                    ':c' => $this->cover,
                    ':r' => $this->rep
                ]);
                // $this->id = $this->lastInsertId();
            }
        }
       
        public function isValid(){
            if(empty($this->title) || empty($this->serie_id) || empty($this->num) || empty($this->write) || empty($this->illustrator) || empty($this->editor) || empty($this->releaseyear) || empty($this->strips) || empty($this->cover) || empty($this->rep)){
                return false;
            }
            else{
                return true;
            }
        }
       
        public static function booksAll(){
            $db = new database();
            $r = $db->query('SELECT * FROM books');
            $r->setFetchMode(PDO::FETCH_CLASS, 'books');
            return $r->fetchAll();
        }
    }
    
    ?>