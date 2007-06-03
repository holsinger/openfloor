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

Global
$the_template;

	$ss = new SidebarStories();
	$ss->pagesize = 5; // the number of items to show in the box.
	
	$ss->orderBy = "link_votes DESC"; // newest on top.
	$ss->filterToTimeFrame = 'today';
	$ss->header = PLIGG_Visual_Pligg_Today;

	
	if($the_template == "yget") {
	echo "<div class=tlb><span><a onclick=\"new Effect.toggle('sstop','blind', {queue: 'end'}); \">  <img src=\"".my_base_url.my_pligg_base."/templates/yget/images/expand.png\" onClick=expandcontent(this,'sstop') ></a></span><a href=".my_pligg_base."/index.php?part=today>".$ss->header."</a></div><div id=sstop style=padding-bottom:5px>";
		$ss->template = $the_template . '/sidebar_stories.tpl';
		$ss->show();
	echo "</div>";
	}
?>