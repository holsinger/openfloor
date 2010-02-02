<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class YouTubeApi {
	
	var $dev_id = 'GIW50NyH9tE';
	var $cacheData = true;
	
	function __construct() {
		
		//we need to get access to the CI object
		$this->CI=& get_instance();
    
		$this->CI->load->library('xmlrpc');
		$this->CI->load->library('xmlrpcs');
	}
	
	public function videoThumb ($video_id = '') 
	{
		
		$videoObj = &$this->getVideoDetails($video_id);
		//var_dump($videoObj);
		return $videoObj->video_details->thumbnail_url;
	}
	
	function getVideoDetails ($video_id = '') 
	{
		$error = '';
		//check for a cached file
		$cachedFileName = './system/cache/youtubexml_' . $video_id;
		$url = "http://www.youtube.com/api2_rest?method=youtube.videos.get_details&dev_id={$this->dev_id}&video_id={$video_id}"; 
	 	
		#TODO check if file past cache limit
	 	if (file_exists($cachedFileName)) {
			$resultObj = simplexml_load_file($cachedFileName); 
	 	} else {
	 		$contents = curl_get_contents($url);
	 		$resultObj = simplexml_load_string($contents);
	 		//if we want to cache the data write the data to a file
	 		if ($this->cacheData) {
	 			// delete the file if it already exists
	 			if (file_exists($cachedFileName)) unlink($cachedFileName);

	 			// recreate file and recache data
	 			if ($file = fopen($cachedFileName, 'wb')) {
		 			fwrite($file, $contents);
		 			fclose($file);
	 			}
	 		}	
	 		
	 	}
		
		return $resultObj;
		
	}
	
	function getVideoDetailsArray ($video_id = '') 
	{
		$videoObj = $this->getVideoDetails ($video_id);
		if (isset($videoObj->error)) {
			$toArray = $videoObj->error;
			return (array) $toArray;
		} else {				
			$toArray = $videoObj->video_details;
			return (array) $toArray;
		}
	}
		
}

/*
 * } else {
			$this->CI->xmlrpc->server('http://www.youtube.com/api2_rest', 80);
			$this->CI->xmlrpc->method('youtube.videos.get_details');
			$this->CI->xmlrpc->set_debug(TRUE);
			$request = array(
								'dev_id', 'GIW50NyH9tE',
								'video_id', $video_id
								);
			$this->CI->xmlrpc->request($request);
			
			if ( ! $this->CI->xmlrpc->send_request())
			{
			    $error = $this->CI->xmlrpc->display_error();
			    exit($error);
			}		
			else {
				$response = $this->CI->xmlrpc->display_response();
				$resultObj = simplexml_load_string($response);	
				
				// delete the file if it already exists
	 			if (file_exists($cachedFileName)) unlink($cachedFileName);
	
	 			// recreate file and recache data
	 			if ($file = fopen($cachedFileName, 'wb')) {
		 			fwrite($file, $response);
		 			fclose($file);
	 			}
			}
*/
?>