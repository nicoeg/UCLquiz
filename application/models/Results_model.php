<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Results_Model extends CI_Model
{
	public function classUsers($class_id)
	{
		return $this->db
			->select('id')
			->where('class_id', $class_id)
			->get('users')
			->result();
	}

	public function getUserQuizByUserId($user_id_array)
	{
		return $this->db
			->select('id')
			->where_in('user_id', $user_id_array)
			->group_by('user_id')
			->get('user_quiz')
			->result();
	}

	public function getClassList($id)
	{
		return $this->db
			->select('class_id')
			->from('user_quiz')
			->where('quiz_id', $id)
			->join('users', 'users.id = user_quiz.user_id')
			->group_by('class_id')
			->get()
			->result();
	}

	public function getClassNames($array)
	{
		return $this->db
			->select('name')
			->where_in('id', $array)
			->get('classes')
			->result();
	}
}
