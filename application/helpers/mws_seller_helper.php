<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MWS_Seller
 *
 * @author 
 */
require_once(APPPATH . 'libraries/phpAmazonMWS/includes/includes.php');

$MWS_seller_id = '';
$MWS_marketplace_id = '';
$MWS_auth_token = '';

class MWS_Seller {

    //put your code here
    private $db;
    private $seller;
    
    /**
    * Initialize MWS_Seller with correct credentials
    * communitcate with Amazon
    */
    function __construct($seller_id, $marketplace_id = null) {
        $CI = & get_instance();
        $this->db = $CI->db;
        if ($marketplace_id == null) {
            $marketplace_id = MARKETPLACE_ID;
        }
        $conditons = array("sellerid" => $seller_id, "marketplaceid" => $marketplace_id);
        $this->seller = $this->db->get_where("user_settings", $conditons)->row_array();
        if (!$this->seller) {
            throw new Exception("Seller $seller_id not found in " . $marketplace_id . ' Market Place');
        }
    }
    
    /**
    * Get local listing from database
    * 
    */
    function getListings($status = null) {
        $conditions = array(
            "sellerid" => $this->seller['sellerid'],
            "marketplaceid" => $this->seller['marketplaceid']
        );

        if ($status) {
            $conditions['status'] = $status;
            $conditions['qty >'] = 0;
        }
        $listings = $this->db->get_where("user_listings", $conditions)->result_array();
        return $listings;
    }
    
    /**
    * Set seller credentials
    */
    private function setStore() {
        //$this->seller->sellerid,$this->seller->marketplaceid
        global $MWS_seller_id, $MWS_marketplace_id, $MWS_auth_token;
        $MWS_seller_id = $this->seller['sellerid'];
        $MWS_marketplace_id = $this->seller['marketplaceid'];
        $MWS_auth_token = $this->seller['mwsauthtoken'];
    }
    
    /**
    * Get products from amazon based on SKUs
    */
    function getMWSProducts($skuArray){
        $this->setStore();
        $products = array();
        $amz = new AmazonProductList();
        
        $limit = 5;
        $start =  0;
        while ($skuList = array_slice($skuArray, $start, $limit)) {
            $amz->setProductIds($skuList);
            $amz->setIdType("SellerSKU");
            $amz->fetchProductList();
            $products += $amz->getProduct();
            $start +=  $limit;
        }
        return $products;
    }
    
    /**
    * Get products Offer, LowestOffer and CompetitivePricing from amazon based on SKUs
    */
    function getMWSProductsListing($skuArray) {
        $this->setStore();
        $results = array();
        $limit = 20;
        $start =  0;
        while ($skuList = array_slice($skuArray, $start, $limit)) {
            // get my pricing
            $amz = new AmazonProductInfo();
            $amz->setSKUs($skuList);
            $amz->fetchMyPrice();
            $products = $amz->getProduct();
            foreach ($products as $product) {
                if(!is_object($product)){
                    die('not a product');
                }
                $tmp = $product->getData();
                $results[$tmp['Identifiers']['SKUIdentifier']['SellerSKU']] = $tmp;
            }
            // get competitive pricing
            $amz = new AmazonProductInfo();
            $amz->setSKUs($skuList);
            $amz->fetchCompetitivePricing();
            $products = $amz->getProduct();
            foreach ($products as $product) {
                $tmp = $product->getData();
                $results[$tmp['Identifiers']['SKUIdentifier']['SellerSKU']]['CompetitivePricing'] = $tmp['CompetitivePricing'];
            }

            // get competitive pricing
            $amz = new AmazonProductInfo();
            $amz->setSKUs($skuList);
            $amz->fetchLowestOffer();
            $products = $amz->getProduct();
            foreach ($products as $product) {
                $tmp = $product->getData();
                $results[$tmp['Identifiers']['SKUIdentifier']['SellerSKU']]['LowestOfferListings'] = $tmp['LowestOfferListings'];
            }
            $start +=  $limit;
        }
        return $results;
    }
    
    /**
    * Get inventory data based on time duration
    */
    function getMWSInvetory( $since ){
        $this->setStore();
        $mwsInvObj = new AmazonInventoryList();
        $mwsInvObj->setStartTime($since);
        $mwsInvObj->fetchInventoryList();
        $inventory =  $mwsInvObj->getSupply();
        return $inventory;
    }
}
