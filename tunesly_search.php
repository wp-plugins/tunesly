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
require_once('./appsdown.php');
require_once('itunes_api.php');



// Make sure the user is logged in.
auth_redirect();

$input = array('column' => 1, 'row' => 100);
if( is_admin() && count($_POST) > 0 ) {
    if( count( $_POST['options'] ) > 0) {
        foreach( $_POST['options'] as $okey => $ovalue) {
            switch($ovalue){
                case 'geolocation':
                    $input['geolocate'] = $_POST['geolocate'];
                    break;
                case 'media_entity':
                    $input['media'] = $_POST['media'];
                    $input['entity'] = $_POST['entity'];
                    break;
                case 'icon_only':
                    $input['useicon'] = $_POST['useicon'];
                    break;
                case 'specific_link':
                    $input['custom_keyword'] = $_POST['custom_keyword'];
                    break;
            }
        }
    } 
    
    $appsDown = new AppsDown;
    $input = $appsDown->process_input($input , $input['custom_keyword']);
    $iTunesAppsStore = new iTunesAppStore;
    $appsStore = $iTunesAppsStore->search_apps("default", $input);
    $total_apps = $appsStore->resultCount;
    $json = array();
    if( $total_apps > 0) {
        $item_array = array();
        $apps = $appsStore->results;
        foreach($apps as $app) {

            $app_name = (!empty($app->trackName) ? $app->trackName : $app->collectionName);
            if(!isset($app_name) || $app_name==null || trim($app_name)=='') continue;
            if( !in_array($app_name, $item_array, true) ) {
                    $i++;
                    $item_array[] = $app_name;
                    $url = (isset($app->collectionViewUrl) ? $app->collectionViewUrl : (isset($app->artistViewUrl)?$app->artistViewUrl:$app->trackViewUrl));
//                    $url = (isset($app->trackViewUrl) ? $app->trackViewUrl : $app->collectionViewUrl);
                    $cat = ucfirst( isset($app->primaryGenreName) ? $app->primaryGenreName : $app->collectionType );
                    $price = isset($app->trackPrice)?$app->trackPrice:(isset($app->collectionPrice)?$app->collectionPrice:$app->price);
                    $price = $price == 0 ? 'Free' : '$'.$price;
                    $map_app = array();
                    $map_app['name'] = $app_name;
                    $map_app['link'] = $url;
                    $map_app['id'] = isset($app->collectionId)?$app->collectionId:$app->trackId;
                    $map_app['image'] = $app->artworkUrl60;
                    $map_app['price'] = $price;
                    $map_app['cat'] = $cat;
                    $json[] = $map_app;
            }
        }
    }
    echo json_encode($json);
}