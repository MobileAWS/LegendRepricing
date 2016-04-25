<?php
    /********************************************
    PayPal API Module

    Defines all the global variables and the wrapper functions 
    ********************************************/

class Mypaypal extends CI_Controller
{                 
  private $data = array();                                     
  private $gearman_server='localhost';
  private $gearman_port='4730';

  private  $PROXY_HOST = '127.0.0.1';
  private     $PROXY_PORT = '808';
  private $current_plan=array('0'=>'free','50'=>'basic','100'=>'premium','150'=>'plus','200'=>'enterprise');
  //' are set to the selections made on the Integration Assistant 
  //'------------------------------------
  private $currencyCodeType = "USD";
  private  $paymentType = "Sale";
  #$paymentType = "Authorization";
  #$paymentType = "Order";

  //'------------------------------------
  //' The returnURL is the location where buyers return to when a
  //' payment has been succesfully authorized.
  //'
  //' This is set to the value entered on the Integration Assistant 
  //'------------------------------------
  private  $returnURL = "http://localhost/recurring/review.php";

  //'------------------------------------
  //' The cancelURL is the location buyers are sent to when they hit the
  //' cancel button during authorization of payment during the PayPal flow
  //'
  //' This is set to the value entered on the Integration Assistant 
  //'------------------------------------
  private  $cancelURL = "http://localhost/recurring/index.php";

  private    $SandboxFlag = true;

  private   $USE_PROXY = false;
  private  $version="64";            
//  private  $version="69";            
  //'------------------------------------
  //' PayPal API Credentials
  //' Replace <API_USERNAME> with your API Username
  //' Replace <API_PASSWORD> with your API Password
  //' Replace <API_SIGNATURE> with your Signature
  //'------------------------------------
  private    $API_UserName="jimmycarter256-facilitator_api1.gmail.com";
  private	$API_Password="L7DVN4KUWUWNNMN6";
  private   $API_Signature="AFcWxV21C7fd0v3bYYYRCpSSRl31AAWckHhGwkiiO5EmuMb4Xu-BJtL.";

  // BN Code 	is only applicable for partners
  private   $sBNCode = "PP-ECWizard";

  public function __construct(){

    parent::__construct();       
//    if(!$this->input->is_cli_request())
    {
      $this->load->library("form_validation");

      if(!$this->session->userdata("logged_in")) redirect("home");     
      $var= $this->session->userdata("logged_in");     
      $this->cancelURL=$this->config->base_url()."mypaypal/cancel";
      $this->returnURL=$this->config->base_url()."mypaypal/review";
      if ($this->SandboxFlag == true) 
      {
        $this->API_Endpoint = "https://api-3t.sandbox.paypal.com/nvp";
        $this->PAYPAL_URL = "https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=";
      }
      else
      {
        $this->API_Endpoint = "https://api-3t.paypal.com/nvp";
        $this->PAYPAL_URL = "https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=";
      }
    }    

  }


  private function GetRecurringPaymentsProfileDetails($profileid)
  {
    $nvpstr="&PROFILEID=".urlencode($profileid);
    $resArray=$this->hash_call("GetRecurringPaymentsProfileDetails",$nvpstr);
    $ack = strtoupper($resArray["ACK"]);
    return $resArray;                    
  }

  public function cancel()
  {

    $this->session->set_flashdata('error_messages_1','Cancel payment done');
    log_message('error', "Customer declined the payment");
    redirect('content/subscriptions');
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
    $this->createsub($log_array);


  }
  public  function createsqs()
  {           
    $details = $this->db->get_where("user_settings",array("email"=>$this->session->userdata('logged_in') ))->row_array();
    $del = $this->db->get_where("pollingtbl",array("sqs_id"=>$details['sellerid'] ))->num_rows();
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
  public function recurring_payment()
  {

    $resArray = $this->CreateRecurringPaymentsProfile($this->session->userdata('mypaymentamount'));
    //    echo "Dumping the aray";
    //    log_message('info',var_dump($resArray));
    $ack = strtoupper($resArray["ACK"]);

    if( $ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING" )
    {

      $this->session->set_userdata('profileid',$resArray['PROFILEID']);
      $transactionId      = $resArray["TRANSACTIONID"]; // ' Unique transaction ID of the payment. Note:  If the PaymentAction of the request was Authorization or Order, this value is your AuthorizationID for use with the Authorization & Capture APIs. 
      $transactionType    = $resArray["TRANSACTIONTYPE"]; //' The type of transaction Possible values: l  cart l  express-checkout 
      $paymentType        = $resArray["PAYMENTTYPE"];  //' Indicates whether the payment is instant or delayed. Possible values: l  none l  echeck l  instant 
      $orderTime          = $resArray["ORDERTIME"];  //' Time/date stamp of payment
      $amt                = $resArray["AMT"];  //' The final amount charged, including any shipping and taxes from your Merchant Profile.
      $currencyCode       = $resArray["CURRENCYCODE"];  //' A three-character currency code for one of the currencies listed in PayPay-Supported Transactional Currencies. Default: USD. 
      $feeAmt             = $resArray["FEEAMT"];  //' PayPal fee amount charged for the transaction
      $settleAmt          = $resArray["SETTLEAMT"];  //' Amount deposited in your PayPal account after a currency conversion.
      $taxAmt             = $resArray["TAXAMT"];  //' Tax charged on the transaction.
      $exchangeRate       = $resArray["EXCHANGERATE"];  //' Exchange rate if a currency conversion occurred. Relevant only if your are billing in their non-primary currency. If the customer chooses to pay with a currency other than the non-primary currency, the conversion occurs in the customer’s account.

                                 
      $paymentStatus  = $resArray["PAYMENTSTATUS"]; 

                                           

      $pendingReason  = $resArray["PENDINGREASON"];  



      $reasonCode     = $resArray["REASONCODE"];    
      $details = $this->db->get_where("subscription",array("email"=>$this->session->userdata('logged_in') ))->row_array();
      if(isset($details) && $details['plan']!="free")
      {
        $log_array11 = $this->db->get_where("paypal",array("email"=>$this->session->userdata('logged_in') ));
        log_message('info','testing');
        if($log_array11->num_rows()>0)
        {
          $new_array=$log_array11->row_array();
          log_message('info',"canceling the profile id ".$new_array['profileid']);
          log_message('info',print_r($this->change_subscription_status($new_array['profileid']),TRUE));
        }
      } 
      // now  cancel the preciouss profile
      ///      echo "Thank you for your payment.";
      $this->session->set_flashdata('error_messages_2','Succesful payment done');
      // save into db


      $sql = $this->db->update("signup",array("payment_status"=>"verified"),array('email' => $this->session->userdata('logged_in')));
      $sql = $this->db->update("subscription",array("plan"=>$this->current_plan[$this->session->userdata('mypaymentamount')]),array('email' => $this->session->userdata('logged_in')));
      // can we get al the details please ?? thanks
      $resultArray=$this->GetRecurringPaymentsProfileDetails($resArray['PROFILEID']);
      log_message('info','AAAAAAAAAAAAAAAAAAAAAAA'.print_r($resultArray,TRUE));
      if($resultArray['ACK']=='Success')
      {
         $log_array['email']=$this->session->userdata('logged_in');
         $log_array['profileid']=$resultArray['PROFILEID'];
         $log_array['status']=$resultArray['STATUS'];        
         $log_array['desc']=$resultArray['DESC'];
         $log_array['maxfailedpayments']=$resultArray['MAXFAILEDPAYMENTS'];
         $log_array['subscribername']=$resultArray['SUBSCRIBERNAME'];
         $log_array['profilestartdate']=$resultArray['PROFILESTARTDATE'];
         $log_array['nextbillingdate']=$resultArray['NEXTBILLINGDATE'];
         $log_array['numcyclescompleted']=$resultArray['NUMCYCLESCOMPLETED'];
         $log_array['numcyclesremaining']=$resultArray['NUMCYCLESREMAINING'];
         $log_array['outstandingbalance']=$resultArray['OUTSTANDINGBALANCE'];
         $log_array['failedpaymentcount']=$resultArray['FAILEDPAYMENTCOUNT'];
         $log_array['trialamtpaid']=$resultArray['TRIALAMTPAID'];
         $log_array['correlationid']=$resultArray['CORRELATIONID'];
         $log_array['billingfrequency']=$resultArray['BILLINGFREQUENCY'];
         $log_array['amt']=$resultArray['AMT'];
         $log_array['currencycode']=$resultArray['CURRENCYCODE'];
         $log_array['billingperiod']=$resultArray['BILLINGPERIOD'];
         $log_array['ack']=$resultArray['ACK'];
         $this->db_mysql->on_duplicate_key_update()->insert("paypal",$log_array);
         // do cretae quqeu and register destination
         $this->createsqs();
         /*
         $log_array['creditcardtype']=$resultArray[''];
         $log_array['expdate']=$this->session->userdata('logged_in');
         $log_array['startdate']=$this->session->userdata('logged_in');
         $log_array['acct']=$this->session->userdata('logged_in');
         $log_array['issuenumber']=$this->session->userdata('logged_in');
          */
      }



    }
    else  
    {
      //Display a user friendly Error on the page using any of the following error information returned by PayPal
      $ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
      $ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
      $ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
      $ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);

      $this->session->set_flashdata('error_messages_2','failed  payment done');

      /*
      echo "GetExpressCheckoutDetails API call failed. ";
      echo "Detailed Error Message: " . $ErrorLongMsg;
      echo "Short Error Message: " . $ErrorShortMsg;
      echo "Error Code: " . $ErrorCode;
      echo "Error Severity Code: " . $ErrorSeverityCode;
       */
    }       

    /*

    $this->load->view('repricing/header',$this->data);
    $this->load->view('repricing/nav',$this->data);
    $this->load->view('repricing/subscriptions',$this->data);
    $this->load->view('repricing/footer',$this->data);                
     */
//    redirect('home/subscriptions');

  }
  public function review()
  {
    //$token = $_REQUEST['token'];
    $token = $this->input->get('token');

    log_message('info', "Customer review payment");

    $resArray = $this->GetShippingDetails( $token );
    $ack = strtoupper($resArray["ACK"]);
    if( $ack == "SUCCESS" || $ack == "SUCESSWITHWARNING") 
    {
                  /*
                        ' The information that is returned by the GetExpressCheckoutDetails call should be integrated by the partner into his Order Review 
                            ' page      
                   */
      $email            = $resArray["EMAIL"]; // ' Email address of payer.
      $payerId          = $resArray["PAYERID"]; // ' Unique PayPal customer account identification number.
      $payerStatus      = $resArray["PAYERSTATUS"]; // ' Status of payer. Character length and limitations: 10 single-byte alphabetic characters.
      $salutation           = @$resArray["SALUTATION"]; // ' Payer's salutation.
      $firstName            = @$resArray["FIRSTNAME"]; // ' Payer's first name.
      $middleName           = @$resArray["MIDDLENAME"]; // ' Payer's middle name.
      $lastName         = @$resArray["LASTNAME"]; // ' Payer's last name.
      $suffix               = @$resArray["SUFFIX"]; // ' Payer's suffix.
      $cntryCode            = @$resArray["COUNTRYCODE"]; // ' Payer's country of residence in the form of ISO standard 3166 two-character country codes.
      $business         = @$resArray["BUSINESS"]; // ' Payer's business name.
      $shipToName           =@$resArray["SHIPTONAME"]; // ' Person's name associated with this address.
      $shipToStreet     = @$resArray["SHIPTOSTREET"]; // ' First street address.
      $shipToStreet2        =@$resArray["SHIPTOSTREET2"]; // ' Second street address.
      $shipToCity           =@$resArray["SHIPTOCITY"]; // ' Name of city.
      $shipToState      =@$resArray["SHIPTOSTATE"]; // ' State or province
      $shipToCntryCode  = @$resArray["SHIPTOCOUNTRYCODE"]; // ' Country code. 
      $shipToZip            = @$resArray["SHIPTOZIP"]; // ' U.S. Zip code or other country-specific postal code.
      $addressStatus        =@$resArray["ADDRESSSTATUS"]; // ' Status of street address on file with PayPal   
      $invoiceNumber        = @$resArray["INVNUM"]; // ' Your own invoice or tracking number, as set by you in the element of the same name in SetExpressCheckout request .
      $phonNumber           = @$resArray["PHONENUM"]; // ' Payer's contact telephone number. Note:  PayPal returns a contact telephone number only if your Merchant account profile settings require that the buyer enter one. 
//      $this->data['paypal_settings']=array('name'=>$firstName,'email'=>$email);
      $this->session->set_flashdata('error_messages_1','review payment done');
      $this->recurring_payment();
    } 
    else  
    {
      //Display a user friendly Error on the page using any of the following error information returned by PayPal
      $ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
      $ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
      $ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
      $ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);
         /*
      echo "GetExpressCheckoutDetails API call failed. ";
      echo "Detailed Error Message: " . $ErrorLongMsg;
      echo "Short Error Message: " . $ErrorShortMsg;
      echo "Error Code: " . $ErrorCode;
      echo "Error Severity Code: " . $ErrorSeverityCode;
          */
      //redirect('content');
      $this->session->set_flashdata('error_messages_1',' Review payment failed');
    }
    redirect('content/subscriptions');
    /*
    $this->load->view('repricing/header',$this->data);
    $this->load->view('repricing/nav',$this->data);
    $this->load->view('repricing/review',$this->data);
    $this->load->view('repricing/footer',$this->data);
     */
  }
  public function index($amount=NULL)
  { 

    //    log_message('error','problem is'.$amount);
    //vliadtion
    $val = $this->db->get_where("user_settings",array("email"=>$this->session->userdata('logged_in') ))->row_array();
    if($val['sellerid']=="" || $val['marketplaceid']=="" || $val['mwsauthtoken']=="")
    {
      $this->session->set_flashdata('error_messages_red','ERROR:Please configure the settings ');
      redirect('content/subscriptions');
    }
    $details = $this->db->get_where("subscription",array("email"=>$this->session->userdata('logged_in') ))->row_array();
    $temp_arr=array_flip($this->current_plan);
    if(isset($details) && $temp_arr[$details['plan']]==$amount)
    {
      //      $this->session->set_flashdata('error_messages_red','YOU CAN ONLY UPGRADE TO THE NEW SERVICE');
      $this->session->set_flashdata('error_messages_red','ERROR:YOU ARE ALREADY SUBSCRIBED TO THIS SERVICE');
      redirect('content/subscriptions');
    }
    // safe check for cancelling the current subscriptions

    $resArray = $this->CallShortcutExpressCheckout ($amount, $this->currencyCodeType, $this->paymentType, $this->returnURL, $this->cancelURL);
    $ack = strtoupper($resArray["ACK"]);
    log_message('info','problem is'.$amount);
    if($ack=="SUCCESS" || $ack=="SUCCESSWITHWARNING")
    {
      $this->RedirectToPayPal ( $resArray["TOKEN"] );
    } 
    else  
    {
      //Display a user friendly Error on the page using any of the following error information returned by PayPal
      $ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
      $ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
      $ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
      $ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);

      log_message('error', "SetExpressCheckout API call failed. ");
      log_message('error',"Detailed Error Message: " . $ErrorLongMsg);
      log_message('error',"Short Error Message: " . $ErrorShortMsg);
      log_message('error',"Error Code: " . $ErrorCode);
      log_message('error',"Error Severity Code: " . $ErrorSeverityCode);
    }



  }
	
	/*	
	' Define the PayPal Redirect URLs.  
	' 	This is the URL that the buyer is first sent to do authorize payment with their paypal account
	' 	change the URL depending if you are testing on the sandbox or the live PayPal site
	'
	' For the sandbox, the URL is       https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=
	' For the live site, the URL is        https://www.paypal.com/webscr&cmd=_express-checkout&token=
	*/
	
	



	/* An express checkout transaction starts with a token, that
	   identifies to PayPal your transaction
	   In this example, when the script sees a token, the script
	   knows that the buyer has already authorized payment through
	   paypal.  If no token was found, the action is to send the buyer
	   to PayPal to first authorize payment
	   */

	/*   
	'-------------------------------------------------------------------------------------------------------------------------------------------
	' Purpose: 	Prepares the parameters for the SetExpressCheckout API Call.
	' Inputs:  
	'		paymentAmount:  	Total value of the shopping cart
	'		currencyCodeType: 	Currency code value the PayPal API
	'		paymentType: 		paymentType has to be one of the following values: Sale or Order or Authorization
	'		returnURL:			the page where buyers return to after they are done with the payment review on PayPal
	'		cancelURL:			the page where buyers return to when they cancel the payment review on PayPal
	'--------------------------------------------------------------------------------------------------------------------------------------------	
	*/
	function CallShortcutExpressCheckout( $paymentAmount, $currencyCodeType, $paymentType, $returnURL, $cancelURL) 
	{
		//------------------------------------------------------------------------------------------------------------------------------------
		// Construct the parameter string that describes the SetExpressCheckout API call in the shortcut implementation

		$nvpstr="&AMT=". $paymentAmount;
		$nvpstr = $nvpstr . "&PAYMENTACTION=" . $paymentType;
		$nvpstr = $nvpstr . "&BILLINGAGREEMENTDESCRIPTION=".urlencode("Legend Pricing Recurring Payment($".$paymentAmount." monthly)");
		$nvpstr = $nvpstr . "&BILLINGTYPE=RecurringPayments";
		$nvpstr = $nvpstr . "&RETURNURL=" . $returnURL;
		$nvpstr = $nvpstr . "&CANCELURL=" . $cancelURL;
		$nvpstr = $nvpstr . "&CURRENCYCODE=" . $currencyCodeType;

        $this->session->set_userdata('currencyCodeType', $currencyCodeType);	  
        $this->session->set_userdata('PaymentType', $paymentType);	  
        $this->session->set_userdata('mypaymentamount', $paymentAmount);	  
	 //   $_SESSION["PaymentType"] = $paymentType;
	  //  $_SESSION["mypaymentamount"] = $paymentAmount;

		//'--------------------------------------------------------------------------------------------------------------- 
		//' Make the API call to PayPal
		//' If the API call succeded, then redirect the buyer to PayPal to begin to authorize payment.  
        //' If an error occured, show the resulting errors
        //'---------------------------------------------------------------------------------------------------------------

        $resArray=$this->hash_call("SetExpressCheckout", $nvpstr);
        //log_message('info','problem is'.$amount);
        $ack = strtoupper($resArray["ACK"]);
        if($ack=="SUCCESS" || $ack=="SUCCESSWITHWARNING")
        {
          $token = urldecode($resArray["TOKEN"]);
          $this->session->set_userdata('TOKEN',$token);
        }

        return $resArray;
    }

	/*   
	'-------------------------------------------------------------------------------------------------------------------------------------------
	' Purpose: 	Prepares the parameters for the SetExpressCheckout API Call.
	' Inputs:  
	'		paymentAmount:  	Total value of the shopping cart
	'		currencyCodeType: 	Currency code value the PayPal API
	'		paymentType: 		paymentType has to be one of the following values: Sale or Order or Authorization
	'		returnURL:			the page where buyers return to after they are done with the payment review on PayPal
	'		cancelURL:			the page where buyers return to when they cancel the payment review on PayPal
	'		shipToName:		the Ship to name entered on the merchant's site
	'		shipToStreet:		the Ship to Street entered on the merchant's site
	'		shipToCity:			the Ship to City entered on the merchant's site
	'		shipToState:		the Ship to State entered on the merchant's site
	'		shipToCountryCode:	the Code for Ship to Country entered on the merchant's site
	'		shipToZip:			the Ship to ZipCode entered on the merchant's site
	'		shipToStreet2:		the Ship to Street2 entered on the merchant's site
	'		phoneNum:			the phoneNum  entered on the merchant's site
	'--------------------------------------------------------------------------------------------------------------------------------------------	
	function CallMarkExpressCheckout( $paymentAmount, $currencyCodeType, $paymentType, $returnURL, 
									  $cancelURL, $shipToName, $shipToStreet, $shipToCity, $shipToState,
									  $shipToCountryCode, $shipToZip, $shipToStreet2, $phoneNum
									) 
	{
		//------------------------------------------------------------------------------------------------------------------------------------
		// Construct the parameter string that describes the SetExpressCheckout API call in the shortcut implementation
		
		$nvpstr="&PAYMENTREQUEST_0_AMT=". $paymentAmount;
		$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_PAYMENTACTION=" . $paymentType;
		$nvpstr = $nvpstr . "&RETURNURL=" . $returnURL;
		$nvpstr = $nvpstr . "&CANCELURL=" . $cancelURL;
		$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_CURRENCYCODE=" . $currencyCodeType;
		$nvpstr = $nvpstr . "&ADDROVERRIDE=1";
		$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_SHIPTONAME=" . $shipToName;
		$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_SHIPTOSTREET=" . $shipToStreet;
		$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_SHIPTOSTREET2=" . $shipToStreet2;
		$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_SHIPTOCITY=" . $shipToCity;
		$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_SHIPTOSTATE=" . $shipToState;
		$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE=" . $shipToCountryCode;
		$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_SHIPTOZIP=" . $shipToZip;
		$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_SHIPTOPHONENUM=" . $phoneNum;
		
		$_SESSION["currencyCodeType"] = $currencyCodeType;	  
		$_SESSION["PaymentType"] = $paymentType;

		//'--------------------------------------------------------------------------------------------------------------- 
		//' Make the API call to PayPal
		//' If the API call succeded, then redirect the buyer to PayPal to begin to authorize payment.  
		//' If an error occured, show the resulting errors
		//'---------------------------------------------------------------------------------------------------------------
	    $resArray=hash_call("SetExpressCheckout", $nvpstr);
		$ack = strtoupper($resArray["ACK"]);
		if($ack=="SUCCESS" || $ack=="SUCCESSWITHWARNING")
		{
			$token = urldecode($resArray["TOKEN"]);
			$_SESSION['TOKEN']=$token;
		}
		   
	    return $resArray;
	}
	*/
	
	/*
	'-------------------------------------------------------------------------------------------
	' Purpose: 	Prepares the parameters for the GetExpressCheckoutDetails API Call.
	'
	' Inputs:  
	'		None
	' Returns: 
	'		The NVP Collection object of the GetExpressCheckoutDetails Call Response.
	'-------------------------------------------------------------------------------------------
	*/
	function GetShippingDetails( $token )
	{
		//'--------------------------------------------------------------
		//' At this point, the buyer has completed authorizing the payment
		//' at PayPal.  The function will call PayPal to obtain the details
		//' of the authorization, incuding any shipping information of the
		//' buyer.  Remember, the authorization is not a completed transaction
		//' at this state - the buyer still needs an additional step to finalize
		//' the transaction
		//'--------------------------------------------------------------
	   
	    //'---------------------------------------------------------------------------
		//' Build a second API request to PayPal, using the token as the
		//'  ID to get the details on the payment authorization
		//'---------------------------------------------------------------------------
	    $nvpstr="&TOKEN=" . $token;

		//'---------------------------------------------------------------------------
		//' Make the API call and store the results in an array.  
		//'	If the call was a success, show the authorization details, aGetExpressnd provide
		//' 	an action to complete the payment.  
		//'	If failed, show the error
		//'---------------------------------------------------------------------------
	    $resArray=$this->hash_call("GetExpressCheckoutDetails",$nvpstr);
	    $ack = strtoupper($resArray["ACK"]);

		if($ack == "SUCCESS" || $ack=="SUCCESSWITHWARNING")
		{	
			$this->session->set_userdata('payer_id',	$resArray['PAYERID']);
			$this->session->set_userdata('email',	$resArray['EMAIL']);
			$this->session->set_userdata('firstName', $resArray["FIRSTNAME"]); 
			$this->session->set_userdata('lastName', $resArray["LASTNAME"]); 
			$this->session->set_userdata('shipToName', $resArray["SHIPTONAME"]); 
			$this->session->set_userdata('shipToStreet', $resArray["SHIPTOSTREET"]); 
			$this->session->set_userdata('shipToCity', $resArray["SHIPTOCITY"]);
			$this->session->set_userdata('shipToState', $resArray["SHIPTOSTATE"]);
			$this->session->set_userdata('shipToZip', $resArray["SHIPTOZIP"]);
			$this->session->set_userdata('shipToCountry', $resArray["SHIPTOCOUNTRYCODE"]);
		} 
		return $resArray;
	}
	
	/*
	'-------------------------------------------------------------------------------------------------------------------------------------------
	' Purpose: 	Prepares the parameters for the GetExpressCheckoutDetails API Call.
	'
	' Inputs:  
	'		sBNCode:	The BN code used by PayPal to track the transactions from a given shopping cart.
	' Returns: 
	'		The NVP Collection object of the GetExpressCheckoutDetails Call Response.
	'--------------------------------------------------------------------------------------------------------------------------------------------	
	*/
	function ConfirmPayment( $FinalPaymentAmt )
	{
		/* Gather the information to make the final call to
		   finalize the PayPal payment.  The variable nvpstr
		   holds the name value pairs
		   */
		

		//Format the other parameters that were stored in the session from the previous calls	
		$token 		= urlencode($_SESSION['TOKEN']);
		$paymentType 		= urlencode($_SESSION['PaymentType']);
		$currencyCodeType 	= urlencode($_SESSION['currencyCodeType']);
		$payerID 		= urlencode($_SESSION['payer_id']);

		$serverName 		= urlencode($_SERVER['SERVER_NAME']);

		$nvpstr  = '&TOKEN=' . $token . '&PAYERID=' . $payerID . '&PAYMENTACTION=' . $paymentType . '&AMT=' . $FinalPaymentAmt;
		$nvpstr .= '&CURRENCYCODE=' . $currencyCodeType . '&IPADDRESS=' . $serverName; 

		 /* Make the call to PayPal to finalize payment
		    If an error occured, show the resulting errors
		    */
		$resArray=$this->hash_call("DoExpressCheckoutPayment",$nvpstr);

		$_SESSION['billing_agreement_id']	= $resArray["BILLINGAGREEMENTID"];

		/* Display the API response back to the browser.
		   If the response from PayPal was a success, display the response parameters'
             If the response was an error, display the errors received using APIError.php.
         */
        $ack = strtoupper($resArray["ACK"]);

        return $resArray;
    }

    function change_subscription_status( $profile_id, $action='cancel' ) {

      $nvpstr= '&METHOD=ManageRecurringPaymentsProfileStatus' .  '&PROFILEID=' . urlencode( $profile_id ) .  '&ACTION=' . urlencode( $action ) .  '&NOTE=' . urlencode( 'Profile cancelled at store' );
      $resArray=$this->hash_call("CreateRecurringPaymentsProfile",$nvpstr);
      $ack = strtoupper($resArray["ACK"]);
      return $resArray;                  

    }
    function CreateRecurringPaymentsProfile($amount)
    {
      //'--------------------------------------------------------------
      //' At this point, the buyer has completed authorizing the payment
      //' at PayPal.  The function will call PayPal to obtain the details
      //' of the authorization, incuding any shipping information of the
      //' buyer.  Remember, the authorization is not a completed transaction
      //' at this state - the buyer still needs an additional step to finalize
      //' the transaction
      //'--------------------------------------------------------------
      $token 		= urlencode($this->session->userdata('TOKEN'));
		$email 		= urlencode($this->session->userdata('logged_in'));
		$shipToName		= urlencode($this->session->userdata('shipToName'));
		$shipToStreet		= urlencode($this->session->userdata('shipToStreet'));
        $shipToCity		= urlencode($this->session->userdata('shipToCity'));
		$shipToState		= urlencode($this->session->userdata('shipToState'));
        $shipToZip		= urlencode($this->session->userdata('shipToZip'));
		$shipToCountry	= urlencode($this->session->userdata('shipToCountry'));
	   
	    //'---------------------------------------------------------------------------
		//' Build a second API request to PayPal, using the token as the
		//'  ID to get the details on the payment authorization
		//'---------------------------------------------------------------------------
		$nvpstr="&TOKEN=".$token;
		#$nvpstr.="&EMAIL=".$email;
		$nvpstr.="&SHIPTONAME=".$shipToName;
		$nvpstr.="&SHIPTOSTREET=".$shipToStreet;
		$nvpstr.="&SHIPTOCITY=".$shipToCity;
		$nvpstr.="&SHIPTOSTATE=".$shipToState;
		$nvpstr.="&SHIPTOZIP=".$shipToZip;
		$nvpstr.="&SHIPTOCOUNTRY=".$shipToCountry;
		//$nvpstr.="&PROFILESTARTDATE=".urlencode("2015-08-03T0:0:0");
		$nvpstr.="&PROFILESTARTDATE=".urlencode(time());
		$nvpstr.="&DESC=".urlencode("Legend Pricing Recurring Payment($".$amount." monthly)");
		$nvpstr.="&BILLINGPERIOD=Month";
		$nvpstr.="&BILLINGFREQUENCY=1";
		$nvpstr.="&AMT=".$amount;
		$nvpstr.="&CURRENCYCODE=USD";
		$nvpstr.="&IPADDRESS=" . $_SERVER['REMOTE_ADDR'];
		
		//'---------------------------------------------------------------------------
		//' Make the API call and store the results in an array.  
		//'	If the call was a success, show the authorization details, and provide
		//' 	an action to complete the payment.  
		//'	If failed, show the error
		//'---------------------------------------------------------------------------
		$resArray=$this->hash_call("CreateRecurringPaymentsProfile",$nvpstr);
		$ack = strtoupper($resArray["ACK"]);
		return $resArray;
	}
	/*
	'-------------------------------------------------------------------------------------------------------------------------------------------
	' Purpose: 	This function makes a DoDirectPayment API call
	'
	' Inputs:  
	'		paymentType:		paymentType has to be one of the following values: Sale or Order or Authorization
	'		paymentAmount:  	total value of the shopping cart
	'		currencyCode:	 	currency code value the PayPal API
	'		firstName:			first name as it appears on credit card
	'		lastName:			last name as it appears on credit card
	'		street:				buyer's street address line as it appears on credit card
	'		city:				buyer's city
	'		state:				buyer's state
	'		countryCode:		buyer's country code
	'		zip:				buyer's zip
	'		creditCardType:		buyer's credit card type (i.e. Visa, MasterCard ... )
	'		creditCardNumber:	buyers credit card number without any spaces, dashes or any other characters
	'		expDate:			credit card expiration date
	'		cvv2:				Card Verification Value 
	'		
	'-------------------------------------------------------------------------------------------
	'		
	' Returns: 
	'		The NVP Collection object of the DoDirectPayment Call Response.
	'--------------------------------------------------------------------------------------------------------------------------------------------	
	*/


	function DirectPayment( $paymentType, $paymentAmount, $creditCardType, $creditCardNumber,
							$expDate, $cvv2, $firstName, $lastName, $street, $city, $state, $zip, 
							$countryCode, $currencyCode )
	{
		//Construct the parameter string that describes DoDirectPayment
		$nvpstr = "&AMT=" . $paymentAmount;
		$nvpstr = $nvpstr . "&CURRENCYCODE=" . $currencyCode;
		$nvpstr = $nvpstr . "&PAYMENTACTION=" . $paymentType;
		$nvpstr = $nvpstr . "&CREDITCARDTYPE=" . $creditCardType;
		$nvpstr = $nvpstr . "&ACCT=" . $creditCardNumber;
		$nvpstr = $nvpstr . "&EXPDATE=" . $expDate;
		$nvpstr = $nvpstr . "&CVV2=" . $cvv2;
		$nvpstr = $nvpstr . "&FIRSTNAME=" . $firstName;
		$nvpstr = $nvpstr . "&LASTNAME=" . $lastName;
		$nvpstr = $nvpstr . "&STREET=" . $street;
		$nvpstr = $nvpstr . "&CITY=" . $city;
		$nvpstr = $nvpstr . "&STATE=" . $state;
		$nvpstr = $nvpstr . "&COUNTRYCODE=" . $countryCode;
		$nvpstr = $nvpstr . "&IPADDRESS=" . $_SERVER['REMOTE_ADDR'];

		$resArray=$this->hash_call("DoDirectPayment", $nvpstr);

		return $resArray;
	}


	/**
	  '-------------------------------------------------------------------------------------------------------------------------------------------
	  * hash_call: Function to perform the API call to PayPal using API signature
	  * @methodName is name of API  method.
	  * @nvpStr is nvp string.
	  * returns an associtive array containing the response from the server.
	  '-------------------------------------------------------------------------------------------------------------------------------------------
	*/
	function hash_call($methodName,$nvpStr)
	{
      //declaring of global variables
      /*
		global $API_Endpoint, $version, $API_UserName, $API_Password, $API_Signature;
		global $USE_PROXY, $PROXY_HOST, $PROXY_PORT;
		global $gv_ApiErrorURL;
		global $sBNCode;
       */
		//setting the curl parameters.
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$this->API_Endpoint);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);

		//turning off the server and peer verification(TrustManager Concept).
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);
		
	    //if USE_PROXY constant set to TRUE in Constants.php, then only proxy will be enabled.
	   //Set proxy name to PROXY_HOST and port number to PROXY_PORT in constants.php 
		if($this->USE_PROXY)
			curl_setopt ($ch, CURLOPT_PROXY, $this->PROXY_HOST. ":" . $this->PROXY_PORT); 

		//NVPRequest for submitting to server
		$nvpreq="METHOD=" . urlencode($methodName) . "&VERSION=" . urlencode($this->version) . "&PWD=" . urlencode($this->API_Password) . "&USER=" . urlencode($this->API_UserName) . "&SIGNATURE=" . urlencode($this->API_Signature) . $nvpStr . "&BUTTONSOURCE=" . urlencode($this->sBNCode);

	 //   var_dump($nvpreq);
		//setting the nvpreq as POST FIELD to curl
		curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

		//getting response from server
		$response = curl_exec($ch);

		//convrting NVPResponse to an Associative Array
		$nvpResArray=$this->deformatNVP($response);
		$nvpReqArray=$this->deformatNVP($nvpreq);
		$_SESSION['nvpReqArray']=$nvpReqArray;

		if (curl_errno($ch)) 
		{
			// moving to display page to display curl errors
			  $_SESSION['curl_error_no']=curl_errno($ch) ;
			  $_SESSION['curl_error_msg']=curl_error($ch);

			  //Execute the Error handling module to display errors. 
		} 
		else 
		{
			 //closing the curl
		  	curl_close($ch);
		}

		return $nvpResArray;
	}

	/*'----------------------------------------------------------------------------------
	 Purpose: Redirects to PayPal.com site.
	 Inputs:  NVP string.
	 Returns: 
	----------------------------------------------------------------------------------
	*/
	function RedirectToPayPal ( $token )
	{
	 //   global $PAYPAL_URL;
		
		// Redirect to paypal.com here
		$payPalURL = $this->PAYPAL_URL . $token;
		header("Location: ".$payPalURL);
	}

	
	/*'----------------------------------------------------------------------------------
	 * This function will take NVPString and convert it to an Associative Array and it will decode the response.
	  * It is usefull to search for a particular key and displaying arrays.
	  * @nvpstr is NVPString.
	  * @nvpArray is Associative Array.
	   ----------------------------------------------------------------------------------
	  */
	function deformatNVP($nvpstr)
	{
		$intial=0;
	 	$nvpArray = array();

		while(strlen($nvpstr))
		{
			//postion of Key
			$keypos= strpos($nvpstr,'=');
			//position of value
			$valuepos = strpos($nvpstr,'&') ? strpos($nvpstr,'&'): strlen($nvpstr);

			/*getting the Key and Value values and storing in a Associative Array*/
			$keyval=substr($nvpstr,$intial,$keypos);
			$valval=substr($nvpstr,$keypos+1,$valuepos-$keypos-1);
			//decoding the respose
			$nvpArray[urldecode($keyval)] =urldecode( $valval);
			$nvpstr=substr($nvpstr,$valuepos+1,strlen($nvpstr));
	     }
		return $nvpArray;
	}

}
?>
