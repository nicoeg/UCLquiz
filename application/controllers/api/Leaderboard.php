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
			$results     = [];
			$count       = $this->leaderboardModel->getQuestionCount($quiz_id);

			foreach($leaderboard as $item)
			{
				$correct_answers = $this->leaderboardModel->getStats($item->id);
				$name = $this->leaderboardModel->getName($item->id);

				$results[$item->user_id] = [
					'name'                  => $name,
					'correct_answers_count' => $correct_answers,
					'time_seconds'          => $item->time
				];		
			}

			$score = array_sum(array_column($results, 'correct_answers_count')) / count($results);
			$time = array_sum(array_column($results, 'time_seconds')) / count($results);

			$output = json_encode([
				'quiz_name'      => $quiz_id,
				'question_count' => $count,
				'results'        => $results,
				'average_score'  => $score,
				'average_time'   => $time
			]);

			return $this->output->set_content_type('application/json')->set_output($output);
		}

		return false;
	}
}