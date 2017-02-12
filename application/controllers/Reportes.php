<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Venta_model');
        $this->load->model('Proveedor_model');
        $this->load->model('Menu_model');
    }

    function index() {
        if ($this->session->userdata('login')) {
            /* cabecera y menu lateral */
            $lateral['submenus'] = $this->Menu_model->selectSubmenu();
            $lateral['menus'] = $this->Menu_model->selectMenu();
            $lateral['activo'] = 'Reportes';
            $this->load->view('common/head');
            $this->load->view('common/menu', $lateral);
            /* contenido */
            $data['tabla'] = $this->Venta_model->getVentas();
            $data['suma'] = $this->Venta_model->sumaVentas();
            $this->load->view('reportes/reporte', $data);
        } else {
            $this->session->set_flashdata('mensaje', 'Para acceder al sistema debe iniciar sesión');
            redirect(base_url() . "index.php/login");
        }
    }
}
