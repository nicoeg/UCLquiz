<?php

class Answer_Model extends CI_Model {
    protected $table = 'answers';

    public function getAnswersByQuestionId($question_id)
    {
        $query = $this->db->where('question_id', $question_id)->get($this->table);

        return $query->result();
    }

    public function saveUserAnswers($user_id, $answers, $user_quiz_id) { 
        foreach ($answers as $answer) {
            $this->db->insert('user_answer', [
                'user_id' => $user_id,
                'answer_id' => $answer['answer_id'], 
                'user_quiz_id' => $user_quiz_id 
            ]);
        }
    }
}