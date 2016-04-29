<?php

	class Yespay{
		public  $paymentActionUrl;
		public  $marchantRemotePassword;
		public  $paymentCallbackSuccess;
		public  $paymentCallbackFailure;
		public  $refundActionUrl;
		public  $refundCallbackUrl;
		public  $digest;
		public  $params = array();
		public function __construct($config=array()){
			if (count($config) > 0){
				$this->initialize($config);
			}
			$this->customConfigSetting();
		}
		public function customConfigSetting(){
			$CI =& get_instance();
			$CI->config->load('yespay/yespay');
			$this->marchantRemotePassword  = $CI->config->item('marchantRemotePassword');
			$this->params['merchantID']    = $CI->config->item('merchantID');
			$this->params['currency']      = $CI->config->item('currency');
			$this->params['version']       = $CI->config->item('version');
			$this->paymentActionUrl        = $CI->config->item('paymentActionUrl');
			$this->paymentCallbackSuccess  = $CI->config->item('paymentCallbackSuccess');
			$this->paymentCallbackFailure  = $CI->config->item('paymentCallbackFailure');
			$this->refundActionUrl         = $CI->config->item('refundActionUrl');
			$this->refundCallbackUrl       = $CI->config->item('refundCallbackUrl');	
		}
		public function initialize($config = array()){
			foreach ($config as $key => $val){
				if($key=='digest' || $key=="callbackSuccess" || $key=="callbackFailure" || $key=="actionUrl"){
					$this->$key = $val;
				}
				else if(isset($this->params[$key])==''){
						$this->params[$key] = $val;
				}
			}
		}
		public function setParams($key,$val){
			if($this->params[$key]){
				unset($this->params[$key]);
			}
			if($this->params[$key]==$val)
				return false;
			else
				return true;
			
		}
		public function unsetParams($key){
			if($this->params[$key]){
				unset($this->params[$key]);
			}
			if($this->params[$key])
				return false;
			else
				return true;
			
		}
		public function cookDigest($digeststring){
			$this->digest = sha1($digeststring);
		}
		public function payment(){
			$this->cookDigest($this->params['MTR'].$this->params['amount'].$this->marchantRemotePassword);
			
			$form         = "<html>";
			$form        .= "<head><script type='text/javascript'>function submitForm(){document.forms['myform'].submit();}</script></head>";
			$form        .= "<body onload='submitForm();'><form name='myform' method='POST' action='".$this->paymentActionUrl."'>";
			foreach($this->params as $key => $val){
				$form    .= "<input type='hidden' name='".$key."' value='".$val."'/>"; 
			}
			$form        .= "<input type='hidden' name='callbackSuccess' value='".$this->paymentCallbackSuccess."'>";
			$form        .= "<input type='hidden' name='callbackFailure' value='".$this->paymentCallbackFailure."'>";
			$form        .= "<input type='hidden' name='digest' value='".$this->digest."'>";
			$form        .= "</form>";
			$form        .= "</body></html>";
			return $form;
		}
		public function refund(){
			$this->cookDigest($this->params['MTR'].$this->params['PGTR'].$this->params['refundAmount'].$this->marchantRemotePassword);
			
			$form         = "<html>";
			$form        .= "<head><script type='text/javascript'>function submitForm(){document.forms['myform'].submit();}</script></head>";
			$form        .= "<body onload='submitForm();'><form name='myform' method='POST' action='".$this->refundActionUrl."'>";
			foreach($this->params as $key => $val){
				$form    .= "<input type='hidden' name='".$key."' value='".$val."'/>"; 
			}
			$form        .= "<input type='hidden' name='callbackUrl' value='".$this->refundCallbackUrl."'>";
			$form        .= "<input type='hidden' name='digest' value='".$this->digest."'>";
			$form        .= "</form>";
			$form        .= "</body></html>";
			return $form;
		}
	}