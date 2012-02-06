/* script goes here */

var media_value = new Object;
	media_value["software"] = "iOS Apps";
    media_value["movie"] = "Movie";
    media_value["podcast"] = "Podcast";
    media_value["music"] = "Music";
    media_value["musicVideo"] = "Music Video";
    media_value["audiobook"] = "Audiobook";
    media_value["shortFilm"] = "Short Film";
    media_value["tvShow"] = "TV Show";
    media_value["ebook"] = "Ebook";
    media_value["all"] = "All";

var media_choices = new Object;
	media_choices["software"] = new Object;
	media_choices["software"]["software"] = "iPhone Apps";
	media_choices["software"]["iPadSoftware"] = "iPad Apps";
	media_choices["software"]["macSoftware"] = "Mac Software";
	media_choices["movie"] = new Object;
	media_choices["movie"]["movie"] = "Movies";
	media_choices["movie"]["movieArtist"] = "Movie Artist";
	media_choices["podcast"] = new Object;
	media_choices["podcast"]["podcast"] = "Podcasts";
	media_choices["podcast"]["podcastAuthor"] = "Podcast Author";
	media_choices["music"] = new Object;
	media_choices["music"]["song"] = "Song";
	media_choices["music"]["musicArtist"] = "Music Artist";
	media_choices["music"]["musicTrack"] = "Music Track";
	media_choices["music"]["album"] = "Album";
	media_choices["music"]["musicVideo"] = "Music Video";
	media_choices["music"]["mix"] = "Mix";
	media_choices["musicVideo"] = new Object;
	media_choices["musicVideo"]["musicVideo"] = "Music Video";
	media_choices["musicVideo"]["musicArtist"] = "Music Artist";
	media_choices["audiobook"] = new Object;
	media_choices["audiobook"]["audiobook"] = "Audiobook";
	media_choices["audiobook"]["audiobookAuthor"] = "Audiobook Author";
	media_choices["shortFilm"] = new Object;
	media_choices["shortFilm"]["shortFilm"] = "Short Film";
	media_choices["shortFilm"]["shortFilmArtist"] = "Short Film Artist";
	media_choices["tvShow"] = new Object;
	media_choices["tvShow"]["tvEpisode"] = "TV Episode";
	media_choices["tvShow"]["tvSeason"] = "TV Season";
	media_choices["ebook"] = new Object;
	media_choices["ebook"]["ebook"] = "Ebook";
	media_choices["all"] = new Object;
	media_choices["all"]["allTrack"] = "All Track";
	media_choices["all"]["movie"] = "Movie";
	media_choices["all"]["album"] = "Album";
	media_choices["all"]["allArtist"] = "All Artist";
	media_choices["all"]["podcast"] = "Podcast";
	media_choices["all"]["musicVideo"] = "Music Video";
	media_choices["all"]["mix"] = "Mix";
	media_choices["all"]["audiobook"] = "Audiobook";
	media_choices["all"]["tvSeason"] = "TV Season";

function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function update_entity(media) {
	var media = (media == null) ? $j('#media :selected').val() : media;
	var entity_option = "";
	
	$j.each(media_choices[media], function(key, value) {
		entity_option += '<option value="' + key + '">' + value + '</option>' + "\n";
	});
	
	$j('select[name="entity"]').html(entity_option);
}

(function() {
    tinymce.create('tinymce.plugins.AppsDown', {
        init : function(ed, url) {
            ed.addButton('appsdown', {
                title : 'Click to add Tunesly shortcode',
                image : url+'/app-store-icon.png',
                onclick : function() {
	                    
            		var tuneslyform = '<div><div id="error_message"/><span style="font-size:12px; font-weight:bold">Click the checkbox to enable option(s).</span><br/>';
                		tuneslyform += '<ul>';
                		
                        if( $j.inArray("columns", tunesly_ls_options) > -1)
                            var tls_columns_default = 'checked="checked"';
                        else
                            var tls_columns_default = '';
                            
                		tuneslyform += '<li><input type="checkbox" name="options" value="columns" ' + tls_columns_default + ' /> Set iTunes listings\' rows and columns.';
                		tuneslyform += '<ul class="tunesly-options">';
                		tuneslyform += '<li><input type="text" name="columns" size="3" value="4" /> Number of columns. <div class="tooltipSet" title="Enter the number of columns of iTunes listings you would like displayed."></div></li>';
                		tuneslyform += '<li><input type="text" name="rows" size="3" value="3" /> Number of rows. <div class="tooltipSet" title="Enter the number of rows of iTunes listings you would like displayed."></div></li>';
                		tuneslyform += '</ul>';
                		tuneslyform += '</li>';
                		
                		tuneslyform += '<li><input type="checkbox" name="options" value="geolocation" /> Enable geolocation.<div class="tooltipSet2" title="This option will automatically insert iTunes search results into the post based upon the country where the viewer is located."></div>';
                		tuneslyform += '<ul class="tunesly-options">';
                		tuneslyform += '<li><input type="radio" name="geolocate" value="yes" checked="checked" /> Yes <input type="radio" name="geolocate" value="no" /> No</li>';
                		tuneslyform += '</ul>';
                		tuneslyform += '</li>';
                		
                		tuneslyform += '<li><input type="checkbox" name="options" value="media_entity" /> Select media type: <div class="tooltipSet2" title="Select the iTunes media type you would like displayed."></div>';
                		tuneslyform += '<ul class="tunesly-options">';
                		tuneslyform += '<li><select id="media" name="media" onchange="update_entity($j(this).val());">';
                		
                		$j.each(media_value, function(key, value) {
                			tuneslyform += '<option value="' + key + '">' + value + '</option>';
                		});
                		
                		tuneslyform += '</select> and category ';
                		tuneslyform += '<select name="entity">';
                		tuneslyform += '</select></li>';
                		tuneslyform += '</ul>';
                		tuneslyform += '</li>';
                		
                		tuneslyform += '<li><input type="checkbox" name="options" value="icon_only" /> Display icons only. <div class="tooltipSet2" title="Selecting this option will display listings as icons only, without text."></div>';
                		tuneslyform += '<ul class="tunesly-options">';
                		tuneslyform += '<li><input type="radio" name="icononly" value="yes" checked="checked" /> Yes <input type="radio" name="icononly" value="no" /> No</li>';
                		tuneslyform += '</ul>';
                		tuneslyform += '</li>';
                		
                		tuneslyform += '</ul>';
                		tuneslyform += '</div>';
                	var dlg = $j("<div id='TuneslyDialog' />").html(tuneslyform).appendTo("body");
                	
					dlg.dialog({
						'dialogClass' : 'wp-dialog',
						'title' : 'Tunesly Post Options',
						'modal' : true,
						'autoOpen' : false,
						'closeOnEscape' : true,
						'buttons' : [
							{
								'text' : 'Apply',
								'class' : 'button-primary',
								'click' : function() {
									
									var active_options = $j('div#TuneslyDialog input[name="options"]:checked');
									var shortcode = "[tunesly-search ";
                                    var contentTLS = '<script type="text/javascript">' + "\n";
									var error_message = "";
                                    var query_string = "";
									
									$j('#TuneslyDialog #error_message').html('');
									contentTLS += "\nvar tunesly_ls_action = 'last_shortcode';\nvar tunesly_ls_options = new Array();\n";
                                    
									active_options.each(function(){
									
										// columns and rows
										if( $j(this).val() === 'columns' ) {
											var columns = $j('input[name="columns"]').val();
											var rows = $j('input[name="rows"]').val();
                                            
						                	query_string += 'options[]=columns&';
                                            contentTLS += 'tunesly_ls_options[0] = "columns";' + "\n";
                                            
						                	// columns
						                	if( !isNumber(columns) && columns.length > 0 ) {
						                		error_message += "Only numbers are allowed in field <strong>column</strong>.<br />"; 
						                    } else {
						                    	shortcode += 'column="' + columns + '" ';
                                                query_string += 'column=' + columns + '&';
                                                contentTLS += 'var tunesly_ls_' + 'column = "' + columns + '";' + "\n";
						                    }
						                    
						                    // rows
						                    if( !isNumber(rows) && rows.length > 0 ) {
						                		error_message += "Only numbers are allowed in field <strong>rows</strong>.<br />"; 
						                    } else {
						                    	shortcode += 'row="' + rows + '" ';
                                                query_string += 'row=' + rows + '&';
                                                contentTLS += 'var tunesly_ls_' + 'row = "' + rows + '";' + "\n";
						                    }
                                            
                                            
										}
										
										// geolocation
										if( $j(this).val() === 'geolocation' ) {
											var geolocate = $j('input[name="geolocate"]:checked').val();
                                            
                                            query_string += 'options[]=geolocation&';
											contentTLS += 'tunesly_ls_options[1] = "geolocation";' + "\n";
                                            
											if( geolocate.length > 0 && geolocate !== "no" && geolocate !== "yes") {
						                		error_message +=  "Only yes or no is allowed in geolocate option.";
						                    } else {
						                    	if( geolocate === "yes" ) {
							                    	shortcode += 'geolocate="yes" ';
                                                    query_string += 'geolocate=yes&';
                                                    contentTLS += 'var tunesly_ls_' + 'geolocate = "yes";' + "\n";
							                    }
						                    }
					                    }
					                    
					                    // media and entity
										if( $j(this).val() === 'media_entity' ) {
                                            query_string += 'options[]=media_entity&';
                                            contentTLS += 'tunesly_ls_options[2] = "media_entity";' + "\n";
                                            
											var media = $j('select[name="media"] :selected').val();
											var entity = $j('select[name="entity"] :selected').val();
											
											shortcode += 'media="' + media + '" entity="' + entity + '" ';
                                            query_string += 'media=' + media + '&';
                                            query_string += 'entity=' + entity + '&';
                                            contentTLS += 'var tunesly_ls_' + 'media = "' + media + '";' + "\n";
                                            contentTLS += 'var tunesly_ls_' + 'entity = "' + entity + '";' + "\n";
					                    }
					                    
					                    // display icon only
										if( $j(this).val() === 'icon_only' ) {
				                            query_string += 'options[]=icon_only&';
                                            contentTLS += 'tunesly_ls_options[3] = "icon_only";' + "\n";
                                            
											var icon_only = $j('input[name="icononly"]:checked').val();
											
											if(icon_only == 'yes')
												shortcode += 'useicon="' + icon_only + '" ';
                                                query_string += 'useicon=' + icon_only + '&';
                                                contentTLS += 'var tunesly_ls_' + 'useicon = "' + icon_only + '";' + "\n";
					                    }
										
										if( error_message.length > 0 ) {
											$j('#TuneslyDialog #error_message').html(error_message);
										}
										
									});
									
									shortcode += '/]';
									
									if( error_message.length == 0 ) {
										$j(this).dialog('close');
										$j('#TuneslyDialog').remove();
										
										ed.execCommand('mceInsertContent', false, shortcode);
                                        $j.ajax({
                                            type: 'post',
                                            url: url+'/tunesly.php',
                                            data: 'action=last_shortcode&'+query_string,
                                            success: function(data){
                                                contentTLS += '</script>';
                                                $j('#tunesly_last_shortcode').html('');
                                                $j('#tunesly_last_shortcode').append(contentTLS);
                                            }
                                        });
									}
								}
							},
							{
								'text' : 'Cancel',
								'class' : 'button-secondary',
								'click' : function() {
								
									
									$j(this).dialog('close');
									$j('#TuneslyDialog').remove();
								}
							}
						]
					}).dialog('open');
                	
                	// Load default entity options
                	update_entity();
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "Tunesly - iTunes AppStore Affiliate Search and Display Engine",
                author : 'Bob Thodarson',
                authorurl : 'http://bobthordarson.com',
                infourl : 'http://tuneslyhq.com',
                version : "1.0"
            };
        }
    });
    tinymce.PluginManager.add('appsdown', tinymce.plugins.AppsDown);
})();









