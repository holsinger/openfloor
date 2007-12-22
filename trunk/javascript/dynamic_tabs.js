// ============================
// = Tab Javascript Interface =
// ============================
//
// Author: Clark Endrizzi
//
// (documentation)
// ============================
if(!Control) var Control = {};

Control.DynamicTabs = Class.create({
	initialize: function (tab_num, content_div, ajax_url, options){
		// Variables
		this.tab_num = tab_num;
		this.content_div = content_div;
		this.ajax_url = ajax_url;
		this.tabs = new Array();
		for(var i = 1; i <= tab_num; i++){
			this.tabs[(i - 1)] = "dyn_tab_"+i;
		}
		this.links = new Array();
		for(var i = 1; i <= tab_num; i++){
			this.links[(i - 1)] = "dyn_text_"+i;
		}
		// We have a lot of defaults that we use if not defined
		this.options = Object.extend({
			initial_tab : 1
		}, options || {});	
		// Now set up the events
		for(var i = 1; i <= tab_num; i++){
			Event.observe( $(this.links[(i-1)]), 'click', this.ChangeTab.bindAsEventListener(this, i) );
		}
		// Get initial content
		this.ChangeTab(null, this.options.initial_tab);
	}, 
	ChangeTab : function(event, tab_num){
		// Reset tab classes to non-selected
		this.tabs.each(function(s) {
			if($(s).hasClassName('selected')) {
				$(s).removeClassName('selected');
			}
		});
 		// Reset link classes to non-selected
 		this.links.each(function(s) {
 			if($(s).hasClassName('selected')) {
 				$(s).removeClassName('selected');
			}
		});
		// Add classes for newly selected
		$('dyn_tab_'+tab_num).addClassName('selected');
		$('dyn_text_'+tab_num).addClassName('selected');
		// Update Content Section
		this.UpdateTabContent(tab_num);
	},
	UpdateTabContent : function(tab_num){
		new Ajax.Updater(this.content_div, this.ajax_url+tab_num);
	}
});