<?php 

class Auth_lib 
{
	private $ci;
	private $error;

	public function __construct() 
	{
		$this->ci =& get_instance();
	}

	public function access() 
	{	
		$headers = getallheaders();

		if(isset($headers['Authorization'])) 
		{
			$authData = explode(' ', $headers['Authorization']);

			$userPass = base64_decode($authData[1]);

			$loginData = explode(':', $userPass);

			$this->login($loginData[0], $loginData[1]);

			return;
		}

		$this->ci->io->out(401, 'no-auth-set');
		return false;

	}

	private function login($email, $password) 
	{
		$this->ci->load->model('User_model');

		$userData = $this->ci->User_model->get_user_by_email($email);

		if($userData !== null) 
		{
			if(password_verify($password, $userData->password)) 
			{
				return true;
			}
		}

		$this->ci->io->out(401, 'email-password-wrong');
		return false;
	}

	public function get_error() 
	{
		return $this->error;
	}
}