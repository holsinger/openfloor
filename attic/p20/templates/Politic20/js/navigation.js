function initPage()
{
	var head = document.getElementById("header");
	var page = document.getElementById("page");
	var width = head.offsetWidth + 39;
	page.style.width = width + "px";
}

if (window.addEventListener)
	window.addEventListener("load", initPage, false);
else if (window.attachEvent)
	window.attachEvent("onload", initPage);

