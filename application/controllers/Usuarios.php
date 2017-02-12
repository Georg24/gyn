<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*En construccion
 *Index redirecciona a phpMyadmin para el manejo de base de datos*/
class Usuarios extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Cliente_model');
    }
    public function index() {
        echo("<script>window.open('http://127.0.0.1/phpmyadmin')</script>");
        echo("<script>location='".base_url()."index.php/inicio'</script>");
    }
}

