<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz_Model extends CI_Model
{
	public function get()
	{
		$this->db->get('quizzes');

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