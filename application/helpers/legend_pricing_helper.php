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
    
    function reprice_product($sellerID,$sku){
        $seller = new MWS_Seller($sellerID);
        $product = $seller->LocalGetProduct($sku);
        $item = $seller->MWSGetProduct( $sku );
        
        if( !$item['Offers'] ){
            $product['status'] = 'inactive';
        }
        
        $lr = new LegendRepricer($item, $product);
        $lr->reprice();
        
        if( !$lr->newPrice ){
            $product['price'] = $lr->ourPrice->listing;
        }
        
        if( $lr->hasBuyBox ){
            $product['price'] = $lr->ourPrice->listing;
        }
        
        $product['bb'] = $lr->hasBuyBox ? 'yes' : 'no';
        $product['bb_price'] = $lr->buyBox->landed;
        $product['c1'] = round($lr->lowestOffer['Price']->landed,2);
        $product['qty'] = $item['qty'];
        debug($item);
        debug($product);exit();
        $seller->LocalUpdateProduct($product);
    }

}
