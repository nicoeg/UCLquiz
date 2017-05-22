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
	

	public function getSingle(int $id)
	{
		if($this->session->userdata('logged_in') === true)
		{	
			if($this->session->userdata('user_type') == 0)
			{
				$quizId = $id;
				$data   = $this->quizModel->getQuizById($quizId);

				$questions = $this->questionModel->getQuestionsByQuizId($quizId);

				foreach ($questions as $key => $question) {
				    $answers = $this->answerModel->getAnswersByQuestionId($question->id);
	                $questions[$key]->answers = array_map(function($answer) {
	                    unset($answer->correct);

	                    return $answer;
	                }, $answers);
	            }

	            $data->questions = $questions;

				$dataJSON = json_encode($data);
			}

			$quizId = $id;
			$data   = $this->quizModel->getQuizById($quizId);

			$questions = $this->questionModel->getQuestionsByQuizId($quizId);

			foreach ($questions as $key => $question) {
			    $answers = $this->answerModel->getAnswersByQuestionId($question->id);
	                $questions[$key]->answers = array_map(function($answer) {
						return $answer;
	                }, $answers);
            }

            $data->questions = $questions;

			$dataJSON = json_encode($data);
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
        if ($this->input->method() != 'post') {
            redirect('404');
        }

        $request_data = json_decode(file_get_contents('php://input'), true);

      	$user_quiz_id = $this->quizModel->saveUserResult($quiz_id, $this->session->userdata('uid'), $request_data['time']); 

        $this->answerModel
    	    ->saveUserAnswers(
    	    	$this->session->userdata('uid'), 
    	    	$request_data['answers'], 
    	    	$user_quiz_id
    	   	); 

        return $this->output
    	    ->set_content_type('application/json')
    	    ->set_output(json_encode($this->quizModel
    	    ->getCorrectAnswers($quiz_id)));
	}

	public function createQuiz()
	{
		if($this->input->method() != 'post')
		{
			return false;
		}
		
		$receivedData = json_decode(file_get_contents('php://input'), true);

		if(is_string($receivedData['title']) || is_numeric($receivedData['course_id']) || is_numeric($receivedData['level']) || is_array($receivedData['questions'])) 
		{
			return false;
		}

		/**
		 * Needs to be sanitized
		 */
		
		$title     = $receivedData['title'];
		$course    = $receivedData['course_id'];
		$level     = $receivedData['level'];
		$questions = $receivedData['questions'];

		$quizId = $this->quizModel->setQuiz(
				$course, 
				$level,
				$title
			);

		foreach($questions as $question)
		{
			if(is_string($question['question']) || is_numeric($question['type']) || is_string($question['hint']))
			{
				//Delete quiz here
				return false;
			}

			/**
			 * Needs to be sanitized
			 */

			$qString  = $question['question'];
			$type     = $question['type'];
			$hint     = $question['hint'];
			$qId      = $quizId;
			$answers  = $question['answers'];

			$questionId = $this->quizModel->setQuestions(
				$qId,
				$qString, 
				$type, 
				$hint
			);

			foreach($answers as $answer)
			{
				if(is_string($answer['answer']) || is_numeric($answer['correct']))
				{
					//Delete quiz here
					return false;
				}

				/**
				 * Needs to be sanitized
				 */

				$aString = $answer['answer'];
				$correct = $answer['correct'];

				$this->quizModel->setAnswers($questionId, $aString, $correct);

				return true;
			}
		}
	}

	public function updateQuiz($id)
	{
		if($this->input->method() != 'post')
		{
			return false;
		}

		$answer_ids = $this->db
			->select('answers.id')
			->join('answers', 'answers.question_id = questions.id')
			->where('quiz_id', $id)
			->get('questions')
			->result(); 

		foreach ($answer_ids as $answer_id) {
			$this->quizModel->deleteAnswer($answer_id->id);
		}

		$question_ids = $this->db
			->select('id')
			->where('quiz_id', $id)
			->get('questions')
			->result();

		foreach ($question_ids as $question_id) {
			$this->quizModel->deleteQuestion($question_id->id);
		}

		$this->quizModel->deleteQuiz($id);

		$this->createQuiz();
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
		$new = $this->quizModel->getNew($limit);

		return $this->output->set_content_type('application/json')->set_output(json_encode($new));
	}

	public function getQuizzesByCourse($id)
	{
		$quizByCourse = $this->quizModel->getByCourse($id);

		return $this->output->set_content_type('application/json')->set_output(json_encode($quizByCourse));
	}

	public function getCompletedQuizzes()
	{
		$completed = $this->quizModel->getCompleted();

		return $this->output->set_content_type('application/json')->set_output(json_encode($completed));
	}
}