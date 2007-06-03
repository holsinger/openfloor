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
include(mnminclude.'ts.php');
include(mnminclude.'link.php');
include(mnminclude.'tags.php');
include(mnminclude.'search.php');
include(mnminclude.'smartyvariables.php');

// -------------------------------------------------------------------------------------

	// module system hook
	check_actions('discard_top');
	
	if(isset($_REQUEST['category'])){
		// find the name of the current category
		$thecat = $db->get_var("SELECT category_name FROM " . table_categories . " WHERE `category_safe_name` = '".$_REQUEST['category']."';");
	}
	
	// start a new search
	$search=new Search();
		// check for some get/post
		if(isset($_REQUEST['from'])){$search->newerthan = sanitize($_REQUEST['from'], 3);}
		if(isset($_REQUEST['search'])){$search->searchTerm = sanitize($_REQUEST['search'], 3);}
		if(!isset($_REQUEST['search'])){$search->orderBy = "link_date DESC";}

		// figure out what "page" of the results we're on
		$search->offset = (get_current_page()-1)*$page_size;

		// pagesize set in the admin panel
		$search->pagesize = $page_size;

		// we only want to view "discarded" stories
		$search->filterToStatus = "discard";

		// filter to just the category we're looking at
		$search->category = $thecat; 

		// do the search
		$search->doSearch();

		$linksum_count = $search->countsql;
		$linksum_sql = $search->sql;

	if(isset($_REQUEST['category']))
	{
		// breadcrumbs / navbar for the category we're looking at
		$main_smarty->assign('title', ''.$main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Discarded').' / ' . $thecat . '');

		$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Discarded');
		$navwhere['link1'] = getmyurl('discarded', '');
		$navwhere['text2'] = $thecat;
		$navwhere['link2'] = getmyurl('discarded_cat', $_REQUEST['category']); //use $_REQUEST['category'] instead of $thecat to use the category_safe_name
		$main_smarty->assign('navbar_where', $navwhere);
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Discarded').' / ' . $thecat);
		$main_smarty->assign('page_header', $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Discarded').' / ' . $thecat);
	} else {
		$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Discarded');
		$navwhere['link1'] = getmyurl('discarded', '');
		$main_smarty->assign('navbar_where', $navwhere);
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Discarded'));
		$main_smarty->assign('page_header', $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Discarded'));
		$main_smarty->assign('cat_url', getmyurl("queuedcategory"));
	}

	// sidebar
	$main_smarty = do_sidebar($main_smarty);

	// pagename	
	define('pagename', 'discarded');
	$main_smarty->assign('pagename', pagename);

	// show the template
	$main_smarty->assign('tpl_center', $the_template . '/upcoming_center');
	$main_smarty->display($the_template . '/pligg.tpl');
?>