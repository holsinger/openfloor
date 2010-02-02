

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

// script.aculo.us effects.js v1.8.0, Tue Nov 06 15:01:40 +0300 2007

// Copyright (c) 2005-2007 Thomas Fuchs (http://script.aculo.us, http://mir.aculo.us)
// Contributors:
//  Justin Palmer (http://encytemedia.com/)
//  Mark Pilgrim (http://diveintomark.org/)
//  Martin Bialasinki
// 
// script.aculo.us is freely distributable under the terms of an MIT-style license.
// For details, see the script.aculo.us web site: http://script.aculo.us/ 

// converts rgb() and #xxx to #xxxxxx format,  
// returns self (or first argument) if not convertable  
String.prototype.parseColor = function() {  
  var color = '#';
  if (this.slice(0,4) == 'rgb(') {  
    var cols = this.slice(4,this.length-1).split(',');  
    var i=0; do { color += parseInt(cols[i]).toColorPart() } while (++i<3);  
  } else {  
    if (this.slice(0,1) == '#') {  
      if (this.length==4) for(var i=1;i<4;i++) color += (this.charAt(i) + this.charAt(i)).toLowerCase();  
      if (this.length==7) color = this.toLowerCase();  
    }  
  }  
  return (color.length==7 ? color : (arguments[0] || this));  
};

/*--------------------------------------------------------------------------*/

Element.collectTextNodes = function(element) {  
  return $A($(element).childNodes).collect( function(node) {
    return (node.nodeType==3 ? node.nodeValue : 
      (node.hasChildNodes() ? Element.collectTextNodes(node) : ''));
  }).flatten().join('');
};

Element.collectTextNodesIgnoreClass = function(element, className) {  
  return $A($(element).childNodes).collect( function(node) {
    return (node.nodeType==3 ? node.nodeValue : 
      ((node.hasChildNodes() && !Element.hasClassName(node,className)) ? 
        Element.collectTextNodesIgnoreClass(node, className) : ''));
  }).flatten().join('');
};

Element.setContentZoom = function(element, percent) {
  element = $(element);  
  element.setStyle({fontSize: (percent/100) + 'em'});   
  if (Prototype.Browser.WebKit) window.scrollBy(0,0);
  return element;
};

Element.getInlineOpacity = function(element){
  return $(element).style.opacity || '';
};

Element.forceRerendering = function(element) {
  try {
    element = $(element);
    var n = document.createTextNode(' ');
    element.appendChild(n);
    element.removeChild(n);
  } catch(e) { }
};

/*--------------------------------------------------------------------------*/

var Effect = {
  _elementDoesNotExistError: {
    name: 'ElementDoesNotExistError',
    message: 'The specified DOM element does not exist, but is required for this effect to operate'
  },
  Transitions: {
    linear: Prototype.K,
    sinoidal: function(pos) {
      return (-Math.cos(pos*Math.PI)/2) + 0.5;
    },
    reverse: function(pos) {
      return 1-pos;
    },
    flicker: function(pos) {
      var pos = ((-Math.cos(pos*Math.PI)/4) + 0.75) + Math.random()/4;
      return pos > 1 ? 1 : pos;
    },
    wobble: function(pos) {
      return (-Math.cos(pos*Math.PI*(9*pos))/2) + 0.5;
    },
    pulse: function(pos, pulses) { 
      pulses = pulses || 5; 
      return (
        ((pos % (1/pulses)) * pulses).round() == 0 ? 
              ((pos * pulses * 2) - (pos * pulses * 2).floor()) : 
          1 - ((pos * pulses * 2) - (pos * pulses * 2).floor())
        );
    },
    spring: function(pos) { 
      return 1 - (Math.cos(pos * 4.5 * Math.PI) * Math.exp(-pos * 6)); 
    },
    none: function(pos) {
      return 0;
    },
    full: function(pos) {
      return 1;
    }
  },
  DefaultOptions: {
    duration:   1.0,   // seconds
    fps:        100,   // 100= assume 66fps max.
    sync:       false, // true for combining
    from:       0.0,
    to:         1.0,
    delay:      0.0,
    queue:      'parallel'
  },
  tagifyText: function(element) {
    var tagifyStyle = 'position:relative';
    if (Prototype.Browser.IE) tagifyStyle += ';zoom:1';
    
    element = $(element);
    $A(element.childNodes).each( function(child) {
      if (child.nodeType==3) {
        child.nodeValue.toArray().each( function(character) {
          element.insertBefore(
            new Element('span', {style: tagifyStyle}).update(
              character == ' ' ? String.fromCharCode(160) : character), 
              child);
        });
        Element.remove(child);
      }
    });
  },
  multiple: function(element, effect) {
    var elements;
    if (((typeof element == 'object') || 
        Object.isFunction(element)) && 
       (element.length))
      elements = element;
    else
      elements = $(element).childNodes;
      
    var options = Object.extend({
      speed: 0.1,
      delay: 0.0
    }, arguments[2] || { });
    var masterDelay = options.delay;

    $A(elements).each( function(element, index) {
      new effect(element, Object.extend(options, { delay: index * options.speed + masterDelay }));
    });
  },
  PAIRS: {
    'slide':  ['SlideDown','SlideUp'],
    'blind':  ['BlindDown','BlindUp'],
    'appear': ['Appear','Fade']
  },
  toggle: function(element, effect) {
    element = $(element);
    effect = (effect || 'appear').toLowerCase();
    var options = Object.extend({
      queue: { position:'end', scope:(element.id || 'global'), limit: 1 }
    }, arguments[2] || { });
    Effect[element.visible() ? 
      Effect.PAIRS[effect][1] : Effect.PAIRS[effect][0]](element, options);
  }
};

Effect.DefaultOptions.transition = Effect.Transitions.sinoidal;

/* ------------- core effects ------------- */

Effect.ScopedQueue = Class.create(Enumerable, {
  initialize: function() {
    this.effects  = [];
    this.interval = null;    
  },
  _each: function(iterator) {
    this.effects._each(iterator);
  },
  add: function(effect) {
    var timestamp = new Date().getTime();
    
    var position = Object.isString(effect.options.queue) ? 
      effect.options.queue : effect.options.queue.position;
    
    switch(position) {
      case 'front':
        // move unstarted effects after this effect  
        this.effects.findAll(function(e){ return e.state=='idle' }).each( function(e) {
            e.startOn  += effect.finishOn;
            e.finishOn += effect.finishOn;
          });
        break;
      case 'with-last':
        timestamp = this.effects.pluck('startOn').max() || timestamp;
        break;
      case 'end':
        // start effect after last queued effect has finished
        timestamp = this.effects.pluck('finishOn').max() || timestamp;
        break;
    }
    
    effect.startOn  += timestamp;
    effect.finishOn += timestamp;

    if (!effect.options.queue.limit || (this.effects.length < effect.options.queue.limit))
      this.effects.push(effect);
    
    if (!this.interval)
      this.interval = setInterval(this.loop.bind(this), 15);
  },
  remove: function(effect) {
    this.effects = this.effects.reject(function(e) { return e==effect });
    if (this.effects.length == 0) {
      clearInterval(this.interval);
      this.interval = null;
    }
  },
  loop: function() {
    var timePos = new Date().getTime();
    for(var i=0, len=this.effects.length;i<len;i++) 
      this.effects[i] && this.effects[i].loop(timePos);
  }
});

Effect.Queues = {
  instances: $H(),
  get: function(queueName) {
    if (!Object.isString(queueName)) return queueName;
    
    return this.instances.get(queueName) ||
      this.instances.set(queueName, new Effect.ScopedQueue());
  }
};
Effect.Queue = Effect.Queues.get('global');

Effect.Base = Class.create({
  position: null,
  start: function(options) {
    function codeForEvent(options,eventName){
      return (
        (options[eventName+'Internal'] ? 'this.options.'+eventName+'Internal(this);' : '') +
        (options[eventName] ? 'this.options.'+eventName+'(this);' : '')
      );
    }
    if (options && options.transition === false) options.transition = Effect.Transitions.linear;
    this.options      = Object.extend(Object.extend({ },Effect.DefaultOptions), options || { });
    this.currentFrame = 0;
    this.state        = 'idle';
    this.startOn      = this.options.delay*1000;
    this.finishOn     = this.startOn+(this.options.duration*1000);
    this.fromToDelta  = this.options.to-this.options.from;
    this.totalTime    = this.finishOn-this.startOn;
    this.totalFrames  = this.options.fps*this.options.duration;
    
    eval('this.render = function(pos){ '+
      'if (this.state=="idle"){this.state="running";'+
      codeForEvent(this.options,'beforeSetup')+
      (this.setup ? 'this.setup();':'')+ 
      codeForEvent(this.options,'afterSetup')+
      '};if (this.state=="running"){'+
      'pos=this.options.transition(pos)*'+this.fromToDelta+'+'+this.options.from+';'+
      'this.position=pos;'+
      codeForEvent(this.options,'beforeUpdate')+
      (this.update ? 'this.update(pos);':'')+
      codeForEvent(this.options,'afterUpdate')+
      '}}');
    
    this.event('beforeStart');
    if (!this.options.sync)
      Effect.Queues.get(Object.isString(this.options.queue) ? 
        'global' : this.options.queue.scope).add(this);
  },
  loop: function(timePos) {
    if (timePos >= this.startOn) {
      if (timePos >= this.finishOn) {
        this.render(1.0);
        this.cancel();
        this.event('beforeFinish');
        if (this.finish) this.finish(); 
        this.event('afterFinish');
        return;  
      }
      var pos   = (timePos - this.startOn) / this.totalTime,
          frame = (pos * this.totalFrames).round();
      if (frame > this.currentFrame) {
        this.render(pos);
        this.currentFrame = frame;
      }
    }
  },
  cancel: function() {
    if (!this.options.sync)
      Effect.Queues.get(Object.isString(this.options.queue) ? 
        'global' : this.options.queue.scope).remove(this);
    this.state = 'finished';
  },
  event: function(eventName) {
    if (this.options[eventName + 'Internal']) this.options[eventName + 'Internal'](this);
    if (this.options[eventName]) this.options[eventName](this);
  },
  inspect: function() {
    var data = $H();
    for(property in this)
      if (!Object.isFunction(this[property])) data.set(property, this[property]);
    return '#<Effect:' + data.inspect() + ',options:' + $H(this.options).inspect() + '>';
  }
});

Effect.Parallel = Class.create(Effect.Base, {
  initialize: function(effects) {
    this.effects = effects || [];
    this.start(arguments[1]);
  },
  update: function(position) {
    this.effects.invoke('render', position);
  },
  finish: function(position) {
    this.effects.each( function(effect) {
      effect.render(1.0);
      effect.cancel();
      effect.event('beforeFinish');
      if (effect.finish) effect.finish(position);
      effect.event('afterFinish');
    });
  }
});

Effect.Tween = Class.create(Effect.Base, {
  initialize: function(object, from, to) {
    object = Object.isString(object) ? $(object) : object;
    var args = $A(arguments), method = args.last(), 
      options = args.length == 5 ? args[3] : null;
    this.method = Object.isFunction(method) ? method.bind(object) :
      Object.isFunction(object[method]) ? object[method].bind(object) : 
      function(value) { object[method] = value };
    this.start(Object.extend({ from: from, to: to }, options || { }));
  },
  update: function(position) {
    this.method(position);
  }
});

Effect.Event = Class.create(Effect.Base, {
  initialize: function() {
    this.start(Object.extend({ duration: 0 }, arguments[0] || { }));
  },
  update: Prototype.emptyFunction
});

Effect.Opacity = Class.create(Effect.Base, {
  initialize: function(element) {
    this.element = $(element);
    if (!this.element) throw(Effect._elementDoesNotExistError);
    // make this work on IE on elements without 'layout'
    if (Prototype.Browser.IE && (!this.element.currentStyle.hasLayout))
      this.element.setStyle({zoom: 1});
    var options = Object.extend({
      from: this.element.getOpacity() || 0.0,
      to:   1.0
    }, arguments[1] || { });
    this.start(options);
  },
  update: function(position) {
    this.element.setOpacity(position);
  }
});

Effect.Move = Class.create(Effect.Base, {
  initialize: function(element) {
    this.element = $(element);
    if (!this.element) throw(Effect._elementDoesNotExistError);
    var options = Object.extend({
      x:    0,
      y:    0,
      mode: 'relative'
    }, arguments[1] || { });
    this.start(options);
  },
  setup: function() {
    this.element.makePositioned();
    this.originalLeft = parseFloat(this.element.getStyle('left') || '0');
    this.originalTop  = parseFloat(this.element.getStyle('top')  || '0');
    if (this.options.mode == 'absolute') {
      this.options.x = this.options.x - this.originalLeft;
      this.options.y = this.options.y - this.originalTop;
    }
  },
  update: function(position) {
    this.element.setStyle({
      left: (this.options.x  * position + this.originalLeft).round() + 'px',
      top:  (this.options.y  * position + this.originalTop).round()  + 'px'
    });
  }
});

// for backwards compatibility
Effect.MoveBy = function(element, toTop, toLeft) {
  return new Effect.Move(element, 
    Object.extend({ x: toLeft, y: toTop }, arguments[3] || { }));
};

Effect.Scale = Class.create(Effect.Base, {
  initialize: function(element, percent) {
    this.element = $(element);
    if (!this.element) throw(Effect._elementDoesNotExistError);
    var options = Object.extend({
      scaleX: true,
      scaleY: true,
      scaleContent: true,
      scaleFromCenter: false,
      scaleMode: 'box',        // 'box' or 'contents' or { } with provided values
      scaleFrom: 100.0,
      scaleTo:   percent
    }, arguments[2] || { });
    this.start(options);
  },
  setup: function() {
    this.restoreAfterFinish = this.options.restoreAfterFinish || false;
    this.elementPositioning = this.element.getStyle('position');
    
    this.originalStyle = { };
    ['top','left','width','height','fontSize'].each( function(k) {
      this.originalStyle[k] = this.element.style[k];
    }.bind(this));
      
    this.originalTop  = this.element.offsetTop;
    this.originalLeft = this.element.offsetLeft;
    
    var fontSize = this.element.getStyle('font-size') || '100%';
    ['em','px','%','pt'].each( function(fontSizeType) {
      if (fontSize.indexOf(fontSizeType)>0) {
        this.fontSize     = parseFloat(fontSize);
        this.fontSizeType = fontSizeType;
      }
    }.bind(this));
    
    this.factor = (this.options.scaleTo - this.options.scaleFrom)/100;
    
    this.dims = null;
    if (this.options.scaleMode=='box')
      this.dims = [this.element.offsetHeight, this.element.offsetWidth];
    if (/^content/.test(this.options.scaleMode))
      this.dims = [this.element.scrollHeight, this.element.scrollWidth];
    if (!this.dims)
      this.dims = [this.options.scaleMode.originalHeight,
                   this.options.scaleMode.originalWidth];
  },
  update: function(position) {
    var currentScale = (this.options.scaleFrom/100.0) + (this.factor * position);
    if (this.options.scaleContent && this.fontSize)
      this.element.setStyle({fontSize: this.fontSize * currentScale + this.fontSizeType });
    this.setDimensions(this.dims[0] * currentScale, this.dims[1] * currentScale);
  },
  finish: function(position) {
    if (this.restoreAfterFinish) this.element.setStyle(this.originalStyle);
  },
  setDimensions: function(height, width) {
    var d = { };
    if (this.options.scaleX) d.width = width.round() + 'px';
    if (this.options.scaleY) d.height = height.round() + 'px';
    if (this.options.scaleFromCenter) {
      var topd  = (height - this.dims[0])/2;
      var leftd = (width  - this.dims[1])/2;
      if (this.elementPositioning == 'absolute') {
        if (this.options.scaleY) d.top = this.originalTop-topd + 'px';
        if (this.options.scaleX) d.left = this.originalLeft-leftd + 'px';
      } else {
        if (this.options.scaleY) d.top = -topd + 'px';
        if (this.options.scaleX) d.left = -leftd + 'px';
      }
    }
    this.element.setStyle(d);
  }
});

Effect.Highlight = Class.create(Effect.Base, {
  initialize: function(element) {
    this.element = $(element);
    if (!this.element) throw(Effect._elementDoesNotExistError);
    var options = Object.extend({ startcolor: '#ffff99' }, arguments[1] || { });
    this.start(options);
  },
  setup: function() {
    // Prevent executing on elements not in the layout flow
    if (this.element.getStyle('display')=='none') { this.cancel(); return; }
    // Disable background image during the effect
    this.oldStyle = { };
    if (!this.options.keepBackgroundImage) {
      this.oldStyle.backgroundImage = this.element.getStyle('background-image');
      this.element.setStyle({backgroundImage: 'none'});
    }
    if (!this.options.endcolor)
      this.options.endcolor = this.element.getStyle('background-color').parseColor('#ffffff');
    if (!this.options.restorecolor)
      this.options.restorecolor = this.element.getStyle('background-color');
    // init color calculations
    this._base  = $R(0,2).map(function(i){ return parseInt(this.options.startcolor.slice(i*2+1,i*2+3),16) }.bind(this));
    this._delta = $R(0,2).map(function(i){ return parseInt(this.options.endcolor.slice(i*2+1,i*2+3),16)-this._base[i] }.bind(this));
  },
  update: function(position) {
    this.element.setStyle({backgroundColor: $R(0,2).inject('#',function(m,v,i){
      return m+((this._base[i]+(this._delta[i]*position)).round().toColorPart()); }.bind(this)) });
  },
  finish: function() {
    this.element.setStyle(Object.extend(this.oldStyle, {
      backgroundColor: this.options.restorecolor
    }));
  }
});

Effect.ScrollTo = function(element) {
  var options = arguments[1] || { },
    scrollOffsets = document.viewport.getScrollOffsets(),
    elementOffsets = $(element).cumulativeOffset(),
    max = (window.height || document.body.scrollHeight) - document.viewport.getHeight();  

  if (options.offset) elementOffsets[1] += options.offset;

  return new Effect.Tween(null,
    scrollOffsets.top,
    elementOffsets[1] > max ? max : elementOffsets[1],
    options,
    function(p){ scrollTo(scrollOffsets.left, p.round()) }
  );
};

/* ------------- combination effects ------------- */

Effect.Fade = function(element) {
  element = $(element);
  var oldOpacity = element.getInlineOpacity();
  var options = Object.extend({
    from: element.getOpacity() || 1.0,
    to:   0.0,
    afterFinishInternal: function(effect) { 
      if (effect.options.to!=0) return;
      effect.element.hide().setStyle({opacity: oldOpacity}); 
    }
  }, arguments[1] || { });
  return new Effect.Opacity(element,options);
};

Effect.Appear = function(element) {
  element = $(element);
  var options = Object.extend({
  from: (element.getStyle('display') == 'none' ? 0.0 : element.getOpacity() || 0.0),
  to:   1.0,
  // force Safari to render floated elements properly
  afterFinishInternal: function(effect) {
    effect.element.forceRerendering();
  },
  beforeSetup: function(effect) {
    effect.element.setOpacity(effect.options.from).show(); 
  }}, arguments[1] || { });
  return new Effect.Opacity(element,options);
};

Effect.Puff = function(element) {
  element = $(element);
  var oldStyle = { 
    opacity: element.getInlineOpacity(), 
    position: element.getStyle('position'),
    top:  element.style.top,
    left: element.style.left,
    width: element.style.width,
    height: element.style.height
  };
  return new Effect.Parallel(
   [ new Effect.Scale(element, 200, 
      { sync: true, scaleFromCenter: true, scaleContent: true, restoreAfterFinish: true }), 
     new Effect.Opacity(element, { sync: true, to: 0.0 } ) ], 
     Object.extend({ duration: 1.0, 
      beforeSetupInternal: function(effect) {
        Position.absolutize(effect.effects[0].element)
      },
      afterFinishInternal: function(effect) {
         effect.effects[0].element.hide().setStyle(oldStyle); }
     }, arguments[1] || { })
   );
};

Effect.BlindUp = function(element) {
  element = $(element);
  element.makeClipping();
  return new Effect.Scale(element, 0,
    Object.extend({ scaleContent: false, 
      scaleX: false, 
      restoreAfterFinish: true,
      afterFinishInternal: function(effect) {
        effect.element.hide().undoClipping();
      } 
    }, arguments[1] || { })
  );
};

Effect.BlindDown = function(element) {
  element = $(element);
  var elementDimensions = element.getDimensions();
  return new Effect.Scale(element, 100, Object.extend({ 
    scaleContent: false, 
    scaleX: false,
    scaleFrom: 0,
    scaleMode: {originalHeight: elementDimensions.height, originalWidth: elementDimensions.width},
    restoreAfterFinish: true,
    afterSetup: function(effect) {
      effect.element.makeClipping().setStyle({height: '0px'}).show(); 
    },  
    afterFinishInternal: function(effect) {
      effect.element.undoClipping();
    }
  }, arguments[1] || { }));
};

Effect.SwitchOff = function(element) {
  element = $(element);
  var oldOpacity = element.getInlineOpacity();
  return new Effect.Appear(element, Object.extend({
    duration: 0.4,
    from: 0,
    transition: Effect.Transitions.flicker,
    afterFinishInternal: function(effect) {
      new Effect.Scale(effect.element, 1, { 
        duration: 0.3, scaleFromCenter: true,
        scaleX: false, scaleContent: false, restoreAfterFinish: true,
        beforeSetup: function(effect) { 
          effect.element.makePositioned().makeClipping();
        },
        afterFinishInternal: function(effect) {
          effect.element.hide().undoClipping().undoPositioned().setStyle({opacity: oldOpacity});
        }
      })
    }
  }, arguments[1] || { }));
};

Effect.DropOut = function(element) {
  element = $(element);
  var oldStyle = {
    top: element.getStyle('top'),
    left: element.getStyle('left'),
    opacity: element.getInlineOpacity() };
  return new Effect.Parallel(
    [ new Effect.Move(element, {x: 0, y: 100, sync: true }), 
      new Effect.Opacity(element, { sync: true, to: 0.0 }) ],
    Object.extend(
      { duration: 0.5,
        beforeSetup: function(effect) {
          effect.effects[0].element.makePositioned(); 
        },
        afterFinishInternal: function(effect) {
          effect.effects[0].element.hide().undoPositioned().setStyle(oldStyle);
        } 
      }, arguments[1] || { }));
};

Effect.Shake = function(element) {
  element = $(element);
  var options = Object.extend({
    distance: 20,
    duration: 0.5
  }, arguments[1] || {});
  var distance = parseFloat(options.distance);
  var split = parseFloat(options.duration) / 10.0;
  var oldStyle = {
    top: element.getStyle('top'),
    left: element.getStyle('left') };
    return new Effect.Move(element,
      { x:  distance, y: 0, duration: split, afterFinishInternal: function(effect) {
    new Effect.Move(effect.element,
      { x: -distance*2, y: 0, duration: split*2,  afterFinishInternal: function(effect) {
    new Effect.Move(effect.element,
      { x:  distance*2, y: 0, duration: split*2,  afterFinishInternal: function(effect) {
    new Effect.Move(effect.element,
      { x: -distance*2, y: 0, duration: split*2,  afterFinishInternal: function(effect) {
    new Effect.Move(effect.element,
      { x:  distance*2, y: 0, duration: split*2,  afterFinishInternal: function(effect) {
    new Effect.Move(effect.element,
      { x: -distance, y: 0, duration: split, afterFinishInternal: function(effect) {
        effect.element.undoPositioned().setStyle(oldStyle);
  }}) }}) }}) }}) }}) }});
};

Effect.SlideDown = function(element) {
  element = $(element).cleanWhitespace();
  // SlideDown need to have the content of the element wrapped in a container element with fixed height!
  var oldInnerBottom = element.down().getStyle('bottom');
  var elementDimensions = element.getDimensions();
  return new Effect.Scale(element, 100, Object.extend({ 
    scaleContent: false, 
    scaleX: false, 
    scaleFrom: window.opera ? 0 : 1,
    scaleMode: {originalHeight: elementDimensions.height, originalWidth: elementDimensions.width},
    restoreAfterFinish: true,
    afterSetup: function(effect) {
      effect.element.makePositioned();
      effect.element.down().makePositioned();
      if (window.opera) effect.element.setStyle({top: ''});
      effect.element.makeClipping().setStyle({height: '0px'}).show(); 
    },
    afterUpdateInternal: function(effect) {
      effect.element.down().setStyle({bottom:
        (effect.dims[0] - effect.element.clientHeight) + 'px' }); 
    },
    afterFinishInternal: function(effect) {
      effect.element.undoClipping().undoPositioned();
      effect.element.down().undoPositioned().setStyle({bottom: oldInnerBottom}); }
    }, arguments[1] || { })
  );
};

Effect.SlideUp = function(element) {
  element = $(element).cleanWhitespace();
  var oldInnerBottom = element.down().getStyle('bottom');
  var elementDimensions = element.getDimensions();
  return new Effect.Scale(element, window.opera ? 0 : 1,
   Object.extend({ scaleContent: false, 
    scaleX: false, 
    scaleMode: 'box',
    scaleFrom: 100,
    scaleMode: {originalHeight: elementDimensions.height, originalWidth: elementDimensions.width},
    restoreAfterFinish: true,
    afterSetup: function(effect) {
      effect.element.makePositioned();
      effect.element.down().makePositioned();
      if (window.opera) effect.element.setStyle({top: ''});
      effect.element.makeClipping().show();
    },  
    afterUpdateInternal: function(effect) {
      effect.element.down().setStyle({bottom:
        (effect.dims[0] - effect.element.clientHeight) + 'px' });
    },
    afterFinishInternal: function(effect) {
      effect.element.hide().undoClipping().undoPositioned();
      effect.element.down().undoPositioned().setStyle({bottom: oldInnerBottom});
    }
   }, arguments[1] || { })
  );
};

// Bug in opera makes the TD containing this element expand for a instance after finish 
Effect.Squish = function(element) {
  return new Effect.Scale(element, window.opera ? 1 : 0, { 
    restoreAfterFinish: true,
    beforeSetup: function(effect) {
      effect.element.makeClipping(); 
    },  
    afterFinishInternal: function(effect) {
      effect.element.hide().undoClipping(); 
    }
  });
};

Effect.Grow = function(element) {
  element = $(element);
  var options = Object.extend({
    direction: 'center',
    moveTransition: Effect.Transitions.sinoidal,
    scaleTransition: Effect.Transitions.sinoidal,
    opacityTransition: Effect.Transitions.full
  }, arguments[1] || { });
  var oldStyle = {
    top: element.style.top,
    left: element.style.left,
    height: element.style.height,
    width: element.style.width,
    opacity: element.getInlineOpacity() };

  var dims = element.getDimensions();    
  var initialMoveX, initialMoveY;
  var moveX, moveY;
  
  switch (options.direction) {
    case 'top-left':
      initialMoveX = initialMoveY = moveX = moveY = 0; 
      break;
    case 'top-right':
      initialMoveX = dims.width;
      initialMoveY = moveY = 0;
      moveX = -dims.width;
      break;
    case 'bottom-left':
      initialMoveX = moveX = 0;
      initialMoveY = dims.height;
      moveY = -dims.height;
      break;
    case 'bottom-right':
      initialMoveX = dims.width;
      initialMoveY = dims.height;
      moveX = -dims.width;
      moveY = -dims.height;
      break;
    case 'center':
      initialMoveX = dims.width / 2;
      initialMoveY = dims.height / 2;
      moveX = -dims.width / 2;
      moveY = -dims.height / 2;
      break;
  }
  
  return new Effect.Move(element, {
    x: initialMoveX,
    y: initialMoveY,
    duration: 0.01, 
    beforeSetup: function(effect) {
      effect.element.hide().makeClipping().makePositioned();
    },
    afterFinishInternal: function(effect) {
      new Effect.Parallel(
        [ new Effect.Opacity(effect.element, { sync: true, to: 1.0, from: 0.0, transition: options.opacityTransition }),
          new Effect.Move(effect.element, { x: moveX, y: moveY, sync: true, transition: options.moveTransition }),
          new Effect.Scale(effect.element, 100, {
            scaleMode: { originalHeight: dims.height, originalWidth: dims.width }, 
            sync: true, scaleFrom: window.opera ? 1 : 0, transition: options.scaleTransition, restoreAfterFinish: true})
        ], Object.extend({
             beforeSetup: function(effect) {
               effect.effects[0].element.setStyle({height: '0px'}).show(); 
             },
             afterFinishInternal: function(effect) {
               effect.effects[0].element.undoClipping().undoPositioned().setStyle(oldStyle); 
             }
           }, options)
      )
    }
  });
};

Effect.Shrink = function(element) {
  element = $(element);
  var options = Object.extend({
    direction: 'center',
    moveTransition: Effect.Transitions.sinoidal,
    scaleTransition: Effect.Transitions.sinoidal,
    opacityTransition: Effect.Transitions.none
  }, arguments[1] || { });
  var oldStyle = {
    top: element.style.top,
    left: element.style.left,
    height: element.style.height,
    width: element.style.width,
    opacity: element.getInlineOpacity() };

  var dims = element.getDimensions();
  var moveX, moveY;
  
  switch (options.direction) {
    case 'top-left':
      moveX = moveY = 0;
      break;
    case 'top-right':
      moveX = dims.width;
      moveY = 0;
      break;
    case 'bottom-left':
      moveX = 0;
      moveY = dims.height;
      break;
    case 'bottom-right':
      moveX = dims.width;
      moveY = dims.height;
      break;
    case 'center':  
      moveX = dims.width / 2;
      moveY = dims.height / 2;
      break;
  }
  
  return new Effect.Parallel(
    [ new Effect.Opacity(element, { sync: true, to: 0.0, from: 1.0, transition: options.opacityTransition }),
      new Effect.Scale(element, window.opera ? 1 : 0, { sync: true, transition: options.scaleTransition, restoreAfterFinish: true}),
      new Effect.Move(element, { x: moveX, y: moveY, sync: true, transition: options.moveTransition })
    ], Object.extend({            
         beforeStartInternal: function(effect) {
           effect.effects[0].element.makePositioned().makeClipping(); 
         },
         afterFinishInternal: function(effect) {
           effect.effects[0].element.hide().undoClipping().undoPositioned().setStyle(oldStyle); }
       }, options)
  );
};

Effect.Pulsate = function(element) {
  element = $(element);
  var options    = arguments[1] || { };
  var oldOpacity = element.getInlineOpacity();
  var transition = options.transition || Effect.Transitions.sinoidal;
  var reverser   = function(pos){ return transition(1-Effect.Transitions.pulse(pos, options.pulses)) };
  reverser.bind(transition);
  return new Effect.Opacity(element, 
    Object.extend(Object.extend({  duration: 2.0, from: 0,
      afterFinishInternal: function(effect) { effect.element.setStyle({opacity: oldOpacity}); }
    }, options), {transition: reverser}));
};

Effect.Fold = function(element) {
  element = $(element);
  var oldStyle = {
    top: element.style.top,
    left: element.style.left,
    width: element.style.width,
    height: element.style.height };
  element.makeClipping();
  return new Effect.Scale(element, 5, Object.extend({   
    scaleContent: false,
    scaleX: false,
    afterFinishInternal: function(effect) {
    new Effect.Scale(element, 1, { 
      scaleContent: false, 
      scaleY: false,
      afterFinishInternal: function(effect) {
        effect.element.hide().undoClipping().setStyle(oldStyle);
      } });
  }}, arguments[1] || { }));
};

Effect.Morph = Class.create(Effect.Base, {
  initialize: function(element) {
    this.element = $(element);
    if (!this.element) throw(Effect._elementDoesNotExistError);
    var options = Object.extend({
      style: { }
    }, arguments[1] || { });
    
    if (!Object.isString(options.style)) this.style = $H(options.style);
    else {
      if (options.style.include(':'))
        this.style = options.style.parseStyle();
      else {
        this.element.addClassName(options.style);
        this.style = $H(this.element.getStyles());
        this.element.removeClassName(options.style);
        var css = this.element.getStyles();
        this.style = this.style.reject(function(style) {
          return style.value == css[style.key];
        });
        options.afterFinishInternal = function(effect) {
          effect.element.addClassName(effect.options.style);
          effect.transforms.each(function(transform) {
            effect.element.style[transform.style] = '';
          });
        }
      }
    }
    this.start(options);
  },
  
  setup: function(){
    function parseColor(color){
      if (!color || ['rgba(0, 0, 0, 0)','transparent'].include(color)) color = '#ffffff';
      color = color.parseColor();
      return $R(0,2).map(function(i){
        return parseInt( color.slice(i*2+1,i*2+3), 16 ) 
      });
    }
    this.transforms = this.style.map(function(pair){
      var property = pair[0], value = pair[1], unit = null;

      if (value.parseColor('#zzzzzz') != '#zzzzzz') {
        value = value.parseColor();
        unit  = 'color';
      } else if (property == 'opacity') {
        value = parseFloat(value);
        if (Prototype.Browser.IE && (!this.element.currentStyle.hasLayout))
          this.element.setStyle({zoom: 1});
      } else if (Element.CSS_LENGTH.test(value)) {
          var components = value.match(/^([\+\-]?[0-9\.]+)(.*)$/);
          value = parseFloat(components[1]);
          unit = (components.length == 3) ? components[2] : null;
      }

      var originalValue = this.element.getStyle(property);
      return { 
        style: property.camelize(), 
        originalValue: unit=='color' ? parseColor(originalValue) : parseFloat(originalValue || 0), 
        targetValue: unit=='color' ? parseColor(value) : value,
        unit: unit
      };
    }.bind(this)).reject(function(transform){
      return (
        (transform.originalValue == transform.targetValue) ||
        (
          transform.unit != 'color' &&
          (isNaN(transform.originalValue) || isNaN(transform.targetValue))
        )
      )
    });
  },
  update: function(position) {
    var style = { }, transform, i = this.transforms.length;
    while(i--)
      style[(transform = this.transforms[i]).style] = 
        transform.unit=='color' ? '#'+
          (Math.round(transform.originalValue[0]+
            (transform.targetValue[0]-transform.originalValue[0])*position)).toColorPart() +
          (Math.round(transform.originalValue[1]+
            (transform.targetValue[1]-transform.originalValue[1])*position)).toColorPart() +
          (Math.round(transform.originalValue[2]+
            (transform.targetValue[2]-transform.originalValue[2])*position)).toColorPart() :
        (transform.originalValue +
          (transform.targetValue - transform.originalValue) * position).toFixed(3) + 
            (transform.unit === null ? '' : transform.unit);
    this.element.setStyle(style, true);
  }
});

Effect.Transform = Class.create({
  initialize: function(tracks){
    this.tracks  = [];
    this.options = arguments[1] || { };
    this.addTracks(tracks);
  },
  addTracks: function(tracks){
    tracks.each(function(track){
      track = $H(track);
      var data = track.values().first();
      this.tracks.push($H({
        ids:     track.keys().first(),
        effect:  Effect.Morph,
        options: { style: data }
      }));
    }.bind(this));
    return this;
  },
  play: function(){
    return new Effect.Parallel(
      this.tracks.map(function(track){
        var ids = track.get('ids'), effect = track.get('effect'), options = track.get('options');
        var elements = [$(ids) || $$(ids)].flatten();
        return elements.map(function(e){ return new effect(e, Object.extend({ sync:true }, options)) });
      }).flatten(),
      this.options
    );
  }
});

Element.CSS_PROPERTIES = $w(
  'backgroundColor backgroundPosition borderBottomColor borderBottomStyle ' + 
  'borderBottomWidth borderLeftColor borderLeftStyle borderLeftWidth ' +
  'borderRightColor borderRightStyle borderRightWidth borderSpacing ' +
  'borderTopColor borderTopStyle borderTopWidth bottom clip color ' +
  'fontSize fontWeight height left letterSpacing lineHeight ' +
  'marginBottom marginLeft marginRight marginTop markerOffset maxHeight '+
  'maxWidth minHeight minWidth opacity outlineColor outlineOffset ' +
  'outlineWidth paddingBottom paddingLeft paddingRight paddingTop ' +
  'right textIndent top width wordSpacing zIndex');
  
Element.CSS_LENGTH = /^(([\+\-]?[0-9\.]+)(em|ex|px|in|cm|mm|pt|pc|\%))|0$/;

String.__parseStyleElement = document.createElement('div');
String.prototype.parseStyle = function(){
  var style, styleRules = $H();
  if (Prototype.Browser.WebKit)
    style = new Element('div',{style:this}).style;
  else {
    String.__parseStyleElement.innerHTML = '<div style="' + this + '"></div>';
    style = String.__parseStyleElement.childNodes[0].style;
  }
  
  Element.CSS_PROPERTIES.each(function(property){
    if (style[property]) styleRules.set(property, style[property]); 
  });
  
  if (Prototype.Browser.IE && this.include('opacity'))
    styleRules.set('opacity', this.match(/opacity:\s*((?:0|1)?(?:\.\d*)?)/)[1]);

  return styleRules;
};

if (document.defaultView && document.defaultView.getComputedStyle) {
  Element.getStyles = function(element) {
    var css = document.defaultView.getComputedStyle($(element), null);
    return Element.CSS_PROPERTIES.inject({ }, function(styles, property) {
      styles[property] = css[property];
      return styles;
    });
  };
} else {
  Element.getStyles = function(element) {
    element = $(element);
    var css = element.currentStyle, styles;
    styles = Element.CSS_PROPERTIES.inject({ }, function(hash, property) {
      hash.set(property, css[property]);
      return hash;
    });
    if (!styles.opacity) styles.set('opacity', element.getOpacity());
    return styles;
  };
};

Effect.Methods = {
  morph: function(element, style) {
    element = $(element);
    new Effect.Morph(element, Object.extend({ style: style }, arguments[2] || { }));
    return element;
  },
  visualEffect: function(element, effect, options) {
    element = $(element)
    var s = effect.dasherize().camelize(), klass = s.charAt(0).toUpperCase() + s.substring(1);
    new Effect[klass](element, options);
    return element;
  },
  highlight: function(element, options) {
    element = $(element);
    new Effect.Highlight(element, options);
    return element;
  }
};

$w('fade appear grow shrink fold blindUp blindDown slideUp slideDown '+
  'pulsate shake puff squish switchOff dropOut').each(
  function(effect) { 
    Effect.Methods[effect] = function(element, options){
      element = $(element);
      Effect[effect.charAt(0).toUpperCase() + effect.substring(1)](element, options);
      return element;
    }
  }
);

$w('getInlineOpacity forceRerendering setContentZoom collectTextNodes collectTextNodesIgnoreClass getStyles').each( 
  function(f) { Effect.Methods[f] = Element[f]; }
);

Element.addMethods(Effect.Methods);


//  Lightview 2.0.1 - 26-02-2008
//  Copyright (c) 2008 Nick Stakenburg (http://www.nickstakenburg.com)
//
//  Licensed under a Creative Commons Attribution-No Derivative Works 3.0 Unported License
//  http://creativecommons.org/licenses/by-nd/3.0/

//  More information on this project:
//  http://www.nickstakenburg.com/projects/lightview/

var Lightview = {
  Version: '2.0.1',

  // Configuration
  options: {
    backgroundColor: '#cccccc',                            // Background color of the view
    border: 5,                                            // Size of the border
    buttons: { opacity: { normal: 0.65, hover: 1 } },      // Opacity of inner buttons
    cyclic: false,                                         // Makes galleries/sets cyclic, no end/begin.
    images: '../images/lightview/',                        // The directory of the images, from this file
    imgNumberTemplate: 'Image #{position} of #{total}',    // Want a different language? change it here
    overlay: {                                             // Overlay
      background: '#444D3E',                                  // Background color, Mac Firefox & Safari use overlay.png
      opacity: 0.85,
      display: false
    },
    preloadHover: true,                                    // Preload images on mouseover
    radius: 12,                                            // Corner radius of the border
    removeTitles: true,                                    // Set to false if you want to keep title attributes intact
    resizeDuration: .1,                                   // When effects are used, the duration of resizing in seconds
    slideshow: { delay: 5, display: true },                // Seconds each image is visible in slideshow
    titleSplit: '::',                                      // The characters you want to split title with
    transition: function(pos) {                            // Or your own transition
      return ((pos/=0.5) < 1 ? 0.5 * Math.pow(pos, 4) :
        -0.5 * ((pos-=2) * Math.pow(pos,3) - 2));
    },
    viewport: true,                                        // Stay within the viewport, true is recommended
    zIndex: 5000,                                          // zIndex of #lightview, #overlay is this -1

    // Optional
    closeDimensions: {                                     // If you've changed the close button you can change these
      large: { width: 85, height: 22 },                    // not required but it speeds things up.
      small: { width: 32, height: 22 },
      innertop: { width: 22, height: 22 },
      topclose: { width: 22, height: 18 }                  // when topclose option is used
    },
    defaultOptions : {                                     // Default open dimensions for each type
      ajax:   { width: 400, height: 300 },
      iframe: { width: 400, height: 300, scrolling: true },
      inline: { width: 400, height: 300 },
      flash:  { width: 400, height: 300 },
      quicktime: { width: 480, height: 220, autoplay: true, controls: true, topclose: true }
    },
    sideDimensions: { width: 16, height: 22 }              // see closeDimensions
  },

  classids: {
    quicktime: 'clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B',
    flash: 'clsid:D27CDB6E-AE6D-11cf-96B8-444553540000'
  },
  codebases: {
    quicktime: 'http://www.apple.com/qtactivex/qtplugin.cab#version=7,3,0,0',
    flash: 'http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,115,0'
  },
  errors: {
    requiresPlugin: "<div class='message'>The content your are attempting to view requires the <span class='type'>#{type}</span> plugin.</div><div class='pluginspage'><p>Please download and install the required plugin from:</p><a href='#{pluginspage}' target='_blank'>#{pluginspage}</a></div>"
  },
  mimetypes: {
    quicktime: 'video/quicktime',
    flash: 'application/x-shockwave-flash'
  },
  pluginspages: {
    quicktime: 'http://www.apple.com/quicktime/download',
    flash: 'http://www.adobe.com/go/getflashplayer'
  },
  // used with auto detection
  typeExtensions: {
    flash: 'swf',
    image: 'bmp gif jpeg jpg png',
    iframe: 'asp aspx cgi cfm htm html php pl php3 php4 php5 phtml rb rhtml shtml txt',
    quicktime: 'avi mov mpg mpeg movie'
  }
};

eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('Z.1d(W.14,{27:(W.14.3k&&(/9x 6./).4r(2H.4a)),2m:(W.14.3i&&!19.4W)});Z.1d(1k,{8H:"1.6.0.2",80:"1.8.1",V:{1n:"43",2T:"12"},5g:!!2H.4a.3z(/52/i),4F:!!2H.4a.3z(/52/i)&&(W.14.3i||W.14.2h),4X:f(A){9((8j 1X[A]=="8d")||(7.4h(1X[A].7Z)<7.4h(7["5X"+A]))){7K("1k 7I "+A+" >= "+7["5X"+A]);}},4h:f(A){n B=A.2B(/5v.*|\\./g,"");B=42(B+"0".7r(4-B.1V));z A.1J("5v")>-1?B-1:B},5e:f(){7.4X("W");9(!!1X.Y&&!1X.55){7.4X("55")}n A=/12(?:-[\\w\\d.]+)?\\.9w(.*)/;7.1l=(($$("9h 99[1q]").6p(f(B){z B.1q.3z(A)})||{}).1q||"").2B(A,"")+7.o.1l;9(W.14.3k&&!19.6w.v){19.6w.6f("v","8v:8s-8p-8n:8i");19.18("4t:4q",f(){19.8c().89("v\\\\:*","87: 1B(#63#83);")})}},4f:f(){7.2F=7.o.2F;7.1b=(7.2F>7.o.1b)?7.2F:7.o.1b;7.1u=7.o.1u;7.1s=7.o.1s;7.5S();7.5P();7.5M()},5S:f(){n B,I,D=7.1N(7.1s);$(19.3P).y({1c:(j u("X",{2j:"2U"}).13())}).y({1c:(7.12=j u("X",{2j:"12"}).q({3m:7.o.3m,1c:"-3l",1g:"-3l"}).1R(0).y(7.3Z=j u("X",{U:"79"}).y(7.3r=j u("2X",{U:"73"}).y(7.5c=j u("1E",{U:"6Y"}).q(I=Z.1d({1v:-1*7.1s.k+"r"},D)).y(7.3g=j u("X",{U:"3U"}).q(Z.1d({1v:7.1s.k+"r"},D)).y(j u("X",{U:"21"})))).y(7.6M=j u("1E",{U:"9r"}).q(Z.1d({6I:-1*7.1s.k+"r"},D)).y(7.3R=j u("X",{U:"3U"}).q(I).y(j u("X",{U:"21"}))))).y(7.4E=j u("X",{U:"9c"}).y(7.3O=j u("X",{U:"3U 97"}).y(j u("X",{U:"21"})))).y(j u("2X",{U:"94"}).y(j u("1E",{U:"6s 91"}).y(B=j u("X",{U:"8Z"}).q({m:7.1b+"r"}).y(j u("2X",{U:"6z 8O"}).y(j u("1E",{U:"6x"}).y(j u("X",{U:"3T"})).y(j u("X",{U:"38"}).q({1g:7.1b+"r"})))).y(j u("X",{U:"6K"})).y(j u("2X",{U:"6z 8y"}).y(j u("1E",{U:"6x"}).q({1z:-1*7.1b+"r"}).y(j u("X",{U:"3T"})).y(j u("X",{U:"38"}).q({1g:-1*7.1b+"r"})))))).y(7.4B=j u("1E",{U:"8r"}).q({m:(8q-7.1b)+"r"}).y(j u("X",{U:"8o"}).y(j u("X",{U:"6d"}).q({1z:7.1b+"r"}).y(7.2K=j u("X",{U:"8m"}).1R(0).q({3K:"0 "+7.1b+"r"}).y(7.1U=j u("X",{U:"8h 38"})).y(7.1F=j u("X",{U:"8g"}).y(7.4s=j u("X",{U:"8f"}).q(7.1N(7.o.1u.4p)).y(7.4m=j u("a",{U:"21"}).1R(7.o.3D.24.4k))).y(7.3B=j u("2X",{U:"85"}).y(7.4i=j u("1E",{U:"84"}).y(7.1r=j u("X",{U:"82"})).y(7.1I=j u("X",{U:"7Y"}))).y(7.3y=j u("1E",{U:"7V"}).y(j u("X"))).y(7.2E=j u("1E",{U:"7Q"}).y(7.2G=j u("a",{U:"21"}).1R(7.o.3D.24.4k).q("1O: 1B("+7.1l+"4c.26) 1c 1g 2C-2J"))))).y(7.1M=j u("X",{U:"7H"}))))).y(7.2L=j u("X",{U:"7E"}).y(7.6m=j u("X",{U:"21"}).q({1O:"1B("+7.1l+"2L.49) 1c 1g 2C-2J"})))).y(j u("1E",{U:"6s 7B"}).y(B.7z(1T))).y(7.1L=j u("1E",{U:"7y"}).13().q({1z:7.1b+"r",1O:"1B("+7.1l+"7v.49) 1c 1g 2J"})))))}).y({1c:(7.1D=j u("X",{2j:"1D"}).q({3m:7.o.3m-1,1n:(!(W.14.2h||W.14.27))?"5A":"3q",1O:7.4F?"1B("+7.1l+"1D.3Q) 1c 1g 2J":7.o.1D.1O}).1R((W.14.2h)?1:7.o.1D.24).13())});n H=j 2t();H.1w=f(){H.1w=W.23;7.1s={k:H.k,m:H.m};n K=7.1N(7.1s),C;7.3r.q({1z:0-(H.m/2).2O()+"r",m:H.m+"r"});7.5c.q(C=Z.1d({1v:-1*7.1s.k+"r"},K));7.3g.q(Z.1d({1v:K.k},K));7.6M.q(Z.1d({6I:-1*7.1s.k+"r"},K));7.3R.q(C)}.S(7);H.1q=7.1l+"2Z.3Q";$w("1r 1I 3y").1j(f(C){7[C].q({2k:7.o.2k})}.S(7));n G=7.3Z.2Q(".3T");$w("7q 7p 7n 5o").1j(f(K,C){9(7.2F>0){7.5l(G[C],K)}10{G[C].y(j u("X",{U:"38"}))}G[C].q({k:7.1b+"r",m:7.1b+"r"}).7g("3T"+K.2y())}.S(7));7.12.2Q(".6K",".38",".6d").2W("q",{2k:7.o.2k});n E={};$w("2Z 1t 22").1j(f(K){7[K+"2x"].3s=K;n C=7.1l+K+".3Q";9(K=="22"){E[K]=j 2t();E[K].1w=f(){E[K].1w=W.23;7.1u[K]={k:E[K].k,m:E[K].m};n L=7.5g?"1g":"78",M=Z.1d({"77":L,1z:7.1u[K].m+"r"},7.1N(7.1u[K]));M["3K"+L.2y()]=7.1b+"r";7[K+"2x"].q(M);7.4E.q({m:E[K].m+"r",1c:-1*7.1u[K].m+"r"});7[K+"2x"].5f().q(Z.1d((!W.14.27?{1O:"1B("+C+")"}:{61:"5R:5d.5Q.5O(1q=\'"+C+"\'\', 5a=\'4d\')"}),7.1N(7.1u[K])))}.S(7);E[K].1q=7.1l+K+".3Q"}10{7[K+"2x"].q(!W.14.27?{1O:"1B("+C+")"}:{61:"5R:5d.5Q.5O(1q=\'"+C+"\'\', 5a=\'4d\')"})}}.S(7));n A={};$w("4p 58 56").1j(f(C){A[C]=j 2t();A[C].1w=f(){A[C].1w=W.23;7.1u[C]={k:A[C].k,m:A[C].m}}.S(7);A[C].1q=7.1l+"6W"+C+".26"}.S(7));n J=j 2t();J.1w=f(){J.1w=W.23;7.2L.q({k:J.k+"r",m:J.m+"r",1z:-0.5*J.m+0.5*7.1b+"r",1v:-0.5*J.k+"r"})}.S(7);J.1q=7.1l+"2L.49";n F=j 2t();F.1w=f(){F.1w=W.23;7.2G.q({k:F.k+"r",m:F.m+"r"})}.S(7);F.1q=7.1l+"4c.26"},51:f(){Y.2I.2M("12").1j(f(A){A.4Z()});7.1p=1m;7.4l();7.1f=1m},4l:f(){9(!7.3e||!7.3d){z}7.3d.y({9q:7.3e.q({1K:7.3e.6J})});7.3d.1Z();7.3d=1m},17:f(B){7.1C=1m;9(Z.6F(B)||Z.6C(B)){7.1C=$(B);7.1C.9a();7.h=7.1C.1G}10{9(B.1a){7.1C=$(19.3P);7.h=j 1k.4N(B)}10{9(Z.6i(B)){7.1C=7.4P(7.h.1i).4M[B];7.h=7.1C.1G}}}9(!7.h.1a){z}7.51();7.4K();7.6n();7.6l();7.3b();7.6k();9(7.h.1a!="#2U"&&Z.6j(1k.4Q).6G(" ").1J(7.h.11)>=0){9(!1k.4Q[7.h.11]){$("2U").1x(j 6y(7.8K.8I).4W({11:7.h.11.2y(),4D:7.4G[7.h.11]}));n C=$("2U").2i();7.17({1a:"#2U",1r:7.h.11.2y()+" 8D 8B",o:C});z 2e}}9(7.h.1P()){7.1f=7.h.1P()?7.4V(7.h.1i):[7.h]}n A=Z.1d({1F:1T,22:2e},7.o.8u[7.h.11]||{});7.h.o=Z.1d(A,7.h.o);9(!(7.h.1r||7.h.1I||(7.1f&&7.1f.1V>1))&&7.h.o.22){7.h.o.1F=2e}9(7.h.2D()){9(7.h.1P()){7.1n=7.1f.1J(7.h);7.6e()}7.1y=7.h.3M;9(7.1y){7.3f()}10{7.4z();n D=j 2t();D.1w=f(){D.1w=W.23;7.3h();7.1y={k:D.k,m:D.m};7.3f()}.S(7);D.1q=7.h.1a}}10{7.1y=7.h.o.4y?19.2g.2i():{k:7.h.o.k,m:7.h.o.m};7.3f()}},4x:f(){n D=7.6c(7.h.1a),A=7.1p||7.1y;9(7.h.2D()){n B=7.1N(A);7.1U.q(B).1x(j u("6b",{2j:"1Q",1q:7.h.1a,8l:"",8k:"2C"}).q(B))}10{9(7.h.3J()){9(7.1p&&7.h.o.4y){A.m-=7.2S.m}3I(7.h.11){2f"2R":n F=Z.3H(7.h.o.2R)||{};n E=f(){7.3h();9(7.h.o.4v){7.1M.q({k:"4u",m:"4u"});7.1y=7.3G(7.1M)}j Y.1e({V:7.V,1o:7.3F.S(7)})}.S(7);9(F.3E){F.3E=F.3E.2l(f(N,M){E();N(M)})}10{F.3E=E}7.4z();j 8e.8b(7.1M,7.h.1a,F);1W;2f"2a":7.1M.1x(7.2a=j u("2a",{8a:0,88:0,1q:7.h.1a,2j:"1Q",1Y:"1Q",69:(7.h.o&&7.h.o.69)?"4u":"2C"}).q(Z.1d({1b:0,68:0,3K:0},7.1N(A))));1W;2f"3C":n C=7.h.1a,H=$(C.66(C.1J("#")+1));9(!H||!H.4j){z}n L=j u(7.h.o.86||"X"),G=H.1H("2b"),J=H.1H("1K");H.2l(L);H.q({2b:"3A"}).17();n I=7.3G(L);H.q({2b:G,1K:J});L.y({64:H}).1Z();H.y({64:7.3d=j u(H.4j)});H.6J=H.1H("1K");7.3e=H.17();7.1M.1x(7.3e);9(7.h.o.4v){7.1y=I;j Y.1e({V:7.V,1o:7.3F.S(7)})}1W}}10{n K={1A:"33",2j:"1Q",k:A.k,m:A.m};3I(7.h.11){2f"2p":Z.1d(K,{4D:7.4G[7.h.11],32:[{1A:"28",1Y:"62",2n:7.h.o.62},{1A:"28",1Y:"4d",2n:"81"},{1A:"28",1Y:"7X",2n:7.h.o.4e},{1A:"28",1Y:"7W",2n:1T},{1A:"28",1Y:"1q",2n:7.h.1a},{1A:"28",1Y:"5Z",2n:7.h.o.5Z||2e}]});Z.1d(K,W.14.3k?{7U:7.7T[7.h.11],7S:7.7R[7.h.11]}:{3B:7.h.1a,11:7.5Y[7.h.11]});1W;2f"2Y":Z.1d(K,{3B:7.h.1a,11:7.5Y[7.h.11],7P:"7O",4D:7.4G[7.h.11],32:[{1A:"28",1Y:"7N",2n:7.h.1a}]});9(7.h.o){K.7M=7.h.o.7L}1W}7.1U.q(7.1N(A)).17();7.1U.1x(7.4g(K));9(7.h.5V()&&$("1Q")){(f(){3v{9("5U"5T $("1Q")){$("1Q").5U(7.h.o.4e)}}3u(M){}}.S(7)).2o(0.4)}}}},3G:f(B){B=$(B);n A=B.7J(),C=[],E=[];A.3t(B);A.1j(f(F){9(F!=B&&F.3L()){z}C.3t(F);E.3t({1K:F.1H("1K"),1n:F.1H("1n"),2b:F.1H("2b")});F.q({1K:"6g",1n:"3q",2b:"3L"})});n D={k:B.7G,m:B.7F};C.1j(f(G,F){G.q(E[F])});z D},4Y:f(){n A=$("1Q");9(A){3I(A.4j.4R()){2f"33":9(W.14.3i&&7.h.5V()){3v{A.5L()}3u(B){}A.7D=""}9(A.7C){A.1Z()}10{A=W.23}1W;2f"2a":A.1Z();9(W.14.2h){5K 1X.7A.1Q}1W;63:A.1Z();1W}}},5J:f(){n A=7.1p||7.1y;9(7.h.o.4e){3I(7.h.11){2f"2p":A.m+=16;1W}}7[(7.1p?"5I":"i")+"5H"]=A},3f:f(){j Y.1e({V:7.V,1o:f(){7.5G()}.S(7)})},5G:f(){7.3c();7.5F();9(!7.h.5E()){7.3h()}9(!((7.h.o.4v&&7.h.7x())||7.h.5E())){7.3F()}9(!7.h.5D()){j Y.1e({V:7.V,1o:7.4x.S(7)})}},5C:f(){j Y.1e({V:7.V,1o:7.5B.S(7)});9(7.h.5D()){j Y.1e({2o:0.15,V:7.V,1o:7.4x.S(7)})}9(7.2N){j Y.1e({V:7.V,1o:7.5z.S(7)})}},2s:f(){7.17(7.2A().2s)},1t:f(){7.17(7.2A().1t)},3F:f(){7.5J();n B=7.47(),D=7.5y();9(7.o.2g&&(B.k>D.k||B.m>D.m)){9(!7.h.o.4y){n E=Z.3H(7.5x()),A=D,C=Z.3H(E);9(C.k>A.k){C.m*=A.k/C.k;C.k=A.k;9(C.m>A.m){C.k*=A.m/C.m;C.m=A.m}}10{9(C.m>A.m){C.k*=A.m/C.m;C.m=A.m;9(C.k>A.k){C.m*=A.k/C.k;C.k=A.k}}}n F=(C.k%1>0?C.m/E.m:C.m%1>0?C.k/E.k:1);7.1p={k:(7.1y.k*F).2O(),m:(7.1y.m*F).2O()};7.3c();B={k:7.1p.k,m:7.1p.m+7.2S.m}}10{7.1p=D;7.3c();B=D}}10{7.3c();7.1p=1m}7.3S(B)},3S:f(B){n F=7.12.2i(),I=2*7.1b,D=B.k+I,M=B.m+I;7.46();n L=f(){7.3b();7.4T=1m;7.5C()};9(F.k==D&&F.m==M){L.S(7)();z}n C={k:D+"r",m:M+"r"};9(!W.14.27){Z.1d(C,{1v:0-D/2+"r",1z:0-M/2+"r"})}n G=D-F.k,K=M-F.m,J=42(7.12.1H("1v").2B("r","")),E=42(7.12.1H("1z").2B("r",""));9(!W.14.27){n A=(0-D/2)-J,H=(0-M/2)-E}7.4T=j Y.7u(7.12,0,1,{1S:7.o.7t,V:7.V,5u:7.o.5u,1o:L.S(7)},f(Q){n N=(F.k+Q*G).2P(0),P=(F.m+Q*K).2P(0);9(W.14.27){7.12.q({k:(F.k+Q*G).2P(0)+"r",m:(F.m+Q*K).2P(0)+"r"});7.4B.q({m:P-1*7.1b+"r"})}10{n O=19.2g.2i(),R=19.2g.5t();7.12.q({1n:"3q",1v:0,1z:0,k:N+"r",m:P+"r",1g:(R[0]+(O.k/2)-(N/2)).2V()+"r",1c:(R[1]+(O.m/2)-(P/2)).2V()+"r"});7.4B.q({m:P-1*7.1b+"r"})}}.S(7))},5B:f(){j Y.1e({V:7.V,1o:u.17.S(7,7[7.h.3p()?"1U":"1M"])});j Y.1e({V:7.V,1o:7.46.S(7)});j Y.5s([j Y.3o(7.2K,{3n:1T,2u:0,2v:1}),j Y.44(7.3r,{3n:1T})],{V:7.V,1S:0.45,1o:f(){9(7.1C){7.1C.5r("12:7s")}}.S(7)});9(7.h.1P()){j Y.1e({V:7.V,1o:7.5q.S(7)})}},6l:f(){9(!7.12.3L()){z}j Y.5s([j Y.3o(7.3r,{3n:1T,2u:1,2v:0}),j Y.3o(7.2K,{3n:1T,2u:1,2v:0})],{V:7.V,1S:0.35});j Y.1e({V:7.V,1o:f(){7.1U.1x("").13();7.1M.1x("").13();7.4Y();7.3O.q({1z:7.1u.22.m+"r"})}.S(7)})},5p:f(){7.4i.13();7.1r.13();7.1I.13();7.3y.13();7.2E.13()},3c:f(){7.5p();9(!7.h.o.1F){7.2S={k:0,m:0};7.41=0;7.1F.13();z 2e}10{7.1F.17()}7.1F[(7.h.3J()?"6f":"1Z")+"7o"]("7m");9(7.h.1r||7.h.1I){7.4i.17()}9(7.h.1r){7.1r.1x(7.h.1r).17()}9(7.h.1I){7.1I.1x(7.h.1I).17()}9(7.1f&&7.1f.1V>1){7.3y.17().5f().1x(j 6y(7.o.7l).4W({1n:7.1n+1,7k:7.1f.1V}));9(7.o.2E.1K){7.2E.17();7.2G.17()}}7.5n();7.5m()},5n:f(){n E=7.1u.58.k,D=7.1u.4p.k,G=7.1u.56.k,A=7.1p?7.1p.k:7.1y.k,F=7j,C=0,B=7.o.7i;9(7.h.o.22){B=1m}10{9(!7.h.3p()){B="1B("+7.1l+"7h.26)";C=G}10{9(A>=F+E&&A<F+D){B="1B("+7.1l+"7f.26)";C=E}10{9(A>=F+D){B="1B("+7.1l+"7e.26)";C=D}}}}9(C>0){7.4s.q({k:C+"r"}).17()}10{7.4s.13()}9(B){7.4m.q({1O:B})}7.41=C},4z:f(){7.40=j Y.44(7.2L,{1S:0.3,2u:0,2v:1,V:7.V})},3h:f(){9(7.40){Y.2I.2M("12").1Z(7.40)}j Y.5k(7.2L,{1S:1,V:7.V})},5j:f(){9(!7.h.2D()){z}n D=(7.o.3j||7.1n!=0),B=(7.o.3j||(7.h.1P()&&7.2A().1t!=0));7.3g[D?"17":"13"]();7.3R[B?"17":"13"]();n C=7.1p||7.1y;7.1L.q({m:C.m+"r"});n A=((C.k/2-1)+7.1b).2V();9(D){7.1L.y(7.2z=j u("X",{U:"21 7d"}).q({k:A+"r"}));7.2z.3s="2Z"}9(B){7.1L.y(7.2w=j u("X",{U:"21 7c"}).q({k:A+"r"}));7.2w.3s="1t"}9(D||B){7.1L.17()}},5q:f(){9(!7.h.2D()){z}7.5j();7.1L.17()},46:f(){7.1L.1x("").13();7.3g.13().q({1v:7.1s.k+"r"});7.3R.13().q({1v:-1*7.1s.k+"r"})},6k:f(){9(7.12.1H("24")!=0){z}n A=f(){9(!W.14.2m){7.12.17()}7.12.1R(1)}.S(7);9(7.o.1D.1K){j Y.44(7.1D,{1S:0.4,2u:0,2v:7.4F?1:7.o.1D.24,V:7.V,7b:7.3Y.S(7),1o:A})}10{A()}},13:f(){9(W.14.2m){n A=$$("33#1Q")[0];9(A){3v{A.5L()}3u(B){}}}9(7.12.1H("24")==0){z}7.2q();7.1L.13();7.2K.13();9(Y.2I.2M("3X").7a.1V>0){z}Y.2I.2M("12").1j(f(C){C.4Z()});j Y.1e({V:7.V,1o:7.4l.S(7)});j Y.3o(7.12,{1S:0.1,2u:1,2v:0,V:{1n:"43",2T:"3X"}});j Y.5k(7.1D,{1S:0.4,V:{1n:"43",2T:"3X"},1o:7.5i.S(7)})},5i:f(){9(!W.14.2m){7.12.13()}10{7.12.q({1v:"-3l",1z:"-3l"})}7.2K.1R(0).17();7.1L.1x("").13();7.1U.1x("").13();7.1M.1x("").13();7.4K();7.5w();9(7.1C){7.1C.5r("12:3A")}7.4Y();7.1C=1m;7.1f=1m;7.h=1m;7.1p=1m},5m:f(){n B={},A=7[(7.1p?"5I":"i")+"5H"].k;7.1F.q({k:A+"r"});7.3B.q({k:A-7.41-1+"r"});B=7.3G(7.1F);7.1F.q({k:"7w%"});7.2S=7.h.o.1F?B:{k:B.k,m:0}},3b:f(){n B=7.12.2i();9(W.14.27){7.12.q({1c:"50%",1g:"50%"})}10{9(W.14.2m||W.14.2h){n A=19.2g.2i(),C=19.2g.5t();7.12.q({1v:0,1z:0,1g:(C[0]+(A.k/2)-(B.k/2)).2V()+"r",1c:(C[1]+(A.m/2)-(B.m/2)).2V()+"r"})}10{7.12.q({1n:"5A",1g:"50%",1c:"50%",1v:(0-B.k/2).2O()+"r",1z:(0-B.m/2).2O()+"r"})}}},5h:f(){7.2q();7.2N=1T;7.1t.S(7).2o(0.25);7.2G.q({1O:"1B("+7.1l+"76.26) 1c 1g 2C-2J"}).13()},2q:f(){9(7.2N){7.2N=2e}9(7.48){75(7.48)}7.2G.q({1O:"1B("+7.1l+"4c.26) 1c 1g 2C-2J"})},6N:f(){7[(7.2N?"4o":"4f")+"74"]()},5z:f(){9(7.2N){7.48=7.1t.S(7).2o(7.o.2E.2o)}},5P:f(){7.4b=[];n A=$$("a[72^=12]");A.1j(f(B){B.5N();j 1k.4N(B);B.18("2r",7.17.71(B).2l(f(E,D){D.4o();E(D)}).1h(7));9(B.1G.2D()){9(7.o.70){B.18("2c",7.5b.S(7,B.1G))}n C=A.6Z(f(D){z D.1i==B.1i});9(C[0].1V){7.4b.3t({1i:B.1G.1i,4M:C[0]});A=C[1]}}}.S(7))},4P:f(A){z 7.4b.6p(f(B){z B.1i==A})},4V:f(A){z 7.4P(A).4M.59("1G")},5M:f(){$(19.3P).18("2r",7.5W.1h(7));$w("2c 29").1j(f(C){7.1L.18(C,f(D){n E=D.57("X");9(!E){z}9(7.2z&&7.2z==E||7.2w&&7.2w==E){7.3w(D)}}.1h(7))}.S(7));7.1L.18("2r",f(D){n E=D.57("X");9(!E){z}n C=(7.2z&&7.2z==E)?"2s":(7.2w&&7.2w==E)?"1t":1m;9(C){7[C].2l(f(G,F){7.2q();G(F)}).S(7)()}}.1h(7));$w("2Z 1t").1j(f(C){7[C+"2x"].18("2c",7.3w.1h(7)).18("29",7.3w.1h(7)).18("2r",7[C=="1t"?C:"2s"].2l(f(E,D){7.2q();E(D)}).1h(7))}.S(7));n B=7.3Z.2Q("a.21");9(!W.14.2m){B.1j(f(C){C.18("2c",u.1R.S(7,C,7.o.3D.24.6X)).18("29",u.1R.S(7,C,7.o.3D.24.4k))}.S(7))}10{B.2W("1R",1)}7.4m.18("2r",7.13.1h(7));7.2G.18("2r",7.6N.1h(7));9(W.14.2m||W.14.2h){n A=f(D,C){9(7.12.1H("1c").3W(0)=="-"){z}D(C)};1e.18(1X,"3x",7.3b.2l(A).1h(7));1e.18(1X,"3S",7.3b.2l(A).1h(7))}9(W.14.2h){1e.18(1X,"3S",7.3Y.1h(7))}7.12.18("2c",7.30.1h(7)).18("29",7.30.1h(7));7.3O.18("2c",7.30.1h(7)).18("29",7.30.1h(7)).18("2r",7.13.1h(7))},30:f(C){n B=C.11;9(!7.h){B="29"}10{9(!(7.h&&7.h.o&&7.h.o.22&&(7.2K.6V()==1))){z}}9(7.3V){Y.2I.2M("54").1Z(7.3V)}n A={1z:((B=="2c")?0:7.1u.22.m)+"r"};7.3V=j Y.53(7.3O,{60:A,1S:0.2,V:{2T:"54",6a:1},2o:(B=="29"?0.3:0)})},67:f(){n A={};$w("k m").1j(f(E){n C=E.2y();n B=19.6U;A[E]=W.14.3k?[B["6T"+C],B["3x"+C]].6S():W.14.3i?19.3P["3x"+C]:B["3x"+C]});z A},3Y:f(){9(!W.14.2h){z}7.1D.q(7.1N(19.2g.2i()));7.1D.q(7.1N(7.67()))},5W:f(A){9(A.31&&(A.31==7.1D||A.31==7.4E||A.31==7.6m)){7.13()}},3w:f(E){n C=E.31,B=C.3s,A=7.1s.k,F=(E.11=="2c")?0:B=="2Z"?A:-1*A,D={1v:F+"r"};9(!7.34){7.34={}}9(7.34[B]){Y.2I.2M("65"+B).1Z(7.34[B])}7.34[B]=j Y.53(7[B+"2x"],{60:D,1S:0.2,V:{2T:"65"+B,6a:1},2o:(E.11=="29"?0.1:0)})},2A:f(){9(!7.1f){z}n D=7.1n,C=7.1f.1V;n B=(D<=0)?C-1:D-1,A=(D>=C-1)?0:D+1;z{2s:B,1t:A}},5l:f(F,G){n B=7.2F,E=7.1b,D=j u("6R",{2j:"6Q"+G,k:E+"r",m:E+"r"}),A={1c:(G.3W(0)=="t"),1g:(G.3W(1)=="l")};9(D&&D.4n&&D.4n("2d")){F.y(D);n C=D.4n("2d");C.6P=7.o.2k;C.6O((A.1g?B:E-B),(A.1c?B:E-B),B,0,9v.9u*2,1T);C.9t();C.6L((A.1g?B:0),0,E-B,E);C.6L(0,(A.1c?B:0),E,E-B)}10{F.y(j u("X").q({k:E+"r",m:E+"r",68:0,3K:0,1K:"6g",1n:"9p",9o:"3A"}).y(j u("v:9n",{9m:7.o.2k,9l:"9k",9j:7.o.2k,9i:(B/E*0.5).2P(2)}).q({k:2*E-1+"r",m:2*E-1+"r",1n:"3q",1g:(A.1g?0:(-1*E))+"r",1c:(A.1c?0:(-1*E))+"r"})))}},6n:f(){9(7.4A){z}$$("2Q","6H","33").2W("q",{2b:"3A"});7.4A=1T},5w:f(){$$("2Q","6H","33").2W("q",{2b:"3L"});7.4A=2e},1N:f(A){n B={};Z.6j(A).1j(f(C){B[C]=A[C]+"r"});z B},47:f(){z{k:7.1y.k,m:7.1y.m+7.2S.m}},5x:f(){n B=7.47(),A=2*7.1b;z{k:B.k+A,m:B.m+A}},5y:f(){n C=20,A=2*7.1s.m+C,B=19.2g.2i();z{k:B.k-A,m:B.m-A}}});Z.1d(1k,{5F:f(){7.3N=7.6E.1h(7);19.18("6D",7.3N)},4K:f(){9(7.3N){19.5N("6D",7.3N)}},6E:f(C){n B=9g.9d(C.6B).4R(),E=C.6B,F=7.h.1P()&&!7.4T,A=7.o.2E.1K,D;9(7.h.3p()){C.4o();D=(E==1e.6A||["x","c"].4S(B))?"13":(E==37&&F&&(7.o.3j||7.1n!=0))?"2s":(E==39&&F&&(7.o.3j||7.2A().1t!=0))?"1t":(B=="p"&&A&&7.h.1P())?"5h":(B=="s"&&A&&7.h.1P())?"2q":1m;9(B!="s"){7.2q()}}10{D=(E==1e.6A)?"13":1m}9(D){7[D]()}9(F){9(E==1e.96&&7.1f.6v()!=7.h){7.17(7.1f.6v())}9(E==1e.95&&7.1f.6t()!=7.h){7.17(7.1f.6t())}}}});Z.1d(1k,{6e:f(){9(7.1f.1V==0){z}n A=7.2A();7.4I([A.1t,A.2s])},4I:f(C){n A=(7.1f&&7.1f.4S(C)||Z.93(C))?7.1f:C.1i?7.4V(C.1i):1m;9(!A){z}n B=$A(Z.6i(C)?[C]:C.11?[A.1J(C)]:C).92();B.1j(f(F){n D=A[F],E=D.1a;9(D.3M||D.4J||!E){z}n G=j 2t();G.1w=f(){G.1w=W.23;D.4J=1m;7.6r(D,G)}.S(7);G.1q=E}.S(7))},6r:f(A,B){A.3M={k:B.k,m:B.m}},5b:f(A){9(A.3M||A.4J){z}7.4I(A)}});Z.1d(1k,{6q:f(A){n B;$w("2Y 3a 2a 2p").1j(f(C){9(j 6o("\\\\.("+7.90[C].2B(/\\s+/g,"|")+")(\\\\?.*)?","i").4r(A)){B=C}}.S(7));9(B){z B}9(A.4L("#")){z"3C"}9(19.6u&&19.6u!=(A).2B(/(^.*\\/\\/)|(:.*)|(\\/.*)/g,"")){z"2a"}z"3a"},6c:f(A){n B=A.8Y(/\\?.*/,"").3z(/\\.([^.]{3,4})$/);z B?B[1]:1m},4g:f(B){n C="<"+B.1A;8X(n A 5T B){9(!["32","4O","1A"].4S(A)){C+=" "+A+\'="\'+B[A]+\'"\'}}9(j 6o("^(?:8W|8V|8U|5o|8T|8S|8R|6b|8Q|8P|98|8N|28|8M|8L|9b)$","i").4r(B.1A)){C+="/>"}10{C+=">";9(B.32){B.32.1j(f(D){C+=7.4g(D)}.S(7))}9(B.4O){C+=B.4O}C+="</"+B.1A+">"}z C}});(f(){19.18("4t:4q",f(){n B=(2H.4U&&2H.4U.1V),A=f(D){n C=2e;9(B){C=($A(2H.4U).59("1Y").6G(",").1J(D)>=0)}10{3v{C=j 8J(D)}3u(E){}}z!!C};1X.1k.4Q=(B)?{2Y:A("9e 9f"),2p:A("4H")}:{2Y:A("6h.6h"),2p:A("4H.4H")}})})();1k.4N=8G.8F({8E:f(b){n c=Z.6F(b);9(c&&!b.1G){b.1G=7;9(b.1r){b.1G.4w=b.1r;9(1k.o.8C){b.1r=""}}}7.1a=c?b.8A("1a"):b.1a;9(7.1a.1J("#")>=0){7.1a=7.1a.66(7.1a.1J("#"))}9(b.1i&&b.1i.4L("36")){7.11="36";7.1i=b.1i}10{9(b.1i){7.11=b.1i;7.1i=b.1i}10{7.11=1k.6q(7.1a);7.1i=7.11}}$w("2R 2Y 36 2a 3a 3C 2p 1M 1U").1j(f(a){n T=a.2y(),t=a.4R();9("3a 36 1U 1M".1J(a)<0){7["8z"+T]=f(){z 7.11==t}.S(7)}}.S(7));9(c&&b.1G.4w){n d=b.1G.4w.8x(1k.o.9s).2W("8w");9(d[0]){7.1r=d[0]}9(d[1]){7.1I=d[1]}n e=d[2];7.o=(e&&Z.6C(e))?8t("({"+e+"})"):{}}10{7.1r=b.1r;7.1I=b.1I;7.o=b.o||{}}9(7.o.4C){7.o.2R=Z.3H(7.o.4C);5K 7.o.4C}},1P:f(){z 7.11.4L("36")},2D:f(){z(7.1P()||7.11=="3a")},3J:f(){z"2a 3C 2R".1J(7.11)>=0},3p:f(){z!7.3J()},9y:f(){z"2p".1J(7.11)>=-1}});1k.5e();19.18("4t:4q",1k.4f.S(1k));',62,593,'|||||||this||if||||||function||view||new|width||height|var|options||setStyle|px|||Element||||insert|return|||||||||||||||||||bind||className|queue|Prototype|div|Effect|Object|else|type|lightview|hide|Browser|||show|observe|document|href|border|top|extend|Event|views|left|bindAsEventListener|rel|each|Lightview|images|null|position|afterFinish|scaledInnerDimensions|src|title|sideDimensions|next|closeDimensions|marginLeft|onload|update|innerDimensions|marginTop|tag|url|element|overlay|li|menubar|_view|getStyle|caption|indexOf|display|prevnext|external|pixelClone|background|isGallery|lightviewContent|setOpacity|duration|true|media|length|break|window|name|remove||lv_Button|topclose|emptyFunction|opacity||jpg|IE6|param|mouseout|iframe|visibility|mouseover||false|case|viewport|Gecko|getDimensions|id|backgroundColor|wrap|WebKit419|value|delay|quicktime|stopSlideshow|click|previous|Image|from|to|nextButton|ButtonImage|capitalize|prevButton|getSurroundingIndexes|replace|no|isImage|slideshow|radius|slideshowButton|navigator|Queues|repeat|center|loading|get|sliding|round|toFixed|select|ajax|menuBarDimensions|scope|lightviewError|floor|invoke|ul|flash|prev|toggleTopClose|target|children|object|sideEffect||gallery||lv_Fill||image|restoreCenter|fillMenuBar|inlineMarker|inlineContent|afterEffect|prevButtonImage|stopLoading|WebKit|cyclic|IE|10000px|zIndex|sync|Opacity|isMedia|absolute|sideButtons|side|push|catch|try|toggleSideButton|scroll|imgNumber|match|hidden|data|inline|buttons|onComplete|resizeWithinViewport|getHiddenDimensions|clone|switch|isExternal|padding|visible|preloadedDimensions|keyboardEvent|topcloseButtonImage|body|png|nextButtonImage|resize|lv_Corner|lv_Wrapper|topCloseEffect|charAt|lightview_hide|maxOverlay|container|loadingEffect|closeButtonWidth|parseInt|end|Appear||hidePrevNext|getInnerDimensions|slideTimer|gif|userAgent|sets|slideshow_play|scale|controls|start|createHTML|convertVersionString|dataText|tagName|normal|restoreInlineContent|closeButton|getContext|stop|large|loaded|test|closeWrapper|dom|auto|autosize|_title|insertContent|fullscreen|startLoading|preventingOverlap|resizeCenter|ajaxOptions|pluginspage|topButtons|pngOverlay|pluginspages|QuickTime|preloadFromSet|isPreloading|disableKeyboardNavigation|startsWith|elements|View|html|getSet|Plugin|toLowerCase|member|resizing|plugins|getViews|evaluate|require|clearContent|cancel||prepare|mac|Morph|lightview_topCloseEffect|Scriptaculous|innertop|findElement|small|pluck|sizingMethod|preloadImageHover|prevSide|DXImageTransform|load|down|isMac|startSlideshow|afterHide|setPrevNext|Fade|createCorner|setMenuBarDimensions|setCloseButtons|br|hideData|showPrevNext|fire|Parallel|getScrollOffsets|transition|_|showOverlapping|getOuterDimensions|getBounds|nextSlide|fixed|showContent|finishShow|isIframe|isAjax|enableKeyboardNavigation|afterShow|nnerDimensions|scaledI|adjustDimensionsToView|delete|Stop|addObservers|stopObserving|AlphaImageLoader|updateViews|Microsoft|progid|build|in|SetControllerVisible|isQuicktime|bodyClick|REQUIRED_|mimetypes|loop|style|filter|autoplay|default|before|lightview_side|substr|getScrollDimensions|margin|scrolling|limit|img|detectExtension|lv_WrapDown|preloadSurroundingImages|add|block|ShockwaveFlash|isNumber|keys|appear|hideContent|loadingButton|hideOverlapping|RegExp|find|detectType|setPreloadedDimensions|lv_Frame|last|domain|first|namespaces|lv_CornerWrapper|Template|lv_Half|KEY_ESC|keyCode|isString|keydown|keyboardDown|isElement|join|embed|marginRight|_inlineDisplayRestore|lv_Filler|fillRect|nextSide|toggleSlideshow|arc|fillStyle|corner|canvas|max|offset|documentElement|getOpacity|close_|hover|lv_PrevSide|partition|preloadHover|curry|class|lv_Sides|Slideshow|clearTimeout|slideshow_stop|float|right|lv_Container|effects|beforeStart|lv_NextButton|lv_PrevButton|close_large|close_small|addClassName|close_innertop|borderColor|180|total|imgNumberTemplate|lv_MenuTop|bl|ClassName|tr|tl|times|opened|resizeDuration|Tween|blank|100|isInline|lv_PrevNext|cloneNode|frames|lv_FrameBottom|parentNode|innerHTML|lv_Loading|clientHeight|clientWidth|lv_External|requires|ancestors|throw|flashvars|FlashVars|movie|high|quality|lv_Slideshow|classids|classid|codebases|codebase|lv_ImgNumber|enablejavascript|controller|lv_Caption|Version|REQUIRED_Scriptaculous|tofit|lv_Title|VML|lv_DataText|lv_Data|wrapperTag|behavior|hspace|addRule|frameBorder|Updater|createStyleSheet|undefined|Ajax|lv_Close|lv_MenuBar|lv_Media|vml|typeof|galleryimg|alt|lv_WrapCenter|com|lv_WrapUp|microsoft|150|lv_Center|schemas|eval|defaultOptions|urn|strip|split|lv_HalfRight|is|getAttribute|required|removeTitles|plugin|initialize|create|Class|REQUIRED_Prototype|requiresPlugin|ActiveXObject|errors|spacer|range|meta|lv_HalfLeft|link|input|hr|frame|col|basefont|base|area|for|gsub|lv_Liquid|typeExtensions|lv_FrameTop|uniq|isArray|lv_Frames|KEY_END|KEY_HOME|lv_topcloseButtonImage|isindex|script|blur|wbr|lv_topButtons|fromCharCode|Shockwave|Flash|String|head|arcSize|strokeColor|1px|strokeWeight|fillcolor|roundrect|overflow|relative|after|lv_NextSide|titleSplit|fill|PI|Math|js|MSIE|isVideo'.split('|'),0,{}));

function showBox(id){
    element = $(id);
	if (!element) {
		
		Lightview.show({
		  href: site_url+'/information/viewAjax/'+id,
		  rel: 'ajax',
		  options: {
		    autosize: true,
		    topclose: true,
		    ajax: {
		      method: 'post',
		      onSuccess: function(transport){
		      var response = transport.responseText;
				/*alert(response);*/
		      }
			}
		  }
		});	
	} else {
	Lightview.show({href:'#'+id,options: true});
	Field.focus('username');
	}
}

function showUrl(url){
		Lightview.show({
		  href: site_url+url,
		  rel: 'ajax',
		  options: {
		    autosize: true,
		    topclose: true,
		    ajax: {
		      method: 'post',
		      onSuccess: function(transport){
		      var response = transport.responseText;
				/*alert(response);*/
		      }
			}
		  }
		});	
}

// ============================
// = Tab Javascript Interface =
// ============================
//
// Author: Clark Endrizzi
//
// (documentation)
// ============================
if(!Control) var Control = {};

Control.DynamicTabs = Class.create({
	initialize: function (tab_num, content_div, ajax_url, options){
		// Variables
		this.tab_num = tab_num;
		this.content_div = content_div;
		this.ajax_url = ajax_url;
		this.tabs = new Array();
		for(var i = 1; i <= tab_num; i++){
			this.tabs[(i - 1)] = "dyn_tab_"+i;
		}
		this.links = new Array();
		for(var i = 1; i <= tab_num; i++){
			this.links[(i - 1)] = "dyn_text_"+i;
		}
		// We have a lot of defaults that we use if not defined
		this.options = Object.extend({
			initial_tab : 1
		}, options || {});	
		// Now set up the events
		for(var i = 1; i <= tab_num; i++){
			Event.observe( $(this.links[(i-1)]), 'click', this.ChangeTab.bindAsEventListener(this, i) );
		}
		// Get initial content
		this.ChangeTab(null, this.options.initial_tab);
	}, 
	ChangeTab : function(event, tab_num){
		// Reset tab classes to non-selected
		this.tabs.each(function(s) {
			if($(s).hasClassName('selected')) {
				$(s).removeClassName('selected');
			}
		});
 		// Reset link classes to non-selected
 		this.links.each(function(s) {
 			if($(s).hasClassName('selected')) {
 				$(s).removeClassName('selected');
			}
		});
		// Add classes for newly selected
		$('dyn_tab_'+tab_num).addClassName('selected');
		$('dyn_text_'+tab_num).addClassName('selected');
		// Update Content Section
		this.UpdateTabContent(tab_num);
	},
	UpdateTabContent : function(tab_num){
		new Ajax.Updater(this.content_div, this.ajax_url+tab_num);
	}
});