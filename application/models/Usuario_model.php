<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuario_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_user_by_identifier($email)
    { // Cambiamos el nombre del parámetro para mayor claridad
        $this->db->where('email', $email);
        $query = $this->db->get('usuarios'); // 'usuarios' es tu tabla de usuarios
        return $query->row(); // Devuelve un solo objeto de usuario o NULL
    }


    public function registrar_usuario($data)
    {
        return $this->db->insert('usuarios', $data);
    }

}
