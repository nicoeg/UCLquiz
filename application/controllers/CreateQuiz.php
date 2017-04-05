<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CreateQuiz extends CI_Controller {
    public function index() {
        $this->load->view('header');
        $this->load->view('createquiz');
        $this->load->view('footer');
    }
}