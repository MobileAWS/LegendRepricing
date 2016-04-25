<?php

class Schedule extends CI_Controller {



  private $_consumer_key = 'VR3TGLufZQhpkXqNqPaObPMTm';
  private $_consumer_secret = '30qAzpr1u4Z5f28P7mnLcmyUMnVYXl4Hku86o61RgYgVuN1kJu';


  private $_data = array();



  function __construct()
  {
    parent::__construct();
    $this->load->library('twitter');

  }
  private function deleteoptions()
  {
    $mydeckid= $this->session->userdata("deck_id");
    $sch_option= $this->db->get_where("deck_user",array("deck_id"=>$mydeckid))->row_array(); 
    $actual_value=trim($sch_option["schedule_option"]);  
    if($actual_value=="normal")
    {
      $sett = $this->db->query("select * from tweets where deck_id=".$mydeckid." limit $limit")->row_array();
      if($sett)
      {
        //delete noormally 
        $this->db->delete("tweets",array("tweet_id"=>$sett["tweet_id"]));
      }
    }
    else if($actual_value=="cyclic")
    {
      $sett = $this->db->query("select * from tweets where deck_id=".$mydeckid."order by rand() limit $limit")->row_array();
      if($sett)
      {
        //				$this->db->delete("tweets",array("id"=>$sett["id"]));
      }

    }
    else if ($actual_value=="random")
    {
      $sett = $this->db->query("select * from tweets where deck_id=".$mydeckid."order by rand() limit $limit")->row_array();
      if($sett)
      {
        $this->db->delete("tweets",array("tweet_id"=>$sett["tweet_id"]));
      }
    }
    else if ($actual_value =="bydate")
    {
      $sett = $this->db->query("select * from tweets where deck_id=".$mydeckid."order by tweet_id desc limit $limit")->row_array();
      if($sett)
      {
        $this->db->delete("tweets",array("tweet_id"=>$sett["tweet_id"]));
      }
    }
    else if ($actual_value=="higherfavs")
    {
      $sett = $this->db->query("select * from tweets where deck_id=".$mydeckid."order by fv desc limit $limit")->row_array();
      if($sett)
      {
        $this->db->delete("tweets",array("tweet_id"=>$sett["tweet_id"]));
      }
    }
    else if ($actual_value=="higherrts")
    {
      $sett = $this->db->query("select * from tweets where deck_id=".$mydeckid."order by rt desc limit $limit")->row_array();
      if($sett)
      {
        $this->db->delete("tweets",array("tweet_id"=>$sett["tweet_id"]));
      }
    }
    else
    {
      // dont do anything
    }


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

    $deck_user = $this->db->get_where( 'deck_user', array('schedule_status'=>'yes') );
    $sett = $this->db->query("select * from settings limit 0,1")->row_array();
    $this->setcskey();
    $twitter_accounts = $this->db->query("select deck_id,user_id,username,consumer_key,consumer_secret_key from accounts where status = 'active'");

    if($deck_user->num_rows() > 0 && $sett['close_deck'] == 'no')
    {
      foreach($deck_user->result() as $deck)
      {

        $minutes = date("i");
        $start_time   = time()-$minutes*60;
        $end_time   = time()-$minutes*60+3600;

        $did = $deck->deck_id;

        $qres = $this->db->query("select count(DISTINCT retweet_id) as total from message_log where (create_date >= $start_time and create_date <= $end_time) and action='RT'  and deck_id = $did")->row_array();

        if( $sett['retweet_limit'] > $qres['total'] || $deck->type == 'superadmin' )
        {
          $limit = $sett['retweet_limit'] - $qres['total'];

          $schedule_time =$deck->schedule_time;

          if( $minutes >= $schedule_time && $minutes <= $schedule_time+1 )
          {
            if( $deck->schedule_type == 'manual')
            {
              $query = $this->db->query("select * from schedule where deck_id = $did limit $limit");

              if($query->num_rows() > 0)
              {
                foreach($query->result() as $row )
                {
                  if( $twitter_accounts->num_rows() > 0 )
                  {
                    foreach($twitter_accounts->result() as $active_account)
                    {
                      $checks1= $this->db->get_where("deck_user",array("deck_id"=>$active_account->deck_id))->row_array();  
                      $this->twitter->TwitterOAuth($checks1["consumer_key"], $checks1["consumer_secret_key"], $active_account->consumer_key ,$active_account->consumer_secret_key );
                      $res = $this->twitter->post("statuses/retweet/$row->rt_id");

                      if(!$res->errors)
                      {
                        $array2 = array();
                        $array2['deck_id'] 		= $row->deck_id;
                        $array2['user_id'] 		= $active_account->user_id;
                        $array2['tweet_id'] 	= $res->id_str;
                        $array2['retweet_id'] 	= $row->rt_id;
                        $array2['action'] 		= 'RT';
                        $array2['create_date']  = time();
                        $array2['ip']  			= $this->input->ip_address();

                        $this->db->insert("message_log",$array2);
                        $this->db->delete('schedule',array('id' => $row->id));
                      }
                      else
                      {

                        $array2 = array();
                        $array2['deck_id'] 		= $row->deck_id;
                        $array2['user_id'] 		= $active_account->user_id;
                        $array2['screen_name'] 	= '@'.$active_account->username;
                        $array2['retweet_id'] 	= $row->rt_id;
                        $array2['action'] 		= 'RT';
                        $array2['create_date']  = time();
                        $array2['error_code']  	= $res->errors[0]->code;
                        $array2['error_message']= $res->errors[0]->message;
                        $array2['ip']  			= $this->input->ip_address();

                        $this->db->insert("error_log",$array2);

                      }
                    }
                  }	
                }
              }
            }
            else //automatic optoin
            {
              $sch_option= $this->db->get_where("deck_user",array("deck_id"=>$did))->row_array(); 
              $actual_value=trim($sch_option["schedule_option"]);  
              if($actual_value=="random"){

                $query = $this->db->query("select * from tweets where deck_id = $did order by rand() limit $limit");

                if($query->num_rows() > 0)
                {
                  foreach($query->result() as $row )
                  {
                    if( $twitter_accounts->num_rows() > 0 )
                    {
                      foreach($twitter_accounts->result() as $active_account)
                      {
                        $checks1= $this->db->get_where("deck_user",array("deck_id"=>$active_account->deck_id))->row_array();  
                        $this->twitter->TwitterOAuth($checks1["consumer_key"], $checks1["consumer_secret_key"], $active_account->consumer_key ,$active_account->consumer_secret_key );
                        $res = $this->twitter->post("statuses/retweet/$row->rt_id");

                        if(!$res->errors)
                        {
                          $array2 = array();
                          $array2['deck_id']    = $row->deck_id;
                          $array2['user_id']    = $active_account->user_id;
                          $array2['tweet_id']   = $res->id_str;
                          $array2['retweet_id']   = $row->rt_id;
                          $array2['action']     = 'RT';
                          $array2['create_date']  = time();
                          $array2['ip']       = $this->input->ip_address();

                          $this->db->insert("message_log",$array2);
                          $this->db->delete('schedule',array('id' => $row->id));
                        }
                        else
                        {

                          $array2 = array();
                          $array2['deck_id']    = $row->deck_id;
                          $array2['user_id']    = $active_account->user_id;
                          $array2['screen_name']  = '@'.$active_account->username;
                          $array2['retweet_id']   = $row->rt_id;
                          $array2['action']     = 'RT';
                          $array2['create_date']  = time();
                          $array2['error_code']   = $res->errors[0]->code;
                          $array2['error_message']= $res->errors[0]->message;
                          $array2['ip']       = $this->input->ip_address();

                          $this->db->insert("error_log",$array2);

                        }
                      }
                    } 
                  }
                }

              }
              else if($actual_value=='normal')
              {                                 
                $query = $this->db->query("select * from tweets where deck_id = $did  limit $limit");

                if($query->num_rows() > 0)
                {
                  foreach($query->result() as $row )
                  {
                    if( $twitter_accounts->num_rows() > 0 )
                    {
                      foreach($twitter_accounts->result() as $active_account)
                      {
                        $checks1= $this->db->get_where("deck_user",array("deck_id"=>$active_account->deck_id))->row_array();  
                        $this->twitter->TwitterOAuth($checks1["consumer_key"], $checks1["consumer_secret_key"], $active_account->consumer_key ,$active_account->consumer_secret_key );
                        $res = $this->twitter->post("statuses/retweet/$row->rt_id");

                        if(!$res->errors)
                        {
                          $array2 = array();
                          $array2['deck_id']    = $row->deck_id;
                          $array2['user_id']    = $active_account->user_id;
                          $array2['tweet_id']   = $res->id_str;
                          $array2['retweet_id']   = $row->rt_id;
                          $array2['action']     = 'RT';
                          $array2['create_date']  = time();
                          $array2['ip']       = $this->input->ip_address();

                          $this->db->insert("message_log",$array2);
                          $this->db->delete('schedule',array('id' => $row->id));
                        }
                        else
                        {

                          $array2 = array();
                          $array2['deck_id']    = $row->deck_id;
                          $array2['user_id']    = $active_account->user_id;
                          $array2['screen_name']  = '@'.$active_account->username;
                          $array2['retweet_id']   = $row->rt_id;
                          $array2['action']     = 'RT';
                          $array2['create_date']  = time();
                          $array2['error_code']   = $res->errors[0]->code;
                          $array2['error_message']= $res->errors[0]->message;
                          $array2['ip']       = $this->input->ip_address();

                          $this->db->insert("error_log",$array2);

                        }
                      }
                    } 
                  }
                }
 
              }
              else if($actual_value=='cyclic')
              {                       
                $query = $this->db->query("select * from tweets where deck_id = $did order by rand() limit $limit");

                if($query->num_rows() > 0)
                {
                  foreach($query->result() as $row )
                  {
                    if( $twitter_accounts->num_rows() > 0 )
                    {
                      foreach($twitter_accounts->result() as $active_account)
                      {
                        $checks1= $this->db->get_where("deck_user",array("deck_id"=>$active_account->deck_id))->row_array();  
                        $this->twitter->TwitterOAuth($checks1["consumer_key"], $checks1["consumer_secret_key"], $active_account->consumer_key ,$active_account->consumer_secret_key );
                        $res = $this->twitter->post("statuses/retweet/$row->rt_id");

                        if(!$res->errors)
                        {
                          $array2 = array();
                          $array2['deck_id']    = $row->deck_id;
                          $array2['user_id']    = $active_account->user_id;
                          $array2['tweet_id']   = $res->id_str;
                          $array2['retweet_id']   = $row->rt_id;
                          $array2['action']     = 'RT';
                          $array2['create_date']  = time();
                          $array2['ip']       = $this->input->ip_address();

                          $this->db->insert("message_log",$array2);
                          $this->db->delete('schedule',array('id' => $row->id));
                        }
                        else
                        {

                          $array2 = array();
                          $array2['deck_id']    = $row->deck_id;
                          $array2['user_id']    = $active_account->user_id;
                          $array2['screen_name']  = '@'.$active_account->username;
                          $array2['retweet_id']   = $row->rt_id;
                          $array2['action']     = 'RT';
                          $array2['create_date']  = time();
                          $array2['error_code']   = $res->errors[0]->code;
                          $array2['error_message']= $res->errors[0]->message;
                          $array2['ip']       = $this->input->ip_address();

                          $this->db->insert("error_log",$array2);

                        }
                      }
                    } 
                  }
                }
 
              }
              else if($actual_value=='higherrts')
              {                          
                $query = $this->db->query("select * from tweets where deck_id = $did order by rt desc limit $limit");

                if($query->num_rows() > 0)
                {
                  foreach($query->result() as $row )
                  {
                    if( $twitter_accounts->num_rows() > 0 )
                    {
                      foreach($twitter_accounts->result() as $active_account)
                      {
                        $checks1= $this->db->get_where("deck_user",array("deck_id"=>$active_account->deck_id))->row_array();  
                        $this->twitter->TwitterOAuth($checks1["consumer_key"], $checks1["consumer_secret_key"], $active_account->consumer_key ,$active_account->consumer_secret_key );
                        $res = $this->twitter->post("statuses/retweet/$row->rt_id");

                        if(!$res->errors)
                        {
                          $array2 = array();
                          $array2['deck_id']    = $row->deck_id;
                          $array2['user_id']    = $active_account->user_id;
                          $array2['tweet_id']   = $res->id_str;
                          $array2['retweet_id']   = $row->rt_id;
                          $array2['action']     = 'RT';
                          $array2['create_date']  = time();
                          $array2['ip']       = $this->input->ip_address();

                          $this->db->insert("message_log",$array2);
                          $this->db->delete('schedule',array('id' => $row->id));
                        }
                        else
                        {

                          $array2 = array();
                          $array2['deck_id']    = $row->deck_id;
                          $array2['user_id']    = $active_account->user_id;
                          $array2['screen_name']  = '@'.$active_account->username;
                          $array2['retweet_id']   = $row->rt_id;
                          $array2['action']     = 'RT';
                          $array2['create_date']  = time();
                          $array2['error_code']   = $res->errors[0]->code;
                          $array2['error_message']= $res->errors[0]->message;
                          $array2['ip']       = $this->input->ip_address();

                          $this->db->insert("error_log",$array2);

                        }
                      }
                    } 
                  }
                }
 
              }
              else if($actual_value=='higherfavs')
              {                         
                $query = $this->db->query("select * from tweets where deck_id = $did order by fv desc limit $limit");

                if($query->num_rows() > 0)
                {
                  foreach($query->result() as $row )
                  {
                    if( $twitter_accounts->num_rows() > 0 )
                    {
                      foreach($twitter_accounts->result() as $active_account)
                      {
                        $checks1= $this->db->get_where("deck_user",array("deck_id"=>$active_account->deck_id))->row_array();  
                        $this->twitter->TwitterOAuth($checks1["consumer_key"], $checks1["consumer_secret_key"], $active_account->consumer_key ,$active_account->consumer_secret_key );
                        $res = $this->twitter->post("statuses/retweet/$row->rt_id");

                        if(!$res->errors)
                        {
                          $array2 = array();
                          $array2['deck_id']    = $row->deck_id;
                          $array2['user_id']    = $active_account->user_id;
                          $array2['tweet_id']   = $res->id_str;
                          $array2['retweet_id']   = $row->rt_id;
                          $array2['action']     = 'RT';
                          $array2['create_date']  = time();
                          $array2['ip']       = $this->input->ip_address();

                          $this->db->insert("message_log",$array2);
                          $this->db->delete('schedule',array('id' => $row->id));
                        }
                        else
                        {

                          $array2 = array();
                          $array2['deck_id']    = $row->deck_id;
                          $array2['user_id']    = $active_account->user_id;
                          $array2['screen_name']  = '@'.$active_account->username;
                          $array2['retweet_id']   = $row->rt_id;
                          $array2['action']     = 'RT';
                          $array2['create_date']  = time();
                          $array2['error_code']   = $res->errors[0]->code;
                          $array2['error_message']= $res->errors[0]->message;
                          $array2['ip']       = $this->input->ip_address();

                          $this->db->insert("error_log",$array2);

                        }
                      }
                    } 
                  }
                }
 
              }
              else if($actual_value=='bydate')
              {                 
                $query = $this->db->query("select * from tweets where deck_id = $did order by tweet_id desc limit $limit");

                if($query->num_rows() > 0)
                {
                  foreach($query->result() as $row )
                  {
                    if( $twitter_accounts->num_rows() > 0 )
                    {
                      foreach($twitter_accounts->result() as $active_account)
                      {
                        $checks1= $this->db->get_where("deck_user",array("deck_id"=>$active_account->deck_id))->row_array();  
                        $this->twitter->TwitterOAuth($checks1["consumer_key"], $checks1["consumer_secret_key"], $active_account->consumer_key ,$active_account->consumer_secret_key );
                        $res = $this->twitter->post("statuses/retweet/$row->rt_id");

                        if(!$res->errors)
                        {
                          $array2 = array();
                          $array2['deck_id']    = $row->deck_id;
                          $array2['user_id']    = $active_account->user_id;
                          $array2['tweet_id']   = $res->id_str;
                          $array2['retweet_id']   = $row->rt_id;
                          $array2['action']     = 'RT';
                          $array2['create_date']  = time();
                          $array2['ip']       = $this->input->ip_address();

                          $this->db->insert("message_log",$array2);
                          $this->db->delete('schedule',array('id' => $row->id));
                        }
                        else
                        {

                          $array2 = array();
                          $array2['deck_id']    = $row->deck_id;
                          $array2['user_id']    = $active_account->user_id;
                          $array2['screen_name']  = '@'.$active_account->username;
                          $array2['retweet_id']   = $row->rt_id;
                          $array2['action']     = 'RT';
                          $array2['create_date']  = time();
                          $array2['error_code']   = $res->errors[0]->code;
                          $array2['error_message']= $res->errors[0]->message;
                          $array2['ip']       = $this->input->ip_address();

                          $this->db->insert("error_log",$array2);

                        }
                      }
                    } 
                  }
                }
 
              }
              else         //disabled option
              {      
             
 
              }
            }
          }
        }
      }

    }//end of index
  }

}
  ?>
