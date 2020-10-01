<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<?php $adid = $_GET['adid']; ?>

<script type='text/javascript'>
(function() {
var useSSL = 'https:' == document.location.protocol;
var src = (useSSL ? 'https:' : 'http:') +
'//www.googletagservices.com/tag/js/gpt.js';
document.write('<scr' + 'ipt src="' + src + '"></scr' + 'ipt>');
})();
</script>

<script type='text/javascript'>

googletag.defineSlot('/1019353/spot_super_leaderboard_gallery_eat_drink', [970, 90], 'div-gpt-ad-1372220318117-153').addService(googletag.pubads());
googletag.defineSlot('/1019353/spot_super_leaderboard_gallery_entertainment', [970, 90], 'div-gpt-ad-1372220318117-154').addService(googletag.pubads());
googletag.defineSlot('/1019353/spot_super_leaderboard_gallery_news_features', [970, 90], 'div-gpt-ad-1372220318117-155').addService(googletag.pubads());
googletag.defineSlot('/1019353/spot_super_leaderboard_gallery_people_parties', [970, 90], 'div-gpt-ad-1372220318117-156').addService(googletag.pubads());
googletag.defineSlot('/1019353/spot_super_leaderboard_gallery_shopping_services', [970, 90], 'div-gpt-ad-1372220318117-157').addService(googletag.pubads());
googletag.defineSlot('/1019353/spot_super_leaderboard_gallery_things_to_do', [970, 90], 'div-gpt-ad-1372220318117-158').addService(googletag.pubads());

googletag.pubads().enableSyncRendering();
googletag.pubads().enableSingleRequest();
googletag.enableServices();
</script>

</head>

<body style="margin: 0px;">	

	<?php 
		if ($adid = "news_features") $gtop = 155;
		elseif ($adid = "eat_drink") $gtop = 153;
		elseif ($adid = "entertainment") $gtop = 154;
		elseif ($adid = "people_parties") $gtop = 156;
		elseif ($adid = "shopping_services") $gtop = 157;
		elseif ($adid = "things_to_do") $gtop = 155;
		else $gtop = 153;
	?>

	<div id="div-gpt-ad-1372220318117-<?php echo $gtop; ?>" style="width: 970px; height: 90px; text-align: center;">
	  <script type='text/javascript'>
        googletag.display('div-gpt-ad-1372220318117-<?php echo $gtop; ?>');
      </script>
    </div>

</body>
</html>