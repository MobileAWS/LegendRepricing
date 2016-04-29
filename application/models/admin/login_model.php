<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	

class Login_model extends CI_Model {

		

		public function __construct(){

			parent::__construct();

		}

		public function admin_check(){

		    $query = $this->db->get_where('admin',array('adminname' => trim($_POST['username']),'password' => md5($_POST['password'])));

		    return $query->num_rows();

	    }

		public function admin_details($data2){

		    $query = $this->db->get_where('admin',array('adminname' => trim($data2['username']),'password' => md5($data2['password'])));
			//echo "<pre>"; print_r($query);exit;
			if($query->num_rows == 0)
			{
		    return 0;
			}
			else{
				return $query->row_array();
			}

	    }

		public function admin_logs_insert($data){

		    return $this->db->insert("admin_logs",$data);	

	    }
		
		public function branch_check(){

		    $query = $this->db->get_where('agents', array('agent_username' => trim($_POST['username']), 'agent_password' => md5($_POST['password'])));

		    return $query->num_rows();

	    }

		public function branch_details(){

		    $query = $this->db->get_where('agents', array('agent_username' => trim($_POST['username']), 'agent_password' => md5($_POST['password'])));

		    return $query->row_array();

	    }

		public function branch_logs_insert($data){

		    return $this->db->insert("branch_logs",$data);	

	    }				

}