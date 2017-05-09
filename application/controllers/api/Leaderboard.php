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
		if(is_numeric($quiz_id))
		{
			$leaderboard = $this->leaderboardModel->getLeaderboard($quiz_id);
			$stats       = [];
			$count       = $this->leaderboardModel->getQuestionCount($quiz_id);

			foreach($leaderboard as $item)
			{
				$user_quiz_id = $this->leaderboardModel->getStats($item->id);

				$stats[$item->user_id] = $user_quiz_id;		
			}

			$output = json_encode([
				'quiz_name' => $quiz_id,
				'question_count' => $count,
				'results' => $stats
			]);

			return $this->output->set_content_type('application/json')->set_output($output);
		}

		return false;
	}
}