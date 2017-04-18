<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question_Model extends CI_Model
{
    protected $table = 'questions';

	public function set($data)
	{
		
	}

    public function getQuestionsByQuizId($quiz_id)
    {
        $query = $this->db->where('quiz_id', $quiz_id)->get($this->table);

        return $query->result();
	}
}