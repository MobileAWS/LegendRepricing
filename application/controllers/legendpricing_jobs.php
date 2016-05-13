<?php

/**
 * Description of legendpricing_jobs
 *
 * @author 
 */


class legendpricing_jobs extends CI_Controller {
    private $client;
    public function __construct() {
        parent::__construct();
        if (php_sapi_name() !== 'cli') {
            show_404();
        }
        $this->load->helper('mws_common');
        $this->load->helper('mws_seller');
        $this->client = new LPGM_Client();
        
    }

    public function update_listings($seller_id) {
        $this->client->addTask( new LPGM_Task('update_listings',$seller_id) );
    }
    
    public function import_listings($seller_id) {
        $this->client->addTask( new LPGM_Task('importListings',$seller_id) );
    }
    
    public function reprice_product(){
        $sellerId = 'A1ERLGARDFTEUE';
        $data['seller_id'] = $sellerId;
        $seller = new MWS_Seller($sellerId);
        $products = $seller->getListings('active');
        foreach($products as $row){
            $data['sku'] = $row['sku'];
            $task = new LPGM_Task('reprice_product',$data);
            $this->client->addTask( $task );
        }
        
        
    }

}
