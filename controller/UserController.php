<?php

class UserController {
    private $renderer;
    private $userModel;
    public function __construct($userModel, $renderer){
        $this->renderer = $renderer;
        $this->userModel = $userModel;
    }

    public function list() {
        $data["usuario"] = $this->userModel->getUsers();
        $this->renderer->render('users',$data);
    }

    public function add(){
        die("llame a add");
    }

    public function delete() {
        die('llame a delete');
    }
}