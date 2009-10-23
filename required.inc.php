<?php
function h($val) { return htmlentities($val, ENT_QUOTES); }
require 'car.inc.php';
require 'db.inc.php';
$RECAPTCHA_PUBLIC_KEY = 'some_public_key';
$RECAPTCHA_PRIVATE_KEY = 'some_private_key';
?>
