<?php
//include_once("GetReportSample.php");
//fetchcsvfile("57173016083");
$idsarray=array();
//exit(0);
$profilearr1 = array();
$fp = fopen('./test.csv','r');
  if (($headers = fgetcsv($fp, 0, "\t")) !== FALSE)
if ($headers)
  while (($line = fgetcsv($fp, 0, "\t")) !== FALSE) 
  if ($line)
if (sizeof($line)==sizeof($headers))
  $profilearr1[] = array_combine($headers,$line);
  fclose($fp);     
//  printf($mask,'min-price','max-price', 'max-order', 'beatby','seller-rating', 'exclude', 'amazon-beatby');
   
?>
