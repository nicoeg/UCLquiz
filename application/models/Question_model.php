<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question_Model extends CI_Model
{


	/**
	 * Gets all questions to a specific quiz
	 * @param  int $quiz_id 
	 * @return array          
	 */
	
	
    public function getQuestionsByQuizId($quiz_id)
    {
        return $this->db
            ->where('quiz_id', $quiz_id)
            ->get('questions')
            ->result();
	}
}
