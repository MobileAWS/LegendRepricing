<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of legend_pricing
 *
 * @author imran
 */
class legend_pricing {

    function __construct() {
        include_once APPPATH . 'helpers/mws_common_helper.php';
        include_once APPPATH . 'helpers/mws_reprice_helper.php';
        include_once APPPATH . 'helpers/mws_seller_helper.php';
        $this->mws_logs = new MWSLogs();
        $CI = & get_instance();
        $this->sqs = $CI->sqs;
        $this->db = $CI->db;
        $this->client = new LPGM_Client();
    }
    
    function log($message, $level = null) {
        if (!$level) {
            $level = 'info';
        }
        $datetime = date('Y-m-d H:i:s');
        $sellerid = $this->seller['sellerid'];
        cli_echo("[$datetime] - $sellerid - ".$message);
        $this->mws_logs->log($sellerid.' - '.$message, $level);
    }
    
    function update_listings($seller_id) {

        $seller = new MWS_Seller($seller_id);

        $results = $seller->getListings();
        $start = rand(0, count($results) - 1);
        $listings = array_slice($results, $start, 1);
        $skuList = array();
        foreach ($listings as $k => $v) {
            $skuList[] = $v['sku'];
            $myList[$v['sku']] = $v;
        }


        $products = $seller->getMWSProductsListing($skuList);
        return $products;
    }

    function reprice_product($sellerId, $sku) {
        $this->log("**repricing product $sku**\n");
        $seller = new MWS_Seller($sellerId);
        $product = $seller->LocalGetProduct($sku);
        $item = $seller->MWSGetProduct($sku);
        
        if (!$item['Offers']) {
            $product['status'] = 'inactive';
        }

        $lr = new LegendRepricer($item, $product);
        $lr->reprice();

        if (!$lr->newPrice) {
            $product['price'] = $lr->ourPrice->listing;
        }

        $product['price'] = (float) $product['price'];
        if ($lr->hasBuyBox || $product['price'] != $lr->ourPrice->listing) {
            $product['price'] = $lr->ourPrice->listing;
        }
        if ($lr->newPrice && $lr->newPrice != $lr->ourPrice->listing) {
            cli_echo('going to reprice');
            //$seller->MWSPriceUpdate($product['sku'], $lr->newPrice);
        }
        $product['bb'] = $lr->hasBuyBox ? 'yes' : 'no';
        $product['bb_price'] = $lr->buyBox->landed;
        $product['c1'] = round($lr->lowestOffer['Price']->landed, 2);
        $product['qty'] = $item['qty'];
        $seller->LocalUpdateProduct($product);
    }
    
    
    function syncListingsFromMWS( $sellerId, $fba_fees = false ){
        $seller = new MWS_Seller($sellerId);
        $skuList = $seller->getMerchantListingsData();
        if( !$skuList ){
            $this->log('Could not get merchant lsitings data');
            return false;
        }
        
        if ($fba_fees) {
            $fba_feed_data = $seller->MWSGetFBAFee();
            if ($fba_feed_data) {
                foreach ($fba_feed_data as $row) {
                    $skuList[$row['sku']]['fees'] = $row['estimated-fee-total'];
                }
            }
        }
        foreach($skuList as $sku=>$product){
            $seller->LocalUpdateProduct($product);
        }
        
        $skuArray = $seller->getNewListings();
        $start = 0;
        $limit = 1000;
//        $this->log( count($skuArray) . ' total skues' );
        while ($skuList = array_slice($skuArray, $start, $limit,true)) {
            $data['sellerId'] = $seller->getSellerId();
            $data['skuList'] = $skuList;
//            $this->log( count($skuList) . ' skus for this job' );
            $task = new LPGM_Task('updateProductData', $data);
            $this->client->addTask($task);
            $start += $limit;
        }
        
        return true;
    }
    
    function updateLocalProducts( $sellerId, $skuList ) {
//        debug($skuArr);exit();
//        debug($skuList);exit();
        $skuArr = array_keys($skuList);
        
        $seller = new MWS_Seller($sellerId);
        $products = $seller->MWSProductListingData($skuArr);
        $results = array();
        foreach ($products as $sku => $product) {
            $item = $skuList[$sku];
            $item['status'] = 'active';
            if (!$product['Offers']) {
                $item['status'] = 'inactive';
            }


            $lr = new LegendRepricer($product, $item);

            $item['ship_price'] = 'notset';
            if (isset($lr->ourPrice->shipping) && $item['fulfillment_channel'] == 'DEFAULT') {
                $item['ship_price'] = $lr->ourPrice->shipping;
            }
            $item['bb'] = $lr->hasBuyBox ? 'yes' : 'no';
            $item['bb_price'] = $lr->buyBox->landed;
            $item['c1'] = round($lr->lowestOffer['Price']->landed, 2);
            $item['qty'] = $product['qty'];
            $item['last_repriced'] = date('Y-m-d H:i:s');
//            $seller->LocalUpdateProduct($product);
            $results[] = $item;
        }

        $this->db->trans_start();
        foreach ($results as $item) {
            $seller->LocalUpdateProduct($item);
        }
        $this->db->trans_complete();
        return;
    }

    function mwsSqs($sqs_pool) {
        $attr['WaitTimeSeconds'] = 20;
        while (1) {
            foreach ($sqs_pool as $sqs) {
                $messages = $this->sqs->receiveMessage('https://sqs.us-west-2.amazonaws.com/436456621616/' . $sqs['sqs_id'], 9, null, $attr);
                cli_echo($sqs['sqs_id'] . ' ' . count($messages) . " messages(s)\n");
                if (count($messages) > 0) {
                    print_r($messages);
                }
            }
        }
    }

}
