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

	/**
	*  Overview of quizzes.
	*
	*/
	
	public function index()
	{
		$data['quizzes'] = $this->quizModel->get();
		$this->load->view('quiz_overview-view', $data);	
	}

    public function show($id)
    {
        $this->load->view('header');
        $this->load->view('quiz_show');
        $this->load->view('footer');
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
	*  Deletes a quiz by id.
	*
	*  @param int $id Id of quiz that is going to be deleted
	*/

	private function delete(int $id = null)
	{
		$safeId = preg_replace('/[^0-9]/', '', $id);

		if(filter_var($safeId, FILTER_VALIDATE_INT))
		{
			$data['quiz'] = $this->quizModel->delete($safeId);

			$this->load->view('quiz_single-view', $data);
			return true;	
		}

		redirect('quiz', 'refresh');
		return false;	
	}
}