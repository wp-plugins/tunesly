/* script goes here */
var tunesly = new Object();
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

function update_entity(media,entity) {
	var media = (media == null) ? $j('#media :selected').val() : media;
        var entity = entity || '';
	var entity_option = "";
	
	$j.each(media_choices[media], function(key, value) {
		entity_option += '<option value="' + key + '" '+(entity==key?'selected="selected"':'')+'>' + value + '</option>' + "\n";
	});
	
	$j('select[name="entity"],select[name="search_entity"]').html(entity_option);
}

function main_form(){
    $j('#tab-search').hide();
    $j('#single-button').removeClass('tab-selected');
    $j('#options-button').addClass('tab-selected');
    $j('#tab-options').show();
    $j('#search-result').html('');
}

function search_button(){
    $j('#single-button').addClass('tab-selected');
    $j('#options-button').removeClass('tab-selected');
    $j('#tab-options').hide();
    $j('#tab-search').show();
    $j('#search-result').html('');
    var active_options = $j('div#TuneslyDialog input[name="options"]:checked');
    var error_message = "";
    var query_string = "";

    $j('#TuneslyDialog #error_message').html('');

    active_options.each(function(){
        // geolocation
        if( $j(this).val() === 'geolocation' ) {
            var geolocate = $j('input[name="geolocate"]:checked').val();
            query_string += 'options[]=geolocation&';
            if( geolocate.length > 0 && geolocate !== "no" && geolocate !== "yes") {
                error_message +=  "Only yes or no is allowed in geolocate option.";
            } else {
                if( geolocate === "yes" ) {
                    query_string += 'geolocate=yes&';
                }
            }
        }

        // display icon only
        if( $j(this).val() === 'icon_only' ) {
            query_string += 'options[]=icon_only&';

            var icon_only = $j('input[name="icononly"]:checked').val();
            query_string += 'useicon=' + icon_only + '&';

        }

    });
    query_string += 'options[]=media_entity&';
    var media = $j('#media').val();
    var entity = $j('#entity').val();
    query_string += 'media=' + media + '&';
    query_string += 'entity=' + entity + '&';
    query_string += 'options[]=specific_link&';
    query_string += 'custom_keyword=' + encodeURIComponent($j('#search-custom-keyword').val());
    if( error_message.length > 0 ) {
        $j('#TuneslyDialog #error_message').html(error_message);
        t.checked=false;
        return false;
    }
    $j.ajax({
        type: 'post',
        dataType:'json',
        url: tunesly.url+'/tunesly_search.php',
        data: 'action=last_shortcode&'+query_string,
        success: function(data){
            if(data.length==0){
                $j('#search-result').html('No Result Found!');
                return;
            }
            var items = [];

            $j.each(data,function(k,v){
                items.push('<li><input type="radio" name="link" value="'+v.link+'" _name="'+v.name+'" _id="'+v.id+'" _image="'+v.image+'" _price="'+v.price+'" _cat="'+v.cat+'"/>' + v.name + '</li>');    
            });
            $j('#search-result').html('');
            $j('<ul/>', {
                'class': 'tunesly-options',
                html: items.join('')
            }).appendTo('#search-result');  
        }
    });
    $j('#search-result').html('loading...');
}
(function() {
    tinymce.create('tinymce.plugins.AppsDown', {
        init : function(ed, url) {
            ed.addButton('appsdown', {
                title : 'Click to add Tunesly shortcode',
                image : url+'/app-store-icon.png',
                onclick : function() {
                    tunesly.url = url;
                    function isSel(f){
                        return f?'checked="checked"':''
                    }
                    var settings = {options:[false,false,false,false],col:4,row:3,geo:true,media:'',entity:'',icon:false};
	                var def = tinymce.util.Cookie.get('tunesly.default.settings');
                        def = $j.extend({},settings,(def && tinymce.util.JSON.parse(def)) || {});
                        var opts = def.options,dlg= $j('#TuneslyDialog');
                        if(dlg.length==0){
            		var tuneslyform = '<form name="FrmTunesly"><div class="tab"><div id="single-button" class="tab-link tab-right search-button" onclick="search_button();">Single Affiliate link</div><div class="tab-link tab-selected" id="options-button" onclick="main_form();">Multiple Affiliate link</div><div style="clear:both"></div></div><div><div id="error_message"/><div id="tab-options"><span style="font-size:12px; font-weight:bold">Click the checkbox to enable option(s).</span><br/>';
                		tuneslyform += '<ul>';
                		
                		tuneslyform += '<li><input type="checkbox" name="options" value="columns" '+isSel(opts[0])+'/> Set iTunes listings\' rows and columns.';
                		tuneslyform += '<ul class="tunesly-options">';
                		tuneslyform += '<li><input type="text" name="columns" size="3" value="'+def.col+'" /> Number of columns. <div class="tooltipSet" title="Enter the number of columns of iTunes listings you would like displayed."></div></li>';
                		tuneslyform += '<li><input type="text" name="rows" size="3" value="'+def.row+'" /> Number of rows. <div class="tooltipSet" title="Enter the number of rows of iTunes listings you would like displayed."></div></li>';
                		tuneslyform += '</ul>';
                		tuneslyform += '</li>';
                		
                		tuneslyform += '<li><input type="checkbox" name="options" value="geolocation" '+isSel(opts[1])+'/> Enable geolocation.<div class="tooltipSet2" title="This option will automatically insert iTunes search results into the post based upon the country where the viewer is located."></div>';
                		tuneslyform += '<ul class="tunesly-options">';
                		tuneslyform += '<li><input type="radio" name="geolocate" value="yes" '+isSel(def.geo)+' /> Yes <input type="radio" name="geolocate" value="no" '+isSel(!def.geo)+'/> No</li>';
                		tuneslyform += '</ul>';
                		tuneslyform += '</li>';
                		
                		tuneslyform += '<li><input type="checkbox" name="options" value="media_entity" '+isSel(opts[2])+'/> Select media type: <div class="tooltipSet2" title="Select the iTunes media type you would like displayed."></div>';
                		tuneslyform += '<ul class="tunesly-options">';
                		tuneslyform += '<li><select id="media" name="media" onchange="update_entity($j(this).val());">';
                		
                		$j.each(media_value, function(key, value) {
                			tuneslyform += '<option value="' + key + '" '+(def.media==key?'selected="selected"':'')+'>' + value + '</option>';
                		});
                		
                		tuneslyform += '</select> and category ';
                		tuneslyform += '<select id="entity" name="entity">';
                		tuneslyform += '</select></li>';
                		tuneslyform += '</ul>';
                		tuneslyform += '</li>';
                		
                		tuneslyform += '<li><input type="checkbox" name="options" value="icon_only" '+isSel(opts[3])+'/> Display icons only. <div class="tooltipSet2" title="Selecting this option will display listings as icons only, without text."></div>';
                		tuneslyform += '<ul class="tunesly-options">';
                		tuneslyform += '<li><input type="radio" name="icononly" value="yes" '+isSel(def.icon)+' /> Yes <input type="radio" name="icononly" value="no" '+isSel(!def.icon)+'/> No</li>';
                		tuneslyform += '</ul>';
                		tuneslyform += '</li>';
						var _keyword = $j('#custom_keyword').val() || '';
						tuneslyform += '<li><input type="checkbox" name="options" value="custkeyword" checked style="display:none;" '+isSel(opts[4])+'/> Keyword: <input type="text" id="customkeyword" name="customkeyword" value="'+_keyword+'" ';
						if(_keyword!=""){
							tuneslyform += 'disabled="disabled" ';
						}
						tuneslyform += '/>';
						if(_keyword!=""){
							keybox = "customkeyword";
							tuneslyform += '<ul class="tunesly-options" style="margin:5px 110px 0px"><li><input type="button" value="Reset keyword" onclick="enableKeyword();"></li></ul>';
						}
						
						tuneslyform += '</li>';
						
						
						    
//                                tuneslyform += '<li><input type="checkbox" name="options" value="specific_link" onchange="showSearch(this,\''+ url.replace("'", "\'") + '\');"/> Select specific link. <div class="tooltipSet2" title="Selecting this option will display selected listings only."></div>';
//                		tuneslyform += '<div id="search-result"></div>';
                		tuneslyform += '</li>';
                		
                		tuneslyform += '</ul>';
                                tuneslyform += '</div>';
                                
                                var _keyword = $j('#custom_keyword').val() || '';
                                tuneslyform += '<div id="tab-search" style="font-size:11px;"><div> Keyword: <input type="text" id="search-custom-keyword" value="'+_keyword+'"/><button class="search-button" onclick="search_button();">Search</button></div>';
                                    
                                tuneslyform += '<div>Media Type: <select id="search_media" name="search_media" onchange="update_entity($j(this).val());">';
                		
                		$j.each(media_value, function(key, value) {
                			tuneslyform += '<option value="' + key + '" '+(def.media==key?'selected="selected"':'')+'>' + value + '</option>';
                		});
                		
                		tuneslyform += '</select><br/>Entity: ';
                		tuneslyform += '<select name="search_entity">';
                		tuneslyform += '</select></div>'
                                    
                                tuneslyform += '<div id="search-result"></div></div>';
                		tuneslyform += '</div></form>';
                                
                                
                                dlg = $j("<div id='TuneslyDialog' />").html(tuneslyform).appendTo("body");
                        }
                	
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
                                var error_message = "";
                                var query_string = "";
									
                                $j('#TuneslyDialog #error_message').html('');
				
                                var linkSel = $j('input[name="link"]:checked');
                                if(linkSel.length>0){
                                    var link = linkSel.val();
                                    if(link){
                                        query_string += 'options[]=specific_link&';
                                        var _link = encodeURIComponent(link),
                                        _image=linkSel.attr('_image'),
                                        _id=linkSel.attr('_id'),
                                        _name=linkSel.attr('_name'),
                                        _price=linkSel.attr('_price'),
                                        _cat=linkSel.attr('_cat');
                                        shortcode += 'link="' + _link + '" image="' + _image + '" id="' + _id + '" name="' + _name + '" price="' + _price + '" cat="' + _cat + '"';
                                        query_string += 'link=' + _link + '&';
                                        query_string += 'image=' + _image + '&';
                                        query_string += 'id=' + _id + '&';
                                        query_string += 'name=' + _name + '&';
                                    }
                                    query_string += 'custom_keyword=' + encodeURIComponent($j('#custom_keyword').val()) + '&';
                                }else{
                                    active_options.each(function(){

                                        // columns and rows
                                        if( $j(this).val() === 'columns' ) {
                                            var columns = $j('input[name="columns"]').val();
                                            var rows = $j('input[name="rows"]').val();

                                            query_string += 'options[]=columns&';

                                            // columns
                                            if( !isNumber(columns) && columns.length > 0 ) {
                                                error_message += "Only numbers are allowed in field <strong>column</strong>.<br />"; 
                                            } else {
                                                shortcode += 'column="' + columns + '" ';
                                                query_string += 'column=' + columns + '&';
                                            }

                                            // rows
                                            if( !isNumber(rows) && rows.length > 0 ) {
                                                error_message += "Only numbers are allowed in field <strong>rows</strong>.<br />"; 
                                            } else {
                                                shortcode += 'row="' + rows + '" ';
                                                query_string += 'row=' + rows + '&';
                                            }
                                            settings.options[0] = true;
                                            settings.col = columns;
                                            settings.row = rows;

                                        }

                                        // geolocation
                                        if( $j(this).val() === 'geolocation' ) {
                                            var geolocate = $j('input[name="geolocate"]:checked').val();

                                            query_string += 'options[]=geolocation&';

                                            if( geolocate.length > 0 && geolocate !== "no" && geolocate !== "yes") {
                                                error_message +=  "Only yes or no is allowed in geolocate option.";
                                            } else {
                                                settings.options[1] = true;
                                                settings.geo = geolocate === "yes";
                                                if( settings.geo ) {
                                                    shortcode += 'geolocate="yes" ';
                                                    query_string += 'geolocate=yes&';
                                                }
                                            }
                                        }

                                        // media and entity
                                        if( $j(this).val() === 'media_entity' ) {
                                            query_string += 'options[]=media_entity&';

                                            var media = $j('select[name="media"] :selected').val();
                                            var entity = $j('select[name="entity"] :selected').val();

                                            shortcode += 'media="' + media + '" entity="' + entity + '" ';
                                            query_string += 'media=' + media + '&';
                                            query_string += 'entity=' + entity + '&';
                                            settings.options[2] = true;
                                            settings.media = media;
                                            settings.entity = entity;
                                        }

                                        // display icon only
                                        if( $j(this).val() === 'icon_only' ) {
                                            query_string += 'options[]=icon_only&';

                                            var icon_only = $j('input[name="icononly"]:checked').val();
                                            settings.options[3] = true;
                                            settings.icon = icon_only == 'yes';
                                            if(settings.icon)
                                                shortcode += 'useicon="' + icon_only + '" ';
                                            query_string += 'useicon=' + icon_only + '&';

                                        }					
										
										//keywords
										if( $j(this).val() === 'custkeyword' ) {
											var keywords = $j('input[name="customkeyword"]').val();
												if(keywords!='') {
													query_string += 'options[]=custkeyword&';
												
													shortcode += 'keywords="' + keywords + '" ';
													//codeID = removeSpaces(keywords);
													//shortcode += 'codeID="' + codeID + '" ';
													query_string += 'keywords=' + keywords + '&';
													
													settings.options[4] = true;
													settings.keywords = keywords;
													
													var postfrm = document.forms['post'];
													//existingVal=postfrm.elements['custom_keyword'];
													//existingKeys = existingVal.value;
													//postfrm.elements['custom_keyword'].value=existingKeys + " " +codeID;
													postfrm.elements['custom_keyword'].value= keywords;
													
													//alert("test2");
												}
												else{
													var postfrm = document.forms['post'];
													postfrm.elements['custom_keyword'].value='';
													//alert("test3");
													document.getElementById('customkeyword').disabled = false;
												}
												
										}
										//if(keywords=='') {
//											var postfrm = document.forms['post'];
//											postfrm.elements['custom_keyword'].value='';
//										}
										
										
                                    });
                                }
                                if( error_message.length > 0 ) {
                                        $j('#TuneslyDialog #error_message').html(error_message);
                                }
									
                                shortcode += '/]';
									
                                if( error_message.length == 0 ) {
                                    $j(this).dialog('close');
                                    $j('#TuneslyDialog').remove();
										
                                    ed.execCommand('mceInsertContent', false, shortcode);
                                    if(linkSel.length==0){
                                        tinymce.util.Cookie.remove('tunesly.default.settings');
                                        tinymce.util.Cookie.set('tunesly.default.settings',tinymce.util.JSON.serialize(settings));
                                    }
                                    $j.ajax({
                                        type: 'post',
                                        url: url+'/tunesly.php',
                                        data: 'action=last_shortcode&'+query_string,
                                        success: function(data){
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
                    main_form();
                    // Load default entity options
                    update_entity(null,def.entity);
                    $j('select[name="search_entity"]').change(function(){
                        $j('select[name="entity"]').val($j(this).val());
                    });
                    $j('select[name="search_media"]').change(function(){
                        $j('select[name="media"]').val($j(this).val());
                        $j('select[name="entity"]').val($j('select[name="search_entity"]').val());
                    });
                    $j('#tab-search').hide();
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






function removeSpaces(string) {
	return string.split(' ').join('');
}




function addOption(selectbox,text,value )
{
	var optn = document.createElement("OPTION");
	optn.text = text;
	optn.value = value;
	selectbox.options.add(optn);
}


function enableKeyword(){
	document.getElementById("customkeyword").disabled = false;
}
