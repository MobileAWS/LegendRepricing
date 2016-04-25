<?php 

class Content extends CI_Controller
{
  private $data = array();
  private $appname="";
  private  $appversion="";
  private $gearman_server='localhost';
  private $gearman_port='4730';

  public function __construct(){

    parent::__construct();       
    $this->load->library('pagination');
    $this->load->library("form_validation");

    if(php_sapi_name() !== 'cli') {
      if(!$this->session->userdata("logged_in")) redirect("home");     
      $var= $this->session->userdata("logged_in");
      if($this->db->get_where("user_settings",array("email"=>$var))->num_rows() == 0 )
      {
        //   $this->settings();
        $this->session->set_flashdata('info_messages_1',"Please configure seller id , markerplace id and mws auth token under <b>Settings</b>");
      }
      if($this->db->get_where("subscription",array("email"=>$var))->num_rows()==0 || $this->db->get_where("subscription",array("email"=>$var))->row_array()['plan'] == 'free' )
      {
        $this->session->set_flashdata('info_messages_2',"Repricing wont work until you are subscribed to basic/premium/enterprice/plus under Subscriptions tab..Currently you are on free version");
      }             
      else
      {
        $this->session->set_flashdata('info_messages_2',"Your current subscription plan is ".$this->db->get_where("subscription",array("email"=>$var))->row_array()['plan']);
      }
    }
    $this->appversion="tetsversion";
    $this->appname="testapp";

  }
 public function do_upload()
  {
    $config['upload_path'] = './uploads/';
    $config['allowed_types'] = 'gif|jpg|png';
    $config['max_size'] = '100';
    $config['max_width']  = '1024';
    $config['max_height']  = '768';

    $this->load->library('upload', $config);

    if ( ! $this->upload->do_upload())
    {
      $error = array('error' => $this->upload->display_errors());

      $this->load->view('upload_form', $error);
    }
    else
    {
      $data = array('upload_data' => $this->upload->data());

      $this->load->view('upload_success', $data);
    }
  }
  private function invokeListMarketplaceParticipations(MarketplaceWebServiceSellers_Interface $service, $request,$sellerid,$marketplaceid)
  {
    try {
      $response = $service->ListMarketplaceParticipations($request);
      $xml=simplexml_load_string($response->toXML());
      foreach($xml->ListMarketplaceParticipationsResult->ListParticipations->Participation as $values)
      {
        if(trim($values->MarketplaceId)==$marketplaceid && trim($values->HasSellerSuspendedListings)=='No'  && trim($values->SellerId)==$sellerid)
          return 'matched';
      }


    } catch (MarketplaceWebServiceSellers_Exception $ex) {
/*
        echo("Caught Exception: " . $ex->getMessage() . "\n");
        echo("Response Status Code: " . $ex->getStatusCode() . "\n");
        echo("Error Code: " . $ex->getErrorCode() . "\n");
        echo("Error Type: " . $ex->getErrorType() . "\n");
        echo("Request ID: " . $ex->getRequestId() . "\n");
        echo("XML: " . $ex->getXML() . "\n");
        echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
 */

    }
    return 'unmatched';
  }

  private function test_cred($sellerid,$marketplaceid,$mwsauthtoken)
  {
    $serviceUrl = $this->config->item($marketplaceid,'gl_serviceurl')."/Sellers/2011-07-01";
    $config = array ( 'ServiceURL' => $serviceUrl, 'ProxyHost' => null, 'ProxyPort' => -1, 'MaxErrorRetry' => 3,);
    $service = new MarketplaceWebServiceSellers_Client(
      AWS_ACCESS_KEY_ID,
      AWS_SECRET_ACCESS_KEY,
      APPLICATION_NAME,
      APPLICATION_VERSION,
      $config);
    $request = new MarketplaceWebServiceSellers_Model_ListMarketplaceParticipationsRequest();
    $request->setSellerId($sellerid);
    $request->setMWSAuthToken($mwsauthtoken);
    return $this->invokeListMarketplaceParticipations($service, $request,$sellerid,$marketplaceid);
  }

  public function setuppage()
  {
    $this->load->view('repricing/settings',$this->data);
  }
  public function status()
  {
    $this->load->view('repricing/status',$this->data);
  }
  public function addons()
  {

    $this->load->view('repricing/header',$this->data);
    $this->load->view('repricing/nav',$this->data);
    $this->load->view('repricing/addons',$this->data);
    $this->load->view('repricing/footer',$this->data);
  } 
  public function qtysync()
  {

    $this->load->view('repricing/header',$this->data);
    $this->load->view('repricing/nav',$this->data);
    $this->load->view('repricing/addons',$this->data);
    $this->load->view('repricing/footer',$this->data);
  }
/*
private function checkservers()
{
  $client= new GearmanClient();
  $client->addServer($this->gearman_server,$this->gearman_port);
  $result=@$client->ping('data testing');
  //echo $client->getErrno();
  return $client->returnCode();
}
private function gen_uuid() {
  return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
    // 32 bits for "time_low"
    mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

    // 16 bits for "time_mid"
    mt_rand( 0, 0xffff ),

    // 16 bits for "time_hi_and_version",
    // four most significant bits holds version number 4
    mt_rand( 0, 0x0fff ) | 0x4000,

    // 16 bits, 8 bits for "clk_seq_hi_res",
    // 8 bits for "clk_seq_low",
    // two most significant bits holds zero and one for variant DCE1.1
    mt_rand( 0, 0x3fff ) | 0x8000,

    // 48 bits for "node"
    mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
  );
}
 */   
  public function dynamic_repricing()
  {
    // add the clients jobss
    // we have the seelr id , mkplace id and token
    if(!$this->input->is_cli_request())
    {
      log_message('info',"create dyamic repricing my only be accessed from the command line");
      return;
    } 
    $result_array=  $this->db->get_where("user_settings")->result_array();
    if($result_array)
    {
      foreach ($result_array as $row)
      {
        $new=array();
        $new['sellerid']=$row['sellerid'];
        $new['mwsauthtoken']=$row['mwsauthtoken'];
        $new['marketplaceid']=$row['marketplaceid'];
        if(checkservers()==0)
        {
          // create new client

          $client= new GearmanClient();
          $client->addServer($this->gearman_server,$this->gearman_port);
          // serialaize the data
          //        $result=$client->doBackground("dynamic_report", serialize($row));
          $result=$client->doBackground("dynamic_repricing", serialize($new));

          log_message('info',print_r($new,TRUE));
          log_message("info","dynamic created repricing client ...waiting for the workrs");
          //     return TRUE;
        }                    
        else
        { 
          //$this->backup_link($new,"dynamic_report");
          backup_link($new,"dynamic_repricing");
        }
      }
    }

    return TRUE;

  }           
  public function dynamic_sqs()
  {
    // add the clients jobss
    // we have the seelr id , mkplace id and token
    if(!$this->input->is_cli_request())
    {
      log_message('info',"create dyamic report  my only be accessed from the command line");
      return;
    } 
    $result_array=  $this->db->get_where("user_settings")->result_array();
    if($result_array)
    {
      foreach ($result_array as $row)
      {
        $new=array();
        $new['sellerid']=$row['sellerid'];
        $new['mwsauthtoken']=$row['mwsauthtoken'];
        $new['marketplaceid']=$row['marketplaceid'];
      //  $this->createsqs($new);
        if(checkservers()==0)
        {
          // create new client

          $client= new GearmanClient();
          $client->addServer($this->gearman_server,$this->gearman_port);
          // serialaize the data
          //        $result=$client->doBackground("dynamic_report", serialize($row));
          $result=$client->doBackground("amazon_sqs", serialize($new));

          log_message('info',print_r($new,TRUE));
          log_message("info","dynamic created amazon sqs client ...waiting for the workrs");
          //     return TRUE;
        }                    
        else
        { 
          //$this->backup_link($new,"dynamic_report");
          backup_link($new,"amazon_sqs");
        }
      }
    }

    return TRUE;

  }                               
  public function dynamic_report()
  {
    // add the clients jobss
    // we have the seelr id , mkplace id and token
    if(!$this->input->is_cli_request())
    {
      log_message('info',"create dyamic report  my only be accessed from the command line");
      return;
    } 
    $result_array=  $this->db->get_where("user_settings")->result_array();
    if($result_array)
    {
      foreach ($result_array as $row)
      {
        $new=array();
        $new['sellerid']=$row['sellerid'];
        $new['mwsauthtoken']=$row['mwsauthtoken'];
        $new['marketplaceid']=$row['marketplaceid'];
        if(checkservers()==0)
        {
          // create new client

          $client= new GearmanClient();
          $client->addServer($this->gearman_server,$this->gearman_port);
          // serialaize the data
          //        $result=$client->doBackground("dynamic_report", serialize($row));
          $result=$client->doBackground("dynamic_report", serialize($new));

          log_message('info',print_r($new,TRUE));
          log_message("info","dynamic created amazon report client ...waiting for the workrs");
          //     return TRUE;
        }                    
        else
        { 
          //$this->backup_link($new,"dynamic_report");
          backup_link($new,"dynamic_report");
        }
      }
    }

    return TRUE;

  }
  public function amazon_fbafees()
  {
    // add the clients jobss
    // we have the seelr id , mkplace id and token
    if(!$this->input->is_cli_request())
    {
      log_message('info',"create fba fees report  my only be accessed from the command line");
      return;
    } 
    $result_array=  $this->db->get_where("user_settings")->result_array();
    if($result_array)
    {
      foreach ($result_array as $row)
      {
        $new=array();
        $new['sellerid']=$row['sellerid'];
        $new['mwsauthtoken']=$row['mwsauthtoken'];
        $new['marketplaceid']=$row['marketplaceid'];
        if(checkservers()==0)
        {
          // create new client

          $client= new GearmanClient();
          $client->addServer($this->gearman_server,$this->gearman_port);
          $result=$client->doBackground("amazon_fbafees", serialize($new));
          log_message('info',print_r($new,TRUE));
          log_message("info","fba fees created amazon report client ...waiting for the workrs");
        }                    
        else
        { 
          backup_link($new,"amazon_fbafees");
        }
      }
    }

    return TRUE;

  }                               
  private function amazon_report($option)
  {
    // add the clients jobss
    // we have the seelr id , mkplace id and token
    if(checkservers()==0)
    {
      // create new client
      $client= new GearmanClient();
      $client->addServer($this->gearman_server,$this->gearman_port);
      // serialaize the data
      $result=$client->doBackground("amazon_report", serialize($option));
      log_message("info","created amazon report client ...waiting for the workrs");
      return TRUE;
    }                    
    else
    { 
      //$this->backup_link($option,"amazon_report");
      backup_link($option,"amazon_report");
    }

    return TRUE;

  }
           /*
private function backup_link($option,$function_name)
  {    
    $log_array['unique_key']=$this->gen_uuid();
    $log_array['function_name']=$function_name;
    $log_array['priority']=1;
    $log_array['data']=serialize($option);
    $this->db->insert("table_name",$log_array);           

    // now restart the service
    exec("/etc/init.d/gearman-job-server restart", $output, $return);
    if ($return == 0) {
      log_message('info', "Ok, process is re-running\n");
    }   else
    {
      log_message('error',"FAILED TO STRT THE GEARMAN SERVICE");
    }


  }
            */
  private function amazon_run($option)
  {

    if(checkservers()==0)
    {
      // create new client
      $client= new GearmanClient();
      $client->addServer($this->gearman_server,$this->gearman_port);
      // serialaize the data
      $result=$client->doBackground("amazon_update", serialize($option));

      return TRUE;
    }
    else
    { 
      //$this->backup_link($option,"amazon_update");
      backup_link($option,"amazon_update");
    }                                        
  }
  private function amazon_update($option,&$error)
  {
    $var=$this->session->userdata('logged_in');
 //   $result=  $this->db->get_where("subscription",array("email"=>$var))->row_array();
   // if($result) //&& $result['plan']!='free')
    {
      // add the clients jobss
      //exceptional cases when beatby and status
      // further vaidaiton
      if(listing_validation($option,$error)==FALSE)
        return FALSE;
      //  if(isset($option['status']) || isset($option['beatby']))
      if(isset($option['status']))
      {
        //    return TRUE;
      }
      if(isset($option['qty']))
      {
        $result_new=$this->db->get_where("user_listings",array("sellerid"=>$option['sellerid'],"sku"=>$option['sku']))->row_array();
        if($result_new['fulfillment_channel'] == "AMAZON_NA" && !isset($option['fulfillment_channel']))
        {
          $error='Cannot edit the quantity with FBA since the items are stored in amazons warehouse';
          return FALSE;
        }
        if(isset($option['fulfillment_channel']) && $option['fulfillment_channel']=='AMAZON_NA')
        {
          $error='Cannot edit the quantity with FBA since the items are stored in amazons warehouse';
          return FALSE;
        }
      }
    /*
    if(checkservers()==0)
    {
      // create new client
      $client= new GearmanClient();
      $client->addServer($this->gearman_server,$this->gearman_port);
      // serialaize the data
      $result=$client->doBackground("amazon_update", serialize($option));

      return TRUE;
    }
    else
    { 
      //$this->backup_link($option,"amazon_update");
      backup_link($option,"amazon_update");
    }
     */
      /*
    $serviceUrl="https://mws.amazonservices.com/Products/2011-10-01";
    $config = array (
      'ServiceURL' => $serviceUrl,
      'ProxyHost' => null,
      'ProxyPort' => -1,
      'MaxErrorRetry' => 3
    );

    $log_array=$this->db->get_where("user_settings",array("email"=>$var))->row_array();
    //        $service = new  MarketplaceWebService_Client(AWS_ACCESS_KEY_ID,AWS_SECRET_ACCESS_KEY,NULL,$this->appname,$this->appversion);
    $awskey='AKIAIPGAVOI4KG2HPRZA';
    $secret='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';
    if($log_array)
    {
      $service = new  MarketplaceWebService_Client($awskey,$secret,$config,$this->appname,$this->appversion);
      var_dump($service);                         
      if($option=='price')
      {
      }
      else if ($option=="min_price")
      {
      }
      else if ($option=="max_price")
      {
      }
      else if ($option=="map")
      {
      }
      else
      {
        return FALSE;
      }
      return TRUE;
    }
       */
    }

    //return FALSE;
    ///  log_message('info','Stuckk here');
    return TRUE;

  }

  public function justcheck()
  {
    echo "starting ..";
    flush();
    ob_flush();
    sleep(10);

    echo "done";
  }
  /* save listings function */
  private function check_sellerid($arr)
  {
    if(preg_match("/^[A-Za-z0-9]{13,16}$/",   $arr))
      return "TRUE";
    return "FALSE";
  }
  public function process()
  {
    /// we can live update ajaz request here
    // update the amazon only then update mysql 
    if(isset($_POST['exclude_seller']) && $_POST['exclude_seller'])
    {
      $ex_id=array_map(array($this,'check_sellerid'),explode(';',trim($_POST['exclude_seller'])));
      if( in_array( "FALSE" ,$ex_id ))
      {
        echo 'Error/invalid exclude seller id supplied ';
        return;
      }
    }
    if(isset($_POST['beatby']))
    {
      if($_POST['beatby']=='beatby')
      {
        if(preg_match("/^[0-9]{1,3}\.[0-9]{1,2}$/",   $_POST['beatbyvalue']) ==0)
        {
          echo 'Error/invalid beat by supplied ';
          return;
        }
      }
      if($_POST['beatby']=='beatmeby')
      {
        if(preg_match("/^[0-9]{1,3}\.[0-9]{1,2}$/",   $_POST['beatbyvalue']) ==0)
        {
          echo 'Error/invalid beat me by supplied ';
          return;
        }
      }
      if($_POST['beatby']=='matchprice')
      {
        $_POST['beatbyvalue']='0.0';
      }
      if($_POST['beatby']=='formula')
      {
        $_POST['beatbyvalue']='Use our secret formula';
      }
    }
    else
    {
      if(isset($_POST['beatbyvalue']))
      {
        if(preg_match("/^[0-9]{1,3}\.[0-9]{1,2}$/",   $_POST['beatbyvalue']) ==0)
        {
          echo 'Error/invalid beat by supplied ';
          return;
        }
      }      
    }
    if(isset($_POST) && isset($_POST['sku']) && isset($_POST['sellerid']))
    {
      $id_sku=$_POST['sku'];
      $id_sellerid=$_POST["sellerid"];
      $error='';
      if($this->amazon_update($_POST,$error) == TRUE)
      {
        // hcekc for fulfilmnet channel
        $this->amazon_run($_POST);
        if(isset($_POST['fulfillment_channel']) &&  $_POST['fulfillment_channel']=="AMAZON_NA")
        {
          $_POST['qty']='undefined';
          $this->db->update("user_listings",$_POST, array('email' => $this->session->userdata("logged_in"),'sellerid' => $id_sellerid,'sku' => $id_sku));
        }
        else
        {
          $this->db->update("user_listings",$_POST, array('email' => $this->session->userdata("logged_in"),'sellerid' => $id_sellerid,'sku' => $id_sku));
        }

        //  echo "status";      
        if($this->db->_error_number())
        {
          //    echo $this->db->_error_message();
          log_message('error',$this->db->_error_message());
          echo 'Error/invalid values supplied ';
          return;
        }
        else echo 'Success';           
        return ;
      }
      else 
      {
        echo $error;
        //      echo 'Error/invalid values supplied ';
        return;
      }
    }
    else 
    {
      echo 'Error/invalid values supplied ';
      return;
    }

    //    http_response_code(200);

  }
  public function insight()

  {





    $data['title'] = 'insight';

    $this->load->view('repricing/insight',$data);





  }	public function manage()

  {

    //	 	$data['title'] = 'manage';
    $myquery="select count(*) as mtotal from user_listings where email='".$this->session->userdata('logged_in')."'";
    $checks1=$this->db->query($myquery);   
    $this->data=$checks1->row_array();

    $this->load->view('repricing/manage',$this->data);

  }
  public function index(){

    if(!$this->session->userdata("logged_in")) redirect("home");     
    //    $data[""]="";
    //load the vewd
    //    $this->load->view('repricing/header',$data);
    //   $this->load->view('repricing/nav',$data);
    $var= $this->session->userdata("logged_in");
    if($this->db->get_where("user_settings",array("email"=>$var))->num_rows() > 0 )
    {
      //      $data["info"]="Ok you are on free verison .. we wont support repricing in this version";
      //      $this->load->view('repricing/listings',$data);
      $this->listings();
    }
    else
    {

      //       $data['title'] = 'Dashboard';

      //      $this->load->view('repricing/dashboard',$data);
      $this->settings();
      //    $this->load->view('repricing/settings',$data);
    } 

    //  $this->load->view('repricing/footer',$data);
    // 			redirect("deck");



    //    $this->session->set_flashdata('error','incorrect captcha');



  }	          
  public function save_profiles()
  {
    // add vlaidationss if u can 
    $var= $this->session->userdata("logged_in");
    /*
    $checks1= $this->db->get_where("user_profiles",array("email"=>$var))->row_array(); 
    if($checks1)
    {
      $this->db->update("user_profiles",array('phone'=> $_POST["phone"],'email'=> $_POST["email"], 'name'=> $_POST['name'],'companyname' => $_POST["companyname"] ), array('email' => $this->session->userdata("logged_in")));
      echo "ok";
    }
    else
    {
      $this->db->insert("user_profiles",array('phone'=> $_POST["phone"],'email'=> $_POST["email"], 'name'=> $_POST['name'],'companyname' => $_POST["companyname"] ));
    }
     */
    $this->db_mysql->on_duplicate_key_update()->insert("user_profiles",array('email'=>$var,'name'=> $_POST["name"],'companyname'=> $_POST["companyname"],'phone'=> $_POST["phone"]));


    $log_array["password"]=md5($_POST["password"]);
    //    $log_array["cpassword"]=md5($_POST["cpassword"]);
    $this->db->update("signup",$log_array, array('email' => $this->session->userdata("logged_in")));
    if($this->db->_error_number())
    {
      echo $this->db->_error_message();
    }
    else echo 'Saved';



  }



  private  function invokeRegisterDestination(MWSSubscriptionsService_Interface $service, $request)

  {

    try {

      $response = $service->RegisterDestination($request);



      //        echo ("Service Response\n");

      //      echo ("=============================================================================\n");



      $dom = new DOMDocument();

      $dom->loadXML($response->toXML());

      $dom->preserveWhiteSpace = false;

      $dom->formatOutput = true;

      $dom->saveXML();

      log_message('info',$response->getResponseHeaderMetadata());

      //      echo("ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");



    } catch (MWSSubscriptionsService_Exception $ex) {

      log_message('info',$ex->getMessage());

                                                                        /*

                                                                                  echo("Caught Exception: " . $ex->getMessage() . "\n");

                                                                        echo("Response Status Code: " . $ex->getStatusCode() . "\n");

                                                                        echo("Error Code: " . $ex->getErrorCode() . "\n");

                                                                                echo("Error Type: " . $ex->getErrorType() . "\n");

                                                                                echo("Request ID: " . $ex->getRequestId() . "\n");

                                                                                        echo("XML: " . $ex->getXML() . "\n");

                                                                                        echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");

                                                                         */

    }

  }  

  private function invokeCreateSubscription(MWSSubscriptionsService_Interface $service, $request)

  {

    try {

      $response = $service->CreateSubscription($request);



      //        echo ("Service Response\n");

      //       echo ("=============================================================================\n");



      $dom = new DOMDocument();

      $dom->loadXML($response->toXML());

      $dom->preserveWhiteSpace = false;

      $dom->formatOutput = true;

      $dom->saveXML();

      log_message('info',$response->getResponseHeaderMetadata());

      //  echo("ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");



    } catch (MWSSubscriptionsService_Exception $ex) {

      log_message('info',$ex->getMessage());

                                                            /*

                                                                      echo("Caught Exception: " . $ex->getMessage() . "\n");

                                                            echo("Response Status Code: " . $ex->getStatusCode() . "\n");

                                                            echo("Error Code: " . $ex->getErrorCode() . "\n");

                                                                    echo("Error Type: " . $ex->getErrorType() . "\n");

                                                                    echo("Request ID: " . $ex->getRequestId() . "\n");

                                                                            echo("XML: " . $ex->getXML() . "\n");

                                                                            echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");

                                                             */

    }

  }
  public function createsub($log_array)

  {        

    log_message('info','Doing create subscription');

    $serviceUrl = "https://mws.amazonservices.com/Subscriptions/2013-07-01";

    $config = array (

      'ServiceURL' => $serviceUrl,

      'ProxyHost' => null,

      'ProxyPort' => -1,

      'ProxyUsername' => null,

      'ProxyPassword' => null,

      'MaxErrorRetry' => 3,

    );

    $service = new MWSSubscriptionsService_Client(

      AWS_ACCESS_KEY_ID,

      AWS_SECRET_ACCESS_KEY,

      APPLICATION_NAME,

      APPLICATION_VERSION,

      $config);

    $request = new MWSSubscriptionsService_Model_CreateSubscriptionInput();

    $sub = new MWSSubscriptionsService_Model_Subscription();

    $sub->setNotificationType('AnyOfferChanged');

    $sub->setIsEnabled(TRUE);

    $dest = new MWSSubscriptionsService_Model_Destination();

    $dest->setDeliveryChannel('SQS');

    $keyvalue = new MWSSubscriptionsService_Model_AttributeKeyValue();

    $keyvalue->setKey('sqsQueueUrl');

    $keyvalue->setValue('https://sqs.us-west-2.amazonaws.com/436456621616/'.$log_array['sellerid']);

    $idlist = new MWSSubscriptionsService_Model_AttributeKeyValueList();

    $dest->setAttributeList($idlist->withmember($keyvalue));

    $sub->setDestination($dest);

    $request->setSubscription($sub);

    $request->setSellerId($log_array['sellerid']);

    $request->setMarketplaceId($log_array['marketplaceid']);

    $request->setMwsAuthToken($log_array['mwsauthtoken']); 

    // object or array of parameters

    $this->invokeCreateSubscription($service, $request);



  }    

  public function registerdest($log_array)

  {

    log_message('info','Doing register destination');

    $serviceUrl = "https://mws.amazonservices.com/Subscriptions/2013-07-01";

    $config = array (

      'ServiceURL' => $serviceUrl,

      'ProxyHost' => null,

      'ProxyPort' => -1,

      'ProxyUsername' => null,

      'ProxyPassword' => null,

      'MaxErrorRetry' => 3,

    );

    $service = new MWSSubscriptionsService_Client(

      AWS_ACCESS_KEY_ID,

      AWS_SECRET_ACCESS_KEY,

      APPLICATION_NAME,

      APPLICATION_VERSION,

      $config);

    //    print_r($service);  

    $request = new MWSSubscriptionsService_Model_RegisterDestinationInput();

    $dest = new MWSSubscriptionsService_Model_Destination();

    $dest->setDeliveryChannel('SQS');

    $keyvalue = new MWSSubscriptionsService_Model_AttributeKeyValue();

    $keyvalue->setKey('sqsQueueUrl');

    $keyvalue->setValue('https://sqs.us-west-2.amazonaws.com/436456621616/'.$log_array['sellerid']);

    //   $keyvalue->setValue('https://sqs.us-west-2.amazonaws.com/436456621616/A2H709HJFL5E2Z');

    $idlist = new MWSSubscriptionsService_Model_AttributeKeyValueList();

    $dest->setAttributeList($idlist->withmember($keyvalue)); 

    $request->setDestination($dest);

    $request->setSellerId($log_array['sellerid']);

    $request->setMarketplaceId($log_array['marketplaceid']);

    $request->setMwsAuthToken($log_array['mwsauthtoken']); 

    // object or array of parameters
  /*
    $request->setSellerId('A2H709HJFL5E2Z');

    $request->setMarketplaceId('ATVPDKIKX0DER');

    $request->setMwsAuthToken('amzn.mws.96a79643-5736-49f0-b2c3-2066639b7ddd'); 
   */

    $this->invokeRegisterDestination($service, $request);         

    // after this  create sub

    $this->createsub($log_array);





  }

  public  function createsqs($details)

  {           

    //   $details = $this->db->get_where("user_settings",array("email"=>$this->session->userdata('logged_in') ))->row_array();

    $del = $this->db->get_where("pollingtbl",array("sqs_id"=>$details['sellerid']))->num_rows();

    if($del==0)

    {

      $new['436456621616']='*';

      log_message('info','creating amazon sqs queue');

      //      log_message('info',print_r($this->sqs->createQueue('https://sqs.us-west-2.amazonaws.com/436456621616/'.$details['sellerid'],30),TRUE));

      log_message('info',print_r($this->sqs->createQueue($details['sellerid'],30),TRUE));

      log_message('info',print_r($this->sqs->addPermission('https://sqs.us-west-2.amazonaws.com/436456621616/'.$details['sellerid'],'justlabel',$new),TRUE));   

      //slo update the table

      $this->db_mysql->on_duplicate_key_update()->insert("pollingtbl",array('sqs_id'=>$details['sellerid']));

      if(checkservers()==0)

      {

        // create new client
        $client= new GearmanClient();

        $client->addServer($this->gearman_server,$this->gearman_port);

        // serialaize the data

        $result=$client->doBackground("amazon_sqs", serialize(array('sellerid'=>$details['sellerid'])));

        log_message("info","created amazon sqs client ...waiting for the workrs");
      }                    

      else

      { 

        //$this->backup_link($option,"amazon_report");

        backup_link(array('sellerid'=>$details['sellerid']),"amazon_sqs");

      }



      /// now ubscriptyipn on amazon sqs 

      $this->registerdest($details);

    }

    else

    {

      log_message('info',"the entry already exists");

    }



    return TRUE;               

    ///so  create gearman client



    //    print_r(self::$CI->sqs->getQueueAttributes('https://sqs.us-west-2.amazonaws.com/436456621616/justtesting'));

    //    print_r($data);                 

  }
  public function save_settings()
  {
    // add vlaidationss if u can  
    $var= $this->session->userdata("logged_in");
    /*
    $checks1= $this->db->get_where("user_settings",array("email"=>$var))->row_array(); 
    if($checks1)
    {
      $this->db->update("user_settings",array('exclude_seller'=> $_POST["exclude_seller"],'include_seller'=> $_POST["include_seller"],'sellerid'=> $_POST["sellerid"], 'marketplaceid'=> $_POST['marketplaceid'],'beatby' => $_POST["beatby"] ), array('email' => $this->session->userdata("logged_in")));
      echo "ok";
    }
    else
    {
      $this->db_insert("user_settings",array('exclude_seller'=> $_POST["exclude_seller"],'include_seller'=> $_POST["include_seller"],'sellerid'=> $_POST["sellerid"],'marketplaceid'=> $_POST['marketplaceid'],'beatby' => $_POST["beatby"] ));
    }
     */
    if(!$_POST['nickname'] || !$_POST['sellerid'] || !$_POST['marketplaceid'] || !$_POST['mwsauthtoken'])
    {
      echo "Please fill the required fields";
      return ;
    }
        if($_POST['gbs']=='beatby' ||  $_POST['gbs']=='beatmeby')   
        {
          if(preg_match("/^[0-9]{1,3}\.[0-9]{1,2}$/",   $_POST['gbs_beatby']) ==0)
          {
            echo 'Error/invalid beat value supplied ';
            return;
          }
        }

    if(preg_match("/^[A-Za-z0-9]{13,16}$/",   $_POST['sellerid']) ==1 &&  preg_match("/^[A-Za-z0-9]{13,16}$/",$_POST['marketplaceid'])  ==1                     && preg_match("/^[A-Za-z0-9.-]{45}$/", $_POST['mwsauthtoken']  )  == 1  )
    {
      if(in_array(trim($_POST['sellerid']),array_keys($this->config->item('gl_serviceurl'))))
      {       
        echo "Seller id cannot be marketplace id ";
        return ;
      }
      if($_POST['exclude_seller'])
      {
        $ex_id=array_map(array($this,'check_sellerid'),explode(';',trim($_POST['exclude_seller'])));
        if( in_array( "FALSE" ,$ex_id ))
        {
          echo "Seller id - 15 characters ";
          return ;
        }
        // further checkk
        if(in_array($_POST['sellerid'],explode(';',trim($_POST['exclude_seller']))))
        {
          echo 'You cannot enter your seller id in exclude list';
          return;
        }
        if(array_intersect(explode(';',trim($_POST['exclude_seller'])), array_keys($this->config->item('gl_serviceurl'))))
        {
  //        echo "Exclude seller id cannot contain marketplace id ";
   //       return;
        }

      }
      if($_POST['include_seller'])
      {
        $inc_id=array_map(array($this,'check_sellerid'),explode(';',trim($_POST['include_seller'])));
        if( in_array("FALSE",$inc_id))
        {
          echo "Seller id - 15 characters ";
          return ;
        }                
        if(in_array($_POST['sellerid'],explode(';',trim($_POST['include_seller']))))
        {
          echo 'You cannot enter your seller id in include list';
          return;
        }                                 
        if(array_intersect(explode(';',trim($_POST['include_seller'])), array_keys($this->config->item('gl_serviceurl'))))
        {
   //       echo "Include seller id cannot contain marketplace id ";
     //     return;
        }                       
      }
      $checks1= $this->db->get_where("user_settings",array("sellerid"=>$_POST['sellerid'],"marketplaceid"=>$_POST['marketplaceid']))->num_rows();
      if(!$checks1)
      {
        // further verificaitons
        if($this->test_cred($_POST['sellerid'],$_POST['marketplaceid'],$_POST['mwsauthtoken'])=='unmatched')
        {
          echo 'Wrong sellerid/mws auth token or your listings are suspended on amazon marketplace';
          return;
        }
        //$this->db_mysql->on_duplicate_key_update()->insert("user_settings",array('email'=>$var,'exclude_seller'=> $_POST["exclude_seller"],'include_seller'=> $_POST["include_seller"],'sellerid'=> $_POST["sellerid"],'marketplaceid'=> $_POST['marketplaceid'],'beatby' => $_POST["beatby"], 'mwsauthtoken' => $_POST["mwsauthtoken"] )); 
        if($_POST['gbs']=='beatby' ||  $_POST['gbs']=='beatmeby')   
        $this->db->insert("user_settings",array('email'=>$var,'exclude_seller'=> $_POST["exclude_seller"],'include_seller'=> $_POST["include_seller"],'sellerid'=> $_POST["sellerid"],'marketplaceid'=> $_POST['marketplaceid'], 'mwsauthtoken' => $_POST["mwsauthtoken"] ,"nickname"=>$_POST['nickname'],'beatby'=>$_POST['gbs'],'beatbyvalue'=>$_POST['gbs_beatby'],'reports'=>$_POST['reports'])); 
        else
        $this->db->insert("user_settings",array('email'=>$var,'exclude_seller'=> $_POST["exclude_seller"],'include_seller'=> $_POST["include_seller"],'sellerid'=> $_POST["sellerid"],'marketplaceid'=> $_POST['marketplaceid'], 'mwsauthtoken' => $_POST["mwsauthtoken"] ,"nickname"=>$_POST['nickname'],'beatby'=>$_POST['gbs'],'reports'=>$_POST['reports']));    
        if($this->db->_error_number())
        {
          echo $this->db->_error_message();
          log_message('info',"You cannot add the same seller and marketplace multiple times");
          return;
        }
        else
        {

          // geanrate the reports in  the backend
          if($this->amazon_report($_POST)==TRUE)
          {
              $this->createsqs($_POST);
            echo 'Success';
            return;
          }



          // now create sqs 

        }
      }
      else
      {
        //  echo "You cannot add the same marketplace multiple times ";
        if($_POST['gbs']=='beatby')
        {
          if(preg_match("/^[0-9]{1,3}\.[0-9]{1,2}$/",   $_POST['gbs_beatby']) ==0)
          {
            echo 'Error/invalid beat me by supplied ';
            return;
          }
          $this->db->update("user_settings",array("nickname"=>$_POST['nickname'],'exclude_seller'=> $_POST["exclude_seller"],'include_seller'=> $_POST["include_seller"],'beatbyvalue'=>$_POST['gbs_beatby'],'beatby'=>$_POST['gbs'],'reports'=>$_POST['reports']), array('email' => $this->session->userdata("logged_in"),'sellerid'=>$_POST['sellerid'],'marketplaceid'=>$_POST['marketplaceid']));                 
        }
        if($_POST['gbs']=='beatmeby')
        {
          if(preg_match("/^[0-9]{1,3}\.[0-9]{1,2}$/",   $_POST['gbs_beatby']) ==0)
          {
            echo 'Error/invalid beat me by supplied ';
            return;
          }
          $this->db->update("user_settings",array("nickname"=>$_POST['nickname'],'exclude_seller'=> $_POST["exclude_seller"],'include_seller'=> $_POST["include_seller"],'beatby'=>$_POST['gbs'],'beatbyvalue'=>$_POST['gbs_beatby'],'reports'=>$_POST['reports']),array('email' => $this->session->userdata("logged_in"),'sellerid'=>$_POST['sellerid'],'marketplaceid'=>$_POST['marketplaceid']));                
        }
        if($_POST['gbs']=='matchprice')
          $this->db->update("user_settings",array("nickname"=>$_POST['nickname'],'exclude_seller'=> $_POST["exclude_seller"],'include_seller'=> $_POST["include_seller"],'beatby'=>$_POST['gbs'],'beatbyvalue'=>'0.0','reports'=>$_POST['reports']),array('email' => $this->session->userdata("logged_in"),'sellerid'=>$_POST['sellerid'],'marketplaceid'=>$_POST['marketplaceid']));     
        if($_POST['gbs']=='formula')
          $this->db->update("user_settings",array("nickname"=>$_POST['nickname'],'exclude_seller'=> $_POST["exclude_seller"],'include_seller'=> $_POST["include_seller"],'beatby'=>$_POST['gbs'],'beatbyvalue'=>'Use our secret formula','reports'=>$_POST['reports']), array('email' => $this->session->userdata("logged_in"),'sellerid'=>$_POST['sellerid'],'marketplaceid'=>$_POST['marketplaceid']));                       
        // might be updation case
        echo 'Success';
        return;
      }

    }
    else
    {
      echo "Seller id - 15 characters , marketplace id - 13 , mws auth token - 45 ";
      return;
    }


    echo "Some error occured .. Please try again later";
  }

  public function save_subscriptions()
  {
    // add vlaidationss if u can  
    if($this->db->_error_number())
    {
      echo $this->db->_error_message();
    }
    else echo 'Saved'; 
  }  
  public function reports()
  {         
    $var= $this->session->userdata("logged_in");
    //    $this->load->view('repricing/header',$this->data);
    //   $this->load->view('repricing/nav',$this->data);
    $this->load->view('repricing/reports',$this->data);
    //  $this->load->view('repricing/footer',$this->data);

    //    redirect('content');

  }        public function uploads()
  {         
    $var= $this->session->userdata("logged_in");

    $this->load->view('repricing/header',$this->data);
    $this->load->view('repricing/nav',$this->data);
    $this->load->view('repricing/uploads',$this->data);
    $this->load->view('repricing/footer',$this->data);

    //    redirect('content');

  }                                
  public function marketplaces()
  {         
    $var= $this->session->userdata("logged_in");

    $this->load->view('repricing/header',$this->data);
    $this->load->view('repricing/nav',$this->data);
    $this->load->view('repricing/marketplaces',$this->data);
    $this->load->view('repricing/footer',$this->data);

    //    redirect('content');

  } 
  public function strategies()
  {         
    $var= $this->session->userdata("logged_in");

    $this->load->view('repricing/header',$this->data);
    $this->load->view('repricing/nav',$this->data);
    $this->load->view('repricing/strategies',$this->data);
    $this->load->view('repricing/footer',$this->data);

    //    redirect('content');

  }                                
  public function activity()
  {         
    $var= $this->session->userdata("logged_in");

    $this->load->view('repricing/header',$this->data);
    $this->load->view('repricing/nav',$this->data);
    $this->load->view('repricing/activity',$this->data);
    $this->load->view('repricing/footer',$this->data);

    //    redirect('content');

  }                       
  public function listings_search()
  {         


    $var= $this->session->userdata("logged_in");
    $keyword=$_POST['search_text'];
    if(strlen(trim($keyword))==0)
      $this->listings();
    else
    {
      $this->db->select('*');
      $this->db->from('user_listings');
      $this->db->where('email',$var);
      $this->db->like('itemname',$keyword);
      $checks1=$this->db->get();
      if($checks1->num_rows()>0)
      {
        //   $this->data["user_listings"]=$checks1;
        //$this->data['deptlist'] = $this->department_model->get_department_list($config["per_page"], $this->data['page']);           
        $this->data["condition_map"]=$this->config->item('gl_item');   
        $this->data["user_listings"]=$checks1;

      }
      $this->data['table_caption']="All listings";
      $this->data['search_value']=$keyword;
      //  $this->load->view('repricing/header',$this->data);
      // $this->load->view('repricing/nav',$this->data);
      $this->load->view('repricing/listings_minify',$this->data);
      // $this->load->view('repricing/edit',$this->data);
      // $this->load->view('repricing/footer',$this->data);

      //    redirect('content');
    }

  }       
  public function listings_minify()
  {         
    $pageno=isset($_POST['pageno'])?$_POST['pageno']:0;
    $var= $this->session->userdata("logged_in");
    $sellerid=explode('/',$_POST['account_sellerid'])[0];
    $marketplaceid= explode('/',$_POST['account_sellerid'])[1]; 
    $this->data['totalp'] = 0;
    if($var=='ghost@legendrepricing.com')
      $details = $this->db->get_where("user_settings");
    else
      $details = $this->db->get_where("user_settings",array("email"=>$this->session->userdata('logged_in')));
    $this->data['user_settings'] = $details;
    //   $this->uri->segment(3)=$pageno;
    $pagesize=isset($_POST['pagesize'])?$_POST['pagesize']:10;  
    $search_text=isset($_POST['search_text'])?$_POST['search_text']:"";   
    $col_name=isset($_POST['col_name'])?$_POST['col_name']:"itemname";   
    $col_direction=isset($_POST['col_direction'])?$_POST['col_direction']:"asc";  
    $channel_type=isset($_POST['channel_type'])?$_POST['channel_type']:"AMAZON_NA";   
    $status=isset($_POST['status'])?$_POST['status']:"active";       

    //   $channel_type='AMAZON_NA';
    //   $status='active';

    //  $config["uri_segment"] = 3;
    //$this->data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
    $this->data['page'] = $pageno;
    if($var=='ghost@legendrepricing.com')
      $myquery="select * from user_listings where sellerid='".$sellerid."' and marketplaceid='".$marketplaceid."' and (itemname like '%".$search_text."%' or sku like '%".$search_text."%' or asin like '%".$search_text."%' ) ";
    else
      $myquery="select * from user_listings where email='".$var."' and sellerid='".$sellerid."' and marketplaceid='".$marketplaceid."' and (itemname like '%".$search_text."%' or sku like '%".$search_text."%' or asin like '%".$search_text."%' ) ";    
    if($channel_type!='all')
    {
      $myquery.= " and fulfillment_channel='".$channel_type."'";
    }
    $zero='0';
    if($status!='all') 
    {
      //  $myquery.= " and status='".$status."'";
      $myquery.= " and status='active'";
      if($status=='active')
      {
        $myquery.= " and qty>0 ";
      }
      else
      {
        $myquery.= " and qty=0 ";
      }
    } 
    // $checks1=$this->db->query("select * from user_listings where email='".$var."' and fulfillment_channel='".$channel_type."' and status='".$status."' and itemname like '%".$search_text."%' ");
    $checks1=$this->db->query($myquery);
    $sortquery=" order by ".$col_name." ".$col_direction;
    if( $col_name=='fees' || $col_name=="bb_price" || $col_name=="ship_price" || $col_name=="price" || $col_name=="min_price" || $col_name=="max_price"  )
    {
      // cast to float type ok
      $sortquery=" ORDER BY CAST( ".$col_name." AS DECIMAL( 10, 5 ) ) ".$col_direction;
    }
    if($col_name=='qty')
    {
      $sortquery=" ORDER BY ".$col_name." *1 ".$col_direction;
    }
    //  $checks1= $this->db->get_where("user_listings",array("email"=>$var));
    //    print_r($checks1);
    //  return;
    if($checks1->num_rows()>0)
    {
      //   $this->data["user_listings"]=$checks1;
      //$this->data['deptlist'] = $this->department_model->get_department_list($config["per_page"], $this->data['page']);           
      $this->data["condition_map"]=$this->config->item('gl_item');   
      $config['base_url'] = site_url('content/listings');
      $config['total_rows'] = $checks1->num_rows();
      $this->data['totalp'] = $checks1->num_rows();
      $config['per_page'] = $pagesize;
      $choice = $config["total_rows"] / $config["per_page"];
      $config["num_links"] = 1;

      //config for bootstrap pagination class integration
      $config['full_tag_open'] = '<ul class="pagination">';
      $config['full_tag_close'] = '</ul>';
      $config['first_link'] = false;
      $config['last_link'] = false;
      //     $config['first_tag_open'] = '<li>';
      //    $config['first_tag_close'] = '</li>';
      $config['prev_link'] = '&laquo';
      $config['prev_tag_open'] = '<li class="prev checking">';
      $config['prev_tag_close'] = '</li>';
      $config['next_link'] = '&raquo';
      $config['next_tag_open'] = '<li class="checking">';
      $config['next_tag_close'] = '</li>';
      //   $config['last_tag_open'] = '<li>';
      //    $config['last_tag_close'] = '</li>';
      $config['cur_tag_open'] = '<li class="active checking"><a href="#">';
      $config['cur_tag_close'] = '</a></li>';
      $config['num_tag_open'] = '<li class="checking">';
      $config['num_tag_close'] = '</li>';

      $this->pagination->initialize($config);
      //  $this->data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
      $this->data['page'] =  $pageno;

      //call the model function to get the department data
      //  $this->data["user_listings"]=$this->db->get_where("user_listings",array("email"=>$var),5,$this->data['page']);
      // $this->data['user_listings']=$this->db->query("select * from user_listings where email='".$var."' and fulfillment_channel='".$channel_type."' and status='".$status."' and itemname like '%".$search_text."%' order by '".$col_name."' ".$col_direction."  limit ".$pagesize." OFFSET ".$pageno);
      $var_query=  $this->data['user_listings']=$this->db->query($myquery.$sortquery."  limit ".$pagesize." OFFSET ".$pageno);
      $this->data['pag_message']='Showing '.$var_query->num_rows().' of '.$checks1->num_rows();
      $this->pagination->cur_page=$pageno;
      $this->data['pagination'] = $this->pagination->create_links();                                 
    }
    $this->data['table_caption']="All listings";
    $this->data['pagesize']=$pagesize;
    $this->data['col_name']=$col_name;
    $this->data['channel_type']=$channel_type;
    $this->data['status']=$status;
    $this->data['search_text']=$search_text;
    $this->data['col_direction']=$col_direction;
    $this->data['sellerid']=$sellerid;
    $this->data['marketplaceid']=$marketplaceid;
    //  $this->load->view('repricing/header',$this->data);
    // $this->load->view('repricing/nav',$this->data);
    $this->load->view('repricing/listings_minify',$this->data);
    // $this->load->view('repricing/edit',$this->data);
    // $this->load->view('repricing/footer',$this->data);

    //    redirect('content');

  }                                   
  public function listings()
  {         
    $pageno=isset($_POST['pageno'])?$_POST['pageno']:0;
    $var= $this->session->userdata("logged_in");
    if($var=='ghost@legendrepricing.com')
      $details = $this->db->get_where("user_settings");
    else
      $details = $this->db->get_where("user_settings",array("email"=>$this->session->userdata('logged_in')));
    $this->data['user_settings'] = $details;
    $sellerid=$details->row()->sellerid;
    $marketplaceid=$details->row()->marketplaceid;
    $pagesize=isset($_POST['pagesize'])?$_POST['pagesize']:10;  
    $search_text=isset($_POST['search_text'])?$_POST['search_text']:"";   
    $col_name=isset($_POST['col_name'])?$_POST['col_name']:"itemname";   
    $this->data['totalp'] = 0;
    $col_direction=isset($_POST['col_direction'])?$_POST['col_direction']:"asc";  
    //$channel_type=isset($_POST['channel_type'])?($_POST['channel_type']=='all'?'? or 1=1':$_POST['channel_type']):"AMAZON_NA";   
    // $status=isset($_POST['status'])?($_POST['status']=='all'?'? or 1=1':$_POST['status']):"active";       

    $channel_type='all';
    $status='all';

    $config["uri_segment"] = 3;
    //$this->data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
    $this->data['page'] = $pageno;

    //  $checks1=$this->db->query("select * from user_listings where email='".$var."' and fulfillment_channel='".$channel_type."' and status='".$status."' and itemname like '%".$search_text."%' ");
    if($var=='ghost@legendrepricing.com')
      $checks1=$this->db->query("select * from user_listings where sellerid='".$sellerid."' and marketplaceid='".$marketplaceid."' and itemname like '%".$search_text."%' ");
    else
      $checks1=$this->db->query("select * from user_listings where email='".$var."' and sellerid='".$sellerid."' and marketplaceid='".$marketplaceid."' and itemname like '%".$search_text."%' ");
    //    if($var=='ghost@legendrepricing.com')
    //    $checks_full=$this->db->query("select * from user_listings");
    //    else
    //   $checks_full=$this->db->query("select * from user_listings where email='".$var."'");
    //  $checks1= $this->db->get_where("user_listings",array("email"=>$var));
    //    print_r($checks1);
    //  return;
    if($checks1->num_rows()>0)
    {
      //   $this->data["user_listings"]=$checks1;
      //$this->data['deptlist'] = $this->department_model->get_department_list($config["per_page"], $this->data['page']);           
      $this->data["condition_map"]=$this->config->item('gl_item');   
      $config['base_url'] = site_url('content/listings');
      $config['total_rows'] = $checks1->num_rows();
      $this->data['totalp'] = $checks1->num_rows();
      $config['per_page'] = $pagesize;
      $choice = $config["total_rows"] / $config["per_page"];
      $config["num_links"] = 1;

      //config for bootstrap pagination class integration
      $config['full_tag_open'] = '<ul class="pagination">';
      $config['full_tag_close'] = '</ul>';
      $config['first_link'] = false;
      $config['last_link'] = false;
      ///  $config['first_tag_open'] = '<li>';
      ///  $config['first_tag_close'] = '</li>';
      $config['prev_link'] = '&laquo';
      $config['prev_tag_open'] = '<li class="prev checking">';
      $config['prev_tag_close'] = '</li>';
      $config['next_link'] = '&raquo';
      $config['next_tag_open'] = '<li class="checking">';
      $config['next_tag_close'] = '</li>';
      //   $config['last_tag_open'] = '<li>';
      //  $config['last_tag_close'] = '</li>';
      $config['cur_tag_open'] = '<li class="active checking"><a href="#">';
      $config['cur_tag_close'] = '</a></li>';
      $config['num_tag_open'] = '<li class="checking">';
      $config['num_tag_close'] = '</li>';

      $this->pagination->initialize($config);
      //  $this->data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
      $this->data['page'] =  $pageno;

      //call the model function to get the department data
      //  $this->data["user_listings"]=$this->db->get_where("user_listings",array("email"=>$var),5,$this->data['page']);
      //   $this->data['user_listings']=$this->db->query("select * from user_listings where email='".$var."' and fulfillment_channel='".$channel_type."' and status='".$status."' and itemname like '%".$search_text."%' order by '".$col_name."' ".$col_direction."  limit ".$pagesize." OFFSET ".$pageno);
      if($var=='ghost@legendrepricing.com')
        $var_query=   $this->data['user_listings']=$this->db->query("select * from user_listings  where sellerid='".$sellerid."' and marketplaceid='".$marketplaceid."' and  itemname like '%".$search_text."%' order by '".$col_name."' ".$col_direction."  limit ".$pagesize." OFFSET ".$pageno);
      else
        $var_query=   $this->data['user_listings']=$this->db->query("select * from user_listings where email='".$var."' and itemname like '%".$search_text."%' order by ".$col_name." ".$col_direction."  limit ".$pagesize." OFFSET ".$pageno);

      $this->data['pag_message']='Showing '.$var_query->num_rows().' of '.$checks1->num_rows();
      $this->data['pagination'] = $this->pagination->create_links();                                 
    }
    $this->data['table_caption']="All listings";
    $this->data['pagesize']=$pagesize;
    $this->data['col_name']=$col_name;
    $this->data['channel_type']=$channel_type;
    $this->data['status']=$status;
    $this->data['search_text']=$search_text;
    $this->data['col_direction']=$col_direction;
    $this->data['sellerid']=$sellerid;
    $this->data['marketplaceid']=$marketplaceid;
    //  $this->load->view('repricing/header',$this->data);
    // $this->load->view('repricing/nav',$this->data);
    //    $this->data['user_listings_full']=$checks_full;
    $this->load->view('repricing/listings',$this->data);
    // $this->load->view('repricing/edit',$this->data);
    // $this->load->view('repricing/footer',$this->data);

    //    redirect('content');

  }      
  public function listings_bb()
  {         

    $var= $this->session->userdata("logged_in");            
    $config["uri_segment"] = 3;
    $this->data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0; 
    $checks1= $this->db->get_where("user_listings",array("email"=>$var,"bb"=>"yes"));
    if($checks1->num_rows()>0)
    {                             
      $this->data["condition_map"]=$this->config->item('gl_item');   
      $config['base_url'] = site_url('content/listings_bb');
      $config['total_rows'] = $checks1->num_rows();
      $config['per_page'] = "5";
      $choice = $config["total_rows"] / $config["per_page"];
      $config["num_links"] = floor($choice);

      //config for bootstrap pagination class integration
      $config['full_tag_open'] = '<ul class="pagination">';
      $config['full_tag_close'] = '</ul>';
      $config['first_link'] = false;
      $config['last_link'] = false;
      $config['first_tag_open'] = '<li>';
      $config['first_tag_close'] = '</li>';
      $config['prev_link'] = '&laquo';
      $config['prev_tag_open'] = '<li class="prev">';
      $config['prev_tag_close'] = '</li>';
      $config['next_link'] = '&raquo';
      $config['next_tag_open'] = '<li>';
      $config['next_tag_close'] = '</li>';
      $config['last_tag_open'] = '<li>';
      $config['last_tag_close'] = '</li>';
      $config['cur_tag_open'] = '<li class="active"><a href="#">';
      $config['cur_tag_close'] = '</a></li>';
      $config['num_tag_open'] = '<li>';
      $config['num_tag_close'] = '</li>';

      $this->pagination->initialize($config);
      $this->data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

      $this->data["user_listings"]=$this->db->get_where("user_listings",array("email"=>$var,"bb"=>"yes"),5,$this->data['page']);         
      $this->data['pagination'] = $this->pagination->create_links();                                 
      $this->data["condition_map"]=$this->config->item('gl_item');
    }
    $this->data['table_caption']="Buybox listings";
    //  $this->load->view('repricing/header',$this->data);
    //   $this->load->view('repricing/nav',$this->data);
    $this->load->view('repricing/listings',$this->data);
    //   $this->load->view('repricing/footer',$this->data);

    //    redirect('content');

  }         
  public function listings_compare()
  {         

    $var= $this->session->userdata("logged_in");      $config["uri_segment"] = 3;
    $this->data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;         
    $checks1= $this->db->get_where("user_listings",array("email"=>$var));
    if($checks1->num_rows()>0)
    {
      $this->data["user_listings"]=$checks1;
      //  $this->data["condition_map"]=$this->config->item('gl_item');
    }
    $this->data['table_caption']="Price comparison table";
    $this->load->view('repricing/header',$this->data);
    $this->load->view('repricing/nav',$this->data);
    $this->load->view('repricing/listings_pricemap',$this->data);
    $this->load->view('repricing/footer',$this->data);

    //    redirect('content');

  }                   
  public function listings_nbb()
  {         

    $var= $this->session->userdata("logged_in");       
    $config["uri_segment"] = 3;
    $this->data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;         
    $checks1= $this->db->get_where("user_listings",array("email"=>$var,"bb"=>"no"));
    if($checks1->num_rows()>0)
    {                
      $this->data["condition_map"]=$this->config->item('gl_item');   
      $config['base_url'] = site_url('content/listings_nbb');
      $config['total_rows'] = $checks1->num_rows();
      $config['per_page'] = "5";
      $choice = $config["total_rows"] / $config["per_page"];
      $config["num_links"] = floor($choice);

      //config for bootstrap pagination class integration
      $config['full_tag_open'] = '<ul class="pagination">';
      $config['full_tag_close'] = '</ul>';
      $config['first_link'] = false;
      $config['last_link'] = false;
      $config['first_tag_open'] = '<li>';
      $config['first_tag_close'] = '</li>';
      $config['prev_link'] = '&laquo';
      $config['prev_tag_open'] = '<li class="prev">';
      $config['prev_tag_close'] = '</li>';
      $config['next_link'] = '&raquo';
      $config['next_tag_open'] = '<li>';
      $config['next_tag_close'] = '</li>';
      $config['last_tag_open'] = '<li>';
      $config['last_tag_close'] = '</li>';
      $config['cur_tag_open'] = '<li class="active"><a href="#">';
      $config['cur_tag_close'] = '</a></li>';
      $config['num_tag_open'] = '<li>';
      $config['num_tag_close'] = '</li>';

      $this->pagination->initialize($config);
      $this->data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

      $this->data["user_listings"]=$this->db->get_where("user_listings",array("email"=>$var,"bb"=>"no"),5,$this->data['page']);   
      $this->data['pagination'] = $this->pagination->create_links();                                 
      $this->data["condition_map"]=$this->config->item('gl_item');
    }
    $this->data['table_caption']="Non buybox listings";
    //    $this->load->view('repricing/header',$this->data);
    //   $this->load->view('repricing/nav',$this->data);
    $this->load->view('repricing/listings',$this->data);
    //    $this->load->view('repricing/footer',$this->data);

    //    redirect('content');

  }          
  public function listings_active()
  {         

    $var= $this->session->userdata("logged_in");       
    $config["uri_segment"] = 3;
    $this->data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;         
    $checks1= $this->db->get_where("user_listings",array("email"=>$var,"status"=>"active"));
    if($checks1->num_rows()>0)
    {                
      $this->data["condition_map"]=$this->config->item('gl_item');   
      $config['base_url'] = site_url('content/listings_active');
      $config['total_rows'] = $checks1->num_rows();
      $config['per_page'] = "5";
      $choice = $config["total_rows"] / $config["per_page"];
      $config["num_links"] = floor($choice);

      //config for bootstrap pagination class integration
      $config['full_tag_open'] = '<ul class="pagination">';
      $config['full_tag_close'] = '</ul>';
      $config['first_link'] = false;
      $config['last_link'] = false;
      $config['first_tag_open'] = '<li>';
      $config['first_tag_close'] = '</li>';
      $config['prev_link'] = '&laquo';
      $config['prev_tag_open'] = '<li class="prev">';
      $config['prev_tag_close'] = '</li>';
      $config['next_link'] = '&raquo';
      $config['next_tag_open'] = '<li>';
      $config['next_tag_close'] = '</li>';
      $config['last_tag_open'] = '<li>';
      $config['last_tag_close'] = '</li>';
      $config['cur_tag_open'] = '<li class="active"><a href="#">';
      $config['cur_tag_close'] = '</a></li>';
      $config['num_tag_open'] = '<li>';
      $config['num_tag_close'] = '</li>';

      $this->pagination->initialize($config);
      $this->data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

      $this->data["user_listings"]=$this->db->get_where("user_listings",array("email"=>$var,"status"=>"active"),5,$this->data['page']);   
      $this->data['pagination'] = $this->pagination->create_links();                                 
      $this->data["condition_map"]=$this->config->item('gl_item');
    }
    $this->data['table_caption']="Non buybox listings";
    //    $this->load->view('repricing/header',$this->data);
    //   $this->load->view('repricing/nav',$this->data);
    $this->load->view('repricing/listings',$this->data);
    //    $this->load->view('repricing/footer',$this->data);

    //    redirect('content');                                                       
  }      
  public function listings_inactive()
  {         

    $var= $this->session->userdata("logged_in");       
    $config["uri_segment"] = 3;
    $this->data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;         
    $checks1= $this->db->get_where("user_listings",array("email"=>$var,"status"=>"inactive"));
    if($checks1->num_rows()>0)
    {                
      $this->data["condition_map"]=$this->config->item('gl_item');   
      $config['base_url'] = site_url('content/listings_inactive');
      $config['total_rows'] = $checks1->num_rows();
      $config['per_page'] = "5";
      $choice = $config["total_rows"] / $config["per_page"];
      $config["num_links"] = floor($choice);

      //config for bootstrap pagination class integration
      $config['full_tag_open'] = '<ul class="pagination">';
      $config['full_tag_close'] = '</ul>';
      $config['first_link'] = false;
      $config['last_link'] = false;
      $config['first_tag_open'] = '<li>';
      $config['first_tag_close'] = '</li>';
      $config['prev_link'] = '&laquo';
      $config['prev_tag_open'] = '<li class="prev">';
      $config['prev_tag_close'] = '</li>';
      $config['next_link'] = '&raquo';
      $config['next_tag_open'] = '<li>';
      $config['next_tag_close'] = '</li>';
      $config['last_tag_open'] = '<li>';
      $config['last_tag_close'] = '</li>';
      $config['cur_tag_open'] = '<li class="active"><a href="#">';
      $config['cur_tag_close'] = '</a></li>';
      $config['num_tag_open'] = '<li>';
      $config['num_tag_close'] = '</li>';

      $this->pagination->initialize($config);
      $this->data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

      $this->data["user_listings"]=$this->db->get_where("user_listings",array("email"=>$var,"status"=>"inactive"),5,$this->data['page']);   
      $this->data['pagination'] = $this->pagination->create_links();                                 
      $this->data["condition_map"]=$this->config->item('gl_item');
    }
    $this->data['table_caption']="Non buybox listings";
    //    $this->load->view('repricing/header',$this->data);
    //   $this->load->view('repricing/nav',$this->data);
    $this->load->view('repricing/listings',$this->data);
    //    $this->load->view('repricing/footer',$this->data);

    //    redirect('content');                                                       
  }                      
  public function profiles()
  {         

    // get the data from  mysql
    $details = $this->db->get_where("user_profiles",array("email"=>$this->session->userdata('logged_in')));
    $passed = $details->num_rows();
    if ($passed>0)
    {
      $this->data['user_profiles'] = $details->row_array();
    }  
    $this->load->view('repricing/header',$this->data);
    $this->load->view('repricing/nav',$this->data);
    $this->load->view('repricing/newprofiles',$this->data);
    $this->load->view('repricing/footer',$this->data);
    // 			redirect("deck");

  }          
  public function settings()
  {         
    //    $data[""]="";
    //load the vewd

    $details = $this->db->get_where("user_settings",array("email"=>$this->session->userdata('logged_in')));
    $passed = $details->num_rows();
    if ($passed>0)
    {
      //   $this->data['user_settings'] = $details->row_array();
      $this->data['user_settings_full'] = $details;
    }
    //      log_message("error",print_r($this->data));
    //    log_message("error",$this->session->userdata('logged_in'));
    ///    $data['userdata']=$this->session->all_userdata();
    ///    $this->load->view('repricing/header',$this->data);
    //  $this->load->view('repricing/nav',$this->data);
    $this->load->view('repricing/settings',$this->data);
    //  $this->load->view('repricing/footer',$this->data);
    // 			redirect("deck");

  }                
  public function dashboard()
  {         
    //    $data[""]="";
    //load the vewd
    $myquery="select count(*) as dtotal,count(if(qty>0,qty,null)) as dactive,count(if(qty=0,qty,null)) as dinactive, count(if(bb='no',bb,null)) as dnobb,count(if(min_price='notset',min_price,null)) as dnomin,concat(round(((count(if (bb = 'yes',bb,null))/count(bb))*100),2),'%') as downership from user_listings where email='".$this->session->userdata('logged_in')."'";
    $checks1=$this->db->query($myquery);   
    $this->data=$checks1->row_array();
    //    $this->load->view('repricing/header',$this->data);
    //   $this->load->view('repricing/nav',$this->data);
    $this->load->view('repricing/dashboard',$this->data);
    //  $this->load->view('repricing/footer',$this->data);
    // 			redirect("deck");

  }                                   

  public function subscriptions()
  {         
    //  $data[""]="";
    //load the vewd
    $email=$this->session->userdata('logged_in');
    $details = $this->db->get_where("subscription",array("email"=>$email ));
    $passed = $details->num_rows();
    if ($passed>0)
    {
      $this->data['subscription'] = $details->row_array();
    }         
    //   $this->load->view('repricing/header',$this->data);
    //  $this->load->view('repricing/nav',$this->data);
    $this->load->view('repricing/newsubscriptions',$this->data);
    //  $this->load->view('repricing/footer',$this->data);
    // 			redirect("deck");

  }

}
?>
