<?php
#ignore_user_abort(false);
define ('DATE_FORMAT', 'Y-m-d\TH:i:s\Z');

//define ('MERCHANT_ID', 'A112ZN3BG4B0O0');
define('AWS_ACCESS_KEY_ID', 'AKIAJWQSXIPAKQWURUBQ');
define('AWS_SECRET_ACCESS_KEY', 'dr13U/5uVl2DWth5VUd0WAAQ71dy3oSVwmEvqFZu');

define('APPLICATION_NAME', '<Your Application Name>');
define('APPLICATION_VERSION', '<Your Application Version or Build Number>');

error_reporting(E_ALL);


//define ('MARKETPLACE_ID', 'ATVPDKIKX0DER');


class Testing extends CI_Controller
{ 
  private static $appname="";
  private static $CI;
  private static  $appversion="";
  private static $marketplaceIdArray = array();
  private $gearman_server='localhost';
  private $gearman_port='4730';                          
  public function __construct(){

    parent::__construct();
    if(php_sapi_name() !== 'cli') {
      show_404();
    }
    self::$appversion="sversion";
    self::$appname="legendpricing";   
    self::$marketplaceIdArray = array("Id" => array(trim("ATVPDKIKX0DER"))); 
    self::$CI =& get_instance();               

    log_message('info',"constructor");    
  }     

  // static public function amazon_fbafees($job)

  static public function invokeRequestReport(MarketplaceWebService_Interface $service, $request) 
  {
    log_message('error',"inside the func checking");
    try {
      log_message('error',"inside the func checking try");
      $response = $service->requestReport($request);

      log_message('error',"inside the func checking after try");
      log_message('error',"inside the func01");

      if ($response->isSetRequestReportResult()) { 
        $requestReportResult = $response->getRequestReportResult();

        if ($requestReportResult->isSetReportRequestInfo()) {

          $reportRequestInfo = $requestReportResult->getReportRequestInfo();
          if ($reportRequestInfo->isSetReportRequestId()) 
          {
            log_message('error',"inside11 the func");
            return $reportRequestInfo->getReportRequestId();
          }
          if ($reportRequestInfo->isSetReportType()) 
          {
          }
          if ($reportRequestInfo->isSetStartDate()) 
          {
          }
          if ($reportRequestInfo->isSetEndDate()) 
          {
          }
          if ($reportRequestInfo->isSetSubmittedDate()) 
          {
          }
          if ($reportRequestInfo->isSetReportProcessingStatus()) 
          {
          }
        }
      } 
      if ($response->isSetResponseMetadata()) { 
        $responseMetadata = $response->getResponseMetadata();
        if ($responseMetadata->isSetRequestId()) 
        {
        }
      } 

    } catch (MarketplaceWebService_Exception $ex) {
      log_message('error',"inside12 the func");
      log_message('error',$ex->getMessage());
    }
    log_message('error',"inside 13 the func");
  }

       static public function amazon_fbafees($job)
  {
    //  global $marketplaceIdArray;    
    /// we have sellerid , mkpid , and token

       $data = unserialize($job->workload());


    $marketplaceIdArray = array("Id" => array(trim($data['marketplaceid'])));
    //$serviceUrl = "https://mws.amazonservices.com";
    $serviceUrl = self::$CI->config->item($data['marketplaceid'],'gl_serviceurl');

    $config = array (
      'ServiceURL' => $serviceUrl,
      'ProxyHost' => null,
      'ProxyPort' => -1,
      'MaxErrorRetry' => 3,
    );

    /************************************************************************
     * Instantiate Implementation of MarketplaceWebService
     * 
     * AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY constants 
     * are defined in the .config.inc.php located in the same 
     * directory as this sample
     ***********************************************************************/
    $service = new MarketplaceWebService_Client(
      AWS_ACCESS_KEY_ID, 
      AWS_SECRET_ACCESS_KEY, 
      $config,
      APPLICATION_NAME,
      APPLICATION_VERSION);


    $request = new MarketplaceWebService_Model_RequestReportRequest();
    $request->setMarketplaceIdList($marketplaceIdArray);
    $request->setMerchant($data['sellerid']); 
    $request->setStartDate(new DateTime('-60 days', new DateTimeZone('UTC')));
    $request->setReportType('_GET_FBA_ESTIMATED_FBA_FEES_TXT_DATA_');
    $request->setMWSAuthToken($data['mwsauthtoken']); // Optional
// $request->setStartDate((string)date('Y-m-d\Th:m:s\Z', strtotime('-30 days')));


    $check_id=self::invokeRequestReport($service, $request);  
    while(TRUE)
    {
      log_message('info',"Sleepin for 120 seconds for ".$data['sellerid']);
      $id=self::getreportlist($data['marketplaceid'],$data['sellerid'],$check_id,'amazon_fbafees');   
      if($id=="cancelled")
      {
     ///   echo 'report is cancelled '.$check_id;
        break;
      }
      if($id=="notfound")
      {
        sleep(120);
        continue;
      }
      self::getreport($data['sellerid'],$id,$data['marketplaceid'],'amazon_fbafees');
      log_message('info',"ok  done populatin the mysql");
      // now again refrehs the listing
      // sleep(300);
      // $res=self::invokeRequestReport();
      break;
      //now udate the mysql tabel


    }                                    
  }                          

  static public function getfeesreport($job)
  {
    //  global $marketplaceIdArray;    
    /// we have sellerid , mkpid , and token

    $data = unserialize($job->workload());


    $marketplaceIdArray = array("Id" => array(trim($data['marketplaceid'])));
    //$serviceUrl = "https://mws.amazonservices.com";
    $serviceUrl = self::$CI->config->item($data['marketplaceid'],'gl_serviceurl');

    $config = array (
      'ServiceURL' => $serviceUrl,
      'ProxyHost' => null,
      'ProxyPort' => -1,
      'MaxErrorRetry' => 3,
    );

    /************************************************************************
     * Instantiate Implementation of MarketplaceWebService
     * 
     * AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY constants 
     * are defined in the .config.inc.php located in the same 
     * directory as this sample
     ***********************************************************************/
    $service = new MarketplaceWebService_Client(
      AWS_ACCESS_KEY_ID, 
      AWS_SECRET_ACCESS_KEY, 
      $config,
      APPLICATION_NAME,
      APPLICATION_VERSION);



    $request = new MarketplaceWebService_Model_RequestReportRequest();
    $request->setMarketplaceIdList($marketplaceIdArray);
    $request->setMerchant($data['sellerid']);
    $request->setReportType('_GET_FBA_ESTIMATED_FBA_FEES_TXT_DATA_');
    $request->setMWSAuthToken($data['mwsauthtoken']); // Optional


    log_message('info',self::invokeRequestReport($service, $request));  
    while(TRUE)
    {
      log_message('info',"Sleepin for 120 seconds for ".$data['sellerid']);
      $id=self::getreportlist($data['marketplaceid'],$data['sellerid']);   
      if($id=="notfound")
      {
        sleep(120);
        continue;
      }
      self::getreport($data['sellerid'],$id,$data['marketplaceid']);
      log_message('info',"ok  done populatin the mysql");
      // now again refrehs the listing
      // sleep(300);
      // $res=self::invokeRequestReport();
      break;
      //now udate the mysql tabel


    }                                    
  }
  static public function getnewreport($job)
  {
    //  global $marketplaceIdArray;    
    /// we have sellerid , mkpid , and token
    $data = unserialize($job->workload());
    log_message('info',print_r($data,TRUE));
    log_message('info','printing the secret key');
    log_message('info',AWS_SECRET_ACCESS_KEY);
    log_message('info','printing the secret key11');         
    $marketplaceIdArray = array("Id" => array(trim($data['marketplaceid'])));
    //$serviceUrl = "https://mws.amazonservices.com";
    // United Kingdom
    //$serviceUrl = "https://mws.amazonservices.co.uk";
    // Germany
    //$serviceUrl = "https://mws.amazonservices.de";
    // France
    //$serviceUrl = "https://mws.amazonservices.fr";
    // Italy
    //$serviceUrl = "https://mws.amazonservices.it";
    // Japan
    //$serviceUrl = "https://mws.amazonservices.jp";
    // China
    //$serviceUrl = "https://mws.amazonservices.com.cn";
    // Canada
    //$serviceUrl = "https://mws.amazonservices.ca";
    // India
    //$serviceUrl = "https://mws.amazonservices.in";

    $serviceUrl = self::$CI->config->item($data['marketplaceid'],'gl_serviceurl');
    $config = array (
      'ServiceURL' => $serviceUrl,
      'ProxyHost' => null,
      'ProxyPort' => -1,
      'MaxErrorRetry' => 3,
    );

    /************************************************************************
     * Instantiate Implementation of MarketplaceWebService
     * 
     * AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY constants 
     * are defined in the .config.inc.php located in the same 
     * directory as this sample
     ***********************************************************************/
    $service = new MarketplaceWebService_Client(
      AWS_ACCESS_KEY_ID, 
      AWS_SECRET_ACCESS_KEY, 
      $config,
      APPLICATION_NAME,
      APPLICATION_VERSION);

    /************************************************************************
     * Uncomment to try out Mock Service that simulates MarketplaceWebService
     * responses without calling MarketplaceWebService service.
     *
     * Responses are loaded from local XML files. You can tweak XML files to
     * experiment with various outputs during development
     *
     * XML files available under MarketplaceWebService/Mock tree
     *
     ***********************************************************************/
    // $service = new MarketplaceWebService_Mock();

    /************************************************************************
     * Setup request parameters and uncomment invoke to try out 
     * sample for Report Action
     ***********************************************************************/
    // Constructing the MarketplaceId array which will be passed in as the the MarketplaceIdList 
    // parameter to the RequestReportRequest object.
    //$marketplaceIdArray = array("Id" => array('<Marketplace_Id_1>','<Marketplace_Id_2>'));
    //$marketplaceIdArray = array("Id" => array('ATVPDKIKX0DER'));

    // @TODO: set request. Action can be passed as MarketplaceWebService_Model_ReportRequest
    // object or array of parameters

    // $parameters = array (
    //   'Merchant' => MERCHANT_ID,
    //   'MarketplaceIdList' => $marketplaceIdArray,
    //   'ReportType' => '_GET_MERCHANT_LISTINGS_DATA_',
    //   'ReportOptions' => 'ShowSalesChannel=true',
    //   'MWSAuthToken' => '<MWS Auth Token>', // Optional
    // );

    // $request = new MarketplaceWebService_Model_RequestReportRequest($parameters);

    $request = new MarketplaceWebService_Model_RequestReportRequest();
    $request->setMarketplaceIdList($marketplaceIdArray);
    $request->setMerchant($data['sellerid']);
    $request->setReportType('_GET_MERCHANT_LISTINGS_DATA_');
    $request->setMWSAuthToken($data['mwsauthtoken']); // Optional
    // Using ReportOptions
    // $request->setReportOptions('ShowSalesChannel=true');

    log_message('info',self::invokeRequestReport($service, $request));  
    while(TRUE)
    {
      log_message('info',"Sleepin for 120 seconds for ".$data['sellerid']);
      $id=self::getreportlist($data['marketplaceid'],$data['sellerid']);   
      if($id=="notfound")
      {
      break;
     //   sleep(120);
       // continue;
      }
    //  echo 'so the genereted report is '.$id;
      self::getreport($data['sellerid'],$id,$data['marketplaceid']);
      log_message('info',"ok  done populatin the mysql");
      // now again refrehs the listing
      // sleep(300);
      // $res=self::invokeRequestReport();
      break;
      //now udate the mysql tabel


    }                                    
  }

  static public function send_email($job)
  {        
    $data = unserialize($job->workload());        
    self::$CI =& get_instance();               
    self::$CI->email->set_newline("\r\n");
    self::$CI->email->from('admin@legendrepricing.com'); // change it to yours
    self::$CI->email->to($data['to']);// change it to yours
    if(isset($data['reply_to']))
      self::$CI->email->reply_to($data['reply_to'],explode($data['reply_to'])[0]);
    self::$CI->email->subject($data['subject']);
    self::$CI->email->message($data['message']); 
    if(self::$CI->email->send())
    {
      log_message('info',print_r($data,TRUE));
    }
    else
    {
      //shal we rrety
      log_message('error',$this->email->print_debugger());
      log_message('info','Failed to send the email');
    }
  }
  static public function dynamic_repricing($job)
  {
    return;
    $data = unserialize($job->workload());
    if($data['sellerid']!='A112ZN3BG4B0O0')
      return;
    $log_array=self::$CI->db->get_where("user_settings",array("sellerid"=>$data['sellerid'],"marketplaceid"=>$data['marketplaceid']))->row_array();
    if($log_array)
    {
      $temp_result=array();
      $result=self::$CI->db->get_where("user_listings",array("sellerid"=>$data['sellerid'],"marketplaceid"=>$data['marketplaceid']))->result_array();
    
      // now udate me
      foreach($result as $row)
      {
        if((float)$row['min_price']=='0.00' || (float)$row['max_price']=='0.00')
        {
        }
        else
        {
          $temp_result[$row['sku']]=$row;
        }
      }

      log_message('error','ok fetched matched= '.count($temp_result));
      self::mycompare_price($temp_result,$log_array);
      $tmp_feeds=array();
      $tmp_feeds1=array();
      foreach($temp_result as $row)
      {
        // matched
        $new=array();
        $new['sellerid']=$row['sellerid'];
        $new['marketplaceid']=$row['marketplaceid'];
        $new['sku']=$row['sku'];
        $new['asin']=$row['asin'];
        if((float)$row['bb_price']=='0.00')
        {
            log_message('info'," ok matched12 inside");
        }
        else
        {
            log_message('info'," ok matched11 inside");
        if($row['match_status']=='matched')
        { 
            log_message('info'," ok matched inside");
          if($row['bb']=='yes')
          {
            $temp=array();
            log_message('info',"test12");
            $temp['bb_list']=$row['bb_lprice'];
            $temp['bb_total']=  $row['bb_price'];
            $new['price']= self::check_ubs_gbs($row,$log_array,$temp,$row['bb_lprice']);
            $new['ship_price']=$row['bb_sprice'];
            $new['bb_price'] = $row['bb_price'];
            $new['bb_eligible']=  'yes';
            $new['bb']=  'yes';
            $message='Raise-> '.print_r($new,TRUE);
            error_log($message,3, "/var/tmp/".rand().".log");
            $tmp_feeds[$new['sku']]=$new['price'];
            $tmp_feeds1[]=$new;

          //  if(self::price_update($new['sellerid'],$new['sku'],$new['price'],$new['marketplaceid'])!="tryagain")
            //  self::$CI->db->update('user_listings', $new, array('sellerid' => $new['sellerid'],'marketplaceid'=>$new['marketplaceid'],'sku'=>$new['sku'],'asin'=>$new['asin']));
          }
          else{
            // dot have bb   
            $temp=array();
            log_message('info',"test13");
            $temp['bb_list']=$row['bb_lprice'];
            $temp['bb_total']=  $row['bb_price'];
            $new['price']= self::check_ubs_gbs($row,$log_array,$temp,$row['bb_lprice']);
            $new['bb_price'] = $row['bb_price']; 
            $new['bb']=  'no';   
            if($new['price'])
            {
            $tmp_feeds1[]=$new;
            //  if(self::price_update($new['sellerid'],$new['sku'],$new['price'],$new['marketplaceid'])!="tryagain")
             //   self::$CI->db->update('user_listings', $new, array('sellerid' => $new['sellerid'],'marketplaceid'=>$new['marketplaceid'],'sku'=>$new['sku'],'asin'=>$new['asin']));
              // update
            $tmp_feeds[$new['sku']]=$new['price'];
            $message='Beating else condition-> '.print_r($new,TRUE);
            //    error_log($message,1, "repricinglegend@gmail.com");
            error_log($message,3, "/var/tmp/".rand().".log");
            }
          }
        }
        }
      }
      // now submit feeds mulltiple
      if(count($tmp_feeds)>0)
      {
        if(self::mprice_update($data['sellerid'],$tmp_feeds,$data['marketplaceid'])!="tryagain")
        {
          foreach($tmp_feeds1 as $key=>$value)
          {
            error_log('ok updating mysql noe ok',3, "/var/tmp/".rand().".log");
          self::$CI->db->update('user_listings', $value, array('sellerid' => $data['sellerid'],'marketplaceid'=>$data['marketplaceid'],'sku'=>$value['sku'],'asin'=>$value['asin']));
          }
        }
      }
    }
  }
  static public function dynamic_report($job)
  {
    //  global $marketplaceIdArray;    
    /// we have sellerid , mkpid , and token
    $data = unserialize($job->workload());
    log_message('info',print_r($data,TRUE));
    log_message('info','printing the secret key');
    log_message('info',AWS_SECRET_ACCESS_KEY);
    log_message('info','printing the secret key11');         
    $marketplaceIdArray = array("Id" => array(trim($data['marketplaceid'])));
    //   $serviceUrl = "https://mws.amazonservices.com";
    $serviceUrl = self::$CI->config->item($data['marketplaceid'],'gl_serviceurl');
    // United Kingdom
    //$serviceUrl = "https://mws.amazonservices.co.uk";
    // Germany
    //$serviceUrl = "https://mws.amazonservices.de";
    // France
    //$serviceUrl = "https://mws.amazonservices.fr";
    // Italy
    //$serviceUrl = "https://mws.amazonservices.it";
    // Japan
    //$serviceUrl = "https://mws.amazonservices.jp";
    // China
    //$serviceUrl = "https://mws.amazonservices.com.cn";
    // Canada
    //$serviceUrl = "https://mws.amazonservices.ca";
    // India
    //$serviceUrl = "https://mws.amazonservices.in";

    $config = array (
      'ServiceURL' => $serviceUrl,
      'ProxyHost' => null,
      'ProxyPort' => -1,
      'MaxErrorRetry' => 3,
    );

    /************************************************************************
     * Instantiate Implementation of MarketplaceWebService
     * 
     * AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY constants 
     * are defined in the .config.inc.php located in the same 
     * directory as this sample
     ***********************************************************************/
    $service = new MarketplaceWebService_Client(
      AWS_ACCESS_KEY_ID, 
      AWS_SECRET_ACCESS_KEY, 
      $config,
      APPLICATION_NAME,
      APPLICATION_VERSION);

    log_message('info',"ok  done populatin the mysql");
    /************************************************************************
     * Uncomment to try out Mock Service that simulates MarketplaceWebService
     * responses without calling MarketplaceWebService service.
     *
     * Responses are loaded from local XML files. You can tweak XML files to
     * experiment with various outputs during development
     *
     * XML files available under MarketplaceWebService/Mock tree
     *
     ***********************************************************************/
    // $service = new MarketplaceWebService_Mock();

    /************************************************************************
     * Setup request parameters and uncomment invoke to try out 
     * sample for Report Action
     ***********************************************************************/
    // Constructing the MarketplaceId array which will be passed in as the the MarketplaceIdList 
    // parameter to the RequestReportRequest object.
    //$marketplaceIdArray = array("Id" => array('<Marketplace_Id_1>','<Marketplace_Id_2>'));
    //$marketplaceIdArray = array("Id" => array('ATVPDKIKX0DER'));

    // @TODO: set request. Action can be passed as MarketplaceWebService_Model_ReportRequest
    // object or array of parameters

    // $parameters = array (
    //   'Merchant' => MERCHANT_ID,
    //   'MarketplaceIdList' => $marketplaceIdArray,
    //   'ReportType' => '_GET_MERCHANT_LISTINGS_DATA_',
    //   'ReportOptions' => 'ShowSalesChannel=true',
    //   'MWSAuthToken' => '<MWS Auth Token>', // Optional
    // );

    // $request = new MarketplaceWebService_Model_RequestReportRequest($parameters);

    $request = new MarketplaceWebService_Model_RequestReportRequest();
    $request->setMarketplaceIdList($marketplaceIdArray);
    $request->setMerchant($data['sellerid']);
    $request->setReportType('_GET_MERCHANT_LISTINGS_DATA_');
    $request->setMWSAuthToken($data['mwsauthtoken']); // Optional
    log_message('info',"ok 11 done populatin the mysql");

    // Using ReportOptions
    // $request->setReportOptions('ShowSalesChannel=true');

    // log_message('error',self::invokeRequestReport($service, $request));  
    $check_id=self::invokeRequestReport($service, $request);  
    log_message('info',"ok 12 done populatin the mysql");
    while(TRUE)
    {
      log_message('info',"Dynamic Sleepin for 120 seconds for ".$data['sellerid']);
      $id=self::getreportlist($data['marketplaceid'],$data['sellerid'],$check_id);   
      if($id=="cancelled")
        break;
      if($id=="notfound")
      {
        sleep(120);
        continue;
      }
      self::getreport($data['sellerid'],$id,$data['marketplaceid']);
      log_message('info',"ok  done populatin the mysql");
      // now again refrehs the listing
      // sleep(300);
      // $res=self::invokeRequestReport();
      break;
      //now udate the mysql tabel


    }                                    
  }

  static public function pricemap_report($job)
  {
    return true;
    //  global $marketplaceIdArray;    
    /// we have sellerid , mkpid , and token
    $data = unserialize($job->workload());
    log_message('info',print_r($data,TRUE));
    log_message('info','printing the secret key');
    log_message('info',AWS_SECRET_ACCESS_KEY);
    log_message('info','printing the secret key11');         
    $marketplaceIdArray = array("Id" => array(trim($data['marketplaceid'])));
    $serviceUrl = "https://mws.amazonservices.com";

    $config = array (
      'ServiceURL' => $serviceUrl,
      'ProxyHost' => null,
      'ProxyPort' => -1,
      'MaxErrorRetry' => 3,
    );

    $service = new MarketplaceWebService_Client(
      AWS_ACCESS_KEY_ID, 
      AWS_SECRET_ACCESS_KEY, 
      $config,
      APPLICATION_NAME,
      APPLICATION_VERSION);

    /************************************************************************
     * Uncomment to try out Mock Service that simulates MarketplaceWebService
     * responses without calling MarketplaceWebService service.
     *
     * Responses are loaded from local XML files. You can tweak XML files to
     * experiment with various outputs during development
     *
     * XML files available under MarketplaceWebService/Mock tree
     *
     ***********************************************************************/
    // $service = new MarketplaceWebService_Mock();

    /************************************************************************
     * Setup request parameters and uncomment invoke to try out 
     * sample for Report Action
     ***********************************************************************/
    // Constructing the MarketplaceId array which will be passed in as the the MarketplaceIdList 
    // parameter to the RequestReportRequest object.
    //$marketplaceIdArray = array("Id" => array('<Marketplace_Id_1>','<Marketplace_Id_2>'));
    //$marketplaceIdArray = array("Id" => array('ATVPDKIKX0DER'));

    // @TODO: set request. Action can be passed as MarketplaceWebService_Model_ReportRequest
    // object or array of parameters

    // $parameters = array (
    //   'Merchant' => MERCHANT_ID,
    //   'MarketplaceIdList' => $marketplaceIdArray,
    //   'ReportType' => '_GET_MERCHANT_LISTINGS_DATA_',
    //   'ReportOptions' => 'ShowSalesChannel=true',
    //   'MWSAuthToken' => '<MWS Auth Token>', // Optional
    // );

    // $request = new MarketplaceWebService_Model_RequestReportRequest($parameters);

    $request = new MarketplaceWebService_Model_RequestReportRequest();
    $request->setMarketplaceIdList($marketplaceIdArray);
    $request->setMerchant($data['sellerid']);
    $request->setReportType('_GET_MERCHANT_LISTINGS_DATA_');
    $request->setMWSAuthToken($data['mwsauthtoken']); // Optional

    // Using ReportOptions
    // $request->setReportOptions('ShowSalesChannel=true');

    // log_message('error',self::invokeRequestReport($service, $request));  
    $check_id=self::invokeRequestReport($service, $request);  
    {
      $id=self::getreportlist($data['marketplaceid'],$data['sellerid'],$check_id);   
      self::getreport($data['sellerid'],$id,$data['marketplaceid']);
      log_message('info',"ok  done populating the price map  the mysql");
    }                                    
  } 






  public function printme()
  {  
    if(!$this->input->is_cli_request())
    {
      log_message('info',"createamazonupdate_workers my only be accessed from the command line");
      return;
    }
  }
  static public function getreport($sellerid,$reportid,$marketplaceid,$func_name='')
  {     
    log_message('info',"Actually getting the csv file");
    ///    $serviceUrl="https://mws.amazonservices.com";
    $serviceUrl = self::$CI->config->item($marketplaceid,'gl_serviceurl');
    $config = array (
      'ServiceURL' => $serviceUrl,
      'ProxyHost' => null,
      'ProxyPort' => -1,
      'MaxErrorRetry' => 3
    );

    //    $awskey='AKIAIPGAVOI4KG2HPRZA';
    ///  $secret='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';
    $service = new  MarketplaceWebService_Client(AWS_ACCESS_KEY_ID,AWS_SECRET_ACCESS_KEY,$config,self::$appname,self::$appversion);     
    $request = new MarketplaceWebService_Model_GetReportRequest();
    $request->setMerchant($sellerid);
    $request->setReport(@fopen('php://memory', 'rw+'));
    $request->setReportId(''.$reportid);
    self::$CI =& get_instance();               
    $log_array=self::$CI->db->get_where("user_settings",array("sellerid"=>$sellerid,"marketplaceid"=>$marketplaceid))->row_array();
    $request->setMWSAuthToken($log_array['mwsauthtoken']); // Optional
    self::invokeGetReport($sellerid,$service, $request,$marketplaceid,$func_name);        

  } 

  static public function update_on_new($sellerid, $sku,$marketplaceid)
  {
    self::$CI =& get_instance();               
    $log_array=self::$CI->db->get_where("user_listings",array("sellerid"=>$sellerid,"marketplaceid"=>$marketplaceid,"sku"=>$sku))->row_array();
    if($log_array)
    {
      $okthen=self::$CI->db->escape($log_array['last_modified']);
      $diff=self::$CI->db->query("select TIMESTAMPDIFF(MINUTE,".$okthen.",NOW()) as mydiff")->row_array();
      log_message('info',"Currently checking ".$sellerid.$sku);
      if($diff['mydiff']>=30)
      {
        log_message('info',"Safe to update then".$sellerid.$sku);
        return TRUE;
      }
      log_message('info',"Un Safe to update then".$sellerid.$sku);
      return FALSE;
    }
    else
    {
      return TRUE;
    }                                
  }          
  static public function invokemeGetCompetitivePricingForSKU(MarketplaceWebServiceProducts_Interface $service, $request
    ,array &$myarray)
  {
    log_message('info',"inside invokeGetmyCompetitivePricingForSKU");
    try {
    log_message('info',"inside17 invokeGetmyCompetitivePricingForSKU");
      $response = $service->GetCompetitivePricingForSKU($request);
    log_message('info',"inside16 invokeGetmyCompetitivePricingForSKU");

      $dom = new DOMDocument();
      $dom->loadXML($response->toXML());
      $dom->preserveWhiteSpace = false;
      $dom->formatOutput = true;   
    log_message('info',"inside11 invokeGetmyCompetitivePricingForSKU");
      $type= $dom->saveXML();
      $xml=simplexml_load_string($response->toXML());
    log_message('info',"inside111 ".print_r($xml,TRUE));
      foreach($xml->GetCompetitivePricingForSKUResult as $prices)
      {
        $sku= trim($prices->attributes()->SellerSKU);
        $status= trim($prices->attributes()->status);
        if($status=="Success")
        {
          if(isset($prices->Product) && isset($prices->Product->CompetitivePricing) && isset($prices->Product->CompetitivePricing->CompetitivePrices))
          {
    log_message('info',"inside12 invokeGetmyCompetitivePricingForSKU");
            foreach($prices->Product->CompetitivePricing->CompetitivePrices->CompetitivePrice as $cprice)
            {
              // attributes 
              if( strcasecmp(trim($cprice->attributes()->condition),$myarray[$sku]['item_condition'])==0 &&   strcasecmp(trim($cprice->attributes()->subcondition),$myarray[$sku]['item_subcondition'])==0)
              {
                //store the values 
    log_message('info',"inside13 invokeGetmyCompetitivePricingForSKU");
                $bb_status= trim($cprice->attributes()->belongsToRequester);
                $bb_price= trim($cprice->Price->LandedPrice->Amount);
                $bb_lprice= trim($cprice->Price->ListingPrice->Amount);
                $bb_sprice= trim($cprice->Price->Shipping->Amount);
                if(strcasecmp($bb_status,'false')==0)
                  $myarray[$sku]["bb"]='no';
                else
                  $myarray[$sku]["bb"]='yes';
                log_message('info',"inside15 invokeGetmyCompetitivePricingForSKU");
                $myarray[$sku]["bb_price"]=$bb_price;
                // some error checking
                if((int)$bb_lprice<=1){
                  $message=print_r($xml,TRUE);
                  error_log($message,1, "repricinglegend@gmail.com");
                }
                $myarray[$sku]["bb_lprice"]=$bb_lprice;
                $myarray[$sku]["bb_sprice"]=$bb_sprice;
                log_message('info',"inside14 invokeGetmyCompetitivePricingForSKU");
                break;
              }

            }
          }
        }
      }

    } catch (MarketplaceWebServiceProducts_Exception $ex) {
    log_message('info',"inside16 invokeGetmyCompetitivePricingForSKU");
      log_message('error',$ex->getMessage()); 
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

    log_message('info',"ending invokeGetCompetitivePricingForSKU");
    return $myarray;
  }  
  static public function invokemyGetCompetitivePricingForSKU(MarketplaceWebServiceProducts_Interface $service, $request
    ,array &$myarray)
  {
    log_message('info',"inside invokeGetmyCompetitivePricingForSKU");
    try {
    log_message('info',"inside17 invokeGetmyCompetitivePricingForSKU");
      $response = $service->GetCompetitivePricingForSKU($request);
    log_message('info',"inside16 invokeGetmyCompetitivePricingForSKU");

      $dom = new DOMDocument();
      $dom->loadXML($response->toXML());
      $dom->preserveWhiteSpace = false;
      $dom->formatOutput = true;   
    log_message('info',"inside11 invokeGetmyCompetitivePricingForSKU");
      $type= $dom->saveXML();
      $xml=simplexml_load_string($response->toXML());
    log_message('info',"inside111 ".print_r($xml,TRUE));
      foreach($xml->GetCompetitivePricingForSKUResult as $prices)
      {
        $sku= trim($prices->attributes()->SellerSKU);
        $status= trim($prices->attributes()->status);
        if($status=="Success")
        {
          if(isset($prices->Product) && isset($prices->Product->CompetitivePricing) && isset($prices->Product->CompetitivePricing->CompetitivePrices))
          {
    log_message('info',"inside12 invokeGetmyCompetitivePricingForSKU");
            foreach($prices->Product->CompetitivePricing->CompetitivePrices->CompetitivePrice as $cprice)
            {
              // attributes 
              if( strcasecmp(trim($cprice->attributes()->condition),$myarray['item_condition'])==0 &&   strcasecmp(trim($cprice->attributes()->subcondition),$myarray['item_subcondition'])==0)
              {
                //store the values 
    log_message('info',"inside13 invokeGetmyCompetitivePricingForSKU");
                $bb_status= trim($cprice->attributes()->belongsToRequester);
                $bb_price= trim($cprice->Price->LandedPrice->Amount);
                $bb_lprice= trim($cprice->Price->ListingPrice->Amount);
                if((int)$bb_lprice<=1){
                  $message=print_r($xml,TRUE);
                  error_log($message,1, "repricinglegend@gmail.com");
                }
                $bb_sprice= trim($cprice->Price->Shipping->Amount);
                if(strcasecmp($bb_status,'false')==0)
                  $myarray["bb"]='no';
                else
                  $myarray["bb"]='yes';
    log_message('info',"inside15 invokeGetmyCompetitivePricingForSKU");
                $myarray["bb_price"]=$bb_price;
                $myarray["bb_lprice"]=$bb_lprice;
                $myarray["bb_sprice"]=$bb_sprice;
    log_message('info',"inside14 invokeGetmyCompetitivePricingForSKU");
                break;
              }

            }
          }
        }
      }

    } catch (MarketplaceWebServiceProducts_Exception $ex) {
    log_message('info',"inside16 invokeGetmyCompetitivePricingForSKU");
      log_message('error',$ex->getMessage()); 
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

    log_message('info',"ending invokeGetCompetitivePricingForSKU");
    return $myarray;
  }
          
  static public function invokeGetCompetitivePricingForSKU(MarketplaceWebServiceProducts_Interface $service, $request
    ,array &$myarray)
  {
    log_message('info',"inside invokeGetCompetitivePricingForSKU");
    try {
      $response = $service->GetCompetitivePricingForSKU($request);

      $dom = new DOMDocument();
      $dom->loadXML($response->toXML());
      $dom->preserveWhiteSpace = false;
      $dom->formatOutput = true;   
      $type= $dom->saveXML();
      $xml=simplexml_load_string($response->toXML());
      foreach($xml->GetCompetitivePricingForSKUResult as $prices)
      {
        $sku= trim($prices->attributes()->SellerSKU);
        $status= trim($prices->attributes()->status);
        if($status=="Success")
        {
          if(isset($prices->Product) && isset($prices->Product->CompetitivePricing) && isset($prices->Product->CompetitivePricing->CompetitivePrices))
          {
            foreach($prices->Product->CompetitivePricing->CompetitivePrices->CompetitivePrice as $cprice)
            {
              // attributes 
              if( strcasecmp(trim($cprice->attributes()->condition),$myarray[$sku]['condition'])==0 &&   strcasecmp(trim($cprice->attributes()->subcondition),$myarray[$sku]['subcondition'])==0)
              {
                //store the values 
                $bb_status= trim($cprice->attributes()->belongsToRequester);
                $bb_price= trim($cprice->Price->LandedPrice->Amount);
                if(strcasecmp($bb_status,'false')==0)
                  $myarray[$sku]["bb"]='no';
                else
                  $myarray[$sku]["bb"]='yes';
                $myarray["$sku"]["bb_price"]=$bb_price;
                break;
              }

            }
          }
        }
      }

    } catch (MarketplaceWebServiceProducts_Exception $ex) {
      log_message('error',$ex->getMessage()); 
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

    return $myarray;
  }


  static public  function invokeGetMyPriceForSKU(MarketplaceWebServiceProducts_Interface $service, $request,array &$myarray)
  {
    log_message('info',"inside invokeGetMyPriceForSKU");
    try {
      $response = $service->GetMyPriceForSKU($request);


      $dom = new DOMDocument();
      $dom->loadXML($response->toXML());
      $dom->preserveWhiteSpace = false;
      $dom->formatOutput = true;
      $type= $dom->saveXML();
      $xml=simplexml_load_string($response->toXML());
      foreach($xml->GetMyPriceForSKUResult as $prices)
      {
        $sku= trim($prices->attributes()->SellerSKU);
        $status= trim($prices->attributes()->status);
        if($status=="Success")
        { 
          if(isset($prices->Product) && isset($prices->Product->Offers))
          {
            foreach($prices->Product->Offers->Offer as $offer)
            {
              $myarray[$sku]['price']=trim($offer->BuyingPrice->ListingPrice->Amount);
              $myarray[$sku]['ship_price']=isset($offer->BuyingPrice->Shipping->Amount)?trim($offer->BuyingPrice->Shipping->Amount):'notset';
              break;
            }
          }
        }
      }

    } catch (MarketplaceWebServiceProducts_Exception $ex) {
      log_message('error',$ex->getMessage());
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

    return $myarray;

    //    print_r($myarray);
  }
   static public  function invokemyGetLowestOfferListingsForSKU(MarketplaceWebServiceProducts_Interface $service, $request,
    array &$myarray)
  {

    // csotm arra
    $cuustom["AMAZON_NA"]="amazon";
    $cuustom["DEFAULT"]="merchant";
    log_message('info',"inside GetLowestOfferListingsForSKUResult");
    try {
      $response = $service->GetLowestOfferListingsForSKU($request);
      $dom = new DOMDocument();
      $dom->loadXML($response->toXML());
      $dom->preserveWhiteSpace = false;
      $dom->formatOutput = true;        
      $dom->saveXML();
      $xml=simplexml_load_string($response->toXML());
      foreach($xml->GetLowestOfferListingsForSKUResult as $prices)
      {
        $sku= trim($prices->attributes()->SellerSKU);
        $myarray[$sku]['match_status']='unmatched';
        $status= trim($prices->attributes()->status);
        if($status=="Success")
        {
          if(isset($prices->Product) && isset($prices->Product->LowestOfferListings))
          {
            foreach($prices->Product->LowestOfferListings->LowestOfferListing as $cprice)
            {
              $attt=$cprice->Qualifiers;
              $bbship= trim($cprice->Price->Shipping->Amount);
              $bb_status= trim($cprice->Price->LandedPrice->Amount);
              if( strcasecmp(trim($attt->ItemCondition),$myarray[$sku]['item_condition'])==0 &&   strcasecmp(trim($attt->ItemSubcondition),$myarray[$sku]['item_subcondition'])==0 && (float)$myarray[$sku]['bb_price']==(float)$bb_status && (float)$bbship==(float)$myarray[$sku]['bb_sprice'])
              {
                // comptititon type
                if(($myarray[$sku]['comp_type']=="all" || $myarray[$sku]['comp_type']=="amazon" || $myarray[$sku]['comp_type']=="fba" || $myarray[$sku]['comp_type']=="amazonandfba" ) &&  $myarray[$sku]['fulfillment_channel']=='AMAZON_NA')
                {
                $myarray[$sku]['match_status']='matched';
                break;
                }
                else if(($myarray[$sku]['comp_type']=="all" || $myarray[$sku]['comp_type']=="nonfba") &&  $myarray[$sku]['fulfillment_channel']=='DEFAULT')
                {
                $myarray[$sku]['match_status']='matched';
                break;
                }
              }
            }
          }
        }
      }
      //     print_r($myarray);                                   

    } catch (MarketplaceWebServiceProducts_Exception $ex) {
      log_message('error',$ex->getMessage());
    }
   // return $myarray;
  }         
  static public  function invokeGetLowestOfferListingsForSKU(MarketplaceWebServiceProducts_Interface $service, $request,
    array &$myarray)
  {

    // csotm arra
    $cuustom["AMAZON_NA"]="amazon";
    $cuustom["DEFAULT"]="merchant";
    log_message('info',"inside GetLowestOfferListingsForSKUResult");
    try {
      $response = $service->GetLowestOfferListingsForSKU($request);
      $dom = new DOMDocument();
      $dom->loadXML($response->toXML());
      $dom->preserveWhiteSpace = false;
      $dom->formatOutput = true;        
      $dom->saveXML();
      $xml=simplexml_load_string($response->toXML());
      foreach($xml->GetLowestOfferListingsForSKUResult as $prices)
      {
        $sku= trim($prices->attributes()->SellerSKU);
        $status= trim($prices->attributes()->status);
        if($status=="Success")
        {
          $count=1;
          if(isset($prices->Product) && isset($prices->Product->LowestOfferListings))
          {
            foreach($prices->Product->LowestOfferListings->LowestOfferListing as $cprice)
            {
              // attributes 
              $attt=$cprice->Qualifiers;
              if($count>=10)
                break;
              if( strcasecmp(trim($attt->ItemCondition),$myarray[$sku]['condition'])==0 &&   strcasecmp(trim($attt->ItemSubcondition),$myarray[$sku]['subcondition'])==0
                && strcasecmp(trim($attt->FulfillmentChannel),$cuustom[$myarray[$sku]['fulfillment-channel']])==0)
              {
                //store the values 
                $bb_status= trim($cprice->Price->LandedPrice->Amount);
             //   $myarray[$sku]['c1'][]="Unknown/".$bb_status;
                $myarray[$sku]['c1'][]=$bb_status;
                $count+=1;
              }

            }
          }
        }
      }
      //     print_r($myarray);                                   

    } catch (MarketplaceWebServiceProducts_Exception $ex) {
      log_message('error',$ex->getMessage());
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
    return $myarray;
  }
  static public function xml2array ( $xmlObject, $out = array () )
  {
    foreach ( (array) $xmlObject as $index => $node )
      $out[$index] = ( is_object ( $node ) ) ? xml2array ( $node ) : $node;

    return $out;
  }
  static public function invokeListInventorySupply(FBAInventoryServiceMWS_Interface $service, $request,array &$myarray)
  {
    try {
      $response = $service->ListInventorySupply($request);
      $dom = new DOMDocument();
      $dom->loadXML($response->toXML());
      $dom->preserveWhiteSpace = false;
      $dom->formatOutput = true;
      $dom->saveXML();
      $xml=simplexml_load_string($response->toXML());
   //   error_log($response->toXML(), 3, "/var/tmp/my-errors.log");
      $xmlarray=($xml);
      if(isset($xmlarray->ListInventorySupplyResult->InventorySupplyList->member))
      { 
        foreach($xmlarray->ListInventorySupplyResult->InventorySupplyList->member as $values)
        {
          if($myarray[(string)trim($values->SellerSKU)]['fulfillment-channel']=='AMAZON_NA')
          {
            log_message('error','now chckign InventorySupplyList '.$values->SellerSKU);
            $myarray[(string)trim($values->SellerSKU)]['qty']=trim($values->InStockSupplyQuantity);
          }
        }
      }

    } catch (FBAInventoryServiceMWS_Exception $ex) {
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
    return $myarray;
  }
  static public function update_fba_qty (array &$return_array , $myarray)
  { 
    $serviceUrl = self::$CI->config->item($myarray['marketplaceid'],'gl_serviceurl')."/FulfillmentInventory/2010-10-01";
    log_message('info',"inside inventory");
    $config = array ( 'ServiceURL' => $serviceUrl, 'ProxyHost' => null, 'ProxyPort' => -1, 'MaxErrorRetry' => 3,);
    $service = new FBAInventoryServiceMWS_Client(
      AWS_ACCESS_KEY_ID,
      AWS_SECRET_ACCESS_KEY,
      APPLICATION_NAME,
      APPLICATION_VERSION,
      $config);
    $offset=0;
    $end=(int)count($return_array);
    if($end > 50)
    {
      while($offset<$end)
      {
        $temp_array=array_slice($return_array,$offset,50,TRUE);

        $request = new FBAInventoryServiceMWS_Model_ListInventorySupplyRequest();
        $request->setSellerId($myarray['sellerid']);
        $request->setMarketplace($myarray['marketplaceid']);
        $request->setMWSAuthToken($myarray['mwsauthtoken']);
        $sku=new FBAInventoryServiceMWS_Model_SellerSkuList();
        call_user_func_array(array($sku,"withmember"),array_keys($temp_array));  
        $request->setSellerSkus($sku);
        log_message('info',"11inside inventory");
        //    $request->setItemCondition(true);
        // object or array of parameters  

        $return_array=(self::invokeListInventorySupply($service, $request,$temp_array)+$return_array);
        log_message('info',"11222inside inventory");
        $offset+=50;
      }

    }
    else
    {    
      $request = new FBAInventoryServiceMWS_Model_ListInventorySupplyRequest();
      $request->setSellerId($myarray['sellerid']);
      $request->setMarketplace($myarray['marketplaceid']);
      $request->setMWSAuthToken($myarray['mwsauthtoken']);
      $sku=new FBAInventoryServiceMWS_Model_SellerSkuList();
      call_user_func_array(array($sku,"withmember"),array_keys($return_array));  
      $request->setSellerSkus($sku);
      log_message('info',"11inside inventory");
      //    $request->setItemCondition(true);
      // object or array of parameters  

      self::invokeListInventorySupply($service, $request,$return_array);

    }
  }
  static public function mycompare_price(array &$return_array , $myarray)
  { 
       $serviceUrl = "https://mws.amazonservices.com/Products/2011-10-01";
    $config = array ( 'ServiceURL' => $serviceUrl, 'ProxyHost' => null, 'ProxyPort' => -1, 'MaxErrorRetry' => 3,);
    $service = new MarketplaceWebServiceProducts_Client(
      AWS_ACCESS_KEY_ID,
      AWS_SECRET_ACCESS_KEY,
      APPLICATION_NAME,
      APPLICATION_VERSION,
      $config); 
    $offset=0;
    $end=(int)count($return_array);
    if($end > 20)
    {
      while($offset<$end)
      {

        log_message('info','offste value is'.$offset);
        log_message('info','array  value is'.print_r($return_array,TRUE));
        $temp_array=array_slice($return_array,$offset,20,TRUE);
        $sku = new MarketplaceWebServiceProducts_Model_SellerSKUListType();
        call_user_func_array(array($sku,"withSellerSKU"),array_keys($temp_array));  
       
        /// for getting my price
        $request_new = new MarketplaceWebServiceProducts_Model_GetMyPriceForSKURequest();
        $request_new->setSellerId($myarray['sellerid']);
        $request_new->setMarketplaceId($myarray['marketplaceid']);
        $request_new->setMWSAuthToken($myarray['mwsauthtoken']); 
        $request_new->setSellerSKUList($sku);
        //$return_array=array_merge($return_array,self::invokeGetMyPriceForSKU($service, $request_new,$temp_array));
        $return_array=(self::invokeGetMyPriceForSKU($service, $request_new,$temp_array)+$return_array);

        /// for getting the bb status 
        $request_bb = new MarketplaceWebServiceProducts_Model_GetCompetitivePricingForSKURequest();
        $request_bb->setSellerId($myarray['sellerid']);
        $request_bb->setMarketplaceId($myarray['marketplaceid']);
        $request_bb->setMWSAuthToken($myarray['mwsauthtoken']);  
        $request_bb->setSellerSKUList($sku);    // object or array of parameters
        //  $return_array=array_merge($return_array,self::invokeGetCompetitivePricingForSKU($service, $request_bb,$temp_array));
        $return_array=(self::invokemeGetCompetitivePricingForSKU($service, $request_bb,$temp_array)+$return_array);  
       
       
        $request = new MarketplaceWebServiceProducts_Model_GetLowestOfferListingsForSKURequest();
        $request->setSellerId($myarray['sellerid']);
        $request->setMarketplaceId($myarray['marketplaceid']);
        $request->setMWSAuthToken($myarray['mwsauthtoken']);
        $request->setSellerSKUList($sku);
        $request->setExcludeMe(true);
        $return_array=(self::invokemyGetLowestOfferListingsForSKU($service, $request,$temp_array)+$return_array);
                                                       
        $offset+=20;
        log_message('info','final offset value is'.$offset);
      }
    }
    else
    {    
    
      $sku = new MarketplaceWebServiceProducts_Model_SellerSKUListType();
      call_user_func_array(array($sku,"withSellerSKU"),array_keys($return_array));  
      /// for getting my price
      $request_new = new MarketplaceWebServiceProducts_Model_GetMyPriceForSKURequest();
      $request_new->setSellerId($myarray['sellerid']);
      $request_new->setMarketplaceId($myarray['marketplaceid']);
      $request_new->setMWSAuthToken($myarray['mwsauthtoken']); 
      $request_new->setSellerSKUList($sku);
      self::invokeGetMyPriceForSKU($service, $request_new,$return_array);

      log_message('error','after gte my price '.print_r($return_array,TRUE));
      /// for getting the bb status 
      $request_bb = new MarketplaceWebServiceProducts_Model_GetCompetitivePricingForSKURequest();
      $request_bb->setSellerId($myarray['sellerid']);
      $request_bb->setMarketplaceId($myarray['marketplaceid']);
      $request_bb->setMWSAuthToken($myarray['mwsauthtoken']);  
      $request_bb->setSellerSKUList($sku);    // object or array of parameters
      self::invokemeGetCompetitivePricingForSKU($service, $request_bb,$return_array);     
    
      log_message('error','after copetiont  my price '.print_r($return_array,TRUE));
    
      $request = new MarketplaceWebServiceProducts_Model_GetLowestOfferListingsForSKURequest();
      $request->setSellerId($myarray['sellerid']);
      $request->setMarketplaceId($myarray['marketplaceid']);
      $request->setMWSAuthToken($myarray['mwsauthtoken']);
      $request->setSellerSKUList($sku);
      $request->setExcludeMe(false);
      //    $request->setItemCondition(true);
      // object or array of parameters  

      self::invokemyGetLowestOfferListingsForSKU($service, $request,$return_array);
                                                                                                  
    }
    log_message('info','final offset value is'.$offset);

  }     
  static public function compare_price(array &$return_array , $myarray)
  { 
    $serviceUrl = "https://mws.amazonservices.com/Products/2011-10-01";
    $config = array ( 'ServiceURL' => $serviceUrl, 'ProxyHost' => null, 'ProxyPort' => -1, 'MaxErrorRetry' => 3,);
    $service = new MarketplaceWebServiceProducts_Client(
      AWS_ACCESS_KEY_ID,
      AWS_SECRET_ACCESS_KEY,
      APPLICATION_NAME,
      APPLICATION_VERSION,
      $config); 
    $offset=0;
    $end=(int)count($return_array);
    if($end > 20)
    {
      while($offset<$end)
      {

        log_message('info','offste value is'.$offset);
        log_message('info','array  value is'.print_r($return_array,TRUE));
        $temp_array=array_slice($return_array,$offset,20,TRUE);
        $request = new MarketplaceWebServiceProducts_Model_GetLowestOfferListingsForSKURequest();
        $sku = new MarketplaceWebServiceProducts_Model_SellerSKUListType();
        call_user_func_array(array($sku,"withSellerSKU"),array_keys($temp_array));  
        $request->setSellerId($myarray['sellerid']);
        $request->setMarketplaceId($myarray['marketplaceid']);
        $request->setMWSAuthToken($myarray['mwsauthtoken']);
        $request->setSellerSKUList($sku);
        $request->setExcludeMe(true);
        //    $request->setItemCondition(true);
        // object or array of parameters  

        // $return_array=array_merge($return_array,self::invokeGetLowestOfferListingsForSKU($service, $request,$temp_array));
        $return_array=(self::invokeGetLowestOfferListingsForSKU($service, $request,$temp_array)+$return_array);

        /// for getting my price
        $request_new = new MarketplaceWebServiceProducts_Model_GetMyPriceForSKURequest();
        $request_new->setSellerId($myarray['sellerid']);
        $request_new->setMarketplaceId($myarray['marketplaceid']);
        $request_new->setMWSAuthToken($myarray['mwsauthtoken']); 
        $request_new->setSellerSKUList($sku);
        //$return_array=array_merge($return_array,self::invokeGetMyPriceForSKU($service, $request_new,$temp_array));
        $return_array=(self::invokeGetMyPriceForSKU($service, $request_new,$temp_array)+$return_array);

        /// for getting the bb status 
        $request_bb = new MarketplaceWebServiceProducts_Model_GetCompetitivePricingForSKURequest();
        $request_bb->setSellerId($myarray['sellerid']);
        $request_bb->setMarketplaceId($myarray['marketplaceid']);
        $request_bb->setMWSAuthToken($myarray['mwsauthtoken']);  
        $request_bb->setSellerSKUList($sku);    // object or array of parameters
        //  $return_array=array_merge($return_array,self::invokeGetCompetitivePricingForSKU($service, $request_bb,$temp_array));
        $return_array=(self::invokeGetCompetitivePricingForSKU($service, $request_bb,$temp_array)+$return_array);
        $offset+=20;
        log_message('info','final offset value is'.$offset);
      }
    }
    else
    {    
      $request = new MarketplaceWebServiceProducts_Model_GetLowestOfferListingsForSKURequest();
      $sku = new MarketplaceWebServiceProducts_Model_SellerSKUListType();
      call_user_func_array(array($sku,"withSellerSKU"),array_keys($return_array));  
      $request->setSellerId($myarray['sellerid']);
      $request->setMarketplaceId($myarray['marketplaceid']);
      $request->setMWSAuthToken($myarray['mwsauthtoken']);
      $request->setSellerSKUList($sku);
      $request->setExcludeMe(true);
      //    $request->setItemCondition(true);
      // object or array of parameters  

      self::invokeGetLowestOfferListingsForSKU($service, $request,$return_array);

      /// for getting my price
      $request_new = new MarketplaceWebServiceProducts_Model_GetMyPriceForSKURequest();
      $request_new->setSellerId($myarray['sellerid']);
      $request_new->setMarketplaceId($myarray['marketplaceid']);
      $request_new->setMWSAuthToken($myarray['mwsauthtoken']); 
      $request_new->setSellerSKUList($sku);
      self::invokeGetMyPriceForSKU($service, $request_new,$return_array);

      /// for getting the bb status 
      $request_bb = new MarketplaceWebServiceProducts_Model_GetCompetitivePricingForSKURequest();
      $request_bb->setSellerId($myarray['sellerid']);
      $request_bb->setMarketplaceId($myarray['marketplaceid']);
      $request_bb->setMWSAuthToken($myarray['mwsauthtoken']);  
      $request_bb->setSellerSKUList($sku);    // object or array of parameters
      self::invokeGetCompetitivePricingForSKU($service, $request_bb,$return_array);
    }
    log_message('info','final offset value is'.$offset);

  }
  static public function processfile($filename,$sellerid,$marketplaceid)
  {
    log_message('info',"processing the report list  ");
    $result = array();
    $fp = fopen($filename,'r');
    if (($headers = fgetcsv($fp, 0, "\t")) !== FALSE)
      if ($headers)
        while (($line = fgetcsv($fp, 0, "\t")) !== FALSE) 
          if ($line)
            if (sizeof($line)==sizeof($headers))
              $result[] = array_combine($headers,array_map("utf8_encode", $line));
    fclose($fp);      
    log_message('info',print_r($result,TRUE));
    self::$CI =& get_instance();               
    $log_array=self::$CI->db->get_where("user_settings",array("sellerid"=>$sellerid,"marketplaceid"=>$marketplaceid))->row_array();
    //garb all the sku and usellowest ogffer lsiitngs anf 
    $pass_array=array();
    foreach($result as $row)
    {                                                                                 
      log_message('error',"adding infomation .. ".$row['seller-sku']);
      list($condition,$subcondition)=check_condition($row['item-condition']); 
      $pass_array[(string)$row["seller-sku"]]=array("fulfillment-channel"=>$row["fulfillment-channel"],"condition"=>$condition,"subcondition"=>$subcondition);
    }
    // now udate me
    self::compare_price($pass_array,$log_array);
    self::update_fba_qty($pass_array,$log_array);
    log_message('info',"now updated values are  ".print_r($pass_array,TRUE));
    foreach($result as $row)
    {
      log_message('error',"updating .. ".$row['seller-sku']);
      if(self::update_on_new($sellerid,$row['seller-sku'],$marketplaceid)==FALSE)
      {
        log_message('error',"FAILED TO UPDATE ");
        continue;
      }
      $new=array(); 
      $new['sellerid']=$sellerid;
      $new['marketplaceid']=$marketplaceid;
      $new['itemname']=htmlentities($row['item-name']);
      $new['listing_id']=$row['listing-id'];
      $new['sku']=$row['seller-sku'];
      $new['price']=$row['price'];
      $new['qty']=$row['fulfillment-channel']=='AMAZON_NA' ? (int)$pass_array[(string)$row['seller-sku']]['qty']: (int)$row['quantity'];
      $new['marketplace']=$row['item-is-marketplace'];
      list($tempcon,$tempsub)=check_condition($row['item-condition']);
      $new['item_condition']=$tempcon;
      $new['item_subcondition']=$tempsub;
      $new['asin']=$row['asin1'];
      $new['product_id']=$row['product-id'];
      $new['product_id_type']=$row['product-id-type'];
      $new['fulfillment_channel']=$row['fulfillment-channel'];
      $new['ship_price']=isset($pass_array[(string)$row['seller-sku']]['ship_price'])?$pass_array[(string)$row['seller-sku']]['ship_price']:'notset';
      $new['bb']=isset($pass_array[(string)$row['seller-sku']]['bb'])?$pass_array[(string)$row['seller-sku']]['bb']:'no'; 
      $new['bb_price']=isset($pass_array[(string)$row['seller-sku']]['bb_price'])?$pass_array[(string)$row['seller-sku']]['bb_price']:'notset'; 

      /// now update the c1-c10 prices
      //      for($i=1;$i<=10;$i++)
      {
        if(isset($pass_array[(string)$row['seller-sku']]['c1']))
        {
          $new['c1']=serialize($pass_array[(string)$row['seller-sku']]['c1'][0]);
        }
      }
      //   $new['beatby']=;
      //    $new['map_price']=;
      $new['prevprice']=$row['price']; 
      //    $new['competitor_price']=;
      $new['email']=$log_array['email'];

      self::$CI->db_mysql->on_duplicate_key_update()->insert("user_listings",$new);
    }

  }  
  static public  function invokeGetReport($sellerid,MarketplaceWebService_Interface $service, $request,$marketplaceid,$func_name='') 
  {
    log_message('info',"Whoos almost reached here Getting the report list  ");
    try {
      $response = $service->getReport($request);

      if ($response->isSetGetReportResult()) {
        $getReportResult = $response->getGetReportResult(); 
        //                  echo ("            GetReport");

        if ($getReportResult->isSetContentMd5()) {
          //                  echo ("                ContentMd5");
          //                echo ("                " . $getReportResult->getContentMd5() . "\n");
        }
      }
      if ($response->isSetResponseMetadata()) { 
        //              echo("            ResponseMetadata\n");
        $responseMetadata = $response->getResponseMetadata();
        if ($responseMetadata->isSetRequestId()) 
        {
          //                echo("                RequestId\n");
          //              echo("                    " . $responseMetadata->getRequestId() . "\n");
        }
      }

      //  echo ("        Report Contents\n");
      //      $cur_time=time();
      $cur_time=mt_rand();
      $handle = fopen("/tmp/${cur_time}_test_".$sellerid.".csv", "w"); 
      fwrite($handle, stream_get_contents($request->getReport()));
      fclose($handle);
      //  echo (stream_get_contents($request->getReport()) . "\n");

      //    echo("            ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");
    } catch (MarketplaceWebService_Exception $ex) {
      /*
      echo("Caught Exception: " . $ex->getMessage() . "\n");
      echo("Response Status Code: " . $ex->getStatusCode() . "\n");
      echo("Error Code: " . $ex->getErrorCode() . "\n");
         echo("Error Type: " . $ex->getErrorType() . "\n");
         echo("Request ID: " . $ex->getRequestId() . "\n");
         echo("XML: " . $ex->getXML() . "\n");
         echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
       */
      log_message('error',"oops failed writing the csv file"); 
    }

    if($func_name=='amazon_fbafees')
      self::processfeesfile("/tmp/${cur_time}_test_".$sellerid.".csv",$sellerid,$marketplaceid);
    else
      self::processfile("/tmp/${cur_time}_test_".$sellerid.".csv",$sellerid,$marketplaceid);

    // now can we insert into my sql db 
    //    $CI =& get_instance();
    //    $log_array=$CI->db->get_where("user_settings",array("sellerid"=>$data['sellerid']))->row_array();
    //  $CI->db_mysql->on_duplicate_key_update()->insert("user_listings",array('email'=>$var,'name'=> $_POST["name"],'companyname'=> $_POST["companyname"],'phone'=> $_POST["phone"]));

    // now insert the data

  }                                                 
  static public function processfeesfile($filename,$sellerid,$marketplaceid)
  {
    $result = array();
    $fp = fopen($filename,'r');
    if (($headers = fgetcsv($fp, 0, "\t")) !== FALSE)
      if ($headers)
        while (($line = fgetcsv($fp, 0, "\t")) !== FALSE) 
          if ($line)
            if (sizeof($line)==sizeof($headers))
              $result[] = array_combine($headers,array_map("utf8_encode", $line));
    fclose($fp);      
    self::$CI =& get_instance();               
    foreach($result as $row)
    {                                                                                 
      //update the fees
 //     echo 'now updating fees for '.$row['sku'].PHP_EOL;
      $new=array(); 
//      $new['sellerid']=$sellerid;
 //     $new['marketplaceid']=$marketplaceid;
   //   $new['sku']=$row['sku'];
      $new['fees']= $row['estimated-fee-total'];
   //   $new['asin']=$row['asin'];
      // so add all te 4 bellow
   //   $new['fees']= $row['estimated-referral-fee-per-unit'];
    //  $new['fees']= $row['estimated-order-handling-fee-per-order'];
     // $new['fees']= $row['estimated-pick-pack-fee-per-unit'];
     // $new['fees']= $row['estimated-weight-handling-fee-per-unit'];
//      self::$CI->db_mysql->on_duplicate_key_update()->insert("user_listings",$new);
      self::$CI->db->update('user_listings', $new, array('sellerid' => $sellerid,'marketplaceid'=>$marketplaceid,'sku'=>$row['sku'],'asin'=>$row['asin']));
    }
  }
  static public function maxprice_update($sellerid,$sku,$mapprice,$marketplaceid)  
  {   
    //    $serviceUrl="https://mws.amazonservices.com";
    $serviceUrl = self::$CI->config->item($marketplaceid,'gl_serviceurl');
    $config = array (
      'ServiceURL' => $serviceUrl,
      'ProxyHost' => null,
      'ProxyPort' => -1,
      'MaxErrorRetry' => 3
    );

    //    $awskey='AKIAIPGAVOI4KG2HPRZA';
    ///  $secret='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';
    $service = new  MarketplaceWebService_Client(AWS_ACCESS_KEY_ID,AWS_SECRET_ACCESS_KEY,$config,self::$appname,self::$appversion);                      
    $log2_array=self::$CI->db->get_where("user_listings",array("sellerid"=>$sellerid,"marketplaceid"=>$marketplaceid,"sku"=>$sku))->row_array();
    $current_price=$log2_array['price'];
    $currency_code=self::$CI->config->item($marketplaceid,'gl_currency');
    $feed = <<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<AmazonEnvelope xsi:noNamespaceSchemaLocation="amznenvelope. xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"> 
<Header> 
<DocumentVersion>1.01</DocumentVersion> 
<MerchantIdentifier>$sellerid</MerchantIdentifier> 
</Header> 
<MessageType>Price</MessageType> 
<Message> <MessageID>1</MessageID> 
<Price> 
<SKU>$sku</SKU> 
<StandardPrice currency="$currency_code">$current_price</StandardPrice> 
<MaximumSellerAllowedPrice currency="$currency_code">$mapprice</MaximumSellerAllowedPrice>
</Price> 
</Message> 
</AmazonEnvelope>
EOD;

    $feedHandle = @fopen('php://memory', 'rw+');
    fwrite($feedHandle, $feed);
    rewind($feedHandle);

    $request = new MarketplaceWebService_Model_SubmitFeedRequest();
    $request->setMerchant($sellerid);
    $marketplaceIdArray = array("Id" => array(trim($marketplaceid)));
    $request->setMarketplaceIdList($marketplaceIdArray);
    $request->setFeedType('_POST_PRODUCT_PRICING_DATA_');
    //$request->setFeedType('_POST_PRODUCT_DATA_');
    $request->setContentMd5(base64_encode(md5(stream_get_contents($feedHandle), true)));
    rewind($feedHandle);
    $request->setPurgeAndReplace(false);
    $request->setFeedContent($feedHandle);
    self::$CI =& get_instance();               
    $log_array=self::$CI->db->get_where("user_settings",array("sellerid"=>$sellerid,"marketplaceid"=>$marketplaceid))->row_array();
    $request->setMWSAuthToken($log_array['mwsauthtoken']); // Optional

    rewind($feedHandle);

    log_message('info','About to send the feeds');                                 
    self::invokeSubmitFeed($service, $request);                                     
  }
  static public function minprice_update($sellerid,$sku,$mapprice,$marketplaceid) 
  {         
    //. get th current price 
    //     $serviceUrl="https://mws.amazonservices.com";
    $serviceUrl = self::$CI->config->item($marketplaceid,'gl_serviceurl');
    $config = array (
      'ServiceURL' => $serviceUrl,
      'ProxyHost' => null,
      'ProxyPort' => -1,
      'MaxErrorRetry' => 3
    );

    //    $awskey='AKIAIPGAVOI4KG2HPRZA';
    ///  $secret='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';
    $service = new  MarketplaceWebService_Client(AWS_ACCESS_KEY_ID,AWS_SECRET_ACCESS_KEY,$config,self::$appname,self::$appversion);      
    $log2_array=self::$CI->db->get_where("user_listings",array("sellerid"=>$sellerid,"marketplaceid"=>$marketplaceid,"sku"=>$sku))->row_array();
    $current_price=$log2_array['price'];
    $currency_code=self::$CI->config->item($marketplaceid,'gl_currency');
    $feed = <<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<AmazonEnvelope xsi:noNamespaceSchemaLocation="amznenvelope. xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"> 
<Header> 
<DocumentVersion>1.01</DocumentVersion> 
<MerchantIdentifier>$sellerid</MerchantIdentifier> 
</Header> 
<MessageType>Price</MessageType> 
<Message> <MessageID>1</MessageID> 
<Price> 
<SKU>$sku</SKU> 
<StandardPrice currency="$currency_code">$current_price</StandardPrice> 
<MinimumSellerAllowedPrice currency="$currency_code">$mapprice</MinimumSellerAllowedPrice>
</Price> 
</Message> 
</AmazonEnvelope>
EOD;

    $feedHandle = @fopen('php://memory', 'rw+');
    fwrite($feedHandle, $feed);
    rewind($feedHandle);

    $request = new MarketplaceWebService_Model_SubmitFeedRequest();
    $request->setMerchant($sellerid);
    $marketplaceIdArray = array("Id" => array(trim($marketplaceid)));
    $request->setMarketplaceIdList($marketplaceIdArray);
    $request->setFeedType('_POST_PRODUCT_PRICING_DATA_');
    //$request->setFeedType('_POST_PRODUCT_DATA_');
    $request->setContentMd5(base64_encode(md5(stream_get_contents($feedHandle), true)));
    rewind($feedHandle);
    $request->setPurgeAndReplace(false);
    $request->setFeedContent($feedHandle);
    self::$CI =& get_instance();               
    $log_array=self::$CI->db->get_where("user_settings",array("sellerid"=>$sellerid,"marketplaceid"=>$marketplaceid))->row_array();
    $request->setMWSAuthToken($log_array['mwsauthtoken']); // Optional

    rewind($feedHandle);

    log_message('info','About to send the feeds');                                 
    self::invokeSubmitFeed($service, $request);                                     
    // log thre results in database
  }  
  static function invokeSubmitFeed(MarketplaceWebService_Interface $service, $request) 
  {

  return self::invokeSubmitFeed_after($service, $request);
  //  if(self::invokeSubmitFeed_after($service, $request)=="tryagain")
    {
      // \try once again else drop it
 //     log_message('info',"trying again ".print_r($request,TRUE));
     // sleep(120);
    //  self::invokeSubmitFeed_after($service,$request);
    } 
  }
  static function invokeSubmitFeed_after(MarketplaceWebService_Interface $service, $request) 
  {
    try {
      $response = $service->submitFeed($request);
      $new=array();
      /*
       self::$CI =& get_instance();               
      $new['service']=serialize($service);
      $new['request']=serialize($request);
      $new['error']=serialize('no error');
      $new['response']=serialize($response);
      self::$CI->db->insert("feeds503",$new);
       */
      //    echo ("Service Response\n");
      //   echo ("=============================================================================\n");

      //   echo("        SubmitFeedResponse\n");
      if ($response->isSetSubmitFeedResult()) { 
        //        echo("            SubmitFeedResult\n");
        $submitFeedResult = $response->getSubmitFeedResult();
        if ($submitFeedResult->isSetFeedSubmissionInfo()) { 
          //          echo("                FeedSubmissionInfo\n");
          $feedSubmissionInfo = $submitFeedResult->getFeedSubmissionInfo();
          if ($feedSubmissionInfo->isSetFeedSubmissionId()) 
          {
            log_message('info',$feedSubmissionInfo->getFeedSubmissionId());
            return $feedSubmissionInfo->getFeedSubmissionId();


            //              echo("                    FeedSubmissionId\n");
            //             echo("                        " . $feedSubmissionInfo->getFeedSubmissionId() . "\n");
          }
          if ($feedSubmissionInfo->isSetFeedType()) 
          {
            //           echo("                    FeedType\n");
            //          echo("                        " . $feedSubmissionInfo->getFeedType() . "\n");
          }
          if ($feedSubmissionInfo->isSetSubmittedDate()) 
          {
            //        echo("                    SubmittedDate\n");
            ///      echo("                        " . $feedSubmissionInfo->getSubmittedDate()->format(DATE_FORMAT) . "\n");
          }
          if ($feedSubmissionInfo->isSetFeedProcessingStatus()) 
          {
            //    echo("                    FeedProcessingStatus\n");
            //   echo("                        " . $feedSubmissionInfo->getFeedProcessingStatus() . "\n");
          }
          if ($feedSubmissionInfo->isSetStartedProcessingDate()) 
          {
            //   echo("                    StartedProcessingDate\n");
            //  echo("                        " . $feedSubmissionInfo->getStartedProcessingDate()->format(DATE_FORMAT) . "\n");
          }
          if ($feedSubmissionInfo->isSetCompletedProcessingDate()) 
          {
            //   echo("                    CompletedProcessingDate\n");
            //  echo("                        " . $feedSubmissionInfo->getCompletedProcessingDate()->format(DATE_FORMAT) . "\n");
          }
        } 
      } 
      if ($response->isSetResponseMetadata()) { 
        //       echo("            ResponseMetadata\n");
        $responseMetadata = $response->getResponseMetadata();
        if ($responseMetadata->isSetRequestId()) 
        {
          //         echo("                RequestId\n");
          //        echo("                    " . $responseMetadata->getRequestId() . "\n");
        }
      } 

      //   echo("            ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");
    } catch (MarketplaceWebService_Exception $ex) {
      log_message('error',$ex->getMessage());
      log_message('error',$ex->getErrorCode());
    self::$CI =& get_instance();               
      $new['service']=serialize($service);
      $new['request']=serialize($request);
      $new['error']=serialize($ex->getMessage());
      $new['response']=serialize($response);
      if($ex->getErrorCode()=="QuotaExceeded" || $ex->getErrorCode()=="RequestThrottled")
      {
        // upat ethe mysql  table this hould not happen ok  

        self::$CI->db->insert("feeds503",$new);
        if($ex->getErrorCode()=="QuotaExceeded" )
        {
        }
        else
        {
          return "tryagain";
        } 
      }
      else
      {
        self::$CI->db->insert("feeds_error",$new);
      }
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
    return "tryagain";
  }                                                              
  static public function mapprice_update($sellerid,$sku,$mapprice,$marketplaceid)
  {            
    //    $serviceUrl="https://mws.amazonservices.com";
    $serviceUrl = self::$CI->config->item($marketplaceid,'gl_serviceurl');
    $config = array (
      'ServiceURL' => $serviceUrl,
      'ProxyHost' => null,
      'ProxyPort' => -1,
      'MaxErrorRetry' => 3
    );

    //    $awskey='AKIAIPGAVOI4KG2HPRZA';
    ///  $secret='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';
    $service = new  MarketplaceWebService_Client(AWS_ACCESS_KEY_ID,AWS_SECRET_ACCESS_KEY,$config,self::$appname,self::$appversion);       

    $log2_array=self::$CI->db->get_where("user_listings",array("sellerid"=>$sellerid,"marketplaceid"=>$marketplaceid,"sku"=>$sku))->row_array();
    $current_price=$log2_array['price'];
    $currency_code=self::$CI->config->item($marketplaceid,'gl_currency');

    $feed = <<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<AmazonEnvelope xsi:noNamespaceSchemaLocation="amznenvelope. xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"> 
<Header> 
<DocumentVersion>1.01</DocumentVersion> 
<MerchantIdentifier>$sellerid</MerchantIdentifier> 
</Header> 
<MessageType>Price</MessageType> 
<Message> <MessageID>1</MessageID> 
<Price> 
<SKU>$sku</SKU> 
<StandardPrice currency="$currency_code">$current_price</StandardPrice> 
<MAP currency="$currency_code">$mapprice</MAP> 
</Price> 
</Message> 
</AmazonEnvelope>
EOD;

    $feedHandle = @fopen('php://memory', 'rw+');
    fwrite($feedHandle, $feed);
    rewind($feedHandle);

    $request = new MarketplaceWebService_Model_SubmitFeedRequest();
    $request->setMerchant($sellerid);
    $marketplaceIdArray = array("Id" => array(trim($marketplaceid)));
    $request->setMarketplaceIdList($marketplaceIdArray);
    $request->setFeedType('_POST_PRODUCT_PRICING_DATA_');
    //$request->setFeedType('_POST_PRODUCT_DATA_');
    $request->setContentMd5(base64_encode(md5(stream_get_contents($feedHandle), true)));
    rewind($feedHandle);
    $request->setPurgeAndReplace(false);
    $request->setFeedContent($feedHandle);
    self::$CI =& get_instance();               
    $log_array=self::$CI->db->get_where("user_settings",array("sellerid"=>$sellerid,"marketplaceid"=>$marketplaceid))->row_array();
    $request->setMWSAuthToken($log_array['mwsauthtoken']); // Optional
    //$request->setMWSAuthToken('<MWS Auth Token>'); // Optional

    rewind($feedHandle);

    log_message('info','About to send the feeds');                                 
    self::invokeSubmitFeed($service, $request);                                        
  } 
  static public function shipprice_update($sellerid, $sku , $mapprice,$marketplaceid)
  {
    //      $serviceUrl="https://mws.amazonservices.com";
    $serviceUrl = self::$CI->config->item($marketplaceid,'gl_serviceurl');
    $config = array (
      'ServiceURL' => $serviceUrl,
      'ProxyHost' => null,
      'ProxyPort' => -1,
      'MaxErrorRetry' => 3
    );

    //    $awskey='AKIAIPGAVOI4KG2HPRZA';
    ///  $secret='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';
    $service = new  MarketplaceWebService_Client(AWS_ACCESS_KEY_ID,AWS_SECRET_ACCESS_KEY,$config,self::$appname,self::$appversion);       
    $currency_code=self::$CI->config->item($marketplaceid,'gl_currency');
    $feed = <<<EOD
<?xml version="1.0" encoding="utf-8"?>
<AmazonEnvelope xsi:noNamespaceSchemaLocation="amznenvelope. xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"> 
<Header> 
<DocumentVersion>1.01</DocumentVersion> 
<MerchantIdentifier>$sellerid</MerchantIdentifier> 
</Header> 
<MessageType>Override</MessageType>
 <Message>
 <MessageID>1</MessageID>
 <OperationType>Update</OperationType>
 <Override>
<SKU>$sku</SKU>
 <ShippingOverride>
 <ShipOption>Same US</ShipOption>
 <Type>Exclusive</Type>
<ShipAmount currency="$currency_code">$mapprice</ShipAmount>
 </ShippingOverride>
 </Override>
 </Message>
</AmazonEnvelope>
EOD;

    $feedHandle = @fopen('php://memory', 'rw+');
    fwrite($feedHandle, $feed);
    rewind($feedHandle);

    $request = new MarketplaceWebService_Model_SubmitFeedRequest();
    $request->setMerchant($sellerid);
    $marketplaceIdArray = array("Id" => array(trim($marketplaceid)));
    $request->setMarketplaceIdList($marketplaceIdArray);
    $request->setFeedType('_POST_PRODUCT_OVERRIDES_DATA_');
    //$request->setFeedType('_POST_PRODUCT_DATA_');
    $request->setContentMd5(base64_encode(md5(stream_get_contents($feedHandle), true)));
    rewind($feedHandle);
    $request->setPurgeAndReplace(false);
    $request->setFeedContent($feedHandle);
    self::$CI =& get_instance();               
    $log_array=self::$CI->db->get_where("user_settings",array("sellerid"=>$sellerid,"marketplaceid"=>$marketplaceid))->row_array();
    $request->setMWSAuthToken($log_array['mwsauthtoken']); // Optional

    rewind($feedHandle);

    log_message('info','About to send the feeds');
    self::invokeSubmitFeed($service, $request);                                         
  }        
  static public function maxorderqty_update($sellerid,$sku,$mapprice,$marketplaceid)
  {   
    //    $serviceUrl="https://mws.amazonservices.com";
    $serviceUrl = self::$CI->config->item($marketplaceid,'gl_serviceurl');
    $config = array (
      'ServiceURL' => $serviceUrl,
      'ProxyHost' => null,
      'ProxyPort' => -1,
      'MaxErrorRetry' => 3
    );

    //    $awskey='AKIAIPGAVOI4KG2HPRZA';
    ///  $secret='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';
    $service = new  MarketplaceWebService_Client(AWS_ACCESS_KEY_ID,AWS_SECRET_ACCESS_KEY,$config,self::$appname,self::$appversion);        
    $log2_array=self::$CI->db->get_where("user_listings",array("sellerid"=>$sellerid,"marketplaceid"=>$marketplaceid,"sku"=>$sku))->row_array();
    $current_title=trim($log2_array['itemname']);
    $feed = <<<EOD
<?xml version="1.0" encoding="utf-8"?>
<AmazonEnvelope xsi:noNamespaceSchemaLocation="amznenvelope. xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"> 
<Header> 
<DocumentVersion>1.01</DocumentVersion> 
<MerchantIdentifier>$sellerid</MerchantIdentifier> 
</Header> 
<MessageType>Product</MessageType>
<PurgeAndReplace>false</PurgeAndReplace>
<Message>
<MessageID>1</MessageID>
<OperationType>PartialUpdate</OperationType>
<Product>
<SKU>$sku</SKU>  
<DescriptionData>
<Title>$current_title</Title>
<MaxOrderQuantity>$mapprice</MaxOrderQuantity>
</DescriptionData>
</Product>
</Message>
</AmazonEnvelope>
EOD;

    $feedHandle = @fopen('php://memory', 'rw+');
    fwrite($feedHandle, $feed);
    rewind($feedHandle);

    $request = new MarketplaceWebService_Model_SubmitFeedRequest();
    $request->setMerchant($sellerid);
    $marketplaceIdArray = array("Id" => array(trim($marketplaceid)));
    $request->setMarketplaceIdList($marketplaceIdArray);
    $request->setFeedType('_POST_PRODUCT_DATA_');
    $request->setContentMd5(base64_encode(md5(stream_get_contents($feedHandle), true)));
    rewind($feedHandle);
    $request->setPurgeAndReplace(false);
    $request->setFeedContent($feedHandle);
    self::$CI =& get_instance();               
    $log_array=self::$CI->db->get_where("user_settings",array("sellerid"=>$sellerid,"marketplaceid"=>$marketplaceid))->row_array();
    $request->setMWSAuthToken($log_array['mwsauthtoken']); // Optional

    rewind($feedHandle);

    log_message('info','About to send the feeds');
    self::invokeSubmitFeed($service, $request);                                        
  }  
  static public function qty_update($sellerid,$sku,$mapprice,$marketplaceid)
  {    
    //    $serviceUrl="https://mws.amazonservices.com";
    $serviceUrl = self::$CI->config->item($marketplaceid,'gl_serviceurl');
    $config = array (
      'ServiceURL' => $serviceUrl,
      'ProxyHost' => null,
      'ProxyPort' => -1,
      'MaxErrorRetry' => 3
    );

    //    $awskey='AKIAIPGAVOI4KG2HPRZA';
    ///  $secret='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';
    $service = new  MarketplaceWebService_Client(AWS_ACCESS_KEY_ID,AWS_SECRET_ACCESS_KEY,$config,self::$appname,self::$appversion);       
    $feed = <<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<AmazonEnvelope xsi:noNamespaceSchemaLocation="amznenvelope. xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"> 
<Header> 
<DocumentVersion>1.01</DocumentVersion> 
<MerchantIdentifier>$sellerid</MerchantIdentifier> 
</Header> 
<MessageType>Inventory</MessageType> 
<Message> <MessageID>1</MessageID> 
 <OperationType>Update</OperationType>
    <Inventory>
<SKU>$sku</SKU> 
        <Quantity>$mapprice</Quantity>
    </Inventory>
</Message> 
</AmazonEnvelope>
EOD;

    $feedHandle = @fopen('php://memory', 'rw+');
    fwrite($feedHandle, $feed);
    rewind($feedHandle);

    $request = new MarketplaceWebService_Model_SubmitFeedRequest();
    $request->setMerchant($sellerid);
    $marketplaceIdArray = array("Id" => array(trim($marketplaceid)));
    $request->setMarketplaceIdList($marketplaceIdArray);
    $request->setFeedType('_POST_INVENTORY_AVAILABILITY_DATA_');
    //$request->setFeedType('_POST_PRODUCT_DATA_');
    $request->setContentMd5(base64_encode(md5(stream_get_contents($feedHandle), true)));
    rewind($feedHandle);
    $request->setPurgeAndReplace(false);
    $request->setFeedContent($feedHandle);
    self::$CI =& get_instance();               
    $log_array=self::$CI->db->get_where("user_settings",array("sellerid"=>$sellerid,"marketplaceid"=>$marketplaceid))->row_array();
    $request->setMWSAuthToken($log_array['mwsauthtoken']); // Optional

    rewind($feedHandle);

    log_message('info','About to send the feeds');
    self::invokeSubmitFeed($service, $request);                                        
  }         
  //we want key value   
  static public function mprice_update($sellerid,$sku=array(),$marketplaceid)
  {              
    //    $serviceUrl="https://mws.amazonservices.com";
    $serviceUrl = self::$CI->config->item($marketplaceid,'gl_serviceurl');
    $config = array (
      'ServiceURL' => $serviceUrl,
      'ProxyHost' => null,
      'ProxyPort' => -1,
      'MaxErrorRetry' => 3
    );

    $service = new  MarketplaceWebService_Client(AWS_ACCESS_KEY_ID,AWS_SECRET_ACCESS_KEY,$config,self::$appname,self::$appversion);        
    $count=1;
    $feed_body='';
    $currency_code=self::$CI->config->item($marketplaceid,'gl_currency');
    foreach($sku as $key=>$value)
    {
      $feed_body.='<Message> <MessageID>'.$count.'</MessageID> 
        <Price> 
        <SKU>'.$key.'</SKU> 
        <StandardPrice currency="'.$currency_code.'">'.$value.'</StandardPrice> 
        </Price> 
        </Message>';  
      $count+=1;
    }
    $feed_footer='</AmazonEnvelope>';                         
    $feed_header = <<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<AmazonEnvelope xsi:noNamespaceSchemaLocation="amznenvelope. xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"> 
<Header> 
<DocumentVersion>1.01</DocumentVersion> 
<MerchantIdentifier>$sellerid</MerchantIdentifier> 
</Header> 
<MessageType>Price</MessageType>$feed_body 
$feed_footer
EOD;

    log_message('error','my feed is '.$feed_header);

    $feedHandle = @fopen('php://memory', 'rw+');
    fwrite($feedHandle, $feed_header);
    rewind($feedHandle);

    $request = new MarketplaceWebService_Model_SubmitFeedRequest();
    $request->setMerchant($sellerid);
    $marketplaceIdArray = array("Id" => array(trim($marketplaceid)));
    $request->setMarketplaceIdList($marketplaceIdArray);
    $request->setFeedType('_POST_PRODUCT_PRICING_DATA_');
    //$request->setFeedType('_POST_PRODUCT_DATA_');
    $request->setContentMd5(base64_encode(md5(stream_get_contents($feedHandle), true)));
    rewind($feedHandle);
    $request->setPurgeAndReplace(false);
    $request->setFeedContent($feedHandle);
    self::$CI =& get_instance();               
    $log_array=self::$CI->db->get_where("user_settings",array("sellerid"=>$sellerid,"marketplaceid"=>$marketplaceid))->row_array();
    $request->setMWSAuthToken($log_array['mwsauthtoken']); // Optional

    rewind($feedHandle);

    log_message('info','About to send the feeds');
   return self::invokeSubmitFeed($service, $request);                                        
  } 
  static public function price_update($sellerid,$sku,$mapprice,$marketplaceid)
  {              
    //    $serviceUrl="https://mws.amazonservices.com";
    log_message('error','changing '.$sellerid.' '.$marketplaceid.' '.$sku.' '.$mapprice); 
    $serviceUrl = self::$CI->config->item($marketplaceid,'gl_serviceurl');
    $config = array (
      'ServiceURL' => $serviceUrl,
      'ProxyHost' => null,
      'ProxyPort' => -1,
      'MaxErrorRetry' => 3
    );

    //    $awskey='AKIAIPGAVOI4KG2HPRZA';
    ///  $secret='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';
    $service = new  MarketplaceWebService_Client(AWS_ACCESS_KEY_ID,AWS_SECRET_ACCESS_KEY,$config,self::$appname,self::$appversion);       
    $currency_code=self::$CI->config->item($marketplaceid,'gl_currency');
    $feed = <<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<AmazonEnvelope xsi:noNamespaceSchemaLocation="amznenvelope. xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"> 
<Header> 
<DocumentVersion>1.01</DocumentVersion> 
<MerchantIdentifier>$sellerid</MerchantIdentifier> 
</Header> 
<MessageType>Price</MessageType> 
<Message> <MessageID>1</MessageID> 
<Price> 
<SKU>$sku</SKU> 
<StandardPrice currency="$currency_code">$mapprice</StandardPrice> 
</Price> 
</Message> 
</AmazonEnvelope>
EOD;

    $feedHandle = @fopen('php://memory', 'rw+');
    fwrite($feedHandle, $feed);
    rewind($feedHandle);

    $request = new MarketplaceWebService_Model_SubmitFeedRequest();
    $request->setMerchant($sellerid);
    $marketplaceIdArray = array("Id" => array(trim($marketplaceid)));
    $request->setMarketplaceIdList($marketplaceIdArray);
    $request->setFeedType('_POST_PRODUCT_PRICING_DATA_');
    //$request->setFeedType('_POST_PRODUCT_DATA_');
    $request->setContentMd5(base64_encode(md5(stream_get_contents($feedHandle), true)));
    rewind($feedHandle);
    $request->setPurgeAndReplace(false);
    $request->setFeedContent($feedHandle);
    self::$CI =& get_instance();               
    $log_array=self::$CI->db->get_where("user_settings",array("sellerid"=>$sellerid,"marketplaceid"=>$marketplaceid))->row_array();
    $request->setMWSAuthToken($log_array['mwsauthtoken']); // Optional

    rewind($feedHandle);

    log_message('info','About to send the feeds');
//    debug($request);exit();
  return  self::invokeSubmitFeed($service, $request);                                        
  }
  static public function common()
  {
  }
  // back jobs             
  static  public function invokeRequestReport_orig(MarketplaceWebService_Interface $service, $request) 
  {
    try {
      $response = $service->requestReport($request);

      //                echo ("Service Response\n");
      //               echo ("=============================================================================\n");

      //             echo("        RequestReportResponse\n");
      if ($response->isSetRequestReportResult()) { 
        //               echo("            RequestReportResult\n");
        $requestReportResult = $response->getRequestReportResult();

        if ($requestReportResult->isSetReportRequestInfo()) {

          $reportRequestInfo = $requestReportResult->getReportRequestInfo();
          //                   echo("                ReportRequestInfo\n");
          if ($reportRequestInfo->isSetReportRequestId()) 
          {
            //                echo("                    ReportRequestId\n");
            //                              echo("                        " . $reportRequestInfo->getReportRequestId() . "\n");
            return $reportRequestInfo->getReportRequestId();
          }
          if ($reportRequestInfo->isSetReportType()) 
          {
            //                     echo("                    ReportType\n");
            //                   echo("                        " . $reportRequestInfo->getReportType() . "\n");
          }
          if ($reportRequestInfo->isSetStartDate()) 
          {
            //                 echo("                    StartDate\n");
            ///                echo("                        " . $reportRequestInfo->getStartDate()->format(DATE_FORMAT) . "\n");
          }
          if ($reportRequestInfo->isSetEndDate()) 
          {
            //              echo("                    EndDate\n");
            //             echo("                        " . $reportRequestInfo->getEndDate()->format(DATE_FORMAT) . "\n");
          }
          if ($reportRequestInfo->isSetSubmittedDate()) 
          {
            //           echo("                    SubmittedDate\n");
            //         echo("                        " . $reportRequestInfo->getSubmittedDate()->format(DATE_FORMAT) . "\n");
          }
          if ($reportRequestInfo->isSetReportProcessingStatus()) 
          {
            //         echo("                    ReportProcessingStatus\n");
            //        echo("                        " . $reportRequestInfo->getReportProcessingStatus() . "\n");
          }
        }
      } 
      if ($response->isSetResponseMetadata()) { 
        //                    echo("            ResponseMetadata\n");
        $responseMetadata = $response->getResponseMetadata();
        if ($responseMetadata->isSetRequestId()) 
        {
          //                      echo("                RequestId\n");
          //                     echo("                    " . $responseMetadata->getRequestId() . "\n");
        }
      } 

      //           echo("            ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");
    } catch (MarketplaceWebService_Exception $ex) {
      /*
         echo("Caught Exception: " . $ex->getMessage() . "\n");
         echo("Response Status Code: " . $ex->getStatusCode() . "\n");
         echo("Error Code: " . $ex->getErrorCode() . "\n");
         echo("Error Type: " . $ex->getErrorType() . "\n");
         echo("Request ID: " . $ex->getRequestId() . "\n");
         echo("XML: " . $ex->getXML() . "\n");
         echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");

       */
      log_message('error',$ex->getMessage());
    }
    return 'error';
  } 
  static public function invokeGetReportRequestList(MarketplaceWebService_Interface $service, $request) 
  {
    try {
      $response = $service->getReportRequestList($request);

      ///                echo ("Service Response\n");
      //             echo ("=============================================================================\n");

      //           echo("        GetReportRequestListResponse\n");
      if ($response->isSetGetReportRequestListResult()) { 
        //             echo("            GetReportRequestListResult\n");
        $getReportRequestListResult = $response->getGetReportRequestListResult();
        if ($getReportRequestListResult->isSetNextToken()) 
        {
          //               echo("                NextToken\n");
          //             echo("                    " . $getReportRequestListResult->getNextToken() . "\n");
        }
        if ($getReportRequestListResult->isSetHasNext()) 
        {
          //           echo("                HasNext\n");
          //         echo("                    " . $getReportRequestListResult->getHasNext() . "\n");
        }
        $reportRequestInfoList = $getReportRequestListResult->getReportRequestInfoList();
        foreach ($reportRequestInfoList as $reportRequestInfo) {
          //           echo("                ReportRequestInfo\n");
          if ($reportRequestInfo->isSetReportRequestId()) 
          {
            //                              echo("                    ReportRequestId\n");
            ///                             echo("                        " . $reportRequestInfo->getReportRequestId() . "\n");
          }
          if ($reportRequestInfo->isSetReportType()) 
          {
            //                echo("                    ReportType\n");
            //               echo("                        " . $reportRequestInfo->getReportType() . "\n");
          }
          if ($reportRequestInfo->isSetStartDate()) 
          {
            //              echo("                    StartDate\n");
            //             echo("                        " . $reportRequestInfo->getStartDate()->format(DATE_FORMAT) . "\n");
          }
          if ($reportRequestInfo->isSetEndDate()) 
          {
            //           echo("                    EndDate\n");
            //          echo("                        " . $reportRequestInfo->getEndDate()->format(DATE_FORMAT) . "\n");
          }
          // add start
          if ($reportRequestInfo->isSetScheduled()) 
          {
            //       echo("                    Scheduled\n");
            //        echo("                        " . $reportRequestInfo->getScheduled() . "\n");
          }
          // add end
          if ($reportRequestInfo->isSetSubmittedDate()) 
          {
            ///       echo("                    SubmittedDate\n");
            ///     echo("                        " . $reportRequestInfo->getSubmittedDate()->format(DATE_FORMAT) . "\n");
          }
          if ($reportRequestInfo->isSetReportProcessingStatus()) 
          {
        //    echo $reportRequestInfo->getReportProcessingStatus();
          if($reportRequestInfo->getReportProcessingStatus()=="_CANCELLED_")
            return 'cancelled';
          if($reportRequestInfo->getReportProcessingStatus()=="_DONE_NO_DATA_")
            return 'cancelled';
            //   echo("                    ReportProcessingStatus\n");
            //  echo("                        " . $reportRequestInfo->getReportProcessingStatus() . "\n");
          }
          // add start
          if ($reportRequestInfo->isSetGeneratedReportId()) 
          {
            //      echo("                    GeneratedReportId\n");
            //    echo("                        " . $reportRequestInfo->getGeneratedReportId() . "\n");
            return $reportRequestInfo->getGeneratedReportId();
            //                              break;
          }
          if ($reportRequestInfo->isSetStartedProcessingDate()) 
          {
            //   echo("                    StartedProcessingDate\n");
            ///  echo("                        " . $reportRequestInfo->getStartedProcessingDate()->format(DATE_FORMAT) . "\n");
          }
          if ($reportRequestInfo->isSetCompletedDate()) 
          {
            //        echo("                    CompletedDate\n");
            //       echo("                        " . $reportRequestInfo->getCompletedDate()->format(DATE_FORMAT) . "\n");
          }
          // add end

        }
      } 
      if ($response->isSetResponseMetadata()) { 
        //       echo("            ResponseMetadata\n");
        $responseMetadata = $response->getResponseMetadata();
        if ($responseMetadata->isSetRequestId()) 
        {
          //             echo("                RequestId\n");
          //            echo("                    " . $responseMetadata->getRequestId() . "\n");
        }
      } 

      //    echo("            ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");
    } catch (MarketplaceWebService_Exception $ex) {
      /*
      echo("Caught Exception: " . $ex->getMessage() . "\n");
      echo("Response Status Code: " . $ex->getStatusCode() . "\n");
      echo("Error Code: " . $ex->getErrorCode() . "\n");
      echo("Error Type: " . $ex->getErrorType() . "\n");
      echo("Request ID: " . $ex->getRequestId() . "\n");
      echo("XML: " . $ex->getXML() . "\n");
      echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
       */
      log_message("info",$ex->getMessage());
      return "cancelled";
    }
    return "notfound";
  }        
  public function checking()
  {
    $sellerid='A2H709HJFL5E2Z';
    self::$CI =& get_instance();               
    $log_array=self::$CI->db->get_where("user_settings",array("sellerid" => $sellerid,"marketplaceid"=>$marketplaceid))->row_array();
    print_r($log_array);

  }
  static public function getreportlist($marketplaceid,$sellerid,$check_id=NULL,$func_name='') // actually get request one
  {             
    log_message('info',"Getting the report list  ");
    //    $serviceUrl="https://mws.amazonservices.com";
    $serviceUrl = self::$CI->config->item($marketplaceid,'gl_serviceurl');
    $config = array (
      'ServiceURL' => $serviceUrl,
      'ProxyHost' => null,
      'ProxyPort' => -1,
      'MaxErrorRetry' => 3
    );
    //    $awskey='AKIAIPGAVOI4KG2HPRZA';
    //  $secret='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';
    $service = new  MarketplaceWebService_Client(AWS_ACCESS_KEY_ID,AWS_SECRET_ACCESS_KEY,$config,self::$appname,self::$appversion);     
    $request = new MarketplaceWebService_Model_GetReportRequestListRequest();
    $request->setMerchant($sellerid);
    $statusList = new MarketplaceWebService_Model_StatusList();
    $idList = new MarketplaceWebService_Model_IdList();
    $typeList = new MarketplaceWebService_Model_TypeList();
    $request->setReportProcessingStatusList($statusList->withStatus('_DONE_')); 
    if($check_id!=NULL)
    {
      $request->setReportRequestIdList($idList->withId($check_id)); 
    }
    if($func_name=='amazon_fbafees')
    $request->setReportTypeList($typeList->withType('_GET_FBA_ESTIMATED_FBA_FEES_TXT_DATA_'));
    else
    $request->setReportTypeList($typeList->withType('_GET_MERCHANT_LISTINGS_DATA_'));
    self::$CI =& get_instance();               
    $log_array=self::$CI->db->get_where("user_settings",array("sellerid"=>$sellerid,"marketplaceid"=>$marketplaceid))->row_array();
    $request->setMWSAuthToken($log_array['mwsauthtoken']); // Optional
    return self::invokeGetReportRequestList($service, $request);                   

  }   


  static public function amazon_report($job)
  {
    /// we have sellerid , mkpid , and token
    $data = unserialize($job->workload());
    //   log_message('info',print_r($data,TRUE));
    log_message('info','printing the secret key');
    log_message('info',AWS_SECRET_ACCESS_KEY);
    log_message('info','printing the secret key11');
    ///    $serviceUrl="https://mws.amazonservices.com";
    $serviceUrl = self::$CI->config->item($data['marketplaceid'],'gl_serviceurl');
    $config = array (
      'ServiceURL' => $serviceUrl,
      'ProxyHost' => null,
      'ProxyPort' => -1,
      'MaxErrorRetry' => 3
    );

    //    $awskey='AKIAIPGAVOI4KG2HPRZA';
    ///   $secret='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';
    //$service = new  MarketplaceWebService_Client(self::$awskey,self::$secret,$config,self::$appname,self::$appversion);  
    $service = new MarketplaceWebService_Client(
      AWS_ACCESS_KEY_ID, 
      AWS_SECRET_ACCESS_KEY, 
      $config,
      APPLICATION_NAME,
      APPLICATION_VERSION);

    //    $service = new  MarketplaceWebService_Client(AWS_ACCESS_KEY_ID,AWS_SECRET_ACCESS_KEY,$config,self::$appname,self::$appversion);
    $request = new MarketplaceWebService_Model_RequestReportRequest();
    $marketplaceIdArray = array("Id" => array(trim($data['marketplaceid'])));
    $request->setMarketplaceIdList($marketplaceIdArray);
    //    $request->setMerchant($data['sellerid']);
    $request->setMerchant(MERCHANT_ID);
    $request->setReportType('_GET_MERCHANT_LISTINGS_DATA_');

    $res=self::invokeRequestReport($service,$request);
    while(TRUE)
    {
      //  log_message('info',"Sleepin for 120 seconds for ".$data['sellerid']);
      /*
      $id=self::getreportlist($data['sellerid']);   
      if($id=="notfound")
      {
        sleep(120);
        continue;
      }
      self::getreport($data['sellerid'],$id);
      log_message('info',"ok  done populatin the mysql");
       */
      // now again refrehs the listing
      // sleep(300);
      // $res=self::invokeRequestReport();
      break;
      //now udate the mysql tabel


    }
    //now submit the 
    // create the 
  }              

  static public function fulfillment_channel($sellerid,$sku,$mapprice,$marketplaceid)
  {
    //           $serviceUrl="https://mws.amazonservices.com";
    $serviceUrl = self::$CI->config->item($marketplaceid,'gl_serviceurl');
    $config = array (
      'ServiceURL' => $serviceUrl,
      'ProxyHost' => null,
      'ProxyPort' => -1,
      'MaxErrorRetry' => 3
    );

    //    $awskey='AKIAIPGAVOI4KG2HPRZA';
    ///  $secret='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';
    $service = new  MarketplaceWebService_Client(AWS_ACCESS_KEY_ID,AWS_SECRET_ACCESS_KEY,$config,self::$appname,self::$appversion);       
    if($mapprice == "AMAZON_NA")
    {
      $feed = <<<EOD
<?xml version="1.0" encoding="utf-8"?>
<AmazonEnvelope xsi:noNamespaceSchemaLocation="amznenvelope. xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"> 
<Header> 
<DocumentVersion>1.01</DocumentVersion> 
<MerchantIdentifier>$sellerid</MerchantIdentifier> 
</Header> 
<MessageType>Inventory</MessageType> 
<Message> <MessageID>1</MessageID> 
    <OperationType>Update</OperationType>
    <Inventory>
<SKU>$sku</SKU> 
<FulfillmentCenterID>AMAZON_NA</FulfillmentCenterID>
<Lookup>FulfillmentNetwork</Lookup>
<SwitchFulfillmentTo>AFN</SwitchFulfillmentTo>
    </Inventory>
</Message> 
</AmazonEnvelope>

EOD;
    }
    else
    {    
      // get th aty 
      $log2_array=self::$CI->db->get_where("user_listings",array("sellerid"=>$sellerid,"marketplaceid"=>$marketplaceid,"sku"=>$sku))->row_array();
      $current_qty=$log2_array['qty'];
      $feed = <<<EOD
<?xml version="1.0" encoding="utf-8"?>
<AmazonEnvelope xsi:noNamespaceSchemaLocation="amznenvelope. xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"> 
<Header> 
<DocumentVersion>1.01</DocumentVersion> 
<MerchantIdentifier>$sellerid</MerchantIdentifier> 
</Header> 
<MessageType>Inventory</MessageType> 
<Message> <MessageID>1</MessageID> 
    <OperationType>Update</OperationType>
    <Inventory>
<SKU>$sku</SKU> 
<FulfillmentCenterID>DEFAULT</FulfillmentCenterID>
<Quantity>$current_qty</Quantity>
<SwitchFulfillmentTo>MFN</SwitchFulfillmentTo>
    </Inventory>
</Message> 
</AmazonEnvelope>

EOD;

    }

    $feedHandle = @fopen('php://memory', 'rw+');
    fwrite($feedHandle, $feed);
    rewind($feedHandle);

    $request = new MarketplaceWebService_Model_SubmitFeedRequest();
    $request->setMerchant($sellerid);
    $marketplaceIdArray = array("Id" => array(trim($marketplaceid)));
    $request->setMarketplaceIdList($marketplaceIdArray);
    $request->setFeedType('_POST_INVENTORY_AVAILABILITY_DATA_');
    //$request->setFeedType('_POST_PRODUCT_DATA_');
    $request->setContentMd5(base64_encode(md5(stream_get_contents($feedHandle), true)));
    rewind($feedHandle);
    $request->setPurgeAndReplace(false);
    $request->setFeedContent($feedHandle);
    self::$CI =& get_instance();               
    $log_array=self::$CI->db->get_where("user_settings",array("sellerid"=>$sellerid,"marketplaceid"=>$marketplaceid))->row_array();
    $request->setMWSAuthToken($log_array['mwsauthtoken']); // Optional

    rewind($feedHandle);

    log_message('info','About to send the feeds');
    self::invokeSubmitFeed($service, $request);                                         
  }
  static public function instant_reprice($ubs,$myarray)
  {               
    $serviceUrl = "https://mws.amazonservices.com/Products/2011-10-01";
    $config = array ( 'ServiceURL' => $serviceUrl, 'ProxyHost' => null, 'ProxyPort' => -1, 'MaxErrorRetry' => 3,);
    $service = new MarketplaceWebServiceProducts_Client(
      AWS_ACCESS_KEY_ID,
      AWS_SECRET_ACCESS_KEY,
      APPLICATION_NAME,
      APPLICATION_VERSION,
      $config);                    
    $Message='';
    $request_bb = new MarketplaceWebServiceProducts_Model_GetCompetitivePricingForSKURequest();
    $request_bb->setSellerId($myarray['sellerid']);
    $request_bb->setMarketplaceId($myarray['marketplaceid']);
    $request_bb->setMWSAuthToken($myarray['mwsauthtoken']);  
        $sku11 = new MarketplaceWebServiceProducts_Model_SellerSKUListType();
        call_user_func_array(array($sku11,"withSellerSKU"),(array)($ubs['sku']));  
    $request_bb->setSellerSKUList($sku11);    // object or array of parameters
    //  $return_array=array_merge($return_array,self::invokeGetCompetitivePricingForSKU($service, $request_bb,$temp_array));
    self::invokemyGetCompetitivePricingForSKU($service, $request_bb,$ubs);
    // now reprice ...please 
    log_message('info',"test11");
    //sowe have
    $new=array();
    $new['sellerid']=$ubs['sellerid'];
    $new['marketplaceid']=$ubs['marketplaceid'];
    $new['sku']=$ubs['sku'];
    $new['asin']=$ubs['asin'];
    if((float)$ubs['bb_price']=='0.00')
    {
    }
    else
    {
    if($ubs['bb']=='yes')
    {
      $temp=array();
      log_message('info',"test12");
      $temp['bb_list']=$ubs['bb_lprice'];
      $temp['bb_total']=  $ubs['bb_price'];
      $new['price']= self::check_ubs_gbs($ubs,$myarray,$temp,$ubs['bb_lprice']);
      $new['ship_price']=$ubs['bb_sprice'];
      $new['bb_price'] = $ubs['bb_price'];
      $new['bb_eligible']=  'yes';
      $new['bb']=  'yes';
      $message='Raise-> '.print_r($new,TRUE);
      // error_log($message,1, "repricinglegend@gmail.com");
      error_log($message,3, "/var/tmp/".rand().".log");
      if(self::price_update($new['sellerid'],$new['sku'],$new['price'],$new['marketplaceid'])!="tryagain")
        self::$CI->db->update('user_listings', $new, array('sellerid' => $new['sellerid'],'marketplaceid'=>$new['marketplaceid'],'sku'=>$new['sku'],'asin'=>$new['asin']));
    }
    else{
      // dot have bb   
      $temp=array();
    log_message('info',"test13");
      $temp['bb_list']=$ubs['bb_lprice'];
      $temp['bb_total']=  $ubs['bb_price'];
      $new['price']= self::check_ubs_gbs($ubs,$myarray,$temp,$ubs['bb_lprice']);
      $new['bb_price'] = $ubs['bb_price']; 
      $new['bb']=  'no';   
      if($new['price'])
      {
        if(self::price_update($new['sellerid'],$new['sku'],$new['price'],$new['marketplaceid'])!="tryagain")
          self::$CI->db->update('user_listings', $new, array('sellerid' => $new['sellerid'],'marketplaceid'=>$new['marketplaceid'],'sku'=>$new['sku'],'asin'=>$new['asin']));
        // update
      }
      $message='Beating else condition-> '.print_r($new,TRUE);
      //    error_log($message,1, "repricinglegend@gmail.com");
      error_log($message,3, "/var/tmp/".rand().".log");
    
    }}

  }
  static  public function amazon_update($job)
  {   
    // data contains sellerid, sku , key , value    
    log_message('info','processing the jobs');
    $data = unserialize($job->workload());
    //    print_r($data);

    log_message('info',print_r($data,TRUE));
    //    $serviceUrl="https://mws.amazonservices.com";
    self::$CI =& get_instance();               
    $serviceUrl = self::$CI->config->item($data['marketplaceid'],'gl_serviceurl');
    $config = array (
      'ServiceURL' => $serviceUrl,
      'ProxyHost' => null,
      'ProxyPort' => -1,
      'MaxErrorRetry' => 3
    );

    log_message('info',"testing");
    //$CI =& get_instance();
    $log_array=self::$CI->db->get_where("user_settings",array("sellerid"=>$data['sellerid'],"marketplaceid"=>$data['marketplaceid']))->row_array();
    //    $awskey='AKIAIPGAVOI4KG2HPRZA';
    //   $secret='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';
    log_message('info',"testing1");
    if($log_array)
    {
      $service = new  MarketplaceWebService_Client(AWS_ACCESS_KEY_ID,AWS_SECRET_ACCESS_KEY,$config,self::$appname,self::$appversion);
      //     var_dump($service);                     

      log_message('info',"testing11");
      log_message('info',print_r($service,TRUE));
      $ret=self::common();
      if (isset($data['min_price']))
      {
     //   self::minprice_update($data['sellerid'],$data['sku'],$data['min_price'],$data['marketplaceid']);
      }
      if (isset($data['max_price']))
      {
      //  self::maxprice_update($data['sellerid'],$data['sku'],$data['max_price'],$data['marketplaceid']);
      }
      if (isset($data['map_price']))
      {
        self::mapprice_update($data['sellerid'],$data['sku'],$data['map_price'],$data['marketplaceid']);
      }
      if (isset($data['maxorderqty']))
      {
        self::maxorderqty_update($data['sellerid'],$data['sku'],$data['maxorderqty'],$data['marketplaceid']);
      }
      if (isset($data['qty']))
      {
        self::qty_update($data['sellerid'],$data['sku'],$data['qty'],$data['marketplaceid']);
      }
      if (isset($data['ship_price']))
      {
        self::shipprice_update($data['sellerid'],$data['sku'],$data['ship_price'],$data['marketplaceid']);
      }
      if (isset($data['fulfillment_channel']))
      {
        self::fulfillment_channel($data['sellerid'],$data['sku'],$data['fulfillment_channel'],$data['marketplaceid']);
      }
      if (isset($data['price']))
      {
        self::price_update($data['sellerid'],$data['sku'],$data['price'],$data['marketplaceid']);
        //  return FALSE;
      }                               
      // autoamtc repricing 
          log_message('error','instant122 ');
      if(!isset($data['price'])&& !isset($data['ship_price']) &&  (isset($data['min_price']) || isset($data['max_price']) || isset($data['exclude_seller']) || isset($data['include_seller']) || isset($data['beat_amazon_flag']) || isset($data['beat_amazon']) || isset($data['comp_type']) || isset($data['beatby']) || isset($data['beatbyvalue'])))
      {
          log_message('error','instant11 ');
        $log_array1=(array)self::$CI->db->get_where("user_listings",array("sellerid"=>$data['sellerid'],"marketplaceid"=>$data['marketplaceid'],"sku"=>$data['sku']))->row();
          log_message('error','instant14 ');
        $glog_array1=self::$CI->db->get_where("user_settings",array("sellerid"=>$data['sellerid'],"marketplaceid"=>$data['marketplaceid']))->row_array();
          log_message('error','instant '.print_r($log_array1,TRUE));
        $minprice=isset($data['minprice'])?(float)$data['minprice']:(float)$log_array1['min_price'];
        $maxprice=isset($data['maxprice'])?(float)$data['maxprice']:(float)$log_array1['max_price'];
          log_message('error','instant13 ');
        if($minprice=='0.00' || $maxprice=='0.00'){}
        else
        {
          // now repricr finaly
          log_message('error','instant '.print_r($log_array1,TRUE));

      ///   self::instant_reprice($log_array1,$glog_array1);

        }


      } // repric
    }

  return TRUE;
  }
  // back jobs

  // we wnat the receouit handles
  static public function delete_messages($sellerid,$myarray=array())
  {       
    if(count($myarray)>0)
    {
      $test=new Sqs('AKIAIBV4GQD2FHN35R5A','iD85Nxujc0y5w7f3ieuZEfLZaWX5tZ8H5sl48xXA',Sqs::ENDPOINT_US_WEST);
      $result_array=$test->deleteMessageBatch('https://sqs.us-west-2.amazonaws.com/436456621616/'.$sellerid,$myarray);  
      log_message('info','deleting sqs message '.print_r($result_array,TRUE));
    }
  }
  static public function process_messages()
  {
  }
  static public function validate_messages($sellerid)
  {
    $log_array=self::$CI->db->get_where("user_settings",array("sellerid"=>$sellerid,"marketplaceid"=>$marketplaceid))->row_array();
    $return_array=self::$CI->db->get_where("subscription",array("sellerid"=>$sellerid))->row_array();
    if($return_array['plan']!='free')
    {
      // now process the message
    }
    else
    {
      return FALSE;
    }
  }
  static public function check_amazon_type($ubs,$buybox)
  {     
    // to do : check the latest price
    if($ubs['beat_amazon_flag']=='yes')
    {
      $newprice=(float)$buybox['bb_list']- (float)$ubs['beat_amazon'];
   if($newprice<=0 || $newprice<=$ubs['min_price'])    
        return $ubs['min_price'];
      return $newprice;
    }
    else
    {
      return '';
    }                              
  }

  static public function check_comp_type($ubs,$gbs,$buybox,$option=NULL)
  {
    if($ubs['comp_type']=='amazon' && in_array($buybox['bb_sellerid'],array_keys(self::$CI->config->item('gl_serviceurl'))))
    {
      return self::check_ubs_gbs($ubs,$gbs,$buybox,$option);
    }
    if($ubs['comp_type']=='all')
    {
      return self::check_ubs_gbs($ubs,$gbs,$buybox,$option);
    }
    if($ubs['comp_type']=='fba' && $buybox['bb_fba']=='true')
    {
      return self::check_ubs_gbs($ubs,$gbs,$buybox,$option);
    }
    if($ubs['comp_type']=='nonfba' && $buybox['bb_fba']=='false')           
    {
      return self::check_ubs_gbs($ubs,$gbs,$buybox,$option);
    }
    if($ubs['comp_type']=='amazonandfba' && (in_array($buybox['bb_sellerid'],array_keys(self::$CI->config->item('gl_serviceurl'))) ||  $buybox['bb_fba']=='true')   )    {
      return self::check_ubs_gbs($ubs,$gbs,$buybox,$option);
    }
    return '';
  }

  static public function check_ubs_gbs($ubs,$gbs,$buybox,$ourprice=NULL)
  {
    // now check
    // newprice is the list price //to do --> consider shipping too...
  //  $ours=$ourprice==NULL?(float)$ubs['price']+(float)$ubs['ship_price']:(float)$ourprice ;
    $ours=$ourprice==NULL?(float)$ubs['price']:(float)$ourprice ;
    if($ubs['beatby']=='formula')
    {
      $newprice=buybox_formula((float)$buybox['bb_total'],0,(float)$ubs['min_price'],(float)$ubs['max_price'],0,(float)$ours);
      return $newprice   ;
    }
    if($ubs['beatby']=='beatby')
    {
      $newprice=(float)$buybox['bb_list']-(float)$ubs['beatbyvalue'];
   if($newprice<=0 || $newprice<=$ubs['min_price'])    
        return $ubs['min_price'];
      if($newprice>=$ubs['max_price'])
        return $ubs['max_price'];
      return $newprice;
    }
    if($ubs['beatby']=='beatmeby')
    {
      $newprice=(float)$buybox['bb_list']+(float)$ubs['beatbyvalue'];
   if($newprice<=0 || $newprice<=$ubs['min_price'])    
        return $ubs['min_price'];
      if($newprice>=$ubs['max_price'])
        return $ubs['max_price'];
      return $newprice;
    }
    if($ubs['beatby']=='matchprice')
    {
      if($buybox['bb_list']<=$ubs['min_price'])
        return $ubs['min_price'];
      if($buybox['bb_list']>=$ubs['max_price'])
        return $ubs['max_price'];
      $newprice=(float)$buybox['bb_list'];
      return $newprice;
    }
    // for gbs
     if($gbs['beatby']=='formula')
    {
     $newprice=buybox_formula((float)$buybox['bb_total'],0,(float)$ubs['min_price'],(float)$ubs['max_price'],0,(float)$ours);
      return $newprice   ;
    }
    if($gbs['beatby']=='beatby')
    {
      $newprice=(float)$buybox['bb_list']-(float)$gbs['beatbyvalue'];
      if($newprice<=0 || $newprice<=$ubs['min_price'])
        return $ubs['min_price'];
      if($newprice>=$ubs['max_price'])
        return $ubs['max_price'];
      return $newprice;
    }
    if($gbs['beatby']=='beatmeby')
    {
      $newprice=(float)$buybox['bb_list']+(float)$gbs['beatbyvalue'];
      if($newprice<=0 || $newprice<=$ubs['min_price'])
        return $ubs['min_price'];
      if($newprice>=$ubs['max_price'])
        return $ubs['max_price'];
      return $newprice;
    }
    if($gbs['beatby']=='matchprice')
    {
      if($buybox['bb_list']<=$ubs['min_price'])
        return $ubs['min_price'];
      if($buybox['bb_list']>=$ubs['max_price'])
        return $ubs['max_price'];
      $newprice=(float)$buybox['bb_list'];
      return $newprice;
    }                   

  }

  static public function amazon_sqs($job)
  {
    return;
    $data = unserialize($job->workload());
   // $sellerid=$data['sellerid'];
    self::$CI =& get_instance();  
    $attr['WaitTimeSeconds']=20;
    while(1)
    {
      $result_array=self::$CI->sqs->receiveMessage('https://sqs.us-west-2.amazonaws.com/436456621616/'.$data['sellerid'],9,null,$attr);
      log_message('info','total sqs message for '.count($result_array));
      $receipt=array();
      if($result_array!=null)
      {
        foreach ($result_array['Messages'] as $mess)
        {
          $receipt[]=$mess['ReceiptHandle'];
        }
          self::delete_messages($data['sellerid'],$receipt);
        // log_message('info','processing sqs message for '.print_r($result_array,TRUE));
        //   foreach($result_array as $myarray)
        //get the receipt handle
        foreach ($result_array['Messages'] as $mess)
        {
          $receipt[]=$mess['ReceiptHandle'];
          $xml=simplexml_load_string($mess['Body']);
          $sellerid=trim($xml->NotificationMetaData->SellerId);
          $mkpid=trim($xml->NotificationMetaData->MarketplaceId);
          $asin=trim($xml->NotificationPayload->AnyOfferChangedNotification->OfferChangeTrigger->ASIN);
          $condn=trim($xml->NotificationPayload->AnyOfferChangedNotification->OfferChangeTrigger->ItemCondition);
          $bbprice=array();
          $bbprice1=array();
          $ourprice=array();
        
          self::$CI->db_mysql->on_duplicate_key_update()->insert("sqs_messages",array('message_id'=>trim($xml->NotificationMetaData->UniqueId),'message_body'=>$mess['Body']));
          log_message('info','processing sqs message for ');
          // ge the buybox prices for new and useed item
          // fetcha all the info based on sleler id and asin
    
          if(isset($xml->NotificationPayload->AnyOfferChangedNotification->Summary->BuyBoxPrices))
          {
          foreach ($xml->NotificationPayload->AnyOfferChangedNotification->Summary->BuyBoxPrices->BuyBoxPrice as $bbprices)
          {
            $tmp_value=$bbprices->attributes()['condition'];
            $bbprice["$tmp_value"]=trim($bbprices->LandedPrice->Amount);
          }
          }
          else
          {
            continue;
          } 
          if(isset($xml->NotificationPayload->AnyOfferChangedNotification->Offers ))
          {
            foreach ($xml->NotificationPayload->AnyOfferChangedNotification->Offers->Offer as $bbprices)
            {
              $bb_flag= trim($bbprices->IsBuyBoxWinner);
              if(trim($bbprices->SellerId)==$sellerid)
              {
                $tempsubcond= trim($bbprices->SubCondition);
              $ourprice[$tempsubcond]['bb_total']=(float)trim($bbprices->ListingPrice->Amount)+(float)trim($bbprices->Shipping->Amount);
              $ourprice[$tempsubcond]['bb_list']=(float)trim($bbprices->ListingPrice->Amount);
              $ourprice[$tempsubcond]['bb_ship']=(float)trim($bbprices->Shipping->Amount);
              $ourprice[$tempsubcond]['bb_sellerid']= trim($bbprices->SellerId);
              $ourprice[$tempsubcond]['bb_fba']= trim($bbprices->IsFulfilledByAmazon);
              $ourprice[$tempsubcond]['bb_merchant']=trim($bbprices->IsFeaturedMerchant); 
              }
              if($bb_flag=='true')
              {
              $tempsubcond= trim($bbprices->SubCondition);
              $bbprice1[$tempsubcond]['bb_total']=(float)trim($bbprices->ListingPrice->Amount)+(float)trim($bbprices->Shipping->Amount);
              $bbprice1[$tempsubcond]['bb_list']=(float)trim($bbprices->ListingPrice->Amount);
              $bbprice1[$tempsubcond]['bb_ship']=(float)trim($bbprices->Shipping->Amount);
              $bbprice1[$tempsubcond]['bb_sellerid']= trim($bbprices->SellerId);
              $bbprice1[$tempsubcond]['bb_fba']= trim($bbprices->IsFulfilledByAmazon);
              $bbprice1[$tempsubcond]['bb_merchant']=trim($bbprices->IsFeaturedMerchant);
              }
            }
          }                 
          $log_array=self::$CI->db->get_where("user_listings",array("sellerid"=>$sellerid,"asin"=>$asin,"marketplaceid"=>$mkpid));
          $glob_array=self::$CI->db->get_where("user_settings",array("sellerid"=>$data['sellerid'],"marketplaceid"=>$mkpid))->row_array();
          $message=print_r($bbprice1,TRUE).print_r($ourprice,TRUE).print_r($bbprice,TRUE);
          if($log_array->num_rows()>0)
          {
            foreach($log_array->result_array() as $row)
            {       
              $new=array(); 
              $new['sellerid']=$sellerid;
              $new['marketplaceid']=$mkpid;
              $new['asin']=$asin;      
              $new['sku']=$row['sku'];
              $flag=0;
              foreach($bbprice as $key=>$value)
              {
                if(strcasecmp($row['item_condition'],$key)==0)
                {
                  $flag=1;
                  $match_cond=$key;
                  break;
                }
              }
              if($flag==0)
                continue;
              // now chekc the subcondition  
              $flag1=0;
              foreach($bbprice1 as $key=>$value)
              {
                if(strcasecmp($row['item_subcondition'],$key)==0)
                {
                  $flag1=1;
                  $match_subcond=$key;
                  break;
                }
              }
              if($flag1==0)
                continue;                       
              if((float)$row['min_price']=='0.00' || (float)$row['max_price']=='0.0')
              { 
                $message.='NOT reprice-> '.print_r($new,TRUE);
//                error_log($message,1, "repricinglegend@gmail.com");
                error_log($message,3, "/var/tmp/".rand().".log");
                continue;
              }
              // now take decision
              // we have buybox
              if($row['sellerid']==$bbprice1[$match_subcond]['bb_sellerid'])
              {
                  // rsie the price
                //update mysql 

               // $new['price']= $bbprice1[$match_subcond]['bb_ship']; 
                $new['price']= self::check_ubs_gbs($row,$glob_array,$bbprice1[$match_subcond],$ourprice[$match_subcond]['bb_list']);
                $new['ship_price']=$bbprice1[$match_subcond]['bb_ship'];
                $new['bb_price'] = $bbprice1[$match_subcond]['bb_total']; 
                $new['bb_eligible']=  $bbprice1[$match_subcond]['bb_merchant']=='true'?'yes':'no'; 
                $new['bb']=  'yes';
                $message.='Raise-> '.print_r($new,TRUE);
               // error_log($message,1, "repricinglegend@gmail.com");
               error_log($message,3, "/var/tmp/".rand().".log");
               if( self::price_update($new['sellerid'],$new['sku'],$new['price'],$new['marketplaceid'])!="tryagain")
                self::$CI->db->update('user_listings', $new, array('sellerid' => $new['sellerid'],'marketplaceid'=>$new['marketplaceid'],'sku'=>$row['sku'],'asin'=>$row['asin']));
                continue;
              }
              // amazon has buybox
               if(in_array($bbprice1[$match_subcond]['bb_sellerid'],array_keys(self::$CI->config->item('gl_serviceurl'))))
              {
                //update mysql 
                // beat amazon
                $new['price']=self::check_amazon_type($row,$bbprice1[$match_subcond]);
                $new['bb_price'] = $bbprice1[$match_subcond]['bb_total']; 
                $new['bb']=  'no';
               if(isset($ourprice[$match_subcond]['bb_total']) && $ourprice[$match_subcond]['bb_total'])
               {
                $new['ship_price']=$ourprice[$match_subcond]['bb_ship'];
                $new['bb_eligible']=  $ourprice[$match_subcond]['bb_merchant']=='true'?'yes':'no'; 
               }
                if($new['price'])
                {
                if(self::price_update($new['sellerid'],$new['sku'],$new['price'],$new['marketplaceid'])!="tryagain")
                self::$CI->db->update('user_listings', $new, array('sellerid' => $new['sellerid'],'marketplaceid'=>$new['marketplaceid'],'sku'=>$row['sku'],'asin'=>$row['asin']));
                  //uppdate then
                }
                $message.='Beating amazon-> '.print_r($new,TRUE);
            //    error_log($message,1, "repricinglegend@gmail.com");
              error_log($message,3, "/var/tmp/".rand().".log");
                continue;
              }
               if(isset($ourprice[$match_subcond]['bb_total']) && $ourprice[$match_subcond]['bb_total'])
                $new['price']= self::check_comp_type($row,$glob_array,$bbprice1[$match_subcond],$bbprice1[$match_subcond]['bb_list']);
               else
                $new['price']= self::check_comp_type($row,$glob_array,$bbprice1[$match_subcond],$bbprice1[$match_subcond]['bb_list']);
                $new['bb_price'] = $bbprice1[$match_subcond]['bb_total']; 
                $new['bb']=  'no';   
                if(isset($ourprice[$match_subcond]['bb_total']) && $ourprice[$match_subcond]['bb_total'])
               {
                $new['ship_price']=$ourprice[$match_subcond]['bb_ship'];
                $new['bb_eligible']=  $ourprice[$match_subcond]['bb_merchant']=='true'?'yes':'no'; 
               }                   
               if($new['price'])
               {
                if(self::price_update($new['sellerid'],$new['sku'],$new['price'],$new['marketplaceid'])!="tryagain")
                self::$CI->db->update('user_listings', $new, array('sellerid' => $new['sellerid'],'marketplaceid'=>$new['marketplaceid'],'sku'=>$row['sku'],'asin'=>$row['asin']));
                 // update
               }
                $message.='Beating else condition-> '.print_r($new,TRUE);
            //    error_log($message,1, "repricinglegend@gmail.com");
              error_log($message,3, "/var/tmp/".rand().".log");
                continue;
               //   self::price_update($data['sellerid'],$row['sku'],$new['price']=(float)$bbprice[$row['item_condition']]+(float)$row['beatbyvalue'],$mkpid);
                //self::$CI->db_mysql->on_duplicate_key_update()->insert("user_listings",$new);
              // ok got the details
              //get the bubox price
              //     self::$CI->db_mysql->on_duplicate_key_update()->insert("user_listings",$new);
              //            $new['marketplace']=$mkpid;
              //          $new['asin']=$asin;

              /// now update the c1-c10 prices
                /*
                for($i=1;$i<=10;$i++)
                {
                  if(isset($pass_array[$row['seller-sku']]["c".$i]))
                  {
                    $new['c'.$i]=$pass_array[$row['seller-sku']]["c".$i];
                  }

                }
                 */
            }
          }
        }
      }
      //   $new['beatby']=;
      //    $new['competitor_price']=;

      //  log_message('info',"now updated values are  ".print_r($new,TRUE));

      // porcess the meesa ge 
      // submit the feeds reprticing alfo based on beatbby formula or value option ok 

      log_message('info','sleeping sqs message for 120 seconds '.$data['sellerid']);
    //  self::delete_messages($data['sellerid'],$receipt);

      //        sleep(10);
      sleep(120);
    }
    //    $new['436456621616']='*';
    //   print_r(self::$CI->sqs->createQueue('justtesting',30));
    //    print_r(self::$CI->sqs->listQueues());
    //   print_r(self::$CI->sqs->addPermission('https://sqs.us-west-2.amazonaws.com/436456621616/justtesting','justlabel',$new));   
    //    print_r(self::$CI->sqs->getQueueAttributes('https://sqs.us-west-2.amazonaws.com/436456621616/justtesting'));
    //    print_r($data);
  }     
  public function sendemailnow()
  {

    if(!$this->input->is_cli_request())
    {
      log_message('error',"sendemailnow my only be accessed from the command line");
      return;
    }

    log_message('info',"sendemailnow created from the cron jobs");
    $worker= new GearmanWorker();
    $worker->addServer("localhost",4730);
    $worker->addFunction("send_email", "Testing::send_email");
    while ($worker->work());
  }        
  public function pricemap()
  {

    if(!$this->input->is_cli_request())
    {
      log_message('error',"created price map reports my only be accessed from the command line");
      return;
    }

    log_message('info',"created pricemap  from the cron jobs");
    $worker= new GearmanWorker();
    $worker->addServer("localhost",4730);
    $worker->addFunction("pricemap_report", "Testing::pricemap_report");
    while ($worker->work());
  }                      
  public function createfeesreport()
  {

    if(!$this->input->is_cli_request())
    {
      log_message('error',"createfeesreport my only be accessed from the command line");
      return;
    }

    log_message('info',"createfeesreport created from the cron jobs");
    $worker= new GearmanWorker();
    $worker->addServer("localhost",4730);
    $worker->addFunction("amazon_fbafees", "Testing::amazon_fbafees");
    while ($worker->work());
  }                              
  public function createdynamicreport()
  {

    if(!$this->input->is_cli_request())
    {
      log_message('error',"createdynamicreport my only be accessed from the command line");
      return;
    }

    log_message('info',"createdynamicreport created from the cron jobs");
    $worker= new GearmanWorker();
    $worker->addServer("localhost",4730);
    $worker->addFunction("dynamic_report", "Testing::dynamic_report");
    while ($worker->work());
  }              
  public function createamazonupdate_workers()
  {

    if(!$this->input->is_cli_request())
    {
      log_message('error',"createamazonupdate_workers my only be accessed from the command line");
      return;
    }

    log_message('info',"createamazonupdate_workers created from the cron jobs");
    $worker= new GearmanWorker();
    $worker->addServer("localhost",4730);
    $worker->addFunction("amazon_update", "Testing::amazon_update");
    while ($worker->work());
  }      
  public function createamazonrepricing_workers()
  {

    if(!$this->input->is_cli_request())
    {
      log_message('error', "createamazonrepricing_workers only be accessed from the command line");
      return;
    }       
    log_message('info',"createamazonrepricing_workers created from the cron jobs");
    $worker= new GearmanWorker();
    $worker->addServer("localhost",4730);
    $worker->addFunction("dynamic_repricing", "Testing::dynamic_repricing");
    while ($worker->work());        
  }                    
  public function createamazonsqs_workers()
  {

    if(!$this->input->is_cli_request())
    {
      log_message('error', "createamazonsqs_workers only be accessed from the command line");
      return;
    }       
    log_message('info',"createamazonsqs_workers created from the cron jobs");
    $worker= new GearmanWorker();
    $worker->addServer("localhost",4730);
    $worker->addFunction("amazon_sqs", "Testing::amazon_sqs");
    while ($worker->work());        
  }    
  public function createamazonreport()
  {

    if(!$this->input->is_cli_request())
    {
      log_message('error', "createamazonraeport only be accessed from the command line");
      return;
    }       
    log_message('info',"createamazonreport created from the cron jobs");
    $worker= new GearmanWorker();
    $worker->addServer("localhost",4730);
    $worker->setTimeout(-1);
    //$worker->addFunction("amazon_report", "Testing::amazon_report");
    $worker->addFunction("amazon_report", "Testing::getnewreport");
    while ($worker->work());        
  }                                   
  //this is tehe montioring services
  public function index()
  {  
    //    $this->load->helper('amazon_helper');
    log_message('info',date('Y-m-d H:i:s')." monitoring index ".dirname(__FILE__));
    //$this->load->library('gearmanclusteradmin',array('localhost:4730','localhost:4734') );
    $this->load->library('gearmanclusteradmin',array('localhost:4730') );
    //    $this->load->library('gearmanclusteradmin');

    //  $test=new GearmanClusterAdmin(array('localhost:4730','localhost:4734'));
    //    $test=new GearmanClusterAdmin(array('localhost:4730'));
    $myamazon= $this->gearmanclusteradmin->getAccumaltiveJobs();
    debug($myamazon);
    $base = '/Applications/AMPPS/www/legendpricing';
    if(isset($myamazon['amazon_update']))
    { 
      $available=$myamazon['amazon_update']['TOTAL']-$myamazon['amazon_update']['RUNNING'];
     // if($available>$myamazon['amazon_update']['AVAILABLE'])
      if($available>0)
      {
        log_message('info',date('Y-m-d H:i:s')." Created amazon update workeers");
        exec("nohup php $base/index.php  testing createamazonupdate_workers >/dev/null &");
      }
    }
    
    if(isset($myamazon['runLegendPricingTask']))
    { 
      $available=$myamazon['runLegendPricingTask']['TOTAL']-$myamazon['runLegendPricingTask']['RUNNING'];
     // if($available>$myamazon['amazon_update']['AVAILABLE'])
      if($available>0)
      {
        log_message('info',date('Y-m-d H:i:s')." Created runLegendPricingTask workeers");
        $log_date = date('Y-m-d');
        exec("nohup php $base/index.php  legendpricing_worker init > $base/application/logs/lp-worker-$log_date.logs &");
      }
    }
    
    if(isset($myamazon['dynamic_repricing']))
    {
      $available=$myamazon['dynamic_repricing']['TOTAL']-$myamazon['dynamic_repricing']['RUNNING'];
   //   if($available>$myamazon['amazon_sqs']['AVAILABLE'])
      if($available>0)
      {
        log_message('info',date('Y-m-d H:i:s')." Created amazon dynamic repricing workeers");
        exec("nohup php /var/www/html/index.php testing createamazonrepricing_workers >/dev/null &");
      }
    }  
    if(isset($myamazon['amazon_sqs']))
    {
      $available=$myamazon['amazon_sqs']['TOTAL']-$myamazon['amazon_sqs']['RUNNING'];
   //   if($available>$myamazon['amazon_sqs']['AVAILABLE'])
      if($available>0)
      {
        log_message('info',date('Y-m-d H:i:s')." Created amazon sqs workeers");
        exec("nohup php /var/www/html/index.php testing createamazonsqs_workers >/dev/null &");
      }
    } 
    if(isset($myamazon['amazon_report']))
    {
      $available=$myamazon['amazon_report']['TOTAL']-$myamazon['amazon_report']['RUNNING'];
    //  if($available>$myamazon['amazon_report']['AVAILABLE'])
      if($available>0)
      {
        log_message('info',date('Y-m-d H:i:s')." Created amazon reports".$myamazon['amazon_report']['TOTAL']." ".$myamazon['amazon_report']['RUNNING']);
        exec("nohup php /var/www/html/index.php testing createamazonreport >/dev/null &");
      }                               
    }    
    if(isset($myamazon['dynamic_report']))
    {
      $available=$myamazon['dynamic_report']['TOTAL']-$myamazon['dynamic_report']['RUNNING'];
    //  if($available>$myamazon['dynamic_report']['AVAILABLE'])
      if($available>0)
      {
        log_message('info',date('Y-m-d H:i:s')." Created dynamic amazon reports");
        // exec("nohup php /var/www/html/index.php testing createdynamicreport >/dev/null &");
        exec("nohup php /var/www/html/index.php testing createdynamicreport >/dev/null &");
      }                               
    }                
    if(isset($myamazon['amazon_fbafees']))
    {
      $available=$myamazon['amazon_fbafees']['TOTAL']-$myamazon['amazon_fbafees']['RUNNING'];
      if($available>0)
      {
        log_message('info',date('Y-m-d H:i:s')." Created dynamic amazon fees reports");
        exec("nohup php /var/www/html/index.php testing createfeesreport >/dev/null &");
      }                               
    }                
    if(isset($myamazon['send_email']))
    {
      $available=$myamazon['send_email']['TOTAL']-$myamazon['send_email']['RUNNING'];
      if($available>0)
      {
        log_message('info',date('Y-m-d H:i:s')." Created send email reports");
        exec("nohup php /var/www/html/index.php testing sendemailnow >/dev/null &");
      }                               
    }      
    if(isset($myamazon['price_map']))
    {
      $available=$myamazon['price_map']['TOTAL']-$myamazon['price_map']['RUNNING'];
      if($available>0)
      {
        log_message('info',date('Y-m-d H:i:s')." Created price map reports");
        exec("nohup php /var/www/html/index.php testing pricemap >/dev/null &");
      }                               
    }                                                                  
  }
}

?>
