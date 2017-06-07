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
		if(!is_numeric($id) || !$this->session->userdata('user_type') == 1)
		{
			return false;
		}

		$safeId = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
		
		//get list of classes with students who has taken the quiz with $safeId
		$query = $this->resultsModel->getClassList($safeId);

		if(count($query) == 0) {
			return false;
		}

		//querybuilder returns as array with objects for each database row, this converts the objects to assoc arrays
		array_walk($query, function(&$item , $key)
		{
		   $item = (array) $item;
		});

		$classIds = array_column($query, 'class_id');

		//get class rows from database where id matches an id from the array $classIds
		$classes  = $this->resultsModel->getClassNames($classIds);	

		//convert querybuilder objects to arrays
		array_walk($classes, function(&$item , $key)
		{
		   $item = (array) $item;
		});

		$classNames = [];

		//sets the class rows from db to $classNames and also adds a count key with the amount of students from that class who has taken this quiz atleast once
		foreach ($classes as $i => $class) {
			$class_id = $class['id'];
			$count = count($this->resultsModel->getUserCount($id, $class_id));
			

			$classNames[$i] = $class;
			$classNames[$i]['count'] = $count;
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($classNames));
	}

	/**
	 * @return the user quiz ids of the quizzes each user in the class has taken of that specific quiz
	 */
	public function getClassResults()
	{
		if($this->input->method() === 'post' && $this->session->userdata('user_type') == 1)
		{
			$array = json_decode(file_get_contents('php://input'), true);

			//gets class id and quiz id from POST
			$class_id = $array['class_id'];
			$quiz_id = $array['quiz_id'];

			//selects id's of users where class id matches $class_id
			$userIds = $this->resultsModel->classUsers($class_id);

			//convert object to array
			array_walk($userIds, function(&$item , $key)
			{
			   $item = (array) $item;
			});

			//save all ids only
			$userIds = array_column($userIds, 'id');

			//takes array of user ids and gets the first user quiz id for each user to avoid multiple values per user
			$userQuizIds = $this->resultsModel->getUserQuizByUserId($userIds);

			$ids = [];

			//push all ids to an empty array
			foreach ($userQuizIds as $id) {
				array_push($ids, $id->id);
			}

			//gets the user_quiz row where quiz id and id matches the passed in values, note $ids is an array so it is for each of them
			$userResults = $this->resultsModel->getUserResults($quiz_id, $ids);

			$userinfo = [];


			foreach($userResults as $item)
			{
				//gets amount of correct answers for this user_quiz 
				$correct_answers = $this->leaderboardModel->getStats($item->id);
				//gets username of person who took this user quiz
				$name = $this->leaderboardModel->getName($item->id);

				$info = [
					'user_quiz_id'          => $item->id,
					'name'                  => $name,
					'user_id'               => $item->user_id, 
					'correct_answers_count' => $correct_answers,
					'time_seconds'          => $item->time
				];

				//push above info to an associative array for each userresult
				array_push($userinfo, $info);		
			}

			//sort by highest correct, if same correct then lowest time
			usort($userinfo, function ($item1, $item2) {
				//if item1 and item2 has the same amount of correct answers
				if (($item2['correct_answers_count'] <=> $item1['correct_answers_count']) == 0) {
					//sort $userinfo by time_seconds property ascending
					return $item1['time_seconds'] <=> $item2['time_seconds'];
				}
				//sort $userinfo by correct_answer_count property descending
			    return $item2['correct_answers_count'] <=> $item1['correct_answers_count'];
			});

			return $this->output->set_content_type('application/json')->set_output(json_encode($userinfo));
		}

		return false;
	}

	public function getUserCount()
	{
		if($this->input->method() === 'post' && $this->session->userdata('user_type') == 1)
		{
			$array = json_decode(file_get_contents('php://input'), true);

			$class_id = $array['class_id'];
			$quiz_id = $array['quiz_id'];

			$count = $this->resultsModel->getUserCount($quiz_id, $class_id);

			return $this->output->set_content_type('application/json')->set_output(json_encode($count));
		}

		return false;
	}

	public function getUserResults($quiz_id)
	{
		if(is_numeric($quiz_id) && $this->session->userdata('user_type') == 1)
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
		if (!is_numeric($user_quiz_id) && !$this->session->userdata('user_type') == 1) {
			return false;
		}

		$result = $this->db
			->where('id', $user_quiz_id)
			->get('user_quiz')
			->row();

		return $this->output->set_content_type('application/json')->set_output(json_encode($result));
	}


	public function getUserAnswers($user_quiz_id)
	{
		if (!is_numeric($user_quiz_id) && !$this->session->userdata('user_type') == 1) {
			return false;
		}

		$answer_ids = $this->resultsModel->getUserAnswers($user_quiz_id);
		
		return $this->output->set_content_type('application/json')->set_output(json_encode($answer_ids));
	}
}