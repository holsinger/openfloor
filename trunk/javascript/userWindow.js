var my_width  = 0;
var my_height = 0;
    
function showBox(id){
    $('overlay').show();
    center(id);
    return false;
}

function hideBox(id){
    $(id).hide();
    $('overlay').hide();
    return false;
}

function center(string){     

    if ( typeof( window.innerWidth ) == 'number' ){
        my_width  = window.innerWidth;
        my_height = window.innerHeight;
    }else if ( document.documentElement && 
             ( document.documentElement.clientWidth ||
               document.documentElement.clientHeight ) ){
        my_width  = document.documentElement.clientWidth;
        my_height = document.documentElement.clientHeight;
    }
    else if ( document.body && 
            ( document.body.clientWidth || document.body.clientHeight ) ){
        my_width  = document.body.clientWidth;
        my_height = document.body.clientHeight;
    }
		
		//see if we have a div
		element = $(string);
		if (!element) {
			element = getDynamicElement(string);	
		} else {
	    //set element styles
	    element.style.position = 'absolute';
	    element.style.zIndex   = 1000;
	    cleanUp (element);
	    new Effect.Appear(string);
	  }
	    
}
function getDynamicElement(string) {
	var my_div = $('hijax');
	Element.extend(my_div);
	//set element styles
  my_div.style.position = 'absolute';
  my_div.style.zIndex   = 1000;
	my_div.innerHTML = 'Loading...';
	my_div.show();
	new Ajax.Request(site_url+'/information/viewAjax/'+string,
  {
    method:'post',
    onSuccess: function(transport){
      var response = transport.responseText;
      //console.debug(response);
      			
			my_div.addClassName('ajax_box');
			my_div.hide();
			my_div.innerHTML = '<img id="close" src="images/close.gif" onclick="hideBox(\'hijax\')" alt="Close" title="Close this window" />'+response;
			
			cleanUp (my_div);			
			my_div.style.display  = 'none';
			new Effect.Appear('hijax');		
			   
	    
    },
    onFailure: function(){ alert('Something went wrong...') }
  });
}

function cleanUp (element) {
		var scrollY = 0;

    if ( document.documentElement && document.documentElement.scrollTop ){
        scrollY = document.documentElement.scrollTop;
    }else if ( document.body && document.body.scrollTop ){
        scrollY = document.body.scrollTop;
    }else if ( window.pageYOffset ){
        scrollY = window.pageYOffset;
    }else if ( window.scrollY ){
        scrollY = window.scrollY;
    }
    
		var elementDimensions = Element.getDimensions(element);

    var setX = ( my_width  - elementDimensions.width  ) / 2;
    var setY = ( my_height - elementDimensions.height ) / 2 + scrollY;

    setX = ( setX < 0 ) ? 0 : setX;
    setY = ( setY < 0 ) ? 0 : setY;

    element.style.left = setX + "px";
    element.style.top  = setY + "px";

    element.style.display  = 'block';    
}