<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    //obtener los detalles de la ultima compra del cliente para alertas
    public function detalleUltimaCompra($id) {
        $query=$this->db->query("SELECT c.*,v.cod_venta,v.fecha,v.total,d.modelo,d.cantidad,d.precio,p.imagen ".
                                "FROM cliente c, venta v, detalle_venta d,producto p ".
                                "WHERE p.modelo=d.modelo AND c.id_cliente=v.id_cliente AND v.cod_venta=d.cod_venta AND c.id_cliente=2 ".
                                "AND v.id_venta IN ".
                                "(SELECT DISTINCT MAX(v2.id_venta) FROM venta v2 WHERE v2.id_cliente=c.id_cliente)");
        return $query->result();        
    }
    
}
