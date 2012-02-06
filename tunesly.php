<?php
/**
 * Executing AJAX process.
 *
 * @since 2.1.0
 */
define('DOING_AJAX', true);
define('WP_ADMIN', true);

if ( ! isset( $_REQUEST['action'] ) && $_REQUEST['action'] != 'last_shortcode' )
	die();

require_once('../../../wp-load.php');

// Make sure the user is logged in.
auth_redirect();

if( is_admin() && count($_POST) > 0 ) {
    if( !isset($_POST['geolocate']) || $_POST['geolocate'] == 'no' ) {
        if( in_array( 'geolocation', $_POST['options'] ) )
            unset($_POST['options'][array_search( 'geolocation', $_POST['options'] )]);
            
        unset($_POST['geolocate']);
    }
    
    if( !isset($_POST['useicon']) || $_POST['useicon'] == 'no' ) {
        if( in_array( 'icon_only', $_POST['options'] ) )
            unset($_POST['options'][array_search( 'icon_only', $_POST['options'] )]);
            
        unset($_POST['useicon']);
    }
    
    if( count( $_POST['options'] ) > 0) {
        $new_options = array();
        
        foreach( $_POST['options'] as $okey => $ovalue) {
            $new_options[] = $ovalue;
        }
        
        $_POST['options'] = $new_options;
    }   
        
    $last_shortcode =  str_replace( 'http://', '', get_bloginfo( 'url' ) ).'_tunesly_last_shortcode';
    $last_shortcode_values = serialize( $_POST );
    
    update_option( $last_shortcode, $last_shortcode_values );
}