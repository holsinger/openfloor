

var username = '';
var site_url = '';
var event_name;
var sort;
var tag = '';
var offset = 0;
var ajaxOn = true;

function init() {
	
	
}

//init obj
if(typeof ajaxVideo === "undefined" || !ajaxVideo) {
	var ajaxVideo = {
		savingMsg: "Saving ..."
	};
}

//init vars
ajaxVideo.supported = true; // supported on current page and by browser
ajaxVideo.inprogress = false; // ajax request in progress
ajaxVideo.timeoutID = null; 
ajaxVideo.videoID = '';

//main call function
/**
 * this function is the main function that should be called
 * 
 * @param string id the you tube video id
 */
ajaxVideo.ajaxCall = function(id) {
	if(!ajaxVideo.supported || ajaxVideo.inprogress) {
		return;
	}

	ajaxVideo.inprogress = true;
	ajaxVideo.videoID = id;


	//make the AJAX Calls
	new Ajax.Request(site_url+'', {
	  method:'post',
	  onSuccess: function(transport){
	     var json = transport.responseText.evalJSON();
	   }
	});
	// if the request isn't done in 20 seconds, allow user to try again
	ajaxVideo.timeoutID = window.setTimeout(function() { ajaxVideo.inprogress = false; }, 20000);
	return;
};
/**
 * this function will get the details of a youtube video via the video id
 * 
 * @param string id the
 */
ajaxVideo.youTubeVideoDetails = function(id) {
	if(!ajaxVideo.supported || ajaxVideo.inprogress) {
		alert('busy');
		return;
	}

	ajaxVideo.inprogress = true;
	//see if we have a video id
	ajaxVideo.videoID = ajaxVideo.getVideoID(id);

	//do some sexy time
	$('videoNext').innerHTML= '<br />Loading..<br />';
	$('errorArea').innerHTML = ' ';
	
	//make the AJAX Calls
	new Ajax.Request(site_url+'/video/youTubeAjax/', {
	  method:'post',	  
  	parameters: {video_id: ajaxVideo.videoID},
	  onSuccess: function(transport){	   	  	 
	     var json = transport.responseText; 
	     var jsonObj = eval("("+json+")");
	     if (jsonObj.code) {
	     	 $('errorArea').innerHTML = jsonObj.description;
	     	 new Effect.Shake ('errorArea');
	     	 var my_input = document.createElement('input');

				 Element.extend(my_input);
				 my_input.id='videoDetailsButton';
				 my_input.type='button';
				 my_input.value='Next >';
				 my_input.addClassName('button');
	     	 my_input.show();
				
				 $('videoNext').innerHTML = '';
				 // insert it in the document
				 $('videoNext').appendChild(my_input);
				 Event.observe($('videoDetailsButton'),'click',function(){ajaxVideo.youTubeVideoDetails($F('youtube'))});
	     	 ajaxVideo.inprogress = false;
	     	 return;
	     }
	     $('youtube').value = ajaxVideo.videoID;
	     Element.extend($('videoNext')).hide();
	     new Effect.BlindDown ('videoDetails'); 
			 
	     $('video').value = jsonObj.title;
	     var desc = jsonObj.description;
	     $('desc').value = desc.substring(0,250);
	     $('thumbnail').value = jsonObj.thumbnail_url;
	     var tags = jsonObj.tags;
	     //$('tags').value = tags.replace(/ /g,', ');
	     $('tags').value = tags;	     
	   }
	});
	return;
};

ajaxVideo.playYouTubeVideo = function(id) {
	if(!ajaxVideo.supported) return;
		
		var vid_element = $('ytvid_'+id);
		//console.log(id);
		vid_element.innerHTML = '<embed src="http://www.youtube.com/v/'+id+'&autoplay=1" type="application/x-shockwave-flash" wmode="transparent" width="325" height="250"></embed>';
}

/**
* this fucntion get the video id from some youtube code
*
*/
ajaxVideo.youTubeVideoID = function() {
	if(!ajaxVideo.supported) return;
		
		var code = $F('youtube_code');
		var video_id = ajaxVideo.getVideoID(code);
		ajaxVideo.youTubeVideoDetails(video_id);
		hideBox('hijax');	
}

ajaxVideo.getVideoID = function(code) {
	if(!ajaxVideo.supported) return;
	
		var array = code.split('/v/');
		if (array[1]) {
			array = array[1].split('"');
			var video_id = array[0];		
		} else {
			array = code.split('?v=');
			if (array[1]) var video_id = array[1];
			else var video_id = code;
		}
		//console.log ('vid->'+video_id);
		return video_id;
	
}

//init obj
if(typeof queueUpdater === "undefined" || !queueUpdater) {
	var queueUpdater = {
		savingMsg: "Saving ..."
	};
}

queueUpdater.updateQueue = function() {
	queueUpdater.updaterObject = new Ajax.PeriodicalUpdater('queue', site_url + '/forums/ajQueueUpdater/' + event_name + '/' + sort + '/' + offset + '/' + tag, {
	  frequency: 10
	});
	
	//new Ajax.PeriodicalUpdater('timer', site_url + '/forums/createTimerHTML/' + event_name, {frequency:10});
}

queueUpdater.updateQueueOnce = function() {
	
	new Ajax.Updater('queue', site_url + '/forums/ajQueueUpdater/' + event_name + '/' + sort + '/' + offset + '/' + tag);
	//new Effect.SlideDown ('queue');
}


queueUpdater.vote = function(url,id) {	
	//new Effect.DropOut ('queue');
	if (username.length <= 0) {
		showBox('login');
		return;
	}
	new Effect.Opacity (id,{duration:.5, from:1.0, to:0.7});
	new Ajax.Request(url, {
	  onSuccess: function(transport) {
		  queueUpdater.updateQueueOnce();
	  }
	});
}

queueUpdater.flagquestion = function(question_id, type_id, reporter_id) {
	url = site_url + '/flag/flagQuestion/' + question_id + '/' + type_id + '/' + reporter_id;
	if (username.length <= 0) {
		showBox('login');
		return;
	}
	new Ajax.Request(url, {
	  onSuccess: function(transport) {
		  queueUpdater.updateQueueOnce();
	  }
	});
}

queueUpdater.flaguser = function(user_id, type_id, reporter_id) {
	url = site_url + '/flag/flagUser/' + user_id + '/' + type_id + '/' + reporter_id;
	if (username.length <= 0) {
		showBox('login');
		return;
	}
	new Ajax.Request(url, {
	  onSuccess: function(transport) {
		  queueUpdater.updateQueueOnce();
	  }
	});
}

queueUpdater.toggleQueue = function () {
	if(ajaxOn) { ajaxOn=false; queueUpdater.updaterObject.stop(); }
	else if ($$('div[class=flag-question]', 'div[class=flag-user]').collect(function(n){ return n.getStyle('display'); }).indexOf('block') == -1) { ajaxOn=true; queueUpdater.updaterObject.start(); }
}

queueUpdater.toggleVisibility = function(element) {
	$$('div[class=flag-question]', 'div[class=flag-user]', 'div[class=watch_question]').without($(element)).invoke('setStyle', {display:'none'});
	style = $(element).getStyle('display') == 'none' ? {display:'block'} : {display:'none'};
	$(element).setStyle(style);
}

queueUpdater.watch = function(id) {
	exec = '<script type="text/javascript" charset="utf-8">Tips.tips.each(function(s){console.log(s)})</script>';
	
	url = site_url + 'forums/watch_answer/' + id;
	
	new Ajax.Request(url, {
		onSuccess: function(transport) {
			new Tip($('watch_' + id), exec + transport.responseText, {className: 'rp', title: 'Watch', showOn: 'click', hideOn: 'click', closeButton: true});
		}
	});
}

<!--
/*
function init ( )
{
	timeDisplay = document.createTextNode ( "" );
  document.getElementById("clock").appendChild ( timeDisplay );
}
*/
function updateClock ( )
{
  var currentTime = new Date ( );

  var currentHours = currentTime.getHours ( );
  var currentMinutes = currentTime.getMinutes ( );
  var currentSeconds = currentTime.getSeconds ( );

  // Pad the minutes and seconds with leading zeros, if required
  currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
  currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;

  // Choose either "AM" or "PM" as appropriate
  var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";

  // Convert the hours component to 12-hour format if needed
  currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;

  // Convert an hours component of "0" to "12"
  currentHours = ( currentHours == 0 ) ? 12 : currentHours;

  // Compose the string for display
  var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;

  // Update the time display
  document.getElementById("clock").firstChild.nodeValue = currentTimeString;
	//$('clock').innerHTML = currentTimeString;
}

// -->