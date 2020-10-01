<?php 
global $adid, $category_slug, $ishome;
$adinit = "";
if ($ishome == 1) {
	$adid = 'home';
	$skinning = 200;
	$billboard = 4;
	$button1 = 15;
	$button2 = 26;
	$rect1 = 80;
	$rect2 = 98;
	$rect3 = 116;
	$rect4 = 4;
	$rect5 = 15;
	$rect6 = 26;
	$strip = 136;
	$mbottom = 4;
	$mtop = 4;
	$pbottom = 4;
	$ptop = 4;
	$bottom = 146;
	$top = 163;
}
else
{
	if ($category_slug == 'establishment') { 
		$adid = 'directory';
		$skinning = 201;
		$billboard = 0;
		$button1 = 11;
		$button2 = 22;
		$rect1 = 74;
		$rect2 = 92;
		$rect3 = 110;
		$rect4 = 0;
		$rect5 = 11;
		$rect6 = 22;
		$strip = 132;
		$mbottom = 0;
		$mtop = 0;
		$pbottom = 0;
		$ptop = 0;
		$bottom = 142;
		$top = 159;
	} elseif ($category_slug == 'event') { 
		$adid = 'events';
		$skinning = 202;
		$billboard = 3;
		$button1 = 14;
		$button2 = 25;
		$rect1 = 77;
		$rect2 = 95;
		$rect3 = 113;
		$rect4 = 3;
		$rect5 = 14;
		$rect6 = 25;
		$strip = 135;
		$mbottom = 3;
		$mtop = 3;
		$pbottom = 3;
		$ptop = 3;
		$bottom = 145;
		$top = 162;
	} else {
		if ($article_category[0]['ID'] == 1622 || $article_category[0]['ID'] == 23985 || $adid == 'eat_drink') { 
			$adid = 'eat_drink'; //EAT&DRINK, EAT OUT NOW
			$skinning = 203;
			$billboard = 1;
			$button1 = 12;
			$button2 = 23;
			$rect1 = 75;
			$rect2 = 93;
			$rect3 = 111;
			$rect4 = 1;
			$rect5 = 12;
			$rect6 = 23;
			$strip = 133;
			$mbottom = 1;
			$mtop = 1;
			$pbottom = 1;
			$ptop = 1;
			$bottom = 143;
			$top = 160;
			$gmrec = 125;
			$gtop = 153;
		} elseif ($article_category[0]['ID'] == 1623 || $article_category[0]['ID'] == 19329 || $article_category[0]['ID'] == 23987 || $adid == 'entertainment') { 
			$adid = 'entertainment'; //ENTERTAINMENT, CUT ME SOME SLACKS, CINESCAPE
			$skinning = 204;
			$billboard = 2;
			$button1 = 13;
			$button2 = 24;
			$rect1 = 76;
			$rect2 = 94;
			$rect3 = 112;
			$rect4 = 2;
			$rect5 = 13;
			$rect6 = 24;
			$strip = 134;
			$mbottom = 2;
			$mtop = 2;
			$pbottom = 2;
			$ptop = 2;
			$bottom = 144;
			$top = 161;
			$gmrec = 126;
			$gtop = 154;
		} elseif ($article_category[0]['ID'] == 11132 || $article_category[0]['ID'] == 19331 || $article_category[0]['ID'] == 11527 || $article_category[0]['ID'] == 17479 || $adid == 'news_features') { 
			$adid = 'news_features'; //NEWS&FEATURE, THIS IS CRAZY PLANETS, ODDS&ENDS, THE FEED
			$skinning = 205;
			$billboard = 6;
			$button1 = 17;
			$button2 = 28;
			$rect1 = 82;
			$rect2 = 100;
			$rect3 = 118;
			$rect4 = 6;
			$rect5 = 17;
			$rect6 = 28;
			$strip = 138;
			$mbottom = 6;
			$mtop = 6;
			$pbottom = 6;
			$ptop = 6;
			$bottom = 148;
			$top = 165;
			$gmrec = 127;
			$gtop = 155;
		} elseif ($article_category[0]['ID'] == 1625 || $adid == 'people_parties') { 
			$adid = 'people_parties'; //PEOPLE&PARTIES
			$skinning = 206;
			$billboard = 8;
			$button1 = 19;
			$button2 = 30;
			$rect1 = 84;
			$rect2 = 102;
			$rect3 = 120;
			$rect4 = 8;
			$rect5 = 19;
			$rect6 = 30;
			$strip = 140;
			$mbottom = 8;
			$mtop = 8;
			$pbottom = 8;
			$ptop = 8;
			$bottom = 150;
			$top = 167;
			$gmrec = 128;
			$gtop = 156;
		} elseif ($article_category[0]['ID'] == 1624 || $adid == 'shopping_services') { 
			$adid = 'shopping_services'; //SHOPPING&SERVICE
			$skinning = 207;
			$billboard = 9;
			$button1 = 20;
			$button2 = 31;
			$rect1 = 86;
			$rect2 = 104;
			$rect3 = 122;
			$rect4 = 9;
			$rect5 = 20;
			$rect6 = 31;
			$strip = 141;
			$mbottom = 9;
			$mtop = 9;
			$pbottom = 9;
			$ptop = 9;
			$bottom = 151;
			$top = 168;
			$gmrec = 129;
			$gtop = 157;
		} elseif ($article_category[0]['ID'] == 23755 || $adid == 'things_to_do') { 
			$adid = 'things_to_do'; //THINGS TO DO
			$skinning = 208;
			$billboard = 10;
			$button1 = 21;
			$button2 = 32;
			$rect1 = 0;
			$rect2 = 1;
			$rect3 = 2;
			$rect4 = 10;
			$rect5 = 21;
			$rect6 = 32;
			$strip = 3;			
			$mbottom = 10;
			$mtop = 10;
			$pbottom = 10;
			$ptop = 10;
			$bottom = 152;
			$top = 169;
			$gmrec = 130;
			$gtop = 158;
		} elseif ($article_category[0]['ID'] == 11526 || $adid == 'events') { 
			$adid = 'events'; //EVENT
			$skinning = 202;
			$billboard = 3;
			$button1 = 14;
			$button2 = 25;
			$rect1 = 77;
			$rect2 = 95;
			$rect3 = 113;
			$rect4 = 3;
			$rect5 = 14;
			$rect6 = 25;
			$strip = 135;
			$mbottom = 3;
			$mtop = 3;
			$pbottom = 3;
			$ptop = 3;
			$bottom = 145;
			$top = 162;
		} else { 
			$adid = 'others';  //VIDEO, PROMO
			$skinning = 209;
			$billboard = 7;
			$button1 = 18;
			$button2 = 29;
			$rect1 = 83;
			$rect2 = 101;
			$rect3 = 119;
			$rect4 = 7;
			$rect5 = 18;
			$rect6 = 29;
			$strip = 139;
			$mbottom = 7;
			$mtop = 7;
			$pbottom = 7;
			$ptop = 7;
			$bottom = 149;
			$top = 166;
		} 
	} 
} ?>

			<script type='text/javascript'>
            (function() {
            var useSSL = 'https:' == document.location.protocol;
            var src = (useSSL ? 'https:' : 'http:') +
            '//www.googletagservices.com/tag/js/gpt.js';
            document.write('<scr' + 'ipt src="' + src + '"></scr' + 'ipt>');
            })();
            </script>
            
            <script type='text/javascript'>
			
			var viewportWidth  = document.documentElement.clientWidth;
			
            if ($(window).width() > 999) {  	
            /* DESKTOP AD UNIT */
            googletag.defineSlot('/1019353/spot_interruptor_ad', [500, 500], 'div-gpt-ad-1372220318117-33').addService(googletag.pubads());
            googletag.defineSlot('/1019353/spot_interstitial_gallery', [300, 250], 'div-gpt-ad-1372220318117-34').addService(googletag.pubads());
            
            googletag.defineSlot('/1019353/spot_special_skinning', [1, 1], 'div-gpt-ad-1372220318117-131').addService(googletag.pubads());
            
			googletag.defineSlot('/1019353/spot_skinning_<?php echo $adid; ?>', [1600, 700], 'div-gpt-ad-1372220318117-<?php echo $skinning; ?>').addService(googletag.pubads());
			
            googletag.defineSlot('/1019353/spot_billboard_<?php echo $adid; ?>', [970, 250], 'div-gpt-ad-1372220318117-<?php echo $billboard; ?>').addService(googletag.pubads());
            googletag.defineSlot('/1019353/spot_strip_ad_<?php echo $adid; ?>', [970, 60], 'div-gpt-ad-1372220318117-<?php echo $strip; ?>').addService(googletag.pubads());
            googletag.defineSlot('/1019353/spot_super_leaderboard_bottom_<?php echo $adid; ?>', [970, 90], 'div-gpt-ad-1372220318117-<?php echo $bottom; ?>').addService(googletag.pubads());
            googletag.defineSlot('/1019353/spot_super_leaderboard_top_<?php echo $adid; ?>', [970, 90], 'div-gpt-ad-1372220318117-<?php echo $top; ?>').addService(googletag.pubads());			
			googletag.defineSlot('/1019353/spot_button01_<?php echo $adid; ?>', [300, 60], 'div-gpt-ad-1372220318117-<?php echo $button1; ?>').addService(googletag.pubads());
            googletag.defineSlot('/1019353/spot_button02_<?php echo $adid; ?>', [300, 60], 'div-gpt-ad-1372220318117-<?php echo $button2; ?>').addService(googletag.pubads());
            googletag.defineSlot('/1019353/spot_medium_rectangle01_<?php echo $adid; ?>', [300, 250], 'div-gpt-ad-1372220318117-<?php echo $rect1; ?>').addService(googletag.pubads());
            googletag.defineSlot('/1019353/spot_medium_rectangle02_<?php echo $adid; ?>', [300, 250], 'div-gpt-ad-1372220318117-<?php echo $rect2; ?>').addService(googletag.pubads());
            googletag.defineSlot('/1019353/spot_medium_rectangle03_<?php echo $adid; ?>', [300, 250], 'div-gpt-ad-1372220318117-<?php echo $rect3; ?>').addService(googletag.pubads());			            
			}
			
			if ($(window).width() > 630 && $(window).width() < 999) {
			/* TABLET AD UNIT */
			googletag.defineSlot('/1019353/spot_leaderboard_top_<?php echo $adid; ?>', [728, 90], 'div-gpt-ad-1375192852269-<?php echo $mtop; ?>').addService(googletag.pubads());			
			googletag.defineSlot('/1019353/spot_leaderboard_bottom_<?php echo $adid; ?>', [728, 90], 'div-gpt-ad-1375192910437-<?php echo $mbottom; ?>').addService(googletag.pubads());
			googletag.defineSlot('/1019353/spot_medium_rectangle05_<?php echo $adid; ?>', [300, 250], 'div-gpt-ad-1375959073562-<?php echo $rect4; ?>').addService(googletag.pubads());
            googletag.defineSlot('/1019353/spot_medium_rectangle06_<?php echo $adid; ?>', [300, 250], 'div-gpt-ad-1375959073562-<?php echo $rect5; ?>').addService(googletag.pubads());
            googletag.defineSlot('/1019353/spot_medium_rectangle07_<?php echo $adid; ?>', [300, 250], 'div-gpt-ad-1375959073562-<?php echo $rect6; ?>').addService(googletag.pubads());			
			}
            
			if ($(window).width() <= 630) {  	
			/* PHONE AD UNIT */			
			googletag.defineSlot('/1019353/spot_leaderboard_top_mobile_<?php echo $adid; ?>', [320, 50], 'div-gpt-ad-1375247383573-<?php echo $ptop; ?>').addService(googletag.pubads());
			googletag.defineSlot('/1019353/spot_leaderboard_bottom_mobile_<?php echo $adid; ?>', [320, 50], 'div-gpt-ad-1375247337879-<?php echo $pbottom; ?>').addService(googletag.pubads());
			}		
            
            googletag.pubads().enableSingleRequest();
            googletag.pubads().collapseEmptyDivs();
            googletag.pubads().enableSyncRendering();
            
            googletag.enableServices();
            </script>
            
            <style>

				
				#div-gpt-ad-1372220318117-<?php echo $billboard; ?> 
				{
					display: block;          	
				}            
				#div-gpt-ad-1372220318117-<?php echo $bottom; ?>, #div-gpt-ad-1372220318117-<?php echo $top; ?>
				{
					display: block;
				}
				#div-gpt-ad-1372220318117-<?php echo $strip; ?> 
				{            
					display: block;
				}
				#div-gpt-ad-1372220318117-<?php echo $button1; ?>, #div-gpt-ad-1372220318117-<?php echo $button2; ?> { display: block; }
				#div-gpt-ad-1372220318117-<?php echo $rect1; ?>, #div-gpt-ad-1372220318117-<?php echo $rect2; ?>, div-gpt-ad-1372220318117-<?php echo $rect3; ?> { display: block; }
				
				/* TABLET AD UNIT */
				#div-gpt-ad-1375192852269-<?php echo $mtop; ?>, #div-gpt-ad-1375192910437-<?php echo $mbottom; ?> { display: none; }
				#div-gpt-ad-1375959073562-<?php echo $rect4; ?>, #div-gpt-ad-1375959073562-<?php echo $rect5; ?>, #div-gpt-ad-1375959073562-<?php echo $rect6; ?> { display: none; }
				
				#div-gpt-ad-1375247383573-<?php echo $ptop; ?>, #div-gpt-ad-1375247337879-<?php echo $pbottom; ?> { display: none; }
	
				@media screen and (max-width: 999px) {
	
					
					#div-gpt-ad-1372220318117-<?php echo $billboard; ?> 
					{
						display: none;          	
					}            
					#div-gpt-ad-1372220318117-<?php echo $bottom; ?>, #div-gpt-ad-1372220318117-<?php echo $top; ?>
					{
						display: none;
					}
					#div-gpt-ad-1372220318117-<?php echo $strip; ?> 
					{            
						display: none;
					}
					#div-gpt-ad-1372220318117-<?php echo $button1; ?>, #div-gpt-ad-1372220318117-<?php echo $button2; ?> { display: none; }
					#div-gpt-ad-1372220318117-<?php echo $rect1; ?>, #div-gpt-ad-1372220318117-<?php echo $rect2; ?>, div-gpt-ad-1372220318117-<?php echo $rect3; ?> { display: none; }
					
					/* TABLET AD UNIT */
					#div-gpt-ad-1375192852269-<?php echo $mtop; ?>, #div-gpt-ad-1375192910437-<?php echo $mbottom; ?> { display: block; }
					#div-gpt-ad-1375959073562-<?php echo $rect4; ?>, #div-gpt-ad-1375959073562-<?php echo $rect5; ?>, #div-gpt-ad-1375959073562-<?php echo $rect6; ?> { display: block; }
					
					/* PHONE AD UNIT */
					#div-gpt-ad-1375247383573-<?php echo $ptop; ?>, #div-gpt-ad-1375247337879-<?php echo $pbottom; ?> { display: none; }
				
				}
				
				@media screen and (max-width: 730px) {
	
				
					#div-gpt-ad-1372220318117-<?php echo $billboard; ?> 
					{
						display: none;          	
					}            
					#div-gpt-ad-1372220318117-<?php echo $bottom; ?>, #div-gpt-ad-1372220318117-<?php echo $top; ?>
					{
						display: none;
					}
					#div-gpt-ad-1372220318117-<?php echo $strip; ?> 
					{            
						display: none;
					}
					#div-gpt-ad-1372220318117-<?php echo $button1; ?>, #div-gpt-ad-1372220318117-<?php echo $button2; ?> { display: none; }
					#div-gpt-ad-1372220318117-<?php echo $rect1; ?>, #div-gpt-ad-1372220318117-<?php echo $rect2; ?>, div-gpt-ad-1372220318117-<?php echo $rect3; ?> { display: none; }
					
					/* TABLET AD UNIT */
					#div-gpt-ad-1375192852269-<?php echo $mtop; ?>, #div-gpt-ad-1375192910437-<?php echo $mbottom; ?> { display: none; }
					#div-gpt-ad-1375959073562-<?php echo $rect4; ?>, #div-gpt-ad-1375959073562-<?php echo $rect5; ?>, #div-gpt-ad-1375959073562-<?php echo $rect6; ?> { display: none; }
					
					/* PHONE AD UNIT */
					#div-gpt-ad-1375247383573-<?php echo $ptop; ?>, #div-gpt-ad-1375247337879-<?php echo $pbottom; ?> { display: block; }
				
				}
				
			</style>
            
            <?php $rand = rand(1, 99999); ?>
        
			<script>
                function readDeviceOrientation() {
					
					location.reload();
                    
                    if ($(window).width() > 999) {  	
                        $("#billboard").html('<a href="http://pubads.g.doubleclick.net/gampad/jump?iu=/1019353/spot_billboard_<?php echo $adid; ?>&sz=970x250&c=<?php echo $rand; ?>"><img src="http://pubads.g.doubleclick.net/gampad/ad?iu=/1019353/spot_billboard_<?php echo $adid; ?>&sz=970x250&c=<?php echo $rand; ?>" /></a>');					
                        $("#superlboard").html('<a href="http://pubads.g.doubleclick.net/gampad/jump?iu=/1019353/spot_super_leaderboard_top_<?php echo $adid; ?>&sz=970x90&c=<?php echo $rand; ?>"><img src="http://pubads.g.doubleclick.net/gampad/ad?iu=/1019353/spot_super_leaderboard_top_<?php echo $adid; ?>&sz=970x90&c=<?php echo $rand; ?>" /></a>');
                        $("#stripad").html('<a href="http://pubads.g.doubleclick.net/gampad/jump?iu=/1019353/spot_strip_ad_<?php echo $adid; ?>&sz=970x60&c=<?php echo $rand; ?>"><img src="http://pubads.g.doubleclick.net/gampad/ad?iu=/1019353/spot_strip_ad_<?php echo $adid; ?>&sz=970x60&c=<?php echo $rand; ?>" /></a>');
                        $("#mrec1").html('<a href="http://pubads.g.doubleclick.net/gampad/jump?iu=/1019353/spot_medium_rectangle01_<?php echo $adid; ?>&sz=300x250&c=<?php echo $rand; ?>"><img src="http://pubads.g.doubleclick.net/gampad/ad?iu=/1019353/spot_medium_rectangle01_<?php echo $adid; ?>&sz=300x250&c=<?php echo $rand; ?>" /></a>');
                        $("#mrec2").html('<a href="http://pubads.g.doubleclick.net/gampad/jump?iu=/1019353/spot_medium_rectangle02_<?php echo $adid; ?>&sz=300x250&c=<?php echo $rand; ?>"><img src="http://pubads.g.doubleclick.net/gampad/ad?iu=/1019353/spot_medium_rectangle02_<?php echo $adid; ?>&sz=300x250&c=<?php echo $rand; ?>" /></a>');
                        $("#mrec3").html('<a href="http://pubads.g.doubleclick.net/gampad/jump?iu=/1019353/spot_medium_rectangle03_<?php echo $adid; ?>&sz=300x250&c=<?php echo $rand; ?>"><img src="http://pubads.g.doubleclick.net/gampad/ad?iu=/1019353/spot_medium_rectangle03_<?php echo $adid; ?>&sz=300x250&c=<?php echo $rand; ?>" /></a>');
                        $("#buttonad1").html('<a href="http://pubads.g.doubleclick.net/gampad/jump?iu=/1019353/spot_button01_<?php echo $adid; ?>&sz=300x60&c=<?php echo $rand; ?>"><img src="http://pubads.g.doubleclick.net/gampad/ad?iu=/1019353/spot_button01_<?php echo $adid; ?>&sz=300x60&c=<?php echo $rand; ?>" /></a>');
                        $("#buttonad2").html('<a href="http://pubads.g.doubleclick.net/gampad/jump?iu=/1019353/spot_button02_<?php echo $adid; ?>&sz=300x60&c=<?php echo $rand; ?>"><img src="http://pubads.g.doubleclick.net/gampad/ad?iu=/1019353/spot_button02_<?php echo $adid; ?>&sz=300x60&c=<?php echo $rand; ?>" /></a>');
                        $("#bottomad").html('<a href="http://pubads.g.doubleclick.net/gampad/jump?iu=/1019353/spot_super_leaderboard_bottom_<?php echo $adid; ?>&sz=970x90&c=<?php echo $rand; ?>"><img src="http://pubads.g.doubleclick.net/gampad/ad?iu=/1019353/spot_super_leaderboard_bottom_<?php echo $adid; ?>&sz=970x90&c=<?php echo $rand; ?>" /></a>');
                        
                        $("#mtop").html('');
                        $("#mrec4").html('');
                        $("#mrec5").html('');
                        $("#mrec6").html('');
                        $("#mbottom").html('');
                        
                        $("#ptop").html('');
                        $("#pbottom").html('');
                    }
                    else if ($(window).width() > 630 && $(window).width() < 999) {		
                        $("#billboard").html('');					
                        $("#superlboard").html('');
                        $("#stripad").html('');
                        $("#mrec1").html('');
                        $("#mrec2").html('');
                        $("#mrec3").html('');
                        $("#buttonad1").html('');
                        $("#buttonad2").html('');
                        $("#bottomad").html('');
                        
                        $("#mtop").html('<a href="http://pubads.g.doubleclick.net/gampad/jump?iu=/1019353/spot_leaderboard_top_<?php echo $adid; ?>&sz=728x90&c=<?php echo $rand; ?>"><img src="http://pubads.g.doubleclick.net/gampad/ad?iu=/1019353/spot_leaderboard_top_<?php echo $adid; ?>&sz=728x90&c=<?php echo $rand; ?>" /></a>');
                        $("#mrec4").html('<a href="http://pubads.g.doubleclick.net/gampad/jump?iu=/1019353/spot_medium_rectangle01_<?php echo $adid; ?>&sz=300x250&c=<?php echo $rand; ?>"><img src="http://pubads.g.doubleclick.net/gampad/ad?iu=/1019353/spot_medium_rectangle05_<?php echo $adid; ?>&sz=300x250&c=<?php echo $rand; ?>" /></a>');
                        $("#mrec5").html('<a href="http://pubads.g.doubleclick.net/gampad/jump?iu=/1019353/spot_medium_rectangle02_<?php echo $adid; ?>&sz=300x250&c=<?php echo $rand; ?>"><img src="http://pubads.g.doubleclick.net/gampad/ad?iu=/1019353/spot_medium_rectangle06_<?php echo $adid; ?>&sz=300x250&c=<?php echo $rand; ?>" /></a>');
                        $("#mrec6").html('<a href="http://pubads.g.doubleclick.net/gampad/jump?iu=/1019353/spot_medium_rectangle03_<?php echo $adid; ?>&sz=300x250&c=<?php echo $rand; ?>"><img src="http://pubads.g.doubleclick.net/gampad/ad?iu=/1019353/spot_medium_rectangle07_<?php echo $adid; ?>&sz=300x250&c=<?php echo $rand; ?>" /></a>');
                        $("#mbottom").html('<a href="http://pubads.g.doubleclick.net/gampad/jump?iu=/1019353/spot_leaderboard_bottom_<?php echo $adid; ?>&sz=728x90&c=<?php echo $rand; ?>"><img src="http://pubads.g.doubleclick.net/gampad/ad?iu=/1019353/spot_leaderboard_bottom_<?php echo $adid; ?>&sz=728x90&c=<?php echo $rand; ?>" /></a>');
                        
                        $("#ptop").html('');
                        $("#pbottom").html('');
                    }
                    else if ($(window).width() <= 630) {  	
                        $("#billboard").html('');					
                        $("#superlboard").html('');
                        $("#stripad").html('');
                        $("#mrec1").html('');
                        $("#mrec2").html('');
                        $("#mrec3").html('');
                        $("#buttonad1").html('');
                        $("#buttonad2").html('');
                        $("#bottomad").html('');
                        
                        $("#mtop").html('');
                        $("#mrec4").html('');
                        $("#mrec5").html('');
                        $("#mrec6").html('');
                        $("#mbottom").html('');
                        
                        $("#ptop").html('<a href="http://pubads.g.doubleclick.net/gampad/jump?iu=/1019353/spot_leaderboard_top_mobile_<?php echo $adid; ?>&sz=320x50&c=<?php echo $rand; ?>"><img src="http://pubads.g.doubleclick.net/gampad/ad?iu=/1019353/spot_leaderboard_top_mobile_<?php echo $adid; ?>&sz=320x50&c=<?php echo $rand; ?>" /></a>');
                        $("#pbottom").html('<a href="http://pubads.g.doubleclick.net/gampad/jump?iu=/1019353/spot_leaderboard_bottom_mobile_<?php echo $adid; ?>&sz=320x50&c=<?php echo $rand; ?>"><img src="http://pubads.g.doubleclick.net/gampad/ad?iu=/1019353/spot_leaderboard_bottom_mobile_<?php echo $adid; ?>&sz=320x50&c=<?php echo $rand; ?>" /></a>');
                    }				
                }
                
                window.onorientationchange = readDeviceOrientation;
            </script>