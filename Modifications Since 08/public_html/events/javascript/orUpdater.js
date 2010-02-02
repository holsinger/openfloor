//init obj
if(typeof orUpdater === "undefined" || !orUpdater) {
	var orUpdater = {
		savingMsg: "Saving ..."
	};
}

orUpdater.orUpdate = function() {
	cans.each(function(s) {
		new Ajax.PeriodicalUpdater('overall-reaction-' + s, site_url + 'forums/overall_reaction/' + event_name + '/overall_reaction/' + s, {
		  frequency: 3
		});
	});	
}

