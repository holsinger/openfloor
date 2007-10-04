<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Time_lib
*/
class Time_lib
{
	public function getDecay($timestamp)
	{
		$time_array = explode(', ', timespan(strtotime($timestamp)));
		return $time_array[0];
	}
}