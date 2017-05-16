<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('cookie');
		$this->load->model('User_model', 'userModel');
	}

	public function index()
	{
		if ($this->session->userdata('logged_in')) {
			redirect(base_url('quiz_view'));
		}

		if (get_cookie('loginData')) 
		{
			$token = get_cookie('loginData');

			$dbToken = $this->userModel->getCookieToken($token);

			if($dbToken !== null)
			{
				$user = $this->userModel->get_user_by_id($dbToken->user_id);
				$class = $this->userModel->getClassById($user->class_id);
				$className = $class->name;

				$sessionData = array(
                   'username'  => $user->username,
                   'email'     => $user->email,
                   'logged_in' => TRUE,
                   'uid' 	   => $user->id,
                   'user_type' => $user->userType,
                   'class'     => $className
               	);

				$this->session->set_userdata($sessionData);

				redirect(base_url('quiz_view'));
			}
		}

		$this->load->view('header');
		$this->load->view('login_view');
        $this->load->view('footer');
	}

	public function logout()
	{
		$this->session->sess_destroy();
		delete_cookie('loginData');
		redirect(base_url());
	}
}