<?php

class User_Model extends CI_Model
{
	public function get_user_by_email($email) 
	{
		$query = $this->db
			->where('email', $email)
			->limit(1)
			->get('users');

		return $query->row();
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
		$userData = $this->get_user_by_email($email);

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

				$this->session->set_userdata($newdata);
				
				return true;
			}
		}
	}
}