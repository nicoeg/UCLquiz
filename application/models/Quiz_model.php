<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz_model extends CI_Model
{
	/**
	*  Table name
	*
	*  @var string
	*/

	private $table = 'quizzes';

	/**
	*  Method to get quiz by id
	*
	*  @param int $id Id of quiz that is going to be viewed
	*/

	public function getQuizById($id)
	{
		$safeId = preg_replace('/[^0-9]/', '', $id);

		if(filter_var($safeId, FILTER_VALIDATE_INT)) 
		{
			$query = $this->db
				->where('id', $safeId)
				->limit(1)
				->get($this->table);

			return $query->result();
		}

		return false;
	}

	/**
	*  Method to get all quizzes
	*
	*/

	public function get()
	{
		$query = $this->db->get('quizzes');

		return $query->result();
	}

	/**
	*  Method to set a quiz
	*
	*  @param array $data Array with data from input fields
	*/

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

	/**
	*  Method to delete a quiz
	*
	*  @param int $id Id of quiz that is going to be deleted
	*/

	public function delete($id)
	{
		$safeId = preg_replace('/[^0-9]/', '', $id);

		if(filter_var($safeId, FILTER_VALIDATE_INT)) 
		{
			$query = $this->db
				->where('id', $safeId)
				->delete($this->table);
		}

		return false;
	}
}