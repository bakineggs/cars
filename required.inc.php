<?php
require_once 'secrets.inc.php'; // define()'s DB_PASSWORD, RECPATCHA_PRIVATE_KEY, RECAPTCHA_PUBLIC_KEY

pg_connect('dbname=cars user=cars password=' . DB_PASSWORD);

function h($val) { return htmlentities($val, ENT_QUOTES); }
function pesc($val) { return pg_escape_string($val); }

require 'car.inc.php';
require 'recaptchalib.php';
?>
