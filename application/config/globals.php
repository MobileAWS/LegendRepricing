<?php

// Create customized config variables
$config['web_Address']= 'http://www.formget.com/blog';
$config['title']= 'Legend Repricing';
$config['currency']= '';
$config['amazon_url']= 'http://www.amazon.com/gp/product/';
$config['seller_url']= 'http://www.amazon.com/gp/aag/main?ie=UTF8&seller=';

function debug($v){
    print_r('<pre>');
    print_r($v);
    print_r('</pre>');
}

function cli_echo($string,$nl=true){
    if (php_sapi_name() != 'cli') {
        return;
    }
    $pnl =$nl ? "\n":'';
    echo $string.$pnl;
}

?>
