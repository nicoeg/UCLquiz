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
		if(is_numeric($quiz_id) && $this->session->userdata('logged_in') == true)
		{
			$safeId      = filter_var($quiz_id, FILTER_SANITIZE_NUMBER_INT);
			$leaderboard = $this->leaderboardModel->getLeaderboard($safeId);
			$results     = [];
			$count       = $this->leaderboardModel->getQuestionCount($safeId);

			//saves the results in an array where each result set has the key userId{$item->user_id}
			foreach($leaderboard as $item)
			{
				$correct_answers = $this->leaderboardModel->getStats($item->id);
				$name            = $this->leaderboardModel->getName($item->id);

				$results['userId'.$item->user_id] = [
					'name'                  => $name,
					'user_id'               => $item->user_id, 
					'correct_answers_count' => $correct_answers,
					'time_seconds'          => $item->time
				];		
			}

			if(isset($_GET['user_id']))
			{
				$userId = $_GET['user_id'];
			}
			else
			{
				$userId = $this->session->userdata('uid');
			}
			
			$userResult = key_exists('userId'.$userId, $results) ? $results['userId'.$userId] : null;
			//average score
			$score = array_sum(array_column($results, 'correct_answers_count')) / count($results);
			//average time
			$time = array_sum(array_column($results, 'time_seconds')) / count($results);

			//sort by highest correct answer then lowest time
			usort($results, function ($item1, $item2) {
				if (($item2['correct_answers_count'] <=> $item1['correct_answers_count']) == 0) {
					return $item1['time_seconds'] <=> $item2['time_seconds'];
				}
			    return $item2['correct_answers_count'] <=> $item1['correct_answers_count'];
			});

			//after the sorted list we slice all but the top 5
			$topFive = array_slice($results, 0, 5, true);
			//checks if the user is part of top 5
			$userInTopFive = array_search($userId, array_column($topFive, 'user_id'));

			//if user is in top 5 slice the top 6 in otherwise top 5 because we always show the users score in the frontend
			if (count($results) < 6) {
				$topFive = $results;
			} 
			elseif($userInTopFive !== false) {
				$topFive = array_slice($results, 0, 6, true);
			}

			$output = json_encode([
				'quiz_name'      => $safeId,
				'question_count' => $count,
				'leaderboard'    => $topFive,
				'average_score'  => $score,
				'average_time'   => $time,
				'user_result'    => $userResult
			]);

			return $this->output
				->set_content_type('application/json')
				->set_output($output);
		}

		return false;
	}
}
