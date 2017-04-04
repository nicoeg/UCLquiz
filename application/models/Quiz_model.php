<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz_model extends CI_Model
{
	public function getQuizById($id)
	{
		$safeId = preg_replace('/[^0-9]/', '', $id);

		if(filter_var($safeId, FILTER_VALIDATE_INT) == true) 
		{
			$query = $this->db
				->where('id', $safeId)
				->limit(1)
				->get('quizzes');

			return $query->result();
		}

		return false;
	}

	public function get()
	{
		$query = $this->db->get('quizzes');

		return $query->result();
	}

	public function set($data)
	{
		$cID   = $data['course'];
		$level = $data['level'];
		$uID   = $data['uID'];
		$title = trim(strip_tags($data['title']));

		$query = $this->db->insert('quizzes', [
			'cID'   => $cID,
			'level' => $level,
			'uID'   => $uID,
			'title' => $title,
		]);
	}
}