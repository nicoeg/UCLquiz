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
		
		if ($this->auth->access()) {
			// echo json_encode( array( 
			// 	'redirect' => 'location:' . base_url(),
			// 	'test' => 'test',
			// 	) );
			echo json_encode( array( 
				'redirect' => base_url('quiz'),
				'errors' => 'wrong username or ',
				) );
		} else {
			echo json_encode( array( 
				'redirect' => 'location:' . base_url(),
				'error' => 'wrong username or password',
				) );
		}

		





		// if ($_SERVER['REQUEST_METHOD'] === 'GET') 
		// {
		// 	if (!empty($_GET['email'])) {
		// 		echo 'hi';
		// 	} else {
		// 		redirect(base_url());
		// 	}
		// 	// $this->auth->access();
		// 	// $output = $this->User_model->get();
		// 	// $status = 200;
		// }
		// else {
		// 	redirect(base_url());
		// }
		// // echo '<pre>';
		// // print_r(getallheaders());
	}
}