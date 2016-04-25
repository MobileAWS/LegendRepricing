<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {	

		public function __construct(){

			parent::__construct();

		}
		
		public function getAllUsers($limit,$offset,$order)
			{
			
			if($order == 'default') {$order = 'desc';}

			$offset = $offset -1;
			
			$this->db->select('*');
			$this->db->from('users');
			$this->db->order_by("followers",$order);
			$this->db->limit($limit, $offset);
			$res = $this->db->get();
			return $res;	   
			}
		public function getSpecificUser($username)
			{
			$this->db->select('*');
			$this->db->from('users');
			$this->db->where("username",$username );
			$this->db->order_by("id", "desc");
			$res = $this->db->get();
			return $res;	   
			}

		public function getAllLinks($limit,$offset,$user_id)
			{
			$offset = $offset -1;
			//$this->db->distinct()  link.user_id,link.create_date,users.username;
			$this->db->select('link.link_url,link.user_id,link.id,users.username,link.create_date');
			$this->db->from('link');
			$this->db->join('users', 'users.user_id = link.user_id');
			$this->db->where("link.user_id",$user_id );
			$this->db->order_by("link.create_date", "desc");
			$this->db->limit($limit, $offset);
			$res = $this->db->get();
			//d($res->result(),1);
			return $res;
			}				
		public function getAllLinkByservice($limit,$offset,$user_id,$service_id)
			{
			$offset = $offset -1;
			
			$this->db->select('link.link_url,link.user_id,link.id,users.username,link.create_date');
			$this->db->from('link');
			$this->db->join('users', 'users.user_id = link.user_id');
			$this->db->where("link.user_id",$user_id );
			$this->db->where("link.service_id",$service_id );
			$this->db->order_by("link.create_date", "desc");
			$this->db->limit($limit, $offset);
			$res = $this->db->get();
			return $res;	   
			}		
		public function newUser($data){

			return $this->db->insert("users",$data);	

		}
		
		public function updateUser($data,$userid){
			
			return $this->db->update("users",$data,array("id" => $userid));	  

		}
				
		public function deleteUser($userid){
			$this->db->delete("users",array("user_id" => $userid));

		}
		public function deleteLink($id){
			//d($userid,1);
			$this->db->delete("link",array("id" => $id));

		}
		public function getUserDetails($userid){

		    return $query = $this->db->get_where('users',array('id' => $userid));

		    //return $query->row();

	    }
		
		public function getUserStats($userid){

		     $date_stop = time();
			 $date_start = time()-60*60*24*7;
			 
			 //echo "create_date between $date_start and $date_stop";exit;
			// return $query = $this->db->get_where('user_stats',array('user_id' => $userid));
			 $this->db->select("tweet_id");
			 $this->db->from("user_stats");
			 $this->db->where("create_date between $date_start and $date_stop"); 
			 $this->db->where("user_id",$userid);  
			 $query = $this->db->get();
		     //d($query->result(),1);
			 return $query;
	    }
		public function getUserMention($userid){
		     $date_stop = time();
			 $date_start = time()-60*60*24*7;
			 
			 //echo "create_date between $date_start and $date_stop";exit;
			// return $query = $this->db->get_where('user_stats',array('user_id' => $userid));
			 $this->db->select("mention_id");
			 $this->db->from("user_mention");
			 $this->db->where("create_date between $date_start and $date_stop"); 
			 $this->db->where("user_id",$userid);  
			 $query = $this->db->get();
		     //d($query->result());
			 return $query;
	    }
		public function getUserRetweet($userid){

			 $date_stop = time();
			 $date_start = time()-60*60*24*7;
			 $this->db->select("retweet_id");
			 $this->db->from("user_retweet");
			 $this->db->where("create_date between $date_start and $date_stop"); 
			 $this->db->where("user_id",$userid);  
			 $query = $this->db->get();
		     //d($query->result());
			 return $query;
	    }
		public function getUserFollow($userid){

		     $date_stop = strtotime(date("Y-m-d",time()));
			 
			 $date_start = strtotime(date("Y-m-d",(time()-60*60*24*7)));
			 
			 //echo "create_date between $date_start and $date_stop";exit;
			// return $query = $this->db->get_where('user_stats',array('user_id' => $userid));
			//echo "sum(new_follower) as follow_diff,sum(new_following) as following_diff from user_follower where entry_date between $date_start and $date_stop";exit;
		 	 //$this->db->select(''); 
			 $this->db->select("sum(new_follower) as follower_count,sum(new_following) as following_count");
			 $this->db->from("user_follower");
			 $this->db->where("entry_date between $date_start and $date_stop");  
			 $this->db->where("user_id",$userid);
			 $query = $this->db->get();
		     //d($query->result(),1);
			 return $query;
	    }
		
		public function user_details($data){

		    $query = $this->db->get_where('users',array('username' => trim($data['username']),'password' => md5($data['password'])));
			
			if($query->num_rows == 0)
			{
		    return 0;
			}
			else{
				return $query->row_array();
			}

	    }
		
		public function getUserAccount($userid){
			return $qry = $this->db->get_where('accounts',array('userid' => $userid));
		}
		public function getUserStatsinfo($userid){
		
			$this->db->select("tweet_7_day,tweet_7_mention,day_7_retweet,follower_7_day,avg_tweet_per_day,avg_mention_per_day,avg_retweet_per_day,avg_follower_per_day,follower_growth_rate,follower_to_following");
			$this->db->from("users");
			$this->db->where("user_id",$userid);
			$query = $this->db->get();
			return $query;

		}
		
		public function total_users(){

			$query = $this->db->get('users');

		    return $query->num_rows();   

		}	
		
		public function get_ip()
		{
			$this->db->select_max('logid');
			$qry = $this->db->get('admin_logs');
			
			foreach($qry->result() as $ret)
			{
				$logid = $ret->logid;
	
			}
			$log_id = $logid - 1;
			
			$this->db->select('*');
			$res = $this->db->get_where('admin_logs', array('logid' => $log_id));
			
			return $res;
		}
		
		public function get_adminUser($adminid){
		
			$this->db->select('adminname');
			$qry = $this->db->get_where('admin', array('admin_id' => $adminid));
			foreach($qry->result() as $ret)
			{
				$adminname = $ret->adminname;
			}
			return $adminname;
		}
		
		public function check_status(){

		    $query = $this->db->get_where('users',array('username' => trim($_POST['username']),'password' => md5($_POST['password'])));

		    return $query->num_rows();

	    }
		
		public function getCredit_points($userid){
		
			$this->db->select('credit_points');
			$qry = $this->db->get_where('users', array('userid' => $userid));
			$result=$qry->result();
			return $result[0]->credit_points;
			
		}
		
		public function insertSkip($data){

			return $this->db->insert("skip_accounts",$data);	

		}
		
		public function getIdfromName($account){
			//d($account,1);
			$qry = $this->db->get_where('accounts', array('acc_id' => $account));
			$result=$qry->result();
			return $result[0]->userid;

		}
		
		public function checkDupFollower($mimic,$acc_name){

			$qry = $this->db->get_where('credit_history', array('mimic' => $mimic,'acc_name' => $acc_name));
			return $qry->num_rows();

		}
		
		public function getAllUserEmail(){

			$this->db->select('username,email');
			$this->db->from('users');
			$this->db->where('status','Active');
			$this->db->where('email != ""');
			$query = $this->db->get();
			
			return $query->result();

		}
		
		public function count_suspend_user()
		{
			$qry = $this->db->get_where("users",array("status" => "Suspend"));
			return $qry->num_rows();
		}
		public function getSuspendUsers($limit,$offset){

			$offset = $offset -1;
			$this->db->order_by("userid", "desc");
			$res = $this->db->get_where('users',array("status" => "Suspend"),$limit,$offset);
			
			return $res;	   

		}
		public function unsuspendUser($id)
		{
			$this->db->update("users",array("status" => "Active"),array("userid" => $id));
			$this->db->update("accounts",array("status" => "Active"),array("userid" => $id));
		}
		
		
		public function count_featured_user()
		{
			$qry = $this->db->get_where("users",array("isFeatured" => "Yes"));
			return $qry->num_rows();
		}
		
		public function getFeaturedUsers($limit,$offset){

			$offset = $offset -1;
			$this->db->order_by("userid", "desc");
			$res = $this->db->get_where('users',array("isFeatured" => "Yes"),$limit,$offset);
			
			return $res;	   

		}
		public function getAllAccount($userid){
			
			
			$qry = $this->db->query("SELECT account_id FROM follow_list WHERE user_id = $userid");
			
			if($qry->num_rows())
				$account_id = ' where account_id NOT IN ('.join(",",GetObjectColumn($qry->result(),"account_id")).')';
			else $account_id= '';

			$res = $this->db->query("select * from signup_account ".$account_id." ORDER BY account_id desc");
		
			return $res;  

		}
}