<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Producto extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Producto_model');
    }

//AJAX request
//retorna el cuerpo del detalle del producto
    public function verDetalleProducto() {
        if ($this->input->is_ajax_request()) {
            $dato = $this->input->post('modelo');
//retorna los campos p.modelo,p.descripcion,p.imagen,p.existencia,p.costo,d.razon,d.id_proveedor,d.telefono,d.pais,r.fecha,r.cantidad FROM producto p,proveedor d,recepcion
            $campo = $this->Producto_model->getProductoProveedor($dato);
            $html = "<div class='row'><div class='col-sm-6'>";
            if ($campo->imagen == "") {
                $html = $html . "<p><img class='img-rounded' src='" . base_url() . "sources/ups/NULL.jpg' style='max-width:100%;max-height:280px;' ></p>";
            } else {
                $html = $html . "<p><img class='img-rounded' src='" . base_url() . "sources/ups/" . $campo->imagen . "' style='max-width:100%;max-height:280px;' ></p>";
            }
            $html = $html . "<p class='h4'>" . $campo->descripcion . "</p>";
            $html = $html . "</div><div class='col-sm-5 alert alert-info'>";
            $html = $html . "<p class='label label-danger pull-right' style='font-size:22px;'>" . $campo->existencia . "</p><br><br>";
            $html = $html . "<p class='h4'> Proveedor   : <i class='pull-right'>" . $campo->razon . " (" . $campo->pais . ")</i></p>";
            $html = $html . "<br><p class='h4'> Telefono    : <i class='pull-right'>" . $campo->telefono . "</i></p>";
            $html = $html . "<p class='h4 " . is_hidden() . "'> Costo/u Bs  : <i class='pull-right'>" . $campo->costo . "</i></p>";
            $html = $html . "<p class='h4'> Ultima Rep  : <i class='pull-right'>" . $campo->fecha . "</i></p>";
            $html = $html . "<p class='h4'> Cantidad Rep: <i class='pull-right'>" . $campo->cantidad . "</i></p><br>";
            $html = $html . "</div></div>";
            echo $html;
        } else {
            show_404();
        }
    }

    //desactivar actualizar campo activo en 0 para desactivarlo
    public function desactivarProducto() {
        if ($this->input->is_ajax_request()) {
            $modelo = $this->input->post('modelo');
            $resp = $this->Producto_model->updateDesactivarProducto($modelo);
            echo $resp;
        } else {
            show_404();
        }
    }
    
    //Modifica el modelo del producto solo si es admin
    public function modificaCodigoProducto() {
        if ($this->input->is_ajax_request()) {
            $modelo=$this->input->post('modelo');
            $nuevo=strtoupper($this->input->post('nuevo'));
            //envia a producto model
            $resp=$this->Producto_model->updateCodigoProducto($modelo,$nuevo);
            if($resp>0)
                echo "Se ha realizado la modificacion del Código con exito!";
            else
                echo "No se ha actualizado el código. \nVerifique que el codigo no se repita en otro producto";
        } else {
            show_404();
        }
    }

}
