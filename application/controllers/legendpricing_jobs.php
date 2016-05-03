<?php

/**
 * Description of legendpricing_jobs
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
        $job = $this->client->addTaskBackground('runTask',  serialize($task));
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

class legendpricing_jobs extends CI_Controller {
    private $client;
    public function __construct() {
        parent::__construct();
        if (php_sapi_name() !== 'cli') {
            show_404();
        }
        $this->client = new LPGM_Client();
    }

    public function update_listings($seller_id) {
        $this->client->addTask( new LPGM_Task('update_listings',$seller_id) );
    }

}
