<?php
//include_once("GetReportSample.php");
//fetchcsvfile("57173016083");
//exit(0);
$result = array();
$mask = "%3s |%-5s | %-5s | %-5s | %-5s | %-5s | %-5s |%10s |%5s |%10s |%10s \n"; 
$count =0;
$fp = fopen('./test.csv','r');
  if (($headers = fgetcsv($fp, 0, "\t")) !== FALSE)
if ($headers)
  while (($line = fgetcsv($fp, 0, "\t")) !== FALSE) 
  if ($line)
if (sizeof($line)==sizeof($headers))
  $result[] = array_combine($headers,$line);
  fclose($fp);     
  printf($mask,'Itemid', 'zshop-shipping-fee','item-note','item-condition','zshop-category1','zshop-browse-path','product-id','add-delete','pending-quantity', 'Seller-sku','product-id-type','Quantity','ASIN1'); 
  foreach ($result as $value) {
    //  echo $value['asin1'];
    printf($mask, $count, $value['zshop-shipping-fee'], $value['item-note'],$value['item-condition'],$value['zshop-category1'],$value['zshop-browse-path'],$value['product-id'],$value['add-delete'],$value['pending-quantity'],$value['seller-sku'],$value['product-id-type'],$value['quantity'],$value['asin1']);
    $count+=1; 

  }
?>
