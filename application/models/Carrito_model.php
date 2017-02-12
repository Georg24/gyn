<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Georg
 * Date: 28/06/2016
 * Time: 08:16 AM
 */
class Carrito_model extends CI_Model {

    function __construct() {
        parent::__construct();
        //$this->load->database();
    }

    //Agregar item
    public function agregar($item) {
        $respuesta = "";
        try {
            if ($this->estaEnCarrito($item)) {
                $this->db->where('modelo',$item['modelo']);
                $this->db->replace("carrito", $item);
                $respuesta = TRUE;
            } else {
                $this->db->insert("carrito", $item);
                $respuesta = TRUE;
            }
        } catch (Exception $ex) {
            $respuesta = "ERROR AL ADICIONAR EL ITEM \n" . $ex;
        } finally {
            return $respuesta;
        }
    }

    //get Carrito
    public function getCarrito() {
        $resp = $this->db->get('carrito');
        return $resp->result();
    }

    // delete all
    public function delCarrito() {
        $resp = $this->db->truncate('carrito');
        return $resp;
    }

    //saber si un elemento ya esta en el carrito retorna 1 si ya esta
    public function estaEnCarrito($prod) {
        $this->db->where('modelo',$prod['modelo']);
        $resp = $this->db->get('carrito');
        return (sizeof($resp->result()) > 0) ? 1 : 0;
    }
    // delete un item 
    public function eliminaItem($modelo) {
        $this->db->where('modelo',$modelo);
        $resp = $this->db->delete('carrito');
        return $resp;
    }
    
    //Actualiza todo el carrito desde ell controlador de carrito
    public function actualizarCarrito($datos) {
        $respuesta = 0;
        try {
            $this->db->update_batch('carrito', $datos, 'modelo');
            $respuesta = 1;
        } catch (Exception $ex) {
            $respuesta = "ERROR AL Actualizar el carrito \n" . $ex;
        } finally {
            return $respuesta;
        }
    }
}
