<?php

/// define our won constats
$fp = fopen('../../'.$argv[1], 'r');
$mydata=array();
$line = fgets($fp, 2048);
$mydata= explode(" ",$line);
define('AWS_ACCESS_KEY_ID', $mydata[3]); 
define('AWS_SECRET_ACCESS_KEY', $mydata[4]); 
define ('MERCHANT_ID',$mydata[5]); 
$marketplaceIdArray = array("Id" => array(trim($mydata[6]))); 
fclose($fp);
include_once("SubmitFeedSample.php");
include_once("RequestReportSample.php");
include_once("GetReportRequestListSample.php");
include_once("GetReportSample.php");
$result = array();
function refreshthefile()
{
global $result;
$result = array();
$reportid=fetchreportid();
sleep(3);
while ($reportid=="notfound")
{
  echo "Sleeping for 60 seconds";
  sleep(60);
$reportid=fetchreportid();
}
//echo $myreportid;
fetchcsvfile($reportid);
$fp = fopen('test.csv','r');
  if (($headers = fgetcsv($fp, 0, "\t")) !== FALSE)
if ($headers)
  while (($line = fgetcsv($fp, 0, "\t")) !== FALSE) 
  if ($line)
if (sizeof($line)==sizeof($headers))
  $result[] = array_combine($headers,$line);
  fclose($fp);
}
//  print_r($result);

//exit(0);
// iterate teh array 
function initialize()
{
  global $result;
  refreshthefile();
passthru('echo $(tput clear)');
passthru('echo $(tput cup 3 75)');
passthru('echo "AMAZON"');
echo "\n";
passthru('echo $(tput setaf 4)');
$mask = "%3s |%-50.50s |%10s |%5s |%10s |%10s \n";
printf($mask,'Itemid', 'ItemName', 'Seller-sku','Price','Quantity','ASIN1');
//printf($mask, '1', 'A value that fits the cell');
//printf($mask, '2', 'A too long value the end of which will be cut off');
$count=0;
foreach ($result as $value) {
//  echo $value['asin1'];
printf($mask, $count, $value['item-name'], $value['seller-sku'],$value['price'],$value['quantity'],$value['asin1']);
  $count+=1;
//  echo "\n";
}

passthru('echo $(reset)');
}
  getnewreport();
initialize();
// ask for input i
 $handle = fopen ("php://stdin","r");
while(1)
{
echo "\033[s";
//printf("\033");
 echo "Are you sure you want to change this?  Type 'number' to continue: ";  

 $id = fgets($handle);
 if(trim($id)=='R' || trim($id)=='r')
  {
    initialize();
    continue;
}
 if(!is_numeric(trim($id)) || trim($id) < 0){
     //save the position
         echo "Invalid input ..Please enter again!\n"; 
         echo "\033[u";
         echo "\033[K";
//         echo "\033[J";
continue;

 }
 if(trim($id)>=count($result))
   {
          echo "Invalid input ..Please enter again!\n"; 
         echo "\033[u";
         echo "\033[K";
//         echo "\033[J";
continue; 
   }
 echo "\n"; 
 echo "Thank you, continuing...\n";
echo "\033[s";
 echo "Enter the new price?  Type 'number' to continue: "; 
 $newprice = fgets($handle);
while(!is_numeric(trim($newprice)))
{ 
  if(trim($newprice)=='R' || trim($newprice)=='r')
  {
    initialize();
    continue 2;
} 
  if(!is_numeric(trim($newprice))){
   //save the position  
   if(trim($newprice)  == "n" || trim($newprice)  == "N" ||   trim($newprice)  == "C" || trim($newprice)  == "c"    )
   {
// nneed to clear everything  
        echo "\033[u";
        echo "\033[3A";
         echo "\033[J"; 
         continue 2;

   } 
         echo "Invalid price ..Please enter again!\n"; 
         echo "\033[u";
         echo "\033[K";
echo "\033[s";
 echo "Enter the new price?  Type 'number' to continue: "; 
 $newprice = fgets($handle);
//         echo "\033[J";


 } 
}
/// echo "\033[s";
        echo "\033[J";
 echo "OK! Type 'Yes' to confirm: "; 
 $line = fgets($handle);  
 if(trim($line)=='R' || trim($line)=='r')
  {
    initialize();
    continue ;
}  
  if(trim($line)=="Yes"){
// send the curl requets 
   //save the position
   //ca l tth func
//echo $result[trim($id)]['seller-sku']; 
//echo $newprice;

//sleep(100);
 echo "\033[s";
 echo "Enter the new  mapprice?  Type 'number' to continue: "; 
 $newmapprice = fgets($handle);
while(!is_numeric(trim($newmapprice)))
{                                     
  if(trim($newmapprice)=='R' || trim($newmapprice)=='r')
  {
    initialize();
    continue 2;
}  
  if(!is_numeric(trim($newmapprice))){
   //save the position  
   if(trim($newmapprice)  == "n" || trim($newmapprice)  == "N" ||   trim($newmapprice)  == "C" || trim($newmapprice)  == "c"    )
   {
// nneed to clear everything  
        echo "\033[u";
        echo "\033[4A";
         echo "\033[J"; 
         continue 3;

   } 
         echo "Invalid price ..Please enter again!\n"; 
         echo "\033[u";
         echo "\033[K";
echo "\033[s";
 echo "Enter the new mapprice?  Type 'number' to continue: "; 
 $newmapprice = fgets($handle);
//         echo "\033[J";


 } 
}
/// echo "\033[s";
        echo "\033[J";
 echo "OK! Type 'Yes' to confirm: "; 
 $line11 = fgets($handle); 
 if(trim($line11)=='R' || trim($line11)=='r')
  {
    initialize();
    continue ;
}   
  if(trim($line11)=="Yes"){ 
    echo $newmapprice;
changeprice(trim($newprice), $result[trim($id)]['seller-sku'], $newmapprice);
/// quque the reposrtnoe 

getnewreport();
//         echo "\033[J";

  }
            echo "\033[u";
        echo "\033[5A";
         echo "\033[J";  

         continue; 

 }
          echo "\033[u";
        echo "\033[4A";
         echo "\033[J"; 
}

  ?>
