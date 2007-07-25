//init obj
if(typeof queueUpdater === "undefined" || !queueUpdater) {
	var queueUpdater = {
		savingMsg: "Saving ..."
	};
}

queueUpdater.updateQueue = function() {
	new Ajax.PeriodicalUpdater('queue', site_url + '/conventionnext/ajQueueUpdater' + window.location.pathname, {
	  frequency: 10
	});
}

queueUpdater.updateQueueOnce = function() {
	new Ajax.Updater('queue', site_url + '/conventionnext/ajQueueUpdater' + window.location.pathname);
}

queueUpdater.vote = function(url) {
	new Ajax.Request(url, {
	  onSuccess: function(transport) {
		  queueUpdater.updateQueueOnce();
	      console.log('successfully voted!');
	  }
	});
}