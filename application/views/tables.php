<?php 
// this is for listing page 

$doc = new DOMDocument();
$doc->loadHTMLFile("nav.html");
echo $doc->saveHTML();
//$doc->loadHTMLFile("table.html");
//echo $doc->saveHTML();
//include_once("table.php");
$doc->loadHTMLFile("subscription.html");
echo $doc->saveHTML();
//include_once("profile.php");

$doc->loadHTMLFile("footer.html");
echo $doc->saveHTML();
//$doc->loadHTMLFile("normal_footer.html");
//echo $doc->saveHTML();
//include_once("nav.html");
//include_once("table.html")   ;
//include_once("normal_footer.html") ;
/*
// this is for subscriptions page 
include_once("nav.html");
include_once("newsignup.html")   ;
include_once("footer.html") ;

// this is for profile page 
include_once("nav.html");
include_once("newsignup.html")   ;
include_once("footer.html") ;

// this is for settings page 
include_once("nav.html");
include_once("newsignup.html")   ;
include_once("footer.html") ;


// this is for dashboard page 
include_once("nav.html");
include_once("newsignup.html")   ;
include_once("footer.html") ;
 */
?>
