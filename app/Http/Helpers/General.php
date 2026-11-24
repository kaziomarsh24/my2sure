<?php

namespace App\Helpers;
use App\setting;

class General{ 

  // public function __construct()
  // {
  //   $this->ObjSettings = setting::get();
  // }

	public function getNewOrderId()
	{
		$newOrderId = $this->isPrefix().$this->RandomId();

		return $newOrderId;
	}

	public function RandomId()
    {
        return sprintf('%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }
    
    public static function generateOTP($length = 6)
    {
        return rand(str_pad("1", $length, "0", STR_PAD_RIGHT), str_pad("9", $length, "9", STR_PAD_RIGHT));
    }

    public function isPrefix()
    {
    	$prefix = "IH";
    	return $prefix;
    }

    /**
     * This function unformats a number and returns them in plain eng format
     *
     * @param int $input_number
     *
     * @return float
     */
    public function num_uf($input_number, $currency_details = null)
    {
        $thousand_separator  = '';
        $decimal_separator  = '';

        if (!empty($currency_details)) {
            $thousand_separator = $currency_details->thousand_separator;
            $decimal_separator = $currency_details->decimal_separator;
        }

        $num = str_replace($thousand_separator, '', $input_number);
        $num = str_replace($decimal_separator, '.', $num);

        return (float)$num;
    }

    /**
    * Calculates percentage for a given number
    *
    * @param int $number
    * @param int $percent
    * @param int $addition default = 0
    *
    * @return float
    */
    public function calc_percentage($number, $percent, $addition = 0)
    {
        return ($addition + ($number * ($percent / 100)));
    }

     /**
     * Calculates base value on which percentage is calculated
     *
     * @param int $number
     * @param int $percent
     *
     * @return float
     */
    public function calc_percentage_base($number, $percent)
    {
        return ($number * 100) / (100 + $percent);
    }

    /**
     * Calculates percentage
     *
     * @param int $base
     * @param int $number
     *
     * @return float
     */
    public function get_percent($base, $number)
    {
        $diff = $number - $base;
        return ($diff / $base) * 100;
    }

    /**
     * Generates unique token
     *
     * @param void
     *
     * @return string
     */
    public function generateToken()
    {
        return md5(rand(1, 10) . microtime());
    }

    public function generatePin()
    {
        $pin =rand(1, 10).rand(10, 20).rand(20, 30); //5 digits pin
        return $pin;
    }

    /**
     * Payment Methods
     *
     * @param void
     *
     * @return string
     */
    public function isPaymentMethodExist($paymentMethod)
    {
    	$Methods = [
    		"cc" , "cod" , "jc", "ep", "wallet"
    	];

    	if(in_array($paymentMethod, $Methods))
    	{
    		return true;
    	}

		return false;
    }

    /**
    * Retrieves IP address of the user
    *
    * @return string
    */
    public function getUserIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
    public static function getPlatform()
    {
        $iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
        $iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
        $iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
        $Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
        $webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");
        $Windows = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");
        if($iPod || $iPhone || $iPad)
            return "iOS";
        elseif($Android)
            return "Android";
        elseif($webOS)
            return "webOS";
        elseif($Windows)
            return "Windows";
        else
            return "Other";
    }


 
 

 
}