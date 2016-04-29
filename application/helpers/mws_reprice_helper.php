<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mws_reprice_helper
 *
 * @author 
 */
class LegendRepricer {

    //put your code here
    private $product;
    private $rules;
    private $matched = null;
    private $buyBox = null;
    private $hasBuyBox;
    private $ourPrice;
    private $matchedOffers = array();
    private $lowestOffer;
    private $channelList = array(
        'DEFAULT' => array('all', 'amazon', 'fba', 'amazonandfba', 'amazonandfba'),
        'AMAZON_NA' => array('all', 'nonfba')
    );

    function __construct($product, $rules) {
        $this->product = new MWS_Product($product);
        $this->rules = $rules;
        $this->checkOurPrice();
        $this->checkBuyBox();
        $this->matchOffers();
    }

    /**
    * Reprice product based on settings
    */
    function reprice() {
//        debug($this);exit();
        debug('Nmae: '.$this->rules['itemname']);
        $link = "<a href='http://www.amazon.com/gp/product/{$this->product->identifiers['MarketplaceASIN']['ASIN']}' target='_blank'>view</a>";
        debug('SKU: '.$this->rules['sku'].' '.$link);
        debug('Our Price: '.$this->ourPrice->landed);
        $hasBuyBox = $this->hasBuyBox->landed ? 'Yes':'No';
        debug('Buy Box: '.$this->buyBox->landed.' ('.$hasBuyBox.')');
//        debug('Competitive Price'); debug($this->product->competitivePrices);
        debug('Lowest Offer: '.$this->lowestOffer['Price']->landed);
        debug($this->matchedOffers);
        exit();
        $bb_price = $this->buyBox->listing;
        $bb_shipping = $this->buyBox->shipping;
        $price = $this->rules['price'];
        $shipping = $this->rules['ship_price'];
        $min = $this->rules['min_price'];
        $max = $this->rules['max_price'];
        $beatBy = $this->rules['beatby'];
        
        switch($beatBy){
            case 'formula':
                $new_price = $this->buybox_formula($bb_price, $bb_shipping, $price, $shipping, $min, $max);
                break;
            case 'beatby':
                $new_price = $this->beatBy($bb_price, $bb_shipping, $price, $shipping);
                break;
            case 'beatmeby':
                $new_price = $this->beatMeBy($bb_price, $bb_shipping, $price, $shipping);
                break;
            case 'matchprice':
                $new_price = $this->matchPrice($bb_price, $bb_shipping, $price, $shipping);
                break;
            
        }
        
        return $new_price;
    }
    
    // need to change it
    private function buybox_formula($bb_price, $bb_shipping, $price, $shipping, $min, $max) {
        $var = 0.027 * ($bb_price + $bb_shipping) + 0.01;
        $temp = (float) ($price - $var);
        if ($temp <= 0) {
            if ($min == '0.00')
                return $price;
            else
                return $min;
        }
        if ((floor($temp * 100) / 100) <= ($min + $shipping)) {
            if ($min == '0.00')
                return (floor($temp * 100) / 100);
            return $min;
        }
        else if ((floor($temp * 100) / 100) >= ($max + $shipping)) {
            if ($max == '0.00')
                return (floor($temp * 100) / 100);
            return $max;
        }
        else {
            return (floor($temp * 100) / 100);
        }
    }

    private function beatBy($bb_price, $bb_shipping, $beatByPrice ) {
        return (float) $bb_price + (float) $bb_shipping - (float) $beatByPrice;
    }
    
    // need to change it
    private function beatMeBy($bb_price, $bb_shipping, $price, $shipping) {
        $newprice = (float) $buybox['bb_list'] + (float) $ubs['beatbyvalue'];
        if ($newprice <= 0 || $newprice <= $ubs['min_price'])
            return $ubs['min_price'];
        if ($newprice >= $ubs['max_price'])
            return $ubs['max_price'];
        return $newprice;
    }
    
    // need to change it
    private function matchPrice($bb_price, $bb_shipping, $price, $shipping) {
        if ($buybox['bb_list'] <= $ubs['min_price'])
            return $ubs['min_price'];
        if ($buybox['bb_list'] >= $ubs['max_price'])
            return $ubs['max_price'];
        $newprice = (float) $buybox['bb_list'];
        return $newprice;
    }

    private function checkOurPrice() {
        $this->ourPrice = new MWS_Price($this->product->myOffer['BuyingPrice']);
        //debug($this->product->myOffer);exit();
    }
    
    /**
    * Check if product is matched in lowest offerings
    */
    public function matchOffers() {
        if ($this->matched !== null) {
            return $this->matched;
        }

        $channel = $this->rules['fulfillment_channel'];
        $items = $this->product->lowestOffers;
        foreach ($items as $item) {
            $tmpPrice = new MWS_Price($itemp['Price']);
            $condition = strcasecmp($item['Qualifiers']['ItemCondition'],$this->product->myOffer['ItemCondition']) === 0 &&
                    strcasecmp($item['Qualifiers']['ItemSubcondition'], $this->product->myOffer['ItemSubCondition']) === 0;
            
            if( $condition ){
                $this->matchedOffers[] = $item;
            }
            
            
            
            $condition = strcasecmp($item['condition'], $this->rules['item_condition']) === 0 &&
                    strcasecmp($item['subcondition'], $this->rules['item_subcondition']) === 0 &&
                    $tmpPrice->listing == $this->buyBox->listing &&
                    $tmpPrice->shipping == $this->buyBox->shipping;

            if (!$condition || !isset($this->channelList[$channel])) {
                continue;
            }

            if (in_array($this->rules['comp_type'], $this->channelList[$channel])) {
                $this->matched = true;
            }
        }
        $lowestOffer = $this->matchedOffers[0];
        $lowestOffer['Price'] = new MWS_Price($lowestOffer['Price']);
        $this->lowestOffer = $lowestOffer;
//        debug($this->lowestOffer);exit();
    }
    
    /**
    * check if we have the buy box
    */
    public function checkBuyBox() {
        $this->hasBuyBox = false;
        $items = $this->product->competitivePrices;
        foreach ($items as $item) {
            $condition = strcasecmp($item['condition'], $this->rules['item_condition']) === 0;
            $condition = $condition && strcasecmp($item['subcondition'], $this->rules['item_subcondition']) === 0;
            if (!$condition) {
                continue;
            }
            if (strcasecmp($item['belongsToRequester'], 'true') === 0) {
                $this->hasBuyBox = true;
            }
            $this->buyBox = new MWS_Price($item['Price']);
        }
    }

}

/**
* MWS Product wrapper
*/
class MWS_Product {

    public $sku, $identifiers, $myOffer, $lowestOffers, $competitivePrices;

    function __construct($data) {
        $this->sku = $data['Identifiers']['SKUIdentifier']['SellerSKU'];
        $this->identifiers = $data['Identifiers'];
        $this->myOffer = $data['Offers'][0];
        $this->lowestOffers = $data['LowestOfferListings'];
        $this->competitivePrices = $data['CompetitivePricing']['CompetitivePrices'];
    }

}

/**
* MWS Price wraper
*/
class MWS_Price {

    public $landed, $listing, $shipping;
    public $currency_code;

    function __construct($mws_price, $landed = null, $listing = null, $shipping = null) {
        if ($mws_price) {
            $this->currency_code = $mws_price['LandedPrice']['CurrencyCode'];
            $this->landed = (float) $mws_price['LandedPrice']['Amount'];
            $this->listing = (float) $mws_price['ListingPrice']['Amount'];
            $this->shipping = (float) $mws_price['Shipping']['Amount'];
            return;
        }
        $this->currency_code = 'USD';
        $this->landed = (float) $landed;
        $this->listing = (float) $listing;
        $this->shipping = (float) $shipping;
    }

}
