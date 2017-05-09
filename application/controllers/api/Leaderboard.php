<?php

class Leaderboard extends CI_Controller
{


	/**
	 * Extends parents constructor method, and loads leaderboard model
	 */
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Leaderboard_Model', 'leaderboardModel');
	}


	/**
	 * [getLeaderboard description]
	 * @param  int $quiz_id [description]
	 * @return [type]          [description]
	 */
	

	public function getLeaderboard($quiz_id)
	{
		$json_data = json_decode(file_get_contents('php://input'), true);

		if(is_numeric($json_data))
		{
			$leaderboard = $this->leaderboardModel->getLeaderboard($json_data);
			$stats       = [];
			$count       = $this->leaderboardModel->getQuestionCount($json_data);

			foreach($leaderboard->id as $leaderboard)
			{
				$user_quiz_id = $this->leaderboardModel->getStats($leaderboard->user_quiz_id);

				$stats[$leaderboard->user_id] = $user_quiz_id;		
			}

			$output = json_encode([
				'quiz_name' => $json_data,
				'question_count' => $count,
				'results' => $stats
			]);

			return $this->output->set_content_type('application/json')->set_content($output);
		}

		return false;
	}

	// public function getLeaderboardByQuizId($quiz_id)
	// {
	// 	$json_data = json_decode(file_get_contents('php://input'), true);

	// 	if(is_numeric($json_data))
	// 	{
	// 		$output = json_encode($this->leaderboardModel->getLeaderboard($json_data));

	// 		return $this->output->set_content_type('application/json')->set_content($output);
	// 	}

	// 	return false;
	// }
}