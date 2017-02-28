<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('getModelos')) {

    function getModelos() {
        $ci = & get_instance();
        $query = $ci->db->query('select modelo from producto');
        return $query->result();
    }

}
if (!function_exists('getClientes')) {

    function getClientes() {
        $ci = & get_instance();
        $query = $ci->db->query('select id_cliente,nombre,paterno from cliente');
        return $query->result();
    }

}
if (!function_exists('getNombresUsuarios')) {

    //tiene items= return 1 si tiene al menos un item
    function getNombresUsuarios() {
        $ci = & get_instance();
        $items = $ci->db->query('select nombre,ci from usuario');
        return $items->result();
    }

}
if (!function_exists('getNombresUsuarios')) {

    //tiene items= return 1 si tiene al menos un item
    function getNombresUsuarios() {
        $ci = & get_instance();
        $items = $ci->db->query('select nombre,ci from usuario');
        return $items->result();
    }

}
if (!function_exists('quienUsuario')) {

    //tiene items= return 1 si tiene al menos un item
    function quienUsuario($ciusuario) {
        $ci = & get_instance();
        if ($ciusuario == "todos" || $ciusuario == "")
            return "todos";
        $items = $ci->db->query('select distinct nombre from usuario where ci like "' . $ciusuario . '"');
        return $items->row()->nombre;
    }

}
if (!function_exists('tieneItems')) {

    //tiene imagen= return 1 si tiene al menos un item
    function tieneItems() {
        $ci = & get_instance();
        $items = $ci->db->query('select modelo from carrito');
        $numero = sizeof($items->row_array());
        if ($numero > 0)
            echo "true";
        else
            echo "false";
    }

}
if (!function_exists('tieneImagen')) {

    //tiene imagen= return 1 si tiene al menos un item
    function tieneImagen($mod) {
        $ci = & get_instance();
        $items = $ci->db->query('select imagen from producto where modelo like ' . $mod);
        echo $items->row_array();
    }

}
if (!function_exists('getIdCliente')) {

    //tiene imagen= return 1 si tiene al menos un item
    function getIdCliente($nom) {
        $ci = & get_instance();
        $items = $ci->db->query('select id_cliente from cliente where nombre like "' . $nom . '"');
        $idCliente = $items->row();
        if (isset($idCliente))
            echo "$idCliente->id_cliente";
        else
            echo '1';
    }

}
if (!function_exists('getReservas')) {

    //obtener todas las reservas para las alertas
    function getReservas() {
        $ci = & get_instance();
        $query = $ci->db->query('select v.cod_venta,v.fecha,c.nombre as cliente,v.total from venta v,cliente c WHERE c.id_cliente=v.id_cliente and v.efectiva=0 ORDER BY v.fecha DESC');
        return $query->result();
    }

}
if (!function_exists('getFaltaClientesHabituales')) {

    //obtener todas las reservas para las alertas
    function getFaltaClientesHabituales() {
        $ci = & get_instance();
        $query = $ci->db->query("SELECT DISTINCT c.id_cliente,c.nombre,c.paterno,v.fecha FROM venta v,cliente c WHERE c.id_cliente=v.id_cliente AND v.fecha<DATE_FORMAT(CURRENT_DATE-15,'%Y-%m-%d') AND v.fecha > DATE_FORMAT(CURRENT_DATE-200,'%Y-%m-%d') AND v.fecha = (SELECT MAX(t.fecha) FROM venta t WHERE t.id_cliente=v.id_cliente)");
        return $query->result();
    }

}

