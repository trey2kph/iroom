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

googletag.defineSlot('/1019353/spot_medium_rectangle_gallery_eat_drink', [300, 250], 'div-gpt-ad-1372220318117-125').addService(googletag.pubads());
googletag.defineSlot('/1019353/spot_medium_rectangle_gallery_entertainment', [300, 250], 'div-gpt-ad-1372220318117-126').addService(googletag.pubads());
googletag.defineSlot('/1019353/spot_medium_rectangle_gallery_news_features', [300, 250], 'div-gpt-ad-1372220318117-127').addService(googletag.pubads());
googletag.defineSlot('/1019353/spot_medium_rectangle_gallery_people_parties', [300, 250], 'div-gpt-ad-1372220318117-128').addService(googletag.pubads());
googletag.defineSlot('/1019353/spot_medium_rectangle_gallery_shopping_services', [300, 250], 'div-gpt-ad-1372220318117-129').addService(googletag.pubads());
googletag.defineSlot('/1019353/spot_medium_rectangle_gallery_things_to_do', [300, 250], 'div-gpt-ad-1372220318117-130').addService(googletag.pubads());

googletag.pubads().enableSyncRendering();
googletag.pubads().enableSingleRequest();
googletag.enableServices();
</script>

</head>

<body style="margin: 0px;">	

	<?php 
		if ($adid = "news_features") $gmrec = 127;
		elseif ($adid = "eat_drink") $gmrec = 125;
		elseif ($adid = "entertainment") $gmrec = 126;
		elseif ($adid = "people_parties") $gmrec = 128;
		elseif ($adid = "shopping_services") $gmrec = 129;
		elseif ($adid = "things_to_do") $gmrec = 130;
		else $gmrec = 125;
	?>

	<div id="div-gpt-ad-1372220318117-<?php echo $gmrec; ?>" style="width: 300px; height: 250px;">
	  <script type='text/javascript'>
        googletag.display('div-gpt-ad-1372220318117-<?php echo $gmrec; ?>');
      </script>
    </div>

</body>
</html>