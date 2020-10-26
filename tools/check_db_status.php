#!/usr/bin/env php
<?php

error_reporting(0);

$dbhost = $argv[1];
$dbuser = $argv[2];
$dbpass = $argv[3];
$dbname = $argv[4];

try {
    $myPDO = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
} catch (Exception $e) {
    exit(1);
}
