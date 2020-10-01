<?php
// include FormValidator class
include 'SPAF_FormValidator.class.php';

// start session
session_start();

// instantiate the object
$spaf_obj = new SPAF_FormValidator();

// stream image
$spaf_obj->streamImage();
?>
