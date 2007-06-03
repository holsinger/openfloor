var xmlhttp
/*@cc_on @*/
/*@if (@_jscript_version >= 5)
  try {
  xmlhttp=new ActiveXObject("Msxml2.XMLHTTP")
 } catch (e) {
  try {
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP")
  } catch (E) {
   xmlhttp=false
  }
 }
@else
 xmlhttp=false
@end @*/

if (!xmlhttp && typeof XMLHttpRequest != 'undefined')
{
  try {
	xmlhttp = new XMLHttpRequest ();
  }
  catch (e) {
  xmlhttp = false}
}

function myXMLHttpRequest ()
{
  var xmlhttplocal;
  try {
  	xmlhttplocal = new ActiveXObject ("Msxml2.XMLHTTP")}
  catch (e) {
	try {
	xmlhttplocal = new ActiveXObject ("Microsoft.XMLHTTP")}
	catch (E) {
	  xmlhttplocal = false;
	}
  }

  if (!xmlhttplocal && typeof XMLHttpRequest != 'undefined') {
	try {
	  var xmlhttplocal = new XMLHttpRequest ();
	}
	catch (e) {
	  var xmlhttplocal = false;
	}
  }
  return (xmlhttplocal);
}

var mnmxmlhttp = Array ();
var mnmString = Array ();
var mnmPrevColor = Array ();
var responsestring = Array ();
var myxmlhttp = Array ();
var responseString = new String;


function menealo (user, id, htmlid, md5, value)
{
  	if (xmlhttp) {
		url = "menealo.php";
		var content = "id=" + id + "&user=" + user + "&md5=" + md5 + "&value=" + value;
		anonymous_vote = false;
        if (anonymous_vote == false && user == '0') {
            window.location="login.php?return="+location.href;
        } else {
    		mnmxmlhttp[htmlid] = new myXMLHttpRequest ();
    		if (mnmxmlhttp) {
    			mnmxmlhttp[htmlid].open ("POST", url, true);
    			mnmxmlhttp[htmlid].setRequestHeader ('Content-Type',
    					   'application/x-www-form-urlencoded');
    
    			mnmxmlhttp[htmlid].send (content);
    			errormatch = new RegExp ("^ERROR:");
    
    			target1 = document.getElementById ('mnms-' + htmlid);
    
    
    			mnmPrevColor[htmlid] = target1.style.backgroundColor;
    			//target1.style.background = '#c00';
    			//target1.style.backgroundColor = '#FF9D9F';
    			mnmxmlhttp[htmlid].onreadystatechange = function () {
    				if (mnmxmlhttp[htmlid].readyState == 4) {
    					mnmString[htmlid] = mnmxmlhttp[htmlid].responseText;
    					if (mnmString[htmlid].match (errormatch)) {
    						mnmString[htmlid] = mnmString[htmlid].substring (6, mnmString[htmlid].length);
    						// myclearTimeout(row);
    						// resetrowfull(row);
    						changemnmvalues (htmlid, true);
    					} else {
    						changemnmvalues (htmlid, false);
    					}
    				}
    			}
    		}
    	}
	}
}

function cvote (user, id, htmlid, md5, value)
{
	if (xmlhttp) {
		url = "cvote.php";
		content = "id=" + id + "&user=" + user + "&md5=" + md5 + "&value=" + value;
		anonymous_vote = false;

        if (anonymous_vote == false && user == '0') {
            window.location="login.php?return="+location.href;
        } else {
    		mnmxmlhttp[htmlid] = new myXMLHttpRequest ();
    		if (mnmxmlhttp) {
    			mnmxmlhttp[htmlid].open ("POST", url, true);
    			mnmxmlhttp[htmlid].setRequestHeader ('Content-Type',
    					   'application/x-www-form-urlencoded');
    
    			mnmxmlhttp[htmlid].send (content);
    			errormatch = new RegExp ("^ERROR:");
    			target1 = document.getElementById ('cvote-' + htmlid);
        
    			mnmPrevColor[htmlid] = target1.style.backgroundColor;
    			//target1.style.background = '#c00';
    			target1.style.backgroundColor = '#FFFFFF';
    			mnmxmlhttp[htmlid].onreadystatechange = function () {
    				if (mnmxmlhttp[htmlid].readyState == 4) {
    					mnmString[htmlid] = mnmxmlhttp[htmlid].responseText;
    					if (mnmString[htmlid].match (errormatch)) {
    						mnmString[htmlid] = mnmString[htmlid].substring (6, mnmString[htmlid].length);
    						// myclearTimeout(row);
    						// resetrowfull(row);
							
    						changecvotevalues (htmlid, true);
							
    					} else {
							target1 = document.getElementById ('ratebuttons-' + id);
							target1.style.display = "none";

							target2 = document.getElementById ('ratetext-' + id);
							target2.innerHTML = "Thank you for rating this comment.";

							changecvotevalues (htmlid, false);
    					}
    				}
    			}
    		}
    	}
	}
}

function changemnmvalues (id, error)
{
	split = new RegExp ("~--~");
	b = mnmString[id].split (split);
	//alert(id);
	target1 = document.getElementById ('mnms-' + id);
	target2 = document.getElementById ('mnmlink-' + id);
	if (error) {
		target2.innerHTML = "<span>voted</span> ";
		return false;
	}
	if (b.length <= 3) {
		target1.innerHTML = b[0];
		target1.style.backgroundColor = mnmPrevColor[id];
		target2.innerHTML = "<span>voted</span> ";
	}
	return false;
}

function changecvotevalues (id, error)
{
	split = new RegExp ("~--~");
	b = mnmString[id].split (split);
	//alert(id);
	target1 = document.getElementById ('cvote-' + id);
	//target2 = document.getElementById ('mnmlink-' + id);
	if (error) {
	//	target2.innerHTML = "<span>vote cast</span>";
		return false;
	}
	if (b.length <= 3) {
		target1.innerHTML = b[0];
		target1.style.backgroundColor = mnmPrevColor[id];
	//	target2.innerHTML = "<span>vote cast</span>";
	}
	return false;
}


function enablebutton (button, button2, target)
{
	var string = target.value;
	button2.disabled = false;
	if (string.length > 0) {
		button.disabled = false;
	} else {
		button.disabled = true;
	}
}

function checkfield (type, form, field)
{
	url = 'checkfield.php?type='+type+'&name=' + field.value;
	checkitxmlhttp = new myXMLHttpRequest ();
	checkitxmlhttp.open ("GET", url, true);
	checkitxmlhttp.onreadystatechange = function () {
		if (checkitxmlhttp.readyState == 4) {
		responsestring = checkitxmlhttp.responseText;
			if (responsestring == 'OK') {
				document.getElementById (type+'checkitvalue').innerHTML = '<span style="color:black">"' + field.value + 
						'": ' + responsestring + '</span>';
				form.submit.disabled = '';
			} else {
				document.getElementById (type+'checkitvalue').innerHTML = '<span style="color:red">"' + field.value + '": ' +
				responsestring + '</span>';
				form.submit.disabled = 'disabled';
			}
		}
	}
  //  xmlhttp.setRequestHeader('Accept','message/x-formresult');
  checkitxmlhttp.send (null);
  return false;
}

function report_problem(frm, user, id, md5 /*id, code*/) {
	if (frm.ratings.value == 0)
		return;
	if (! confirm("do you wish to report the problem?") ) {
		frm.ratings.selectedIndex=0;
		return false;
	}
	content = "id=" + id + "&user=" + user + "&md5=" + md5 + '&value=' +frm.ratings.value;
	url="/problem.php?" + content;
	xmlhttp.open("GET",url,true);
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4) {
			frm.ratings.disabled=true;
			alert(xmlhttp.responseText);
		}
  	}
	xmlhttp.send(null);
	return false;
}

function emailto (original_id, htmlid, instpath, address_count)
{
	email_message = document.getElementById('email_message' + htmlid).value;

	email_address = document.getElementById('email_address_1_' + htmlid).value;
	if (address_count > 1){ 
		for ($i = 2; $i <= address_count; $i++) {
			if(document.getElementById('email_address_' + $i + '_' + htmlid).value != "") {
				email_address = email_address + ', ' + document.getElementById('email_address_' + $i + '_' + htmlid).value;
			}
		}
	}
	
	if (xmlhttp) {
		url = instpath + "recommend.php";
		content = "email_address=" + escape(email_address) + "&email_to_submit=submit&email_message=" + escape(email_message) + "&original_id=" + original_id + "&backup=0";
		target2 = document.getElementById ('emailto-' + htmlid);
		target2.innerHTML = "<br>Sending, please wait....";
		
		mnmxmlhttp[htmlid] = new myXMLHttpRequest ();
		if (mnmxmlhttp) {
			mnmxmlhttp[htmlid].open ("POST", url, true);
			mnmxmlhttp[htmlid].setRequestHeader ('Content-Type',
					   'application/x-www-form-urlencoded');

			mnmxmlhttp[htmlid].send (content);
			errormatch = new RegExp ("^ERROR:");

			target1 = document.getElementById ('emailto-' + htmlid);

			mnmxmlhttp[htmlid].onreadystatechange = function () {
				if (mnmxmlhttp[htmlid].readyState == 4) {
					mnmString[htmlid] = mnmxmlhttp[htmlid].responseText;
			
					if (mnmString[htmlid].match (errormatch)) {
						mnmString[htmlid] = mnmString[htmlid].substring (6, mnmString[htmlid].length);
						
						target2 = document.getElementById ('emailto-' + htmlid);
						target2.innerHTML = mnmString[htmlid];
						
					} else {
						target2 = document.getElementById ('emailto-' + htmlid);
						target2.innerHTML = mnmString[htmlid];

					}
				}
			}
		}
	}
}

function show_recommend(htmlid, linkid, instpath)
{
	var emailtodisplay=document.getElementById('emailto-' + htmlid).style.display ? '' : 'none';
	document.getElementById('emailto-' + htmlid).style.display = emailtodisplay;

	if (xmlhttp) {
		url = instpath + "recommend.php";
		content = "draw=small&htmlid=" + htmlid + "&linkid=" + linkid;
		target2 = document.getElementById ('emailto-' + htmlid);
		target2.innerHTML = "<br>Loading, please wait....";
		
		mnmxmlhttp[htmlid] = new myXMLHttpRequest ();
		if (mnmxmlhttp) {
			mnmxmlhttp[htmlid].open ("POST", url, true);
			mnmxmlhttp[htmlid].setRequestHeader ('Content-Type',
					   'application/x-www-form-urlencoded');

			mnmxmlhttp[htmlid].send (content);
			errormatch = new RegExp ("^ERROR:");

			target1 = document.getElementById ('emailto-' + htmlid);

			mnmxmlhttp[htmlid].onreadystatechange = function () {
				if (mnmxmlhttp[htmlid].readyState == 4) {
					mnmString[htmlid] = mnmxmlhttp[htmlid].responseText;
			
					if (mnmString[htmlid].match (errormatch)) {
						mnmString[htmlid] = mnmString[htmlid].substring (6, mnmString[htmlid].length);
						
						target2 = document.getElementById ('emailto-' + htmlid);
						target2.innerHTML = mnmString[htmlid];
						
					} else {
						target2 = document.getElementById ('emailto-' + htmlid);
						target2.innerHTML = mnmString[htmlid];

					}
				}
			}
		}
	}
}
