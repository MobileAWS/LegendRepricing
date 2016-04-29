<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	

    class Common extends CI_Model {

		

		public function __construct(){

			parent::__construct();

		}

		public function getAllBranches(){

				   
                        echo "eft";
				   

		}

		public function newBranch()

		{	

		}

		

		public function updateBranch(){	   

		  

		}

		

		public function deleteBranch(){

		   

		}

		public function getCountryList(){

		    $query = $this->db->get('country');

		    return $query->result();

		}				

    }
