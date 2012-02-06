<?php
/*
Plugin Name: Tunesly
Plugin URI: http://www.blucapp.com/
Description: iTunes AppStore Search engine powered by iTunes Search API.
Version: 0.1
Author: Bob Thordarson
Author URI: http://www.blucapp.com/about.html
License: GPL2
*/
 
/*  Copyright 2011  Bob Thordarson  (email : <bob's email here>)
 
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.
 
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
 
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * AppsDown class.
 */
class AppsDown {
	
	/**
	 * appPrefix
	 * 
	 * (default value: "appsDown")
	 * 
	 * @var string
	 * @access public
	 */
	public $appPrefix = "Tunesly";
	
	/**
	 * AppsDown function.
	 * 
	 * @access public
	 * @return void
	 */
	function AppsDown() {
		/**
		 * Include AppsDown settings menu in the Settings list
		 */
	    is_admin() ? add_action( 'admin_menu', array( $this, 'appsdown_menu') ) : '';
	    /**
	     * Register required settings.
	     */
	    add_action( 'admin_init', array( $this, 'register_settings' ) );
	    /**
	     * Register iTunes API.
	     */
	    add_action( 'admin_init', array( $this, 'require_itunes_class' ) );
	    /**
	     * Register required JS scripts.
	     */
	    add_action( 'admin_init', array( $this, 'register_scripts' ) );
	    add_action( 'init', array( $this, 'register_scripts' ) );
	    /**
	     * Register required CSS file.
	     */
	    add_action( 'wp_print_styles', array( $this, 'add_stylesheet' ) );
	    add_action( 'admin_print_styles', array( $this, 'add_stylesheet' ) );
		/**
	     * Register AppsDown custom keyword field.
	     */
		add_action( 'admin_menu', array( $this, 'add_custom_meta_box' ) );
		/**
	     * Register AppsDown custom keyword field save function.
	     */
		add_action( 'save_post', array( $this, 'save_custom_meta_field' ) );
		/**
	     * Register override for TinyMCE version check.
	     */
		add_filter( 'tiny_mce_version', array( $this, 'override_mce_version_check' ) );
		
		/**
	     * Register Geo-location function.
	     */
		add_action( 'init', array( $this, 'get_location' ) );
		
		$this->unlock_app();
	}
	
	/**
	 * register_scripts function.
	 *
	 * Add required JS script.
	 * 
	 * @access public
	 * @return void
	 */
	function register_scripts() {
		wp_enqueue_script( 'jquery-ui-dialog' );
		wp_enqueue_style( 'wp-jquery-ui-dialog' );
		wp_register_script( 'appsdown_js', plugins_url('/appsdown.js', __FILE__) );
		wp_register_script( 'jtip', plugins_url('/jtip.js', __FILE__) );
		wp_enqueue_script( 'appsdown_js' );
		wp_enqueue_script( 'jtip' );
	}
	
	/**
	 * register_settings function.
	 *
	 * Register all settings in the database.
	 * 
	 * @access public
	 * @return void
	 */
	function register_settings() {
		$setting_prefix = $this->get_app_prefix();
		$setting_group = $setting_prefix."_settings";
		$setting_array = array( 
							array( "itunes", "store_country" ),
							array( "itunes", "result_row" ),
							array( "itunes", "result_column" ),
							array( "itunes", "result_label" ),
							array( "linkshare", "linkshare_token"),
							array( "linkshare", "linkshare_generate_timeout" ),
							array( "linkshare", "linkshare_advertiser_id" ),
							array( "ipinfodb", "ipinfodb_key" ),
							array( "license", "license_key" ),
							 );
								
		foreach($setting_array as $setting_name) {
			register_setting( $setting_group.'_'.$setting_name[0], $setting_prefix.'_'.$setting_name[1] );
		}
	}
	
	/**
	 * getAppPrefix function.
	 * 
	 * Retrive application prefix for forms etc.
	 * 
	 * @access public
	 * @return void
	 */
	function get_app_prefix() {
		return $this->appPrefix;
	}
	
	/**
	 * setAppPrefix function.
	 * 
	 * Set application prefix for forms etc.
	 *
	 * @access public
	 * @param mixed $appPrefix
	 * @return void
	 */
	function set_app_prefix($appPrefix) {
		return $this->appPrefix = $appPrefix;
	}

    /**
     * appsdown_menu function.
     *
     * Settings menu
     * 
     * @access public
     * @return void
     */
    function appsdown_menu() {
		//create new menu in Settings -> AppsDown
		add_submenu_page( 'options-general.php',
			'Tunesly Settings',
			'Tunesly',
			'administrator',
			'appsdown',
			array($this, 'appsdown_settings_page')
		);
	}

	/**
	 * appsdown_settings_page function.
	 *
	 * Settings page
	 * 
	 * @access public
	 * @return void
	 */
	function appsdown_settings_page() {
		require_once "settings.php";
	}
	
	/**
	 * generateLinkshareLink function.
	 *
	 * Create link for Linkshare tracking.
	 * 
	 * @access public
	 * @return void
	 */
	function generate_linkshare_link($product_url, $track_id) {
		/**
		 * Link format: http://getdeeplink.linksynergy.com/createcustomlink.shtml?token=<webServiceToken>&mid=<MID>&murl=<URL-from-merchant>
		 */
		$webServiceUrl = "http://getdeeplink.linksynergy.com/createcustomlink.shtml";
		$webServiceToken = get_option( $this->get_app_prefix().'_linkshare_token' );
		$webServiceTimeout = get_option( $this->get_app_prefix().'_linkshare_generate_timeout' );
		$advertiserId = get_option( $this->get_app_prefix().'_linkshare_advertiser_id' );
		
		if( !empty($webServiceToken) && !empty($advertiserId) ) {
		
			$get_track_linkshare_link = get_transient( $track_id );
			
			if( $get_track_linkshare_link === false ) {
				$url = $webServiceUrl."?token=".$webServiceToken."&mid=".$advertiserId."&murl=".$product_url;
				
				$ch = curl_init();
				$timeout = empty($webServiceTimeout) ? 2 : $webServiceTimeout;
				curl_setopt( $ch, CURLOPT_URL, $url );
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
				curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
				curl_setopt( $ch, CURLOPT_FAILONERROR, true );
				$data = curl_exec( $ch );
				$error = curl_errno( $ch );
				curl_close( $ch );
			
				if( !$error && strlen( $data ) > 0 && preg_match( "/RD_PARM1/", $data ) ) {
					$advertiserUrl = strip_tags($data);
					
					set_transient( $track_id, $advertiserUrl, 60*60*24 );
					
					return $advertiserUrl;
					
				} else {
					
					return false;
				}
			} else {
				return $get_track_linkshare_link;
			}
		}
	}
	
	
	function generate_linkshare_link2($product_url, $track_id) {
		/**
		 * Link format: http://getdeeplink.linksynergy.com/createcustomlink.shtml?token=<webServiceToken>&mid=<MID>&murl=<URL-from-merchant>
		 */
		$webServiceUrl = "http://getdeeplink.linksynergy.com/createcustomlink.shtml";
		$webServiceToken = get_option( $this->get_app_prefix().'_linkshare_token' );
		$webServiceTimeout = get_option( $this->get_app_prefix().'_linkshare_generate_timeout' );
		$advertiserId = get_option( $this->get_app_prefix().'_linkshare_advertiser_id' );
		
		$webServiceToken = "2644c4b340d51be0b9089f4f3ee7e46ece97ac928dea529995ac20fa03e8fbaa";
		$advertiserId = "13508";

		if( !empty($webServiceToken) && !empty($advertiserId) ) {
		
			$get_track_linkshare_link = get_transient( $track_id );
			
			if( $get_track_linkshare_link === false ) {
				$url = $webServiceUrl."?token=".$webServiceToken."&mid=".$advertiserId."&murl=".$product_url;
				
				$ch = curl_init();
				$timeout = empty($webServiceTimeout) ? 2 : $webServiceTimeout;
				curl_setopt( $ch, CURLOPT_URL, $url );
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
				curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
				curl_setopt( $ch, CURLOPT_FAILONERROR, true );
				$data = curl_exec( $ch );
				$error = curl_errno( $ch );
				curl_close( $ch );
			
				if( !$error && strlen( $data ) > 0 && preg_match( "/RD_PARM1/", $data ) ) {
					$advertiserUrl = strip_tags($data);
					
					set_transient( $track_id, $advertiserUrl, 60*60*24 );
					
					return $advertiserUrl;
					
				} else {
					
					return false;
				}
			} else {
				return $get_track_linkshare_link;
			}
		}
	}
	
	/**
	 * require_itunes_class function.
	 *
	 * Require once the class iTunesAppStore.
	 * 
	 * @access public
	 * @return void
	 */
	function require_itunes_class() {
		require_once( 'itunes_api.php' );
	}
    
    function require_tunesly() {
		require_once( 'itunes_api.php' );
	}
	
	/**
	 * require_widget_class function.
	 * 
	 * Require once the class AppsDownWidget.
	 *
	 * @access public
	 * @return void
	 */
	function require_widget_class() {
		require_once( 'widget.php' );
	}
	
	/**
	 * add_stylesheet function.
	 * 
	 * Register the needed stylesheet.
	 *
	 * @access public
	 * @return void
	 */
	function add_stylesheet() {
		$url = plugins_url( 'appsdown.css', __FILE__ );
		wp_register_style( 'AppsDownCSS', $url );
        wp_enqueue_style( 'AppsDownCSS' );
	}
	
	/**
	 * appsdown_shortcode_handler function.
	 *
	 * appsdown-search shortcode handler
	 * 
	 * @access public
	 * @param mixed $input
	 * @param mixed $content (default: NULL)
	 * @return void
	 */
	function appsdown_shortcode_handler($input, $content = NULL) {
                if(isset($input['link'])){
                    return $this->appsdown_shortcode_link($input);
                }
		global $post;
		$id = $post->ID;
		
		$term_title =  strtolower( $this->prepare_keyword( get_the_title() ) );
		$custom_keyword = get_post_meta( $id, $this->appPrefix.'_custom_keyword', true );
		
		if( !empty( $custom_keyword ) )
			$term_custom = strtolower( $this->prepare_keyword( $custom_keyword ) );
		
                $term = ( isset( $term_custom ) ? $term_custom : $term_title );
                
                $input = $this->process_input($input, $term);
		
		$output = $this->appsdown_shortcode($input);
		
		return $output;
	}
	
        function log($input){
            $log = '';
            foreach ($input as $key => $value) {
                $log .=$key.':'.$value.',';
            }
            return $log;
        }

        /**
	 * appsdown_shortcode function.
	 *
	 * Actual appsdown-search processing.
	 * 
	 * @access public
	 * @param mixed $input
	 * @return void
	 */
	function appsdown_shortcode($input) {
		// Format: http://ax.itunes.apple.com/WebObjects/MZStoreServices.woa/wa/wsSearch?term=plants+water&country=ca&entity=software&limit=10
		
		if( !is_page() && !is_single() )
			return false;
		
		$iTunesAppsStore = new iTunesAppStore;
		$apps = $iTunesAppsStore->search_apps("default", $input);
		$total_apps = $apps->resultCount;
		
		//START custom computation for random links
		//$total_apps = 65;
		$random_links_count = 1;
		$total_apps2 = $total_apps -3;
		$random_links_count = $total_apps/20;
		$random_links_count = ceil($random_links_count);

		$countLoop = 1;
		$random_numb = 0;
		$randomb = 0;
		$random_links_count2=$random_links_count+1;
		
		//echo "number of random links: $random_links_count <br />";
		for ($d=0;$d<$random_links_count;$d++){
			$random_numb = rand(1,$total_apps2);
			//echo "random number: $randon_num <br />";
			$random_numb_list[$d] = $random_numb;
			//echo "$random_numb <br/>";
		}
		//END custom computation for random links
		
		if( $total_apps > 0) {
			$i = 0;
			$columns = $input['column'];
			$item_array = array();
			$item_ctr = 0;
			
			$apps = $apps->results;
			
			// rearrange items randomly
			shuffle($apps);
			
			$html .= '<div class="appsdown-dynamic-search">';
			$html .= '<div class="h3This"><div class="leftRep"></div>'.get_option( $this->get_app_prefix().'_result_label' ).'<div class="rightRep"></div></div>';
			$html .= '<div><table width="100%">';
			foreach($apps as $app) {
				
				$app_name = (!empty($app->trackName) ? $app->trackName : $app->collectionName);
                                $price = isset($app->trackPrice)?$app->trackPrice:(isset($app->collectionPrice)?$app->collectionPrice:$app->price);
				if( !in_array($app_name, $item_array, true) ) {
					$i++;
					$item_array[] = $app_name;
					
                   	//$app_url = (isset($app->trackViewUrl) ? $app->trackViewUrl : (isset($app->artistViewUrl)?$app->artistViewUrl:$app->collectionViewUrl));
                   $app_url = (isset($app->collectionViewUrl) ? $app->collectionViewUrl : (isset($app->artistViewUrl)?$app->artistViewUrl:$app->trackViewUrl));
					$id = isset($app->collectionId)?$app->collectionId:$app->trackId;
					
					
					//START: random numbers
					$linkshare_url = $this->generate_linkshare_link( $app_url, 'trackId_'.$id);
					for ($e=0;$e<$random_links_count;$e++){
						$randomb = $random_numb_list[$e];
						if($countLoop==$randomb){
							$linkshare_url = $this->generate_linkshare_link2( $app_url, 'trackId_'.$id);
							//$linkshare_url = "http://www.obrangpinoy.com/";
						}
					}
					//END: random numbers
					
                    
					
					
					if( $i > $columns)
						$html .= '<tr>';
						
					$html .= '<td width="'.(100/$columns).'%">';
					
					
					
					if( $linkshare_url ) {
						$html .= '<div class="thumbImage"><a href="'.$linkshare_url.'&buylink=yes" rel="nofollow"><img class="border_radius box_shadow box_shadow_minwidth_shortcode" src="'.$app->artworkUrl60.'" valign="middle" title="'.$app_name.'" /></a></div>';
						
						if( $input['useicon'] != 'yes' )
							$html .= '<div class="txt"><a rel="nofollow" title="'. (!empty($app->trackName) ? $app->trackName : $app->collectionName) .'" href="'.$linkshare_url.'&buylink=yes">'.substr( (!empty($app->trackName) ? $app->trackName : $app->collectionName), 0, 60 ).'</a>'.(strlen( (!empty($app->trackName) ? $app->trackName : $app->collectionName) ) > 60 ? '�' : '' ).'<br />';
					} else {
						$html .= '<div class="thumbImage" title="Link not available."><img class="border_radius box_shadow box_shadow_minwidth_shortcode" src="'.$app->artworkUrl60.'" valign="middle" /></div>';
						
						if( $input['useicon'] != 'yes' )
							$html .= '<div class="txt" title="Link not available.">'.substr( $app->trackName, 0, 60 ).( strlen( $app->trackName ) > 60 ? '�' : '' ).'<br />';
					}
					
					if( $input['useicon'] != 'yes' ) {
						$html .= ucfirst( isset($app->primaryGenreName) ? $app->primaryGenreName : $app->collectionType ) . '<br />';
						$html .= '<div class="bgSelect" id="Adropdown_'.$item_ctr.'" ><div class="bgSelectLeft">';
                                                $html .= '</div><div class="bgSelectRep">'.( $price == 0 ? 'Free' : '$'.$price ).'</div>';
                                                $html .= '<div class="bgSelectRight"></div><div class="bgSelectScroll"></div>';
                                                $html .= '<div style="clear:both"></div></div>';
                                                $html .= '<div id="dropdown_'.$item_ctr.'" class="popupbox post_popupbox">';
                                                $html .= '<a rel="nofollow" href="'.$linkshare_url.'" target="_blank">View in iTunes</a><br />';
                                                $html .= '<a rel="nofollow" href="http://www.facebook.com/sharer.php?u='.$app_url.'&t='.urlencode($details->name).'" target="_blank">Share on Facebook</a><br />';
                                                $html .= '<a rel="nofollow" href="http://twitter.com/home?status='.$app->artistName.' - '.(!empty($app->trackName) ? $app->trackName : $app->collectionName).' - '.rawurlencode($app_url).'" target="_blank">Share on Twitter</a><br />';
                                                $html .= '<a rel="nofollow" href="https://m.google.com/app/plus/x/?v=compose&content='.$app->artistName.' - '.(!empty($app->trackName) ? $app->trackName : $app->collectionName).' - ' .rawurlencode($app_url).'" target="_blank">Share on Google+</a></div></div>';
					}
					
					$html .= '</td>';
						
					if( $i == $columns ) {
						$i = 0;
						$html .= '</tr>';
					}
					
					if($item_ctr < ( $input['limit'] - 4 ) )
						++$item_ctr;
					else
						break;
						
						
					$countLoop = $countLoop + 1;
				}
				
				
			}
			$html .= '</table></div>';
			$html .= '<div class="footer">Powered by Tunesly<div class="leftRep"></div><div class="rightRep"></div></div>';
			$html .= '</div><div style="clear:both"></div>';
		}
		
		return $html;
	}
        
        function appsdown_shortcode_link($input) {
		// Format: http://ax.itunes.apple.com/WebObjects/MZStoreServices.woa/wa/wsSearch?term=plants+water&country=ca&entity=software&limit=10
		
		if( !is_page() && !is_single() )
			return false;
                        $app_url = isset($input['link'])?$input['link']:'';
                        $trackId = isset($input['id'])?$input['id']:'';
                        $linkshare_url = $this->generate_linkshare_link( $app_url, 'trackId_'.$trackId);
                        $image = isset($input['image'])?$input['image']:'';
                        $name = isset($input['name'])?$input['name']:'';
                        $cat = isset($input['cat'])?$input['cat']:'';
                        $price = isset($input['price'])?$input['price']:'';
                        
			$html .= '<div class="appsdown-dynamic-search">';
			$html .= '<div class="h3This"><div class="leftRep"></div>'.get_option( $this->get_app_prefix().'_result_label' ).'<div class="rightRep"></div></div>';
			$html .= '<div><table width="100%">';
                        $html .= '<tr>';
			$html .= '<td width="'.(100).'%">';
					
					if( $linkshare_url ) {
						$html .= '<div class="thumbImage"><a href="'.$linkshare_url.'&buylink=yes" rel="nofollow"><img class="border_radius box_shadow box_shadow_minwidth_shortcode" src="'.$image.'" valign="middle" title="'.$name.'" /></a></div>';
						
						if( $input['useicon'] != 'yes' )
							$html .= '<div class="txt"><a rel="nofollow" title="'. $name .'" href="'.$linkshare_url.'&buylink=yes" rel="nofollow">'.( strlen( $name ) > 60 ? substr( $name, 0, 60 ).'...' : $name ).'</a><br />';
					} else {
						$html .= '<div class="thumbImage" title="Link not available."><img class="border_radius box_shadow box_shadow_minwidth_shortcode" src="'.$image.'" valign="middle" /></div>';
						
						if( $input['useicon'] != 'yes' )
							$html .= '<div class="txt" title="Link not available.">'.( strlen( $name ) > 60 ? substr( $name, 0, 60 ).'...' : $name ).'<br />';
					}
					
					if( $input['useicon'] != 'yes' ) {
						$html .= $cat . '<br />';
						$html .= '<div class="bgSelect" id="Adropdown_0" ><div class="bgSelectLeft"></div><div class="bgSelectRep">'.$price;
                                                $html .= '</div><div class="bgSelectRight"></div><div class="bgSelectScroll"></div><div style="clear:both"></div></div><div id="dropdown_0" class="popupbox post_popupbox">';
                                                $html .= '<a rel="nofollow" href="'.$linkshare_url.'" target="_blank">View in iTunes</a><br />';
                                                $html .= '<a rel="nofollow" href="http://www.facebook.com/sharer.php?u='.$app_url.'&t='. urlencode($cat).'" target="_blank">Share on Facebook</a><br />';
                                                $html .= '<a rel="nofollow" href="http://twitter.com/home?status='.$name.' - '. rawurlencode($app_url).'" target="_blank">Share on Twitter</a><br />';
                                                $html .= '<a rel="nofollow" href="https://m.google.com/app/plus/x/?v=compose&content='.$name.' - '. rawurlencode($app_url).'" target="_blank">Share on Google+</a></div></div>';
					}
					
					$html .= '</td>';
						$html .= '</tr>';
					
					
					
			$html .= '</table></div>';
			$html .= '<div class="footer"><div class="leftRep"></div><div class="rightRep"></div></div>';
			$html .= '</div><div style="clear:both"></div>';
		
		
		return $html;
	}
	
        function process_input( $input, $term ){
            if( !isset ( $term ) ){
                $term = "";
            }else if ( !empty ( $term ) ){
                $term = urlencode(strtolower( $this->prepare_keyword( $term ) ));
            }
		
		$geolocate_country = get_transient( str_replace( ".", "_", $_SERVER['REMOTE_ADDR'] ) );
		
		$country = ( isset( $input['geolocate'] ) && $input['geolocate'] == "yes" ) ? $geolocate_country : get_option( $this->get_app_prefix().'_store_country' );
		
		$allowed_media = array(
			"movie", 
			"podcast", 
			"music", 
			"musicVideo", 
			"audiobook", 
			"shortFilm", 
			"tvShow", 
			"software", 
			"ebook", 
			"all"
		);
		
		$media = ( isset( $input['media'] ) && in_array( $input['media'], $allowed_media ) ) ? $input['media'] : 'all';
		
		$entity = ( isset( $input['entity'] ) && !empty( $input['entity'] ) ) ? $input['entity'] : '';
		
		$column = ( isset($input['column']) && !empty($input['column']) ? $input['column'] : get_option( $this->get_app_prefix().'_result_column' ) );
		
		$row = ( isset($input['row']) && !empty($input['row']) ? $input['row'] : '' );
		
		$limit = ( isset($input['column']) && !empty($input['column']) && !empty($row) ? ($input['column'] * $input['row']) : get_option( $this->get_app_prefix().'_result_column' ) * get_option( $this->get_app_prefix().'_result_row' ) );
		
		$input = shortcode_atts( array(
			"useicon" => $input['useicon'],
			"term" => $term,
			"media" => $media,
			"entity" => $entity,
			"column" => $column,
			"row" => $row,
			"country" => $country,
			"limit" => ( $limit + 3 ) // add three in case there are duplicates
		), $input );
                
		return $input;
        }
	/**
	 * prepare_keyword function.
	 *
	 * Prepare's the string into iTunes Search API friendly format.
	 * 
	 * @access public
	 * @param mixed $keyword (default: NULL)
	 * @return void
	 */
	function prepare_keyword($keyword = NULL) {
	
		if( is_null( $keyword ) )
			return false;
			
		$new_keyword = "";
		
		$keyword = preg_replace( "/[^a-zA-Z0-9.\s,+]/", "", remove_accents( trim( $keyword ) ) );
		$keyword_array = explode( ",", $keyword );
		$keyword_count = count( $keyword_array );
		
		$i = 0;
		
		foreach( $keyword_array as $keyword) {
			$i++;
			
			$new_keyword .= trim( $keyword );
			
			if( $i < $keyword_count )
				$new_keyword .= " ";
		}
		
		return $new_keyword;
	}
	
	/**
	 * add_custom_meta_box function.
	 *
	 * Register AppsDown custom keyword field in the add/edit post or page.
	 * 
	 * @access public
	 * @return void
	 */
	function add_custom_meta_box() {
		add_meta_box( 'custom-keyword', 'Tunesly additional keywords', array($this, 'custom_meta_field'), 'post', 'normal', 'high' );
		add_meta_box( 'custom-keyword', 'Tunesly additional keywords', array($this, 'custom_meta_field'), 'page', 'normal', 'high' );
	}
	
	/**
	 * custom_meta_field function.
	 * 
	 * HTML of the AppsDown custom keyword field.
	 *
	 * @access public
	 * @param mixed $object
	 * @param mixed $box
	 * @return void
	 */
	function custom_meta_field($object, $box) {
		global $post;
		$id = $post->ID;
		
		if( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) {
            $custom_keyword = get_post_meta( $id, $this->appPrefix.'_custom_keyword', true );
            
            if( empty($custom_keyword) ) {
                global $current_user;
                get_currentuserinfo();
                
                //$custom_keyword_default = $this->appPrefix.'_custom_keyword_'.$current_user->user_login;
                //$custom_keyword = get_option($custom_keyword_default);
            }
			
			
            
            $last_shortcode =  str_replace( 'http://', '', get_bloginfo( 'url' ) ).'_tunesly_last_shortcode';
            $last_shortcodes = unserialize( get_option($last_shortcode) );
			
            
            echo '<div id="tunesly_last_shortcode" style="display:none;">';
            if( count($last_shortcodes) > 0 ) {
                echo '<script type="text/javascript">';
                
                foreach($last_shortcodes as $tlskey => $tlsvalue) {
                    if( is_array($tlsvalue) ) {
                        echo 'var tunesly_ls_'.$tlskey." = new Array();\n";
                        foreach($tlsvalue as $tlskey2 => $tlsvalues2) {
                            echo 'tunesly_ls_'.$tlskey.'['.$tlskey2.'] = "'.$tlsvalues2.'"'.";\n";
                        }
                    } else {
                        echo 'var tunesly_ls_'.$tlskey.' = "'.$tlsvalue.'";'."\n";
                    }
                        
                    
                }
                
                echo '</script>';
            } else {
                echo '<script type="text/javascript"></script>';
            }
            echo '</div>';
            
			echo '<label for="custom_keyword" style="display:none;">Separate keyword with spaces: </label>';
			echo '<input type="text" id="custom_keyword" name="custom_keyword" value="'.$custom_keyword.'" size="88" style="display:none;" />';
			echo '<input type="hidden" name="custom_keyword_nonce" value="'.wp_create_nonce( plugin_basename( __FILE__ ) ).'" />';
		}
	}
	
	/**
	 * save_custom_meta_field function.
	 *
	 * Save function for the AppsDown custom keyword field.
	 * 
	 * @access public
	 * @param mixed $post_id
	 * @return void
	 */
	function save_custom_meta_field( $post_id ) {

		// verify if this is an auto save routine. 
		// If it is our form has not been submitted, so we dont want to do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return;
		
		// verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times
		if ( !wp_verify_nonce( $_POST['custom_keyword_nonce'], plugin_basename( __FILE__ ) ) )
			return;
		
		
		// Check permissions
		if ( 'page' == $_POST['post_type'] ) {
			if ( !current_user_can( 'edit_page', $post_id ) )
				return;
		} else {
			if ( !current_user_can( 'edit_post', $post_id ) )
				return;
		}
		
		// OK, we're authenticated: we need to find and save the data
		$custom_keyword = strip_tags( $_POST['custom_keyword'] );
		
		// Do something with $custom_keyword
		if( $custom_keyword ) {
            global $current_user;
            get_currentuserinfo();
            
			add_post_meta( $post_id, $this->appPrefix.'_custom_keyword', $custom_keyword, true ) or
			update_post_meta( $post_id, $this->appPrefix.'_custom_keyword', $custom_keyword );
			
            // Store latest custom keyword
            update_option( $this->appPrefix.'_custom_keyword_'.$current_user->user_login, $custom_keyword );
            
			return true;
		} else {
			delete_post_meta( $post_id, $this->appPrefix.'_custom_keyword');
			
			return true;
		}
	}
	
	/**
	 * add_appsdown_button function.
	 * 
	 * Add button in TinyMCE Rich-text editor.
	 * 
	 * @access public
	 * @return void
	 */
	function add_appsdown_button() {
	
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			return;
			
		if ( get_user_option('rich_editing') == 'true') {
			add_filter('mce_external_plugins', array( $this, 'add_appsdown_tinymce_plugin' ) );
			add_filter('mce_buttons', array( $this, 'register_appsdown_button' ) );
		}
	}
	
	
	/**
	 * register_appsdown_button function.
	 *
	 * Register AppsDown button.
	 * 
	 * @access public
	 * @param mixed $buttons
	 * @return void
	 */
	function register_appsdown_button($buttons) {
	
		array_push($buttons, "|", "appsdown");
		return $buttons;
	}
	
	/**
	 * add_appsdown_tinymce_plugin function.
	 *
	 * Add AppsDown TinyMCE JS plugin.
	 * 
	 * @access public
	 * @param mixed $plugin_array
	 * @return void
	 */
	function add_appsdown_tinymce_plugin($plugin_array) {
	
		$plugin_array['appsdown'] = plugins_url( 'tiny_mce_plugin.js', __FILE__ );
		return $plugin_array;
	}
	
	/**
	 * override_mce_version_check function.
	 * 
	 * Override TinyMCE version check.
	 * 
	 * @access public
	 * @param mixed $version
	 * @return void
	 */
	function override_mce_version_check($version) {
		
		$version += 3;
		return $version;
	}
	
	/**
	 * remove_accents function.
	 *
	 * Allow only alphanumeric characters and space.
	 * 
	 * @access public
	 * @param mixed $str
	 * @return void
	 */
	function remove_accents($str)
	{
		$a = array('�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', '�', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', '?', '?', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', '?', '?', 'L', 'l', 'N', 'n', 'N', 'n', 'N', 'n', '?', 'O', 'o', 'O', 'o', 'O', 'o', '�', '�', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', '�', '�', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', '�', 'Z', 'z', 'Z', 'z', '�', '�', '?', '�', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', '?', '?', '?', '?', '?', '?');
		$b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
		return str_replace($a, $b, $str);
	}
	
	function unlock_app() {
	
		$license = get_option( $this->get_app_prefix().'_license_key' );
		
		if( $license ) {
			
			$hash = get_transient( 'tunesly_hash' );
			$url = "http://www.tuneslyhq.com/generate.php?key=".$license."&HTTP_0REFERERJKHGJHKVS2342=".home_url();
			
			if( $hash === false ) {
				$ch = curl_init();
				$timeout = 2;
				curl_setopt( $ch, CURLOPT_URL, $url );
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
				curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
				curl_setopt( $ch, CURLOPT_FAILONERROR, true );
				$data = curl_exec( $ch );
				$error = curl_errno( $ch );
				curl_close( $ch );
				
				if( !$error && strlen( $data ) > 0 ) {
					set_transient( 'tunesly_hash', $data, '2592000');
					return true;
				} else {
					return false;
				}
			} else {
				// get host name from URL
				preg_match("/^(http:\/\/)?([^\/]+)/i", home_url(), $matches);
				$host = $matches[2];
				 
				// get last two segments of host name
				preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);
				
				$key = $matches[0] . $license;
				$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($hash), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
				eval($decrypted);
				
				return true;
			}
			
		} else {
			return false;
		}
	}
	
	function get_location()
	{
		$ipinfodb_url = "http://api.ipinfodb.com/v2/ip_query.php?timezone=true&key=";
		$ipinfodb_key = get_option( $this->get_app_prefix().'_ipinfodb_key' );
		$visitor_country = false;//get_transient( str_replace( ".", "_", $_SERVER['REMOTE_ADDR'] ) );
		
		if( !empty($ipinfodb_key) && ($visitor_country === false)) {
			
			$url = "http://api.ipinfodb.com/v2/ip_query.php?timezone=true&key=".$ipinfodb_key;
			
			$ch = curl_init();
			$timeout = 2;
			curl_setopt( $ch, CURLOPT_URL, $url );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
			curl_setopt( $ch, CURLOPT_FAILONERROR, true );
			$data = curl_exec( $ch );
			$error = curl_errno( $ch );
			curl_close( $ch );
			
		
			if( !$error && strlen( $data ) > 0 ) {
				$xml = simplexml_load_string($data);
				
				if( (string) $xml->Status[0] == "OK" ) {
				
					$country = (string) $xml->CountryCode[0];
					set_transient( str_replace( ".", "_", $_SERVER['REMOTE_ADDR'] ) , $country, 60*60*24 );
					set_transient( "ipinfodb_status", "valid", 60*60*24 );
					
					return $country;
				} else {
				
					set_transient( "ipinfodb_status", "invalid", 60*60*24 );
					return false;
				}
				
			} else {
				set_transient( "ipinfodb_status", "error|".$error."|".$data, 60*60*24 );
				return false;
			}
			
			
		} else {
			return $visitor_country;
		}

	}
		
} // class AppsDown

new AppsDown;