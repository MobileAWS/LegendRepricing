<?php

class Themes extends CI_Controller
{  
  public function __construct(){

    parent::__construct();

//    if($this->session->userdata("logged_in")) redirect("content");
  }
 

  public function index()
  {
    $this->load->theme('demo');
   $this->load->view('home11'); 
  
  }
}





