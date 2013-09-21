<?php

ini_set('display_errors', true);
ini_set('error_reporting', E_ALL);

require_once("lib/vendor/pfj/ActiveRecord/Database.php");
require_once("lib/vendor/pfj/ActiveRecord/Table.php");
require_once("lib/vendor/pfj/ActiveRecord/Row.php");

require_once("src/PeterFrankJohnson/Response.php");

$response = new Response();