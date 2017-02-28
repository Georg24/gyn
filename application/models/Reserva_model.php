<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reserva_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    //obtener los detalles de la ultima compra del cliente(cod venta)
    public function eliminaReserva($cod) {
        // 1ro actualizamos la existencia de los productos adicionando lo que no se ha vendido
        $modelocantidad = $this->db->query("SELECT p.modelo,(d.cantidad+p.existencia) as existencia FROM producto p,detalle_venta d WHERE p.modelo LIKE d.modelo AND d.cod_venta LIKE '" . $cod . "';")->result_array(); //obtenemos los datos del detalle
        if (sizeof($modelocantidad) > 0) {
            //actualizamos la existencia en producto
            $this->db->update_batch('producto', $modelocantidad, 'modelo');
            if ($this->db->affected_rows() > 0) {
                //3ro eliminamos el detalle de venta de la venta
                $this->db->query("delete from detalle_venta where cod_venta like '" . $cod . "'");
                if ($this->db->affected_rows() > 0) {
                    //eliminamos los datos de la venta
                    $this->db->query("delete from venta where cod_venta like '" . $cod . "'");
                    if ($this->db->affected_rows() > 0) {
                        return "Exito! Se ha eliminado la reserva de"; //el nombre se muestra en jquery
                    } else {
                        return "Error: No se ha eliminado la reserva de";
                    }
                } else {
                    return "Error: No se ha eliminado el Detalle de la venta de";
                }
            } else {
                return "Error: No se ha actualizado la existencia de productos";
            }
        } else {
            return "No se tiene registro del detalle de la venta de";
        }
    }

    //obtener todos los detalles de la venta con producto
    public function getDetalleReserva($cod) {
        $query = $this->db->query('SELECT v.*,p.*,d.* FROM venta v , producto p,detalle_venta d WHERE v.cod_venta LIKE d.cod_venta AND p.modelo LIKE d.modelo AND v.cod_venta LIKE "' . $cod . '"');
        return $query->result();
    }

    //hacer efectiva una venta reservada
    public function efectivaReserva($cod) {
        $this->db->query('UPDATE venta SET efectiva=1 WHERE cod_venta like "' . $cod . '"');
        if ($this->db->affected_rows() > 0) {
            return "Se ha registrado la venta";
        } else {
            return "Error Ha ocurrido un problema, No se ha registrado la venta";
        }
    }

}
