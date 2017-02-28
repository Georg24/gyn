<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Georg
 * Date: 18/06/2016
 * Time: 08:16 AM
 */
class Menu_model extends CI_Model{
    function __construct()
    {
        parent::__construct();
        //$this->load->database();
    }
    //select de la tabla menu
    public function selectMenu(){
        $query = $this->db->query("select * from menu order by id_menu");
        return $query->result();
    }
    //seleccion para armar el menu lateral
    public function selectSubmenu(){
        $query = $this->db->query('SELECT * from submenu order by id_menu');
        return $query->result();
    }
    //verificar los submenus de cada menu
    public function nroSubmenus(){
        $query = $this->db->query('SELECT m.id_menu,count(m.id_menu) as nro FROM submenu');
        return $query->result();
    }

}