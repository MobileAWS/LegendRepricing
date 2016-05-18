<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mws_common_helper
 *
 * @author 
 */
define('GearmanHost','localhost');
define('GearmanPort',4730);

class LPGM_Task{
    public $fn,$data;
    function __construct($fn,$data) {
        $this->fn = $fn;
        $this->data = $data;
    }
}

class LPGM_Client extends GearmanClient{
    private $client;
    function __construct($host=null,$port=null) {
        parent::__construct();
        $this->client = new GearmanClient();
        if( $host == null ){
            $host = GearmanHost;
        }
        if( $port == null ){
            $port = GearmanPort;
        }
        // Add a server
        $this->client->addServer($host,$port); // by default host/port will be "localhost" & 4730
    }
    
    function addTask($task){
//        debug($task);
//        debug(serialize($task));
        $job = $this->client->addTaskBackground('runLegendPricingTask',  serialize($task));
        $this->client->runTasks();
        
        $this->logJob($jobId,'added');
        if ($jobId) {
            //echo "Job added: $jobId§\n";
        }
    }
    
    private function logJob($jobId,$status){
        //todo
    }
}

function parse_condition($opt) {

    if ($opt == 1)
        return array("used", "mint");
    if ($opt == 2)
        return array("used", "verygood");

    if ($opt == 3)
        return array("used", "good");
    if ($opt == 4)
        return array("used", "acceptable");
    /*
      if($opt==5)
      return array("","");
      if($opt==6)
      return array("","");
      if($opt==7)
      return array("","");
      if($opt==8)
      return array("","");
     */
    return array("new", "new");
}
