<?php
/**
 * Description of legendpricing_worker
 *
 * @author 
 */
include_once APPPATH.'helpers/legend_pricing_helper.php';

class legendpricing_worker extends CI_Controller {
    private $lp;
    public function __construct() {
        parent::__construct();
        if (php_sapi_name() !== 'cli') {
            show_404();
        }
        
    }
    
    static public function init() {
        // Create our worker object
        $worker = new GearmanWorker();

        // Add a server (again, same defaults apply as a worker)
        $worker->addServer();
        $worker->addOptions(GEARMAN_WORKER_GRAB_UNIQ);
        // Inform the server that this worker can process "reverse" function calls
        $worker->addFunction('runTask',"legendpricing_worker::runTask");

        while (1) {
            print "Waiting for job...\n---------------------\n\n";
            $ret = $worker->work(); // work() will block execution until a job is delivered
            if ($worker->returnCode() != GEARMAN_SUCCESS) {
                break;
            }
        }
    }
    
    static public function runTask( $job ){
        $task = (array) unserialize($job->workload());
        $fn = $task['fn'];
        $data = $task['data'];
        $jobId = $job->handle();
        
        cli_echo("======Starting job $fn with id ".$jobId.'======');
        
        // doing the real job
        $result = legendpricing_worker::$fn($data);
        
        legendpricing_worker::updateJobStatus($jobId,'DONE');
        cli_echo("======Ending job $fn======\n\n");
    }
    
    static public function updateJobStatus($jobId,$status){
        //todo
    }
    
    function update_listings( $seller_id ) {
        $lp = new legend_pricing();
        $results = $lp->update_listings($seller_id);
        cli_echo(count($results)." products fetched.");
        
    }

}