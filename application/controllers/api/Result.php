<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Result extends CI_Controller
{
	public function __construct()
	{
		Parent::__construct();
		$this->load->model('Quiz_Model', 'quizModel');
        $this->load->model('Question_Model', 'questionModel');
        $this->load->model('Answer_Model', 'answerModel');
        $this->load->model('Results_Model', 'resultsModel');
        $this->load->model('Leaderboard_Model', 'leaderboardModel');
	}

	/**
	 * @return list of classes as JSON
	 */
	public function getClassList($id)
	{
		if ($this->session->userdata('user_type') == 1) 
		{
			$query = $this->resultsModel->getClassList($id);

			array_walk($query, function(&$item , $key)
			{
			   $item = (array) $item;
			});

			$classIds = array_column($query, 'class_id');

			$classes = $this->resultsModel->getClassNames($classIds);

			

			array_walk($classes, function(&$item , $key)
			{
			   $item = (array) $item;
			});

			$classNames = [];

			foreach ($classes as $i => $class) {
				$class_id = $class['id'];
				$count = count($this->resultsModel->getUserCount($id, $class_id));
				

				$classNames[$i] = $class;
				$classNames[$i]['count'] = $count;
			}

			return $this->output->set_content_type('application/json')->set_output(json_encode($classNames));
		}
		return json_encode('Not teacher');
	}

	/**
	 * @return the user quiz ids of the quizzes each user in the class has taken of that specific quiz
	 */
	public function getClassResults()
	{
		if($this->input->method() === 'post')
		{
			$array = json_decode(file_get_contents('php://input'), true);

			$class_id = $array['class_id'];
			$quiz_id = $array['quiz_id'];

			$userIds = $this->resultsModel->classUsers($class_id);

			array_walk($userIds, function(&$item , $key)
			{
			   $item = (array) $item;
			});

			$userIds = array_column($userIds, 'id');

			$userQuizIds = $this->resultsModel->getUserQuizByUserId($userIds);

			$ids = [];

			foreach ($userQuizIds as $id) {
				array_push($ids, $id->id);
			}
			$userResults = $this->resultsModel->getUserResults($quiz_id, $ids);

			$userinfo = [];

			foreach($userResults as $item)
			{
				$correct_answers = $this->leaderboardModel->getStats($item->id);
				$name = $this->leaderboardModel->getName($item->id);

				$info = [
					'user_quiz_id'          => $item->id,
					'name'                  => $name,
					'user_id'               => $item->user_id, 
					'correct_answers_count' => $correct_answers,
					'time_seconds'          => $item->time
				];

				array_push($userinfo, $info);		
			}

			usort($userinfo, function ($item1, $item2) {
				if (($item2['correct_answers_count'] <=> $item1['correct_answers_count']) == 0) {
					return $item1['time_seconds'] <=> $item2['time_seconds'];
				}
			    return $item2['correct_answers_count'] <=> $item1['correct_answers_count'];
			});

			return $this->output->set_content_type('application/json')->set_output(json_encode($userinfo));
		}
	}

	public function getUserCount()
	{
		if($this->input->method() === 'post')
		{
			$array = json_decode(file_get_contents('php://input'), true);

			$class_id = $array['class_id'];
			$quiz_id = $array['quiz_id'];

			$count = $this->resultsModel->getUserCount($quiz_id, $class_id);

			return $this->output->set_content_type('application/json')->set_output(json_encode($count));
		}
	}

	public function getUserResults($quiz_id)
	{
		if(is_numeric($quiz_id))
		{
			$leaderboard        = $this->resultsModel->getUserResults($quiz_id);
			$results            = [];
			$count              = $this->leaderboardModel->getQuestionCount($quiz_id);

			foreach($leaderboard as $item)
			{
				$correct_answers = $this->leaderboardModel->getStats($item->id);
				$name = $this->leaderboardModel->getName($item->id);

				$results['userId'.$item->user_id] = [
					'name'                  => $name,
					'user_id'               => $item->user_id, 
					'correct_answers_count' => $correct_answers,
					'time_seconds'          => $item->time
				];		
			}

			$userId = $this->session->userdata('uid');
			$userResult = $results['userId'.$userId];
			$score = array_sum(array_column($results, 'correct_answers_count')) / count($results);
			$time = array_sum(array_column($results, 'time_seconds')) / count($results);

			usort($results, function ($item1, $item2) {
				if (($item2['correct_answers_count'] <=> $item1['correct_answers_count']) == 0) {
					return $item1['time_seconds'] <=> $item2['time_seconds'];
				}
			    return $item2['correct_answers_count'] <=> $item1['correct_answers_count'];
			});
			$topFive = array_slice($results, 0, 5, true);
			$userInTopFive = array_search($userId, array_column($topFive, 'user_id'));

			if (count($results) < 6) {
				$topFive = $results;
			} 
			elseif($userInTopFive !== false) {
				$topFive = array_slice($results, 0, 6, true);
			}

			$output = json_encode([
				'quiz_name'      => $quiz_id,
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

	public function getUserResult($user_quiz_id) 
	{
		$result = $this->db
			->where('id', $user_quiz_id)
			->get('user_quiz')
			->row();

		return $this->output->set_content_type('application/json')->set_output(json_encode($result));
	}


	public function getUserAnswers($user_quiz_id)
	{
		$answer_ids = $this->resultsModel->getUserAnswers($user_quiz_id);
		
		return $this->output->set_content_type('application/json')->set_output(json_encode($answer_ids));
	}
}







