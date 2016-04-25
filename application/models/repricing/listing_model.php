<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	

class Listing_model extends CI_Model {

		public function __construct(){

			parent::__construct();

		}
		
		public function getAdminDetails($admin_id){
			
			//return $this->db->get_where('admin', array('id' => $admin_id));
			return $this->db->get_where('user_listings', array('id' => $admin_id));
		}
		
		public function update_admin_username($data2){
			
			$data = array(
						  	'adminname' => $data2['username']
						 );
			$this->db->where('id', $this->session->userdata('admin_id'));
			$this->db->update('admin',$data);
		
			return 1;
		}
		public function update_admin_password($data2){
		
			$data = array(
						  'password '  => md5($data2['new_password'])
						 );
			$this->db->where('id', $this->session->userdata('admin_id'));
			$this->db->update('admin',$data);
		
			return 1;
		}
		public function deleteService($service_id){
			
			$this->db->delete("services",array("service_id" => $service_id));
		}
		public function deleteName($account_id){
			
			$this->db->delete("signup_account",array("account_id" => $account_id));
		}		
		public function getAllServices()
			{
			$this->db->select('*');
			$this->db->from('services');
			$this->db->order_by("service_id", "desc");
			//$this->db->limit($limit, $offset);
			$res = $this->db->get();
			return $res;	   
			}
		public function getAllAccounts($limit,$offset)
			{
			$offset = $offset -1;
			
			$this->db->select('*');
			$this->db->from('signup_account');
			$this->db->order_by("account_id", "desc");
			$this->db->limit($limit, $offset);
			$res = $this->db->get();
			return $res;	   
			}
}
