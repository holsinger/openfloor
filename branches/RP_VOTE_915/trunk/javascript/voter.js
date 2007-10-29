// ===============
// = Voter Class =
// ===============
if(!Control) var Control = {};
Control.Voter = Class.create();

Control.Voter.prototype = {
	initialize: function (elem_id, options){
		// Even though initialization is not a requirement, I like to have all the variables defined in one place for cleaner code.
		this.options = options || {};
		if(this.options.start_value){
			for(var i = 0; i < this.options.meter_values.length; i++){
				if(this.options.meter_values[i] == this.options.start_value){
					this.num_selected = i;
					break;
				}
			}
			
		}else{
			this.num_selected = 0; // The index of meter_elems that is currently selected
		}
		
		this.dragging = false;
		this.offsetX = 0;
		if(this.options.arrow_elem){
			this.drag_start_num_selected = this.num_selected;
			this.current_arrow_pos = 0;
			this.options.arrow_offset_x = this.options.arrow_offset_x || 0;
			// Move arrow and make visible (optional)
			var div_dim = Position.positionedOffset($(this.options.meter_elems[this.num_selected]));
			this.current_arrow_pos = div_dim[1] - ($(this.options.meter_elems[this.num_selected]).getHeight() / 2);
			var abs_div_dim = Position.cumulativeOffset($(this.options.meter_elems[this.num_selected]));	// Need absolute positioning for dragging
			this.current_arrow_abs_pos = abs_div_dim[1] - ($(this.options.meter_elems[this.num_selected]).getHeight() / 2);
			$(this.options.arrow_elem).setStyle({
				top: this.current_arrow_pos+"px",
				left: (div_dim[0] - this.options.arrow_offset_x)+"px",
				visibility: "visible"
			});
		}
		
		
		this.options.initial_elem_class = new Array();
		for (var i = 0; i < this.options.meter_elems.length; i++){
			this.options.initial_elem_class[i] = $(this.options.meter_elems[i]).className;
		}
		// Assign Events
		this.onMeterMouseDown = this.clickMeter.bindAsEventListener(this);
		this.onArrowMouseUp   = this.endDrag.bindAsEventListener(this);
		this.onArrowMouseDown = this.startDrag.bindAsEventListener(this);
		this.eventMouseMove = this.update.bindAsEventListener(this);
				
		for(i = 0; i < this.options.meter_elems.length; i++){
			Event.observe(this.options.meter_elems[i], "mousedown", this.onMeterMouseDown);
		}
		if(this.options.arrow_elem){
			Event.observe(this.options.arrow_elem, "mousedown", this.onArrowMouseDown);
			Event.observe(document, "mouseup", this.onArrowMouseUp);
			Event.observe(document, "mousemove", this.eventMouseMove);
			
			// Change the look if necessary
			if(this.num_selected > 0)
				this.changeRating(this.options.meter_elems[this.num_selected], true);
		}
	}, 
	clickMeter : function(event){
		this.changeRating(Event.element(event).id);
	},
	changeRating : function(meter_id, ignore_event_calls){
		ignore_event_calls = typeof(ignore_event_calls) != 'undefined' ? ignore_event_calls : false;  // Want this value to be false by default
		for (var i = 0; i < this.options.meter_elems.length; i++){
			$(this.options.meter_elems[i]).className = this.options.voted_meter_classes[i];
			// If we've found our triggered element, then stop
			if(this.options.meter_elems[i] == meter_id){
				for(c = (i + 1); c < (this.num_selected + 1); c++){
					$(this.options.meter_elems[c]).className = this.options.initial_elem_class[c];
				}
				this.num_selected = i;
				// Fire onchange even if it exists
				if(this.options.onchange && !ignore_event_calls){
					if(!this.dragging){
						this.options.onchange(this.options.meter_values[i], meter_id);
					}
				}
					
				// Move Arrow if it exists
				if(this.options.arrow_elem){
					// relative position
					var div_dim = Position.positionedOffset($(this.options.meter_elems[i]));
					this.current_arrow_pos = div_dim[1] - ($(this.options.arrow_elem).getHeight() / 2);
					// absolute position
					var abs_div_dim = Position.cumulativeOffset($(this.options.meter_elems[this.num_selected]));
					this.current_arrow_abs_pos = abs_div_dim[1] - ($(this.options.meter_elems[this.num_selected]).getHeight() / 2);
					// move
					$(this.options.arrow_elem).setStyle({
						top: this.current_arrow_pos+"px",
						left: (div_dim[0] - this.options.arrow_offset_x)+"px"
					});
					
				}
				
				return;		
			}
		}
		
	},
	startDrag : function(event){
		this.dragging = true;
		this.drag_start_num_selected = this.num_selected;	
	},
	endDrag : function(){
		// If it changed then fire the onchange event, this is done hear so it wont' call it for each change while dragging.
		if(this.dragging){
			if(this.options.onchange){
				if(this.drag_start_num_selected != this.num_selected){
					this.options.onchange(this.options.meter_values[this.num_selected], this.options.meter_elems[this.num_selected]);
				}
			}
		}
		this.dragging = false;
	},
	update: function(event) {
		// if(this.options.error_div){
		// 	$(this.options.error_div).innerHTML = "PointerX: "+Event.pointerX(event)+"&nbsp;PointerY: "+Event.pointerY(event)+"<br \>";
		// 	$(this.options.error_div).innerHTML += "Current Pos (rel): "+this.current_arrow_pos+" (abs): "+this.current_arrow_abs_pos+"<br \>";
		// 	$(this.options.error_div).innerHTML += "div height: "+$(this.options.meter_elems[0]).getHeight();
		// }
		
		if(this.dragging == true){
			this.determineMouseMoveMeterChange(Event.pointerY(event));
		}
	},
	determineMouseMoveMeterChange : function(current_pointer_pos){
		
		// Find out if we are past the half way point, first for below then above
		if(this.num_selected > 0){
			if(current_pointer_pos > ( this.current_arrow_abs_pos + ( $(this.options.meter_elems[this.num_selected]).getHeight() / 2 ) )){
				this.changeRating(this.options.meter_elems[(this.num_selected - 1)]);
			}
		}
		if(this.num_selected < (this.options.meter_elems.length - 1)){
			if(current_pointer_pos < ( this.current_arrow_abs_pos + ( $(this.options.meter_elems[(this.num_selected + 1)]).getHeight() / 2 ) )){
				this.changeRating(this.options.meter_elems[(this.num_selected + 1)]);
			}	
		}
	}
}