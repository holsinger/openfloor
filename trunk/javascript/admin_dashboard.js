//init obj
if(typeof admin_dashboard === "undefined" || !admin_dashboard) {
	var admin_dashboard = {
		savingMsg: "Saving ..."
	};
}

admin_dashboard.init = function() {
	new Ajax.PeriodicalUpdater('current_question', site_url + 'admin/dashboard/' + event_name + '/current_question/', {
	  frequency: 5
	});
	new Ajax.PeriodicalUpdater('upcoming_question', site_url + 'admin/dashboard/' + event_name + '/upcoming_question/', {
	  frequency: 5
	});
	new Ajax.PeriodicalUpdater('last_10_users', site_url + 'admin/dashboard/' + event_name + '/last_10_users/', {
	  frequency: 5
	});
	new Ajax.PeriodicalUpdater('last_10_flags', site_url + 'admin/dashboard/' + event_name + '/last_10_flags/', {
	  frequency: 5
	});
	new Ajax.PeriodicalUpdater('last_10_questions', site_url + 'admin/dashboard/' + event_name + '/last_10_questions/', {
	  frequency: 5
	});
}