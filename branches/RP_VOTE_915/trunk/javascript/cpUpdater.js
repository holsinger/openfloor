//init obj
if(typeof cpUpdater === "undefined" || !cpUpdater) {
	var cpUpdater = {
		savingMsg: "Saving ..."
	};
}

// vars
cpUpdater.current_question_id = 0;
cpUpdater.sliders = new Object;
var timer;
var i = 0;
var startHex = 0xFCC6CA;
var endHex = 0xEEF8FF;
var upOrDown = true;

// functions

function fadeHex (hex, hex2, ratio){
	var r = hex >> 16;
	var g = hex >> 8 & 0xFF;
	var b = hex & 0xFF;
	r += ((hex2 >> 16)-r)*ratio;
	g += ((hex2 >> 8 & 0xFF)-g)*ratio;
	b += ((hex2 & 0xFF)-b)*ratio;
	return(r<<16 | g<<8 | b);
}

function d2h(d) {
	return d.toString(16);
}

cpUpdater.cpUpdateOnce = function() {
	new Ajax.Updater('current_question', site_url + 'forums/cp/' + event_name + '/current_question');
	
	new Ajax.Updater('upcoming_questions', site_url + 'forums/cp/' + event_name + '/upcoming_questions/' + sort);
}

cpUpdater.vote = function(url) {
	// new Effect.Opacity (id,{duration:.5, from:1.0, to:0.7});
	new Ajax.Request(url, {
	  onSuccess: function(transport) {
		  cpUpdater.cpUpdateOnce();
	  }
	});
}

cpUpdater.cpUpdate = function() {
	updaters = new Array();
	
	updaters.push(new Ajax.PeriodicalUpdater('current_question', site_url + 'forums/cp/' + event_name + '/current_question', {
	  frequency: 10
	}));
	
	updaters.push(new Ajax.PeriodicalUpdater('upcoming_questions', site_url + 'forums/cp/' + event_name + '/upcoming_questions/' + sort, {
	  frequency: 10
	}));
	
	updaters.push(new Ajax.PeriodicalUpdater('user-reaction-ajax', site_url + 'forums/cp/' + event_name + '/reaction', {
	  frequency: 10,
	  evalScripts: true
	}));
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
	if(ajaxOn) { ajaxOn=false; updaters.each(function(s) {
			s.stop();
		}); 
	}
}

cpUpdater.enableAJAX = function() {
	if(!ajaxOn) { ajaxOn=true; updaters.each(function(s) {
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
		new Ajax.Updater('cp-votes-' + question_id, site_url + 'votes/who/' + question_id, {
			parameters: {
				'ajax' : 'true'
			},
			onSuccess: function(transport) {
				cpUpdater.toggleVisibility('cp-votes-' + question_id);
				cpUpdater.toggleAJAX();
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
		new Ajax.Updater('cp-comments-' + question_id, site_url + 'question/view/' + event_name + '/' + question_name, {
			parameters: {
				'ajax' : 'true'
			},
			onSuccess: function(transport) {
				cpUpdater.toggleVisibility('cp-comments-' + question_id);
				cpUpdater.toggleAJAX();
			}
		});
	}
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
	if(ajaxOn) { cpUpdater.disableAJAX(); }
	else if ($$('div[class=cp-comments]', 'div[class=cp-votes]').collect(function(n){ return n.getStyle('display'); }).indexOf('block') == -1) { cpUpdater.enableAJAX(); }
}

cpUpdater.toggleVisibility = function(element) {
	$$('div[class=cp-comments]', 'div[class=cp-votes]').without($(element)).invoke('setStyle', {display:'none'});
	style = $(element).getStyle('display') == 'none' ? {display:'block'} : {display:'none'};
	$(element).setStyle(style);
}

cpUpdater.current_question_fade = function() {
	timer = setInterval('ColorChange()', 75);
}

cpUpdater.change_sort = function(_sort) {
	sort = _sort;
	
	sort_links = new Array();
	sort_links = ['pending', 'newest', 'asked'];
	sort_links.without(_sort).each(function(s) {
		if($('sort-link-' + s).hasClassName('cp-sort-link-selected')) {
			$('sort-link-' + s).removeClassName('cp-sort-link-selected');
			$('sort-link-' + s).addClassName('cp-sort-link');
		}
	});
	
	if($('sort-link-' + _sort).hasClassName('cp-sort-link')) {
		$('sort-link-' + _sort).removeClassName('cp-sort-link');
		$('sort-link-' + _sort).addClassName('cp-sort-link-selected');
	}
	
	updaters.each(function(s) { s.stop(); });
	cpUpdater.cpUpdate();
	ajaxOn = true;
}

ColorChange = function() {
	var ratio = i/9;
	var nowColor = d2h(fadeHex(startHex, endHex, ratio));
	$('the-current-question').setStyle({'background-color': '#' + nowColor});
	
	if(i == 9) {
		// startHex = 0xEEF8FF;
		// endHex = 0xFCC6CA;
		upOrDown = false;
	}
	
	if(upOrDown) i++;
	
	if(i == 0) {
		upOrDown = true;
		clearInterval(timer);		
	}
	
	if(!upOrDown) i--;
	
}