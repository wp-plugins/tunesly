<?php
$AppsDown = new AppsDown;
$appsDownPrefix = $AppsDown->get_app_prefix();
?>
<div class="wrap">
    <div id="icon-options-general" class="icon32"></div>
    <h2>Tunesly Settings</h2>
    <p>The following parameters are needed to make this plugin work.</p>
    
    <?php 
    	//if( $AppsDown->unlock_app() === true ) {
    ?>
    
    <form method="POST" action="options.php">
    	<?php settings_fields( $appsDownPrefix.'_settings_itunes' ); ?>
        <h3 class="title">iTunes Affiliate Default Options</h3>
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><label for="<?=$appsDownPrefix;?>_store_country">Default Store Country: </label></th>
                <td>
                	<?php $option = get_option( $appsDownPrefix.'_store_country' ); ?>
                    <select id="<?=$appsDownPrefix;?>_store_country" name="<?=$appsDownPrefix;?>_store_country">
                        <option value="" <?php if($option == "") echo 'selected="selected"'?>></option>
                        <option value="AR" <?php if($option == "AR") echo 'selected="selected"'?>>Argentina</option>
						<option value="AU" <?php if($option == "AU") echo 'selected="selected"'?>>Australia</option>
						<option value="AT" <?php if($option == "AT") echo 'selected="selected"'?>>Austria</option>
	  					<option value="BE" <?php if($option == "BE") echo 'selected="selected"'?>>Belgium</option>
	  					<option value="BR" <?php if($option == "BR") echo 'selected="selected"'?>>Brazil</option>
	  					<option value="CA" <?php if($option == "CA") echo 'selected="selected"'?>>Canada</option>
	  					<option value="CL" <?php if($option == "CL") echo 'selected="selected"'?>>Chile</option>
	  					<option value="CN" <?php if($option == "CN") echo 'selected="selected"'?>>China</option>
	  					<option value="CO" <?php if($option == "CO") echo 'selected="selected"'?>>Colombia</option>
	  					<option value="CR" <?php if($option == "CR") echo 'selected="selected"'?>>Costa Rica</option>
	  					<option value="HR" <?php if($option == "HR") echo 'selected="selected"'?>>Croatia</option>
	  					<option value="CZ" <?php if($option == "CZ") echo 'selected="selected"'?>>Czech Republic</option>
	  					<option value="DK" <?php if($option == "DK") echo 'selected="selected"'?>>Denmark</option>
	  					<option value="SV" <?php if($option == "SV") echo 'selected="selected"'?>>El Salvador</option>
	  					<option value="FI" <?php if($option == "FI") echo 'selected="selected"'?>>Finland</option>
	  					<option value="FR" <?php if($option == "FR") echo 'selected="selected"'?>>France</option>
	  					<option value="DE" <?php if($option == "DE") echo 'selected="selected"'?>>Germany</option>
	  					<option value="GR" <?php if($option == "GR") echo 'selected="selected"'?>>Greece</option>
	  					<option value="GT" <?php if($option == "GT") echo 'selected="selected"'?>>Guatemala</option>
	  					<option value="HK" <?php if($option == "HK") echo 'selected="selected"'?>>Hong Kong</option>
	  					<option value="HU" <?php if($option == "HU") echo 'selected="selected"'?>>Hungary</option>
	  					<option value="IN" <?php if($option == "IN") echo 'selected="selected"'?>>India</option>
	  					<option value="ID" <?php if($option == "ID") echo 'selected="selected"'?>>Indonesia</option>
	  					<option value="IE" <?php if($option == "IE") echo 'selected="selected"'?>>Ireland</option>
						<option value="IL" <?php if($option == "IL") echo 'selected="selected"'?>>Israel</option>
						<option value="IT" <?php if($option == "IT") echo 'selected="selected"'?>>Italy</option>
						<option value="JP" <?php if($option == "JP") echo 'selected="selected"'?>>Japan</option>
						<option value="KR" <?php if($option == "KR") echo 'selected="selected"'?>>Korea, Republic Of</option>
						<option value="KW" <?php if($option == "KW") echo 'selected="selected"'?>>Kuwait</option>
						<option value="LB" <?php if($option == "LB") echo 'selected="selected"'?>>Lebanon</option>
						<option value="LU" <?php if($option == "LU") echo 'selected="selected"'?>>Luxembourg</option>
						<option value="MY" <?php if($option == "MY") echo 'selected="selected"'?>>Malaysia</option>
						<option value="MX" <?php if($option == "MX") echo 'selected="selected"'?>>Mexico</option>
						<option value="NL" <?php if($option == "NL") echo 'selected="selected"'?>>Netherlands</option>
						<option value="NZ" <?php if($option == "NZ") echo 'selected="selected"'?>>New Zealand</option>
						<option value="NO" <?php if($option == "NO") echo 'selected="selected"'?>>Norway</option>
						<option value="PK" <?php if($option == "PK") echo 'selected="selected"'?>>Pakistan</option>
						<option value="PA" <?php if($option == "PA") echo 'selected="selected"'?>>Panama</option>
						<option value="PE" <?php if($option == "PE") echo 'selected="selected"'?>>Peru</option>
						<option value="PH" <?php if($option == "PH") echo 'selected="selected"'?>>Philippines</option>
						<option value="PL" <?php if($option == "PL") echo 'selected="selected"'?>>Poland</option>
						<option value="PT" <?php if($option == "PT") echo 'selected="selected"'?>>Portugal</option>
						<option value="QA" <?php if($option == "QA") echo 'selected="selected"'?>>Qatar</option>
						<option value="RO" <?php if($option == "RO") echo 'selected="selected"'?>>Romania</option>
						<option value="RU" <?php if($option == "RU") echo 'selected="selected"'?>>Russia</option>
						<option value="SA" <?php if($option == "SA") echo 'selected="selected"'?>>Saudi Arabia</option>
						<option value="SG" <?php if($option == "SG") echo 'selected="selected"'?>>Singapore</option>
						<option value="SK" <?php if($option == "SK") echo 'selected="selected"'?>>Slovakia</option>
						<option value="SI" <?php if($option == "SI") echo 'selected="selected"'?>>Slovenia</option>
						<option value="ZA" <?php if($option == "ZA") echo 'selected="selected"'?>>South Africa</option>
						<option value="ES" <?php if($option == "ES") echo 'selected="selected"'?>>Spain</option>
						<option value="LK" <?php if($option == "LK") echo 'selected="selected"'?>>Sri Lanka</option>
						<option value="SE" <?php if($option == "SE") echo 'selected="selected"'?>>Sweden</option>
						<option value="CH" <?php if($option == "CH") echo 'selected="selected"'?>>Switzerland</option>
						<option value="TW" <?php if($option == "TW") echo 'selected="selected"'?>>Taiwan</option>
						<option value="TH" <?php if($option == "TH") echo 'selected="selected"'?>>Thailand</option>
						<option value="TR" <?php if($option == "TR") echo 'selected="selected"'?>>Turkey</option>
						<option value="GB" <?php if($option == "GB") echo 'selected="selected"'?>>UK</option>
						<option value="US" <?php if($option == "US") echo 'selected="selected"'?>>USA</option>
						<option value="AE" <?php if($option == "AE") echo 'selected="selected"'?>>United Arab Emirates</option>
						<option value="VE" <?php if($option == "VE") echo 'selected="selected"'?>>Venezuela</option>
						<option value="VN" <?php if($option == "VN") echo 'selected="selected"'?>>Vietnam</option>
				   </select>
				   <a id="store_country_link" name="Store Country" class="jTip"  alt="<?=plugins_url('/tooltips.php?field='.$appsDownPrefix.'_store_country&width=200', __FILE__);?>"><img src="<?=plugins_url('/questionMark.png', __FILE__);?>" class="help_icon" /></a>
                </td>
            </tr>
            <!--<tr valign="top">
                <th scope="row"><label for="<?=$appsDownPrefix;?>_store_result_item">No. of applications to show: </label></th>
                <td>
                	<?php $option = get_option( $appsDownPrefix.'_store_result_item' ); ?>
                    <select id="<?=$appsDownPrefix;?>_store_result_item" name="<?=$appsDownPrefix;?>_store_result_item" style="width:50px">
                        <option <?php if($option == 10) echo "selected"?>>10</option>
                        <option <?php if($option == 25) echo "selected"?>>25</option>
                        <option <?php if($option == 50) echo "selected"?>>50</option>
                    </select>
                    <a id="store_result_item" name="No. of applications to show" class="jTip" href="#" alt="<?=plugins_url('/tooltips.php?field='.$appsDownPrefix.'_store_result_item&width=200', __FILE__);?>"><img src="<?=plugins_url('/questionMark.png', __FILE__);?>" class="help_icon" /></a>
                </td>
            </tr>-->
            <tr valign="top">
                <th scope="row"><label for="<?=$appsDownPrefix;?>_result_row">No. of rows: </label></th>
                <td><input id="<?=$appsDownPrefix;?>_result_row" class="small-text" type="text" maxlength="50" name="<?=$appsDownPrefix;?>_result_row" value="<?=get_option( $appsDownPrefix.'_result_row' );?>"" />
                <a id="result_row" name="No. of rows" class="jTip"  alt="<?=plugins_url('/tooltips.php?field='.$appsDownPrefix.'_result_rows&width=200', __FILE__);?>"><img src="<?=plugins_url('/questionMark.png', __FILE__);?>" class="help_icon" /></a></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="<?=$appsDownPrefix;?>_result_column">No. of columns: </label></th>
                <td><input id="<?=$appsDownPrefix;?>_result_column" class="small-text" type="text" maxlength="50" name="<?=$appsDownPrefix;?>_result_column" value="<?=get_option( $appsDownPrefix.'_result_column' );?>"" />
                <a id="result_column" name="No. of columns" class="jTip" alt="<?=plugins_url('/tooltips.php?field='.$appsDownPrefix.'_result_column&width=200', __FILE__);?>"><img src="<?=plugins_url('/questionMark.png', __FILE__);?>" class="help_icon" /></a></td>
            </tr>
            <!-- <tr valign="top">
                <th scope="row"><label for="<?=$appsDownPrefix;?>_result_label">Header Title: </label></th>
                <td><input id="<?=$appsDownPrefix;?>_result_label" class="regular-text" type="text" maxlength="50" name="<?=$appsDownPrefix;?>_result_label" value="<?=get_option( $appsDownPrefix.'_result_label' );?>"" />
                <a id="result_label" name="Header Title" class="jTip"  alt="<?=plugins_url('/tooltips.php?field='.$appsDownPrefix.'_result_label&width=200', __FILE__);?>"><img src="<?=plugins_url('/questionMark.png', __FILE__);?>" class="help_icon" /></a>
                <br />
                <span>Leave Title blank to use Post Title as Header</span>
                
                </td>
            </tr> -->
        </table>
        <p class="submit">
            <input type="submit" class="button-primary" name="submitbutton" value="<?php _e('Save Options'); ?>" id="submitbutton" />
        </p>
    </form>
    <form method="POST" action="options.php">
    	<?php 
    		settings_fields( $appsDownPrefix.'_settings_linkshare' ); 
    		$linkshare_token = get_option($appsDownPrefix.'_linkshare_token');
    		$linkshare_advertiser_id = get_option($appsDownPrefix.'_linkshare_advertiser_id');
    	?>
        <h3 class="title">Linkshare Affiliate Configuration</h3>
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><label for="<?=$appsDownPrefix;?>_linkshare_token">Web Services Token: </label></th>
                <td><textarea id="<?=$appsDownPrefix;?>_linkshare_token" class="regular-text" cols="40" rows="3" name="<?=$appsDownPrefix;?>_linkshare_token"><?=get_option( $appsDownPrefix.'_linkshare_token' );?></textarea>
                <br><span class="description">Click <a href="http://cli.linksynergy.com/cli/publisher/links/webServices.php" title="Right-click to open in new tab/window.">here</a> to change your Web Services Token.</span> <a id="linkshare_token" name="Web Services Token" class="jTip"  alt="<?=plugins_url('/tooltips.php?field='.$appsDownPrefix.'_linkshare_token&width=200', __FILE__);?>"><img src="<?=plugins_url('/questionMark.png', __FILE__);?>" class="help_icon" /></a></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="<?=$appsDownPrefix;?>_linkshare_generate_timeout">Link generation timeout (seconds): </label></th>
                <td><input id="<?=$appsDownPrefix;?>_linkshare_generate_timeout" class="small-text" type="text" maxlength="50" name="<?=$appsDownPrefix;?>_linkshare_generate_timeout" value="<?=get_option( $appsDownPrefix.'_linkshare_generate_timeout' );?>"  /> <span class="description">Defaults to 2 seconds.</span> <a id="linkshare_generate_timeout" name="Link generation timeout" class="jTip"  alt="<?=plugins_url('/tooltips.php?field='.$appsDownPrefix.'_linkshare_generate_timeout&width=200', __FILE__);?>"><img src="<?=plugins_url('/questionMark.png', __FILE__);?>" class="help_icon" /></a></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="<?=$appsDownPrefix;?>_linkshare_advertiser_id">Advertiser ID: </label></th>
                <td><input id="<?=$appsDownPrefix;?>_linkshare_advertiser_id" class="small-text" type="text" maxlength="50" name="<?=$appsDownPrefix;?>_linkshare_advertiser_id" value="<?=get_option( $appsDownPrefix.'_linkshare_advertiser_id' );?>"  /> <a id="linkshare_advertiser_id" name="Advertiser ID" class="jTip"  alt="<?=plugins_url('/tooltips.php?field='.$appsDownPrefix.'_linkshare_advertiser_id&width=200', __FILE__);?>"><img src="<?=plugins_url('/questionMark.png', __FILE__);?>" class="help_icon" /></a></td>
            </tr>
        </table>
        <p class="submit">
            <input type="submit" class="button-primary" name="submitbutton2" value="<?php _e('Save Linkshare Configuration'); ?>" id="submitbutton2" />
        </p>
    </form>
    <form method="POST" action="options.php">
    	<?php 
    		settings_fields( $appsDownPrefix.'_settings_ipinfodb' ); 
    		$ipinfodb_key = get_option($appsDownPrefix.'_ipinfodb_key');
    	?>
        <h3 class="title">IPInfoDB Configuration</h3>
        <p><a href="http://www.ipinfodb.com/login.php">Signup here</a> to provide free geo-location feature to your widgets and shortcode thru IPInfoDB service.</p>
        <table class="form-table">																																													
        	<tr valign="top">
                <th scope="row"><label for="<?=$appsDownPrefix;?>_ipinfodb_key">IPInfoDB  API Key: </label></th>
                <td><textarea id="<?=$appsDownPrefix;?>_ipinfodb_key" class="regular-text" cols="40" rows="3" name="<?=$appsDownPrefix;?>_ipinfodb_key"><?=get_option( $appsDownPrefix.'_ipinfodb_key' );?></textarea> <a id="ipinfodb_api_key" name="IPInfoDB API Key" class="jTip"  alt="<?=plugins_url('/tooltips.php?field='.$appsDownPrefix.'_ipinfodb_key&width=200', __FILE__);?>"><img src="<?=plugins_url('/questionMark.png', __FILE__);?>" class="help_icon" /></a></td>
            </tr>
            <?php
            	$ipinfodb_status = get_transient( 'ipinfodb_status' );
            	
            	if( $ipinfodb_status ) {
            	
            		if( $ipinfodb_status == "valid" )
            			$message = "Active";
            		else if( $ipinfodb_status == "invalid" )
            			$message = "Invalid API Key.";
            		else {
            			$e = explode( "|", $ipinfodb_status );
            			$message = $e[0] . ": " . $e[1] . "<br />";
            			$message = '<div style="width: 200px;">' . $e[2] . '</div>';
            		}
            ?>
            <tr valign="top">
            	<th scope="row">Geo-location Status:</th>
            	<td><strong><?php echo $message; ?></strong></td>
            </tr>
            <?php } ?>
        </table>
        <p class="submit">
            <input type="submit" class="button-primary" name="submitbutton3" value="<?php _e('Save IPInfoDB Configuration'); ?>" id="submitbutton2" />
        </p>
    </form>
    
    <?php  //} else { ?>
    <!--<form method="POST" action="options.php">
    	<?php //settings_fields( $appsDownPrefix.'_settings_license' ); ?>
        <h3 class="title">License Setup</h3>
        <table class="form-table">
            <tr valign="top">
            	<th scope="row">Paste your license key in the box below and click <strong>Activate Tunesly</strong>.<br />This form will disappear once you save a valid license.<br />
            		<textarea id="<?//=$appsDownPrefix;?>_license_key" class="regular-text" cols="60" rows="3" name="<?//=$appsDownPrefix;?>_license_key"><?//=get_option( $appsDownPrefix.'_license_key' );?></textarea>
            	</th>
            </tr>
        </table>
        <p class="submit">
            <input type="submit" class="button-primary" name="submitbutton3" value="<?php//_e('Activate Tunesly'); ?>" id="submitbutton2" />
        </p>
    </form>-->
    <?php // } ?>
</div>