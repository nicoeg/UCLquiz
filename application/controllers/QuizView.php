<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class QuizView extends CI_Controller {
    public function index() {
        $this->load->view('header');
        $this->load->view('quizview');
        $this->load->view('footer');
    }
}