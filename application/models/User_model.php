<?php 

class User_model extends CI_Model 
{
	// public function get() 
	// {
	// 	$query = $this->db->get('users');
	// 	return $query->result();
	// }

	public function get_user_by_email($email) 
	{
		$query = $this->db
			->where('email', $email)
			->limit(1)
			->get('users');

		return $query->row();
	}

	// public function set($data) 
	// {
	// 	$email = trim(strip_tags($data['email']));
	// 	$password = password_hash($data['password'], PASSWORD_DEFAULT);
	// 	$name = trim(strip_tags($data['name']));

	// 	$query = $this->db->insert('users', [
	// 		'email' => $email,
	// 		'password' => $password,
	// 		'name' => $name,
	// 	]);

	// 	if ($query == true) {
	// 		return $this->db->insert_id();
	// 	}
	// 	return false;
	// }
}