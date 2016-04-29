<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$gl_mkpid["ca"]="A2EUQ1WTGCTBG2";

$gl_mkpid["us"]="ATVPDKIKX0DER";

$gl_mkpid["de"]="A1PA6795UKMFR9";

$gl_mkpid["es"]="A1RKKUPIHCS9HS";

$gl_mkpid["fr"]="A13V1IB3VIYZZH";

$gl_mkpid["in"]="A21TJRUUN4KGV";

$gl_mkpid["it"]="APJ6JRA9NG5V4";

$gl_mkpid["uk"]="A1F83G8C2ARO7P";

$gl_mkpid["jp"]="A1VC38T7YXB528";

$gl_mkpid["cn"]="AAHKV2X7AFYLW";
$gl_mkpid["mx"]="A1AM78C64UM0Y8";

$gl_currency["A2EUQ1WTGCTBG2"]="CAD";
$gl_currency["ATVPDKIKX0DER"]="USD";
$gl_currency["A1AM78C64UM0Y8"]="MXN";

$gl_serviceurl["A2EUQ1WTGCTBG2"]="https://mws.amazonservices.ca";
$gl_serviceurl["ATVPDKIKX0DER"]="https://mws.amazonservices.com";
$gl_serviceurl["A1AM78C64UM0Y8"]="https://mws.amazonservices.com.mx";
$gl_serviceurl["A1PA6795UKMFR9"]="https://mws-eu.amazonservices.com";
$gl_serviceurl["A1RKKUPIHCS9HS"]="https://mws-eu.amazonservices.com";
$gl_serviceurl["A13V1IB3VIYZZH"]="https://mws-eu.amazonservices.com";
$gl_serviceurl["A21TJRUUN4KGV"]="https://mws.amazonservices.in";
$gl_serviceurl["APJ6JRA9NG5V4"]="https://mws-eu.amazonservices.com";
$gl_serviceurl["A1F83G8C2ARO7P"]="https://mws-eu.amazonservices.com";
$gl_serviceurl["A1VC38T7YXB528"]="https://mws.amazonservices.jp";
$gl_serviceurl["AAHKV2X7AFYLW"]="https://mws-eu.amazonservices.com.cn";
/*  gl_product types */

$gl_prod["1"]="ASIN";
$gl_prod["2"]="ISBN";
$gl_prod["3"]="UPC";
$gl_prod["4"]="EAN";

/* item condition */
$gl_item["1"]="Used; Like New ";
$gl_item["2"]="Used; Very Good ";
$gl_item["3"]="Used; Good ";
$gl_item["4"]="Used; Acceptable ";
$gl_item["5"]="Collectible; Like New";
$gl_item["6"]="Collectible; Very Good ";
$gl_item["7"]="Collectible; Good";
$gl_item["8"]="Collectible; Acceptable ";
$gl_item["11"]="New";
// item condition aray
$gl_cond=array('New', 'Used', 'Collectible', 'Refurbished',  'Club');
// item sub condition array 
$gl_subcond=array('New', 'Mint', 'VeryGood', 'Good', 'Acceptable', 'Poor', 'Club', 'OEM', 'Warranty', 'RefurbishedWarranty','Refurbished', 'OpenBox',  'Other');


$config['gl_marketplaceid']=$gl_mkpid;
$config['gl_prod']=$gl_prod;
$config['gl_item']=$gl_item;
$config['gl_currency']=$gl_currency;
$config['gl_serviceurl']=$gl_serviceurl;
