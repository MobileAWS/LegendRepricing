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
        $selleridStr = !empty($this->seller['sellerid']) ? ' - '.$this->seller['sellerid'] : '';
        cli_echo("[$datetime]$selleridStr - ".$message);
        $this->mws_logs->log($selleridStr.' - '.$message, $level);
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
        $this->log("\n\n\t\t**repricing product $sku**\n");
        try{
            $seller = new MWS_Seller($sellerId);
        }catch(Exception $e){
            $this->log($e->getMessage());
            return false;
        }
        
        $product = $seller->LocalGetProduct($sku);
        $last_repriced = $product['last_repriced'];
        
        $item = $seller->MWSGetProduct($sku);
        
        if (!$item['Offers']) {
            $product['status'] = 'inactive';
        }

        $lr = new LegendRepricer($item, $product);
        $lr->reprice();
        if( $lr->hasBuyBox ){
            $this->log("####BuyBox###");
        }
        
        // lost buy box - we had it before
        if( $product['bb'] == 'no' && $lr->hasBuyBox ){
            $this->log('Won after Lost = YES');
            $product['bb_won_after_lost'] = 1;
        }
        
        if( $product['bb_won_after_lost'] && $lr->hasBuyBox ){
            $product['bb_won_after_lost'] = 1;
        }else{
            $product['bb_won_after_lost'] = 0;
        }
        
        $do_reprice = false;
        $product['price'] = (float) $product['price'];
        $this->log('###'.$lr->newPrice.' = '.$lr->ourPrice->listing.' from '.$product['price']);
        $mins = $this->GetMinutesSinceRepriced( $last_repriced );
        if ($lr->newPrice && $lr->newPrice != $lr->ourPrice->listing) {
            if( $lr->hasBuyBox && $lr->newPrice > $lr->ourPrice->listing ){
                $mins = $this->GetMinutesSinceRepriced( $product['last_repriced']);
                $this->log('BB-YES - last repriced '. $mins.' minutes ago');
                $wal = $product['bb_won_after_lost'] ? 'yes' : 'no';
                $this->log('Won after lost ='.$wal);
//                $product['bb_won_after_lost'] = 1;
//                $mins = 60;
                if( !$product['bb_won_after_lost'] || $mins >= 60 ){
                    $do_reprice = true;
                }
            }else{
                $do_reprice = true;
            }    
        }
        
        if( $do_reprice ){
            $this->log('### Reprcing to '.$lr->newPrice.' from '.$lr->ourPrice->listing);
            $seller->MWSPriceUpdate($product['sku'], $lr->newPrice);
        }
        
        $price_changed = 'no';
        $our_price = $product['price'];
        $new_price = $lr->ourPrice->listing;
        
        if ( $product['price'] != $lr->ourPrice->listing) {
            $product['last_repriced'] = $this->GetMySQLNowTime();
            $product['prevprice'] = $product['price'];
            $price_changed = 'yes';
        }
        
        $product['price'] = $lr->ourPrice->listing;
        
        $product['bb'] = $lr->hasBuyBox ? 'yes' : 'no';
        $product['bb_price'] = $lr->buyBox->landed;
        $product['c1'] = round($lr->lowestOffer['Price']->landed, 2);
        if( $product['fulfillment_channel'] != 'DEFAULT' ){
            $product['qty'] = $item['qty'];
        }
        $seller->LocalUpdateProduct($product);
        $seller->addRepriceLogs($product['sku'], $product['asin'], $price_changed, $our_price, $new_price, $product['bb_price'], $product['bb']);
    }
    
    
    function syncListingsFromMWS( $sellerId, $fba_fees = false ){
        $seller = new MWS_Seller($sellerId);
        if( !$seller->isAuthrized() ){
            return;
        }
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
        
        $skuArray = $seller->getListings();
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
            
            if( $item['fulfillment_channel'] != 'DEFAULT' ){
                $item['qty'] = $product['qty'];
            }
            
//            $item['last_repriced'] = $this->GetMySQLNowTime();
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
    
    
    function GetMySQLNowTime(){
        $query = "SELECT now() now";
        $now = $this->db->query($query)->result_array();
        return $now[0]['now'];
    }
    
    function GetMinutesSinceRepriced($last_repriced){
        $now = $this->GetMySQLNowTime();
        $mins = round(abs(strtotime($now) - strtotime($last_repriced)) / 60);
        return $mins;
    }

}
