<?php

    $setting = $main->get_set(0);
    $expirydate = strtotime(date("Y-m-d 00:00:00"));

    define("ANNOUNCEMENT", $setting[0]['set_annexpire'] > $expirydate ? trim($setting[0]['set_announce']) : "");
    define("MAILFOOT", $setting[0]['set_mailfoot'] ? $setting[0]['set_mailfoot'] : "");
    define("NUM_ROWS", $setting[0]['set_numrows'] ? $setting[0]['set_numrows'] : 20); // the number of records on each page

?>