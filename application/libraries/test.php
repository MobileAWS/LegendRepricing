<?php
$xml=simplexml_load_file("test.xml") or die("Error: Cannot create object");

foreach ($xml->NotificationPayload->AnyOfferChangedNotification->Summary->LowestPrices->LowestPrice as $prices)
{
//  echo $prices->attributes()->condition.PHP_EOL;
 // echo $prices->attributes()->fulfillmentChannel.PHP_EOL;
  //echo $prices->LandedPrice->Amount.PHP_EOL;
  // echo $prices->LandedPrice->Amount.PHP_EOL;
}
foreach( $xml->NotificationPayload->AnyOfferChangedNotification->Summary->BuyBoxPrices->BuyBoxPrice as $bb)
{
//  echo $bb->LandedPrice->Amount.PHP_EOL;
 // echo $bb->Shipping->Amount.PHP_EOL;
  //echo $bb->attributes()->condition.PHP_EOL;
}
echo $xml->NotificationPayload->AnyOfferChangedNotification->Summary->ListPrice->Amount.PHP_EOL;
echo $xml->NotificationPayload->AnyOfferChangedNotification->Summary->SuggestedLowerPricePlusShipping->Amount.PHP_EOL;
foreach( $xml->NotificationPayload->AnyOfferChangedNotification->Offers->Offer as $bb)
{
//  echo $bb->SellerId.PHP_EOL;
//  echo $bb->SubCondition.PHP_EOL;
 // echo $bb->ListingPrice->Amount.PHP_EOL;
//  echo $bb->Shipping->Amount.PHP_EOL;
 // echo $bb->IsFulfilledByAmazon.PHP_EOL;
  //echo $bb->IsBuyBoxWinner.PHP_EOL;
}

//print_r($xml);
?>
