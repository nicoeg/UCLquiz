<?php

class Answer_Model extends CI_Model 
{


    /**
     * get whole answer table where question id is equal to the passed id
     * @param  int $question_id 
     * @return array              array with table rows as objects
     */
    

    public function getAnswersByQuestionId($question_id)
    {
        return $this->db
            ->where('question_id', $question_id)
            ->get('answers')
            ->result();
    }


    /**
     * saves user answers from a whole quiz
     * @param  int $user_id      
     * @param  array $answers      
     * @param  int $user_quiz_id 
     * @return bool               
     */
    
    
    public function saveUserAnswers($user_id, $answers, $user_quiz_id) 
    {
        foreach ($answers as $answer) 
        {
            $this->db->insert('user_answer', [
                'user_id' => $user_id,
                'answer_id' => $answer['answer_id'], 
                'user_quiz_id' => $user_quiz_id 
            ]);
        }

        return true;
    }
}
