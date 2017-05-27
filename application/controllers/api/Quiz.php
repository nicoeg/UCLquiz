<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz extends CI_Controller
{
	private $status;

	public function __construct()
	{
		Parent::__construct();
		$this->load->model('Quiz_Model', 'quizModel');
        $this->load->model('Question_Model', 'questionModel');
        $this->load->model('Answer_Model', 'answerModel');
	}

	/**
	 * Retrieves a single quiz
	 * @return Object JSON data with quiz questions and answers
	 *
	 * int $id Id of quiz
	 */
	

	public function getSingle($id)
	{
		if(!is_numeric($id))
		{
			return false;
		}

		$safeId = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

		if($this->session->userdata('logged_in') === true)
		{	
			if($this->session->userdata('user_type') == 0)
			{
				$data      = $this->quizModel->getQuizById($safeId);
				$questions = $this->questionModel->getQuestionsByQuizId($safeId);

				foreach($questions as $key => $question) 
				{
				    $answers = $this->answerModel->getAnswersByQuestionId($question->id);
	                $questions[$key]->answers = array_map(function($answer) 
	                {
	                    unset($answer->correct);
	                    return $answer;
	                }, $answers);
	            }

	            $data->questions = $questions;
				$dataJSON        = json_encode($data);
			}

			$data      = $this->quizModel->getQuizById($safeId);
			$questions = $this->questionModel->getQuestionsByQuizId($safeId);

			foreach($questions as $key => $question) 
			{
			    $answers = $this->answerModel->getAnswersByQuestionId($question->id);
	                $questions[$key]->answers = array_map(function($answer) 
	                {
						return $answer;
	                }, $answers);
            }

            $data->questions = $questions;
			$dataJSON        = json_encode($data);
		} 
		else 
		{
			$dataJSON = json_encode([
				'error'    => 'You are not logged in',
				'redirect' => base_url(),
			]);
		}

		return $this->output->set_content_type('application/json')->set_output($dataJSON);
	}

    public function saveResult($quiz_id) {
        if($this->input->method() != 'post') 
        {
            redirect('404');
        }

        if(is_numeric($quiz_id))
        {
        	$safeId       = filter_var($quiz_id, FILTER_SANITIZE_NUMBER_INT);
            $request_data = json_decode(file_get_contents('php://input'), true);
          	$user_quiz_id = $this->quizModel->saveUserResult($safeId, $this->session->userdata('uid'), $request_data['time']); 

            $this->answerModel
        	    ->saveUserAnswers(
        	    	$this->session->userdata('uid'), 
        	    	$request_data['answers'], 
        	    	$user_quiz_id
        	   	); 

            return $this->output
        	    ->set_content_type('application/json')
        	    ->set_output(json_encode($this->quizModel
        	    ->getCorrectAnswers($safeId)));
        }
	}

	public function createQuiz($id = null)
	{
		if($this->input->method() != 'post')
		{
			return false;
		}
		
		$data = json_decode(file_get_contents('php://input'), true);

		if(!is_string($data['title']) || !is_numeric($data['course_id']) || !is_numeric($data['level']) || !is_array($data['questions'])) 
		{
			return false;
		}

		/**
		 * Needs to be sanitized
		 */
		
		$title     = mysqli_real_escape_string(filter_var($data['title'], FILTER_SANITIZE_STRING));
		$course    = filter_var($data['course_id'], FILTER_SANITIZE_NUMBER_INT);
		$level     = filter_var($data['level'], FILTER_SANITIZE_NUMBER_INT);
		$questions = $data['questions'];

		if($id !== null) 
		{
			$quizId = $this->quizModel->updateQuiz(
				$id,
				$course, 
				$level,
				$title
			);
		} 
		else 
		{
			$quizId = $this->quizModel->setQuiz(
				$course, 
				$level,
				$title
			);
		}

		foreach($questions as $question)
		{
			if(!is_string($question['question']) || !is_numeric($question['type']) || !is_string($question['hint']))
			{
				return false;
			}

			$qString  = mysqli_real_escape_string(filter_var($question['question'], FILTER_SANITIZE_STRING));
			$type     = filter_var($question['type'], FILTER_SANITIZE_NUMBER_INT);
			$hint     = mysqli_real_escape_string(filter_var($question['hint'], FILTER_SANITIZE_STRING));
			$qId      = filter_var($quizId, FILTER_SANITIZE_NUMBER_INT);
			$answers  = $question['answers'];

			$questionId = $this->quizModel->setQuestions(
				$qId,
				$qString, 
				$type, 
				$hint
			);

			foreach($answers as $answer)
			{
				if(!is_string($answer['answer']) || !is_numeric($answer['correct']))
				{
					return false;
				}

				$aString = mysqli_real_escape_string(filter_var($answer['answer'], FILTER_SANITIZE_STRING));
				$correct = filter_var($answer['correct'], FILTER_SANITIZE_NUMBER_INT);

				$this->quizModel->setAnswers($questionId, $aString, $correct);
			}
		}
	}

	public function updateQuiz($id)
	{
		if($this->input->method() != 'post')
		{
			return false;
		}

		if(is_numeric($id))
		{
			$safeId = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

			$answer_ids = $this->db
				->select('answers.id')
				->join('answers', 'answers.question_id = questions.id')
				->where('quiz_id', $safeId)
				->get('questions')
				->result(); 

			foreach($answer_ids as $answer_id) 
			{
				$this->quizModel->deleteAnswer($answer_id->id);
			}

			$question_ids = $this->db
				->select('id')
				->where('quiz_id', $safeId)
				->get('questions')
				->result();

			foreach($question_ids as $question_id) 
			{
				$this->quizModel->deleteQuestion($question_id->id);
			}

			$user_answer_ids = $this->db
				->select('user_answer.id')
				->join('user_answer', 'user_answer.user_quiz_id = user_quiz.id')
				->where('quiz_id', $safeId)
				->get('user_quiz')
				->result(); 

			foreach($user_answer_ids as $user_answer_id) 
			{
				$this->quizModel->deleteUserAnswer($user_answer_id->id);
			}

			$this->quizModel->deleteUserQuiz($safeId);

			$this->createQuiz($safeId);

			return true;
		}

		return false;
	}

	public function getCourses()
	{
		$courses = $this->quizModel->getCourses();

		return $this->output->set_content_type('application/json')->set_output(json_encode($courses));
	}

	public function getQuizzes()
	{
		$quizzes = $this->quizModel->get();

		return $this->output->set_content_type('application/json')->set_output(json_encode($quizzes));
	}

	public function getNewQuizzes($limit)
	{
		if(is_numeric($limit))
		{
			$safeLimit = filter_var($limit, FILTER_SANITIZE_NUMBER_INT);
			$new = $this->quizModel->getNew($safeLimit);

			return $this->output->set_content_type('application/json')->set_output(json_encode($new));
		}

		return false;
	}

	public function getQuizzesByCourse($id)
	{
		if(is_numeric($id))
		{
			$safeId       = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
			$quizByCourse = $this->quizModel->getByCourse($safeId);

			return $this->output->set_content_type('application/json')->set_output(json_encode($quizByCourse));
		}

		return false;
	}

	public function getCompletedQuizzes()
	{
		$completed = $this->quizModel->getCompleted();

		return $this->output->set_content_type('application/json')->set_output(json_encode($completed));
	}
}
