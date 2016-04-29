<?php
  

class Myerrors extends CI_Controller
{   
  private $data = array();
  public function __construct(){

		parent::__construct();
		
	}
public function page_missing()
{


//    $this->load->view('homepage/nav',$data);
  //  $this->load->view('homepage/header',$data);
    $this->load->view('404',$this->data);
  //echo "<strong>whoops ...to do needs to add the page we can us this for testing as well </strong>";
}
  public function index()
  {
    
    $this->load->view('errorpage',$this->data);

  }
}

