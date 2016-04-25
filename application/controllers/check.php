<?php
class Check extends CI_Controller {  
  private static $CI;
  public function __construct(){

    parent::__construct();          
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
        echo("ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");

    } catch (MWSSubscriptionsService_Exception $ex) {
        echo("Caught Exception: " . $ex->getMessage() . "\n");
        /*
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
    $keyvalue->setValue('https://sqs.us-west-2.amazonaws.com/436456621616/A2H709HJFL5E2Z');
    $idlist = new MWSSubscriptionsService_Model_AttributeKeyValueList();
    $dest->setAttributeList($idlist->withmember($keyvalue));
    $sub->setDestination($dest);
    $request->setSubscription($sub);
    $request->setSellerId('A2H709HJFL5E2Z');
    $request->setMarketplaceId('ATVPDKIKX0DER');
    $request->setMwsAuthToken('amzn.mws.96a79643-5736-49f0-b2c3-2066639b7ddd');  
    // object or array of parameters
    $this->invokeCreateSubscription($service, $request);

  }     
  private  function invokeRegisterDestination(MWSSubscriptionsService_Interface $service, $request)
  {
    try {
      $response = $service->DeregisterDestination($request);

      //        echo ("Service Response\n");
      //      echo ("=============================================================================\n");

      $dom = new DOMDocument();
      $dom->loadXML($response->toXML());
      $dom->preserveWhiteSpace = false;
      $dom->formatOutput = true;
      $dom->saveXML();
      echo("ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");

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
    $request = new MWSSubscriptionsService_Model_DeregisterDestinationInput();
    $dest = new MWSSubscriptionsService_Model_Destination();
    $dest->setDeliveryChannel('SQS');
    $keyvalue = new MWSSubscriptionsService_Model_AttributeKeyValue();
    $keyvalue->setKey('sqsQueueUrl');
    //$keyvalue->setValue('https://sqs.us-west-2.amazonaws.com/436456621616/'.$log_array['sellerid']);
    $keyvalue->setValue('https://sqs.us-west-2.amazonaws.com/436456621616/A2H709HJFL5E2Z');
    $idlist = new MWSSubscriptionsService_Model_AttributeKeyValueList();
    $dest->setAttributeList($idlist->withmember($keyvalue)); 
    $request->setDestination($dest);
//    $request->setSellerId($log_array['sellerid']);
//    $request->setMarketplaceId($log_array['marketplaceid']);
//    $request->setMwsAuthToken($log_array['mwsauthtoken']); 
    // object or array of parameters
    $request->setSellerId('A2H709HJFL5E2Z');
    $request->setMarketplaceId('ATVPDKIKX0DER');
    $request->setMwsAuthToken('amzn.mws.96a79643-5736-49f0-b2c3-2066639b7ddd'); 
    $this->invokeRegisterDestination($service, $request);         
    // after this  create sub
//    $this->createsub($log_array);


  }                          
      public function createCsv($xml,$f)
{

  foreach ($xml->children() as $item) 
  {

    $hasChild = (count($item->children()) > 0)?true:false;

    if( ! $hasChild)
    {
      $put_arr = array($item->getName(),$item); 
      print_r($put_arr);
      fputcsv($f, $put_arr ,',','"');

    }
    else
    {
      $this->createCsv($item, $f);
    }
  }
 /// fclose($f);

}                  
  public function index11($sellerid,$sku)
  {
    self::$CI =& get_instance();  
    echo "teting";
    $attr['WaitTimeSeconds']=10;
    $result_array=$this->sqs->receiveMessage('https://sqs.us-west-2.amazonaws.com/436456621616/testing',1,null,$attr);

    foreach ($result_array['Messages'] as $mess)
    {
      // check the message id  ok
      //  echo $mess['MessageId'].PHP_EOL;
      // now body 
  //     echo $mess['Body'];
      $xml=simplexml_load_string($mess['Body']);
     // echo gettype($xml);
      print_r(($xml));
     // file_put_contents("test.xml", $xml);

      break;
    }   
    exit(0);
    //$filexml='test.xml';

//    if (file_exists($filexml)) 
    {
  //    $xml = simplexml_load_file($filexml);
      $f = fopen('/var/www/test.csv', 'w');
      if(isset($f))
        $this->createCsv($xml, $f);
      else 
        echo "ergftr";
      fclose($f);
    }

//print_r($result_array);



    exit(0);
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
    print_r($service);

    exit(0);
    $AmazonSNS = new AmazonSNS(AMAZON_ACCESS_KEY_ID, AMAZON_SECRET_ACCESS_KEY);

    // Create a Topic
    $topicArn = $AmazonSNS->createTopic('My New SNS Topic');

    // Set the Topic's Display Name (required)
    $AmazonSNS->setTopicAttributes($topicArn, 'DisplayName', 'My SNS Topic Display Name');

    // Subscribe to this topic
    $AmazonSNS->subscribe($topicArn, 'email', 'example@github.com');


    exit(0);

    self::$CI->load->model('repricing/listing_model', '', TRUE);
    self::$CI->listing_model->getakshay();
    return FALSE;
    echo backup_link('ergtr','tgtt');    
    return FALSE;
    $log_array=self::$CI->db->get_where("user_listings",array("sellerid"=>$sellerid,"sku"=>$sku))->row_array();
    if($log_array)
    {
      $okthen=self::$CI->db->escape($log_array['last_modified']);
      $diff=self::$CI->db->query("select TIMESTAMPDIFF(MINUTE,".$okthen.",NOW()) as mydiff")->row_array();
      log_message('info',"Currently checking ".$sellerid.$sku);
      if($diff['mydiff']>=10)
      {
        echo $diff['mydiff'];
        return TRUE;
      }
      return FALSE;
    }
    else
    {
      return TRUE;
    }                 

//    echo $this->config->item('us', 'marketplaceid');
    // log_message('error',"OK". __FUNCTION__);
  }
}

?>
