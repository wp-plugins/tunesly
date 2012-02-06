/* script goes here */
var $j = jQuery.noConflict();

var itunesvar = new Object;
	itunesvar[""] = "";
	
	
	// iOS Apps
	itunesvar["iOS Apps"] = new Object;
	itunesvar["iOS Apps"]["topfreeapplications"] = "Top Free iPhone Apps";
	itunesvar["iOS Apps"]["toppaidapplications"] = "Top Paid iPhone Apps";
	itunesvar["iOS Apps"]["topgrossingapplications"] = "Top Grossing iPhone Apps";
	itunesvar["iOS Apps"]["topfreeipadapplications"] = "Top Free iPad Apps";
	itunesvar["iOS Apps"]["toppaidipadapplications"] = "Top Paid iPad Apps";
	itunesvar["iOS Apps"]["topgrossingipadapplications"] = "Top Grossing iPad Apps";
	itunesvar["iOS Apps"]["newapplications"] = "New Apps";
	itunesvar["iOS Apps"]["newfreeapplications"] = "New Free Applications";
	itunesvar["iOS Apps"]["newpaidapplications"] = "New Paid Applications";
	itunesvar["iOS Apps"]["genre"] = new Object;
	itunesvar["iOS Apps"]["genre"]["6018"] = "Books";
	itunesvar["iOS Apps"]["genre"]["6000"] = "Business";
	itunesvar["iOS Apps"]["genre"]["6017"] = "Education";
	itunesvar["iOS Apps"]["genre"]["6016"] = "Entertainment";
	itunesvar["iOS Apps"]["genre"]["6015"] = "Finance";
	itunesvar["iOS Apps"]["genre"]["6014"] = "Games";
	itunesvar["iOS Apps"]["genre"]["6013"] = "Health &amp; Fitness";
	itunesvar["iOS Apps"]["genre"]["6012"] = "Lifestyle";
	itunesvar["iOS Apps"]["genre"]["6020"] = "Medical";
	itunesvar["iOS Apps"]["genre"]["6011"] = "Music";
	itunesvar["iOS Apps"]["genre"]["6010"] = "Navigation";
	itunesvar["iOS Apps"]["genre"]["6009"] = "News";
	itunesvar["iOS Apps"]["genre"]["6008"] = "Photo &amp; Video";
	itunesvar["iOS Apps"]["genre"]["6007"] = "Productivity";
	itunesvar["iOS Apps"]["genre"]["6006"] = "Reference";
	itunesvar["iOS Apps"]["genre"]["6005"] = "Social Networking";
	itunesvar["iOS Apps"]["genre"]["6004"] = "Sports";
	itunesvar["iOS Apps"]["genre"]["6003"] = "Travel";
	itunesvar["iOS Apps"]["genre"]["6002"] = "Utilities";
	itunesvar["iOS Apps"]["genre"]["6001"] = "Weather";
	
	// Mac Apps
	itunesvar["Mac Software"] = new Object;
	itunesvar["Mac Software"]["topmacapps"] = "Top Mac Software";
	itunesvar["Mac Software"]["topfreemacapps"] = "Top Free Mac Software";
	itunesvar["Mac Software"]["topgrossingmacapps"] = "Top Grossing Mac Software";
	itunesvar["Mac Software"]["toppaidmacapps"] = "Top Paid Mac Software";
	itunesvar["Mac Software"]["genre"] = new Object;
	itunesvar["Mac Software"]["genre"]["12001"] = "Business";
	itunesvar["Mac Software"]["genre"]["12002"] = "Developer Tools";
	itunesvar["Mac Software"]["genre"]["12003"] = "Education";
	itunesvar["Mac Software"]["genre"]["12004"] = "Entertainment";
	itunesvar["Mac Software"]["genre"]["12005"] = "Finance";
	itunesvar["Mac Software"]["genre"]["12006"] = "Games";
	itunesvar["Mac Software"]["genre"]["12022"] = "Graphics &amp; Design";
	itunesvar["Mac Software"]["genre"]["12007"] = "Health &amp; Fitness";
	itunesvar["Mac Software"]["genre"]["12008"] = "Lifestyle";
	itunesvar["Mac Software"]["genre"]["12010"] = "Medical";
	itunesvar["Mac Software"]["genre"]["12011"] = "Music";
	itunesvar["Mac Software"]["genre"]["12012"] = "News";
	itunesvar["Mac Software"]["genre"]["12013"] = "Photography";
	itunesvar["Mac Software"]["genre"]["12014"] = "Productivity";
	itunesvar["Mac Software"]["genre"]["12015"] = "Reference";
	itunesvar["Mac Software"]["genre"]["12016"] = "Social Networking";
	itunesvar["Mac Software"]["genre"]["12017"] = "Sports";
	itunesvar["Mac Software"]["genre"]["12018"] = "Travel";
	itunesvar["Mac Software"]["genre"]["12019"] = "Utilities";
	itunesvar["Mac Software"]["genre"]["12020"] = "Video";
	itunesvar["Mac Software"]["genre"]["12021"] = "Weather";
	
		// Movies
	itunesvar["Movies"] = new Object;
	itunesvar["Movies"]["topmovies"] = "Top Movies";
	itunesvar["Movies"]["topvideorentals"] = "Top Video Rentals";
	itunesvar["Movies"]["genre"] = new Object;
	itunesvar["Movies"]["genre"]["4401"] = "Action &amp; Adventure";
	itunesvar["Movies"]["genre"]["4403"] = "Classics";
	itunesvar["Movies"]["genre"]["4404"] = "Comedy";
	itunesvar["Movies"]["genre"]["4405"] = "Documentary";
	itunesvar["Movies"]["genre"]["4406"] = "Drama";
	itunesvar["Movies"]["genre"]["4408"] = "Horror";
	itunesvar["Movies"]["genre"]["4409"] = "Independent";
	itunesvar["Movies"]["genre"]["4410"] = "Kids &amp; Family";
	itunesvar["Movies"]["genre"]["4412"] = "Romance";
	itunesvar["Movies"]["genre"]["4413"] = "Sci-Fi &amp; Fantasy";
	itunesvar["Movies"]["genre"]["4414"] = "Short Films";
	itunesvar["Movies"]["genre"]["4417"] = "Sports";
	itunesvar["Movies"]["genre"]["4416"] = "Thriller";
	itunesvar["Movies"]["genre"]["4418"] = "Western";
	
	
	// iOS Apps
	itunesvar["iTunes U"] = new Object;
	itunesvar["iTunes U"]["topitunesucollections"] = "Top iTunes U Collections";
	itunesvar["iTunes U"]["genre"] = new Object;
	itunesvar["iTunes U"]["genre"]["40000001"] = "Business";
	itunesvar["iTunes U"]["genre"]["40000009"] = "Engineering";
	itunesvar["iTunes U"]["genre"]["40000016"] = "Fine Arts";
	itunesvar["iTunes U"]["genre"]["40000026"] = "Health &amp; Medicine";
	itunesvar["iTunes U"]["genre"]["40000041"] = "History";
	itunesvar["iTunes U"]["genre"]["40000052"] = "Humanities";
	itunesvar["iTunes U"]["genre"]["40000056"] = "Language";
	itunesvar["iTunes U"]["genre"]["40000070"] = "Literature";
	itunesvar["iTunes U"]["genre"]["40000077"] = "Mathematics";
	itunesvar["iTunes U"]["genre"]["40000084"] = "Science";
	itunesvar["iTunes U"]["genre"]["40000094"] = "Social Science";
	itunesvar["iTunes U"]["genre"]["40000101"] = "Society";
	itunesvar["iTunes U"]["genre"]["40000109"] = "Teaching &amp; Education";
	
	
	
		// Podcasts
	itunesvar["Podcasts"] = new Object;
	itunesvar["Podcasts"]["toppodcasts"] = "Top Podcasts";
	itunesvar["Podcasts"]["genre"] = new Object;
	itunesvar["Podcasts"]["genre"]["1301"] = "Arts";
	itunesvar["Podcasts"]["genre"]["1321"] = "Business";
	itunesvar["Podcasts"]["genre"]["1303"] = "Comedy";
	itunesvar["Podcasts"]["genre"]["1304"] = "Education";
	itunesvar["Podcasts"]["genre"]["1323"] = "Games &amp; Hobbies";
	itunesvar["Podcasts"]["genre"]["1325"] = "Government &amp; Organizations";
	itunesvar["Podcasts"]["genre"]["1307"] = "Health";
	itunesvar["Podcasts"]["genre"]["1305"] = "Kids &amp; Family";
	itunesvar["Podcasts"]["genre"]["1310"] = "Music";
	itunesvar["Podcasts"]["genre"]["1311"] = "News &amp; Politics";
	itunesvar["Podcasts"]["genre"]["1314"] = "Religion &amp; Spirituality";
	itunesvar["Podcasts"]["genre"]["1315"] = "Science &amp; Medicine";
	itunesvar["Podcasts"]["genre"]["1324"] = "Society &amp; Culture";
	itunesvar["Podcasts"]["genre"]["1316"] = "Sports &amp; Recreation";
	itunesvar["Podcasts"]["genre"]["1318"] = "Technology";
	itunesvar["Podcasts"]["genre"]["1309"] = "TV &amp; Film";
	
	
	// Music
	itunesvar["Music"] = new Object;
	itunesvar["Music"]["topalbums"] = "Top Albums";
	itunesvar["Music"]["topimixes"] = "Top iMixes";
	itunesvar["Music"]["topsongs"] = "Top Songs";
	itunesvar["Music"]["newreleases"] = "New Releases";
	itunesvar["Music"]["justadded"] = "Just Added";
	itunesvar["Music"]["featuredalbums"] = "Featured Albums &amp; Exclusives";
	itunesvar["Music"]["genre"] = new Object;
	itunesvar["Music"]["genre"]["20"] = "Alternative";
	itunesvar["Music"]["genre"]["2"] = "Blues";
	itunesvar["Music"]["genre"]["4"] = "Children&#146;s Music";
	itunesvar["Music"]["genre"]["22"] = "Christian &amp; Gospel";
	itunesvar["Music"]["genre"]["5"] = "Classical";
	itunesvar["Music"]["genre"]["3"] = "Comedy";
	itunesvar["Music"]["genre"]["6"] = "Country";
	itunesvar["Music"]["genre"]["17"] = "Dance";
	itunesvar["Music"]["genre"]["7"] = "Electronic";
	itunesvar["Music"]["genre"]["50"] = "Fitness &amp; Workout";
	itunesvar["Music"]["genre"]["18"] = "Hip Hop/Rap";
	itunesvar["Music"]["genre"]["8"] = "Holiday";
	itunesvar["Music"]["genre"]["11"] = "Jazz";
	itunesvar["Music"]["genre"]["12"] = "Latino";
	itunesvar["Music"]["genre"]["14"] = "Pop";
	itunesvar["Music"]["genre"]["15"] = "R&amp;B/Soul";
	itunesvar["Music"]["genre"]["24"] = "Reggae";
	itunesvar["Music"]["genre"]["21"] = "Rock";
	itunesvar["Music"]["genre"]["10"] = "Singer/Songwriter";
	itunesvar["Music"]["genre"]["16"] = "Soundtrack";
	itunesvar["Music"]["genre"]["50000061"] = "Spoken Word";
	itunesvar["Music"]["genre"]["19"] = "World";

	// Music Videos
	itunesvar["Music Videos"] = new Object;
	itunesvar["Music Videos"]["topmusicvideos"] = "Top Music Videos";
	itunesvar["Music Videos"]["genre"] = new Object;
	itunesvar["Music Videos"]["genre"]["1620"] = "Alternative";
	itunesvar["Music Videos"]["genre"]["1606"] = "Country";
	itunesvar["Music Videos"]["genre"]["1607"] = "Electronic";
	itunesvar["Music Videos"]["genre"]["1618"] = "Hip Hop/Rap";
	itunesvar["Music Videos"]["genre"]["1612"] = "Latino";
	itunesvar["Music Videos"]["genre"]["1614"] = "Pop";
	itunesvar["Music Videos"]["genre"]["1615"] = "R&amp;B/Soul";
	itunesvar["Music Videos"]["genre"]["1621"] = "Rock";


	
	// Audiobooks
	itunesvar["Audiobooks"] = new Object;
	itunesvar["Audiobooks"]["topaudiobooks"] = "Top Audiobooks";
	itunesvar["Audiobooks"]["genre"] = new Object;
	itunesvar["Audiobooks"]["genre"]["50000041"] = "Arts &amp; Entertainment";
	itunesvar["Audiobooks"]["genre"]["50000070"] = "Audiobooks Latino";
	itunesvar["Audiobooks"]["genre"]["50000042"] = "Biography &amp; Memoir";
	itunesvar["Audiobooks"]["genre"]["50000043"] = "Business";
	itunesvar["Audiobooks"]["genre"]["50000045"] = "Classics";
	itunesvar["Audiobooks"]["genre"]["50000046"] = "Comedy";
	itunesvar["Audiobooks"]["genre"]["50000047"] = "Drama &amp; Poetry";
	itunesvar["Audiobooks"]["genre"]["50000040"] = "Fiction";
	itunesvar["Audiobooks"]["genre"]["50000049"] = "History";
	itunesvar["Audiobooks"]["genre"]["50000044"] = "Kids &amp; Young Adults";
	itunesvar["Audiobooks"]["genre"]["50000050"] = "Languages";
	itunesvar["Audiobooks"]["genre"]["50000051"] = "Mystery";
	itunesvar["Audiobooks"]["genre"]["74"] = "News";
	itunesvar["Audiobooks"]["genre"]["50000052"] = "Nonfiction";
	itunesvar["Audiobooks"]["genre"]["75"] = "Programs &amp; Performances";
	itunesvar["Audiobooks"]["genre"]["50000053"] = "Religion &amp; Spirituality";
	itunesvar["Audiobooks"]["genre"]["50000069"] = "Romance";
	itunesvar["Audiobooks"]["genre"]["50000055"] = "Sci-Fi &amp; Fantasy";
	itunesvar["Audiobooks"]["genre"]["50000054"] = "Science";
	itunesvar["Audiobooks"]["genre"]["50000056"] = "Self Development";
	itunesvar["Audiobooks"]["genre"]["50000048"] = "Speakers &amp; Storytellers";
	itunesvar["Audiobooks"]["genre"]["50000057"] = "Sports";
	itunesvar["Audiobooks"]["genre"]["50000058"] = "Technology";
	itunesvar["Audiobooks"]["genre"]["50000059"] = "Travel &amp; Adventure";
	
	// TV Shows
	itunesvar["TV Shows"] = new Object;
	itunesvar["TV Shows"]["toptvepisodes"] = "Top TV Episodes";
	itunesvar["TV Shows"]["toptvseasons"] = "Top TV Seasons";
	itunesvar["TV Shows"]["genre"] = new Object;
	itunesvar["TV Shows"]["genre"]["4002"] = "Animation";
	itunesvar["TV Shows"]["genre"]["4004"] = "Classic";
	itunesvar["TV Shows"]["genre"]["4000"] = "Comedy";
	itunesvar["TV Shows"]["genre"]["4001"] = "Drama";
	itunesvar["TV Shows"]["genre"]["4005"] = "Kids";
	itunesvar["TV Shows"]["genre"]["4006"] = "Nonfiction";
	itunesvar["TV Shows"]["genre"]["4007"] = "Reality TV";
	itunesvar["TV Shows"]["genre"]["4008"] = "Sci-Fi &amp; Fantasy";
	itunesvar["TV Shows"]["genre"]["4009"] = "Sports";
	itunesvar["TV Shows"]["genre"]["4010"] = "Teens";

	// E-Books
	itunesvar["E-Books"] = new Object;
	itunesvar["E-Books"]["toppaidebooks"] = "Top Paid Books";
	itunesvar["E-Books"]["topfreeebooks"] = "Top Free Books";
	itunesvar["E-Books"]["genre"] = new Object;
	itunesvar["E-Books"]["genre"]["9007"] = "Arts &amp; Entertainment";
	itunesvar["E-Books"]["genre"]["9008"] = "Biographies &amp; Memoirs";
	itunesvar["E-Books"]["genre"]["9009"] = "Business &amp; Personal Finance";
	itunesvar["E-Books"]["genre"]["9010"] = "Children &amp; Teens";
	itunesvar["E-Books"]["genre"]["9026"] = "Comics &amp; Graphic Novels";
	itunesvar["E-Books"]["genre"]["9027"] = "Computers &amp; Internet";
	itunesvar["E-Books"]["genre"]["9028"] = "Cookbooks, Food &amp; Wine";
	itunesvar["E-Books"]["genre"]["9031"] = "Fiction &amp; Literature";
	itunesvar["E-Books"]["genre"]["9025"] = "Health, Mind &amp; Body";
	itunesvar["E-Books"]["genre"]["9015"] = "History";
	itunesvar["E-Books"]["genre"]["9012"] = "Humor";
	itunesvar["E-Books"]["genre"]["9024"] = "Lifestyle &amp; Home";
	itunesvar["E-Books"]["genre"]["9032"] = "Mysteries &amp; Thrillers";
	itunesvar["E-Books"]["genre"]["9002"] = "Nonfiction";
	itunesvar["E-Books"]["genre"]["9030"] = "Parenting";
	itunesvar["E-Books"]["genre"]["9034"] = "Politics &amp; Current Events";
	itunesvar["E-Books"]["genre"]["9029"] = "Professional &amp; Technical";
	itunesvar["E-Books"]["genre"]["9033"] = "Reference";
	itunesvar["E-Books"]["genre"]["9018"] = "Religion &amp; Spirituality";
	itunesvar["E-Books"]["genre"]["9003"] = "Romance";
	itunesvar["E-Books"]["genre"]["9020"] = "Sci-Fi &amp; Fantasy";
	itunesvar["E-Books"]["genre"]["9019"] = "Science &amp; Nature";
	itunesvar["E-Books"]["genre"]["9035"] = "Sports &amp; Outdoors";
	itunesvar["E-Books"]["genre"]["9004"] = "Travel &amp; Adventure";
	

	
	
	

function load_html_option(media, target, selected) {
	var string = "";
	var genre = '<option value="">All Genres</option>';
	
	if(typeof media === "object")
		var itunes = media;
	else if(media.length > 0)
		var itunes = itunesvar[media];
	else
		var itunes = itunesvar;
			
	$j.each(itunes, function(key, value) {

		var option_value = (typeof key === "string") ? ' value="' + key + '"' : '';
		var option_text = (typeof value === "string") ? value : key;
		
		if(key !== "genre")
			string += '<option' + option_value + (selected == key ? ' selected="selected"' : '') + '>' + option_text + '</option>';
		else {
			$j.each(value, function(index, name){
				genre += '<option value="' + index + '" ' + (selected == index ? ' selected="selected"' : '') + '>' + name + '</option>';
			});
		}
	});
	
	$j('#'+target).html(string);
	
	if(media.length > 0)
		$j('#'+target.replace("feed_type", "feed_genre")).html(genre);
}

function generate_linkshare_link(appPrefix, plugin_url) {
	var original_content = $j("#"+ appPrefix +"_linkshare_url").val();
	var token = $j("#"+ appPrefix +"_linkshare_token").val();
	var mid = $j("#"+ appPrefix +"_linkshare_advertiser_id").val();
	var murl = $j("#"+ appPrefix +"_linkshare_advertiser_url").val();
	var url = "http://getdeeplink.linksynergy.com/createcustomlink.shtml?token=" + token + "&mid=" + mid + "&murl=" + murl + "&buylink=yes";
	
	var result = $j.ajax({
					type: "GET",
					url: plugin_url,
					data: {url: url},
					beforeSend: function() {
						$j("#"+ appPrefix +"_linkshare_url").val("Updating...");
					},
					success: function(data) {
						$j("#"+ appPrefix +"_linkshare_url").val(data);
						alert("Linkshare link has been updated.");
					},
					statusCode: {
						500: function() {
							$j("#"+ appPrefix +"_linkshare_url").val(original_content);
							alert("Request failed. Please try again.");
						}
					}
				});
}



$j(document).ready(function() {

$j('.bgSelect').click(function(e) {
    $j(this).next("div").toggle();
    e.stopPropagation();
});

$j('html').mouseover(function() {
    $j(".popupbox").hide();
});

$j('.popupbox').mouseover(function(e) {
    e.stopPropagation();
});

});







