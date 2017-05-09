<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz_View extends CI_Controller {
    public function index() {
        $this->load->model('Quiz_Model', 'quizModel');

        $this->load->view('header', [
            'logged_in' => $this->session->userdata('logged_in'),
            'teacher' => $this->session->userdata('user_type') == 1
        ]);

         $this->load->view('quizview', [ 
            'quizzes' => $this->quizModel->get(), 
            'quizzes' => $this->quizModel->getCompleted(), 
        ]); 

        $this->load->view('footer');
    }
}