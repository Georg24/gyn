<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pruebas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Inventario_model');
        $this->load->model('Proveedor_model');
        $this->load->model('Menu_model');
    }

    public function index() {

        $lateral['submenus'] = $this->Menu_model->selectSubmenu();
        $lateral['menus'] = $this->Menu_model->selectMenu();
        $lateral['activo'] = 'Inicio';
        $this->load->view('common/head');
        $this->load->view('common/sidemenu', $lateral);
        /* contenido */
        $data['alertas'] = $this->Inventario_model->alertaProductos(); //productos activos 1 por campo en BD
        $this->load->view('alerta', $data);

        //$this->session->set_flashdata('mensaje', 'Para acceder al sistema debe iniciar sesión');
        //redirect(base_url() . "index.php/login");
    }

    public function getIDCLIENTE() {
        echo print_r("hola");
        echo getIdCliente('SONIA');
        echo getIdCliente('DON MARCOS');
        echo getIdCliente('asdsa');
    }

}
