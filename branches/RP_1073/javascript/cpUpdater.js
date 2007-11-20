//init obj
if(typeof cpUpdater === "undefined" || !cpUpdater) {
	var cpUpdater = {
		savingMsg: "Saving ..."
	};
}

// vars
cpUpdater.current_question_id = 0;
cpUpdater.sliders = new Object;
ajaxOn = true;
var sort = 'pending';

cpUpdater.cpUpdateOnce = function() {
	new Ajax.Updater('current_question', site_url + 'forums/cp/' + event_name + '/current_question');
}

cpUpdater.vote = function(url) {
	new Ajax.Request(url, {
		onSuccess: function(transport) {
			cpUpdater.cpUpdateOnce();
			lazy_loader.refreshView();
		}
	});
}

cpUpdater.cpUpdate = function() {
	updaters = new Array();
	
	updaters.push(new Ajax.PeriodicalUpdater('current_question', site_url + 'forums/cp/' + event_name + '/current_question', {
		frequency: 10,
		decay: 2
	}));
	
	updaters.push(new Ajax.PeriodicalUpdater('user-reaction-ajax', site_url + 'forums/cp/' + event_name + '/reaction', {
		frequency: 10,
		evalScripts: true,
		decay: 2
	}));
	
	cans.each(function(s) {
		updaters.push(new Ajax.PeriodicalUpdater('overall-reaction-' + s, site_url + 'forums/cp/' + event_name + '/overall_reaction/' + s, {
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

cpUpdater.disableAJAX = function() {
	if(lazy_loader.update && ajaxOn) {
		lazy_loader.stopUpdating();
		ajaxOn=false; 
		updaters.each(function(s) {
			s.stop();
		});
	}	
}

cpUpdater.enableAJAX = function() {
	if(!lazy_loader.update && !ajaxOn) {
		lazy_loader.startUpdating();
		ajaxOn=true; 
		updaters.each(function(s) {
			s.start();
		});
	}	
}

cpUpdater.viewVotes = function(question_id) {
	visible = !($('cp-votes-' + question_id).getStyle('display') == 'none');
	
	if(visible) {
		cpUpdater.toggleVisibility('cp-votes-' + question_id);
		cpUpdater.toggleAJAX();
	} else {
		my_loading_reminder.show();
		new Ajax.Updater('cp-votes-' + question_id, site_url + 'votes/who/' + question_id, {
			parameters: {
				'ajax' : 'true'
			},
			onSuccess: function(transport) {
				cpUpdater.toggleVisibility('cp-votes-' + question_id);
				cpUpdater.toggleAJAX();
				my_loading_reminder.hide();
			}
		});
	}	
}

cpUpdater.viewComments = function(question_id, event_name, question_name) {	
	visible = !($('cp-comments-' + question_id).getStyle('display') == 'none');
	
	if(visible) {	
		cpUpdater.toggleVisibility('cp-comments-' + question_id);
		cpUpdater.toggleAJAX();		
	} else {
		my_loading_reminder.show();
		new Ajax.Updater('cp-comments-' + question_id, site_url + 'question/view/' + event_name + '/' + question_name, {
			parameters: {
				'ajax' : 'true'
			},
			onSuccess: function(transport) {
				cpUpdater.toggleVisibility('cp-comments-' + question_id);
				cpUpdater.toggleAJAX();
				my_loading_reminder.hide();
			}
		});
	}
}

cpUpdater.change_comments_sort = function(question_id, event_name, question_name, sort) {
	my_loading_reminder.show();
	new Ajax.Updater('cp-comments-' + question_id, site_url + 'question/view/' + event_name + '/' + question_name + '/' + sort, {
		parameters: {
			'ajax' : 'true'
		},
		onSuccess: function(transport) {
			my_loading_reminder.hide();
		}
	});
}

cpUpdater.viewInfo = function(question_id) {
	cpUpdater.toggleVisibility('cp-info-' + question_id);
	cpUpdater.toggleAJAX();
}

cpUpdater.voteComment = function (url, question_id, event_name, question_name) {
	new Ajax.Request(url, {
		onSuccess: function(transport) {
			new Ajax.Updater('cp-comments-' + question_id, site_url + 'question/view/' + event_name + '/' + question_name, {
				parameters: {
					'ajax' : 'true'
				}
			});
		}
	});
}

cpUpdater.submitComment = function(question_id, event_name, question_name, parent_id) {
	// form = $('commenting_form_' + question_id);
	if(parent_id > 0) {
		form = $('subcommenting_form_' + parent_id);
	} else {
		form = $('commenting_form_' + question_id);
	}
	
	new Ajax.Request(site_url + 'comment/addCommentAction/', {
		parameters: {
			'parent_id'			: parent_id,
			'comment'			: $F(form['comment']),
			'fk_question_id'	: question_id,
			'event_name'		: $F(form['event_name']),
			'name'				: $F(form['name']),
			'event_type'		: $F(form['event_type']),
			'ajax'				: 'true'
		},
		onSuccess: function(transport) {
			new Ajax.Updater('cp-comments-' + question_id, site_url + 'question/view/' + event_name + '/' + question_name, {
				parameters: {
					'ajax' : 'true'
				}
			});
		}
	});
}

cpUpdater.toggleAJAX = function () {
	if(lazy_loader.update && ajaxOn) { cpUpdater.disableAJAX(); }
	else if ($$('div[class=cp-comments]', 'div[class=cp-votes]', 'div[class=cp-info]').collect(function(n){ return n.getStyle('display'); }).indexOf('block') == -1) { cpUpdater.enableAJAX(); }
}

cpUpdater.toggleVisibility = function(element) {
	$$('div[class=cp-comments]', 'div[class=cp-votes]', 'div[class=cp-info]').without($(element)).invoke('setStyle', {display:'none'});		// Hides all tabs first

	style = $(element).getStyle('display') == 'none' ? {display:'block'} : {display:'none'};
	$(element).setStyle(style);
}

cpUpdater.current_question_fade = function() {
	new Effect.Highlight('the-current-question', {startcolor: '#eef8ff', endcolor: '#fcc6ca', duration: 1.5});
	// timer = setInterval('ColorChange()', 75);
}

cpUpdater.change_sort = function(_sort) {
	sort = _sort;
	
	sort_links = new Array();
	// Event_timing defined in main.php, this needs to be a member variable when made a class
	
	// Change the question title
	if(sort == 'pending'){
		if(event_timing == 'past'){
			$('question_title').innerHTML = "Unanswered Questions";
		}else{
			$('question_title').innerHTML = "Upcoming Questions";
		}
	}else if(sort == 'newest'){
		$('question_title').innerHTML = "Newest Questions";
	}else{
		$('question_title').innerHTML = "Answered Questions";
	}
	// Change the highlights
	if(event_timing == 'past'){
		sort_links = ['pending', 'asked'];
	}else{
		sort_links = ['pending', 'newest', 'asked'];
	}
	sort_links.without(_sort).each(function(s) {
		if($('sort-link-' + s + '-2').hasClassName('cp-sort-link-selected')) {
			$('sort-link-' + s + '-2').removeClassName('cp-sort-link-selected');
			$('sort-link-' + s + '-2').addClassName('cp-sort-link');
		}
	});

	if($('sort-link-' + _sort + '-2').hasClassName('cp-sort-link')) {
		$('sort-link-' + _sort + '-2').removeClassName('cp-sort-link');
		$('sort-link-' + _sort + '-2').addClassName('cp-sort-link-selected');
	}
	
	ajax_update_url = site_url + 'forums/cp/' + event_name + '/upcoming_questions/' + sort;
	ajax_count_url = site_url + 'forums/cp/' + event_name + '/upcoming_questions_count';
	
	lazy_loader.reset(ajax_update_url, ajax_count_url);
	
	// Should this be here?????
	updaters.each(function(s) { s.stop(); });
	cpUpdater.cpUpdate();
	ajaxOn = true;
}

cpUpdater.startLazyLoader = function() {
	lazy_loader = new Control.LazyLoader('upcoming_questions', upcoming_questions_url, upcoming_questions_count_url, {
		count_refresh_lapse: 100000, 
		view_refresh_lapse: 10000,
		onStartAddSection: function() { 
			my_loading_reminder.show(); 
		}, 
		onFinishAddSection: function() { 
			my_loading_reminder.hide(); 
		}
	});
}

