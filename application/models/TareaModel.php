<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TareaModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function mis_tareas($user_id_param)
    {
        // CORRECTO: Filtrar por la columna 'user_id' de la tabla 'tareas'
        $this->db->where('user_id', $user_id_param);
        $this->db->order_by('categoria', 'ASC');
        $this->db->order_by('descripcion', 'ASC');
        $query = $this->db->get('tareas');
        return $query->result();
    }


    public function registrar($user_id_param, $descripcion, $categoria)
    {
        $data = [
            // CORRECTO: Guardar el ID del usuario en la columna 'user_id'
            'user_id'     => $user_id_param,
            'descripcion' => $descripcion,
            'categoria'   => $categoria,
            'completada'  => 0
        ];
        if ($this->db->insert('tareas', $data)) {
            return $this->db->insert_id();
        }
        return false;
    }


    public function es_mi_tarea($tarea_id_param, $user_id_param)
    {
        // CORRECTO: Compara el 'id' de la tarea con $tarea_id_param
        $this->db->where('id', $tarea_id_param);
        // CORRECTO: Compara la columna 'user_id' de la tarea con $user_id_param
        $this->db->where('user_id', $user_id_param);
        $query = $this->db->get('tareas');
        return $query->num_rows() > 0;
    }


    public function completar($tarea_id_param, $user_id_param)
    {
        if ($this->es_mi_tarea($tarea_id_param, $user_id_param)) {
            $this->db->where('id', $tarea_id_param);
            return $this->db->update('tareas', ['completada' => 1]);
        }
        return false;
    }


    public function eliminar($tarea_id_param, $user_id_param)
    {
        if ($this->es_mi_tarea($tarea_id_param, $user_id_param)) {

            $this->db->where('id', $tarea_id_param);
            return $this->db->delete('tareas');
        }
        return false;
    }


    public function actualizar($tarea_id_param, $user_id_param, $descripcion, $categoria)
    {
        if ($this->es_mi_tarea($tarea_id_param, $user_id_param)) {
            $this->db->where('id', $tarea_id_param);
            $data_to_update = [
                'descripcion' => $descripcion,
                'categoria'   => $categoria
            ];
            return $this->db->update('tareas', $data_to_update);
        }
        return false;
    }
    /*
    public function actualizar($tarea_id_param, $user_id_param, $descripcion, $categoria)
    {
        if ($this->es_mi_tarea($tarea_id_param, $user_id_param)) {
            $this->db->where('id', $tarea_id_param);
            $data_to_update = [
                'descripcion' => $descripcion,
                'categoria'   => $categoria
            ];
            return $this->db->update('tareas', $data_to_update);
        }
        return false;
    }
        */
}
