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
        cli_echo('Initializing seller..' . $seller_id);
        $CI = & get_instance();
        $this->CI = $CI;
        $this->db = $CI->db;
        $this->db_mysql = $CI->db_mysql;
        if ($marketplace_id == null) {
            $marketplace_id = MARKETPLACE_ID;
        }
        $conditons = array("sellerid" => $seller_id, "marketplaceid" => $marketplace_id);
        $this->seller = $this->db->get_where("user_settings", $conditons)->row_array();
        if (!$this->seller) {
            throw new Exception("Seller $seller_id not found in " . $marketplace_id . ' Market Place');
        }
    }
    
    function getSellerId(){
        return $this->seller['sellerid'];
    }
    
    function getMarketPlaceId(){
        return $this->seller['marketplaceid'];
    }
    
    /**
     * Get local listing from database
     * 
     */
    function getListings($status = null) {
        cli_echo('Fetching seller listings');
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
     * Get local product from database by sku
     * 
     */
    function getProductBySKU($sku) {
        
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
    function getMWSProducts($skuArray) {
        $this->setStore();
        $products = array();
        $amz = new AmazonProductList();

        $limit = 5;
        $start = 0;
        while ($skuList = array_slice($skuArray, $start, $limit)) {
            $amz->setProductIds($skuList);
            $amz->setIdType("SellerSKU");
            $amz->fetchProductList();
            $products += $amz->getProduct();
            $start += $limit;
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
        $start = 0;
        cli_echo('Fetching listing from amazon...');
        while ($skuList = array_slice($skuArray, $start, $limit)) {
            // get my pricing
            $amz = new AmazonProductInfo();
            $amz->setSKUs($skuList);
            cli_echo('fetchMyPrice for ' . implode(', ', $skuList));
            $amz->fetchMyPrice();
            $products = $amz->getProduct();
            foreach ($products as $product) {
                if (!is_object($product)) {
                    die('not a product');
                }
                $tmp = $product->getData();
                $results[$tmp['Identifiers']['SKUIdentifier']['SellerSKU']] = $tmp;
                if (!isset($tmp['Offers'])) {
                    $results[$tmp['Identifiers']['SKUIdentifier']['SellerSKU']]['Offers'] = null;
                }
            }
            // get competitive pricing
            $amz = new AmazonProductInfo();
            $amz->setSKUs($skuList);
            cli_echo('fetchCompetitivePricing for ' . implode(', ', $skuList));
            $amz->fetchCompetitivePricing();
            $products = $amz->getProduct();
            foreach ($products as $product) {
                $tmp = $product->getData();
                $results[$tmp['Identifiers']['SKUIdentifier']['SellerSKU']]['CompetitivePricing'] = $tmp['CompetitivePricing'];
            }

            // get competitive pricing
            $amz = new AmazonProductInfo();
            $amz->setSKUs($skuList);
            cli_echo('fetchLowestOffer for ' . implode(', ', $skuList));
            $amz->fetchLowestOffer();
            $products = $amz->getProduct();
            foreach ($products as $product) {
                $tmp = $product->getData();
//                debug($tmp);exit();
                $results[$tmp['Identifiers']['SKUIdentifier']['SellerSKU']]['LowestOfferListings'] = $tmp['LowestOfferListings'];
            }

            $amz = new AmazonInventoryList();
            $amz->setSellerSkus($skuList);
            $amz->fetchInventoryList();
            $supplies = $amz->getSupply();
            foreach ($supplies as $supply) {
                $results[$supply['SellerSKU']]['qty'] = $supply['InStockSupplyQuantity'];
            }


            $start += $limit;
        }
        return $results;
    }

    /**
     * Get inventory data based on time duration
     */
    function getMWSInvetory($since) {
        $this->setStore();
        $mwsInvObj = new AmazonInventoryList();
        $mwsInvObj->setStartTime($since);
        $mwsInvObj->fetchInventoryList();
        $inventory = $mwsInvObj->getSupply();
        return $inventory;
    }

    function LocalUpdateProduct($data) {
        unset($data['last_modified']);
//        debug($data);exit();
        $this->db_mysql->on_duplicate_key_update()->insert("user_listings", $data);
    }

    function LocalGetProduct($sku) {
        if (empty($sku)) {
            throw new Exception('SKU is empty');
        }
        cli_echo('Fetching local product ' . $sku);
        $conditions = array(
            "sellerid" => $this->seller['sellerid'],
            "marketplaceid" => $this->seller['marketplaceid'],
            "sku" => $sku
        );

        $product = $this->db->get_where("user_listings", $conditions)->result_array();
//        debug($this->db);exit();
        if (empty($product)) {
            throw new Exception($sku . ' does not exist');
        }
        return $product[0];
    }

    function MWSGetProduct($sku) {
        $this->setStore();
        $mws_product = array();

        // get my pricing
        $amz = new AmazonProductInfo();
        $amz->setSKUs($sku);
        cli_echo('fetchMyPrice for ' . $sku);
        $amz->fetchMyPrice();
        $product = $amz->getProduct()[0];
        if (!is_object($product)) {
            die('not a product');
        }
        $tmp = $product->getData();
        $mws_product = $tmp;
        if (!isset($tmp['Offers'])) {
            $mws_product['Offers'] = null;
        }

        // get competitive pricing
        $amz = new AmazonProductInfo();
        $amz->setSKUs($sku);
        cli_echo('fetchCompetitivePricing for ' . $sku);
        $amz->fetchCompetitivePricing();
        $product = $amz->getProduct()[0];
        $tmp = $product->getData();
        $mws_product['CompetitivePricing'] = $tmp['CompetitivePricing'];

        // get competitive pricing
        $amz = new AmazonProductInfo();
        $amz->setSKUs($sku);
        cli_echo('fetchLowestOffer for ' . $sku);
        $amz->fetchLowestOffer();
        $product = $amz->getProduct()[0];
        $tmp = $product->getData();
        $mws_product['LowestOfferListings'] = $tmp['LowestOfferListings'];

        $amz = new AmazonInventoryList();
        $amz->setSellerSkus($sku);
        $amz->fetchInventoryList();
        $supply = $amz->getSupply()[0];
        $mws_product['qty'] = $supply['InStockSupplyQuantity'];

        return $mws_product;
    }

    function MWSUpdatePrice($sku, $price) {
        $this->setStore();
        $sellerid = $this->getSellerId();
        $currency_code = $this->CI->config->item($this->getMarketPlaceId(),'gl_currency');;
        $feed = <<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<AmazonEnvelope xsi:noNamespaceSchemaLocation="amznenvelope. xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"> 
<Header> 
<DocumentVersion>1.01</DocumentVersion> 
<MerchantIdentifier>$sellerid</MerchantIdentifier> 
</Header> 
<MessageType>Price</MessageType> 
<Message> <MessageID>1</MessageID> 
<Price> 
<SKU>$sku</SKU> 
<StandardPrice currency="$currency_code">$price</StandardPrice> 
</Price> 
</Message> 
</AmazonEnvelope>
EOD;
        $amz = new AmazonFeed();
        $amz->setMarketplaceIds($this->getMarketPlaceId());
        $amz->setFeedType('_POST_PRODUCT_PRICING_DATA_');
        $amz->setFeedContent($feed);
        debug($amz);exit();
        $status = $amz->submitFeed();
        $respose = $amz->getResponse();
        debug($feed);
        debug($respose);
        return $respose;
    }

    function MWSUpdateShipping($sku, $shipping) {
        
    }

    function MWSUpdateMAPPrice($sku, $map_price) {
        
    }
    
    function MWSGetFeed(){
        $this->setStore();
        $amz = new AmazonFeedList();
//        $amz->setFeedTypes('_POST_PRODUCT_PRICING_DATA_');
        if( isset($_GET['fid']) && !empty($_GET['fid']) ){
            $amz->setFeedIds($_GET['fid']);
        }
        $amz->fetchFeedSubmissions();
        $list = $amz->getFeedList();
        debug($list);exit();
    }

}
