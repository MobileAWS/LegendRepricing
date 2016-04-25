<?php 
//ini_set("display_errors", "1");
//error_reporting(E_ALL);
class Deck extends CI_Controller 
{
	private $_consumer_key = 'VR3TGLufZQhpkXqNqPaObPMTm';
    private $_consumer_secret = '30qAzpr1u4Z5f28P7mnLcmyUMnVYXl4Hku86o61RgYgVuN1kJu';
	private $db_b;

	public function __construct(){

		parent::__construct();
		$this->load->library("form_validation");
		if(!$this->session->userdata("deck_id")) redirect("main");
		$this->load->library('twitter');
		$this->db_b = $this->load->database('master', TRUE); 

	}


	public function index(){
			
      $testflag=false;
			//echo date("jS m Y H:i a",time());exit;
			if($this->session->userdata("deck_id"))
				{
          // we can set the consumebr keys OK

				$user_exits = $this->db->get_where("deck_user",array("deck_id"=>$this->session->userdata("deck_id")));
				if($user_exits->num_rows() <1)
					{
						$this->session->sess_destroy();
						$this->session->unset_userdata('deck_id');
						redirect("main");
					}
          else
          {
            foreach($user_exits->result() as $row)
            {

              $this->_consumer_secret=$row->consumer_secret_key;

              $this->_consumer_key=$row->consumer_key;
              $testflag=true;

              break;



            }


          }
				}

			if($_POST)
			{
			
			$checkbox = $_POST['checkbox'];

			$count = count($checkbox);

		   /*if($_POST['schedule_id']) {

					$sch = explode("\n", $_POST['schedule_id']);
				
					for($j=0;$j < count($sch);$j++)
					{
						for($i=0; $i<$count; $i++)
						{
							//echo $checkbox[$i];
							$active_account = $this->db->query("select user_id,username,consumer_key,consumer_secret_key from accounts where user_id = ".$checkbox[$i]." and status = 'active' ")->row_array();
							
							/*$this->twitter->TwitterOAuth($this->_consumer_key, $this->_consumer_secret, $active_account['consumer_key'] ,$active_account['consumer_secret_key'] );
							$res = $this->twitter->post("statuses/retweet/$retweet_id");*/
							//d($res->errors[0]->message,1);
							
							/*if(!$res->errors)
							{

								$array2 = array();
								$array2['deck_id'] 		= $this->session->userdata("deck_id");
								$array2['user_id'] 		= $checkbox[$i];
								$array2['rt_id'] 		= $sch[$j];
								$array2['delete_time']  = ($_POST['af_time']*60);
								$array2['create_time']  = time();
								
								//d($array2);
								$this->db->insert("schedule",$array2);
								
							}
							else
							{

								$array2 = array();
								$array2['deck_id'] 		= $this->session->userdata("deck_id");
								$array2['user_id'] 		= $checkbox[$i];
								$array2['screen_name'] 	= '@'.$active_account['username'];
								$array2['retweet_id'] 	= $_POST['retweet_id'];
								$array2['action'] 		= 'RT';
								$array2['create_date']  = time();
								$array2['error_code']  	= 0;
								$array2['error_message']= "Rt limit exceeded";
								$array2['ip']  			= $this->session->userdata('ip_address');
								
								$this->db->insert("error_log",$array2);
 
							}
							
						 }
					
				    }
				
				   
				}*/
			if($_POST['minutos']) {
					
	$array = array();
		
		$time =$this->db->query("Select autounret_time from settings LIMIT 1")->row_array();
		
		$unretweet_time = $time['autounret_time']?$time['autounret_time']:5;
		$unretweet_time = $unretweet_time*60;
		$minutos = $_POST['minutos'];
		$minutos = $minutos*60;
		$present_time = time();
		$current_time = time();
		$limit_time = $current_time-$minutos;
				
		$qry =$this->db->query("Select * from message_log where action = 'RT' and create_date > $limit_time and  $present_time >= create_date + $unretweet_time  ORDER BY deck_id DESC ");
		

		if($qry->num_rows>0 )
		{	
			foreach($qry->result() as $row)
			{	
					
					/*d($row);*/
					$users = $this->db->get_where("accounts",array("user_id"=>$row->user_id))->row_array();

        $checks1= $this->db->get_where("deck_user",array("deck_id"=>$users["deck_id"]))->row_array(); 
					$this->twitter->TwitterOAuth($checks1["consumer_key"], $checks1["consumer_secret_key"], $users['consumer_key'] , $users['consumer_secret_key']);
					$res = $this->twitter->post("https://api.twitter.com/1.1/statuses/destroy/".$row->tweet_id.".json");
					
					
					/*d($res); */
					
					if(!$res->errors)
					{						
						
						$this->db->update("message_log",array("action"=>'unRT'),array("msg_id"=>$row->msg_id));
					}
			}
		}
				    
					}
		    if($_POST['retweet_id']) {
					
					
					$retweet_id = $_POST['retweet_id'];
          ///for sendng too views file 
          
					$mm = $this->db->get_where('deck_user',array("deck_id"=> $this->session->userdata("deck_id")))->row_array();

					$minutes = date("i");
					$start_time   = time()-$minutes*60;
					$end_time   = time()-$minutes*60+3600;
					
					$did = $this->session->userdata("deck_id");
					$qres = $this->db->query("select count(DISTINCT retweet_id) as total from message_log where (create_date >= $start_time and create_date <= $end_time) and action='RT'  and deck_id=$did");
					
					$qres = $qres->row_array();

					$sett = $this->db->query("select * from settings limit 0,1");
					$sett = $sett->row_array();

					//echo $qres['total'];die();

					if($sett['retweet_limit'] > $qres['total'] || $mm['type'] == 'superadmin')
					{
						for($i=0; $i<$count; $i++)
						{
							$active_account = $this->db->query("select deck_id,user_id,username,consumer_key,consumer_secret_key from accounts where user_id = ".$checkbox[$i]." and status = 'active' ")->row_array();
							
        $checks1= $this->db->get_where("deck_user",array("deck_id"=>$active_account["deck_id"]))->row_array(); 
							$this->twitter->TwitterOAuth($checks1["consumer_key"], $checks1["consumer_secret_key"], $active_account['consumer_key'] ,$active_account['consumer_secret_key'] );
							$res = $this->twitter->post("statuses/retweet/$retweet_id");
							//d($res->errors[0]->message,1);
							
							if(!$res->errors)
							{
								$array2 = array();
								$array2['deck_id'] 		= $this->session->userdata("deck_id");
								$array2['user_id'] 		= $active_account['user_id'];
								$array2['tweet_id'] 	= $res->id_str;
								$array2['retweet_id'] 	= $_POST['retweet_id'];
								$array2['action'] 		= 'RT';
								$array2['create_date']  = time();
								$array2['ip']  			= $this->session->userdata('ip_address');
                $data["mysendstatus"][]=$active_account["user_id"].":"."green";
								
								$this->db->insert("message_log",$array2);
								
								$users = $this->db->query("select * from error_log where deck_id =".$this->session->userdata("deck_id")." and user_id = ".$active_account['user_id']);
								if($users->num_rows()>0)
									$this->db->delete('error_log', array('user_id' => $active_account['user_id'])); 
							}
							else
							{
								$array2 = array();
								$array2['deck_id'] 		= $this->session->userdata("deck_id");
								$array2['user_id'] 		= $active_account['user_id'];
								$array2['screen_name'] 	= '@'.$active_account['username'];
								$array2['retweet_id'] 	= $_POST['retweet_id'];
								$array2['action'] 		= 'RT';
								$array2['create_date']  = time();
								$array2['error_code']  	= $res->errors[0]->code;
								$array2['error_message']= $res->errors[0]->message;
								$array2['ip']  			= $this->session->userdata('ip_address');
								
                $data["mysendstatus"][]=$active_account["user_id"].":"."red";
								$this->db->insert("error_log",$array2);

							}
							
							}
					}
				    
					}
			if($_POST['favorite_id'])
					{
						for($i=0; $i<$count; $i++)
						{
						$active_account = $this->db->query("select deck_id,user_id,username,consumer_key,consumer_secret_key from accounts where user_id = ".$checkbox[$i]." and status = 'active' ")->row_array();
						
        $checks1= $this->db->get_where("deck_user",array("deck_id"=>$active_account["deck_id"]))->row_array(); 
						$this->twitter->TwitterOAuth($checks1["consumer_key"], $checks1["consumer_secret_key"], $active_account['consumer_key'] ,$active_account['consumer_secret_key'] );
						$res = $this->twitter->post("favorites/create", array("id" => $_POST['favorite_id']));

						
						//d($res,1);	
						
						if(!$res->errors)
						{
							$array2 = array();
							$array2['deck_id'] 		= $this->session->userdata("deck_id");
							$array2['user_id'] 		= $active_account['user_id'];
							$array2['favorite_id'] 	= $_POST['favorite_id'];
							$array2['action'] 		= 'FAV';
							$array2['create_date']  = time();
							$array2['ip']  = $this->session->userdata('ip_address');
							
							$this->db->insert("message_log",$array2);

							$users = $this->db->query("select * from error_log where deck_id =".$this->session->userdata("deck_id")." and user_id = ".$active_account['user_id']);
							if($users->num_rows()>0)
								$this->db->delete('error_log', array('user_id' => $active_account['user_id'])); 

						}
						else
						{
							$array2 = array();
							$array2['deck_id'] 		= $this->session->userdata("deck_id");
							$array2['user_id'] 		= $active_account['user_id'];
							$array2['screen_name'] 	= '@'.$active_account['username'];
							$array2['favorite_id'] 	= $_POST['favorite_id'];
							$array2['action'] 		= 'FAV';
							$array2['create_date']  = time();
							$array2['error_code']  	= $res->errors[0]->code;
							$array2['error_message']= $res->errors[0]->message;
							$array2['ip']  			= $this->session->userdata('ip_address');
							
							$this->db->insert("error_log",$array2);

						}

			
						}
		
				    }

			if($_POST['undo_retweet_id']) {
					
					
						$retweet_id = $_POST['undo_retweet_id'];					
						
						for($i=0; $i<$count; $i++)
						{
						$active_account = $this->db->query("select deck_id,user_id,username,consumer_key,consumer_secret_key, (select tweet_id from message_log where user_id = ".$checkbox[$i]." and retweet_id = $retweet_id and action='RT' ORDER BY msg_id DESC LIMIT 1) as tweet_id from accounts where user_id = ".$checkbox[$i]." and status = 'active' ")->row_array();

						
						if($active_account['tweet_id'])
						{
        $checks1= $this->db->get_where("deck_user",array("deck_id"=>$active_account["deck_id"]))->row_array(); 
						$this->twitter->TwitterOAuth($checks1["consumer_key"], $checks1["consumer_secret_key"], $active_account['consumer_key'] ,$active_account['consumer_secret_key'] );
						$res = $this->twitter->post("https://api.twitter.com/1.1/statuses/destroy/".$active_account['tweet_id'].".json");
						
						if(!$res->errors)
						{
							//$this->db->delete("message_log",array("tweet_id"=>$active_account['tweet_id']));
							
							$array2 = array();
							$array2['deck_id'] 		= $this->session->userdata("deck_id");
							$array2['user_id'] 		= $active_account['user_id'];
							$array2['retweet_id'] 	=  $_POST['undo_retweet_id'];
							
							$array2['action'] 		= 'unRT';
							$array2['create_date']  = time();
							$array2['ip']  = $this->session->userdata('ip_address');
							
							$this->db->insert("message_log",$array2);
							
							$users = $this->db->query("select * from error_log where deck_id =".$this->session->userdata("deck_id")." and user_id = ".$active_account['user_id']);
							if($users->num_rows()>0)
								$this->db->delete('error_log', array('user_id' => $active_account['user_id'])); 

						}
						else
						{
							$array2 = array();
							$array2['deck_id'] 		= $this->session->userdata("deck_id");
							$array2['user_id'] 		= $active_account['user_id'];
							$array2['screen_name'] 	= '@'.$active_account['username'];
							$array2['retweet_id'] 	= $_POST['undo_retweet_id'];
							$array2['action'] 		= 'unRT';
							$array2['create_date']  = time();
							$array2['error_code']  	= $res->errors[0]->code;
							$array2['error_message']= $res->errors[0]->message;
							$array2['ip']  			= $this->session->userdata('ip_address');
							
							$this->db->insert("error_log",$array2);

						}

						}
						
						}
		
				    
					}
			if($_POST['undo_favorite_id'])
					{
						for($i=0; $i<$count; $i++)
						{
						$active_account = $this->db->query("select deck_id,user_id,username,consumer_key,consumer_secret_key from accounts where user_id = ".$checkbox[$i]." and status = 'active' ")->row_array();
						
        $checks1= $this->db->get_where("deck_user",array("deck_id"=>$active_account["deck_id"]))->row_array(); 
						$this->twitter->TwitterOAuth($checks1["consumer_key"], $checks1["consumer_secret_key"], $active_account['consumer_key'] ,$active_account['consumer_secret_key'] );
						$res = $this->twitter->post("favorites/destroy", array("id" => $_POST['undo_favorite_id']));

						
						if($this->chk_rt_limit_return($this->session->userdata("deck_id")))
						{
							$array2 = array();
							$array2['deck_id'] 		= $this->session->userdata("deck_id");
							$array2['user_id'] 		= $active_account['user_id'];
							$array2['favorite_id'] 	= $_POST['undo_favorite_id'];
							$array2['action'] 		= 'unFAV';
							$array2['create_date']  = time();
							$array2['ip']  = $this->session->userdata('ip_address');
							
							$this->db->insert("message_log",$array2);

							$users = $this->db->query("select * from error_log where deck_id =".$this->session->userdata("deck_id")." and user_id = ".$active_account['user_id']);
							if($users->num_rows()>0)
								$this->db->delete('error_log', array('user_id' => $active_account['user_id'])); 

						}
						else
						{
							$array2 = array();
							$array2['deck_id'] 		= $this->session->userdata("deck_id");
							$array2['user_id'] 		= $active_account['user_id'];
							$array2['screen_name'] 	= '@'.$active_account['username'];
							$array2['favorite_id'] 	= $_POST['undo_favorite_id'];
							$array2['action'] 		= 'unFAV';
							$array2['create_date']  = time();
							$array2['error_code']  	= 0;
							$array2['error_message']= "RT limit exceed";
							$array2['ip']  			= $this->session->userdata('ip_address');
							
							$this->db->insert("error_log",$array2);

						}

						}
		
				    }


			}
			
			$data['title'] = 'The deck Information';
			
			$data['user_info'] = $this->db->get_where("deck_user",array("deck_id"=>$this->session->userdata("deck_id")))->row_array();
			
			$data['setting_info'] = $this->db->get_where("settings")->row_array();

			$data['schedule_info'] = $this->db->get_where('schedule', array("deck_id"=>$this->session->userdata("deck_id")));

	 // 	$data['deck_accounts'] = $this->db->query("select *, (select name from deck_user where deck_user.deck_id = accounts.deck_id) as user_name from accounts where accounts.deck_id=".$this->session->userdata("deck_id")." order by account_id desc");
	  	$data['deck_accounts'] = $this->db->query("select *, (select name from deck_user where deck_user.deck_id = accounts.deck_id) as user_name from accounts order by account_id desc");
			
			//d($data['deck_accounts']->result(),1);
			
			$data['log_history'] = $this->db->query("select *, (select name from deck_user where deck_user.deck_id = message_log.deck_id) as user_name from message_log group by  action , retweet_id, favorite_id ORDER BY msg_id desc");
			
			$data['alternative_accounts'] = $this->db->query("select * , (select name from deck_user where deck_user.deck_id = user_accounts.deck_id) as name from user_accounts order by acc_id desc");

			$inactive_accounts = $this->db->query("select * from error_log where deck_id =".$this->session->userdata("deck_id")." group by user_id ");

			
			$screen_names = GetObjectColumn($inactive_accounts->result(),'screen_name');
			
			$data['inactive_accounts'] = (!empty($screen_names)) ? implode(',',$screen_names) : 0;
			
			$this->load->view('deck2',$data);
		}	
	public function chk_rt_limit_return($deck_id)
	{
		$mm = $this->db->get_where('deck_user',array("deck_id"=> $this->session->userdata("deck_id")))->row_array();
				
		$minutes = date("i");
		$start_time   = time()-$minutes*60;
		$end_time   = time()-$minutes*60+3600;
		
		$did = $deck_id;
		$qres = $this->db->query("select count(DISTINCT retweet_id) as total from message_log where (create_date >= $start_time and create_date <= $end_time) and action='RT'  and deck_id=$did");
		
		$qres = $qres->row_array();

		$sett = $this->db->query("select * from settings limit 0,1");
		$sett = $sett->row_array();

		if($sett['retweet_limit'] > $qres['total'] || $mm['type'] == 'superadmin')
		{
			return true;
		}
		else return false;
		
	}	

	public function chk_rt_limit()
	{
		$retweet_id = $_POST['retweet_id'];
		$mm = $this->db->get_where('deck_user',array("deck_id"=> $this->session->userdata("deck_id")))->row_array();

		$minutes = date("i");
		$start_time   = time()-$minutes*60;
		$end_time   = time()-$minutes*60+3600;
		
		$did = $this->session->userdata("deck_id");
		$qres = $this->db->query("select count( DISTINCT retweet_id) as total from message_log where (create_date >= $start_time and create_date <= $end_time) and action='RT'  and deck_id=$did");
		$qres = $qres->row_array();

		$sett = $this->db->query("select * from settings limit 0,1");
		$sett = $sett->row_array();

		if($sett['retweet_limit'] > $qres['total'] || $mm['type'] == 'superadmin')
		{
			echo "yes";
		}
		else echo "no";
		
	}
	/*public function deletespam()
	{
	$array = array();
		
		$time =$this->db->query("Select autounret_time from settings LIMIT 1")->row_array();
		
		$unretweet_time = $time['autounret_time']?$time['autounret_time']:5;
		$unretweet_time = $unretweet_time*60;
		$minutos = $_POST['minutos'];
		$minutos = $minutos*60;
		$present_time = time();
		$current_time = time();
		$limit_time = $current_time-$minutos;
				
		$qry =$this->db->query("Select * from message_log where action = 'RT' and create_date > $limit_time and  $present_time >= create_date + $unretweet_time  ORDER BY deck_id DESC ");
		

		if($qry->num_rows>0 )
		{	
			foreach($qry->result() as $row)
			{	
					
					d($row);
					$users = $this->db->get_where("accounts",array("user_id"=>$row->user_id))->row_array();

					$this->twitter->TwitterOAuth($this->_consumer_key, $this->_consumer_secret, $users['consumer_key'] , $users['consumer_secret_key']);
					$res = $this->twitter->post("https://api.twitter.com/1.1/statuses/destroy/".$row->tweet_id.".json");
					
					
					d($res);
					
					if(!$res->errors)
					{						
						
						$this->db->update("message_log",array("action"=>'unRT'),array("msg_id"=>$row->msg_id));
					}
			}
		}
			$data['title'] = 'The deck Information';
			
			$data['user_info'] = $this->db->get_where("deck_user",array("deck_id"=>$this->session->userdata("deck_id")))->row_array();
			
			$data['setting_info'] = $this->db->get_where("settings")->row_array();

			$data['deck_accounts'] = $this->db->query("select *, (select username from deck_user where deck_user.deck_id = accounts.deck_id) as user_name from accounts order by account_id desc");
			
			//d($data['deck_accounts']->result(),1);
			
			$data['log_history'] = $this->db->query("select *, (select name from deck_user where deck_user.deck_id = message_log.deck_id) as user_name from message_log order by msg_id desc");
			
			$data['alternative_accounts'] = $this->db->query("select * , (select name from deck_user where deck_user.deck_id = user_accounts.deck_id) as name from user_accounts order by acc_id desc");

			//d($data['alternative_accounts']->result(),1);

			$this->load->view('deck2',$data);
	}*/
 public function save_schtime()
{
		$schedule_status = $_POST['data'];
    // match teh
		$this->db->update("deck_user",array('schedule_time'=> $schedule_status), array('deck_id' => $this->session->userdata("deck_id")));
    echo "ok";
}    
public function save_schtype()
{
		$schedule_status = $_POST['data'];
    // match teh
		$this->db->update("deck_user",array('schedule_type'=> $schedule_status), array('deck_id' => $this->session->userdata("deck_id")));
    echo "ok";
}
  public function save_schoption()
  {

		$schedule_status = $_POST['data'];
    // match teh
		$this->db->update("deck_user",array('schedule_option'=> $schedule_status), array('deck_id' => $this->session->userdata("deck_id")));
    echo "ok";

  }
	public function sv_schedule()
	{
	
		$schedule_status = $_POST['schedule_status'];
		
		$schedule_ids 	 = explode("\n", $_POST['schedule_id']);
		
		$this->db->update("deck_user",array('schedule_status'=> $schedule_status, 'schedule_time'=> $_POST['af_time'] ), array('deck_id' => $this->session->userdata("deck_id")));

		$gsch = $this->db->delete("schedule", array("deck_id"=> $this->session->userdata("deck_id")));


		if(count($schedule_ids) > 0 )
		{
			foreach($schedule_ids as $tweet_id)
			{
				if($tweet_id) 
				{
					
							$array2 = array();
							$array2['deck_id'] 		= $this->session->userdata("deck_id");
							//$array2['user_id'] 		= $row->user_id;
							$array2['rt_id'] 		= $tweet_id;
										
							$this->db->insert("schedule",$array2);
				}
			}
			 echo "yes";
		}
		else echo "no";	
		
	   
				
	}

	public function delete() 
	{
 
	   $deck_user = $this->db->get_where("user_accounts",array("acc_id"=>$this->uri->segment(3)))->row_array();
	   
	   if($deck_user['deck_id'])
	   {
			$this->db->delete("deck_user",array("deck_id"=>$deck_user['deck_id']));
			$this->db->delete("schedule",array("deck_id"=>$deck_user['deck_id']));
	   }
	
	   $this->db->delete("user_accounts",array("acc_id"=>$this->uri->segment(3)));
	   
	   redirect('deck');
 
    }

	public function deletemultiUsers() 
	{
		
		foreach($_POST['data'] as $row)
		{
 
		   $deck_user = $this->db->get_where("user_accounts",array("acc_id"=>$row))->row_array();
		   
		   if($deck_user['deck_id'])
		   {
				$this->db->delete("deck_user",array("deck_id"=>$deck_user['deck_id']));
				$this->db->delete("schedule",array("deck_id"=>$deck_user['deck_id']));
		   }
		
		   $this->db->delete("user_accounts",array("acc_id"=>$row));
	   
	   }
	   		$this->session->set_userdata(array('success'=>'Usuario(s) ELMINADOS(s) exitosamente!'));
			echo 1;exit;

 
    }
	
	public function deleteaccount() 
	{
		
			
			$this->db->delete("accounts",array("account_id"=>$this->uri->segment(3)));
			
			redirect('deck');
	
    }    
    public function verifycredentials() 
	{
		$res=array() ;
		foreach($_POST['data'] as $row)
		{
			$checks= $this->db->get_where("accounts",array("user_id"=>$row))->row_array(); 
			if($checks)
			{
				$checks1= $this->db->get_where("deck_user",array("deck_id"=>$checks["deck_id"]))->row_array(); 
				if($checks1)
				{
				$this->twitter->TwitterOAuth($checks1["consumer_key"], $checks1["consumer_secret_key"], $checks["consumer_key"] , $checks["consumer_secret_key"]);
				$checks2 = $this->twitter->get('https://api.twitter.com/1.1/account/verify_credentials.json','');
				if($checks2->id)
					$res[]="green";
				else
					$res[]="yellow";
				}
			}
			else
				$res[]="yellow";
		}
		echo json_encode($res);
    }  

     public function deletetweets()
    {
      /// we match using the ids only
      foreach($_POST['data'] as $row)
      {
				$this->db->delete("tweets",array("tweet_id"=>$row));
    }
  echo "Success";
    } 
    public function savetweets()
    {
      $res=array() ;

      $str="";
          $statuses = json_decode($this->input->post('data'),true);
          // safe check
       $check=   $this->db->query('select * from tweets');
       if(($check->num_rows()+count($statuses))>300)
       {
         echo 'failure';

       } 
       else
       {
      foreach($statuses as $row)
      {
        $row["deck_id"]=$this->session->userdata("deck_id");
        $sus=$this->db->insert("tweets",$row);
//		 	$sus = $this->db->update("tweets",array("text"=>$row['text'],"deck_id"=>$this->session->userdata("deck_id"),"screename"=>$row["screename"],"fv"=>$row["fv"],"rt"=>$row["rt"]),array('id' => $row["id"]));
      if($sus == 1)
      {
      $str.="success";
      }
        // updates wth on errors
        }
 
  echo $str;
       }
    }
    public function verifykeys() 
	{
    $res=array();
    foreach($_POST['data'] as $row)
    {
      $checks1= $this->db->get_where("accounts",array("user_id"=>$row))->row_array(); 
      if($checks1)
      {
        $checks= $this->db->get_where("deck_user",array("deck_id"=>$checks1["deck_id"]))->row_array(); 
        if($checks["consumer_secret_key"] && $checks["consumer_key"])
          $res[]="green";
        else
          $res[]="blue";
      }
        else
          $res[]="blue";
    }
    echo json_encode($res);
    } 
	public function deletemultiaccounts() 
	{
			foreach($_POST['data'] as $row)
			{
			//	$this->db->delete("accounts",array("user_id"=>$row));
				$this->db->delete("accounts",array("user_id"=>$row));
			}
			
			$this->session->set_userdata(array('success'=>'Cuenta(s) ELIMINDA(s) exitosamente!'));
			echo 1;exit;
	
    }

	public function deleteloghistory() 
	{
		
			
			$this->db->delete("message_log",array("msg_id"=>$this->uri->segment(3)));
			
			redirect('deck');
	
    }
	
	public function deletemultilogs() 
	{
		
			
			foreach($_POST['data'] as $row)
			{
				$this->db->delete("message_log",array("msg_id"=>$row));
			}
			$this->session->set_userdata(array('success'=>'Borrado exitosamente!'));
			echo 1;exit;
	
    }

	public function deletealllogs() 
	{
		
			
		$this->db->empty_table('message_log'); 
		$this->session->set_userdata(array('success'=>'Registro BORRADO exitosamente!'));
			
			redirect('deck');
	
    }
	
		public function deleteerrorlog() 
	{
		
			
		$this->db->empty_table('error_log'); 
		$this->session->set_userdata(array('success'=>'Advertencia BORRADA exitosamente!'));
			
			redirect('');
	
    }
    private function displaytemp($data_Result)
    {
      if($this->session->userdata["session"])
      {
      $rows=count($data_Result);
      $var='<table class="tablesorter" border="0"><form id="input_form1" name="input_form1" action="deck/saved" method="post" onSubmit="return selectcheckbox();" ><input type="hidden" name="total" id="total" value="'.$rows.'" />';
      $header='<tr style="background-color:#CCCCCC;"> <td width="40"><input type="checkbox" name="allbox" id="allbox" value="0" onClick="checkAll(this.value)" /></td> <td width="50">No</td> <td width="100">text</td> <td width="100">rts</td> <td >favs</td> </tr>';
      if($rows)
      {
        $i=1;
        $t=0;
        $userrt=$_POST["noofretweets"];
        $userfvs=$_POST["nooffavs"];
        foreach($data_Result as $row)
        {
          if($row["favorite_count"]> $userfvs && $row["retweet_count"]> $userrt)
          {
            $add='<tr><td><input type="checkbox" class="twitter_ids" name="checkbox[]" id="check'.$t.'" value="'.$row->id_str.'"</td>

              <td>'.$i.'</td>

              <td>'.substr($row["text"],0,40).'</td>

              <td>'.$row["favorite_count"].'</td>

              <td>'.$row["retweet_count"].'</td>

              </tr>';                           
          }

          $i++;$t++;
        }
        $var=$var.$header.$add.'</table>';
        echo $var;
      }


      }
    }
    public function savedtweets()
    {
      /*
      $this->load->model('admin/login_model');
$data["rt"]= $this->login_model->admin_check();
      $this->load->view('test',$data);
    */
        $var11= $this->session->userdata("deck_id");

      try
      {
      if($var11)
      {                                				
		$qry =$this->db->query("Select * from tweets where deck_id =".$var11);
		if($qry->num_rows>0 )
		{	
        $i=1;
        $t=0;
      $rows=$qry->num_rows;
      $tsaved=300-$rows;
      $schtime= $this->db->get_where("deck_user",array("deck_id"=>$var11))->row_array(); 
      $message='<strong><b>Saved tweets table</b></strong><br />Specify the scheduled time<br /><input type="number" size="30" min="1" max="59" id="scheduletime" placeholder="1 to 59" name="" value="'.$schtime["schedule_time"].'" /><p>you have space to store '.$tsaved.' more tweets</p>';
      $var='<table id="dynamicsave" class="tablesorter" border="0"><form id="input_form1" name="input_form1" action="deck/saved" method="post" onSubmit="return selectcheckbox();" ><input type="hidden" name="total" id="totaldelete" value="'.$rows.'" />';
      $header='<thead><tr style="background-color:#CCCCCC;"> <th width="40"><input type="checkbox" name="alltweetdeletebox" id="alltweetdeletebox" value="0" onClick="checkAlldeletetweets(this.value)" /></th> <th width="50">No</th> <th width="100">text</th> <th width="50">rts</th> <th >favs</th> </tr></thead>';
        $add="";
			foreach($qry->result() as $row)
			{	                                            
        $add.='<tr class="tweetdata" id="deletecheckdelete'.$t.'"><td><input type="checkbox" class="twitter_ids" name="checkbox[]" id="checkdelete'.$t.'" value="'.$row->tweet_id.'"></td>
              <td>'.$i.'</td>
              <td>'.substr($row->text,0,40).'</td>
              <td>'.$row->rt.'</td>
              <td>'.$row->fv.'</td>
              </tr>';                           
          $i++;$t++;
      }
              $sch_option= $this->db->get_where("deck_user",array("deck_id"=>$var11))->row_array(); 
              $actual_value=$sch_option["schedule_option"];



 $rr=array('normal'=>'','disabled'=>'','cyclic'=>'','random'=>'','bydate'=>'','higherfavs'=>'','higherrts'=>'');
 $rr[$actual_value]='selected';

      $schoption='<center>Currently scheduled option: <select id="schoption">
       <option value="normal" '.$rr["normal"].'>normal</option>
         <option value="cyclic" '.$rr["cyclic"].'>cyclic</option>
           <option value="random" '.$rr["random"].'>random</option>
            <option value="bydate" '.$rr["bydate"].'>bydate</option>
              <option value="higherrts" '.$rr["higherrts"].'>higherrts</option>
                <option value="higherfavs" '.$rr["higherfavs"].'>higherfavs</option>
                  <option value="disabled" '.$rr["disabled"].'>disabled</option>
                  </select>
      </center>';
        $footer='<center><input id="dynamichange" type="button" class="deletetweets_twitter" value="Delete" />';
         $var=$message.$var.$header.$add.'</table>'.$schoption.$footer; echo $var;
    } 
        } 

      }
        catch ( Exception $e ) {
			
			echo "error";
			log_message ( 'error', 'Deck::displayLimitedLogs Error ' . $e->getMessage () );
			
		} 

      }
      private function getofflimittweets($url)
      {
     
//        $url = "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$username;
        $max_id = null;
        $limit=300;

        $result = 0;

        $data_Result = array();
        $rslt=$url;
        for ($count = 0; ; ) {

          if (null !== $max_id && $max_id == '') {

            break;

          }
          if($count!=0){

            $final_str = $rslt."&count=".($limit-$count)."&max_id=".$max_id;
          }
          else
          {
            $final_str=$rslt."&count=".$limit;
            }
          $checks2 = $this->twitter->get($final_str);
          $statuses = json_decode($checks2,true);           

          if (count($statuses)) {

            $result = $result + count($statuses);

            $last_tweet = end($statuses); 

            $prev_max_Id = $max_id;

            $max_id = $last_tweet['id_str'];
            $count = $result;

            if($prev_max_Id == $max_id){

              $max_id = null;
              break;

            }

            else{

              $data_Result = array_merge($data_Result,$statuses);

            }

            if($count>=$limit)
              break;
          } 

          else {

            $max_id = null;
            break;

          } 
        }

        return $data_Result;


      }

      public function schsemiauto()
      {
          $var= $this->session->userdata("deck_id");
              $checks1= $this->db->get_where("deck_user",array("deck_id"=>$var))->row_array(); 
		$this->db->update("deck_user",array('schedule_auto_account'=> $_POST["semitwusername"], 'schedule_time'=> $_POST['semitime'],'schedule_auto_from' => $_POST["optionsemitweets"] ), array('deck_id' => $this->session->userdata("deck_id")));
    echo "ok";
      }
      public function schauto()
      {    

          $var= $this->session->userdata("deck_id");

          try
          {
            if($var)
            {      
              $users = $this->db->get_where("accounts",array("deck_id"=>$var));
              $cs="";
              $cskey="";
              if($users->num_rows() >0)  
              {
                foreach($users->result() as $row)
                {
                  $cs=$row->consumer_key;
                  $cskey=$row->consumer_secret_key;
                  break;

                }
              }

              $checks1= $this->db->get_where("deck_user",array("deck_id"=>$var))->row_array(); 
              if($checks1)
              {
                $this->twitter->decode_json=FALSE;
                $this->twitter->TwitterOAuth($checks1["consumer_key"], $checks1["consumer_secret_key"], $cs , $cskey); 
                $checks2="";
          if($_POST["optiontweets"]=="timeline")
          {
        //  $checks2 = $this->twitter->get('https://api.twitter.com/1.1/statuses/user_timeline.json?count='.$_POST["nooftweets"].'&screen_name='.$_POST["twusername"],''); 
//          $checks2 = $this->twitter->get('https://api.twitter.com/1.1/statuses/user_timeline.json?count=200&screen_name='.$_POST["twusername"],''); 
          $checks2 = $this->getofflimittweets('https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name='.$_POST["twusername"]);  
//          $checks2 = $this->twitter->get('https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=twitterapi&count=1',''); 
//          $checks2 = $this->twitter->get('https://api.twitter.com/1.1/favorites/list.json?screen_name=episod&count=1',''); 
          }
          else
          {
//         $checks2 = $this->twitter->get('https://api.twitter.com/1.1/favorites/list.json?screen_name='.$_POST["twusername"],''); 
         $checks2 = $this->getofflimittweets('https://api.twitter.com/1.1/favorites/list.json?screen_name='.$_POST["twusername"]); 
//         $checks22=json_decode($checks2, true);  
          }
         $data_Result=$checks2;
      $rows=count($data_Result);
     $var='<table id="dynamicsave" class="tablesorter" border="0"><form id="input_form1" name="input_form1" action="deck/saved" method="post" onSubmit="return selectcheckbox();" ><input type="hidden" name="total" id="totaltweets" value="'.$rows.'" />';
      $header='<thead><tr style="background-color:#CCCCCC;"> <th width="40"><input type="checkbox" name="alltweetbox" id="alltweetbox" value="0" onClick="checkAlltweets(this.value)" /></th> <th width="50">No</th> <th width="100">text</th> <th width="50">rts</th> <th >favs</th></thead> </tr>';
      if($rows)
      {
        $i=1;
        $t=0;
        $userrt=$_POST["noofretweets"];
        $userfvs=$_POST["nooffavs"];
        $add="";
        foreach($data_Result as $row)
        {
          if($i>$_POST["nooftweets"])
            break;
          if($row["favorite_count"]>= $userfvs && $row["retweet_count"]>= $userrt)
          {
            $add=$add.'<tr class="tweetdata"><td><input type="checkbox" class="twitter_ids" name="checkbox[]" id="checktweet'.$t.'" value="'.$row["id_str"].'"></td>
              <td>'.$i.'</td>
              <td>'.substr($row["text"],0,40).'</td>
              <td>'.$row["retweet_count"].'</td>
              <td>'.$row["favorite_count"].'</td>
              </tr>';                           
          $i++;$t++;
        $footer='<center><input id="dynamichange" type="button" class="savetweets_twitter" value="Save" />';
          }

        }
         $var=$var.$header.$add.'</table>'.$footer; echo $var;
    } 
        } 

      }
      else
      {

      }
      }
        catch ( Exception $e ) {
			
			echo "error";
			log_message ( 'error', 'Deck::displayLimitedLogs Error ' . $e->getMessage () );
			
		} 
                   

          $this->twitter->decode_json=TRUE;

        // we wont rediret i any case
      // getthe info and spit it as table format

   //   $data["test"]="hi aksay";
    //  redirect('deck');
             /*
foreach ($_POST as $key => $value)
{
 echo "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."<br>";
}
			// vlaidat the entrie
			if($_POST["password"] && $_POST["new_password"])
			{
				$sus = $this->db->update("deck_user",array("consumer_key"=>$_POST['password'],"consumer_secret_key"=>$_POST["new_password"]),array('deck_id' => $this->session->userdata("deck_id")));
				/// 			$sus1 = $this->db_b->update("deck_user",array("consumer_key"=>$_POST['password'],"consumer_secret_key"=>$_POST["new_password"]),array('deck_id' => $this->session->userdata("deck_id")));

				if($sus == 1)
					$data['success'] = "<font style='color:#00FF00; font-weight:bold; font-size:14px;'>Your information has been successfully updated.</font>";
				//				if($sus1 == 1)
				//					$data['success'] = "<font style='color:#00FF00; font-weight:bold; font-size:14px;'>Your information has been successfully updated.</font>";
			}
			else
			{
				echo "OOPS";
				return 0;
			}






			//	$this->load->view('deck2',$data);

			redirect('deck');


		   redirect('test');
       */
		}

	public function addapp()
		{    

			$var= $this->session->userdata("deck_id");

			// vlaidat the entries
			if($_POST["password"] && $_POST["new_password"])
			{
				$sus = $this->db->update("deck_user",array("consumer_key"=>$_POST['password'],"consumer_secret_key"=>$_POST["new_password"]),array('deck_id' => $this->session->userdata("deck_id")));
				/// 			$sus1 = $this->db_b->update("deck_user",array("consumer_key"=>$_POST['password'],"consumer_secret_key"=>$_POST["new_password"]),array('deck_id' => $this->session->userdata("deck_id")));

				if($sus == 1)
					$data['success'] = "<font style='color:#00FF00; font-weight:bold; font-size:14px;'>Your information has been successfully updated.</font>";
				//				if($sus1 == 1)
				//					$data['success'] = "<font style='color:#00FF00; font-weight:bold; font-size:14px;'>Your information has been successfully updated.</font>";
			}
			else
			{
				echo "OOPS";
				return 0;
			}






			//	$this->load->view('deck2',$data);

			redirect('deck');
			//   redirect('main');
		}



	public	function reset_password() 
	{
		
			
			$this->form_validation->set_rules('password', 'Password', 'callback_currentpassword_check');
			$this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
			$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'trim|required|matches[new_password]|md5');
			
				
			if ($this->form_validation->run() == TRUE)
			{
				
				$sus = $this->db->update("deck_user",array("password"=>md5($_POST['new_password'])),array("deck_id"=>$this->session->userdata("deck_id")));
				
				
				if($sus == 1)
					$data['success'] = "<font style='color:#00FF00; font-weight:bold; font-size:14px;'>Your information has been successfully updated.</font>";

			}
		
		
			$data['title'] = 'The deck Information';
			
			$data['user_info'] = $this->db->get_where("deck_user",array("deck_id"=>$this->session->userdata("deck_id")))->row_array();
			
			$data['setting_info'] = $this->db->get_where("settings")->row_array();

			$data['schedule_info'] = $this->db->get_where('schedule', array("deck_id"=>$this->session->userdata("deck_id")));
			
			$data['deck_accounts'] = $this->db->query("select *, (select username from deck_user where deck_user.deck_id = accounts.deck_id) as user_name from accounts order by account_id desc");
			
			//d($data['deck_accounts']->result(),1);
			
			$data['log_history'] = $this->db->query("select *, (select name from deck_user where deck_user.deck_id = message_log.deck_id) as user_name from message_log order by msg_id desc");
			
			$data['alternative_accounts'] = $this->db->query("select * , (select name from deck_user where deck_user.deck_id = user_accounts.deck_id) as name from user_accounts order by acc_id desc");

			//d($data['alternative_accounts']->result(),1);

			$this->load->view('deck2',$data);
				
    }

  function currentpassword_check($str){
		
		$email =  $this->db->get_where('deck_user', array('password' => md5($str)));
        
		if($email->num_rows() <= 0)
			{
				$this->form_validation->set_message('currentpassword_check', 'Current password is not match.');
				return false;
			}
		else
			{
			return true;
			}
    }  

	
	
	/**
	 * Display logs by day limit
	 */
	public function displayLimitedLogs() {
		
		try {
			
			//-- Get the post input(s) --//
			$days_back = $this->input->post ( 'days-back', TRUE );
			$current_time = time();
			$time_back = $current_time - (int) $days_back * 86400;
			
			//-- Make the query --//
			$log_query = "select
				(select name from deck_user where deck_user.deck_id = message_log.deck_id) as userName, 
				(select type from deck_user where deck_user.deck_id = message_log.deck_id) as userType,
				DATE_FORMAT(CONVERT_TZ(from_unixtime(create_date), @@session.time_zone, '-06:00'),'%d-%m-%Y %r') createdOn ,
				action as actionPerformed,
				tweet_id as tweetId,
				msg_id as msgId,
				retweet_id as reTweetId,
				favorite_id as favoriteId
				from 
				message_log
				where create_date >= " . $time_back . "
				group by action , retweet_id, favorite_id 
				order by create_date desc ";
			
			$log_query_results = $this->db->query($log_query);
			
			if ($log_query_results->num_rows () > 0) {
				
				$log_query_results_arr = $log_query_results->result();
				
				echo json_encode($log_query_results_arr);
				
			} else {
				
			
			}
			
			
		} catch ( Exception $e ) {
			
			echo "error";
			log_message ( 'error', 'Deck::displayLimitedLogs Error ' . $e->getMessage () );
			
		}
	}

	/**
	 * Display Logs by Retweet Id or name
	 */
	public function displayRetweetIdLogs() {
	
		try {
				
			//-- Get the post input(s) --//
			$re_tweet_id = $this->input->post ( 're-tweet-id', TRUE );
			$search_type = $this->input->post ( 'search-type', TRUE );			
			$search_str = $this->input->post ( 'search-str', TRUE );
			
			//-- Make the query append str --//
			$log_query_append = "";
			$log_query_append_where = " where ";
			if($search_type == 1) {
				$log_query_append = $log_query_append_where . " retweet_id = " . $re_tweet_id . "";
			} else {
				$log_query_append = ", deck_user " . $log_query_append_where . " deck_user.name = '" . $search_str . "' 
						and deck_user.deck_id = message_log.deck_id ";
			}
			
			//-- Make the query --//
			$log_query = "select
				(select name from deck_user where deck_user.deck_id = message_log.deck_id) as userName,
				(select type from deck_user where deck_user.deck_id = message_log.deck_id) as userType,
				DATE_FORMAT(CONVERT_TZ(from_unixtime(max(message_log.create_date)), @@session.time_zone, '-06:00'),'%d-%m-%Y %r') 
					createdOn ,
				action as actionPerformed,
				tweet_id as tweetId,
				msg_id as msgId,
				retweet_id as reTweetId,
				favorite_id as favoriteId
				from
				message_log 
				" . $log_query_append . "
				group by action, retweet_id
				order by create_date desc ";
				
			$log_query_results = $this->db->query($log_query);
				
			if ($log_query_results->num_rows () > 0) {
	
				$log_query_results_arr = $log_query_results->result();
	
				echo json_encode($log_query_results_arr);
	
			} else {
	
					
			}
				
				
		} catch ( Exception $e ) {
				
			echo "error";
			log_message ( 'error', 'Deck::displayLimitedLogs Error ' . $e->getMessage () );
				
		}
	}

}
?>
