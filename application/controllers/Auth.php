<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Usuario_model');
        // Las librerías session, form_validation y helpers url, form, security ya están en autoload
    }

    public function login()
    {
        // Si el usuario ya está logueado, redirigir
        if ($this->session->userdata('id')) {
            redirect('tareas'); // Redirige a tu controlador de tareas
        }
        $this->load->view('auth/login_view');
    }

    public function process_login()
    {
        try {
            if ($this->session->userdata('id')) { // Es lo mismo que $SESSION['user_id'] 'a'
                redirect('tareas');
            }

            $this->form_validation->set_rules('identifier', 'Usuario o Email', 'trim|required|min_length[3]|max_length[100]|xss_clean');
            $this->form_validation->set_rules('contrasena', 'Contraseña', 'trim|required|min_length[6]');

            if ($this->form_validation->run() === FALSE) {
                // Falló la validación, mostrar errores
                $this->load->view('auth/login_view');
            } else {
                // Validación exitosa
                $identifier = $this->input->post('identifier');
                $password = $this->input->post('contrasena');

                $user = $this->Usuario_model->get_user_by_identifier($identifier);

                if ($user && $user->activo && password_verify($password, $user->contrasena_hash)) {
                    // Usuario y contraseña correctos, y usuario activo
                    $session_data = array(
                        'id'       => $user->id,
                        'email'         => $user->email,
                        'rol'           => $user->rol, // Si usas roles
                        'is_logged_in'  => TRUE
                    );
                    $this->session->set_userdata($session_data);

                    redirect('tareas'); // Redirigir al ToDo List
                } else {
                    // Usuario/contraseña incorrectos o usuario inactivo
                    $this->session->set_flashdata('error', 'Usuario, email o contraseña incorrectos, o cuenta inactiva.');
                    redirect('auth/login');
                }
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata('success', 'Has cerrado sesión exitosamente.');
        redirect('auth/login');
    }

    // --- Funciones Opcionales (Registro) ---
    public function register()
    {
        if ($this->session->userdata('id')) {
            redirect('tareas');
        }
        $this->load->view('auth/register_view'); // Necesitarás crear esta vista
    }

    public function process_registration()
    {
        if ($this->session->userdata('id')) {
            redirect('tareas');
        }

        // Reglas de validación (ajusta según tus necesidades)
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[100]|is_unique[usuarios.email]|xss_clean');
        $this->form_validation->set_rules('contrasena', 'Contraseña', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('confirmar_contrasena', 'Confirmar Contraseña', 'trim|required|matches[contrasena]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth/register_view');
        } else {
            $data = array(
                'email'          => $this->input->post('email', TRUE),
                'contrasena_hash' => password_hash($this->input->post('contrasena'), PASSWORD_DEFAULT),
                'rol'            => 'usuario', // Rol por defecto
                'activo'         => 1 // Activar por defecto, o 0 si requiere confirmación por email
            );

            if ($this->Usuario_model->registrar_usuario($data)) {
                $this->session->set_flashdata('success', '¡Registro exitoso! Ahora puedes iniciar sesión.');
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('error', 'Hubo un problema al registrar la cuenta. Inténtalo de nuevo.');
                $this->load->view('auth/register_view');
            }
        }
    }
}
