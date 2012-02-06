<?php
class LinkshareApi {
	/**
	 * instance
	 * 
	 * @var mixed
	 * @access private
	 * @static
	 */
	private static $instance;
	/**
	 * advertiserSearchApi
	 * 
	 * (default value: "http://findadvertisers.linksynergy.com)
	 * 
	 * @var string
	 * @access public
	 */
	public $advertiserSearchApi = "http://findadvertisers.linksynergy.com/merchantsearch";
	/**
	 * appPrefix
	 * 
	 * (default value: "appsDown")
	 * 
	 * @var string
	 * @access public
	 */
	public $appPrefix = "appsDown";
	/**
	 * __construct function.
	 * 
	 * @access private
	 * @return void
	 */
	private function __construct() {
		// do nothing
	}
	
	/**
	 * getInstance function.
	 * 
	 * @access public
	 * @static
	 * @return void
	 */
	public static function getInstance() {
	
		if(!self::$instance)
			self::$instance = new LinkshareApi;
		
		return self::$instance;
	}
	
	/**
	 * getAllAdvertisers function.
	 * 
	 * @access public
	 * @param mixed $params (default: null)
	 * @return void
	 */
	public function getAllAdvertisers($params = null) {
	
		if(is_null($params))
			return false;
		
		$query_strings = $this->generate_query_strings($params);
		
		if($query_strings)
			$url = $this->advertiserSearchApi . $query_strings;
		else
			return false;
			
		$result = $this->do_request($url);
		
		if(!$result)
			return false;
		else {
			$object = $this->xml_to_object($result);
			
			if(!$object)
				return false;
			else
				return $object;
		}
	}
	
	public function generate_query_strings($params = null) {
		if(is_null($params) || !is_array($params))
			return false;
		
		if(is_array($params) && count($params) == 0)
			return false;
		
		$query_strings = "?";
		
		foreach($params as $key => $value) {
			$query_strings .= $key . "=" . $value;
		}
		
		return $query_strings;
	}
	
	public function xml_to_object($xml_string = null) {
		if(is_null($xml_string) || empty($xml_string))
			return false;
		
		$xml_object = simplexml_load_string( trim( $xml_string ) );
		
		if(!$xml_object)
			return false;
		else
			return $xml_object;
	}
	
	/**
	 * do_request function.
	 * 
	 * Create a cURL HTTP request and return output.
	 *
	 * @access public
	 * @param mixed $url (default: NUll)
	 * @return string
	 */
	function do_request($url = NULL) {
		if( is_null($url) || empty($url) )
			return false;
		
		$ch = curl_init();
		$timeout = 2;
		curl_setopt( $ch,CURLOPT_URL, $url );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch,CURLOPT_CONNECTTIMEOUT, $timeout );
		$data = curl_exec( $ch );
		curl_close( $ch );
		
		return $data;
	}
}