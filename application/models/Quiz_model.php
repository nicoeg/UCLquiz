<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz_model extends CI_Model
{


	/**
	 * get quiz info based on its id
	 * @param  int $id 
	 * @return array     from database
	 */


	public function getQuizById($id)
	{
		return $this->db
			->where('id', $id)
			->limit(1)
			->get('quizzes')
			->row();
	}


	/**
	 * gets a list of all quizzes
	 * @return array quiz table from database
	 */
	

	public function get()
	{
		return $this->db
			->get('quizzes')
			->result();
	}


	/**
	 * get a custom amount of the newest quizzes
	 * @param  int $limit amount of quizzes to get
	 * @return array        
	 */
	

	public function getNew($limit) 
	{ 
		return $this->db
			->from('quizzes') 
		  	->order_by('id', 'DESC') 
		  	->limit($limit) 
		  	->get()
			->result(); 
	} 


	/**
	 * get quizzes by course id
	 * @param  int $id 
	 * @return array     
	 */
	

	public function getByCourse($id)  
	{ 
		return $this->db
			->from('quizzes') 
		    ->select('*') 
		    ->join('courses', 'courses.id = quizzes.course_id') 
		    ->where('course_id', $id) 
		    ->get()
			->result(); 
	} 


	/**
	 * get a list of all the quizzes a user has completed including duplicates of the same quiz taken several times
	 * @return array 
	 */
	

	public function getCompleted() 
	{ 
		if(null !== $this->session->userdata('uid')) 
		{ 
			$id = $this->session->userdata('uid'); 

			return $this->db
				->join('quizzes', 'quizzes.id = user_quiz.quiz_id')
				->where('user_id', $id)
				->get('user_quiz')
				->result(); 
		} 

		return false;
	} 


	/**
	 * gets a list of all courses from the database
	 * @return array 
	 */
	

	public function getCourses()
	{
		return $this->db
			->get('courses')
			->result();
	}


	/**
	*  Method to set a quiz
	*
	*  @param array $data Array with data from input fields
	*/


	public function setQuiz($course_id, $level, $title)
	{	
		if(null !== $this->session->userdata('uid')) 
		{ 
			$user_id = $this->session->userdata('uid'); 
	
			$this->db->insert('quizzes', [
				'course_id' => $course_id,
				'level'     => $level,
				'uID'       => $user_id,
				'title'     => $title
			]);

			return $this->db->insert_id();
		}

		return false;
	}


	/**
	 * inserts the questions in the database when you create a quiz
	 * @param int $quiz_id  
	 * @param string $question 
	 * @param int $type     type of question as int
	 * @param string $hint     
	 * @return  int 	id of question from database
	 */
	

	public function setQuestions($quiz_id, $question, $type, $hint)
	{
		$this->db->insert('questions', [
			'quiz_id'  => $quiz_id,
			'question' => $question,
			'type'     => $type,
			'hint'     => $hint
		]);

		return $this->db->insert_id();
	}


	/**
	 * inserts answer data in the database
	 * @param int $question_id 
	 * @param string $answer      
	 * @param int $correct     int used as bool with 0 and 1
	 */
	

	public function setAnswers($question_id, $answer, $correct)
	{
		$this->db->insert('answers', [
			'question_id' => $question_id,
			'answer'      => $answer,
			'correct'     => $correct
		]);
	}


	/**
	 * deletes all data related to the quiz with this id, then inserts a whole new quiz in the database
	 * @param  int $id        quiz id
	 * @param  int $course_id 
	 * @param  int $level     quiz level 1-3
	 * @param  string $title     
	 * @return int            id of quiz from database
	 */
	

	public function updateQuiz($id, $course_id, $level, $title)
	{	
		if(null !== $this->session->userdata('uid')) 
		{ 
			$user_id = $this->session->userdata('uid'); 

			$this->db->replace('quizzes', [
				'id'          => $id,
				'course_id'   => $course_id,
				'level'       => $level,
				'uID'         => $user_id,
				'title'       => $title
			]);

			return $id;
		}

		return false;
	}


	/**
	 * delete question with the passed in id
	 * @param  int $question_id 
	 * @return bool              
	 */
	

	public function deleteQuestion($question_id)
	{
		$this->db->delete('questions', [
			'id' => $question_id
		]);

		return true;
	}


	/**
	 * delete answer with the passed in id
	 * @param  int $answer_id 
	 * @return bool            
	 */
	

	public function deleteAnswer($answer_id)
	{
		$this->db->delete('answers', [
			'id' => $answer_id
		]);

		return true;
	}


	/**
	 * deletes user quiz with the passed in id
	 * @param  int $quiz_id 
	 * @return bool          
	 */
	

	public function deleteUserQuiz($quiz_id)
	{
		$this->db->delete('user_quiz', [
			'id' => $quiz_id
		]);

		return true;
	}


	/**
	 * deletes user answer with the passed in id
	 * @param  int $user_answer_id 
	 * @return bool                 
	 */
	

	public function deleteUserAnswer($user_answer_id)
	{
		$this->db->delete('user_answer', [
			'id' => $user_answer_id
		]);
		
		return true;
	}


	/**
	 * saves result in user_quiz table when a user takes a quiz
	 * @param  int $quiz_id 
	 * @param  int $user_id 
	 * @param  int $time    time in seconds
	 * @return int          returns the id of the user_quiz
	 */
	

    public function saveUserResult($quiz_id, $user_id, $time)
    {
		$this->db->insert('user_quiz', [
		    'user_id' => $user_id,
		    'quiz_id' => $quiz_id,
		    'time'    => $time
		]);

    	return $this->db->insert_id(); 
	}


	/**
	 * gets correct answers by quiz id
	 * @param  int $quiz_id 
	 * @return array          with answer id and question id for each correct question
	 */
	

    public function getCorrectAnswers($quiz_id)
    {
		return $this->db
			->from('answers')
		    ->select('answers.id, answers.question_id')
		    ->join('questions', 'questions.id = answers.question_id')
		    ->where('quiz_id', $quiz_id)
		    ->where('correct', 1)
		    ->get()
			->result();
	}
}
