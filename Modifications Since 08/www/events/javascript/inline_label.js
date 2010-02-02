// ============================
// = Inline Label =
// ============================
//
// Author: Clark Endrizzi
//
// (documentation)
// ============================
Form.InlineLabel = Class.create({
	initialize: function (elem_id, label_text, options){
		// Variables
		this.elem_id = elem_id;
		this.label_text = label_text;
		// Options Defaults
		this.options = Object.extend({
			labelColor : "#737373",
			normalColor: "#000000"
		}, options || {});	
		// Now set up the events
		Event.observe( $(this.elem_id), 'click', this.onClick.bindAsEventListener(this) );
		Event.observe( $(this.elem_id), 'blur', this.onBlur.bindAsEventListener(this) );
		// Set label
		this.setLabel();
		
	}, 
	onClick : function(event){
		if($(this.elem_id).value == this.label_text){
			// Set color
			$(this.elem_id).setStyle({
				color: this.options.normalColor, 
				fontStyle : "normal"
			});
			// Blank
			$(this.elem_id).value = "";
		}
	},
	onBlur : function (event){
		this.setLabel();
	},
	setLabel : function(){
		if($(this.elem_id).value == "" || $(this.elem_id).value == this.label_text){
			// Set label
			$(this.elem_id).value = this.label_text;
			// Set color
			$(this.elem_id).setStyle({
				color: this.options.labelColor, 
				fontStyle : "italic"
			});
		}
	}
});