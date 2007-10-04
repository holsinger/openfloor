<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class ApiData {

    var $error = false;
    var $debugLevel = 0;
    var $zip = 0;
    var $state = '';
    var $city = '';
    var $county = '';
    var $districtsArray = array();
    var $cacheData = true;
    
    function __construct ($debug=0) {
    	$this->debugLevel = $debug;
		$this->CI=& get_instance();
    }
    
    //sets
    
    
    //gets
    /**
     * this function returns the data in the requested format
     * 
     * @param string outputType (html|xml|...)
     */
    function getData ($outputType = 'html') {
    	//get an array of rep ids and make sure we have the state
    	$repIdArray = array();
    	$senIdArray = array();
    	if ($this->zip) {
    		//get data starting with zip
    		$this->getDistrictsFromZip ();
    		if (!$this->state) $this->state = $this->getStateFromZip ();
    		foreach ($this->districtsArray as $key => $value) array_push($repIdArray,$this->getRepFromDistrict ($value));    		
    	} else if ($this->city && $this->state) {
    		$repIdArray = $this->getRepsFromCityState ();    		
    	}
    	//now get state senitors
    	$senIdArray = $this->getSensFromState (); 
    
    	$out =  "<h2>Senators</h2>";
    	foreach ($senIdArray as $id) $out .= $this->buildHTMLLink ($id);
    	$out .= '<div style="clear:both;">';
    	$out .= "<h2>Representatives</h2>";
    	//vardump ($repIdArray);
    	foreach ($repIdArray as $id) $out .= $this->buildHTMLLink ($id);
    	$out .= '<div style="clear:both;">';
    	return $out;
    }    
    
    /**
     * this function will return html to diplay
     * 
     * @param string id a sunlight id
     */
    function buildHTMLLink ($id) {
    	$resultsArray = $this->getPersonalInfo ($id);
    	  //exit(var_dump($resultsArray));  	
    	
    	  $html ="";
    	  $html .= "<div class='who_can' style='float:left;padding:5px;'>";
    	  $html .= "<img src='http://sunlightlabs.com/widgets/popuppoliticians/resources/images/{$resultsArray['photo']}'>";
    	  $html .= "<br />";
    	  $html .= "<a href=".$resultsArray['URL']." target='_blank'>".$resultsArray['firstname']." ".$resultsArray['lastname']."</a>";
    	  $html .= "<br />";
    	  $html .= anchor ('/your_government/politician/'.$id,"What is ".$resultsArray['firstname']." ".$resultsArray['lastname']."up to?");
    	  $html .= "</div>";
    	  return $html;
    }
    
    function whatUp ($id) {
    		$html = '';
    		$resultsArray = $this->getPersonalInfo ($id);
    		$html .= "<h3>{$resultsArray['firstname']} {$resultsArray['lastname']}</h3>";
    		$html .= "<img src='http://sunlightlabs.com/widgets/popuppoliticians/resources/images/{$resultsArray['photo']}'>";
    	  $html .= "<br />";
    		$html .= "<h3>Videos</h3>";
    	  $html .= '<!-- ++Begin Video Bar Wizard Generated Code++ -->

  <div id="videoBar-player">
    <span style="color:#676767;font-size:11px;margin:10px;padding:4px;">Loading...</span>
  </div>
  <div id="videoBar-bar">
    <span style="color:#676767;font-size:11px;margin:10px;padding:4px;">Loading...</span>
  </div>
  <script src="http://www.google.com/uds/api?file=uds.js&v=1.0&source=uds-vbw&key=ABQIAAAAkKcqFPODFw9EgKwKbb0vmxQMMgp4bRk8oDwCMuUVC3eAkH6yhxRey5JriXQU4hISBErCZHOSAAHL4w"
    type="text/javascript"></script>
  <style type="text/css">
    @import url("http://www.google.com/uds/css/gsearch.css");
  </style>

  <!-- Video Bar Code and Stylesheet -->
  <script type="text/javascript">
    window._uds_vbw_donotrepair = true;
  </script>
  <script src="http://www.google.com/uds/solutions/videobar/gsvideobar.js?mode=new"
    type="text/javascript"></script>
  <style type="text/css">
    @import url("http://www.google.com/uds/solutions/videobar/gsvideobar.css");
  </style>

  <style type="text/css">
    #videoBar-player .playerInnerBox_gsvb .player_gsvb {
      width : 320px;
      height : 260px;
    }
  </style>
  <script type="text/javascript">
    function LoadVideoBar() {

    var videoBar;
    var options = {
        largeResultSet : !true,
        horizontal : true,
        autoExecuteList : {
          cycleTime : GSvideoBar.CYCLE_TIME_MEDIUM,
          cycleMode : GSvideoBar.CYCLE_MODE_RANDOM,
          executeList : ["'.$resultsArray['firstname'].' '.$resultsArray['lastname'].'"]
        }
      }

    videoBar = new GSvideoBar(document.getElementById("videoBar-bar"),
                              document.getElementById("videoBar-player"),
                              options);
    }
    // arrange for this function to be called during body.onload
    // event processing
    GSearch.setOnLoadCallback(LoadVideoBar);
  </script>
<!-- ++End Video Bar Wizard Generated Code++ -->';
    	  
    	  $html .= '<h3>Blog Posts</h3>';
    	  $html .= '<!-- ++Begin Blog Bar Wizard Generated Code++ -->
  <!--
  // Created with a Google AJAX Search Wizard
  // http://code.google.com/apis/ajaxsearch/wizards.html
  -->

  <!--
  // The Following div element will end up holding the actual blogbar.
  // You can place this anywhere on your page.
  -->
  <div id="blogBar-bar">
    <span style="color:#676767;font-size:11px;margin:10px;padding:4px;">Loading...</span>
  </div>

  <!-- Ajax Search Api and Stylesheet
  // Note: If you are already using the AJAX Search API, then do not include it
  //       or its stylesheet again
  //
  // The Key Embedded in the following script tag is designed to work with
  // the following site:
  // http://politic20.com
  -->
  <script src="http://www.google.com/uds/api?file=uds.js&v=1.0&source=uds-blbw&key=ABQIAAAAkKcqFPODFw9EgKwKbb0vmxQMMgp4bRk8oDwCMuUVC3eAkH6yhxRey5JriXQU4hISBErCZHOSAAHL4w"
    type="text/javascript"></script>
  <style type="text/css">
    @import url("http://www.google.com/uds/css/gsearch.css");
  </style>

  <!-- Blog Bar Code and Stylesheet -->
  <script src="http://www.google.com/uds/solutions/blogbar/gsblogbar.js?mode=new"
    type="text/javascript"></script>
  <style type="text/css">
    @import url("http://www.google.com/uds/solutions/blogbar/gsblogbar.css");
  </style>

  <script type="text/javascript">
    function LoadBlogBar() {
      var blogBar;
      var options = {
        largeResultSet : false,
        title : "Blogs",
        horizontal : true,
        orderBy : GSearch.ORDER_BY_DATE,
        autoExecuteList : {
          executeList : ["'.$resultsArray['firstname'].' '.$resultsArray['lastname'].'"]
        }
      }

      blogBar = new GSblogBar(document.getElementById("blogBar-bar"), options);
    }
    // arrange for this function to be called during body.onload
    // event processing
    GSearch.setOnLoadCallback(LoadBlogBar);
  </script>
<!-- ++End Blog Bar Wizard Generated Code++ -->';
    	  $html .= "<h3>Tracked Events</h3>";    		
    		$html .= "<script src='http://www.govtrack.us/embed/events.xpd?monitors=p:{$resultsArray["GovTrack_ID"]}&options=&count=8' type='text/javascript'/>";

    		$html .= "<h3>Votes</h3>";
				$html .= "<script src='http://www.govtrack.us/embed/events.xpd?monitors=pv:{$resultsArray["GovTrack_ID"]}&options=&count=8' type='text/javascript'/>";    		
    		
				return $html;
    }
    
		function getPersonalInfo ($id) {
			$resultsArray = $this->callAPI ('http://api.sunlightlabs.com/people.getPersonInfo.php?id='.$id,'getPersonInfo');
			return $resultsArray;
		}
		/**
     * 
     * this function calls the sunlight api and returns
     * the data as an array
     * @param string value possible zip value
     * @return array of districts
	 * @author James
	 *
	 */
    function getDistrictsFromZip ($value = false) {
			$resultsArray = array();
			//where we getting the zip from
			if ($value) $zip = $value;
			else $zip = $this->zip;
			//sunlight api url
			$url='http://api.sunlightlabs.com/places.getDistrictsFromZip.php?zip='.$zip;

			//parse results
			$resultsArray = $this->callAPI ($url,'getDistrictsFromZip');
			
			//set state
			$this->state = $resultsArray['districts'][0]['state'];
			//add to districts array
			foreach ($resultsArray['districts'] as $value) array_push($this->districtsArray,$value['district']);
			
			return $this->districtsArray;
	
	}
	
	/**
     * this function calls the sunlight api and returns
     * the data id
     * @param string value district number
     * @return array of representitives
	 * @author James
	 *
	 */
    function getRepFromDistrict ($value = false) {
			$resultsArray = array();
			//sunlight api url
			$url='http://api.sunlightlabs.com/people.reps.getRepFromDistrict.php?state='.$this->state.'&district='.$value;

			//parse results
			$resultsArray = $this->callAPI ($url,'getRepFromDistrict');
			//exit(var_dump($resultsArray));
						
			return $resultsArray['entity_id'];
	
	}
	
	/**
     * this function calls the sunlight api and returns
     * the data as an array
     * @param string value city string
     * @param string value2 state string
     * @return array of representitives
	 * @author James
	 *
	 */
    function getRepsFromCityState ($value = false,$value2=false) {
			$resultsArray = array();
			$returnArray = array();
			//where we getting the city state from
			if ($value) $city = $value;
			else $city = $this->city;
			if ($value2) $state = $value2;
			else $state = $this->state;
			//sunlight api url
			$url='http://api.sunlightlabs.com/people.reps.getRepsFromCityState.php?city='.$city.'&state='.$state;

			//parse results
			$resultsArray = $this->callAPI ($url,'getRepsFromCityState');
			//exit(var_dump($resultsArray));
						
			//set return array
			$returnArray = $resultsArray['entity_ids'];
			
			return $returnArray;
	
	}
	
	/**
     * this function calls the sunlight api and returns
     * the data as an array
     * @param string value state string
     * @return array of senators
	 * @author James
	 *
	 */
    function getSensFromState ($value = false) {
			$resultsArray = array();
			$returnArray = array();
			//where we getting the state from
			if ($value) $state = $value;
			else $state = $this->state;
			//sunlight api url
			$url='http://api.sunlightlabs.com/people.sens.getSensFromState.php?state='.$state;

			//parse results
			$resultsArray = $this->callAPI ($url,'getSensFromState');
			//exit(var_dump($resultsArray));
						
			//set return array
			$returnArray = $resultsArray['entity_ids'];
			
			return $returnArray;
	
    }
	
	/**
	 * this function will handle calling api and error checking
	 * 
	 * @param string url the url of the api call
	 * @param string debugName the name to pass as a debug title
	 * @return array associative array of results
	 * @author James Kleinschnitz
	 */
	 function callAPI ($url,$debugName='') {
	 	//get api contents decose with json to an array
		$cachedFileName = './system/cache/' . str_replace(array(':', '/', '?', '&'), '', substr($url, 28, strlen($url)));
	 	
		#TODO check if file past cache limit
	 	if (file_exists($cachedFileName)) {
			$resultsArray = json_decode(file_get_contents($cachedFileName),true); 
	 	} else {
			$contents = curl_get_contents($url);
	 		$resultsArray = json_decode($contents,true);
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
	 	//do some kind of error checking here and return false		
		
		if ( $this->debugLevel > 0 ) { 
			echo "<b style='color:#FF0000;'>".$debugName.":</b><br />";
			foreach ($resultsArray as $key => $val) {
				if ( is_array($val) ) {
					echo $key."<br />";
					foreach ($val as $index => $value) echo "  $index => $value <br />";
				} else  echo "$key => $val <br />";
			}
			echo "<br />";
		}
		
		return $resultsArray;
	 }
    /**
     * this function return and array of districts based on a city state pair
     * 
     * @param string city a specific city value
     * @param string state a specific state value
     * @return array of districts
     * @author James Kleinschnitz
     */
     /*
    function getDistrictsFromCityState ($city = false, $state = false) {
    	$zipArray = getZipsFromCityState ();
  		//build the district array
  		foreach ($zipArray as $key => $value) array_merge($this->districtsArray,$this->getDistrictsFromZip ($value));
    }*/

	function getAllNames()
	{
		$cachedPoliticians = './system/cache/politicians';
		$politicians = array('' => '');
		
		if (file_exists($cachedPoliticians)) {
			$politicians = unserialize(file_get_contents($cachedPoliticians));
		} else {
			$resultsArray = array();
			$parties = array('D', 'R', 'I');
		
			foreach ($parties as $v) {
				$url = "http://api.sunlightlabs.com/people.getDataCondition.php?party=$v";
				$array = $this->callAPI ($url,'getDataCondition');
			
				$resultsArray = array_merge($resultsArray, $array['entity_ids']);
			}			
		
			foreach ($resultsArray as $k => $v) {
				
				$url = "http://api.sunlightlabs.com/people.getPersonInfo.php?id=".$v;
				$result = $this->callAPI ($url,'getPersonInfo');
				#$url = "http://api.sunlightlabs.com/people.getDataItem.php?id=$v&code=firstname";
				#$result = $this->callAPI ($url,'getDataItem');
				$firstname = $result['firstname'];
			
				//$url = "http://api.sunlightlabs.com/people.getDataItem.php?id=$v&code=lastname";
				//$result = $this->callAPI ($url,'getDataItem');
				$lastname = $result['lastname'];
				
				$entity_id = $result['entity_id'];
				$politicians[$entity_id] = "$lastname, $firstname";
			}
			
			asort($politicians);
			
			if ($file = fopen($cachedPoliticians, 'wb')) {
	 			fwrite($file, serialize($politicians));
	 			fclose($file);
 			}			
		}
		return $politicians;
	}
}

?>