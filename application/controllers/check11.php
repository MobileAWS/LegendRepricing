
<?php

exec("/etc/init.d/gearman-job-server restart", $output, $return);
echo $output.PHP_EOL;
echo $return;
if ($return == 0) {
      echo "Ok, process is running\n";
}

?>
