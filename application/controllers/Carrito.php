<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* este carrito solo interactua con ajax desde la parte de ajuste de ventas */

class Carrito extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Inventario_model');
        $this->load->model('Carrito_model');
    }

    //agregar elemnto al recibo desdes venta en views
    public function agregar() {
        if ($this->input->is_ajax_request()) {
            $prod = array(
                'modelo' => $this->input->post('modelo'),
                'cantidad' => $this->input->post('cantidad'),
                'precio' => $this->input->post('precio'),
                'existencia' => $this->input->post('existencia')
            );
            $res = $this->Carrito_model->agregar($prod);
            echo $res;
        } else {
            show_404();
        }
    }

    //agregar elemnto al recibo desdes venta en views
    public function mostrar() {
        $items = $this->Carrito_model->getCarrito();
        $html = "";
        foreach ($items as $item) {
            $html = $html . "<tr class='text-center'>";
            $html = $html . "<td><input type='number' id='" . str_replace(" ","_",$item->modelo) . "' class='input-td cant_rec' value='" . $item->cantidad . "' min='1' max='" . $item->existencia . "' required pattern='[0-9]'>";
            $html = $html . "<td class='input-td'>" . $item->modelo . "</td>";
            $html = $html . "<td class='input-td'> <input cod='" . str_replace(" ","_",$item->modelo) . "' id='prec_" . str_replace(" ","_",$item->modelo) . "' class='input-td prec_rec moneda' value='" . $item->precio . "' " . is_readonly() . "></td>";
            $html = $html . "<td class='input-td subtotal' id='sub_" . str_replace(" ","_",$item->modelo) . "'>" . $item->precio * $item->cantidad . "</td>";
            $html = $html . "<td><button class='btn btn-sm btn-danger glyphicon glyphicon-remove' onclick='borrar_item(\"" . $item->modelo . "\")' ></button>";
            $html = $html . "</td></tr>";
        }
        echo $html;
    }

    //eliminacion de todo el carrito recibo
    public function eliminarTodo() {
        $resp = $this->Carrito_model->delCarrito();
        echo $resp;
    }

    //eliminacion de todo el carrito recibo
    public function eliminarItem() {
        $modelo = $this->input->post('modelo');
        $resp = $this->Carrito_model->eliminaItem($modelo);
        echo $resp;
    }

    //actualiza el carrito antes de eliminar un item
    public function actualizaCarrito() {
        if ($this->input->is_ajax_request()) {
            $datos = $_POST;
            $ven = $this->Carrito_model->actualizarCarrito($datos);
            echo $ven;
        } else {
            show_404();
        }
    }

}
