<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Producto_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    //retorna un stdobject de una fila los datos de la ultima recepcion
    public function getProductoProveedor($mod)
    {   //columnas:de producto cliente y recepcion la ultima recepcion
        $tabla = $this->db->query("SELECT p.modelo,p.descripcion,p.imagen,p.existencia,p.costo,p.minimo,d.razon,d.id_proveedor,d.pais,d.telefono,r.fecha,r.cantidad FROM producto p,proveedor d,recepcion r WHERE r.modelo LIKE p.modelo AND r.id_proveedor=d.id_proveedor AND p.modelo LIKE '".$mod."' ORDER BY r.fecha DESC LIMIT 1");
        return $tabla->row();
    }
    //desactivar producto actualizando el estado activo=0
    public function updateDesactivarProducto($modelo) {
        $this->db->query("UPDATE producto SET activo=0 WHERE modelo LIKE '".$modelo."'");
        $resp=$this->db->affected_rows();
        return $resp;//retorna 1 si ha desactivado el campo
    }
    //ACTUALIZAR EL CODIGO MODELO DE PRODUCTO 
    public function updateCodigoProducto($modelo,$nuevo) {
        $query=$this->db->query("SELECT modelo FROM producto WHERE modelo LIKE '".$modelo."'");
        if($query->num_rows==0)
        {
            $this->db->query("UPDATE producto SET modelo='".$nuevo."' WHERE modelo LIKE '".$modelo."'");
            $resp=$this->db->affected_rows();
            return $resp;//retorna 1 si ha cambiado el modelo
        }
        else
        {
            return 0;
        }
    }
}