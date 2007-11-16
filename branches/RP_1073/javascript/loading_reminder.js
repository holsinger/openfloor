// ===============
// = PopUP Class =
// ===============
//
//
if(!Control) var Control = {};
Control.LoadingReminder = Class.create();

Control.LoadingReminder.prototype = {
	initialize: function (reminder_elem_id ,options){
		this.reminder_elem_id = reminder_elem_id;
		this.fade_effect = "";
		this.fading = false;
		
		// We have a lot of defaults that we use if not defined
		this.options = Object.extend({
			effects : 'on'
		}, options || {});
		
		// Do some fun stuff on the div provided
		if(typeof document.body.style.maxHeight != "undefined"){		// filter out the rancid IE 6
			var pop_pos = 'fixed';
		}else{
			var pop_pos = 'absolute';
		}
		$(this.reminder_elem_id).setStyle({ position: pop_pos, display: 'none', top : '0px', left : '0px' });
		Event.observe($(this.reminder_elem_id), 'mousedown', this.popup_elem_event);
		
		// IE 6 support, now it gets ugly
		if(typeof document.body.style.maxHeight == "undefined"){
			Event.observe(window, 'scroll', this.ieScroll.bind(this));
		}		
	}, 
	show : function(){
		if(this.fading){
			this.fade_effect.cancel();
			this.fading = false;
		}
		$(this.reminder_elem_id).setStyle({ display: 'block', opacity: "1", filter : "alpha(opacity=100)" });
		
		
	},
	hide : function(){
		if(this.options.effects == 'on'){
			this.fade_effect = Effect.Fade(this.reminder_elem_id, { duration : 1.5, afterFinish :  this.afterHide.bind(this) });
			this.fading = true;
		}else{
			$(this.reminder_elem_id).setStyle({ display: 'none'  });
		}
		
		
	},
	afterHide : function(){
		this.fading = false;
	},
	ieScroll : function(){
		var scrolled = document.viewport.getScrollOffsets();
		$(this.reminder_elem_id).setStyle({ top : scrolled[1]+'px'});
	},
	isVisible : function(){
		if($(this.reminder_elem_id).getStyle('display') == 'block'){
			return true;
		}else{
			return false;
		}
	}
}