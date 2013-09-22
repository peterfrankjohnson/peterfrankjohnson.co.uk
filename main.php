<?php

include('lib/vendor/pfj/ActiveRecord/Database.class.php');
include('lib/vendor/pfj/ActiveRecord/Table.class.php');
//include('lib/vendor/pfj/ActiveRecord/Test.class.php');
include('src/PeterFrankJohnson/Response.php');

$database = new Database();
$database->connect();
$database->selectDb('test');

//$test = new Test($database);
$response = new Response($database);

echo $response->getId();
$database->close();
