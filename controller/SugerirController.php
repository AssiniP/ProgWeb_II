<?php
require_once( SITE_ROOT . '/helpers/Session.php');
class SugerirController {
    private $renderer;
    private $userModel;

    public function __construct($userModel, $renderer){
        $this->renderer = $renderer;
        $this->userModel = $userModel;
    }

    public function list() {
        $data['preguntas'] = $this->userModel->getQuestionUser($_SESSION['nickname']);
        $data["verCategoria"] = $this->userModel->getAllCategoria();
        if(isset($_GET["id"])) {
            $data['editarPregunta'] = $this->userModel->getQuestionId(intval($_GET["id"]));
        }
        $this->renderer->render('sugerir', $data);
    }

    public function eliminar() {
        $this->userModel->delQuestionId($_GET["id"]);
        header('location: /sugerir/list');
    }

    public function validateFields() {
        $errorMsg = [];
        if (!$this->checkThatUserFormIsNotEmpty()) {
            $errorMsg[] = "Llena todos los campos";
        }
        $response = ['errorMsg' => $errorMsg];

        if (!empty($errorMsg)) {
            // Enviar respuesta con errores en formato JSON
            echo json_encode($response);
        } else {
            // Llamar a la función add() dentro de un bloque try-catch
            $response = ['success' => true];
            echo json_encode($response);
            try{
                $this->addPregunta();
            } catch (Exception $e) {
            }
        }
    }
    private function addPregunta(){
        $preguntaEdit = isset($_POST['idPregunta']) ? intval($_POST['idPregunta']): 0;

        $preguntaData = [
            'idPregunta' => $preguntaEdit,
            'idCategoria' => $_POST['idCategoria'],
            'idUsuario' => $this->userModel->getIDUsuarioActual(),
            'pregunta' => $_POST['pregunta'],
            'opcion1' => $_POST['opcion1'],
            'opcion2' => $_POST['opcion2'],
            'opcion3' => $_POST['opcion3'],
            'opcion4' => $_POST['opcion4'],
            'respuestaCorrecta' => $_POST['respuestaCorrecta']];
        var_dump($preguntaData);

        if(isset($_POST['idPregunta'])) {
            $this->userModel->editQuestionId($preguntaData);
        } else {
            $nickname = $_SESSION['nickname'];
            $this->userModel->addQuestion($preguntaData,$nickname);
        }
    }

    private function checkThatUserFormIsNotEmpty(){
        if(empty($_POST['idCategoria']) || empty($_POST['pregunta']) || empty($_POST['opcion1']) || empty($_POST['opcion2']) ||
             empty($_POST['opcion3']) || empty($_POST['opcion4']) || empty($_POST['respuestaCorrecta'])){
            return false;
        }
        return true;
    }


}