<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('getModelosDescripcion')) {

    //retorna los modelos y la desc para la busqueda en datalist autocompletada
    function getModelosDescripcion() {
        $ci = & get_instance();
        $query = $ci->db->query('select modelo,descripcion from producto');
        return $query->result();
    }

}
if (!function_exists('')) {

}
