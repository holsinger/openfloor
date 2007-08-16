//init obj
if(typeof cpUpdater === "undefined" || !cpUpdater) {
	var cpUpdater = {
		savingMsg: "Saving ..."
	};
}

cpUpdater.cpUpdate = function() {
	new Ajax.PeriodicalUpdater('current_question', site_url + '/conventionnext/cp/' + event_name + '/current_question', {
	  frequency: 10
	});
	//new Effect.Opacity ('upcoming_questions',{duration:.5, from:1.0, to:0.7});
	new Ajax.PeriodicalUpdater('upcoming_questions', site_url + '/conventionnext/cp/' + event_name + '/upcoming_questions', {
	  frequency: 10
	});
}