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
        
        $CI = & get_instance();
        $this->db = $CI->db;
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

    function reprice_product($sellerId,$sku){
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
//        debug($lr->buyBox);exit();
//        var_dump($lr->ourPrice->listing);
//        var_dump($lr->newPrice);
//        var_dump($product['price']);
        if( $lr->newPrice && $lr->newPrice != $lr->ourPrice->listing ){
            cli_echo('going to reprice');
            $seller->MWSPriceUpdate($product['sku'], $lr->newPrice);
            
//            $product['price'] = $lr->newPrice;
        }
        $product['bb'] = $lr->hasBuyBox ? 'yes' : 'no';
        $product['bb_price'] = $lr->buyBox->landed;
//        debug($lr->lowestOffer);
        $product['c1'] = round($lr->lowestOffer['Price']->landed, 2);
        $product['qty'] = $item['qty'];
//        debug($product);
        $seller->LocalUpdateProduct($product);
    }

    function syncListingsFromMWS($sellerId, $fba_fees = false ) {
        var_dump($fba_fees);
        $seller = new MWS_Seller($sellerId);
        $report = $seller->MWSGetReport(_GET_MERCHANT_LISTINGS_DATA_);
        $skuList = array();
        $rows = array();
        foreach ($report as $row) {
            $new['sellerid'] = $seller->getSellerId();
            $new['marketplaceid'] = $seller->getMarketPlaceId();
            $new['itemname'] = htmlentities($row['item-name']);
            $new['listing_id'] = $row['listing-id'];
            $new['sku'] = $row['seller-sku'];
            $new['price'] = $row['price'];
            $new['marketplace'] = $row['item-is-marketplace'];
            list($tempcon, $tempsub) = parse_condition($row['item-condition']);
            $new['item_condition'] = $tempcon;
            $new['item_subcondition'] = $tempsub;
            $new['asin'] = $row['asin1'];
            $new['product_id'] = $row['product-id'];
            $new['product_id_type'] = $row['product-id-type'];
            $new['fulfillment_channel'] = $row['fulfillment-channel'];
            $new['prevprice'] = $row['price'];
            $new['email'] = $seller->getEmail();

            $skuArr[] = $row['seller-sku'];
            $skuList[$row['seller-sku']] = $new;
        }
        $products = $seller->MWSProductListingData($skuArr);
        if ($fba_fees) {
            $fba_feed_data = $seller->MWSGetFBAFee();
            foreach ($fba_feed_data as $row) {
                $skuList[$row['sku']]['fees'] = $row['estimated-fee-total'];
            }
        }

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
//            $seller->LocalUpdateProduct($product);
            $results[] = $item;
        }

        $this->db->trans_start();
//        $this->db->query('delete FROM user_listings WHERE sellerid = ? AND marketplaceid = ? ', array('sellerid' => $seller->getSellerId(), 'marketplaceid' => $seller->getMarketPlaceId()));
        foreach ($results as $item) {
            $seller->LocalUpdateProduct($item);
        }
        $this->db->trans_complete();
        return;
    }

}
