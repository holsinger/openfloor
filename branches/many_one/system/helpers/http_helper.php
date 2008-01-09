<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

function curl_get_contents($url)
{
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$data = curl_exec($ch);
	curl_close($ch);
	
	return $data;
}