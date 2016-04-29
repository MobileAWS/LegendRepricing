<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends CI_Controller {

private $data=array();
	public function index()
	{
		$this->data['title'] = 'About';
		$this->load->view('homepage/about',$this->data);
	}
}
