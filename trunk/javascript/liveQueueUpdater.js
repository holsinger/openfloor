//init obj
if(typeof liveQueueUpdater === "undefined" || !liveQueueUpdater) {
	var liveQueueUpdater = {
		savingMsg: "Saving ..."
	};
}

liveQueueUpdater.liveQueueUpdate = function() {
	new Ajax.PeriodicalUpdater('current_question', site_url + '/forums/liveQueue/' + event_name + '/current_question', {
	  frequency: 10
	});
	//new Effect.Opacity ('upcoming_questions',{duration:.5, from:1.0, to:0.7});
	new Ajax.PeriodicalUpdater('upcoming_questions', site_url + '/forums/liveQueue/' + event_name + '/upcoming_questions', {
	  frequency: 10
	});
}