<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CreateQuiz extends CI_Controller {
    public function index() {
        $this->load->view('header', [
            'logged_in' => $this->session->userdata('logged_in')
        ]);
        $this->load->view('createquiz');
        $this->load->view('footer');
    }
}