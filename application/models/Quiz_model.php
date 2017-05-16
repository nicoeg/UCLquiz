<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz_model extends CI_Model
{
	/**
	*  Table name
	*
	*  @var string
	*/

	private $table = 'quizzes';

	/**
	*  Method to get quiz by id
	*
	*  @param int $id Id of quiz that is going to be viewed
	*/

	public function getQuizById($id)
	{
		$safeId = preg_replace('/[^0-9]/', '', $id);

		if(filter_var($safeId, FILTER_VALIDATE_INT)) 
		{
			$query = $this->db
				->where('id', $safeId)
				->limit(1)
				->get($this->table);

			return $query->row();
		}

		return false;
	}

	/**
	*  Method to get all quizzes
	*
	*/

	public function get()
	{
		$query = $this->db->get('quizzes');

		return $query->result();
	}

	public function getNew($limit) 
	{ 
		$query = $this->db->from('quizzes') 
		  ->order_by('id', 'DESC') 
		  ->limit($limit) 
		  ->get(); 

		return $query->result(); 
	} 

	public function getByCourse($course)  
	{ 
		$query = $this->db->from('quizzes') 
		        ->select('*') 
		        ->join('courses', 'courses.id = quizzes.course_id') 
		        ->where('name', $course) 
		        ->get(); 

		return $query->result(); 
	} 

	public function getCompleted() 
	{ 
		if(null !== $this->session->userdata('uid')) 
		{ 
			$id = $this->session->userdata('uid'); 
			$query = $this->db->join('quizzes', 'quizzes.id = user_quiz.quiz_id')->where('user_id', $id)->get('user_quiz'); 

			return $query->result(); 
		} 
	} 

	public function getCourses()
	{
		$query = $this->db->get('courses');

		return $query->result();
	}

	/**
	*  Method to set a quiz
	*
	*  @param array $data Array with data from input fields
	*/

	public function setQuiz($course_id, $level, $title)
	{	
		$safe = [
			'course_id' => filter_var($course_id, FILTER_SANITIZE_NUMBER_INT),
			'level'     => filter_var($level, FILTER_SANITIZE_NUMBER_INT),
			'user_id'   => filter_var($this->session->userdata('uid'), FILTER_SANITIZE_NUMBER_INT),
			'title'     => filter_var($title, FILTER_SANITIZE_STRING)
		];

		if(
			filter_var($safe['course_id'], FILTER_VALIDATE_INT) 
			&& filter_var($safe['level'], FILTER_VALIDATE_INT) 
			&& filter_var($safe['user_id'], FILTER_VALIDATE_INT) 
			&& is_string($safe['title'])
			)
		{
			$this->db->insert($this->table, [
				'course_id'   => $safe['course_id'],
				'level'       => $safe['level'],
				'uID'         => $safe['user_id'],
				'title'       => $safe['title']
			]);

			return $this->db->insert_id();
		}

		die('Quiz data not valid');
	}

	public function setQuestions($quiz_id, $question, $type, $hint)
	{
		$safe = [
			'quiz_id'  => filter_var($quiz_id, FILTER_SANITIZE_NUMBER_INT),
			'question' => filter_var($question, FILTER_SANITIZE_STRING),
			'type'     => filter_var($type, FILTER_SANITIZE_NUMBER_INT),
			'hint'     => filter_var($hint,  FILTER_SANITIZE_STRING)
		];

		if(
			filter_var($safe['quiz_id'], FILTER_VALIDATE_INT) 
			&& is_string($safe['question']) 
			&& filter_var($safe['type'], FILTER_VALIDATE_INT) 
			&& is_string($safe['hint'])
			)
		{
			$this->db->insert('questions', [
				'quiz_id'  => $safe['quiz_id'],
				'question' => $safe['question'],
				'type'     => $safe['type'],
				'hint'     => $safe['hint']
			]);

			return $this->db->insert_id();
		}

		die('Question data not valid');
	}

	public function setAnswers($question_id, $answer, $correct)
	{
		$safe = [
			'question_id' => filter_var($data['question_id'], FILTER_SANITIZE_NUMBER_INT),
			'answer'      => filter_var($data['answer'], FILTER_SANITIZE_STRING),
			'correct'     => filter_var($data['correct'], FILTER_SANITIZE_NUMBER_INT),
		];

		if(
			filter_var($safe['question_id'], FILTER_VALIDATE_INT) 
			&& is_string($safe['answer']) 
			&& filter_var($safe['correct'], FILTER_VALIDATE_INT)
			)
		{
			$this->db->insert('answers', [
				'question_id' => $safe['question_id'],
				'answer'      => $safe['answer'],
				'correct'     => $safe['correct']
			]);
		}
	}

	/**
	*  Method to delete a quiz
	*
	*  @param int $id Id of quiz that is going to be deleted
	*/

	public function delete($id)
	{
		$safeId = preg_replace('/[^0-9]/', '', $id);

		if(filter_var($safeId, FILTER_VALIDATE_INT)) 
		{
			$query = $this->db
				->where('id', $safeId)
				->delete($this->table);
		}

		return false;
	}

	public function update($id, $data)
	{
		$cID    = preg_replace('/[^0-9]/', '', $data['cID']);
		$level  = preg_replace('/[^0-9]/', '', $data['level']);
		$title  = stripslashes($data['title']);
		$safeId = preg_replace('/[^0-9]/', '', $id);

		$data['cID']   = $cID;
		$data['level'] = $level;
		$data['title'] = $title;

		$this->db->where('id', $safeId)
			->update($this->table, $data);
	}

    public function saveUserResult($quiz_id, $user_id)
    {
<<<<<<< HEAD
        $this->db->insert('user_quiz', [
            'user_id' => $user_id,
            'quiz_id' => $quiz_id
        ]);

        return $this->db->insert_id();
=======
    	$safe = [
    		'quiz_id' => filter_var($quiz_id, FILTER_SANITIZE_NUMBER_INT),
    		'user_id' => filter_var($user_id, FILTER_SANITIZE_NUMBER_INT)
    	];

    	if(filter_var($safe['quiz_id'], FILTER_VALIDATE_INT) && filter_var($safe['user_id'], FILTER_VALIDATE_INT))
    	{
    		$this->db->insert('user_quiz', [
    		    'user_id' => $safe['user_id'],
    		    'quiz_id' => $safe['quiz_id']
    		]);
    	}

    	return $this->db->insert_id(); 
>>>>>>> fa711a65b24fe1be2cff5e5aa7aeb2af9575eb78
	}

    public function getCorrectAnswers($quiz_id)
    {
    	$safe['quiz_id'] = filter_var($quiz_id, FILTER_SANITIZE_NUMBER_INT);

    	if(filter_var($safe['quiz_id'], FILTER_VALIDATE_INT))
    	{
    		$query = $this->db->from('answers')
    		    ->select('answers.id, answers.question_id')
    		    ->join('questions', 'questions.id = answers.question_id')
    		    ->where('quiz_id', $safe['quiz_id'])
    		    ->where('correct', 1)
    		    ->get();

    		return $query->result();
    	}
	}
}
