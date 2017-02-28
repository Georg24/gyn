<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Venta extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Inventario_model');
        $this->load->model('Proveedor_model');
        $this->load->model('Menu_model');
        $this->load->model('Venta_model');
    }

    function index() {
        if ($this->session->userdata('login')) {
            /* cabecera y menu lateral */
            $lateral['submenus'] = $this->Menu_model->selectSubmenu();
            $lateral['menus'] = $this->Menu_model->selectMenu();
            $lateral['activo'] = 'Vender';
            $this->load->view('common/head');
            $this->load->view('common/menu', $lateral);
            /* contenido */
            $this->load->view('venta/venta');
        } else {
            $this->session->set_flashdata('mensaje', 'Para acceder al sistema debe iniciar sesión');
            redirect(base_url() . "index.php/login");
        }
    }

    function ajuste($dia = FALSE) {
        if ($this->session->userdata('login')) {
            //$this->output->enable_profiler(TRUE);
            /* cabecera y menu lateral */
            $lateral['submenus'] = $this->Menu_model->selectSubmenu();
            $lateral['menus'] = $this->Menu_model->selectMenu();
            $lateral['activo'] = 'Ajuste de Venta';
            $this->load->view('common/head');
            $this->load->view('common/menu', $lateral);
            /* contenido */
            $datos['dia'] = $dia;
            $datos['tabla'] = $this->Venta_model->getVentasXDia($dia);
            $this->load->view('venta/ajuste', $datos);
        } else {
            $this->session->set_flashdata('mensaje', 'Para acceder al sistema debe iniciar sesión');
            redirect(base_url() . "index.php/login");
        }
    }

    function registroDiario($diario = FALSE) {
        if ($this->session->userdata('login')) {
            //$this->output->enable_profiler(TRUE);
            /* cabecera y menu lateral */
            $lateral['submenus'] = $this->Menu_model->selectSubmenu();
            $lateral['menus'] = $this->Menu_model->selectMenu();
            $lateral['activo'] = 'Registro Diario';
            $this->load->view('common/head');
            $this->load->view('common/menu', $lateral);
            /* contenido */
            $ci="";
            $dia =FALSE;
            if ($diario!="") {
                $dia = substr($diario, 0, 10);
                $ci = substr($diario, 10);
            }
            if ($ci == "" || $ci == "todos") {   //si no se ha mandado o es todos
                $ci = "todos";
            }
            $datos['dia'] = $dia;
            $datos['quien'] = $ci;
            $datos['tabla'] = $this->Venta_model->getVentasXDia($dia,$ci);
            $this->load->view('venta/Diario', $datos);
        } else {
            $this->session->set_flashdata('mensaje', 'Para acceder al sistema debe iniciar sesión');
            redirect(base_url() . "index.php/login");
        }
    }
    
    function PorMayor() {
        if ($this->session->userdata('login')) {
            /* cabecera y menu lateral */
            $lateral['submenus'] = $this->Menu_model->selectSubmenu();
            $lateral['menus'] = $this->Menu_model->selectMenu();
            $lateral['activo'] = 'Por Mayor';
            $this->load->view('common/head');
            $this->load->view('common/menu', $lateral);
            /* contenido */
            $this->load->view('venta/pormayor');
        } else {
            $this->session->set_flashdata('mensaje', 'Para acceder al sistema debe iniciar sesión');
            redirect(base_url() . "index.php/login");
        }
    }
    function PorMenor() {
        if ($this->session->userdata('login')) {
            /* cabecera y menu lateral */
            $lateral['submenus'] = $this->Menu_model->selectSubmenu();
            $lateral['menus'] = $this->Menu_model->selectMenu();
            $lateral['activo'] = 'Por Menor';
            $this->load->view('common/head');
            $this->load->view('common/menu', $lateral);
            /* contenido */
            $this->load->view('venta/pormayor');
        } else {
            $this->session->set_flashdata('mensaje', 'Para acceder al sistema debe iniciar sesión');
            redirect(base_url() . "index.php/login");
        }
    }
    
    //AJAX
    // busqueda con ajax
    function buscar() {
        if ($this->input->is_ajax_request()) {
            $buscar = $this->input->post('buscar');
            $tabla = $this->Inventario_model->buscarModelos($buscar);
            echo json_encode($tabla);
        } else {
            show_404();
        }
    }

    // Venta con ajax desde la vista venta 
    //modificando tambien todas las tablas necesarias
    function vender() {
        if ($this->input->is_ajax_request()) {
            $datos = $_POST;
            $ven = $this->Venta_model->registrarVenta($datos);
            echo $ven;
        } else {
            show_404();
        }
    }

    // Venta con ajax desde la vista venta 
    //modificando tambien todas las tablas necesarias
    function reservar() {
        if ($this->input->is_ajax_request()) {
            $datos = $_POST;
            $ven = $this->Venta_model->registrarReserva($datos);
            echo $ven;
        } else {
            show_404();
        }
    }

    //mostrar el detalle de venta para el ajuste
    public function detalleVenta() {
        if ($this->input->is_ajax_request()) {
            $ven = $this->Venta_model->getDetalleVenta($this->input->post('codigo'));
            $html = "<div class='row'><h4 class='col-sm-12 text-primary'>" . $ven[0]->nombre . "</h4></div>";
            $html = $html . "<table id='tabla_detalle' class='table table-hover'><thead class='text-danger'><th class='text-center'>Cantidad</th><th class='text-center'>Modelo<th class='text-center'>Precio/u</th><th class='text-center'>Subtotal</th>";
            $html = $html . "</thead><tbody>";
            foreach ($ven as $val) {
                $html = $html . "<tr class='text-center'>";
                $html = $html . "<td><input class='det_cant input-td num' value='" . $val->cantidad . "'><input class='defecto_cant' hidden value='" . $val->cantidad . "'></td>";
                $html = $html . "<td>" . $val->modelo . "</td>";
                $html = $html . "<td><input class='det_prec input-td moneda' value='" . $val->precio . "'><input class='defecto_prec' hidden value='" . $val->precio . "'></td>";
                $html = $html . "<td class='subtot'>" . ($val->cantidad * $val->precio) . "</td>";
                $html = $html . "</tr>";
            }
            $html = $html . "</tbody></table>";
            echo $html;
        } else {
            show_404();
        }
    }
    //mostrar el detalle de venta para el ajuste
    public function detalleVentaDiaria() {
        if ($this->input->is_ajax_request()) {
            $ven = $this->Venta_model->getDetalleVenta($this->input->post('codigo'));
            $html = "<div class='row'><h4 class='col-sm-12 text-primary'>" . $ven[0]->nombre . "</h4></div>";
            $html = $html . "<table id='tabla_detalle' class='table table-hover'><thead class='text-danger'><th class='text-center'>Cantidad</th><th class='text-center'>Modelo<th class='text-center'>Precio/u</th><th class='text-center'>Subtotal</th>";
            $html = $html . "</thead><tbody>";
            foreach ($ven as $val) {
                $html = $html . "<tr >";
                $html = $html . "<td class='text-center'>".$val->cantidad."</td>";
                $html = $html . "<td class='text-center'>" . $val->modelo . "</td>";
                $html = $html . "<td class='text-center'>" . $val->precio . "</td>";
                $html = $html . "<td class='subtot text-center'>" . ($val->cantidad * $val->precio) . "</td>";
                $html = $html . "</tr>";
            }
            $html = $html . "</tbody></table>";
            echo $html;
        } else {
            show_404();
        }
    }

    //recibe Json con los detalles de venta desde el indice 1 //recibe un bi array(1[modelo,cantidad,precio,subtotal,codigo],2...)
    public function ajustarDetalle() {
        if ($this->input->is_ajax_request()) {
            $datos = $_POST;
            $resp = $this->Venta_model->ajusteDetalleVenta($datos);
            echo $resp;
        } else {
            show_404();
        }
    }

}
