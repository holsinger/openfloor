//init obj
if(typeof queueUpdater === "undefined" || !queueUpdater) {
	var queueUpdater = {
		savingMsg: "Saving ..."
	};
}

queueUpdater.updateQueue = function() {
	queueUpdater.updaterObject = new Ajax.PeriodicalUpdater('queue', site_url + '/conventionnext/ajQueueUpdater/' + event_name + '/' + sort + '/' + offset + '/' + tag, {
	  frequency: 10
	});
}

queueUpdater.updateQueueOnce = function() {
	
	new Ajax.Updater('queue', site_url + '/conventionnext/ajQueueUpdater/' + event_name + '/' + sort + '/' + offset + '/' + tag);
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
	style = $(element).getStyle('display') == 'none' ? {display:'block'} : {display:'none'};
	$(element).setStyle(style);
}