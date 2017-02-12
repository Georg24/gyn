<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inventario extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Inventario_model');
        $this->load->model('Proveedor_model');
        $this->load->model('Menu_model');
        $this->load->library('pagination');
    }

    public function index() {
        if ($this->session->userdata('login')) {
            /* cabecera y menu lateral */
            $lateral['submenus'] = $this->Menu_model->selectSubmenu();
            $lateral['menus'] = $this->Menu_model->selectMenu();
            $lateral['activo'] = 'Inventario';
            $this->load->view('common/head');
            $this->load->view('common/menu', $lateral);
            /* paginacion de productos */
            $config['base_url'] = base_url() . 'index.php/inventario/index/';
            $config['total_rows'] = $this->Inventario_model->numProductos();
            $config['per_page'] = 10;
            $config['num_links'] = 3;
            $config['full_tag_open'] = '<ul class="pagination">';
            $config['full_tag_close'] = '</ul>';
            $config['first_link'] = FALSE;
            $config['last_link'] = FALSE;
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $config['prev_link'] = '&laquo';
            $config['prev_tag_open'] = '<li class="prev">';
            $config['prev_tag_close'] = '</li>';
            $config['next_link'] = '&raquo';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="active"><a href="#">';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $datos['productos'] = $this->Inventario_model->pagProductos($config['per_page']);
            $this->pagination->initialize($config);
            $datos['paginacion'] = $this->pagination->create_links();
            $this->load->view('inventario/verinventario', $datos);
        } else {
            $this->session->set_flashdata('mensaje', 'Para acceder al sistema debe iniciar sesión');
            redirect(base_url() . "index.php/login");
        }
    }

    public function recepcion() {
        if ($this->session->userdata('login')) {
            /* cabecera y menu lateral */
            $lateral['submenus'] = $this->Menu_model->selectSubmenu();
            $lateral['menus'] = $this->Menu_model->selectMenu();
            $lateral['activo'] = 'Recepcion';
            $this->load->view('common/head');
            $this->load->view('common/menu', $lateral);
            /* contenido */
            $data['proveedores'] = $this->Proveedor_model->selectProvs();
            $this->load->view('inventario/recepcion', $data);
        } else {
            $this->session->set_flashdata('mensaje', 'Para acceder al sistema debe iniciar sesión');
            redirect(base_url() . "index.php/login");
        }
    }

    //reposision de elementos y actualizacion de datos
    public function reposicion($codigo) {
        if ($this->session->userdata('login')) {
            /* cabecera y menu lateral */
            $lateral['submenus'] = $this->Menu_model->selectSubmenu();
            $lateral['menus'] = $this->Menu_model->selectMenu();
            $lateral['activo'] = 'Recepcion';
            $this->load->view('common/head');
            $this->load->view('common/menu', $lateral);
            /* contenido */
            $codigo = urldecode($codigo);
            $data['proveedores'] = $this->Proveedor_model->selectProvs();
            $data['producto'] = $this->Inventario_model->getProducto($codigo);
            if (sizeof($data['producto']) != 0) {
                $this->load->view('inventario/reposicion', $data);
            } else {
                redirect(base_url() . "index.php/Inventario");
            }
        } else {
            $this->session->set_flashdata('mensaje', 'Para acceder al sistema debe iniciar sesión');
            redirect(base_url() . "index.php/login");
        }
    }
    //Cuando se quiere realizar una modificacion del producto
    public function modificar($codigo) {
        if ($this->session->userdata('login')) {
            /* cabecera y menu lateral */
            $lateral['submenus'] = $this->Menu_model->selectSubmenu();
            $lateral['menus'] = $this->Menu_model->selectMenu();
            $lateral['activo'] = 'Recepcion';
            $this->load->view('common/head');
            $this->load->view('common/menu', $lateral);
            /* contenido */
            $codigo = urldecode($codigo);
            $data['proveedores'] = $this->Proveedor_model->selectProvs();
            $data['producto'] = $this->Inventario_model->getProducto($codigo);
            if (sizeof($data['producto']) != 0) {
                $this->load->view('inventario/modificacion', $data);
            } else {
                redirect(base_url() . "index.php/Inventario");
            }
        } else {
            $this->session->set_flashdata('mensaje', 'Para acceder al sistema debe iniciar sesión');
            redirect(base_url() . "index.php/login");
        }
    }

    //cuando se realiza una busquera en el index de inventario
    public function buscar($modesc) {   //busca los productos por modelo o descripcion buscarProductoMD
        if ($this->session->userdata('login')) {
            /* cabecera y menu lateral */
            $lateral['submenus'] = $this->Menu_model->selectSubmenu();
            $lateral['menus'] = $this->Menu_model->selectMenu();
            $lateral['activo'] = 'Inventario';
            $this->load->view('common/head');
            $this->load->view('common/menu', $lateral);
            /* contenido */
            $modesc = urldecode($modesc);
            $data['productos'] = $this->Inventario_model->buscarProductoMD($modesc);
            $data['paginacion'] = "Se han encontrado " . sizeof($data['productos']) . " resultados";
            $this->load->view('inventario/verinventario', $data);
        } else {
            $this->session->set_flashdata('mensaje', 'Para acceder al sistema debe iniciar sesión');
            redirect(base_url() . "index.php/login");
        }
    }

    //cuando se quiere ajustar una recepcion
    public function ajuste() {
        if ($this->session->userdata('login')) {
            /* cabecera y menu lateral */
            $lateral['submenus'] = $this->Menu_model->selectSubmenu();
            $lateral['menus'] = $this->Menu_model->selectMenu();
            $lateral['activo'] = 'Ajuste';
            $this->load->view('common/head');
            $this->load->view('common/menu', $lateral);
            /* contenido */
            $this->load->view('inventario/ajuste');
        } else {
            $this->session->set_flashdata('mensaje', 'Para acceder al sistema debe iniciar sesión');
            redirect(base_url() . "index.php/login");
        }
    }

    /* ===========================================
     * AJAX
     * para registrar el producto y devolver solo el mensaje de correcto exito
     */

    public function registrar() {   //el IF is_ajax_request() verifica si solo se accede al metodo por ajax
        if ($this->input->is_ajax_request()) {
            $config = [
                "upload_path" => "./sources/ups",
                "allowed_types" => "png|jpg|jpeg|jpe|bmp|gif"
            ]; //iniciamos la libreria upload para la imagen
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('imagen')) { //si la imagen se sube sin problemas
                $data = array(
                    "upload_data" => $this->upload->data()
                );
            } else { //si no hay imagen ponemos 
                $data['upload_data']['file_name'] = 'NULL';
            }

            $producto = array(
                'modelo' => strtoupper($this->input->post('modelo')), 'descripcion' => $this->input->post('descripcion'),
                'costo' => $this->input->post('costo'), 'precio_u' => $this->input->post('precio_u'), 'precio_m' => $this->input->post('precio_m'),
                'minimo' => $this->input->post('minimo'), 'existencia' => $this->input->post('existencia'),
                'imagen' => $data['upload_data']['file_name']
            ); //almacen por defecto 1 del PRINCIPAL
            $recepcion = array(
                'modelo' => strtoupper($this->input->post('modelo')), 'ci' => $this->session->userdata('ci'),
                'id_proveedor' => $this->input->post('proveedor'), 'id_almacen' => '1',
                'cantidad' => $this->input->post('existencia'),
                'fecha' => date('y/n/d')
            );
            $almacen = array(
                'modelo' => strtoupper($this->input->post('modelo')), 'id_almacen' => '1',
                'existencia' => $this->input->post('existencia')
            ); //envia echo como respuesta  
            echo $this->Inventario_model->registrarProducto($producto, $recepcion, $almacen);
        } else {
            show_404();
        }
    }

    public function actualizacion() {   //el IF is_ajax_request() verifica si solo se accede al metodo por ajax
        if ($this->input->is_ajax_request()) {
            $config = [
                "upload_path" => "./sources/ups",
                "allowed_types" => "png|jpg|jpeg|jpe|bmp|gif"
            ];
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('imagen')) {
                $data = array(
                    "upload_data" => $this->upload->data()
                );
            } else { // si no se sube la imagen por algun error 
                if ($this->input->post('imagenanterior') != "") {
                    $data['upload_data']['file_name'] = $this->input->post('imagenanterior');
                } else {
                    $data['upload_data']['file_name'] = 'NULL';
                }
            }
            $modelo = strtoupper($this->input->post('modelo'));
            $producto = array(
                'descripcion' => $this->input->post('descripcion'),
                'costo' => $this->input->post('costo'), 'precio_u' => $this->input->post('precio_u'), 'precio_m' => $this->input->post('precio_m'),
                'minimo' => $this->input->post('minimo'), 'existencia' => $this->input->post('existencia') + $this->input->post('existactual'),
                'imagen' => $data['upload_data']['file_name'], 'activo' => 1
            ); //almacen por defecto 1 del PRINCIPAL
            $recepcion = array(
                'modelo' => strtoupper($this->input->post('modelo')), 'ci' => $this->session->userdata('ci'),
                'id_proveedor' => $this->input->post('proveedor'), 'id_almacen' => '1',
                'cantidad' => $this->input->post('existencia'),
                'fecha' => date('y/n/d')
            );
            $almacen = array(
                'modelo' => strtoupper($this->input->post('modelo')), 'id_almacen' => '1',
                'existencia' => $this->input->post('existencia') + $this->input->post('existactual')
            ); //envia echo como respuesta  
            echo $this->Inventario_model->actualizaProducto($modelo, $producto, $recepcion, $almacen);
        } else {
            show_404();
        }
    }
    public function modificacion() {   //el IF is_ajax_request() verifica si solo se accede al metodo por ajax
        if ($this->input->is_ajax_request()) {
            $config = [
                "upload_path" => "./sources/ups",
                "allowed_types" => "png|jpg|jpeg|jpe|bmp|gif"
            ];
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('imagen')) {
                $data = array(
                    "upload_data" => $this->upload->data()
                );
            } else { // si no se sube la imagen por algun error 
                if ($this->input->post('imagenanterior') != "") {
                    $data['upload_data']['file_name'] = $this->input->post('imagenanterior');
                } else {
                    $data['upload_data']['file_name'] = 'NULL';
                }
            }
            $modelo = strtoupper($this->input->post('modelo'));
            $producto = array(
                'descripcion' => $this->input->post('descripcion'),
                'costo' => $this->input->post('costo'), 'precio_u' => $this->input->post('precio_u'), 'precio_m' => $this->input->post('precio_m'),
                'minimo' => $this->input->post('minimo'), 
                'imagen' => $data['upload_data']['file_name'], 'activo' => 1
            ); //almacen por defecto 1 del PRINCIPAL
            echo $this->Inventario_model->modificaProducto($modelo, $producto);
        } else {
            show_404();
        }
    }

    //verifica si un modelo ya existe en BD
    public function existeModelo() {   //el IF is_ajax_request() verifica si solo se accede al metodo por ajax
        if ($this->input->is_ajax_request()) {
            $modelo = $this->input->post('modelo');
            $resp = $this->Inventario_model->existeModelo($modelo);
            echo $resp;
        } else {
            show_404();
        }
    }

    //devuelble la tabla para ajustar el Inventario
    public function paraAjustar() {
        if ($this->input->is_ajax_request()) {
            $modelo = $this->input->post('modelo');
            $resp = $this->Inventario_model->getDatosAjuste($modelo); //retorna un array html
            echo json_encode($resp);
        } else {
            show_404();
        }
    }

    //ajuste positivo
    public function ajustePositivo() {
        if ($this->input->is_ajax_request()) {
            $datos = array(
                'modelo' => $this->input->post('modelo'),
                'id_recepcion' => $this->input->post('id_recepcion'),
                'adicion' => $this->input->post('add'),
                'existencia' => $this->input->post('add') + $this->input->post('existencia')
            );
            $resp = $this->Inventario_model->ajPositivo($datos); //retorna un array html
            echo print_r($resp);
        } else {
            show_404();
        }
    }

    //ajuste negativo
    public function ajusteNegativo() {
        if ($this->input->is_ajax_request()) {
            $datos = array(
                'modelo' => $this->input->post('modelo'),
                'id_recepcion' => $this->input->post('id_recepcion'),
                'sustraccion' => $this->input->post('rem'),
                'existencia' => $this->input->post('existencia') - $this->input->post('rem')
            );
            $resp = $this->Inventario_model->ajNegativo($datos); //retorna un array html
            echo print_r($resp);
        } else {
            show_404();
        }
    }
    
}
