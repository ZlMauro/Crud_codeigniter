<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("User_model");
	}

	public function index($id)
	{	
        //echo $id;
        $data=$this->User_model->getUser($id);
        //print_r($data);
		$this->load->view('user/edit',$data);
	}



	public function update($id){	
		//Capturamos el valor de los input por medio del name

		$fullName = $this->input->post("fullName");
		$email = $this->input->post("email");
		$password = $this->input->post("password");
		$repeatPassord = $this->input->post("repeatPassord");
	
        $data=$this->User_model->getUser($id);

        $validateEMail="";
        
        if($email!=$data->email){
            $validateEMail="|is_unique[user.email]";
        }


		$this->form_validation->set_rules('fullName', 'Nombre completo', 'required|min_length[3]');
		$this->form_validation->set_rules('email', 'Correo eléctronico', 'required|valid_email'.$validateEMail);
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[4]');
		$this->form_validation->set_rules('repeatPassord', 'Confirma contraseña', 'required|matches[password]');

		if ($this->form_validation->run() == FALSE){
			//$this->load->view('user/edit',$data);
            $this->index($id);
		}else{
			$data = array(
				"full_name"=>$fullName,
				"email"=>$email,
				"password"=>md5($password),
                "modified_at"=>date("y-m-d h:m:s")
			);
			
			//Enviamos los datos al modelo User_model a la funticon save
			$this->User_model->update($data,$id);
			
			//generar la alerta en la vista
			$this->session->set_flashdata('success', 'los datos se actualizaron correctamente');
			
			#creamos la redireccoino
			redirect(base_url()."usuarios");
	
		}



		
	}

}
