<?php
    require 'DB.php';

    class SyncItems{

        private $_db = null;

        public function __construct() {
            $this->_db = DB::getInstence();
        }

        public function getItems() {
            $email = $_COOKIE['login'];
            $result = $this->_db->query("SELECT * FROM `items` WHERE `belongs` = '$email' ORDER BY id DESC");
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }

        public function isValid($text, $email) {
            $result = $this->_db->query("SELECT * FROM `items` WHERE `text` = '$text' AND `belongs` = '$email'");
            $elements = $result->fetchAll(PDO::FETCH_ASSOC);
            if(count($elements)>=1){
                return 'Такая запись уже сужествует / Such an entry is already established';
            }
            else if(strlen($text) < 1){
                return 'Введите текст';
            }
             
            else {
                return 'ок';
            }
        }

        public function setItem($text, $file, $email){
                move_uploaded_file($file['file']['tmp_name'], 'public/img/'.$file['file']['name'].$_SERVER['REQUEST_TIME']);
                $sql = 'INSERT INTO `items` (`id`, `text`, `img`, `belongs`) VALUES (NULL, :text, :img, :belongs)';
                $query = $this->_db->prepare($sql);
                $query->execute(['text' => $text, 'img' => $file['file']['name'], 'belongs' => $email]);
                unset($_POST);
        }

        public function deleteItem($id) {
            $sql = 'DELETE FROM `items` WHERE `items`.`id` = :id';
            $query = $this->_db->prepare($sql);
            $query->execute(['id' => $id]);
        }
    }
