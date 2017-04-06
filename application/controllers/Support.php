<?php

class Support extends CI_Controller {
    public function index()
    {
        $this->load->view('header', [
            'logged_in' => $this->session->userdata('logged_in')
        ]);

        $this->load->view('support');

        $this->load->view('footer');
    }
}