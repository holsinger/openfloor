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