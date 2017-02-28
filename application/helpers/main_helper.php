<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
// ya no se usa array to upper
if (!function_exists('array_to_upper')) {

    function array_to_upper($array) {
        for ($i = 0; $i < sizeof($array); $i++) {
            $array[$i] = strtoupper($array[$i]);
        }
        return $array;
    }
}
if (!function_exists('make_cod_venta')) {

    function make_cod_venta($id_cliente) {
        $ci = & get_instance();
        $usu = $ci->session->userdata('codusu');
        $cod = "V-" . date('ymdhi') . $id_cliente . $usu;
        return $cod;
    }

}
if (!function_exists('make_cod_ajuste_venta')) {

    function make_cod_ajuste_venta() {
        $ci = & get_instance();
        $usu = $ci->session->userdata('codusu');
        $cod = "A-" . date('ymdhi') . $usu;
        return $cod;
    }

}
if (!function_exists('is_disabled')) {
//si NO es admin retorna disabled
    function is_disabled() {
        $ci = & get_instance();
        if ($ci->session->userdata('perfil') != 1)
            return "disabled";
        else
            return "";
    }

}
if (!function_exists('is_hidden')) {
//si NO es admin retorna disabled
    function is_hidden() {
        $ci = & get_instance();
        if ($ci->session->userdata('perfil') != 1)
            return "hidden";
        else
            return "";
    }

}
if (!function_exists('is_readonly')) {
// si NO es admin retorna read only
    function is_readonly() {
        $ci = & get_instance();
        if ($ci->session->userdata('perfil') != 1)
            return "readonly";
        else
            return "";
    }

}
if (!function_exists('is_admin')) {
//si no es admin retorna false, si SI lo es TRUE
    function is_admin() {
        $ci = & get_instance();
        if ($ci->session->userdata('perfil') != 1)
            return FALSE;
        else
            return TRUE;
    }

}
if (!function_exists('get_nombre_dia')) {
    function get_nombre_dia($fecha) {
        $fechats = strtotime($fecha); //pasamos a timestamp
//el parametro w en la funcion date indica que queremos el dia de la semana
//lo devuelve en numero 0 domingo, 1 lunes,....
        switch (date('w', $fechats)) {
            case 0: return "Domingo";
                break;
            case 1: return "Lunes";
                break;
            case 2: return "Martes";
                break;
            case 3: return "Miercoles";
                break;
            case 4: return "Jueves";
                break;
            case 5: return "Viernes";
                break;
            case 6: return "Sabado";
                break;
        }
    }

}