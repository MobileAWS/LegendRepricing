<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache');
error_reporting(E_ALL);
//echo "Wait...please....".PHP_EOL;
fflush(stdout);
$new_url= substr($_SERVER['QUERY_STRING'],4);
//echo $new_url;
//$new_url='https://dashboard.mapstell.com/assets/graph/image.php?id=7658&gstyle=active';
//echo $url;
$parts = parse_url($new_url);
//var_dump($parts);
if($parts['path'] && $parts['query'])
{
parse_str($parts['path'], $query);
parse_str($parts['query'], $query);
//var_dump($query);
$string="/var/www/html/myimages/".$query['id'].'-'.$query['gstyle'].".png";
$string_display="/html/myimages/".$query['id'].'-'.$query['gstyle'].".png";
//echo $string;


//$url = "https://dashboard.mapstell.com/assets/graph/image.php?id=7792&gstyle=instinctive";    // Website URL to Create Image
//$command = "xvfb-run --server-args=\"-screen 0, 1024x768x24\" /usr/bin/cutycapt --delay=2000ms --url="."$new_url"." --out="."$string";
$command = "wkhtmltoimage   --javascript-delay 2000 "."$new_url"." "."$string";
//$output = shell_exec(escapeshellcmd($command));
exec(escapeshellcmd($command).' 2>&1', $outputAndErrors, $return_value);
//var_dump($outputAndErrors);
$im = imagecreatefrompng("$string");
header('Content-Type: image/png');
imagepng($im);
imagedestroy($im);
//echo '<html><body><img src="'.$string_display.'" /></body></html>';
}
else
{
  echo "Check the url again please ...it seems ERRRO";
}
?>
