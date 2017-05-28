<?php

class User_Model extends CI_Model
{


	/**
	 * gets a user by the passed in email
	 * @param  string $email 
	 * @return array        
	 */
	

	public function getUserByEmail($email) 
	{
		return $this->db
			->where('email', $email)
			->limit(1)
			->get('users')
			->row();
	}


	/**
	 * gets user info from the database by the passed in id
	 * @param  int $id 
	 * @return array     
	 */
	

	public function getUserById($id) 
	{
		return $this->db
			->where('id', $id)
			->limit(1)
			->get('users')
			->row();
	}


	/**
	 * login method that handles the login info from the authorization header
	 * @return bool 
	 */
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


	/**
	 * login method that sets a session if login info is correct
	 * @param  string $email    
	 * @param  string $password 
	 * @return bool           
	 */
	

	private function login($email, $password) 
	{
		$userData = $this->getUserByEmail($email);

		if($userData === null || !password_verify($password, $userData->password)) 
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


	/**
	 * gets the cookie token from the database
	 * @param  string $token 
	 * @return array        
	 */
	

	public function getCookieToken($token)
	{
		return $this->db
			->where('token', $token)
			->limit(1)
			->get('cookie_data')
			->row();
	}


	/**
	 * gets class table where id is passed in
	 * @param  int $id 
	 * @return array     
	 */
	
	
	public function getClassById($id)
	{
		return $this->db
			->where('id', $id)
			->limit(1)
			->get('classes')
			->row();
	}
}
