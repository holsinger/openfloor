<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

include_once('Smarty.class.php');

$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'smartyvariables.php');

$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Live');
$navwhere['link1'] = getmyurl('live', '');
$main_smarty->assign('navbar_where', $navwhere);
$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Live'));
$main_smarty->assign('page_header', $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Live'));

$globals['body-args'] = 'onload="start()"';

$main_smarty->assign('body_args', 'onload="start()"');
$main_smarty->assign('items_to_show', items_to_show);
$main_smarty->assign('showsideleftsidebar', "no");
$main_smarty->assign('showsiderightsidebar', "no");

define('pagename', 'live'); 
$main_smarty->assign('pagename', pagename);

$main_smarty = do_sidebar($main_smarty);

$main_smarty->assign('tpl_center', $the_template . '/live_center');
$main_smarty->display($the_template . '/pligg.tpl');
?>

<script type="text/javascript">
//<![CDATA[
var timestamp=0;
var busy = false;
var animating = false;
var base_url = '<?php echo my_base_url;?>'+'<?php echo my_pligg_base;?>/live2.php';
var items = Array();
var new_items = 0;
var animation_colors = Array("#ffc891", "#ffd3a6", "#ffd7ae", "#ffdcb9", "#FFE2C5", "#ffe3c8", "#ffe9d3", "#ffeddb", "#fff0e1", "#fff6ee", "#fffaf6", "#fffdfa", "#ffffff");
var colors_max = animation_colors.length - 1;
var current_colors = Array();
var animation_timer;
var max_items = <?php echo items_to_show; ?>;
var min_update = <?php echo (how_often_refresh * 1000); ?>;
var next_update = 5000;
var xmlhttp = new myXMLHttpRequest ();
var requests = 0;
var max_requests = 3000;
// Reload the mnm banner each 5 minutes
var mnm_banner_reload = 180000;

function start() {
	for (i=0; i<max_items; i++) {
		items[i] = document.getElementById('live2-'+i);
	}
	get_data();
}


function get_data() {
	if (busy) return;
	busy = true;
	url=base_url+'?time='+timestamp;
	xmlhttp.open("GET",url,true);
	xmlhttp.onreadystatechange=received_data;
	xmlhttp.send(null);
	requests++;
	return false;
}

function set_initial_color(i) {
	var j;
	if (i >= colors_max)
		j = colors_max - 1;
	else j = i;
	current_colors[i] = j;
	items[i].style.backgroundColor = animation_colors[j];
}

function animate_background() {
	if (animating) {
		return;
	}
	if (current_colors[0] == colors_max) {
		clearInterval(animation_timer);
		return;
	}
	animating = true;
	for (i=new_items-1; i>=0; i--) {
		if (current_colors[i] < colors_max) {
			current_colors[i]++;
			items[i].style.backgroundColor = animation_colors[current_colors[i]];
		} else 
			new_items--;
	}
	animating = false;
}

function received_data() {
	if (xmlhttp.readyState != 4) return;
	busy = false;
	if (xmlhttp.status == 200 && xmlhttp.responseText.length > 10) {
		// We get new_data array
		var new_data = Array();
		eval (xmlhttp.responseText);
		new_items= new_data.length;
		if(new_items > 0) {
			clearInterval(animation_timer);
			next_update = Math.round(0.5*next_update + 0.5*min_update/(new_items*2));
			shift_items(new_items);
			for (i=0; i<new_items && i<max_items; i++) {
				items[i].innerHTML = to_html(new_data[i]);
				set_initial_color(i);
			}
			animation_timer = setInterval('animate_background()', 100)
		} else next_update = Math.round(next_update*1.25);
	}
	if (next_update < 5000) next_update = 5000;
	if (next_update > min_update) next_update = min_update;
	if (requests > max_requests) {
		if ( !confirm('<?php echo _('Timeout: Would you like to try to reconnect?');?>') ) {
			mnm_banner_reload = 0;
			return;
		}
		requests = 0;
		next_update = 100;
	}
	timer = setTimeout('get_data()', next_update)
}

function shift_items(n) {
	//for (i=n;i<max_items;i++) {
	for (i=max_items-1;i>=n;i--) {
		items[i].innerHTML = items[i-n].innerHTML;
		//items.shift();
	}
}

function to_html(data) {
	var ts=new Date(data.ts*1000);
	var timeStr;

	var hours = ts.getHours();
	var minutes = ts.getMinutes();
	var seconds = ts.getSeconds();

	timeStr  = ((hours < 10) ? "0" : "") + hours;
	timeStr  += ((minutes < 10) ? ":0" : ":") + minutes;
	timeStr  += ((seconds < 10) ? ":0" : ":") + seconds;

	html = '<div class="live2-ts">'+timeStr+'</div>';

	if (data.type == 'problem')
		html += '<div class="live2-type"><span class="live2-problem">'+data.type+'</span></div>';
	else if (data.type == 'new')
		html += '<div class="live2-type"><strong><a href="<?php echo my_pligg_base; ?>/unpublished.php">'+data.type+'</a></strong></div>';
	else if (data.type == 'published')
		html += '<div class="live2-type"><strong><a href="<?php echo my_pligg_base; ?>/published.php">'+data.type+'</a></strong></div>';	
	else if (data.type == 'comment')
		html += '<div class="live2-type"><strong><a href="<?php echo my_pligg_base; ?>/comments.php">'+data.type+'</a></strong></div>';	
	else
		html += '<div class="live2-type">'+data.type+'</div>';

	html += '<div class="live2-votes">'+data.votes+'</div>';
	html += '<div class="live2-story"><a href="<?php echo my_base_url.my_pligg_base; ?>/story.php?id='+data.link+'">'+data.title+'</a></div>';
	if (data.type == 'problem')
		html += '<div class="live2-who"><span class="live2-problem">'+data.who+'</span></div>';
	else if (data.uid > 0) 
		html += '<div class="live2-who"><a href="<?php echo my_base_url.my_pligg_base; ?>/user.php?login='+data.who+'">'+data.who+'</a></div>';
	else 
		html += '<div class="live2-who">'+data.who+'</div>';
	html += '<div class="live2-status">'+data.status+'</div>';
	return html;
}

//]]>
</script>