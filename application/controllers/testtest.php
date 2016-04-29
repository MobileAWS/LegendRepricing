<?php
   define ('DATE_FORMAT', 'Y-m-d\TH:i:s\Z');

define ('MERCHANT_ID', 'A112ZN3BG4B0O0');
define('AWS_ACCESS_KEY_ID', 'AKIAIPGAVOI4KG2HPRZA');
define('AWS_SECRET_ACCESS_KEY', 't2cz64syxrRnLT5LH/xBxHw+UN41lgt2ZOvgc5zL');

define('APPLICATION_NAME', '<Your Application Name>');
define('APPLICATION_VERSION', '<Your Application Version or Build Number>');



define ('MARKETPLACE_ID', 'ATVPDKIKX0DER');

class Testtest extends CI_Controller
{     	public function __construct(){

  parent::__construct();

}        // United States:
public function getnewreport($skuid,$newprice,$newmapprice)
{
//  global $marketplaceIdArray;
$marketplaceIdArray = array("Id" => array(trim("ATVPDKIKX0DER")));
$serviceUrl = "https://mws.amazonservices.com";
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

echo $skuid;
echo $newprice;
//return ;
//<MAP currency="USD">$newmapprice</MAP> 
// $request = new MarketplaceWebService_Model_RequestReportRequest($parameters);
$feed = <<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<AmazonEnvelope xsi:noNamespaceSchemaLocation="amznenvelope. xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"> 
<Header> 
<DocumentVersion>1.01</DocumentVersion> 
<MerchantIdentifier>A112ZN3BG4B0O0</MerchantIdentifier> 
</Header> 
<MessageType>Price</MessageType> 
<Message> <MessageID>1</MessageID> 
<Price> 
<SKU>$skuid</SKU> 
<StandardPrice currency="USD">$newprice</StandardPrice> 
<MAP currency="USD">$newmapprice</MAP> 
</Price> 
</Message> 
</AmazonEnvelope>
EOD;

$feedHandle = @fopen('php://memory', 'rw+');
fwrite($feedHandle, $feed);
rewind($feedHandle);

$request = new MarketplaceWebService_Model_SubmitFeedRequest();
$request->setMerchant(MERCHANT_ID);
$request->setMarketplaceIdList($marketplaceIdArray);
$request->setFeedType('_POST_PRODUCT_PRICING_DATA_');
//$request->setFeedType('_POST_PRODUCT_DATA_');
$request->setContentMd5(base64_encode(md5(stream_get_contents($feedHandle), true)));
rewind($feedHandle);
$request->setPurgeAndReplace(false);
$request->setFeedContent($feedHandle);
//$request->setMWSAuthToken('<MWS Auth Token>'); // Optional

rewind($feedHandle);
/********* End Comment Block *********/

$this->invokeSubmitFeed($service, $request);                                           
/*
 $request = new MarketplaceWebService_Model_RequestReportRequest();
 $request->setMarketplaceIdList($marketplaceIdArray);
 $request->setMerchant(MERCHANT_ID);
 $request->setReportType('_GET_MERCHANT_LISTINGS_DATA_');
// $request->setMWSAuthToken('<MWS Auth Token>'); // Optional

// Using ReportOptions
// $request->setReportOptions('ShowSalesChannel=true');

 return $this->invokeRequestReport($service, $request);
 */

}
public  function invokeSubmitFeed(MarketplaceWebService_Interface $service, $request) 
{
  try {
    $response = $service->submitFeed($request);

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
       error_log($ex->getMessage());
       echo "Error";
       echo $ex->getMessage();
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
/**
  * Get Report List Action Sample
  * returns a list of reports; by default the most recent ten reports,
  * regardless of their acknowledgement status
  *   
  * @param MarketplaceWebService_Interface $service instance of MarketplaceWebService_Interface
  * @param mixed $request MarketplaceWebService_Model_GetReportList or array of parameters
  */
public function invokeRequestReport(MarketplaceWebService_Interface $service, $request) 
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
         echo("Caught Exception: " . $ex->getMessage() . "\n");
         echo("Response Status Code: " . $ex->getStatusCode() . "\n");
         echo("Error Code: " . $ex->getErrorCode() . "\n");
         echo("Error Type: " . $ex->getErrorType() . "\n");
         echo("Request ID: " . $ex->getRequestId() . "\n");
         echo("XML: " . $ex->getXML() . "\n");
         echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
     }
 }
 

                                                                                

public function index()
{
  $this->load->library('email');
  $this->load->library('payment');
  $serviceUrl="https://mws.amazonservices.com/Products/2011-10-01";
  $config = array (
    'ServiceURL' => $serviceUrl,
    'ProxyHost' => null,
    'ProxyPort' => -1,
    'MaxErrorRetry' => 3
  );
  $this->getnewreport();

//  $service = new  MarketplaceWebService_Client(AWS_ACCESS_KEY_ID,AWS_SECRET_ACCESS_KEY,NULL,APPLICATION_NAME,APPLICATION_VERSION);
  //var_dump($service);


  //      $this->payment->paypalForm(45,"yhyhy","yhyyy");
//  $this->load->view('test',$data);

}
}

/*
include_once 'vendor/autoload.php';

//require_once 'core/CodeIgniter.php';

class Test extends CI_Controller
{
    public function index()
      {
            $browser = new Buzz\Browser();
                $response = $browser->get('http://www.google.com');

                    echo $browser->getLastRequest()."\n";
                        echo $response;
                          }
}
 */
?>
