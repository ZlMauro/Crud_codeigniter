<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("User_model");
	}

	public function index()
	{	
		$this->load->view('user/add');
	}

	public function save(){	
		//Capturamos el valor de los input por medio del name

		$fullName = $this->input->post("fullName");
		$email = $this->input->post("email");
		$password = $this->input->post("password");
		$repeatPassord = $this->input->post("repeatPassord");
	
		$this->form_validation->set_rules('fullName', 'Nombre completo', 'required|min_length[3]');
		$this->form_validation->set_rules('email', 'Correo eléctronico', 'required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[4]');
		$this->form_validation->set_rules('repeatPassord', 'Confirma contraseña', 'required|matches[password]');

		if ($this->form_validation->run() == FALSE){
			$this->load->view('user/add');
		}else{
			$data = array(
				"full_name"=>$fullName,
				"email"=>$email,
				"password"=>md5($password)
			);
			
			//Enviamos los datos al modelo User_model a la funticon save
			$this->User_model->save($data);
			
			//generar la alerta en la vista
			$this->session->set_flashdata('success', 'Se guardo los datos correctamente');
			
			#creamos la redireccoino
			redirect(base_url()."usuarios");
		

		}



		
	}

}
