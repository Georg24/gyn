<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Cliente_model');
    }
    //retorna html para el cuerpo del detalle de la ultima compra del cliente
    public function verDetalleUltimaCompra() {
        if ($this->input->is_ajax_request()) {
            $dato = $this->input->post('id');
            //campos: c.*,v.cod_venta,v.fecha,v.total,d.modelo,d.cantidad,d.precio,p.imagen
            $resp=$this->Cliente_model->detalleUltimaCompra($dato);//recibe una tabla con campos
            $html="<h4 class='pull-right'> Telf: ".$resp[0]->telefono."</h4>";
            $html = $html . "<p class='h4 text-primary'>".$resp[0]->cod_venta."</p><span class='h4 pull-right'>fecha: ".$resp[0]->fecha."</span>";
            $html = $html . "<table class='table table-condensed table-hover'>";
            $html = $html . "<thead><th class='text-center'>Cant</th><th class='text-center'>Modelo</th><th class='text-center'>Precio</th><th class='text-center'>Subtotal</th></thead><tbody>";
            foreach ($resp as $campo) {
                $html = $html . "<tr class='text-center'><td>".$campo->cantidad."</td>";
                $html = $html . "<td class='td-imagen'><img class='accional' src='".base_url()."sources/ups/".$campo->imagen."'>".$campo->modelo."</td>";
                $html = $html . "<td>".$campo->precio."</td>";
                $html = $html . "<td>".($campo->cantidad*$campo->precio)."</td></tr>";
            }
            $html = $html . "<tr><td colspan='4' align='right'><h4> Total Bs. ".$resp[0]->total."</h4></td></tr></tbody>";
            $html = $html . "</table></div>";
            
            echo $html;
        } else {
            show_404();
        }
    }
}
