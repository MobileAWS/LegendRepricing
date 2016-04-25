<?php
//include_once("GetReportSample.php");
//fetchcsvfile("57173016083");
ini_set('auto_detect_line_endings',TRUE);
//exit(0);
$profilearr = array();
$mask = "%10s |%-5s | %-5s | %-5s | %-5s | %-5s | %-5s \n"; 
$count =0;
$fp = fopen('./profile.csv','r');
  if (($headers = fgetcsv($fp, 0, ",")) !== FALSE)
if ($headers)
  while (($line = fgetcsv($fp, 0, ",")) !== FALSE) 
  if ($line)
if (sizeof($line)==sizeof($headers))
  $profilearr[] = array_combine($headers,$line);
  fclose($fp);     
  printf($mask,'min-price','max-price', 'max-order', 'beatby','seller-rating', 'exclude', 'amazon-beatby');
  foreach ($profilearr as $value) {
    printf($mask, $value['min-price'], $value['max-price'],$value['max-order'],$value['beatby'],$value['seller-rating'],$value['exclude'],$value['amazon-beatby']);
  }
   


  ini_set('auto_detect_line_endings',FALSE);
?>
