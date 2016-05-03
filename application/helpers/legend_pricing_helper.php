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
        include_once APPPATH . 'helpers/mws_reprice_helper.php';
        include_once APPPATH . 'helpers/mws_seller_helper.php';
    }

    function update_listings($seller_id) {

        $seller = new MWS_Seller($seller_id);

        $results = $seller->getListings();
        $start = rand(0,count($results)-1);
        $listings = array_slice($results, $start, 1);
        $skuList = array();
        foreach ($listings as $k => $v) {
            $skuList[] = $v['sku'];
            $myList[$v['sku']] = $v;
        }
        
        
        $products = $seller->getMWSProductsListing($skuList);
        
        return $products;
    }

}
