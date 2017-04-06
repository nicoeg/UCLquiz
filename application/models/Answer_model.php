<?php

class Answer_Model extends CI_Model {
    protected $table = 'answers';

    public function getAnswersByQuestionId($question_id)
    {
        $query = $this->db->where('question_id', $question_id)->get($this->table);

        return $query->result();
    }
}