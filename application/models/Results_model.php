<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Results_Model extends CI_Model
{
	public function classUsers($class_id)
	{
		$query = $this->db->select('id')
				->where('class_id', $class_id)
				->get('users');

		return $query->result();
	}

	public function getUserQuizByUserId($user_id_array)
	{
		$query = $this->db->select('id')
			->where_in('user_id', $user_id_array)
			->group_by('user_id')
			->get('user_quiz');

		return $query->result();
	}
}