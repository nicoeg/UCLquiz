<?php 

class User extends CI_controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('User_model', 'userModel');
		$this->load->helper('cookie');
		$this->load->helper('string');
	}

	public function index() 
	{	
		if ($this->userModel->access()) 
		{
			if($_GET['setCookie'])
			{
				$token = random_string('sha1');
				set_cookie('loginData', $token, 2592000);

				$this->db->set('expiration_date', 'NOW() + INTERVAL 30 DAY', false);
				$this->db->insert('cookie_data', [
					'user_id'         => $this->session->userdata('uid'),
					'token'           => $token
				]);
			}

			$json_data = ['redirect' => $this->redirect()];
		} 
		else 
		{
			$json_data = ['redirect' => base_url()];
		}

		echo json_encode($json_data);
	}

	public function redirect() {
		return base_url($this->session->userdata('user_type') == 0 ? 'student' : 'teacher');
	}
}
