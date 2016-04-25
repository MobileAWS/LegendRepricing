<?php
exec("pgrep gearman", $output, $return);
if ($return == 0) {
  echo "Ok, process is running\n";
}
else
{
  //            echo "restart the server now";
  if(stristr(php_uname(),'ubuntu')!==false)
    exec("/etc/init.d/gearman-job-server restart",$output,$return);
  else
  {
    echo 'using fedora';
    exec("service gearmand restart",$output,$return);
  }

  if($return==0)
  {
    // make conneciton
    echo 'making connection';
  }
}
?>

