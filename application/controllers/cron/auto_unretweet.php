<?php
class Auto_unretweet extends CI_Controller {

	private $_consumer_key = 'VR3TGLufZQhpkXqNqPaObPMTm';
    private $_consumer_secret = '30qAzpr1u4Z5f28P7mnLcmyUMnVYXl4Hku86o61RgYgVuN1kJu';
	
	private $_data = array();

	function __construct()
	{
		parent::__construct();
		$this->load->library('twitter');
		
	}
  private function setcskey()
  {
                      

    $mydeckid= $this->session->userdata("deck_id");

    $myquer="select consumer_key,consumer_secret_key from deck_user where deck_id=".$mydeckid;

    $log_query_results = $this->db->query($myquer);

    if ($log_query_results->num_rows () > 0) {

      foreach($log_query_results->result() as $row)

      {

        $this->_consumer_secret=$row->consumer_secret_key;

        $this->_consumer_key=$row->consumer_key;

        break;



      }



      //now override the values 

      //      echo json_encode($log_query_results_arr);



    } else {



      echo "OOPS";

      return 1;

    } 
  }
	
	public function index()
	{
		$array = array();
		
    // setthe consumer keys OK
    $this->setcskey();
		$time =$this->db->query("Select autounret_time from settings LIMIT 1")->row_array();
		
		$unretweet_time = $time['autounret_time']?$time['autounret_time']:5;
		$unretweet_time = $unretweet_time*60;
		$present_time = time();
		$current_time = time();
		$limit_time = $current_time-900;
		
		$qry =$this->db->query("Select * from message_log where action = 'RT' and create_date > $limit_time and  $present_time >= create_date + $unretweet_time  ORDER BY deck_id DESC ");
		

		if($qry->num_rows>0 )
		{	
			foreach($qry->result() as $row)
			{	
					
					d($row);
					$users = $this->db->get_where("accounts",array("user_id"=>$row->user_id))->row_array();
           $checks1= $this->db->get_where("deck_user",array("deck_id"=>$users["deck_id"]))->row_array();  
					$this->twitter->TwitterOAuth($checks1["consumer_key"], $checks1["consumer_secret_key"], $users['consumer_key'] , $users['consumer_secret_key']);
					$res = $this->twitter->post("https://api.twitter.com/1.1/statuses/destroy/".$row->tweet_id.".json");
					
					
					d($res);
					
					if(!$res->errors)
					{						
						
						$this->db->update("message_log",array("action"=>'unRT'),array("msg_id"=>$row->msg_id));
					}
			}
		}//end of if qry
	}//end of index
	}
?>
