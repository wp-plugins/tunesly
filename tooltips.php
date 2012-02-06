<?php
$tooltip = strip_tags( trim( $_GET['field'] ) );

switch($tooltip) {
	case "Tunesly_store_country":
		$content = '<p>Default iTunes Store country used if no country is defined in widget or shortcode settings.</p>';
		break;
	case "Tunesly_store_result_item":
		$content = '<p>This is the default number of search results to be displayed used in the shortcode output.</p>';
		break;
	case "Tunesly_result_rows":
		$content = '<p>Number of rows the search results will grouped into when row parameter is not defined in the shortcode.</p>';
		break;	
	case "Tunesly_result_column":
		$content = '<p>Number of columns the search results will grouped into when column parameter is not defined in the shortcode.</p>';
		break;
	case "Tunesly_result_label":
		$content = '<p>The header title will use Post Title if default setting is blank.</p>';
		break;
	case "Tunesly_linkshare_token":
		$content = '<p>The Web Services token is used to identify you and validate your feed request in Linkshare.</p>';
		break;
	case "Tunesly_linkshare_generate_timeout":
		$content = '<p>The timeout used when requesting for Linkshare links. This defaults to 2 seconds. Take note that setting this to a higher number will slow down your site if ever there\'s a connection issue with Linkshare.</p>';
		break;
	case "Tunesly_linkshare_advertiser_id":
		$content = '<p>This is the iTunes Advertiser ID. You can find this by logging in to your account and going to the following link: <em>Programs</em> -&gt; <em>My Advertisers</em>. Hover your mouse to iTunes link to show the Advertiser ID.</p>';
		break;
	case "Tunesly_ipinfodb_key":
		$content = '<p>The token is used to validate your geo-location request to IPInfoDB. This generated upon completing the registration process.</p>';
		break;
	default:
		$content = '';
}

echo $content;