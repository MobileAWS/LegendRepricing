<?php
$row = 1;
if (($handle = fopen("test.csv", "r")) !== FALSE) {
  while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE) {
    $num = count($data);
    echo " $num fields in line $row:\n";
    $row++;
    for ($c=0; $c < $num; $c++) {
      echo "fields is: ".$data[$c] . "\n";
    }
  }
  fclose($handle);
}
?>
