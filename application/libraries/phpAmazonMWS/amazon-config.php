<?php
/**
 * Copyright 2013 CPI Group, LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 *
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

define('MWSkeyId','AKIAJWQSXIPAKQWURUBQ');
define('MWSsecretKey','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');

global $MWS_seller_id,$MWS_marketplace_id,$MWS_auth_token;
$store['myStore']['merchantId'] = $MWS_seller_id;//Merchant ID for this store
$store['myStore']['marketplaceId'] = $MWS_marketplace_id; //Marketplace ID for this store
$store['myStore']['MWSAuthToken'] = $MWS_auth_token;//'';//MWSAuthToken for this store
$store['myStore']['keyId'] = MWSkeyId; //Access Key ID
$store['myStore']['secretKey'] = MWSsecretKey; //Secret Access Key for this store
$store['myStore']['serviceUrl'] = ''; //optional override for Service URL


//Service URL Base
//Current setting is United States
$AMAZON_SERVICE_URL = 'https://mws.amazonservices.com/';

//Location of log file to use
$logpath = __DIR__.'/log.txt';

//Name of custom log function to use
$logfunction = '';

//Turn off normal logging
$muteLog = false;

?>
