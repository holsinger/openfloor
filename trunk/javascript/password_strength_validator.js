// ============================
// = Password Strength Validator =
// ============================
//
// Author: Clark Endrizzi
//
// (documentation)
// ============================
if(!Control) var Control = {};
Control.PasswordStrengthValidator = Class.create({
	initialize: function (password_elem_id, meter_elem_id, options){
		// Variables
		this.password_elem_id = password_elem_id;
		this.meter_elem_id = meter_elem_id;
		this.commonPasswords = new Array('password', 'pass', '1234', '1246'); // This could be improved
		this.numbers = "0123456789"; 
		this.lowercase = "abcdefghijklmnopqrstuvwxyz"; 
		this.uppercase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
		this.punctuation = "!.@$£#*()%~<>{}[]";
		// Options Defaults
		this.options = Object.extend({
			default_password : ""
		}, options || {});	
		// Now set up the events
		Event.observe( $(this.password_elem_id), 'keyup', this.keyUp.bindAsEventListener(this) );
		// Do initial if necessary
		if($(this.password_elem_id).value != "" && $(this.password_elem_id).value != this.options.default_password){
			this.checkPassword($(this.password_elem_id).value);
		}
	}, 
	keyUp : function(event){
		if($(this.password_elem_id).value != ""){
			this.checkPassword($(this.password_elem_id).value);
		}else{
			$(this.meter_elem_id).setStyle({
				width : "0%"
			});
		}
	},
	checkPassword : function(password) { 
	    var combinations = 0; 

	    if (this.contains(password, this.numbers) > 0) { 
	        combinations += 10; 
	    } 
	    if (this.contains(password, this.lowercase) > 0) { 
	        combinations += 26; 
	    } 
	    if (this.contains(password, this.uppercase) > 0) { 
	        combinations += 26; 
	    } 
	    if (this.contains(password, this.punctuation) > 0) { 
	        combinations += this.punctuation.length; 
	    } 

	    // work out the total combinations 
	    var totalCombinations = Math.pow(combinations, password.length); 

	    // if the password is a common password, then everthing changes... 
	    if (this.isCommonPassword(password)) { 
	        totalCombinations = 75000 // about the size of the dictionary 
	    } 

	    // work out how long it would take to crack this (@ 200 attempts per second) 
	    var timeInSeconds = (totalCombinations / 200) / 2; 

	    // this is how many days? (there are 86,400 seconds in a day. 
	    var timeInDays = timeInSeconds / 86400 

	    // how long we want it to last 
	    var lifetime = 365; 

	    // how close is the time to the projected time? 
	    var percentage = timeInDays / lifetime; 
	    var friendlyPercentage = this.cap(Math.round(percentage * 100), 100); 
	    if (totalCombinations != 75000 && friendlyPercentage < (password.length * 5)) { 
	        friendlyPercentage += password.length * 5; 
	    } 
		
		
		// CHANGE THE METER TO REFLECT THE PASSWORD STRENGTH
		$(this.meter_elem_id).setStyle({
			width : friendlyPercentage + "%"
		});
		// strong password
	    if (percentage > 1) { 
			$(this.meter_elem_id).setStyle({
				backgroundColor : "#3bce08"
			});
	        return; 
	    } 
		// reasonable password
	    if (percentage > 0.5) { 
			$(this.meter_elem_id).setStyle({
				backgroundColor : "#ffd801"
			});
	        return; 
	    } 
		// weak password
	    if (percentage > 0.10) { 
			$(this.meter_elem_id).setStyle({
				backgroundColor : "orange"
			});
	        return; 
	    } 
	    // useless password! 
	    if (percentage <= 0.10) { 
			$(this.meter_elem_id).setStyle({
				backgroundColor : "red"
			});
	        return; 
	    } 
	}, 

	cap: function(number, max) { 
	    if (number > max) { 
	        return max; 
	    } else { 
	        return number; 
	    } 
	},

	isCommonPassword : function(password) { 
	    for (i = 0; i < this.commonPasswords.length; i++) { 
	        var commonPassword = this.commonPasswords[i]; 
	        if (password == commonPassword) { 
	            return true; 
	        } 
	    } 

	    return false; 
	}, 

	contains : function(password, validChars) { 
	    count = 0; 
	    for (i = 0; i < password.length; i++) { 
	        var char = password.charAt(i); 
	        if (validChars.indexOf(char) > -1) { 
	            count++; 
	        } 
	    } 
	    return count; 
	}
});