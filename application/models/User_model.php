<?php

class User_Model extends CI_Model
{
	public function getUserByEmail(string $email)
	{
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);

		$query = $this->db
			->get('users')
			->where('email', $email)
			->limit(1);

		return $query->row();
	}
}