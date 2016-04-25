<?php
define('AWS_ACCESS_KEY_ID','AKIAIPGAVOI4KG2HPRZA' ); 
define('AWS_SECRET_ACCESS_KEY', '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'); 
define ('MERCHANT_ID','A112ZN3BG4B0O0'); 
$marketplaceIdArray = array("Id" => array('ATVPDKIKX0DER')); 
include_once("RequestReportSample.php");
include_once("GetReportRequestListSample.php");
include_once("GetReportSample.php");
// now playe 

//getnewreport();
// now 

$reportid=fetchreportid();
//echo $myreportid;
fetchcsvfile($reportid);
?>
