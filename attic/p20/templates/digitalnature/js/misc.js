
/* cookie handling */

    function setCookie(name,value,days) {
	 if (days) {
		 var date = new Date();
		 date.setTime(date.getTime()+(days*24*60*60*1000));
		 var expires = ";expires="+date.toGMTString();
	 } else {
		 expires = "";
	 }
	 document.cookie = name+"="+value+expires+";path=/";
	}
		
	function readCookie(name) {
	 var needle = name + "=";
	 var cookieArray = document.cookie.split(';');
	 for(var i=0;i < cookieArray.length;i++) {
		 var pair = cookieArray[i];
		 while (pair.charAt(0)==' ') {
			 pair = pair.substring(1, pair.length);
		 }
		 if (pair.indexOf(needle) == 0) {
			 return pair.substring(needle.length, pair.length);
		 }
	 }
	 return null;
	}



function clearText(thisfield, defaulttext) {
if (thisfield.value == defaulttext) {
thisfield.value = "";
}
}

function restoreText(thisfield, defaulttext) {
if (thisfield.value == "") {
thisfield.value = defaulttext;
}
}

function preload() {
  var d=document; 
  if(d.images){ 
    if(!d.pre) d.pre=new Array();
    var i,j=d.pre.length,a=preload.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.pre[j]=new Image; d.pre[j++].src=a[i];}
  }
}

/* better and much more simple toggle i think, but with no cookies :( */

function toggle(obj,srclink) {
 var el = document.getElementById(obj);
 var srcEl = document.getElementById(srclink); 
 if (el.style.display != 'none') {
  el.style.display = 'none';
  srcEl.className = 'expand-down';	
 }
 else {
  el.style.display = '';
  srcEl.className = 'expand-up';
 }
}

<!-- some combined fx -->

 
 Effect.DropIn = function(element) {
  element = $(element);
  var oldTop = element.style.top;
  var oldLeft = element.style.left;
  var pos = Position.cumulativeOffset(element);
   return new Effect.Parallel(
    [ new Effect.MoveBy(element, 100, 0, { sync: true }), 
      new Effect.Opacity(element, { sync: true, from:0.0, to: 1.0 }) ],
    Object.extend(
      { duration: 0.5,
        beforeSetup: function(effect) { 
          Element.makePositioned(effect.effects[0].element); 
          Element.setOpacity(element, 0);
         // element.style.position = 'absolute'; 
         // element.style.top = (pos[1]-100) + 'px'; 
        }
      }, arguments[1] || {}));
 }

 Effect.PopOut = function(element) {
  element = $(element);
  var oldTop = element.style.top;
  var oldLeft = element.style.left;
  var pos = Position.cumulativeOffset(element);
   return new Effect.Parallel(
    [ new Effect.MoveBy(element, -100, 0, { sync: true }), // move up
      new Effect.Opacity(element, { sync: true, from:1, to: 0 }) ],
    Object.extend(
      { duration: 0, // effect won't be noticeable
        beforeSetup: function(effect) { 
          Element.makePositioned(effect.effects[0].element); 
          Element.setOpacity(element, 1);
          // element.style.position = 'absolute'; 
          // element.style.top = (pos[1]-100) + 'px'; 
        }
      }, arguments[1] || {}));
 }
 
 
 
 
    Effect.BlindLeft = function(element) {
          element = $(element);
          element.makeClipping();
          return new Effect.Scale(element, 0, 
            Object.extend({ scaleContent: false, 
              scaleY: false, 
              restoreAfterFinish: true,
              afterFinishInternal: function(effect) {
                effect.element.hide();
                effect.element.undoClipping();
              } 
            }, arguments[1] || {})
          );
        }

        Effect.BlindRight = function(element) {
          element = $(element);
          var elementDimensions = element.getDimensions();
          return new Effect.Scale(element, 100, 
            Object.extend({ scaleContent: false, 
              scaleY: false,
              scaleFrom: 0,
              scaleMode: {originalHeight: elementDimensions.height, originalWidth: elementDimensions.width},
              restoreAfterFinish: true,
              afterSetup: function(effect) {
                effect.element.makeClipping();
                effect.element.setStyle({width: '0px'});
                effect.element.show(); 
              },  
              afterFinishInternal: function(effect) {
                effect.element.undoClipping();
              }
            }, arguments[1] || {})
          );
        }

        Effect.DelayedChain = Class.create();
        Object.extend(Effect.DelayedChain.prototype, {
            initialize: function(effect, elements, options, timeout){
                this.elements = elements;
                this.effect = effect;
                this.timeout = timeout || 100;
                this.options = Object.extend({}, options || {});

                this.afterFinish = this.options.afterFinish || Prototype.emptyFunction;
                this.options.afterFinish = Prototype.emptyFunction;
                setTimeout(this.action.bind(this),1);
            },
            action: function() {
                if(this.elements.length){ 
                    new Effect[this.effect](this.elements.shift(), this.options);
                    setTimeout(this.action.bind(this), this.timeout);
                } else {
                    if(this.afterFinish) this.afterFinish();
                }
            }
        });

        Effect.Chain = Class.create();
        Object.extend(Effect.Chain.prototype, {
            initialize: function(effect, elements, options){
                this.elements = elements || [];
                this.effect = effect;
                this.options = options || {};
                this.afterFinish = this.options.afterFinish || Prototype.emptyFunction;
                this.options.afterFinish = this.nextEffect.bind(this);
                setTimeout(this.nextEffect.bind(this), 1);
            },
            nextEffect: function(){
                if(this.elements.length)
                    new Effect[this.effect](this.elements.shift(), this.options);
                else
                    this.afterFinish();
            }
        });