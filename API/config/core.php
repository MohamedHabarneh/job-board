<?php
// show error reporting
error_reporting(E_ALL);

// set your default time-zone
date_default_timezone_set('America/Los_Angeles');

// variables used for jwt
$key = "santana";
$issued_at = time();
$expiration_time = $issued_at + (60 * 60); // valid for 1 hour
$issuer = "http://localhost/api";