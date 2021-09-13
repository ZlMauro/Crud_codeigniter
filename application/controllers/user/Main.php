<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
     #este metodo se carga antes que todos 
	public function __construct(){
		parent::__construct();
		$this->load->model("User_model");#llamamos le modelo por el nombre de la clase
	}

	public function index(){
		//Retornar la lista de los usuarios desde la bd
		$data = array("data"=>$this->User_model->getUsers());	
		//print_r($data);
		$this->load->view('user/main',$data);
	}

	public function delete($id){
		$this->User_model->delete($id);
		$this->session->set_flashdata('success', 'Se Elimino correctamente');
		redirect(base_url()."usuarios");
	}
}
