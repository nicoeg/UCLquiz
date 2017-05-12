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
	
	public function index()
	{
		if ($this->session->userdata('logged_in') === true) {
			$data['quizzes'] = $this->quizModel->get();
			$this->load->view('quiz_overview-view', $data);	
		} else {
			redirect(base_url());
		}
		
		
	}

    public function show($id)
    {
        $this->load->view('header', [
            'logged_in' => $this->session->userdata('logged_in')
        ]);

        $this->load->view('quiz_show', ['quizId' => $id]);
        $this->load->view('footer');
    }
}