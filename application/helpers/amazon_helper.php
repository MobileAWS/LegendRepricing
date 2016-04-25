<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');   
if ( ! function_exists('checkarray'))
{
  function checkarray($array,$key,$default)
  {  
    return isset($array[$key]) ? $array[$key] : $default;
  }

}                
if ( ! function_exists('checkvariable'))
{
  function checkvariable($value,$default)
  {  
    return isset($value) ? $value : $default;
  }

} 
 if ( ! function_exists('check_condition'))
{
  function check_condition($opt)
  { 

if($opt==1)return array("used","mint");
if($opt==2)
  return array("used","verygood");

if($opt==3)
  return array("used","good");
if($opt==4)
  return array("used","acceptable");
/*
  if($opt==5)
    return array("","");
if($opt==6)
  return array("","");
if($opt==7)
  return array("","");
if($opt==8)
  return array("","");
 */
return array("new","new");

  }
}
if ( ! function_exists('listing_validation'))
{
  function listing_validation($option,&$error)
  {
    // chekc for tice forprice 
    //    qty
    //    and fiulfilmentchanel
    // for price   
    if(isset($option['beat_amazon']))
    {
      //        if(preg_match("/^[0-9]+\.[0-9]{2}$/",   $option['min_price']) ==0)
   //   if(isset($option['beat_amazon_flag']) && $option['beat_amazon_flag']=='yes')
      {
        if(preg_match("/^[0-9]{1,4}\.[0-9]{2}$/",   $option['beat_amazon']) ==0)
        {
          $error='Beat amazon invalid value';
          log_message('error', 'caught amazon beat error');
          return FALSE;
        }
      }
    /*
      if(!isset($option['beat_amazon_flag']))
      {
        $CI =& get_instance();
        $log_array=$CI->db->get_where("user_listings",array("sellerid"=>$option['sellerid'],"marketplaceid"=>$option['marketplaceid'],"sku"=>$option['sku']))->row_array();
        if($log_array['beat_amazon_flag']=='yes')
        {
          if(preg_match("/^[0-9]{1,4}\.[0-9]{2}$/",   $option['beat_amazon']) ==0)
          {
            $error='Beat amazon invalid value';
            log_message('error', 'caught amazon beat error');
            return FALSE;
          }
        }        
      }
     */    
    }
      if((isset($option['min_price'])  || isset($option['max_price'])   ||  isset($option['price'])  || isset($option['map_price'])  || isset($option['ship_price']) ) )
      {       
        //   $wow=preg_grep("/^.*price/",array_keys( $option));
        if(isset($option['price']))
        {
          //      if(preg_match("/^[0-9]+\.[0-9]{2}$/",   $option['price']) ==0)
          if(preg_match("/^[0-9]{1,4}\.[0-9]{2}$/",   $option['price']) ==0)
          {
            $error='Price invalid value';
            log_message('error', 'caught price error');
          return FALSE;
        }
      }         
      if(isset($option['min_price']))
      {
//        if(preg_match("/^[0-9]+\.[0-9]{2}$/",   $option['min_price']) ==0)
        if(preg_match("/^[0-9]{1,4}\.[0-9]{2}$/",   $option['min_price']) ==0)
        {
          $error='Min Price invalid value';
          log_message('error', 'caught min price error');
          return FALSE;
        }
        if($option['min_price']=='0.00')
        {
          $error='Min Price invalid value';
          log_message('error', 'caught min price error');
          return FALSE;
        }
        if(!isset($option['max_price']))
        {
          $CI =& get_instance();
          $log_array=$CI->db->get_where("user_listings",array("sellerid"=>$option['sellerid'],"marketplaceid"=>$option['marketplaceid'],"sku"=>$option['sku']))->row_array();
          if((float) $log_array['max_price']<=$option['min_price'])
          {
        $error='Min Price should be less than max price';
          log_message('error', 'caught min price error');
          return FALSE;
          }
        }
        else
        {      
          if(preg_match("/^[0-9]{1,4}\.[0-9]{2}$/",   $option['max_price']) ==0)
      {
        $error='Max Price invalid value';
        log_message('error', 'caught max price error');
        return FALSE;
      }                  
          if( $option['max_price']<=$option['min_price'])
          {
        $error='Min Price should be less than max price';
          log_message('error', 'caught min price error');
          return FALSE;
          
          }
        }
      }     
      if(isset($option['max_price']))
      {
        //      if(preg_match("/^[0-9]+\.[0-9]{2}$/",   $option['max_price']) ==0)
        if(preg_match("/^[0-9]{1,4}\.[0-9]{2}$/",   $option['max_price']) ==0)
      {
        $error='Max Price invalid value';
        log_message('error', 'caught max price error');
        return FALSE;
      }      
        if($option['max_price']=='0.00')
        {
          $error='Max Price invalid value';
          log_message('error', 'caught max price error');
          return FALSE;
        }               
       if(!isset($option['min_price']))
        {
          $CI =& get_instance();
          $log_array=$CI->db->get_where("user_listings",array("sellerid"=>$option['sellerid'],"marketplaceid"=>$option['marketplaceid'],"sku"=>$option['sku']))->row_array();
          if( (float)$log_array['min_price']>=$option['max_price'])
          {
        $error='Min Price should be less than max price';
          log_message('error', 'caught max price error');
        return FALSE;
          }
        }              
       else
       {   
         if( $option['max_price']<=$option['min_price'])
          {
        $error='Min Price should be less than max price';
          log_message('error', 'caught min price error');
          return FALSE;
          }          
       }
      }   
      if(isset($option['map_price']))
      {
//      if(preg_match("/^[0-9]+\.[0-9]{2}$/",   $option['map_price']) ==0)
        if(preg_match("/^[0-9]{1,4}\.[0-9]{2}$/",   $option['map_price']) ==0)
      {
        $error='Map Price invalid value';
        log_message('error', 'caught map price error');
        return FALSE;
      }
      }           
      if(isset($option['ship_price']))
      {
  //    if(preg_match("/^[0-9]+\.[0-9]{2}$/",   $option['ship_price']) ==0)
        if(preg_match("/^[0-9]{1,4}\.[0-9]{2}$/",   $option['ship_price']) ==0)
      {
        $error='Ship Price invalid value';
        log_message('error', 'caught ship price error');
        return FALSE;
      }
      }           
      //alsof chekc less  thhan m,ax pirce
      if(isset($option['price']))
      {
        $CI =& get_instance();
        $log_array=$CI->db->get_where("user_listings",array("sellerid"=>$option['sellerid'],"marketplaceid"=>$option['marketplaceid'],"sku"=>$option['sku']))->row_array();
        if((isset($option['max_price']) && $option['price']>$option['max_price']) || (isset($option['min_price']) && $option['price']<$option['min_price']))
        {
        $error='Should be less than max price and more than min price';
        log_message('error', 'Price range confliction');
        return FALSE;
        }    
        if((!isset($option['max_price']) && $option['price']>(float)$log_array['max_price']) || (!isset($option['min_price']) && $option['price']<(float)$log_array['min_price']))
        {
          // 2 options
          if($log_array['max_price']!='notset' && $log_array['min_price']!="notset")
            $error='Should be less than max price and more than min price';
          else
            $error='Try to set min and max price too';
          log_message('error', 'Pirce range confliction');
          return FALSE;
        }            
      }
      if(isset($option['ship_price']))
      {
        $CI =& get_instance();
        $log_array=$CI->db->get_where("user_listings",array("sellerid"=>$option['sellerid'],"marketplaceid"=>$option['marketplaceid'],"sku"=>$option['sku']))->row_array();
        if(isset($option['fulfillment_channel']) && $option['fulfillment_channel']=="AMAZON_NA")    // whopp
        {
          $error='Cannot modify shipping price as AMAZON_NA' ;
          log_message('error', 'Cannot modify shipping price as AMAZON_NA');
          return FALSE;
        }
        if(!isset($option['fulfillment_channel']) && $log_array['fulfillment_channel']=='AMAZON_NA') 
        {
          $error='Cannot modify shipping price as AMAZON_NA' ;
          log_message('error', 'Cannot modify shipping price as AMAZON_NA');
          return FALSE;
        }
      }      //anpth resitriction fr shiping

      }
      if(isset($option['maxorderqty']) && preg_match("/^[0-9]+$/",   $option['maxorderqty']) ==0) 
      {
        $error='Max qty not valid';
        log_message('error', 'caught maxqty error');
      return FALSE;
    }
    if(isset($option['qty']) && preg_match("/^[0-9]+$/",   $option['qty']) ==0) 
    {
        $error='Qty not valid';
        log_message('error', 'caught qty  error');
      return FALSE;
    }
    if(isset($option['fulfillment_channel']) && preg_match("/^(AMAZON_NA|DEFAULT)$/", $option['fulfillment_channel']) ==0) 
    {
        $error='fulfillment_channel not valid';
        log_message('error', 'caught fulfillment_channel error');
      return FALSE;
    }
    return TRUE;
  }
}  
if ( ! function_exists('checkservers'))
{
  function checkservers()
  {
      $client= new GearmanClient();
      $client->addServer('localhost',4730);
      $result=@$client->ping('data testing');
      //echo $client->getErrno();
    return $client->returnCode();
  }                             
}  
if ( ! function_exists('backup_link'))
{
  function backup_link($option,$function_name)
  {    
    $log_array['unique_key']=gen_uuid();
    $log_array['function_name']=$function_name;
    $log_array['priority']=1;
    if($function_name=='amazon_report')
    {
    $new['sellerid']=$option['sellerid'];
    $new['marketplaceid']=$option['marketplaceid'];
    $new['mwsauthtoken']=$option['mwsauthtoken'];
    $log_array['data']=serialize($new);
    }
    else
    $log_array['data']=serialize($option);
    $CI =& get_instance();
    $CI->db->insert("table_name",$log_array);           

    // now restart the service
    if(stristr(php_uname(),'ubuntu')!==false)
      exec("/etc/init.d/gearman-job-server restart", $output, $return);
    else
      exec("service gearmand restart", $output, $return);
    if ($return == 0) {
      log_message('info', "Ok, process is re-running\n");
    }   else
    {
      log_message('error',"FAILED TO STRT THE GEARMAN SERVICE");
    }


  }                  
}   
if ( ! function_exists('gen_uuid'))
{
    function gen_uuid() {
  return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
    // 32 bits for "time_low"
    mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

    // 16 bits for "time_mid"
    mt_rand( 0, 0xffff ),

    // 16 bits for "time_hi_and_version",
    // four most significant bits holds version number 4
    mt_rand( 0, 0x0fff ) | 0x4000,

    // 16 bits, 8 bits for "clk_seq_hi_res",
    // 8 bits for "clk_seq_low",
    // two most significant bits holds zero and one for variant DCE1.1
    mt_rand( 0, 0x3fff ) | 0x8000,

    // 48 bits for "node"
    mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
  );
    }                    
}             
if ( ! function_exists('buybox_formula'))
{
  function buybox_formula($lowest,$shipping,$min,$max,$shipprice,$myprice) { 
          log_message('error', 'reccived values are '.$lowest.' '.$shipping.' '.$min.' '.$max.' '.$shipprice.' '.$myprice);
    $var=0.027*($lowest+$shipping)+0.01;
    $temp= (float)($myprice-$var);
if($temp<=0)
{
if($min=='0.00')
return $myprice;
else
return $min;
} 
    if((floor($temp * 100) / 100)<=($min+$shipprice))
    {
      if($min=='0.00')
      return    (floor($temp * 100) / 100);
      return $min;
    }
    else if ((floor($temp * 100) / 100)>=($max+$shipprice))
    {
      if($max=='0.00')
      return    (floor($temp * 100) / 100);
      return $max;
    }
    else
    {     
      return    (floor($temp * 100) / 100);
    }
  }
}
