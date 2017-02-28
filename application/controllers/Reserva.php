<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reserva extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Reserva_model');
    }

    //AJAX request hacia abajo
    public function eliminarReserva() {
        if ($this->input->is_ajax_request()) {
            $cod = $this->input->post('codigo');
            $resp = $this->Reserva_model->eliminaReserva($cod);
            echo $resp; //respuesta a post
        } else {
            show_404();
        }
    }

    public function verDetalleReserva() {
        if ($this->input->is_ajax_request()) {
            $cod = $this->input->post('codigo');
            $resp = $this->Reserva_model->getDetalleReserva($cod);
            $html = "<table class='table table-condensed table-hover'><thead><th class='text-center'>Cant</th><th class='text-center'>Modelo</th><th class='text-center'>Precio/u</th><th class='text-center'>Subtotal</th></thead><tbody>";
            foreach ($resp as $campo) {
                $html = $html . "<tr class='text-center'><td>".$campo->cantidad."</td>";
                $html = $html . "<td class='td-imagen'><img style='z-index:1;' class='accional' src='".  base_url()."sources/ups/".$campo->imagen."'>".$campo->modelo."</td>";
                $html = $html . "<td>".$campo->precio."</td>";
                $html = $html . "<td>".  floatval($campo->precio*$campo->cantidad)."</td>";
            }
            $html = $html . "</tbody></table>";
            $html = $html . "<input hidden id='inTotalReserva' value='".$resp[0]->total."'>";//el total escondido para proporcionar su valor
            echo $html; //respuesta a post
        } else {
            show_404();
        }
    }
    //hacer efectiva una reserva
    public function hacerEfectiva() {
        if ($this->input->is_ajax_request()) {
            $cod = $this->input->post('codigo');
            $resp = $this->Reserva_model->efectivaReserva($cod);
            echo $resp; //respuesta a post
        } else {
            show_404();
        }
    }

}
