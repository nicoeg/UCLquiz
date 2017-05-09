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
	 * Gets a leaderboard based on quiz id
	 * 
	 * @param   int  $quiz_id  Quiz ID for desired leaderboard
	 * @return  JSON Object    A JSON object containing a leaderboard.
	 */
	

	public function getLeaderboardByQuizId($quiz_id)
	{
		$json_data = json_decode(file_get_contents('php://input'), true);

		if(is_numeric($json_data))
		{
			$output = json_encode($this->leaderboardModel->getLeaderboard($json_data));

			return $this->output->set_content_type('application/json')->set_content($output);
		}

		return false;
	}
}