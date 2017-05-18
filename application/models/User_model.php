<?php

class User_Model extends CI_Model
{
	public function get_user_by_email($email) 
	{
		return $this->db
			->where('email', $email)
			->limit(1)
			->get('users')
			->row();
	}

	public function get_user_by_id($id) 
	{
		return $this->db
			->where('id', $id)
			->limit(1)
			->get('users')
			->row();
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

		if($userData === null || password_verify($password, $userData->password)) 
		{
			return false;
		}
		
		$class = $this->getClassById($userData->class_id);
		$className = $class->name;

		$sessionData = array(
			'username'  => $userData->username,
			'email'     => $userData->email,
			'logged_in' => TRUE,
			'uid' 	    => $userData->id,
			'user_type' => $userData->userType,
			'class'     => $className
		);

		$this->session->set_userdata($sessionData);
		
		return true;
	}

	public function getCookieToken($token)
	{
		return $this->db
			->where('token', $token)
			->limit(1)
			->get('cookie_data')
			->row();
	}

	public function getClassById($id)
	{
		return $this->db
			->where('id', $id)
			->limit(1)
			->get('classes')
			->row();
	}
}
