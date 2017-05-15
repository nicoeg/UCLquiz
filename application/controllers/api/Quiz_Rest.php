<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz_Rest extends CI_Controller
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
	 * Retrieves all quizzes
	 * @return [type] [description]
	 */
	public function index()
	{

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
			$quizId = $id;
			$data   = $this->quizModel->getQuizById($quizId);

			$questions = $this->questionModel->getQuestionsByQuizId($quizId);

			foreach ($questions as $key => $question) {
			    $answers                  = $this->answerModel->getAnswersByQuestionId($question->id);
                $questions[$key]->answers = array_map(function($answer) {
                    unset($answer->correct);

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

      	$user_quiz_id = $this->quizModel->saveUserResult($quiz_id, $this->session->userdata('uid')); 
        $this->answerModel->saveUserAnswers($this->session->userdata('uid'), $request_data['answers'], $user_quiz_id); 
 

        return $this->output->set_content_type('application/json')->set_output(json_encode($this->quizModel->getCorrectAnswers($quiz_id)));
	}
	
	/**
	 * Creates a quiz
	 */
	public function post()
	{
		if($this->input->method() === 'post')
		{
			$array = json_decode(file_get_contents('php://input'), true);

			if(is_string($array['title']) && is_numeric($array['course_id']) && is_numeric($array['level'] && is_array($array['questions']) && is_array($array['answers'])))
			{
				$questions = [];
				$answers   = [];

				foreach($array['questions'] as $question)
				{
					if(is_string($question['question']))
					{
						$question = [
							'question' => $question['question'],
							'type'     => $question['type'],
							'hint'     => $question['hint']
						];

						array_push($questions, $question);
					}
				}

				foreach($array['answers'] as $answer)
				{
					$answer = [
						'answer'  => $answer['answer'],
						'correct' => $answer['correct']
					];

					if(is_string($answer['answer']))
					{
						array_push($answers, $answer);
					}
				}

				$dataToInsert = [
					'title'     => $array['title'],
					'cID'       => $array['course_id'],
					'level'     => $array['level'],
					'user_id'   => 2,
					'questions' => $questions,
					'answers'   => $answers
				];

				echo '<pre>';
				print_r($dataToInsert);
				die();

				$query = $this->quizModel->setQuiz($dataToInsert);

				return $query;
			}
		}

		return false;
	}

	/**
	 * Updates a quiz
	 * @return [type] [description]
	 */
	public function put()
	{

	}

	/**
	 * Deletes a quiz
	 * @return [type] [description]
	 */
	public function delete()
	{

	}
}