<?php


class RegisterController
{  private $renderer;
    private $userModel;
    public function __construct($userModel, $renderer){
        $this->renderer = $renderer;
        $this->userModel = $userModel;
    }

    public function list(){
        $this->renderer->render('registerForm');
    }

    public function validateFields(){
        $errorMsg = [];
        if(!$this->checkThatUserFormIsNotEmpty()){
            $errorMsg[] = "Llena todos los campos";
        }
        if(!$this->checkMatchingPassword()){
            $errorMsg[] = "Las contraseñas no coinciden";
        }

        if(count($this->checkEmailAndNick())>0){
            $errorMsg[] = 'Ya existe el mail y/o el usuario';
        }

        $data['errorMsg'] = $errorMsg;

        if(!empty($errorMsg)){
            $this->renderer->render('registerForm', $data);
            exit;
        } else{
            $this->add();
        }
    }

    public function add(){
        $userData = [
            'nickName' => $_POST['nickName'],
            'password' => md5($_POST['password']),
            'email' => $_POST['email'],
            'nombre' => $_POST['nombre'],
            'ubicacion' => $_POST['ubicacion'],
            'imagenPerfil' => $_POST['imagenPerfil'],
            'pais' => $_POST['pais'],
            'idGenero' => $_POST['idGenero'],
            'ciudad' => $_POST['ciudad'],
            'idRol' => 3];
        $this->userModel->addUser($userData);
        $data['msg'] = "Se registro correctamente";
        $this->renderer->render('loginForm', $data);
    }

    private function checkThatUserFormIsNotEmpty(){
        if(empty($_POST['nickName']) || empty($_POST['email']) || empty($_POST['password']) ||
            empty($_POST['repassword']) || empty($_POST['nombre']) || empty($_POST['ubicacion']) ||
            empty($_POST['imagenPerfil']) || empty($_POST['pais']) || empty($_POST['idGenero']) ||
            empty($_POST['ciudad'])){
            return false;
        }
        return true;
    }

    private function checkMatchingPassword(){
        if($_POST['password'] != $_POST['repassword']){
            return false;
        }
        return true;
    }

    private function checkEmailAndNick(){
        $nickname = $_POST['nickName'];
        $email = $_POST['email'];
        $data["usuario"] = $this->userModel->check_user($nickname, $email);
        return $data["usuario"];
    }

/*

        if ($request->password !== $request->repassword) {

            return redirect()->back()->withErrors(['repassword' => 'Las contraseñas no coinciden.'])->withInput();
            exit;

        }*/
        
        // Validar que la contraseña y su reingreso sean iguales
        //if ($request->password !== $request->repassword) {
         //   $request->validate(['repassword' => 'Las contraseñas no coinciden.']);
        //}

        // Resto del código para agregar el usuario a la base de datos


}