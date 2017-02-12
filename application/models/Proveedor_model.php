<?php

class Proveedor_model extends CI_Model{
    function __construct()
    {
        parent::__construct();
        //$this->load->database();
    }
    /*select proveedor y id para combobox*/
    function selectProvs()
    {
        $query = $this->db->query("select id_proveedor, razon from proveedor");
        return $query->result();
    }
}

