<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Results_Model extends CI_Model
{


	/**
	 * list of users that belong to a class
	 * @param  int $class_id 
	 * @return array           
	 */
	

	public function classUsers($class_id)
	{
		return $this->db
			->select('id')
			->where('class_id', $class_id)
			->get('users')
			->result();
	}


	/**
	 * gets all user quizzes taken by users with the ids passed in
	 * @param  array $user_id_array 
	 * @return array                with user quizzes
	 */
	

	public function getUserQuizByUserId($user_id_array)
	{
		return $this->db
			->select('id')
			->where_in('user_id', $user_id_array)
			->group_by('user_id')
			->get('user_quiz')
			->result();
	}


	/**
	 * shows all classes with students that has taken the quiz with the id that is passed
	 * @param  int $quiz_id 
	 * @return array          
	 */
	

	public function getClassList($quiz_id)
	{
		return $this->db
			->select('class_id')
			->from('user_quiz')
			->where('quiz_id', $quiz_id)
			->join('users', 'users.id = user_quiz.user_id')
			->group_by('class_id')
			->get()
			->result();
	}


	/**
	 * get all users that has taken the quiz that is passed in and from the class that is passed in
	 * @param  int $quiz_id  
	 * @param  int $class_id 
	 * @return array           
	 */
	

	public function getUserCount($quiz_id, $class_id)
	{
		return $this->db
			->select('user_id')
			->join('users', 'users.id = user_quiz.user_id')
			->where('quiz_id', $quiz_id)
			->where('class_id', $class_id)
 			->group_by('user_id') 
 			->get('user_quiz')
 			->result();
	}


	/**
	 * gets names of classes that has one of the ids passed in
	 * @param  array $array array of class ids
	 * @return array        
	 */
	

	public function getClassNames($array)
	{
		return $this->db
			->select('*')
			->where_in('id', $array)
			->get('classes')
			->result();
	}


	/**
	 * gets user results to a quiz with the passed in array but only if the user matches the array of user ids
	 * @param  int $quiz_id       
	 * @param  array $user_id_array 
	 * @return array                
	 */
	

	public function getUserResults($quiz_id, $user_id_array)
	{
		return $this->db
			->where('quiz_id', $quiz_id)
			->where_in('id', $user_id_array)
			->get('user_quiz')
			->result(); 
	}


	/**
	 * gets user answers to the passed in user quiz id
	 * @param  int $user_quiz_id 
	 * @return array               
	 */
	
	
	public function getUserAnswers($user_quiz_id)
	{
		return $this->db
			->select('answer_id')
			->select('question_id')
			->where('user_quiz_id', $user_quiz_id)
			->join('answers', 'answers.id = user_answer.answer_id')
			->get('user_answer')
			->result();	
	}
}
