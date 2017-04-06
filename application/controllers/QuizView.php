<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class QuizView extends CI_Controller {
    public function index() {
        $this->load->model('Quiz_Model', 'quizModel');

        $this->load->view('header');
        $this->load->view('quizview', [
            'quizzes' => $this->quizModel->get(),
            'teacher' => $this->session->userdata('user_type') == 1
        ]);
        $this->load->view('footer');
    }
}