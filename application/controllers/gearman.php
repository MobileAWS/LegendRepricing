<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Gearman extends CI_Controller {
  // This is just sample products -- you can name your
  // products anything and use any variables you like.
  // But you should be storing and calling product info
  // from your database though, and not like this.

  function __construct() {
    parent::__construct();

  }
  public function index()
  {
    $client= new GearmanClient();
    //$client->addServer("localhost",4731);
    $client->addServers("localhost:4731,localhost:4732,localhost");

    echo "ok sleepign ..";
    sleep(20);
    /*
      $task= $client->addTask("reverse", "foo");
    $task= $client->addTask("reverse", "foo");
    $task= $client->addTask("reverse", "foo");
    print $client->runTasks(); 
     */
    print $client->doBackground("reverse", "Hello World!");
    print $client->doBackground("reverse", "Hello World!");
    print $client->doBackground("reverse", "Hello World!");


  }

}
?>
