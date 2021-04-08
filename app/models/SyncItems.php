<?php
    require 'DB.php';

    class SyncItems{

        private $_db = null;

        public function __construct() {
            $this->_db = DB::getInstence();
        }

        public function getItems() {
            $email = $_COOKIE['login'];//*
            $result = $this->_db->query("SELECT * FROM `items` WHERE `belongs` = '$email' ORDER BY id DESC");//*
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
                $filename = $_SERVER['REQUEST_TIME'].$file['file']['name'];
                move_uploaded_file($file['file']['tmp_name'], 'public/files/'.$filename);
                $sql = 'INSERT INTO `items` (`id`, `text`, `filename`, `belongs`) VALUES (NULL, :text, :filename, :belongs)';
                $query = $this->_db->prepare($sql);
                $query->execute(['text' => $text, 'filename' => $filename, 'belongs' => $email]);
                unset($_POST);
        }

        public function deleteItem($id) {
            $sql = 'DELETE FROM `items` WHERE `items`.`id` = :id';
            $query = $this->_db->prepare($sql);
            $query->execute(['id' => $id]);
        }
    }
