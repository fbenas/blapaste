#!/usr/bin/php
<?php

$stdin = fopen("php://stdin", "r");

$paste = "";
while (false !== ($line = fgets($stdin))) {
	$paste .= $line;
}
$url = "http://p.of.je/submit.php";
$myvars = "paste=" . $paste;

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $myvars);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec($ch);

$response = explode("\n", $response);
foreach ($response as $line) {
	if (strpos($line, "Location") !== false) {
		echo $line . "\n";
		exit;
	}
}
echo "failed\n";
