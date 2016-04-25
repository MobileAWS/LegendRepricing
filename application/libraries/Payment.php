<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2006, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Email Class
 *
 * Permits Payment.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category		Libraries
 * @author		Manas kanti dey
 * @link		http://codeigniter.com/user_guide/libraries/email.html
 */
class CI_Payment {

	var	$returnUrl;
	var	$failureUrl;
	var $notifyUrl;
	var	$paymentDescription;
	var $currency; 
	var $paypal_email;

	/**
	 * Constructor - Sets Email Preferences
	 *
	 * The constructor can be passed an array of config values
	 */	
	function CI_Payment($config = array())
	{
		
		if (count($config) > 0)
		{
			$this->initialize($config);
		}	
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize preferences
	 *
	 * @access	public
	 * @param	array
	 * @return	void
	 */	
	function initialize($config = array())
	{
		foreach ($config as $key => $val)
		{
			if (isset($this->$key)=='')
			{
					$this->$key = $val;
			}
		}
	}
	
	
function paypalForm($paymentAmount,$mTable,$paymentDescription,$directPayment=FALSE,$postUrl='https://www.sandbox.paypal.com/cgi-bin/webscr') {
        global $lang, $setts;

        $paymentDesc = ($paymentDescription) ? $lang[paypalpayment] : $paymentDescription;
        ### this will be the new payment form design
        //echo "<table width=\"100%\" border=\"0\" cellspacing=\"4\" cellpadding=\"4\" class=\"paymenttable\">\n";
        //  echo "        <tr>\n";
        ### the PG image will go below
       // echo "           <td width=\"160\" class=\"paytable1\"><img src=\"themes/".$setts[default_theme]."/img/system/paypal_logo.gif\"></td>\n";
        ### the description will go below
        echo "                <form action=\"".$postUrl."\" method=\"post\" name=\"f1\" id=\"payform\">                                \n";
   ## echo "        <td class=\"paytable2\" width=\"100%\">$lang[paypal_description_new]".(($directPayment)? "<br>".displayAmount($paymentAmount,$currency) :"");
        
        ## this setting is for the direct payment feature
        if ($directPayment) {
                echo "<br><strong>$lang[add_insurance]:</strong> $currency <input type=\"text\" name=\"insurance\" value=\"\" size=\"7\">\n";
        }
        echo "  </td>\n";
        ### the payment gateway from will go below
   echo "        <td class=\"paytable3\">                                                                \n".
             "                 <input type=\"hidden\" name=\"cmd\" value=\"_xclick\">                                                                \n".
             "                 <input type=\"hidden\" name=\"bn\" value=\"wa_dw_2.0.4\">                                                        \n".
                  "                  <input type=\"hidden\" name=\"business\" value=\"".$this->paypal_email."\">                        \n".
                  "                 <input type=\"hidden\" name=\"receiver_email\" value=\"".$this->paypal_email."\">        \n".
                  "                 <input type=\"hidden\" name=\"amount\" value=\"".$paymentAmount."\">                        \n".
              "                 <input type=\"hidden\" name=\"currency_code\" value=\"".$this->currency."\">                        \n".
             "                 <input type=\"hidden\" name=\"return\" value=\"".$this->returnUrl."\">                                        \n".
             "                 <input type=\"hidden\" name=\"cancel_return\" value=\"".$this->failureUrl."\">                \n".
                  "                   <input type=\"hidden\" name=\"item_name\" value=\"".$this->description."\">\n".
                  "                 <input type=\"hidden\" name=\"undefined_quantity\" value=\"0\">                                        \n".
              "                 <input type=\"hidden\" name=\"no_shipping\" value=\"1\">                                                        \n".
                  "                 <input type=\"hidden\" name=\"no_note\" value=\"1\">                                                                        \n".
                  "                  <input type=\"hidden\" name=\"custom\" value=\"".$mTable."\">\n".
                  "                  <input type=\"hidden\" name=\"notify_url\" value=\"".$this->notifyUrl."\">                        \n".
             "                  ".
                  "                </td></form>\n".
                  "        </tr>\n".
                  "</table>";
    echo "<script>document.f1.submit();</script>";
}
  	
	

}
// END CI_Payment class

/* End of file Payment.php */
/* Location: ./application/libraries/Payment.php */
