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

			return $this->output->set_content_type('application/json')->set_output(json_encode($classes));
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

			return $this->output->set_content_type('application/json')->set_output(json_encode($userQuizIds));
		}
	}
}







