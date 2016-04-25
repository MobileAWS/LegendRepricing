<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller {

	
	public function index()
	{
			$this->load->view('homepage/inventory-management');
	}
	
}
