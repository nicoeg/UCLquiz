<?php 

class Io_lib 
{
	private $ci;

	public function __construct() 
	{
		$this->ci =& get_instance();
	}

	public function out($status, $output) 
	{
		$this->ci->output
			->set_status_header($status)
			->set_content_type('application/json')
			->set_output(json_encode([
				'response' => $output,
				'status'   => $status,
				'time'     => date('Y-m-d H:i:s', time()),
			]))
			->_display();

		die();
	}

	public function in() 
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method === 'POST' || $method === 'PUT') 
		{
			if(count($_POST) > 0) $data = $_POST;
			else $data = (array)json_decode(file_get_contents('php://input'));

			$return = [];
			foreach($data as $key => $value) 
			{
				$sanitizedValue = addslashes(htmlentities(nl2br($value)));
				$return[$key] = $value;
				// array_push($return, $sanitizedValue);
			}

			return $return; 
		}

		return null;
		
	}
}