<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz extends CI_Controller
{
	public function __construct()
	{
		Parent::__construct();
		$this->load->model('Quiz_model', 'quizModel');
	}
	
	public function index()
	{
		$data['quizzes'] = $this->quizModel->get();
		$this->load->view('quiz_overview-view', $data);	
	}

	public function view($id = null)
	{
		$data['quiz'] = $this->quizModel->getQuizById($id);
		echo '<pre>';
		print_r($data['quiz']);
		// $this->load->view('quiz_single-view', $data);	
	}
}