<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".
// -------------------------------------------------------------------------------------

include_once('Smarty.class.php');
if(!isset($main_smarty)){$main_smarty = new Smarty;}
// If we're calling this page through another page like index.php, $main_smarty will already be set
// If we're calling this page directly, set main_smarty

include_once('config.php');
include_once(mnminclude.'html1.php');
include_once(mnminclude.'link.php');
include_once(mnminclude.'tags.php');
include_once(mnminclude.'search.php');
include_once(mnminclude.'smartyvariables.php');
include_once(mnminclude.'sidebarstories.php');

Global $the_template;

	// for filterTo you can use "published", "queued" or "all"
	// to change the way the links look, edit /tempates/<your template>/sidebar_stories.tpl

	$ss = new SidebarStories();
	$ss->orderBy = "link_date DESC"; // newest on top.
	$ss->pagesize = 5; // the number of items to show in the box.

	if(pagename == "index"){
		$ss->filterToStatus = "queued";
		$ss->header = PLIGG_Visual_Pligg_Queued;
	}
	elseif(pagename == "upcoming"){
		$ss->filterToStatus = "published";
		$ss->header = PLIGG_Visual_Published_News;
	}
	else{
		$ss->filterToStatus = "published";
		$ss->header = PLIGG_Visual_Published_News;
	}


	if($the_template == "mollio-beat" || $the_template == "paul01") {

	echo "<img src=minus.gif class=showstate onClick=expandcontent(this,'ss') /><h3>".$ss->header."</h3><div id=ss class=switchcontent>";
		$ss->template = $the_template . '/sidebar_stories.tpl';
		$ss->show();
	echo "</div>";

	}

	elseif ($the_template == "digitalnature") {

	echo "<div class=box><h1><span class=expand><a href=javascript:toggle('stories','expstories'); id=expstories class=expand-up></a></span><a href=javascript:toggle('stories','expstories');".$ss->header."</a></h1><div class=box2 id=stories><div class=wrap><div class=content>";
	$ss->template = $the_template . '/sidebar_stories.tpl';
		$ss->show();
	echo "</div></div></div></div>";

	}

	elseif ($the_template == "yget") {

	echo "<div class=tlb><span><a onclick=\"new Effect.toggle('ssstories','blind', {queue: 'end'}); \"> <img src=\"".my_base_url.my_pligg_base."/templates/yget/images/expand.png\"  onClick=expandcontent(this,'ssstories') ></a></span><a href=".my_pligg_base."/upcoming.php>".$ss->header."</a></div><div id=ssstories style=padding-bottom:5px>";
	$ss->template = $the_template . '/sidebar_stories.tpl';
	$ss->show();
	echo "</div>";

	}

	elseif ($the_template == "Politic20") {
		echo "<h3><a class=\"close\" onclick=\"new Effect.toggle('ssstories','blind', {queue: 'end'}); \">close</a>";
		echo '<span class="upcoming-news">' . $ss->header . '</span></h3>';
		echo '<div class="box" id="ssstories">';
		echo '<ul class="list-rss">';
		$ss->template = $the_template . '/sidebar_stories.tpl';
		$ss->show();
		echo '</ul>';
		echo '<a href="' . my_pligg_base . '/upcoming.php" class="more">read more &raquo;</a>';
		echo '</div>';
		echo '<div class="box-bottom"></div>';
	}
?>