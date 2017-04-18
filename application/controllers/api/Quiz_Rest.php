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
	 * @return [type] [description]
	 */
	public function getSingle()
	{
		if($this->session->userdata('logged_in') === true)
		{	
			$id = json_decode($_GET['id']);
			$data = $this->quizModel->getQuizById($id);

			$questions = $this->questionModel->getQuestionsByQuizId($id);

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
		else 
		{
			$dataJSON = json_encode([
				'error' => 'You are not logged in',
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

        $this->quizModel->saveUserResult($quiz_id, $this->session->userdata('uid'));
        $this->answerModel->saveUserAnswers($this->session->userdata('uid'), $request_data['answers']);

        return $this->output->set_content_type('application/json')->set_output(json_encode($this->quizModel->getCorrectAnswers($quiz_id)));
	}
	
	/**
	 * Creates a quiz
	 */
	public function post()
	{
		if($_POST)
		{
			$title  = $_POST['title'];
			$course = $_POST['course'];
			$level  = $_POST['level'];
			$uID    = 1;

			if(isset($title) && isset($course) && isset($level))
			{
				$data = [
					'title'  => $title,
					'cID'    => $course,
					'level'  => $level,
					'uID'    => $uID
				];

				$this->quizModel->set($data);
			}
		}
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