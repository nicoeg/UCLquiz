<?php 

class Auth_lib 
{
	private $ci;

	public function __construct() 
	{
		$this->ci =& get_instance();
	}

	public function access() 
	{	
		$headers = getallheaders();

		if(isset($headers['Authorization'])) 
		{
			$authData  = explode(' ', $headers['Authorization']);	
			$userPass  = base64_decode($authData[1]);
			$loginData = explode(':', $userPass);

			return $this->login($loginData[0], $loginData[1]);

		}

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

				$newdata = array(
                   'username'  => $userData->username,
                   'email'     => $userData->email,
                   'logged_in' => TRUE,
                   'uid' 	   => $userData->id,
                   'user_type' => $userData->userType
               	);

				$this->ci->session->set_userdata($newdata);
				
				return true;
			}
		}
	}
}