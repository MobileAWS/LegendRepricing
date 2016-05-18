<?php

/**
 * Description of legendpricing_worker
 *
 * @author 
 */
include_once APPPATH . 'helpers/legend_pricing_helper.php';

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
        $worker->addFunction('runLegendPricingTask', "legendpricing_worker::runlegendPricingTask");

        while (1) {
            print "Waiting for job...\n---------------------\n\n";
            $ret = $worker->work(); // work() will block execution until a job is delivered
            if ($worker->returnCode() != GEARMAN_SUCCESS) {
                break;
            }
        }
    }

    static public function runlegendPricingTask($job) {
        $task = (array) unserialize($job->workload());
        $fn = $task['fn'];
        $data = $task['data'];
        $jobId = $job->handle();

        cli_echo("======Starting job $fn with id " . $jobId . '======');

        if (!method_exists('legendpricing_worker', $fn)) {
            cli_echo($fn . ' is not defined.');
            return false;
        }
        // doing the real job
        $result = legendpricing_worker::$fn($data);

        legendpricing_worker::updateJobStatus($jobId, 'DONE');
        cli_echo("======Ending job $fn======\n\n");
    }

    static public function updateJobStatus($jobId, $status) {
        //todo
    }

    static function update_listings($seller_id) {
        $lp = new legend_pricing();
        $results = $lp->update_listings($seller_id);
        cli_echo(count($results) . " products fetched.");
    }

    static function syncListings($data) {
        $sellerId = $data['sellerid'];
        $update_fbafees = isset($data['update_fbafees']) ? $data['update_fbafees'] : false;
        $lp = new legend_pricing();
        $lp->syncListingsFromMWS($sellerId, $update_fbafees);
    }

    static function reprice_products($sellerId) {
        $lp = new legend_pricing();
        $seller = new MWS_Seller($sellerId);
        $products = $seller->getListings('active');
        foreach ($products as $row) {
            $lp->reprice_product($sellerId, $row['sku']);
        }
        return true;
    }

}
