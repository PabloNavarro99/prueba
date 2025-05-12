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
        $descripcion = $this->input->post('descripcion', TRUE);
        $categoria = $this->input->post('categoria', TRUE);
        $user_id = $this->session->userdata('id');

        $actualizado = $this->TareaModel->actualizar($id, $user_id, $descripcion, $categoria);

        if ($actualizado) {
            $this->session->set_flashdata('success', 'Tarea actualizada correctamente.');
        } else {
            $this->session->set_flashdata('error', 'No se pudo actualizar la tarea.');
        }

        redirect('tareas');
    }
}

//Este es un comentario de prueba para ver si el código se corta en la mitad o no.
