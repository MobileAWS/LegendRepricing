<?php
//$content = file_get_contents("test.csv");
$csv = array_map('str_getcsv', file('test.csv'));
var_dump($csv);
//$rows = array_map('str_getcsv', $content, array_fill(0, count($content), "\t"));

?>
