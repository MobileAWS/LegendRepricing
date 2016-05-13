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
    public $product;
    public $rules;
    public $matched = null;
    public $buyBox = null;
    public $hasBuyBox;
    public $ourPrice;
    public $newPrice;
    public $matchedOffers = array();
    public $lowestOffer;
    public $channelList = array(
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
//        debug('Nmae: '.$this->rules['itemname']);
//        $link = "<a href='http://www.amazon.com/gp/product/{$this->product->identifiers['MarketplaceASIN']['ASIN']}' target='_blank'>view</a>";
//        debug('SKU: '.$this->rules['sku'].' '.$link);
//        debug('Our Price: '.$this->ourPrice->landed);
//        $hasBuyBox = $this->hasBuyBox->landed ? 'Yes':'No';
//        debug('Buy Box: '.$this->buyBox->landed.' ('.$hasBuyBox.')');
//        debug('Competitive Price'); debug($this->product->competitivePrices);
//        debug('Lowest Offer: '.$this->lowestOffer['Price']->landed);
//        debug($this->matchedOffers);
//        exit();
        $bb_price = $this->buyBox->listing;
        $bb_shipping = $this->buyBox->shipping;
        $price = (float) $this->rules['price'];
        $shipping = (float) $this->rules['ship_price'];
        $min = (float) $this->rules['min_price'];
        $max = (float) $this->rules['max_price'];
        $beatBy = $this->rules['beatby'];
//        $beatBy = 'formula';
        $beatByValue = (float) $this->rules['beatbyvalue'];
        if ($min <= 0) {
            $this->newPrice = false;
            return;
        }
//        debug($beatBy);
        switch ($beatBy) {
            case 'formula':
                $nlanding = $this->buybox_formula($this->hasBuyBox,$bb_price, $bb_shipping, $price, $shipping);
                break;
            case 'beatby':
                $nlanding = $this->beatBy($this->hasBuyBox, $bb_price, $bb_shipping, $beatByValue);
                break;
            case 'beatmeby':
                $nlanding = $this->beatMeBy($this->hasBuyBox, $bb_price, $bb_shipping, $beatByValue);
                break;
            case 'matchprice':
                $nlanding = $this->matchPrice($this->hasBuyBox, $bb_price, $bb_shipping, $price);
                break;
        }
//        debug($nlanding.' ('.$min.' - '.$max.')');
        $new_price = null;
        if ($nlanding <= $min) {
            $new_price = $min - $shipping;
//            debug('if '.$new_price);
        } else if ($nlanding - $shipping >= $max) {
            $new_price = $max - $shipping;
//            debug('else '.$new_price);
        } else {
            $new_price = $nlanding - $shipping;
        }

        $this->newPrice = $new_price;
    }

    // need to change it
    private function buybox_formula($hasBuyBox, $bb_price, $bb_shipping, $price, $shipping) {
        $bb_landing = $bb_price + $bb_shipping;
        $landing = $price + $shipping;
        
        if( $hasBuyBox ){
            $landing = round($landing + $landing * 0.01, 2);
        }else{
            $landing = round($landing - $landing * 0.01, 2);
        }
        
        return $landing;
    }

    private function beatBy($hasBuyBox, $bb_price, $bb_shipping, $beatByPrice) {
        $bb_landing = $bb_price + $bb_shipping;
        return $bb_landing - $beatByPrice;
    }

    // need to change it
    private function beatMeBy($hasBuyBox, $bb_price, $bb_shipping, $beatByPrice) {
        $bb_landing = $bb_price + $bb_shipping;
        return $bb_landing + $beatByPrice;
    }

    // need to change it
    private function matchPrice($hasBuyBox, $bb_price, $bb_shipping) {
        return $bb_price + $bb_shipping;
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
        $items = isset($this->product->lowestOffers) ? $this->product->lowestOffers : array();
        foreach ($items as $item) {
            $tmpPrice = new MWS_Price($itemp['Price']);
            $condition = strcasecmp($item['Qualifiers']['ItemCondition'], $this->rules['item_condition']) === 0;
            //&& strcasecmp($item['Qualifiers']['ItemSubcondition'], $this->product->myOffer['ItemSubCondition']) === 0;

            if ($condition) {
                $this->matchedOffers[] = $item;
            }

//            $condition = strcasecmp($item['condition'], $this->rules['item_condition']) === 0 &&
//                    strcasecmp($item['subcondition'], $this->rules['item_subcondition']) === 0 &&
//                    $tmpPrice->listing == $this->buyBox->listing &&
//                    $tmpPrice->shipping == $this->buyBox->shipping;
//
//            if (!$condition || !isset($this->channelList[$channel])) {
//                continue;
//            }
//
//            if (in_array($this->rules['comp_type'], $this->channelList[$channel])) {
//                $this->matched = true;
//            }
        }
         $this->lowestOffer = null;
        if (count($items)) {
            $lowestOffer = $this->matchedOffers[0];
            $lowestOffer['Price'] = new MWS_Price($lowestOffer['Price']);
            $this->lowestOffer = $lowestOffer;
        }
    }

    /**
     * check if we have the buy box
     */
    public function checkBuyBox() {
        $this->hasBuyBox = false;
        $items = isset($this->product->competitivePrices) ? $this->product->competitivePrices : array();
        foreach ($items as $item) {
            $condition = strcasecmp($item['condition'], $this->rules['item_condition']) === 0;
//            $condition = $condition && strcasecmp($item['subcondition'], $this->rules['item_subcondition']) === 0;
//            $condition = strcasecmp($item['condition'],$this->product->myOffer['ItemCondition']) === 0;
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
