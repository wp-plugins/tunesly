<?php

/**
 * send_http_request function.
 * 
 * Parses output of the page or throw an error 500 when request fails.
 *
 * @access public
 * @return void
 */
function send_http_request()
{
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch,CURLOPT_URL,$_GET['url']);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	

	if(strlen($data) > 0 && preg_match("/RD_PARM1/", $data)) {
		$resultArray = explode( "RD_PARM1=", $data );
		echo $resultArray[0]."RD_PARM1=";
	} else {
		header("HTTP/1.1 500 Internal Server Error");
	}
}

send_http_request();