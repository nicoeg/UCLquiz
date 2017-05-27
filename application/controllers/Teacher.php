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
            'role' => $this->session->userdata('user_type')
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

    public function edit($id) {
        $this->load->view('header', [
            'logged_in' => $this->session->userdata('logged_in')
        ]);
        $this->load->view('quiz_create', [
            'quiz_id' => $id
        ]);
        $this->load->view('footer');
    }

    public function results($id) {
        $this->load->view('header', [
            'logged_in' => $this->session->userdata('logged_in')
        ]);
        $this->load->view('quiz_result', [
            'quiz_id' => $id
        ]);
        $this->load->view('footer');
    }

    public function userResults($user_quiz_id) {
        $this->load->view('header', [
            'logged_in' => $this->session->userdata('logged_in')
        ]);
        $this->load->view('quiz_user_result', [
            'user_quiz_id' => $user_quiz_id
        ]);
        $this->load->view('footer');
    }
}
