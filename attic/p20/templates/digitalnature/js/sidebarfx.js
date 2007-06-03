var theRules = {
'#rssbox h1' : function(el){
	el.onclick = function(){
		if (Element.hasClassName(this, 'invisible')) {
			new Effect.BlindDown('rss', {duration:0.3});
			Element.removeClassName(this, 'invisible');
			document.getElementById('exprss').className='expand-down';						
			setCookie(this.parentNode.id, '', 365);

		} else {
			new Effect.BlindUp('rss', {duration:0.3});
			Element.addClassName(this, 'invisible');
			document.getElementById('exprss').className='expand-up';						
			setCookie(this.parentNode.id, 'invisible', 365);
		}
	}		
},

'#tagbox h1' : function(el){
	el.onclick = function(){
		if (Element.hasClassName(this, 'invisible')) {
			new Effect.BlindDown('tags', {duration:0.3});
			Element.removeClassName(this, 'invisible');
			document.getElementById('exptags').className='expand-down';					
			setCookie(this.parentNode.id, '', 365);
		} else {
			new Effect.BlindUp('tags', {duration:0.3});
			Element.addClassName(this, 'invisible');
			document.getElementById('exptags').className='expand-up';					
			setCookie(this.parentNode.id, 'invisible', 365);
		}
	}
},

'#categorybox h1' : function(el){
	el.onclick = function(){
		if (Element.hasClassName(this, 'invisible')) {
			new Effect.BlindDown('categorynav', {duration:0.3});
			Element.removeClassName(this, 'invisible');
			document.getElementById('expcat').className='expand-down';
			setCookie(this.parentNode.id, '', 365);
		} else {
			new Effect.BlindUp('categorynav', {duration:0.3});
			Element.addClassName(this, 'invisible');
			document.getElementById('expcat').className='expand-up';
			setCookie(this.parentNode.id, 'invisible', 365);
		}
	}			
},

'#loginbox h1' : function(el){
	el.onclick = function(){
		if (Element.hasClassName(this, 'invisible')) {
			new Effect.BlindDown('loginform', {duration:0.3});
			Element.removeClassName(this, 'invisible');
			document.getElementById('explogin').className='expand-down';
			setCookie(this.parentNode.id, '', 365);
		} else {
			new Effect.BlindUp('loginform', {duration:0.3});
			Element.addClassName(this, 'invisible');
			document.getElementById('explogin').className='expand-up';
			setCookie(this.parentNode.id, 'invisible', 365);
		}
	}			
},

'#sidenavbox h1' : function(el){
	el.onclick = function(){
		if (Element.hasClassName(this, 'invisible')) {
			new Effect.BlindDown('sidenav', {duration:0.3});
			Element.removeClassName(this, 'invisible');
			document.getElementById('expnav').className='expand-down';
			setCookie(this.parentNode.id, '', 365);
		} else {
			new Effect.BlindUp('sidenav', {duration:0.3});
			Element.addClassName(this, 'invisible');
			document.getElementById('expnav').className='expand-up';
			setCookie(this.parentNode.id, 'invisible', 365);
		}
	}			
},

'#aboutbox h1' : function(el){
	el.onclick = function(){
		if (Element.hasClassName(this, 'invisible')) {
			new Effect.BlindDown('about', {duration:0.3});
			Element.removeClassName(this, 'invisible');
			document.getElementById('expabout').className='expand-down';
			setCookie(this.parentNode.id, '', 365);
		} else {
			new Effect.BlindUp('about', {duration:0.3});
			Element.addClassName(this, 'invisible');
			document.getElementById('expabout').className='expand-up';
			setCookie(this.parentNode.id, 'invisible', 365);
		}
	}			
}

				
};	

Behaviour.register(theRules);
Behaviour.addLoadEvent(hideBoxes);

function hideBoxes() {

// Id names of all the "boxes"
boxIds = $("rssbox","tagbox","categorybox","loginbox","sidenavbox","aboutbox");	

for (i = 0; i < boxIds.length; i++) {
	if (boxIds[i]) {
		cookieValue = readCookie(boxIds[i].id);
		if (cookieValue == 'invisible') {

			var h1 = boxIds[i].getElementsByTagName('h1');
			Element.addClassName(h1[0], 'invisible');
			var kids = boxIds[i].childNodes;
			for (j = 1; j < kids.length; j++) {
				if (kids[j].id) {
					Element.hide(kids[j]);
				}
			}  	
		}
	}		
 };
 document.getElementById('sidelist').style.display='block'; 
 //new Effect.DropIn('sidelist', {duration: 0.3});
}