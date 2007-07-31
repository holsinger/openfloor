//init obj
if(typeof queueUpdater === "undefined" || !queueUpdater) {
	var queueUpdater = {
		savingMsg: "Saving ..."
	};
}

queueUpdater.updateQueue = function() {
	new Ajax.PeriodicalUpdater('queue', site_url + '/conventionnext/ajQueueUpdater/' + event_name + '/' + sort + '/' + offset + '/' + tag, {
	  frequency: 10
	});
}

queueUpdater.updateQueueOnce = function() {
	
	new Ajax.Updater('queue', site_url + '/conventionnext/ajQueueUpdater/' + event_name + '/' + sort + '/' + offset + '/' + tag);
	//new Effect.SlideDown ('queue');
}


queueUpdater.vote = function(url) {	
	//new Effect.DropOut ('queue');
	if (username.length <= 0) {
		showBox('login');
		return;
	}
	//new Effect.Opacity (id,{duration:.5, from:1.0, to:0.7});
	new Ajax.Request(url, {
	  onSuccess: function(transport) {
		  queueUpdater.updateQueueOnce();
	  }
	});
}