<?php

class Leaderboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Leaderboard_Model', 'leaderboardModel');
	}

	/**
	 * Gets a leaderboard based on quiz id
	 * 
	 * @param  int    $quiz_id Quiz ID for desired leaderboard
	 * @return [type]     [description]
	 */
	
	public function getLeaderboardByQuizId(int $quiz_id)
	{
		if(is_numeric($quiz_id))
		{
			
		}
	}
}