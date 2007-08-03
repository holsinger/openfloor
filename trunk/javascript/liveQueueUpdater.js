//init obj
if(typeof liveQueueUpdater === "undefined" || !liveQueueUpdater) {
	var liveQueueUpdater = {
		savingMsg: "Saving ..."
	};
}

liveQueueUpdater.liveQueueUpdate = function() {
	new Ajax.PeriodicalUpdater('current_question', site_url + '/conventionnext/liveQueue/' + event_name + '/current_question', {
	  frequency: 10
	});
	new Ajax.PeriodicalUpdater('upcoming_questions', site_url + '/conventionnext/liveQueue/' + event_name + '/upcoming_questions', {
	  frequency: 10
	});
}