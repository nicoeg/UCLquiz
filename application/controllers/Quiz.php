<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz extends CI_Controller
{
	public function __construct()
	{
		Parent::__construct();
		$this->load->model('Quiz_model', 'quizModel');
	}

	/**
	*  Overview of quizzes.
	*
	*/
	
	public function index()
	{
		if ($this->session->userdata('logged_in') === true) {
			$data['quizzes'] = $this->quizModel->get();
			$this->load->view('quiz_overview-view', $data);	
		} else {
			redirect(base_url());
		}
		
		
	}

	/**
	*  View a quiz by id.
	*
	*  @param int $id Id of quiz that is going to be viewed
	*/

	public function view(int $id = null)
	{
		$safeId = preg_replace('/[^0-9]/', '', $id);

		if(filter_var($safeId, FILTER_VALIDATE_INT))
		{
			$data['quiz'] = $this->quizModel->getQuizById($safeId);

			$this->load->view('quiz_single-view', $data);
			return true;	
		}

		redirect('quiz', 'refresh');
		return false;
	}

	/**
	*  Controller delete quiz by id.
	*
	*  @param int $id Id of quiz that is going to be deleted
	*/

	public function delete(int $id = null)
	{
		$safeId = preg_replace('/[^0-9]/', '', $id);

		if(filter_var($safeId, FILTER_VALIDATE_INT))
		{
			$data['quiz'] = $this->quizModel->delete($safeId);

			redirect('quiz', 'refresh');
			return true;	
		}

		redirect('quiz', 'refresh');
		return false;	
	}

	public function create()
	{
		$this->load->library('form_validation');

		if($this->form_validation->run('create-quiz') == true)
		{
			$cID   = $this->input->post('course');
			$level = $this->input->post('level');
			$uID   = 1;
			$title = stripslashes($this->input->post('title'));

			var_dump('test-no-if');

			if(isset($cID) && isset($level) && isset($uID) && isset($title))
			{
				$data = [
					'cID'   => $cID,
					'level' => $level,
					'uID'   => $uID,
					'title' => $title,
				];

				var_dump('test');

				$this->quizModel->set($data);
			}
		}

		$this->load->view('quiz_create-view');
	}
}