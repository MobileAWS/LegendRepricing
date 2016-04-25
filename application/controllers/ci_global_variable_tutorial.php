<?php
class CI_Global_Variable_Tutorial extends CI_Controller{
  public function __construct() {
    parent::__construct();
  }
  // Load view page
  public function index() {
    $this->load->view('show_global_variables');
  }
}
?>
