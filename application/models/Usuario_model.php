<?php

class Usuario_model extends CI_Model {

    function __construct() {
        parent::__construct();
        //$this->load->database();
    }

    /* LOGIN contra la base de datos */
    /**/
    function login($user, $pass) {
        $this->db->where('ci', $user);
        $this->db->where('password', $pass);
        $resp = $this->db->get('usuario');
        if ($resp->num_rows() > 0) {
            return $resp->row();
        } else {
            return FALSE;
        }
    }

}
