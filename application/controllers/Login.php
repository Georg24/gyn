<?php

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Menu_model');
        $this->load->model('Usuario_model');
    }

    //pagina de inicio de la aplicacion
    //el Login
    function index() {
        
        if ($this->session->userdata('login')) {
            $this->session->sess_destroy();
        }
        $this->load->view('usuario/login');
    }

    //login con ajax: desde la vista Login
    function ingresar() {
        $usuario = $this->input->post('usuario');
        $pass = $this->input->post('password');
        $resp = $this->Usuario_model->login($usuario, $pass);
        if ($resp) { //los datos se usaran por toda la aplicacion
            $datos = [
                "ci" => $resp->ci,
                "nombre" => $resp->nombre,
                "codusu" => $resp->nombre[0].$resp->nombre[1], //codigo para transacciones
                "perfil" => $resp->id_perfil, //usamos los id de perfil 1 adimin 2 vendedor , etc
                "login" => TRUE,
            ];
            $this->session->set_userdata($datos);
        } else {
            echo 'error';
        }
    }

}
