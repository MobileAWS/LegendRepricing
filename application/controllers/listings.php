<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Listings extends CI_Controller {

    public function __construct() {

        parent::__construct();

        $this->load->library('pagination');
        $this->load->library("form_validation");

        if (!$this->session->userdata("logged_in"))
            redirect("home");
    }

    public function index() {
        $this->load->helper('mws_seller');
        $this->load->helper('mws_reprice');
        $this->load->driver('cache');

        try {
            $items = array();
            $reprice = false;
            if (isset($_POST['reprice']) && !empty($_POST['data'])) {
                $reprice = true;
                foreach ($_POST['data'] as $item) {
                    if (!isset($item['sku'])) {
                        continue;
                    }
                    $items[$item['sku']] = $item;
                }
            }
            $seller_id = 'A112ZN3BG4B0O0';

            $seller = new MWS_Seller($seller_id);

            $listings = $seller->getListings('active');
            $skuList = array();
            foreach ($listings as $k => $v) {
//                debug($items);
                if (empty($items)) {
//                    $skuList[] = $v['sku'];
//                    $myList[$v['sku']] = $v;  
                } elseif (isset($items[$v['sku']])) {
                    $item = $items[$v['sku']];
                    $v['min_price'] = $item['min_price'];
                    $v['max_price'] = $item['max_price'];
                    $v['price'] = $item['price'];
                    $v['qty'] = $item['qty'];
                    $v['ship_price'] = $item['ship_price'];
                    $v['beatby'] = $item['beatby'];
                    $v['beatbyvalue'] = isset($item['beatbyvalue']) ? $item['beatbyvalue'] : '';
                } else {
                    continue;
                }
                $skuList[] = $v['sku'];
                $myList[$v['sku']] = $v;
            }
//            debug($myList);exit();
            
            if (!empty($items)) {
//                $ck = md5(serialize($skuList));
//                if (!$products = $this->cache->file->get($ck)) {
//                    $products = $seller->getMWSProductsListing($skuList);
//                    $ok = $this->cache->file->save($ck, $products, 300);
//                }
                $products = $seller->getMWSProductsListing($skuList);
                foreach ($products as $sku => $product) {
                    $lr = new LegendRepricer($product, $myList[$sku]);
                    $lr->reprice();
//                    debug($lr);exit();
                    $myList[ $sku ]['new_price'] = $lr->newPrice;
                    $myList[ $sku ]['bb'] = $lr->hasBuyBox ? 'yes' : 'no';
                    $myList[ $sku ]['bb_price'] = $lr->buyBox->landed;
                    $myList[ $sku ]['bb'] = 'yes';
                    
                }
            }
            $data['reprice'] = $reprice;
            $data['listing'] = $myList;
        } catch (Exception $ex) {
            echo 'There was a problem with the Amazon library. Error: ' . $ex->getMessage();
        }
        $this->load->view('listings/main', $data);
    }

}
