function toggle1(obj,srclink,obj2,srclink2) {
 var el = document.getElementById(obj);
 var e2 = document.getElementById(obj2);
 var srcEl = document.getElementById(srclink); 
 var srcE2 = document.getElementById(srclink2); 
 if (el.style.display == 'none') {
  el.style.display = '';
  e2.style.display = 'none';
  srcEl.className = 'active';
  srcE2.className = '';	
 }
}
