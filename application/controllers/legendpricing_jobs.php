<?php

/**
 * Description of legendpricing_jobs
 *
 * @author 
 */
class legendpricing_jobs extends CI_Controller {

    private $client;
    public $db;

    public function __construct() {
        parent::__construct();
        if (php_sapi_name() !== 'cli') {
            //show_404();
        }
        $CI = & get_instance();
        $this->db = $CI->db;
        $this->load->helper('mws_common');
        $this->load->helper('mws_seller');
        $this->client = new LPGM_Client();
    }

    public function test() {
        $seller = new MWS_Seller('A3NP85KUD0UI05');
        $skuArray = $seller->getNewListings();
        $start = 0;
        $limit = 1000;
        while ($skuList = array_slice($skuArray, $start, $limit)) {
            $data['sellerId'] = $seller->getSellerId();
            $data['skuList'] = $skuList;
            $task = new LPGM_Task('updateProductData', $data);
//            debug($task);
            $this->client->addTask($task);
            $start += $limit;
        }
    }

    public function sync_listings($sellerId) {
        $data['update_fbafees'] = true;
        $data['sellerid'] = $sellerId; //'ANF2DSU3YZFVJ';
        $this->client->addTask(new LPGM_Task('syncListings', $data));
    }

    public function reprice_products() {
//        $conditions = array('sellerid' => 'ANF2DSU3YZFVJ');
//        $conditions = array();
        $results = $this->db->get_where("user_settings", $conditions, 4)->result();
//        debug($results);exit();
        foreach ($results as $row) {
            $task = new LPGM_Task('reprice_products', $row->sellerid);
            $this->client->addTask($task);
            //break;
        }
    }

    function sqs() {
        $results = $this->db->get_where("pollingtbl")->result_array();
        $task = new LPGM_Task('mws_sqs', $results);
        $this->client->addTask($task);
    }

}
