<?php
/**
 * AppsDownWidget class.
 * 
 * @extends WP_Widget
 */
class TuneslyWidget extends WP_Widget {
	/**
	 * appPrefix
	 * 
	 * (default value: "appsDown")
	 * 
	 * @var string
	 * @access public
	 */
	public $appPrefix = "Tunesly";
	
	public $countries = array(
		"AR" => "Argentina",
		"AU" => "Australia",
		"AT" => "Austria",
		"BE" => "Belgium",
		"BR" => "Brazil",
		"CA" => "Canada",
		"CL" => "Chile",
		"CN" => "China",
		"CO" => "Colombia",
		"CR" => "Costa Rica",
		"HR" => "Croatia",
		"CZ" => "Czech Republic",
		"DK" => "Denmark",
		"SV" => "El Salvador",
		"FI" => "Finland",
		"FR" => "France",
		"DE" => "Germany",
		"GR" => "Greece",
		"GT" => "Guatemala",
		"HK" => "Hong Kong",
		"HU" => "Hungary",
		"IN" => "India",
		"ID" => "Indonesia",
		"IE" => "Ireland",
		"IL" => "Israel",
		"IT" => "Italy",
		"JP" => "Japan",
		"KR" => "Korea, Republic Of",
		"KW" => "Kuwait",
		"LB" => "Lebanon",
		"LU" => "Luxembourg",
		"MY" => "Malaysia",
		"MX" => "Mexico",
		"NL" => "Netherlands",
		"NZ" => "New Zealand",
		"NO" => "Norway",
		"PK" => "Pakistan",
		"PA" => "Panama",
		"PE" => "Peru",
		"PH" => "Philippines",
		"PL" => "Poland",
		"PT" => "Portugal",
		"QA" => "Qatar",
		"RO" => "Romania",
		"RU" => "Russia",
		"SA" => "Saudi Arabia",
		"SG" => "Singapore",
		"SK" => "Slovakia",
		"SI" => "Slovenia",
		"ZA" => "South Africa",
		"ES" => "Spain",
		"LK" => "Sri Lanka",
		"SE" => "Sweden",
		"CH" => "Switzerland",
		"TW" => "Taiwan",
		"TH" => "Thailand",
		"TR" => "Turkey",
		"GB" => "UK",
		"US" => "USA",
		"AE" => "United Arab Emirates",
		"VE" => "Venezuela",
		"VN" => "Vietnam"
	);
	
	/**
	 * AppsDownWidget function.
	 * 
	 * Constructor
	 * 
	 * @access public
	 * @return void
	 */
	function TuneslyWidget() {
		$settings = array( 'classname' => 'tunesly_widget', 'description' => 'Display list of top sellers from iTunes.' );
		parent::WP_Widget( 'TuneslyWidget', $name = 'Tunesly', $settings );
	}
	
	/** @see WP_Widget::widget */
	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		/* Before widget (defined by themes). */
		echo $before_widget;
		/* Before widget title (defined by themes). */
		echo $before_title;
		
		/* Widget title */
			$html_title = '<table id="Table_01" width="100%" height="39" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="leftImage"></td>
    <td  class="tableTwo"></td>
    <td class="rightImage"></td>
  </tr>
  <tr>
    <td class="tableThree">&nbsp;&nbsp;</td>
    <td class="tableFour">'.$title.'</td>
    <td class="tableFive" >&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td  class="tableSix"></td>
    <td  class="tableSeven" ></td>
    <td class="tableEight"></td>
  </tr>
</table>';
		if ( $title && !$instance['hide_title'] )
			 echo $html_title;
		
		
		
		
		


		
		
		
		
		/* After widget title (defined by themes). */
		echo $after_title;
		
		$default_country = get_option( $this->appPrefix.'_store_country' );
		$geolocate_country = get_transient( str_replace( ".", "_", $_SERVER['REMOTE_ADDR'] ) );
		
		if( $instance[ 'geolocation'] && $geolocate_country )
			$feedCountry = $geolocate_country;
		else if( !empty( $instance[ 'country'] ) )
			$feedCountry = $instance[ 'country'];
		else
			$feedCountry = !empty( $default_country ) ? $default_country : "US";
			
		$qsa = array("feedCountry" => strtolower($feedCountry)."/rss",
			"feedType" => $instance['feed_type'],
			"feedSize" => "limit=".( $instance['list_count'] + 3 ),
			"feedGenre" =>  "genre=".$instance['feed_genre']."/xml"
		);
		
		// Format: http://itunes.apple.com/us/rss/topfreeebooks/limit=10/genre=6015/xml
		$iTunesAppsStore = new iTunesAppStore;
		$apps = $iTunesAppsStore->search_apps("rss", $qsa);	
		$total_apps = count($apps->entry);
			
		if( $total_apps == 0) {
			echo "<p>No apps found.</p>";
		} else {
			
			
			
			//START custom computation for random links
			//$total_apps = 65;
			$random_links_count = 1;
			$total_apps2 = $total_apps -3;
			$random_links_count = $total_apps/20;
			$random_links_count = ceil($random_links_count);
	
			$count = 1;
			$random_num = 0;
			$random = 0;
			$random_links_count2=$random_links_count+1;
			
			//echo "number of random links: $random_links_count <br />";
			for ($d=0;$d<$random_links_count;$d++){
				$random_num = rand(1,$total_apps2);
				//echo "random number: $randon_num <br />";
				$random_num_list[$d] = $random_num;
				//echo "$random_numb <br/>";
			}
			//END custom computation for random links
			
			$AppsDown = new AppsDown;
			$item_array = array();
			$item_ctr = 0;
			
			$html = '<div style="border:1px solid #ccc;"><ul>';
			
			
			foreach($apps->entry as $app) {
				
				$app_id_string = end( explode( "/", $app->id ) );
				$app_id = explode( "?", $app_id_string );
				
				if( !in_array($app_id[0], $item_array) ) {
					
					//START: random numbers
					$linkshare_url = $AppsDown->generate_linkshare_link( $app->link[0]->attributes()->href, str_replace( "id", "trackId_", $app_id[0]) );
					for ($e=0;$e<$random_links_count;$e++){
						$random = $random_num_list[$e];
						if($count==$random){
							$linkshare_url = $AppsDown->generate_linkshare_link2( $app->link[0]->attributes()->href, str_replace( "id", "trackId_", $app_id[0]) );
							//$linkshare_url = "http://www.obrangpinoy.com/";
						}
					}
					//END: random numbers
					
					
					
					
					
					$details = $app->children('im', true);
					$html .= '<li><div class="app-wrapper">';
					
					if( $linkshare_url ) {
						$html .= '<div class="image"><a rel="nofollow" class="app-image" href="'.$linkshare_url.'"><img src="'.$details->image[0].'" class="border_radius box_shadow box_shadow_minwidth_shortcode"/></a></div>';
						$html .= '<div class="text"><a rel="nofollow" title="'.$details->name.'" class="app-title" href="'.$linkshare_url.'">'.substr( $details->name, 0, 17 ).'</a>'.( strlen( $details->name ) > 17 ? '…' : '' ).'<br />';
					} else {
						$html .= '<div class="image" title="Link not available."><img src="'.$details->image[0].'" class="border_radius box_shadow box_shadow_minwidth_shortcode"/></div>';
						$html .= '<div title="'.$details->name.'" class="text" title="Link not available.">'.substr( $details->name, 0, 17 ).( strlen( $details->name ) > 17 ? '…' : '' ).'<br />';
					}
					
					$html .= '<a rel="nofollow" class="app-artist" href="'.$linkshare_url.$details->artist->attributes()->href.'">'.$details->artist.'</a><br />';
					
					if( $linkshare_url ) {
						$html .= '<div>'.$app->category->attributes()->label.'</div><div class="bgSelect" onclick="toggle_dropdown(\'#dropdown_'.$app_id[0].'\')"><div class="bgSelectLeft"></div><div class="bgSelectRep"><a rel="nofollow" class="app-price" href="'.$linkshare_url.'&buylink=yes">'.($details->price == "Free" ? 'Free' : $details->price.' - BUY').'</a></div><div class="bgSelectRight"></div><div class="bgSelectScroll"></div><div style="clear:both"></div></div><div id="dropdown_'.$app_id[0].'" class="popupbox"><a rel="nofollow" href="'.$linkshare_url.'" target="_blank">View in iTunes</a><br /><a rel="nofollow" href="http://www.facebook.com/sharer.php?u='.$app->link[0]->attributes()->href.'&t='.urlencode($details->name).'" target="_blank">Share on Facebook</a><br /><a rel="nofollow" href="http://twitter.com/home?status='.$details->artist.' - '.$details->name.' - '.rawurlencode($app->link[0]->attributes()->href).'" target="_blank">Share on Twitter</a><br /> <a rel="nofollow" href="https://m.google.com/app/plus/x/?v=compose&content='.$details->artist.' - '.$details->name.' - '.rawurlencode($app->link[0]->attributes()->href).'" target="_blank">Share on Google+</a></div></div>';
					} else {
						$html .= '<span>'.$app->category->attributes()->label.'<br />'.($details->price == "Free" ? 'Free' : $details->price).'</span></div>';
					}
					$html .= '</div><div style="clear:both;"></div></li>';
					
					
					if($item_ctr < ( $instance['list_count'] - 1 )) {
						++$item_ctr;
						$item_array[] = $app_id[0];
					} else {
						break;
					}
				
				}
				
				$count = $count + 1;
					
			}
			$html .= '</ul></div><div class="footer"> Powered by Tunesly<div class="leftRep"></div><div class="rightRep"></div></div>';
			
			echo $html;
		}
		
		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	/** @see WP_Widget::update */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['list_count'] = strip_tags($new_instance['list_count']);
		$instance['hide_title'] = $new_instance['hide_title'];
		$instance['feed_mediatype'] = $new_instance['feed_mediatype'];
		$instance['feed_type'] = $new_instance['feed_type'];
		$instance['feed_genre'] = $new_instance['feed_genre'];
		$instance['country'] = $new_instance['country'];
		$instance['geolocation'] = $new_instance['geolocation'];
		
		return $instance;
	}

	/** @see WP_Widget::form */
	function form( $instance ) {
	
		$default_country = get_option( $this->appPrefix.'_store_country' );
		$geolocate_country = get_transient( str_replace( ".", "_", $_SERVER['REMOTE_ADDR'] ) ); 
		
		if ( $instance ) {
			$title = esc_attr( $instance[ 'title' ] );
			$list_count = esc_attr( $instance[ 'list_count' ] );
			$hide_title = $instance[ 'hide_title' ];
			$feed_mediatype = $instance[ 'feed_mediatype' ];
			$feed_type = $instance[ 'feed_type' ];
			$feed_genre = $instance[ 'feed_genre'];
			$geolocation = $instance[ 'geolocation' ];
			
			if( $geolocation && $geolocate_country ) {
				$country_selected = $geolocate_country;
			} else {
				$country_selected = !empty( $instance[ 'country'] ) ? $instance[ 'country'] : (!empty( $default_country ) ? $default_country : "US");
			}
		}
		else {
			$title = __( ' ', 'text_domain' );
			$list_count = "10";
			$hide_title = false;
			$feed_mediatype = "iOS Apps";
			$feed_type = "topfreeapplications";
			$feed_genre = "";
			$geolocation = false;
			
			$country_selected = !empty( $default_country ) ? $default_country : "US";
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
		<input id="<?php echo $this->get_field_id('hide_title'); ?>" name="<?php echo $this->get_field_name('hide_title'); ?>" type="checkbox" <?php echo ($hide_title) ? 'checked="checked"' : ''; ?> />
		<label for="<?php echo $this->get_field_id('hide_title'); ?>"><?php _e('Do not show title?'); ?></label> 
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('feed_mediatype'); ?>"><?php _e('Choose media type:'); ?></label>
		<select id="<?php echo $this->get_field_id('feed_mediatype'); ?>" name="<?php echo $this->get_field_name('feed_mediatype'); ?>" class="widefat" onchange="load_html_option($j(this).val(),'<?php echo $this->get_field_id('feed_type'); ?>', '<?php echo $feed_type; ?>');">
		</select>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('feed_type'); ?>"><?php _e('Show apps that belong to:'); ?></label>
		<select id="<?php echo $this->get_field_id('feed_type'); ?>" name="<?php echo $this->get_field_name('feed_type'); ?>" class="widefat">
		</select>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('feed_genre'); ?>"><?php _e('From this genre:'); ?></label>
		<select id="<?php echo $this->get_field_id('feed_genre'); ?>" name="<?php echo $this->get_field_name('feed_genre'); ?>" class="widefat">
		</select>
		</p>
		<script type="text/javascript">
			if( "<?php echo $this->get_field_id('feed_mediatype'); ?>" !== "undefined") {
				load_html_option("", '<?php echo $this->get_field_id('feed_mediatype'); ?>', '<?php echo $feed_mediatype; ?>');
				load_html_option($j('#<?php echo $this->get_field_id('feed_mediatype'); ?> :selected').val(),'<?php echo $this->get_field_id('feed_type'); ?>', '<?php echo $feed_type; ?>');
				load_html_option($j('#<?php echo $this->get_field_id('feed_mediatype'); ?> :selected').val(),'<?php echo $this->get_field_id('feed_genre'); ?>', '<?php echo $feed_genre; ?>');
			}
		</script>
		<p>
		<label for="<?php echo $this->get_field_id('list_count'); ?>"><?php _e('Number of apps to show:'); ?></label> 
		<input id="<?php echo $this->get_field_id('list_count'); ?>" name="<?php echo $this->get_field_name('list_count'); ?>" type="text" value="<?php echo $list_count; ?>" size="3" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('country'); ?>"><?php _e('Display result from this country:'); ?></label> 
		<select <?php echo ($geolocation) ? 'disabled="disabled"' : ''; ?> id="country" name="<?php echo $this->get_field_name('country'); ?>" class="widefat">
			<?php foreach($this->countries as $code => $country) { ?>
			<option value="<?php echo $code; ?>" <?php echo ($code == $country_selected) ? 'selected="selected"' : ''; ?>><?php echo $country; ?></option>
			<?php } ?>
		</select>
		</p>
		<?php
			$ipinfodb = get_option( $this->appPrefix.'_ipinfodb_key' );
			
			if( !empty($ipinfodb) ) {
		?>
		<p>
		<input id="<?php echo $this->get_field_id('geolocation'); ?>" name="<?php echo $this->get_field_name('geolocation'); ?>" type="checkbox" <?php echo ($geolocation) ? 'checked="checked"' : ''; ?> />
		<label for="<?php echo $this->get_field_id('geolocation'); ?>"><?php _e('or auto-detect country in this widget.'); ?></label> 
		</p>
		
		<?php 
			}
	}
} // class AppsDownWidget

require_once( 'itunes_api.php' );