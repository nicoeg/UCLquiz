<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leaderboard_Model extends CI_Model
{

	/**
	 * use this to get the user_quiz_id, user_id, quiz_id, time
	 * @param  int $quizid id of quiz you want leaderboards for
	 * @return obj         returns user quiz id, user id, quiz id and time
	 */
	

	public function getLeaderboard($quiz_id)
	{
		$query = $this->db->where('quiz_id', $quiz_id)
		->group_by('user_id')
		->get('user_quiz'); 

		return $query->result(); 
	}


	/**
	 * Gets the amount of correct answers based on the user quiz id
	 * @param  int $user_quiz_id 
	 * @return string               amount of correct answers
	 */
	

	public function getStats($user_quiz_id)
	{
		$query = $this->db->select_sum('correct')
			->where('user_quiz_id', $user_quiz_id)
			->join('answers', 'answers.id = user_answer.answer_id')
			->get('user_answer');

		return $query->row('correct');
	}

	public function getName($user_quiz_id)
	{
		$query = $this->db
			->where('user_quiz.id', $user_quiz_id)
			->join('users', 'users.id = user_quiz.user_id')
			->get('user_quiz');

			return $query->row('username');
	}


	/**
	 * Gets question count based on quiz id
	 * @param  int $quiz_id 
	 * @return int          amoutn of questions
	 */
	

	public function getQuestionCount($quiz_id)
	{
		$query = $this->db->where('quiz_id', $quiz_id)
			->count_all_results('questions');

		return $query;
	}
}