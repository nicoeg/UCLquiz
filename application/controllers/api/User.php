<?php 

class User extends CI_controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('User_model', 'userModel');
	}

	public function index() 
	{	
		if ($this->userModel->access()) 
		{
			$json_data = ['redirect' => base_url('quiz_view')];
		} 
		else 
		{
			$json_data = ['redirect' => base_url()];
		}

		echo json_encode($json_data);
	}
}