<?php
include_once("profile.php");
include_once("getids.php");
include_once("geclient.php");
include_once("getest.php");
include_once("GetCompetitivePricingForSKUSample.php");  // we wwill use this 
include_once("GetCompetitivePricingForASINSample.php");

// get tehe value of the report
while(1)
{

foreach($profilearr1 as $value)
{
 // now ass the taskss
 $tmpvalue="";
 unset($temparrr);
 $temparrr=array();
$tmpvalue=verifyBB($value['seller-sku'],$value['item-condition']);
 if($tmpvalue === "true")
 {
 }
 else
 {
   $temparrr['seller-sku']=$value['seller-sku'];
   $temparrr['newprice']=$tmpvalue;
  $client->doBackground("getBB",implode(",",$temparrr));
 }

}
    
  sleep(60);

}

?>
