<?php
/**
 * File:    Bitly.class.php
 * Author:  Dennis Madsen <dennis@demaweb.dk>
 * Created: 03/01/2010
 * Updated  24/03/2010
 * Version: 1.0.1
*/
class Bitly {
	private $login = "";
	private $apiKey = "";
	private $url = "http://api.bit.ly/";	
	private $version = "2.0.1";
	public $history = true;
		
	/*
	* Creating a short Bit.ly URL from a long URL.
	*/
	public function getShortURL($longUrl) {		
		// Creating the parameters for the request
		$additionalParameterList = array(
			"longUrl" => urlencode($longUrl)
		);		
		$parameters = $this->getParameters($additionalParameterList);
		
		// Sending the request to Bit.ly
		$response = $this->sendRequest("shorten", $parameters);
		
		// Parsing the response and return the short url
		$json = @json_decode($response,true);
		return $json['results'][$longUrl]['shortUrl'];
	}
	
	
	/*
	* Returning the original URL from a short Bit.ly URL.
	*/
	public function getLongURL($shortUrl) {
		// Find the hash from the short URL
		$hash = $this->getHash($shortUrl);
	
		// Creating the parameters for the request
		$additionalParameterList = array(
			"shortUrl" => urlencode($shortUrl)
		);		
		$parameters = $this->getParameters($additionalParameterList);
		
		// Sending the request to Bit.ly
		$response = $this->sendRequest("expand", $parameters);
		
		// Parsing the response and return the long url
		$json = @json_decode($response,true);
		return $json['results'][$hash]['longUrl'];	
	}
	
	/*
	* Returning the number of click from a short Bit.ly URL.
	*/
	public function getClicks($shortUrl) {
		// Creating the parameters for the request
		$additionalParameterList = array(
			"shortUrl" => urlencode($shortUrl)
		);		
		$parameters = $this->getParameters($additionalParameterList);
		
		// Sending the request to Bit.ly
		$response = $this->sendRequest("stats", $parameters);
		
		// Parsing the response and return the long url
		$json = @json_decode($response,true);		
		return $json['results']['clicks'];	
	}
	
	/*
	* Returning the number of click of current bit.ly user from a short Bit.ly URL.
	*/
	public function getClicksByMe($shortUrl) {
		// Creating the parameters for the request
		$additionalParameterList = array(
			"shortUrl" => urlencode($shortUrl)
		);		
		$parameters = $this->getParameters($additionalParameterList);
		
		// Sending the request to Bit.ly
		$response = $this->sendRequest("stats", $parameters);
		
		// Parsing the response and return the long url
		$json = @json_decode($response,true);		
		return $json['results']['userClicks'];	
	}
	
	/*
	* Set your Bit.ly authentication.
	* http://bit.ly/account/your_api_key
	*/	
	public function setAuthentication($login, $apiKey) {
		$this->login = $login;
		$this->apiKey = $apiKey;
	}
	
	private function getParameters($additionalParameterList=null) {
		$parameters="";
		
		foreach ($additionalParameterList as $key => $value) {
			if (!empty($parameters)) $parameters .= "&";
			$parameters .= $key."=".$value;
		}
		
		if (!empty($parameters)) $parameters .= "&";
		$parameters .= "login=".$this->login."&apiKey=".$this->apiKey;
		if (!empty($this->version)) $parameters .= "&version=".$this->version;
		if ($this->history) $parameters .= "&history=".$this->history;
		
		return $parameters;
	}
	
	private function sendRequest($method, $parameters) {
		$url = $this->url . $method . "?" . $parameters;
	
		// Using cURL to handle the request
		// cURL Extension must be enabled in your PHP environment
		// Further information: http://php.net/manual/en/book.curl.php
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
		curl_close($ch);
		
		// Validating the response
		$this->validateResponse($response);
		
		return $response;
	}
	
	private function validateResponse($response) {
		// Checking the statusCode
		$json = @json_decode($response,true);
		$errorCode = $json['errorCode'];
		$errorMessage = $json['errorMessage'];
		
		// Printing error message if error exists
		if ($errorCode!=0)
			die("Bit.ly error: ".$errorMessage.". Error code: ".$errorCode.".");
	}
	
	private function getHash($bitlyUrl) {
		$searchString = "bit.ly/";
		$pos = strpos($bitlyUrl, $searchString);
		if ($pos === false)
			die("Invalid Bit.ly short url.");
		return substr($bitlyUrl, ($pos+strlen($searchString)));
	}	
}
?>