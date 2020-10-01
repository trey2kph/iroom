<?php
/* ----------------------------------------------------------------------------
  SPAF_FormValidator.class.php
 ------------------------------------------------------------------------------
  created  : 2005-12-14
  revision : 001
  status   : functional
  author   : martynas@solmetra.com
 ------------------------------------------------------------------------------
  Form validation class
 --------------------------------------------------------------------------- */
 
class SPAF_FormValidator {
  // {{{
  // !!! EDITABLE CONFIGURATION ===============================================
  var $lib_dir      = 'lib/';
  var $backgrounds  = array('10.png');
  var $fonts        = array('arial.ttf');
//  var $fonts        = array('arial.ttf','vindicti.ttf', 'amplitud.ttf', 'bandless.ttf', 
//                            'elsewher.ttf', 'fullcomp.ttf', 'handmeds.ttf', 
//                            'imposs.ttf', 'mysteron.ttf', 'pneuwide.ttf','rambling.ttf');
  var $font_sizes   = array(17, 15, 16);
  var $colors       = array(
    array(0, 0, 0),
    array(20, 20, 20)
  );
  var $shadow_color = array(255, 255, 255);
  var $char_num     = 5;
  var $chars        = array('A', 'C', 'D', 'E', 'F', 'H', 'J', 'K',  'M', 
                            'N', 'P', 'R', 'S', 'T', 'Y', '3', '4', '6', 
                            '7', '9');
  // !!! DO NOT CHANGE ANYTHING BELOW THIS LINE ===============================
  // }}}
  // {{{
  var $img_func_suffix = 'png';
  // }}}
  // {{{
  function SPAF_FormValidator () {
    // dummy constructor
  }
  // }}}
  // {{{
  function setLibDir ($dir) {
    $this->lib_dir = $dir;
  }
  // }}}
  // {{{
  function tagUser () {
    // set session variable
    // ATTENTION! Session must be already started with session_start()
    $_SESSION['spaf_form_validator_tag'] = $this->getRandomString($this->char_num);
    return true;
  }
  // }}}
  // {{{
//  function getUserTag () {
//    if (!isset($_SESSION['spaf_form_validator_tag']) || isset($_GET['regen'])) {
//      // user is not tagged - issue new tag
//      $this->tagUser();
//    }
//    return $_SESSION['spaf_form_validator_tag'];
//  }
  function getUserTag () {
//    if (!isset($_SESSION['spaf_form_validator_tag']) || isset($_GET['regen'])) {
//      // user is not tagged - issue new tag
//      $this->tagUser();
//    }
    return $_GET['rand'];
  }
  // }}}
  // {{{
  function validRequest ($req) {
    return strtolower($this->getUserTag()) == strtolower($req)
      ? true 
      : false;
  }
  // }}}
  // {{{
  function getRandomString ($chars = 5) {
    $str = '';
    $cnt = sizeof($this->chars);
    for ($i = 0; $i < $chars; $i++) {
      $str .= $this->chars[mt_rand(0, $cnt-1)];
    }
    return $str;
  }
  // }}}
  // {{{
  function streamImage () {
    // select random background
    $background = $this->backgrounds[mt_rand(0, sizeof($this->backgrounds)-1)];
    
    // set proper image format according to selected background image
    $this->setImageFormat($background);
    
    // create image resource
    $function = "imagecreatefrom".$this->img_func_suffix;
    $image = $function($this->lib_dir.$background);
    
    // create color resources
    $colors = array();
    $color_count = sizeof($this->colors);
    for ($i = 0; $i < $color_count; $i++) {
      $colors[] = imagecolorallocate($image, 
                                     $this->colors[$i][0], 
                                     $this->colors[$i][1], 
                                     $this->colors[$i][2]);
    }
    $shadow = imagecolorallocate($image, 
                                 $this->shadow_color[0], 
                                 $this->shadow_color[1], 
                                 $this->shadow_color[2]);
    
    // get secret word from session
    $word = $this->getUserTag();
    // calculate geometrics
    $width  = imagesx($image);
    $height = imagesy($image);
    $lenght = strlen($word);
    $step   = floor(($width / $lenght) * 0.9);
    
    // put letters on background
    for ($i = 0; $i < $lenght; $i++) {
      // get current character
      $char = substr($word, $i, 1);
      
      // randomize letter display characteristics
      $font_size = $this->font_sizes[mt_rand(0, sizeof($this->font_sizes)-1)];
      $data = array(
        'size'  => $font_size,
        'angle' => mt_rand(-10, 10),
        'x'     => $step * $i + 5,
        'y'     => mt_rand($font_size+5, $height-5 ),
        'color' => $colors[mt_rand(0, $color_count-1)],
        'font'  => $this->lib_dir.$this->fonts[mt_rand(0, sizeof($this->fonts)-1)]
      );
      
      // put a shadow
      imagettftext($image, 
                   $font_size, 
                   $data['angle'], 
                   $data['x'] + 1, 
                   $data['y'] + 1, 
                   $shadow, 
                   $data['font'], 
                   $char);
                   
      // put a letter
      imagettftext($image, 
                   $font_size, 
                   $data['angle'], 
                   $data['x'], 
                   $data['y'], 
                   $data['color'], 
                   $data['font'], 
                   $char);
    }
    
    // stream image to browser
    $function = "image".$this->img_func_suffix;
    header('Content-Type: image/'.$this->img_func_suffix);
    $function($image);
    imagedestroy($image);
    
    return true;
  } 
  // }}}
  // {{{
  function setImageFormat ($file) {
    // get extention
    $arr = explode('.', $file);
    $ext = strtolower($arr[sizeof($arr) - 1]);
    
    // set appropriate formats
    switch ($ext) {
      case 'gif':
      case 'png':
      case 'jpeg':
        $this->img_func_suffix = $ext;
        break;
      case 'jpg':
        $this->img_func_suffix = 'jpeg';
        break;
      default:
        // critical error - unsupported format
        die('ERROR: Unsupported format!');
        break;
    }
  }
  // }}}
  // {{{
  function destroy () {
    unset($_SESSION['spaf_form_validator_tag']);
  }
  // }}}
}   
?>
