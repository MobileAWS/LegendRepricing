<?php session_start();

class TwitterLogin extends CI_Controller {

	private $_consumer_key = 'VR3TGLufZQhpkXqNqPaObPMTm';
    private $_consumer_secret = '30qAzpr1u4Z5f28P7mnLcmyUMnVYXl4Hku86o61RgYgVuN1kJu';
	private $db_b;
	function __construct()
	{
		parent::__construct();
		$this->load->library('twitter');
		$this->db_b = $this->load->database('master', TRUE); 
	}
	
	public function index()
	{
		//d($this->session->userdata('id'),1);
		
		$tokens['access_token'] = NULL;
		$tokens['access_token_secret'] = NULL;

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

		// GET THE ACCESS TOKENS		
		$to = $this->twitter->TwitterOAuth($this->_consumer_key, $this->_consumer_secret, $oauth_token = false, $oauth_token_secret = false);
		//Request tokens from twitter 
		$OAUTH_CALLBACK = site_url('twitterlogin/callback');
		$tok = $this->twitter->getRequestToken($OAUTH_CALLBACK);
		
		// Set session
		$_SESSION['oauth_request_token'] = $token = $tok['oauth_token'];
		$_SESSION['oauth_request_token_secret'] = $tok['oauth_token_secret'];
		
		/* Build the authorization URL*/
		$request_link = $this->twitter->getAuthorizeURL($tok['oauth_token']);
	
		header("Location: $request_link");
	}

	public function callback()
	{
		$app_count = 0;                               
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
    }
//		print_r("ertgrg");
		$to = $this->twitter->TwitterOAuth($this->_consumer_key, $this->_consumer_secret, $_SESSION['oauth_request_token'], $_SESSION['oauth_request_token_secret']);
		$url = parse_url($_SERVER['REQUEST_URI']);
		parse_str($url['query'], $params);		
		
		$info = $this->twitter->getAccessToken($params['oauth_verifier']);
		//d($info,1);
		$userInfo = $this->twitter->get("users/show", array("user_id" => $info['user_id']));
		$app_count++;
		
		if(!$info['user_id'])
		{
			$info['success'] = 0;
		}
		else
		{
				$query = $this->db->get_where("accounts", array( 'user_id' => $info['user_id']));
				$account = $query->result();
				//d($account);
				if( $query->num_rows() > 0 ) {
					
					$updata["username"] = $info['screen_name'];
					
					$updata["deck_id"] = $this->session->userdata('deck_id');
					
					$updata["consumer_key"] = $info['oauth_token'];
					$updata["consumer_secret_key"] = $info['oauth_token_secret'];
					$updata["profile_image"] = $userInfo->profile_image_url;
					$updata["followers"] = $userInfo->followers_count;
					$updata["following"] = $userInfo->friends_count;
					$updata["description"] = $userInfo->description;
					$updata["total_tweets"] = $userInfo->statuses_count;
					$updata["listed_count"] = $userInfo->listed_count;
					
					$updata["last_update"] = strtotime("now");
					//d($updata,1);
					$true = $this->db->update("accounts", $updata, array("user_id" => $info['user_id']));					
					$this->db_b->update("accounts", $updata, array("user_id" => $info['user_id']));
					redirect('deck');
				}
				
				else
				{
					
					$true = $this->db->insert("accounts", array("user_id" => $info['user_id'],"deck_id" => $this->session->userdata('deck_id'), "username" => $info['screen_name'], "consumer_key" => $info['oauth_token'], "consumer_secret_key" => $info['oauth_token_secret'], "profile_image" => $userInfo->profile_image_url, "followers" => $userInfo->followers_count, "following" => $userInfo->friends_count, "description" => $userInfo->description,"listed_count" => $userInfo->listed_count, "total_tweets" => $userInfo->statuses_count, "create_date" => strtotime("now"), "last_update" => strtotime("now")));
					
					$master = $this->db_b->insert("accounts", array("user_id" => $info['user_id'],"deck_id" => $this->session->userdata('deck_id'), "username" => $info['screen_name'], "consumer_key" => $info['oauth_token'], "consumer_secret_key" => $info['oauth_token_secret'], "profile_image" => $userInfo->profile_image_url, "followers" => $userInfo->followers_count, "following" => $userInfo->friends_count, "description" => $userInfo->description,"listed_count" => $userInfo->listed_count, "total_tweets" => $userInfo->statuses_count, "create_date" => strtotime("now"), "last_update" => strtotime("now")));
						
					redirect('deck');
				
			}
		}
	}
}
?>
