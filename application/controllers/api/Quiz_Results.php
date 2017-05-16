<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz_Results extends CI_Controller
{
	public function __construct()
	{
		Parent::__construct();
		$this->load->model('Quiz_Model', 'quizModel');
        $this->load->model('Question_Model', 'questionModel');
        $this->load->model('Answer_Model', 'answerModel');
        $this->load->model('Results_Model', 'resultsModel');
	}

	public function getClassList()
	{
		if ($this->session->userdata('user_type') == 1) 
		{
			$query = $this->db->from('classes')
				->select('*')
				->get();

			return json_encode($query->result());
		}
		return json_encode('Not teacher');
	}

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

			return $userQuizIds;
		}
	}
}







