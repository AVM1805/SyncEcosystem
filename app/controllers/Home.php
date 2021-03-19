<?php
    class Home extends Controller {
        public function index() {
            if($_COOKIE['login'] == '') {
                $data = [];
                if (isset($_POST['name'])) {
                    $user = $this->model('UserModel');
                    $user->setData($_POST['name'], $_POST['email'], $_POST['pass'], $_POST['re_pass']);

                    $isValid = $user->validForm();
                    if ($isValid == "Верно")
                        $user->addUser();
                    else
                        $data['message'] = $isValid;
                }
                $this->view('home/index', $data);
            }
            else {
                $items = $this->model('SyncItems');
                $opt = [];
                if (isset($_POST['text'])) {
                    $isValid = $items->isValid($_POST['text'], $_COOKIE['login']);
                    if ($isValid == "ок"){
                        $items->setItem($_POST['text'], $_FILES, $_COOKIE['login']);
                    }
                    else {
                        $opt['message'] = $isValid;
                    }
                }
                if (isset($_POST['delete_button'])){
                    $items->deleteItem($_POST['delete_button']);
                    unset($_POST);
                }
                
                $this->viewOpt('home/index', $items->getItems(), $opt);
            }


        }
    }