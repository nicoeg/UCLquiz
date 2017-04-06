<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz_Rest extends CI_Controller
{
	private $status;

	public function __construct()
	{
		Parent::__construct();
		$this->load->model('Quiz_Model', 'quizModel');
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
			// $data = $this->quizModel->getQuizById($id);
			$data['view'] = $this->load->view('quiz_single-view');

			$dataJSON = json_encode($data);

			echo $dataJSON;
		} 
		else 
		{
			$dataJSON = json_encode([
				'error' => 'You are not logged in',
				'redirect' => base_url(),
			]);

			echo $dataJSON;
		}
	}
	
	/**
	 * Creates a quiz
	 */
	public function set()
	{

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