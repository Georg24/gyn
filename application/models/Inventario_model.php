<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inventario_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        //$this->load->database();
    }

    // registro de producto
    //   se registra junto a los datos de recpcion usuario proveedort catidad fecha y almacen
    public function registrarProducto($datos, $recep, $almacen) {
        $mensaje = "metodo registrar Producto";
        try {
            $this->db->insert("producto", $datos);
            $this->db->insert("recepcion", $recep);
            $this->db->insert("prod_almacen", $almacen);
            $mensaje = "Exito en el registro";
        } catch (Exception $ex) {
            $mensaje = "problemas al registrar el producto => " . $ex;
        } finally {
            return $mensaje;
        }
    }

    // registro de producto
    //   se registra junto a los datos de recpcion usuario proveedort catidad fecha y almacen
    public function actualizaProducto($modelo, $datos, $recep, $almacen) {
        $mensaje = "ERROR Actualizar Producto";
        try {
            $this->db->where("modelo", $modelo);
            $this->db->update("producto", $datos);
            $this->db->insert("recepcion", $recep);
            $this->db->where("modelo", $modelo);//modificar cuando se tenga mas almacenes para igualar con el id_almacen
            $this->db->update("prod_almacen", $almacen);
            $mensaje = "Exito en la reposicion y actualizacion de los datos";
        } catch (Exception $ex) {
            $mensaje = "problemas al Actualizar los datos del producto  " . $ex;
        } finally {
            return $mensaje;
        }
    }
    public function modificaProducto($modelo, $datos) {
        $mensaje = "ERROR Actualizar Producto";
        try {
            $this->db->where("modelo", $modelo);
            $this->db->update("producto", $datos);
            $mensaje = "Exito en la modificación de los datos del producto";
        } catch (Exception $ex) {
            $mensaje = "problemas al Modificar los datos del producto  " . $ex;
        } finally {
            return $mensaje;
        }
    }

    /* obtener todo de productos */

    public function getProductos() {
        $tabla = $this->db->get('producto');
        return $tabla->result_array();
    }

    public function getProducto($mod) {
        $this->db->where('modelo', $mod);
        $tabla = $this->db->get('producto');
        return $tabla->row();
    }

    // numero de productos registrados
    public function numProductos() {
        return $this->db->query('select modelo from producto')->num_rows();
    }

    // productos por pagina
    public function pagProductos($page) {
        $datos = $this->db->get('producto', $page, $this->uri->segment(3));
        return $datos->result_array();
    }

    // busquede de producto por modelo y descripcion
    public function buscarProductoMD($modesc) {
        return $this->db->query('select * from producto where modelo like "%' . $modesc . '%" or descripcion like "%' . $modesc . '%"')->result_array();
    }

    // seleccionar los productos que tengan menor existencia que sus minimos  
    public function alertaProductos() {
        $query = $this->db->query('SELECT modelo, descripcion, imagen, existencia,minimo '
                . 'FROM producto '
                . 'WHERE existencia<(minimo+20) AND activo=1');
        return $query->result();
    }

    /* buscar modelos para la venta
     */

    public function buscarModelos($mod) {
        $this->db->like('modelo', $mod);
        $tabla = $this->db->get('producto');
        return $tabla->result();
    }

    // retorna 1 si el modelo ya existe en base de datos
    public function existeModelo($mod) {
        $query = $this->db->query('select modelo from producto where modelo like "' . $mod . '"');
        return sizeof($query->result());
    }

    //GET datos de la ultima recepcion para modificar en ajuste
    public function getDatosAjuste($model) {
        $query = $this->db->query('SELECT r.id_recepcion,p.modelo,p.descripcion,p.existencia,v.razon, r.fecha, r.cantidad,u.nombre,p.imagen FROM recepcion r,producto p, proveedor v,usuario u WHERE p.modelo = r.modelo and u.ci=r.ci and v.id_proveedor =r.id_proveedor and p.modelo like "' . $model . '" ORDER BY r.id_recepcion DESC');
        $datos = $query->result_array();
        return $datos;
    }
    //ajuste positivo
    public function ajPositivo($datos)
    {   
        $mensaje;
        try {
            $this->db->query('update recepcion set cantidad=cantidad+'.$datos['adicion'].' where id_recepcion='.$datos['id_recepcion']);
            $this->db->query('update producto set existencia=existencia+'.$datos['adicion'].' where modelo like "'.$datos['modelo'].'"');
            $this->db->query('update prod_almacen set existencia=existencia+'.$datos['adicion'].' where modelo like "'.$datos['modelo'].'"');
            //se debera añadir una condicion en casoo de que el almcen sea otro
            $mensaje="Exito... Se ha realizado el ajuste en inventario";
        } catch (Exception $exc) {
            $mensaje="ERROR No se ha podido Realizar el Ajuste positivo ".$exc->getTraceAsString();
        } finally {
            return $mensaje;
        }
    }
    //ajuste Negativo
    public function ajNegativo($datos)
    {
        $mensaje;
        try {
            $this->db->query('update recepcion set cantidad=cantidad-'.$datos['sustraccion'].' where id_recepcion='.$datos['id_recepcion']);
            $this->db->query('update producto set existencia=existencia-'.$datos['sustraccion'].' where modelo like "'.$datos['modelo'].'"');
            $this->db->query('update prod_almacen set existencia=existencia-'.$datos['sustraccion'].' where modelo like "'.$datos['modelo'].'"');
            //se debera añadir una condicion en casoo de que el almcen sea otro
            $mensaje="Exito... Se ha realizado el ajuste en inventario";
        } catch (Exception $exc) {
            $mensaje="ERROR No se ha podido Realizar el Ajuste negativo ".$exc->getTraceAsString();
        } finally {
            return $mensaje;
        }
    }

}
