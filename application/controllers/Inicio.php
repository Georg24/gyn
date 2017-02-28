<?php

class Inicio extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Inventario_model');
        $this->load->model('Proveedor_model');
        $this->load->model('Menu_model');
    }

    //pagina de home de la aplicacion se muestran las alertas de los productos con poco inventario
    public function index() {
        if ($this->session->userdata('login')) {
            /* cabecera y menu lateral */
            $lateral['submenus'] = $this->Menu_model->selectSubmenu();
            $lateral['menus'] = $this->Menu_model->selectMenu();
            $lateral['activo'] = 'Noticias';
            $this->load->view('common/head');
            $this->load->view('common/menu', $lateral);
            /* contenido */
            $data['alertas'] = $this->Inventario_model->alertaProductos();//productos activos 1 por campo en BD
            $this->load->view('alerta', $data);
        } else {
            $this->session->set_flashdata('mensaje', 'Para acceder al sistema debe iniciar sesión');
            redirect(base_url()."index.php/login");
        }
    }

}
