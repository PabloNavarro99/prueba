<?php

class datosModel extends CI_model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function registro($nombre, $telefono, $email)
    {
        // A SI SE HACE UN ISERT DESDE CODEIGNITER
        return $this->db->insert("datos", array("nombre" => $nombre, "telefono" => $telefono, "email" => $email));
    }
}
