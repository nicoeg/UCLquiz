<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question_Model extends CI_Model
{

    public function getQuestionsByQuizId($quiz_id)
    {
        return $this->db
            ->where('quiz_id', $quiz_id)
            ->get('questions')
            ->result();
	}
}
