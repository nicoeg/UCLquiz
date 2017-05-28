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


    /**
     * Edit a single quiz
     * @param  int $id Quiz id
     * @return bool     Returns true on success
     */
    

    public function edit($id) {
        if(is_numeric($id))
        {
            $safeId = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

            $this->load->view('header', [
                'logged_in' => $this->session->userdata('logged_in')
            ]);
            $this->load->view('quiz_create', [
                'quiz_id' => $safeId
            ]);
            $this->load->view('footer');

            return true;
        }

        return false;
    }


    /**
     * Shows all results for a quiz
     * @param  int $id quiz id
     * @return bool     Returns true on success
     */
    

    public function results($id) {
        if(is_numeric($id))
        {
            $safeId = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

            $this->load->view('header', [
                'logged_in' => $this->session->userdata('logged_in')
            ]);
            $this->load->view('quiz_result', [
                'quiz_id' => $safeId
            ]);
            $this->load->view('footer');

            return true;
        }

        return false;
    }


    /**
     * Show results for one quiz
     * @param  int $user_quiz_id User quiz id
     * @return bool               Returns true on success
     */
    

    public function userResults($user_quiz_id) {
        if(is_numeric($user_quiz_id))
        {
            $safeId = filter_var($user_quiz_id, FILTER_SANITIZE_NUMBER_INT);

            $this->load->view('header', [
                'logged_in' => $this->session->userdata('logged_in')
            ]);
            $this->load->view('quiz_user_result', [
                'user_quiz_id' => $safeId
            ]);
            $this->load->view('footer');

            return true;
        }

        return false;
    }
}
