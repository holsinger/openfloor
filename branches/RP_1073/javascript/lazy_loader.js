// ===============
// = Lazy Loader Class =
// ===============
//
//
if(!Control) var Control = {};
Control.LazyLoader = Class.create();

Control.LazyLoader.prototype = {
	initialize: function (container_elem_id, ajax_update_url, initial_count, ajax_count_url, options){
		this.container_elem_id = container_elem_id;
		this.ajax_update_url = ajax_update_url;
		this.item_count = initial_count;
		this.ajax_count_url = ajax_count_url;
		this.segment_divs = new Array();
		this.segment_divs_last_refresh = new Array();
		this.segment_divs_view_range = new Array();
		
		// We have a lot of defaults that we use if not defined
		this.options = Object.extend({
			items_per_section : 10,
			count_refresh_lapse: 100000,		// Default is every minute
			view_refresh_lapse: 100000			// Default is every minute
		}, options || {});
		
		// Add the initial content
		this.addNewSegment(this.fillContent.bindAsEventListener(this));
		
		// Assign Events
		this.fillContentEvent = this.fillContent.bindAsEventListener(this);
		Event.observe(window, 'scroll', this.fillContentEvent);
		Event.observe(window, 'resize', this.fillContentEvent);
		
		// Start the periodic count	check
		setInterval(this.checkCount.bind(this), this.options.count_refresh_lapse);
		setInterval(this.periodicRefreshView.bind(this), this.options.view_refresh_lapse);
	},
	fillContent : function(){
		// First find out where we are scrolled on the page
		var viewport_height = document.viewport.getDimensions().height;
		var scrolled = document.viewport.getScrollOffsets();
		var scrolled_pos = scrolled[1] + viewport_height;
		// Find out which divs are in the current view
		var min = scrolled[1];
		var max = min + viewport_height;
		var within_range = this.getViewportWithinRange();
		// Draw new segemnts that are found using our handy diff fucntion
		if(within_range[0] < this.segment_divs_view_range[0]){
			this.refreshView(within_range[0], true);
		}else if(within_range[1] > this.segment_divs_view_range[1]){
			this.refreshView(within_range[1], true);
		}
		this.segment_divs_view_range = within_range;
		// Finally make the comparison to add new divs if necessary
		if(((this.segment_divs.length) * this.options.items_per_section) < this.item_count){
			// find out where the lowest div is
			var abs_div_pos = Position.cumulativeOffset($(this.segment_divs[(this.segment_divs.length - 1)]));
			var bottom_div_height = $(this.segment_divs[(this.segment_divs.length - 1)]).getHeight();
			var bottom_div_max = bottom_div_height + abs_div_pos[1];
			var bottom_div_half_height = (bottom_div_height / 2);
			// If we have scrolled past the last half of the last div then add segment
			if(scrolled_pos+bottom_div_half_height > bottom_div_max){			
				this.addNewSegment(this.fillContent.bindAsEventListener(this));
			}else{
				return;
			}
		}
	},
	addNewSegment : function(callAfterUpdate){
		if(!callAfterUpdate) callAfterUpdate = function(){ };
		
		this.segment_divs[this.segment_divs.length] = document.createElement('div');
		$(this.segment_divs[(this.segment_divs.length - 1)]).innerHTML = 'Loading...';
		$(this.container_elem_id).appendChild(this.segment_divs[(this.segment_divs.length - 1)]);
		new Ajax.Updater($(this.segment_divs[(this.segment_divs.length - 1)]), this.ajax_update_url+'?section='+(this.segment_divs.length - 1), { method: 'get', onComplete : callAfterUpdate });
		// Set a time stamp for this section so it can be refreshed accordingly
		var now=new Date()
		var h=now.getHours() * 60;
		var m=(now.getMinutes() + h) * 60;
		var s=now.getSeconds() + m;
		this.segment_divs_last_refresh[(this.segment_divs.length - 1)] = s;
	},
	// CHECK COUNT FUNCTIONS
	checkCount : function(){
		new Ajax.Request(this.ajax_count_url,
		  {
		    onSuccess: this.checkCountOnSuccessCallback.bind(this)
		  });
	},
	checkCountOnSuccessCallback : function(transport){
		this.item_count = transport.responseText;
	},
	// REFRESH FUNCTIONS
	periodicRefreshView : function(){
		for(var i = this.segment_divs_view_range[0]; i <= this.segment_divs_view_range[1]; i++){
			this.refreshView(i, false);
		}
	},
	// Actual part where the view is refreshed.  This is used in two separate places which explains why it is it's own functions
	refreshView : function(section_num, time_check){
		if(time_check){
			var now=new Date();
			var h=now.getHours() * 60;
			var m=(now.getMinutes() + h) * 60;
			var s=now.getSeconds() + m;
			
			// If checking is on (scrolling down and entering new section) then check to see if we should refresh, we don't want to refresh
			// every time the user scrolls over a new section or it could amount to far too much loading.			
			if(s < (this.segment_divs_last_refresh[section_num] + this.options.view_refresh_lapse * 0.001)){
				return;
			}
		}
		
		new Ajax.Updater($(this.segment_divs[section_num]), this.ajax_update_url+'?section='+section_num);
		// Set a time stamp for this section so it can be refreshed accordingly
		var now=new Date();
		var h=now.getHours() * 60;
		var m=(now.getMinutes() + h) * 60;
		var s=now.getSeconds() + m;
		this.segment_divs_last_refresh[section_num] = s;
		//console.log('Refreshing Section '+section_num+" Timestamp at: "+this.segment_divs_last_refresh[section_num]);
	},
	// HELPER FUNCTIONS
	getViewportWithinRange : function(){
		// First find out where we are scrolled on the page
		var viewport_height = document.viewport.getDimensions().height;
		var scrolled = document.viewport.getScrollOffsets();
		// Find out which divs are in the current view
		var min = scrolled[1];
		var max = min + viewport_height;
		var current_div_iteration = 0;
		var return_array = new Array();
		// First find with div the min is in
		if(min < Position.cumulativeOffset($(this.segment_divs[0]))[1] ){
			return_array[0] = '0';
		}else{
			for(var i = 0; i < this.segment_divs.length; i++){
				var current_div_pos = Position.cumulativeOffset($(this.segment_divs[i]));
				var current_div_bottom = current_div_pos[1] + $(this.segment_divs[i]).getHeight();
				if((min >= current_div_pos[1] && min <= current_div_bottom)){
					//console.log("Section "+i+" is in the current view");
					return_array[0] = i;
					current_div_iteration = i;
					break;
				}
			}
		}
		
		// Then find with di the max is in
		if(max >= (Position.cumulativeOffset($(this.segment_divs[(this.segment_divs.length - 1)]))[1]+ $(this.segment_divs[(this.segment_divs.length - 1)]).getHeight()) ){
			return_array[1] = (this.segment_divs.length - 1);
		}else{
			for(var i = current_div_iteration; i < this.segment_divs.length; i++){
				var current_div_pos = Position.cumulativeOffset($(this.segment_divs[i]));
				var current_div_bottom = current_div_pos[1] + $(this.segment_divs[i]).getHeight();
				if((max >= current_div_pos[1] && max <= current_div_bottom)){
					//console.log("Section "+i+" is in the current view");
					return_array[1] = i;
					current_div_iteration = i;
					break;
				}
			}
		}
		
		return return_array;
	}
}