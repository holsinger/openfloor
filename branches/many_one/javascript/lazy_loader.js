// ===============
// = Lazy Loader Class =
// ===============
//
//
if(!Control) var Control = {};
Control.LazyLoader = Class.create();

Control.LazyLoader.prototype = {
	initialize: function (container_elem_id, ajax_update_url, ajax_count_url, options){
		this.container_elem_id = container_elem_id;
		this.ajax_update_url = ajax_update_url;
		this.item_count = 0;
		this.ajax_count_url = ajax_count_url;
		this.segment_divs = new Array();
		this.segment_divs_last_refresh = new Array();
		this.segment_divs_view_range = new Array();
		this.update = true;		// Starts true, is used to stop all updating
		this.update_on_scroll = false;
		
		
		
		// We have a lot of defaults that we use if not defined
		this.options = Object.extend({
			items_per_section : 10,
			onStartAddSection : false,
			onFinishAddSection : false,
			count_refresh_lapse: 100000,		// Default is every minute
			view_refresh_lapse: 100000,			// Default is every minute
		}, options || {});
		
		// Add Content, first temp then real content added on the callback from the CheckCount() call below
		this.init_populate_complete = false;
		this.checkCount();		// For the initial count, because of the variable above it actually populates the container initially too
		
		// Assign Events, the observes are added after the initial population (IE thing)
		this.addSegmentsOnEventEvent = this.addSegmentsOnEvent.bind(this, "scroll");
		this.refreshExistingSegmentsOnScrollEvent = this.refreshExistingSegmentsOnScroll.bind(this);

		// Start the periodic count	check
		this.checkCountHandle = setInterval(this.checkCount.bind(this), this.options.count_refresh_lapse);
		this.checkRefreshHandle = setInterval(this.refreshView.bind(this), this.options.view_refresh_lapse);
	},
	refreshExistingSegmentsOnScroll : function(){
		if(this.update){
			// Refresh segments that come into the current view due to scrolling that have already been added.
			var within_range = this.getViewportWithinRange();		
			if(within_range[0] < this.segment_divs_view_range[0]){
				this.refreshSection(within_range[0], true);
			}else if(within_range[1] > this.segment_divs_view_range[1]){
				this.refreshSection(within_range[1], true);
			}
			this.segment_divs_view_range = within_range;
		}
	},
	addSegmentsOnEvent : function(call_source){
		
		//console.log("addSegmentsOnEvent");
		if(this.update){
			// Add More divs if necessary
			var scrolled_pos = document.viewport.getScrollOffsets()[1] + document.viewport.getDimensions().height;
			if(((this.segment_divs.length) * this.options.items_per_section) < this.item_count){
				// find out where the lowest div is
				var abs_div_pos = Position.cumulativeOffset($(this.segment_divs[(this.segment_divs.length - 1)]));
				var bottom_div_height = $(this.segment_divs[(this.segment_divs.length - 1)]).getHeight();
				var bottom_div_max = bottom_div_height + abs_div_pos[1];
				var bottom_div_half_height = (bottom_div_height / 2);
				// If we have scrolled past the last half of the last div then add segment
				if(scrolled_pos+bottom_div_half_height > bottom_div_max){			
					this.addNewSegment(call_source);	
					return;
				}
			}
			// This part should only be reached if it's not adding a section and it's on a callback from previously adding a section
			if(this.options.onFinishAddSection && call_source == "callback"){
				this.options.onFinishAddSection();
			}
			if(call_source == 'callback' && !this.init_populate_complete){
				//console.log('Population Complete, add the events');
				this.init_populate_complete = true;		// The initial population is complete so we can add the onscroll events
				
				Event.observe(window, 'scroll', this.addSegmentsOnEventEvent);
				Event.observe(window, 'resize', this.addSegmentsOnEventEvent);
				Event.observe(window, 'scroll', this.refreshExistingSegmentsOnScrollEvent);
				Event.observe(window, 'resize', this.refreshExistingSegmentsOnScrollEvent);
			}
		}
	},
	addNewSegment : function(original_call_source){
		if(original_call_source == 'scroll' && this.options.onStartAddSection){
			this.options.onStartAddSection();
		}
		
		this.segment_divs[this.segment_divs.length] = document.createElement('div');
		$(this.container_elem_id).appendChild(this.segment_divs[(this.segment_divs.length - 1)]);
		var date = new Date();
		var timestamp = date.getTime();
		new Ajax.Updater($(this.segment_divs[(this.segment_divs.length - 1)]), this.ajax_update_url+'/'+(this.segment_divs.length - 1)+'/'+timestamp, { method: 'post', onComplete : this.addNewSegmentOnComplete.bind(this) });
		// Set a time stamp for this section so it can be refreshed accordingly
		var now=new Date()
		var h=now.getHours() * 60;
		var m=(now.getMinutes() + h) * 60;
		var s=now.getSeconds() + m;
		this.segment_divs_last_refresh[(this.segment_divs.length - 1)] = s;
	},
	addNewSegmentOnComplete : function(){
		this.addSegmentsOnEvent("callback");
	},
	stopUpdating : function(){
		clearTimeout(this.checkCountHandle);
		clearTimeout(this.checkRefreshHandle);
		this.update = false;
	},
	startUpdating : function(do_not_update_first){
		if(!do_not_update_first){
			// Update immediatley first
			this.checkCount();
			this.refreshView();
		}
		// start the interval
		this.checkCountHandle = setInterval(this.checkCount.bind(this), this.options.count_refresh_lapse);
		this.checkRefreshHandle = setInterval(this.refreshView.bind(this), this.options.view_refresh_lapse);
		// let the class know we mean it!
		this.update = true;
	},
	reset : function(ajax_update_url, ajax_count_url){
		this.ajax_update_url = ajax_update_url;
		this.item_count = 0;
		this.ajax_count_url = ajax_count_url;
		
		this. stopUpdating();
		Event.stopObserving(window, 'scroll', this.addSegmentsOnEventEvent);
		Event.stopObserving(window, 'resize', this.addSegmentsOnEventEvent);
		Event.stopObserving(window, 'scroll', this.refreshExistingSegmentsOnScrollEvent);
		Event.stopObserving(window, 'resize', this.refreshExistingSegmentsOnScrollEvent);
		
		// remove existing divs
		for(var i = 0; i < this.segment_divs.length; i++){
			$(this.container_elem_id).removeChild(this.segment_divs[i]);
		}
		
		this.segment_divs = new Array();
		this.segment_divs_last_refresh = new Array();
		this.segment_divs_view_range = new Array();
		
		// Add Content, first temp then real content added on the callback from the CheckCount() call below
		this.init_populate_complete = false;
		this.checkCount();		// For the initial count, because of the variable above it actually populates the container initially too
		
		this.startUpdating(true);
	},
	// CHECK COUNT FUNCTIONS, on initial call it calls the first portion to fill in the page.  We must have the count before we can do this!
	checkCount : function(){
		if(!this.init_populate_complete && this.options.onStartAddSection){
			this.options.onStartAddSection();
		}
		var date = new Date();
		var timestamp = date.getTime();
		new Ajax.Request(this.ajax_count_url+'/'+timestamp,
		  {
		    onSuccess: this.checkCountOnSuccessCallback.bind(this)
		  });
	},
	checkCountOnSuccessCallback : function(transport){
		this.item_count = transport.responseText;
		if(!this.init_populate_complete){
			$(this.container_elem_id).innerHTML = "";
			this.addNewSegment();	//console.log("Initial population call");
			
		}
		
	},
	// REFRESH FUNCTIONS
	refreshView : function(){
		for(var i = this.segment_divs_view_range[0]; i <= this.segment_divs_view_range[1]; i++){
			this.refreshSection(i, false);
		}
	},
	// Actual part where the view is refreshed.  This is used in two separate places which explains why it is it's own functions
	refreshSection : function(section_num, time_check){
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
		var date = new Date();
		var timestamp = date.getTime();
		new Ajax.Updater($(this.segment_divs[section_num]), this.ajax_update_url+'/'+section_num+'/'+timestamp, { method: 'post'});
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