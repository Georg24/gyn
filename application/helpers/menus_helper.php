<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('get_submenu')) {
    //crea un submenu para el id del menu que se envie y de acuerdo al perfil
    function get_submenu($nro_menu) {
        $ci = & get_instance();
        $query = $ci->db->query('select s.* from submenu s,perfil_submenu p where id_menu=' . $nro_menu .' AND p.id_submenu=s.id_submenu AND p.id_perfil='.$ci->session->userdata('perfil'));
        return $query->result();
    }

}
//DEPRECATED ya no se usa
if (!function_exists('submenu_para')) {
    //crea un submenu para el id del menu que se envie
    function submenu_para($nro_menu, $activo) {
        $ci = & get_instance();
        $query = $ci->db->query('select * from submenu where id_menu=' . $nro_menu);

        foreach ($query->result() as $sub) {
            $es = ($activo == $sub->submenu) ? "active" : "";

            echo '<li class="' . $es . '" ><a href="' . base_url() . $sub->enlace . '"><span class="glyphicon glyphicon-menu-up"></span>  ' . $sub->submenu . '</a></li>';
        }
    }

}


