<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher extends CI_Controller {
    public function index() {
        $this->load->model('Quiz_Model', 'quizModel');

        $this->load->view('header', [
            'logged_in' => $this->session->userdata('logged_in'),
            'teacher' => $this->session->userdata('user_type') == 1
        ]);

        $this->load->view('quiz_preview', [
            'quizzes' => $this->quizModel->get(),
        ]);

        $this->load->view('footer');
    }

    public function create() {
        $this->load->view('header', [
            'logged_in' => $this->session->userdata('logged_in')
        ]);
        $this->load->view('quiz_create');
        $this->load->view('footer');
    }
}
