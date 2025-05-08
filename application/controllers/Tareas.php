<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Tareas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Verificar si el usuario está logueado
        if (!$this->session->userdata('id')) {
            $this->session->set_flashdata('error', 'Debes iniciar sesión para acceder a esta página.');
            redirect('auth/login'); // Redirigir al login si no hay sesión
        }

        $this->load->model('TareaModel');
        $this->load->helper('url'); // Ya debería estar en autoload
    }

    public function index()
    {

        $user_id = $this->session->userdata('id');
        $data['tareas'] = $this->TareaModel->mis_tareas($user_id);
        $this->load->view('tareas', $data);
    }

    public function agregar()
    {
        $descripcion = $this->input->post('descripcion', TRUE); // TRUE para XSS Clean
        $categoria = $this->input->post('categoria', TRUE);
        $user_id = $this->session->userdata('id'); // Obtener el ID del usuario

        if ($descripcion && $categoria) {
            // Modifica tu TareaModel->registrar para aceptar y guardar user_id
            $this->TareaModel->registrar($user_id, $descripcion, $categoria);
            //$this->TareaModel->registrar($descripcion, $categoria);
        }
        redirect('tareas');
    }

    public function completar($id)
    {
        // Aquí también podrías verificar que la tarea pertenezca al usuario logueado antes de completarla
        // $user_id = $this->session->userdata('user_id');
        // if ($this->TareaModel->verificar_pertenencia_tarea($id, $user_id)) {
        //     $this->TareaModel->completar($id);
        // } else {
        //     $this->session->set_flashdata('error', 'No tienes permiso para modificar esta tarea.');
        // }
        $this->TareaModel->completar($id);
        redirect('tareas');
    }

    public function eliminar($id)
    {
        // Similar a completar, verificar pertenencia
        $this->TareaModel->eliminar($id);
        redirect('tareas');
    }

    public function actualizar($id)
    {
        // Similar a completar, verificar pertenencia
        $descripcion = $this->input->post('descripcion', TRUE);
        $categoria = $this->input->post('categoria', TRUE);
        //$this->TareaModel->actualizar($id, $descripcion, $categoria);
        $this->TareaModel->actualizar($tarea_id_int, $this->user_id_session, $descripcion, $categoria);
        redirect('tareas');
    }
}
