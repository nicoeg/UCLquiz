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
}