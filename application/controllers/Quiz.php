<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz extends CI_Controller
{
	public function __construct()
	{
		Parent::__construct();
		$this->load->model('Quiz_model', 'quizModel');
	}

    public function _remap($method, $params = [])
    {
        if (is_numeric($method)) {
            return call_user_func_array(array($this, 'show'), [$method]);
        }else if (method_exists($this, $method))
        {
            return call_user_func_array(array($this, $method), $params);
        }

        show_404();
    }
	
	// public function index()
	// {
	// 	if ($this->session->userdata('logged_in') === true) {
	// 		$data['quizzes'] = $this->quizModel->getNew(1);
	// 		$this->load->view('quiz_overview-view', $data);	
	// 	} else {
	// 		redirect(base_url());
	// 	}
		
		
	// }

    public function show($id)
    {
        $this->load->view('header', [
            'logged_in' => $this->session->userdata('logged_in')
        ]);

        $this->load->view('quiz_show', ['quizId' => $id]);
        $this->load->view('footer');
    }

    public function created()
	{
		$this->load->library('form_validation');
		$this->load->model('Question_model', 'questionModel');

		$this->load->view('quiz_created-view');
	}

	public function update($id)
	{
		$this->load->library('form_validation');

		$safeId       = preg_replace('/[^0-9]/', '', $id);
		$data['quiz'] = $this->quizModel->getQuizById($safeId);

		$cID   = $this->input->post('course');
		$level = $this->input->post('level');
		$uID   = 1;
		$title = stripslashes($this->input->post('title'));

		if(isset($cID) && isset($level) && isset($uID) && isset($title))
		{
			if($this->form_validation->run('create-quiz') === true)
			{
				$setData = [
					'cID' => $cID,
					'level' => $level,
					'uID' => $uID,
					'title' => $title,
				];

				$this->quizModel->update($safeId, $setData);
			}	
		}

		$this->load->view('quiz_update-view', $data);
	}

	public function Test()
	{
		$this->load->model('Leaderboard_model');
		echo '<pre>';
		var_dump($this->Leaderboard_model->getLeaderboard(1));
	}

	public function Test2()
	{
		$this->load->model('Leaderboard_model');
		echo '<pre>';
		var_dump($this->Leaderboard_model->getQuestionCount(2));
	}
}
