<?php 

   if ( ! defined('BASEPATH')) exit('No direct script access allowed');



    function d($var,$a=false){

	  echo "<pre>";

	  print_r($var);

	  echo "</pre>";
	  if($a)exit;

    }

	function isLogin($id,$redirect=false){

		$ci         = & get_instance();

		$id         = $ci->session->userdata($id);

		if($id){

			return true;

		}else{

			if($redirect){

				redirect($redirect);

			}else{

				return false;

			}

		}

	}

	function get(){

		parse_str($_SERVER['REQUEST_URI'],$get);

		$i=0;

		foreach($get as $key => $val){

			if($i==0)

				$key = substr(strstr($key,'?'),1);

			$result[$key] = $val;

		  	$i++;

		}

		return $result;

	}
	
	if(!function_exists('makePlayingTime')){
		 function makePlayingTime($playing_time){
			 
			$second    = $playing_time%60;
			$minute    = ($playing_time-$second)/60;
			if($second < 10)
				$second = "0".$second;
			$return = $minute.":".$second;
			return $return;
		 }
	 }
	 

function getShortUrl($longUrl){
	
	$bitly            = new Bitly();
	$loginUsername    = "atarue8";
    $apiKey           = "R_38c0f6863583c5e03aa7c48e53db01ec";
    $bitly->setAuthentication($loginUsername, $apiKey);
    $shortUrl         = $bitly->getShortURL($longUrl);
    
		return $shortUrl;
	}

function getShortUrlFromText($text){
		$text_array = explode(' ',$text);
		$i=0;
		foreach($text_array as $txr){
			if(substr($txr,0,7)=='http://' || substr($txr,0,8)=='https://' || substr($txr,0,4)=='www.'){
				if(substr($txr,0,13)!='http://bit.ly')
        	$shortUrl = getShortUrl($txr);
        if(substr($shortUrl,0,13)=='http://bit.ly')
					$text_array[$i] = $shortUrl;
			}
			$i++;				
		}
		return implode(' ',$text_array);
  }
  
  function addAcronym($text){
		$text_array = explode(' ',$text);
		$i=0;
		foreach($text_array as $txr){
			if(substr($txr,0,7)=='http://' || substr($txr,0,8)=='https://' || substr($txr,0,4)=='www.'){
			
			if(substr($txr,0,4)=='www.')	
			$text_array[$i] = "<a style='color:#0084B4' href='http://".$txr."' target='_blank'>".$txr."</a>";
			else
			$text_array[$i] = "<a style='color:#0084B4' href='".$txr."' target='_blank'>".$txr."</a>";
							
		}
		else
		{
			$text_array[$i] = $txr;
		}
			$i++;
		}
		return implode(' ',$text_array);
  }
 function array2json($arr) {
		
		if(function_exists('json_encode')) return json_encode($arr); //Lastest versions of PHP already has this functionality.
		$parts = array();
		$is_list = false;
	
		//Find out if the given array is a numerical array
		$keys = array_keys($arr);
		$max_length = count($arr)-1;
		if(($keys[0] == 0) and ($keys[$max_length] == $max_length)) {//See if the first key is 0 and last key is length - 1
			$is_list = true;
			for($i=0; $i<count($keys); $i++) { //See if each key correspondes to its position
				if($i != $keys[$i]) { //A key fails at position check.
					$is_list = false; //It is an associative array.
					break;
				}
			}
		}
	
		foreach($arr as $key=>$value) {
			if(is_array($value)) { //Custom handling for arrays
				if($is_list) $parts[] = array2json($value); /* :RECURSION: */
				else $parts[] = '"' . $key . '":' . array2json($value); /* :RECURSION: */
			} else {
				$str = '';
				if(!$is_list) $str = '"' . $key . '":';
	
				//Custom handling for multiple data types
				if(is_numeric($value)) $str .= $value; //Numbers
				elseif($value === false) $str .= 'false'; //The booleans
				elseif($value === true) $str .= 'true';
				else $str .= '"' . addslashes($value) . '"'; //All other things
				// :TODO: Is there any more datatype we should be in the lookout for? (Object?)
	
				$parts[] = $str;
			}
		}
		$json = implode(',',$parts);
		
		if($is_list) return '[' . $json . ']';//Return numerical JSON
		return '{' . $json . '}';//Return associative JSON
}

function GetColumn($a=array(), $column='id', $null=true, $column2=null)
{
		$ret = array();
		@list($column, $anc) = preg_split('/[\s\-]/',$column,2,PREG_SPLIT_NO_EMPTY);
		
		foreach( $a AS $one )
		{
		
		if ( $null || @$one[ $column ])
		$ret[] = @$one[ $column ].($anc?'-'.@$one[$anc]:'');
		}
		return $ret;
}

function GetObjectColumn($a=array(), $column='id', $null=true, $column2=null)
{
		$ret = array();
		@list($column, $anc) = preg_split('/[\s\-]/',$column,2,PREG_SPLIT_NO_EMPTY);
		
		foreach( $a AS $one )
		{
		
		if ( $null || @$one->$column)
		$ret[] = @$one->$column .($anc?'-'.@$one[$anc]:'');
		}
		return array_unique($ret);
}

/* support 2-level now */
function AssColumn($a=array(), $column='id')
{
		$two_level = func_num_args() > 2 ? true : false;
		if ( $two_level ) $scolumn = func_get_arg(2);
		
		$ret = array(); settype($a, 'array');
		if ( false == $two_level )
		{
		foreach( $a AS $one )
		{
		if ( is_array($one) )
		$ret[ @$one[$column] ] = $one;
		else
		$ret[ @$one->$column ] = $one;
		}
		}
		else
		{
		foreach( $a AS $one )
		{
		if (is_array($one)) {
		if ( false==isset( $ret[ @$one[$column] ] ) ) {
		$ret[ @$one[$column] ] = array();
		}
		$ret[ @$one[$column] ][ @$one[$scolumn] ] = $one;
		} else {
		if ( false==isset( $ret[ @$one->$column ] ) )
		$ret[ @$one->$column ] = array();
		
		$ret[ @$one->$column ][ @$one->$scolumn ] = $one;
		}
		}
		}
return $ret;
}