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

	/**
	*  Method to set a quiz
	*
	*  @param array $data Array with data from input fields
	*/

	public function setQuiz($data)
	{	
		$safe = [
			'course_id' => filter_var($data['cID'], FILTER_SANITIZE_NUMBER_INT),
			'level'     => filter_var($data['level'], FILTER_SANITIZE_NUMBER_INT),
			'user_id'   => filter_var($data['uID'], FILTER_SANITIZE_NUMBER_INT),
			'title'     => filter_var($data['title'], FILTER_SANITIZE_STRING)
		];

		if(filter_var($safe['course_id'], FILTER_VALIDATE_INT) && filter_var($safe['level'], FILTER_VALIDATE_INT) && filter_var($safe['user_id'], FILTER_VALIDATE_INT) && is_string($safe['title']))
		{
			$this->db->insert($this->table, [
				'cID'   => $safe['course_id'],
				'level' => $safe['level'],
				'uID'   => $safe['user_id'],
				'title' => $safe['title'],
			]);

			$last_id = $this->db->insert_id();

			foreach($data['questions'] as $question)
			{
				$safe = [
					'question' => filter_var($question['question'], FILTER_SANITIZE_STRING),
					'type'     => filter_var($question['type'], FILTER_SANITIZE_NUMBER_INT),
					'answers'  => filter_var($question['answers'], FILTER_SANITIZE_STRING),
					'hint'     => filter_var($question['hint'], FILTER_SANITIZE_STRING), 
				];

				if(is_string($safe['question']) && filter_var($safe['type'], FILTER_VALIDATE_INT) && is_string($safe['answers']) && is_string($safe['hint']))
				{
					$data = [
						'qID'      => $last_id,
						'question' => $safe['question'],
						'type'     => $safe['type'],
						'answers'  => $safe['answers'],
						'hint'     => $safe['hint']
					];

					$this->setQuestions($data);
				}
			}
		}
	}

	public function setQuestions($data)
	{
		$safe = [
			'quiz_id'  => filter_var($data['qID'], FILTER_SANITIZE_NUMBER_INT),
			'question' => filter_var($data['question'], FILTER_SANITIZE_STRING),
			'type'     => filter_var($data['type'], FILTER_SANITIZE_NUMBER_INT)
		];

		if(filter_var($safe['quiz_id'], FILTER_VALIDATE_INT) && is_string($safe['question']) && filter_var($safe['type'], FILTER_VALIDATE_INT))
		{
			$this->db->insert('questions', [
				'quiz_id'  => $safe['quiz_id'],
				'question' => $safe['question'],
				'type'     => $safe['type']
			]);

			$last_id = $this->db->insert_id();

			foreach($data['answers'] as $answer)
			{
				$safe = [
					'answer'  => filter_var($answer['answer'], FILTER_SANITIZE_STRING),
					'correct' => filter_var($answer['correct'], FILTER_SANITIZE_NUMBER_INT)
				],

				if(is_string($safe['answer']) && filter_var($safe['correct'], FILTER_VALIDATE_INT))
				{
					$data = [
						'question_id' => $last_id,
						'answer'      => $safe['answer'],
						'correct'     => $safe['correct'],
					];

					$this->setAnswers($answer);
				}
			}
		}
	}

	public function setAnswers($data)
	{
		$safe = [
			'question_id' => filter_var($data['question_id'], FILTER_SANITIZE_NUMBER_INT),
			'answer' => filter_var($data['answer'], FILTER_SANITIZE_STRING),
			'correct' => filter_var($data['correct'], FILTER_SANITIZE_NUMBER_INT),
		],

		if(filter_var($safe['question_id'], FILTER_VALIDATE_INT) && is_string($safe['answer']) && filter_var($safe['correct'], FILTER_VALIDATE_INT))
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
    	$safe = [
    		'quiz_id' => filter_var($quiz_id, FILTER_SANITIZE_NUMBER_INT),
    		'user_id' => filter_var($user_id, FILTER_SANITIZE_NUMBER_INT)
    	],

    	if(filter_var($safe['quiz_id'], FILTER_VALIDATE_INT) && filter_var($safe['user_id'], FILTER_VALIDATE_INT))
    	{
    		$this->db->insert('user_quiz', [
    		    'user_id' => $safe['quiz_id'],
    		    'quiz_id' => $safe['user_id']
    		]);
    	}
	}

    public function getCorrectAnswers($quiz_id)
    {
    	$safe['quiz_id'] => filter_var($quiz_id, FILTER_SANITIZE_NUMBER_INT);

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