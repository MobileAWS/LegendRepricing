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

    public function sync_listings($seller_id) {
        $data['update_fbafees'] = true;
        $data['sellerid'] = 'ANF2DSU3YZFVJ';
        $this->client->addTask(new LPGM_Task('syncListings', $data));
    }

    public function reprice_products() {
//        $conditions = array('sellerid' => 'ANF2DSU3YZFVJ');
//        $conditions = array();
        $results = $this->db->get_where("user_settings", $conditions)->result();
        foreach ($results as $row) {
            $task = new LPGM_Task('reprice_products', $row->sellerid);
            $this->client->addTask($task);
            //break;
        }
    }

    function sqs() {
        $results = $this->db->get_where("pollingtbl")->result_array();
        $task = new LPGM_Task('mws_sqs',$results);
        $this->client->addTask($task);
    }

}
