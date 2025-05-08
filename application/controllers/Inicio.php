<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {

	public function index()
	{
		
		$this->load->view('welcome/inicio');
	}

    public function segundo(){
        $this->load->helper('url');
		$this->load->view('inicio');

    }
    public function tercero (){
        echo "Hola tercero";
    }
}
