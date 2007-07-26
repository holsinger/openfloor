//init obj
if(typeof queueUpdater === "undefined" || !queueUpdater) {
	var queueUpdater = {
		savingMsg: "Saving ..."
	};
}

queueUpdater.updateQueue = function(e_key, e_val) {
	new Ajax.PeriodicalUpdater('queue', site_url + '/conventionnext/ajQueueUpdater/' + e_key + '/' + e_val, {
	  frequency: 10
	});
}

queueUpdater.updateQueueOnce = function() {
	new Ajax.Updater('queue', site_url + '/conventionnext/ajQueueUpdater' + window.location.pathname);
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