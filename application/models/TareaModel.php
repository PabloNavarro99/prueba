<?php


defined('BASEPATH') or exit('No direct script access allowed');

class TareaModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Obtiene las tareas de un usuario específico.
     * @param int $user_id_param El ID del usuario.
     * @return array Un array de objetos de tarea.
     */
    public function mis_tareas($user_id_param)
    {
        // CORRECTO: Filtrar por la columna 'user_id' de la tabla 'tareas'
        $this->db->where('user_id', $user_id_param);
        $this->db->order_by('categoria', 'ASC');
        $this->db->order_by('descripcion', 'ASC');
        $query = $this->db->get('tareas');
        return $query->result();
    }

    /**
     * Registra una nueva tarea para un usuario.
     * @param int $user_id_param El ID del usuario que crea la tarea.
     * @param string $descripcion La descripción de la tarea.
     * @param string $categoria La categoría de la tarea.
     * @return int|bool El ID de la tarea insertada o false en caso de error.
     */
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

    /**
     * Verifica si una tarea específica pertenece a un usuario específico.
     * @param int $tarea_id_param El ID de la tarea (columna 'id' en la tabla 'tareas').
     * @param int $user_id_param El ID del usuario (a comparar con la columna 'user_id' en la tabla 'tareas').
     * @return bool True si la tarea pertenece al usuario, false en caso contrario.
     */
    public function es_mi_tarea($tarea_id_param, $user_id_param)
    {
        // CORRECTO: Compara el 'id' de la tarea con $tarea_id_param
        $this->db->where('id', $tarea_id_param);
        // CORRECTO: Compara la columna 'user_id' de la tarea con $user_id_param
        $this->db->where('user_id', $user_id_param);
        $query = $this->db->get('tareas');
        return $query->num_rows() > 0;
    }

    /**
     * Marca una tarea como completada, si pertenece al usuario.
     * @param int $tarea_id_param El ID de la tarea a completar.
     * @param int $user_id_param El ID del usuario.
     * @return bool True si la operación fue exitosa, false en caso contrario.
     */
    public function completar($tarea_id_param, $user_id_param)
    {
        if ($this->es_mi_tarea($tarea_id_param, $user_id_param)) {
            $this->db->where('id', $tarea_id_param);
            return $this->db->update('tareas', ['completada' => 1]);
        }
        return false;
    }

    /**
     * Elimina una tarea, si pertenece al usuario.
     * @param int $tarea_id_param El ID de la tarea a eliminar.
     * @param int $user_id_param El ID del usuario.
     * @return bool True si la operación fue exitosa, false en caso contrario.
     */
    public function eliminar($tarea_id_param, $user_id_param)
    {
        if ($this->es_mi_tarea($tarea_id_param, $user_id_param)) {
            // CORRECTO: Eliminar usando el ID de la tarea, después de verificar que pertenece al usuario.
            // No es necesario volver a poner user_id aquí porque es_mi_tarea ya lo verificó.
            $this->db->where('id', $tarea_id_param);
            return $this->db->delete('tareas');
        }
        return false;
    }

    /**
     * Actualiza la descripción y categoría de una tarea, si pertenece al usuario.
     * Este método ahora espera 4 argumentos como lo indicaba tu error anterior.
     * @param int $tarea_id_param El ID de la tarea a actualizar.
     * @param int $user_id_param El ID del usuario.
     * @param string $descripcion La nueva descripción.
     * @param string $categoria La nueva categoría.
     * @return bool True si la operación fue exitosa, false en caso contrario.
     */
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
}
