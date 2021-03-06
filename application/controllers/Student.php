<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends CI_Controller {

    public function _remap($method, $params = [])
    {
        if (is_numeric($method)) {
            return call_user_func_array(array($this, 'quiz'), [$method]);
        }else if (method_exists($this, $method))
        {
            return call_user_func_array(array($this, $method), $params);
        }

        show_404();
    }

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


    /**
     * Show a single quiz
     * @param  int $id Id of quiz
     * @return bool     Returns true on success
     */
    public function quiz($id)
    {
        if(is_numeric($id))
        {
            $safeId = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

            $this->load->view('header', [
                'logged_in' => $this->session->userdata('logged_in')
            ]);

            $this->load->view('quiz_show', [
                'quizId' => $safeId
            ]);
            
            $this->load->view('footer');

            return true;
        }

        return false;
    }
}
