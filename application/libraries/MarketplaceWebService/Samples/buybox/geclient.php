<?php
$client= new GearmanClient();
$client->addServers("127.0.0.1");
/*
function reverse_complete($task)
{
      echo "COMPLETE: " . $task->jobHandle() . ", " . $task->data() . "\n";
}

function reverse_fail($task)
{
      echo "FAILED: " . $task->jobHandle() . "\n";
}
*/

//$client->setCompleteCallback("reverse_complete");
//$client->setFailCallback("reverse_fail");
//$test=array("ergf","rtgty");

//$task= $client->addTask("reverse", "foo");
//print $client->runTasks(); 
//print $client->doBackground("getBB", implode(" ",$test));

//print $client->doBackground("reverse", "Hello World!");
//echo "compleet";
?>
