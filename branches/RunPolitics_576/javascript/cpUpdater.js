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
	
	new Ajax.PeriodicalUpdater('upcoming_questions', site_url + '/conventionnext/cp/' + event_name + '/upcoming_questions', {
	  frequency: 10
	});
	
	cans.each(function(s) {
		new Ajax.PeriodicalUpdater('overall-' + s, site_url + '/conventionnext/cp/' + event_name + '/overall_reaction/' + s, {
		  frequency: 10
		});
	});
}