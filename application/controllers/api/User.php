<?php 

class User extends CI_controller 
{
	private $status = 0;

	public function __construct() 
	{
		parent::__construct();
		$this->load->model('User_model');
	}

	public function index() 
	{
		switch($_SERVER['REQUEST_METHOD']) 
		{
			case 'GET':
				$this->auth->access();
				$output = $this->User_model->get();
				$status = 200;
				break;
			// case 'POST':
			// 	$output = $this->user_create();
			// 	$status = $this->status;
			// 	break;
			default: 
				$status = 405;
				$output = 'Not allowed';
		}

		$this->io->out($status, $output);
	}
}