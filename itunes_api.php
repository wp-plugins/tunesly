<?php
/**
 * iTunesAppStore class.
 */
class iTunesAppStore {
	/**
	 * iTunes_search_url
	 *
	 * iTunes API Search URL from Apple.
	 * 
	 * (default value: "http://ax.itunes.apple.com/WebObjects/MZStoreServices.woa/wa/wsSearch?")
	 * 
	 * @var string
	 * @access public
	 */
	public $iTunes_search_url = "http://ax.itunes.apple.com/WebObjects/MZStoreServices.woa/wa/wsSearch?";
	/**
	 * iTunes_rss_url
	 *
	 * iTunes Store RSS link.
	 * 
	 * (default value: "http://itunes.apple.com/us/rss/")
	 * 
	 * @var string
	 * @access public
	 */
	public $iTunes_rss_url = "http://itunes.apple.com/";
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
	 * generate_query_string function.
	 * 
	 * @access public
	 * @param mixed $params
	 * @param string $source
	 * @return void
	 */
	function generate_query_string($params, $source = NULL) {
		if( !is_array($params) || count($params) == 0 || is_null($source)  || empty($source) )
			return false;
		
		$query_string = "";
		$param_count = count($params);
		$i = 0;
		
		foreach($params as $field => $value) {
			if( $source == "rss" )
				$query_string .= $value;
			else
				$query_string .= $field."=".$value;
			
			if( ($i + 1) < $param_count)
				if( $source == "rss" )
					$query_string .= "/";
				else
					$query_string .= "&";
			
			$i++;
		}
		
		return $query_string;
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
	
	/**
	 * search_apps function.
	 * 
	 * @access public
	 * @param mixed $keyword (default: NULL)
	 * @param int $limit (default: 10)
	 * @return string query strings
	 */
	function search_apps($source = "rss", $qsa = NULL) {
		if( is_null($qsa) )
			return false;	
		$transient_name = str_replace( array( "/", "=" ), array( "_", ":" ), implode("_", $qsa) );
		$transient_result = get_transient( $transient_name );
		
		if( $transient_result === false ) {	
			$url = ($source == "rss") ? $this->iTunes_rss_url : $this->iTunes_search_url;
			$url .= $this->generate_query_string( $qsa, $source );
			$result = $this->do_request( $url );
			
			set_transient( $transient_name, $result, 60*60*24 );
		} else {
			$result = $transient_result;
		}
		
		if( $source == "rss" )
			return simplexml_load_string( $result );
		else
			return json_decode( $result );
	}
}