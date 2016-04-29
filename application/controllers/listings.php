<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Listings extends CI_Controller {

    public function __construct() {

        parent::__construct();

        $this->load->library('pagination');
        $this->load->library("form_validation");

        if (!$this->session->userdata("logged_in"))
            redirect("home");
    }

    public function index() {
        $this->load->view('listings/main');
    }

}
