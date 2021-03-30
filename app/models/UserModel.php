<?php
    require 'DB.php';

    class UserModel {
        private $name;
        private $email;
        private $pass;

        private $_db = null;

        public function __construct() {
            $this->_db = DB::getInstence();
        }

        public function setData($name, $email, $pass) {
            $this->name = $name;
            $this->email = $email;
            $this->pass = $pass;
        }

        public function getRealID($soup) {
            $firstarray = explode('1308', $soup);
            $secondarray = explode('8734', $firstarray[1])[0];
            return $secondarray;
        }

        public function secureID($id) {
            $result = '561308'.$id.'873483';
            return $result;
        }

        public function validForm() {
            $result = $this->_db->query("SELECT * FROM `users` WHERE `name` = '$this->name'");
            $isReged =  $result->fetchAll(PDO::FETCH_ASSOC);

            $resultemail = $this->_db->query("SELECT * FROM `users` WHERE `email` = '$this->email'");
            $isRegedEmail =  $resultemail->fetchAll(PDO::FETCH_ASSOC);

            if(strlen($this->name) < 3)
                return "Имя слишком короткое";
            else if(strlen($this->email) < 3)
                return "Email слишком короткий";
            else if(strlen($this->pass) < 3)
                return "Пароль не менее 3 символов";
            else if(count($isReged) >= 1)
                return "Пользователь с  таким  логином уже существует";
            else if(count($isRegedEmail) >= 1)
                return "Пользователь с  таким  email уже существует";
            else
                return "Верно";
        }

        public function addUser() {
            $sql = 'INSERT INTO users(name, email, pass) VALUES(:name, :email, :pass)';
            $query = $this->_db->prepare($sql);

            $pass = password_hash($this->pass, PASSWORD_DEFAULT);
            $query->execute(['name' => $this->name, 'email' => $this->email, 'pass' => $pass]);

            $this->setAuth($this->email);
        }

        public function getUser() {
            $email = $_COOKIE['login'];
            //explode('/', $_COOKIE['login'])[0]
            $result = $this->_db->query("SELECT * FROM `users` WHERE `email` = '$email'");
            return $result->fetch(PDO::FETCH_ASSOC);

        }

        public function logOut() {
            setcookie('login', $this->email, time() - 3600, '/');
            unset($_COOKIE['login']);
            header('Location: /user/auth');
        }

        public function auth($name, $pass) {
            $result = $this->_db->query("SELECT * FROM `users` WHERE `name` = '$name'");
            $user = $result->fetch(PDO::FETCH_ASSOC);

            if($user['name'] == '')
                return 'Пользователя с таким логином не существует';
            else if(password_verify($pass, $user['pass']))
                //
                //$this->setAuth($user['email']);
                $this->setAuth($user['email']);
            else
                return 'Пароли не совпадают';
        }

        public function setAuth($email) {
            setcookie('login', $email, time() + 3600, '/');
            //setcookie('login', $email.'/'.$_SERVER['REQUEST_TIME'], time() + 3600, '/');
            header('Location: /user/dashboard');
        }

    }