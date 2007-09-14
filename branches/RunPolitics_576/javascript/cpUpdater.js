//init obj
if(typeof cpUpdater === "undefined" || !cpUpdater) {
	var cpUpdater = {
		savingMsg: "Saving ..."
	};
}

cpUpdater.cpUpdateOnce = function() {
	new Ajax.Updater('current_question', site_url + 'conventionnext/cp/' + event_name + '/current_question');
	
	new Ajax.Updater('upcoming_questions', site_url + 'conventionnext/cp/' + event_name + '/upcoming_questions');
	
	cans.each(function(s) {
		new Ajax.Updater('overall-reaction-' + s, site_url + 'conventionnext/cp/' + event_name + '/overall_reaction/' + s);
	});
}

cpUpdater.cpUpdate = function() {
	updaters = new Array();
	
	updaters.push(new Ajax.PeriodicalUpdater('current_question', site_url + 'conventionnext/cp/' + event_name + '/current_question', {
	  frequency: 10
	}));
	
	updaters.push(new Ajax.PeriodicalUpdater('upcoming_questions', site_url + 'conventionnext/cp/' + event_name + '/upcoming_questions', {
	  frequency: 10
	}));
	
	cans.each(function(s) {
		updaters.push(new Ajax.PeriodicalUpdater('overall-reaction-' + s, site_url + 'conventionnext/cp/' + event_name + '/overall_reaction/' + s, {
		  frequency: 10
		}));
	});
}

cpUpdater.askQuestion = function() {
	form = $('add_question_form');
	
	new Ajax.Request(site_url + 'question/add/event/' + event_name, {
		parameters: {
			'event'		: $F(form['event']),
			'question'	: $F(form['question']),
			'desc'		: $F(form['desc']),
			'tags'		: $F(form['tags']),
			'ajax'		: 'true'
		},
		onSuccess: function(transport) {
			if(transport.responseText=='success') {
				form['question'].clear();
				form['desc'].clear();
				form['tags'].clear();
				new Effect.toggle('cp-ask-question','blind', {queue: 'end'});
			} else {
				$('cp-ask-question').innerHTML = transport.responseText;
			}
		}
	});
}

cpUpdater.toggleAJAX = function () {
	if(ajaxOn) { ajaxOn=false; updaters.each(function(s) {
			s.stop();
		}); 
	}
	else { ajaxOn=true; updaters.each(function(s) {
			s.start();
		}); 
	}
}

cpUpdater.viewVotes = function(question_id) {
	if(ajaxOn) {
		cpUpdater.toggleAJAX();
		cpUpdater.populateVotes(question_id);
	} else {
		cpUpdater.populateVotes(question_id);
		cpUpdater.toggleAJAX();
	}
}

cpUpdater.viewComments = function(question_id, event_name, question_name) {
	if(ajaxOn) {
		cpUpdater.toggleAJAX();
		cpUpdater.populateComments(question_id, event_name, question_name);
	} else {
		cpUpdater.populateComments(question_id, event_name, question_name);
		cpUpdater.toggleAJAX();
	}
}

cpUpdater.populateVotes = function (question_id) {
	new Ajax.Updater('cp-votes-' + question_id, site_url + 'votes/who/' + question_id, {
		parameters: {
			'ajax' : 'true'
		},
		onSuccess: function(transport) {
			javascript:new Effect.toggle('cp-votes-' + question_id,'blind', {queue: 'end'});			
		}
	});
}

cpUpdater.populateComments = function (question_id, event_name, question_name) {
	new Ajax.Updater('cp-comments-' + question_id, site_url + 'question/view/' + event_name + '/' + question_name, {
		parameters: {
			'ajax' : 'true'
		},
		onSuccess: function(transport) {
			javascript:new Effect.toggle('cp-comments-' + question_id,'blind', {queue: 'end'});			
		}
	});
}