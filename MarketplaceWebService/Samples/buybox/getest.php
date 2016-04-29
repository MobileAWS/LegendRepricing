<?php               
include_once("SubmitFeedSample.php");
function my_BB_function($job)
{
  // now  send the sumkitffeedssampel .php
  echo $job->workload();
    return strrev($job->workload());
    // call
}
$worker= new GearmanWorker();
$worker->addServer("127.0.0.1");
$worker->addFunction("getBB", "my_BB_function");
print "Waiting for job...\n";
while($worker->work())
{
  if ($worker->returnCode() != GEARMAN_SUCCESS)
  {
    echo "return_code: " . $worker->returnCode() . "\n";
    //      break;
  }
  else
  { // succes
  // suimt he feeds
  echo "got";
  }
}
//while ($worker->work());

?>

