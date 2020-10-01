<?php 
ob_start();
session_start();

//Select random background image
$bgurl = rand(1, 3);
$im = "images/bg".$bgurl.".png";

//Generate the random string
$chars = array("a","A","b","B","c","C","d","D","e","E","f","F","g","G","h","H","i","I","j","J",
			   "k","K","l","L","m","M","n","N","o","O","p","P","q","Q","r","R","s","S","t","T",
			   "u","U","v","V","w","W","x","X","y","Y","z","Z","1","2","3","4","5","6","7","8","9");
$textstr = '';
for ($i = 0, $length = 8; $i < $length; $i++) {
   $textstr .= $chars[rand(0, count($chars) - 1)];
}

// SET SESSION VARIABLE
$hashtext = md5($textstr);
$tmpname = $hashtext.'.png';
$_SESSION['strSec'] = $hashtext;
$_SESSION['textstr'] = $textstr;


# prep font
$font = "arial.ttf";
$size = rand(24, 36);
$hexValues = array('0','1','2','3','4');
$numHex = count($hexValues);
$color = sprintf("#%02X%02X%02X", rand(0,160), rand(0,160), rand(0,160));
for ($i = 0; $i < 6; $i++) {
//	$color .= $hexValues[rand(0, $numHex-1)];
}
# image magick text gravities that we wanna use to position the text
$gravities = array('West', 'Center', 'East');
$gravity = $gravities[rand(0, count($gravities)-1)];

# give the image a slight angle
$angle = rand(-2, 2);
$swirl = 15;
$wave = rand(-2, 2);
$blur = rand(-2, 2);

# prepare our image magick command
$cmd  = '/usr/local/bin/convert';
$cmd .= ' -font "'.$font.'"';
$cmd .= ' -fill "#'.$color.'"';
$cmd .= ' -pointsize '.$size;
$cmd .= ' -gravity "'.$gravity.'"';
$cmd .= ' -draw \'text 0,0 "'.$textstr.'"\'';
$cmd .= ' -rotate '.$angle;
$cmd .= ' -swirl '.$swirl;
$cmd .= ' -wave '.$wave.'x80';
$cmd .= ' ./'.$im.' ./images/tmp/'.$tmpname;

exec($cmd);

// Output PNG Image
header("Content-Type: image/png");
print fread(fopen('./images/tmp/'.$tmpname, 'r'), filesize('./images/tmp/'.$tmpname));

# since we've displayed the image lets go ahead and delete the actual file
exec('rm -f ./images/tmp/'.$tmpname);

ob_end_flush();
?>