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
	check_actions('upcoming_top');
	
	if(isset($_REQUEST['category'])){
		// find the name of the current category
		$thecat = $db->get_var("SELECT category_name FROM " . table_categories . " WHERE `category_safe_name` = '".$db->escape($_REQUEST['category'])."';");
	}
	
	// start a new search
	$search=new Search();
		if(isset($_REQUEST['from'])){$search->newerthan = sanitize($_REQUEST['from'], 3);}
		if(isset($_REQUEST['search'])){$search->searchTerm = sanitize($_REQUEST['search'], 3);}
		if(!isset($_REQUEST['search'])){$search->orderBy = "link_date DESC";}
		if(isset($_REQUEST['tag'])){$search->searchTerm = sanitize($_REQUEST['search'], 3); $search->isTag = true;}

		// figure out what "page" of the results we're on
		$search->offset = (get_current_page()-1)*$page_size;

		// pagesize set in the admin panel
		$search->pagesize = $page_size;

		// since this is index, we only want to view "queued" stories
		$search->filterToStatus = "queued";

		// this is for the tabs on the top that filter
		$search->setmek = $db->escape($_GET['part']);
		$search->ords = $db->escape($_GET['order']);
		$search->do_setmek();

		// filter to just the category we're looking at
		$search->category = $thecat; 

		// do the search
		$search->doSearch();

	
	// setup the links
	if(isset($_GET['category'])){
	$main_smarty->assign('upcoming_url_newest', getmyurl('upcoming_sort', 'upcoming', 'newest', '&category='.sanitize($_GET['category'],2)));
	$main_smarty->assign('upcoming_url_oldest', getmyurl('upcoming_sort', 'upcoming', 'oldest', '&category='.sanitize($_GET['category'],2)));
	$main_smarty->assign('upcoming_url_mostpopular', getmyurl('upcoming_sort', 'upcoming', 'mostpopular', '&category='.sanitize($_GET['category'],2)));
	$main_smarty->assign('upcoming_url_leastpopular', getmyurl('upcoming_sort', 'upcoming', 'leastpopular', '&category='.sanitize($_GET['category'],2)));
   	$main_smarty->assign('cat_url', getmyurl("queuedcategory"));
	}
    else {
	$main_smarty->assign('upcoming_url_newest', getmyurl('upcoming_sort', 'upcoming', 'newest'));
	$main_smarty->assign('upcoming_url_oldest', getmyurl('upcoming_sort', 'upcoming', 'oldest'));
	$main_smarty->assign('upcoming_url_mostpopular', getmyurl('upcoming_sort', 'upcoming', 'mostpopular'));
	$main_smarty->assign('upcoming_url_leastpopular', getmyurl('upcoming_sort', 'upcoming', 'leastpopular'));
	}
	
	$linksum_count = $search->countsql;
	$linksum_sql = $search->sql;


	if(isset($_REQUEST['category']))
	{
		// breadcrumbs / navbar for the category we're looking at
		$main_smarty->assign('title', ''.$main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Queued').' / ' . $thecat . '');
		$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Queued');
		$navwhere['link1'] = getmyurl('upcoming', '');
		$navwhere['text2'] = $thecat;
		$main_smarty->assign('navbar_where', $navwhere);
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Queued').' / ' . $thecat);
		$main_smarty->assign('page_header', $main_smarty->get_config_vars('PLIGG_Visual_Pligg_Queued').' / ' . $thecat);
	} else {
		$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Queued');
		$navwhere['link1'] = getmyurl('upcoming', '');
		$main_smarty->assign('navbar_where', $navwhere);
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Queued'));
		$main_smarty->assign('page_header', $main_smarty->get_config_vars('PLIGG_Visual_Pligg_Queued'));
	}


	// sidebar
	$main_smarty = do_sidebar($main_smarty);

	// pagename	
	define('pagename', 'upcoming');
	$main_smarty->assign('pagename', pagename);

	// misc smarty
	$main_smarty->assign('setmeka', $search->setmek);
	$main_smarty->assign('paorder', $search->ords);
	$main_smarty->assign('totalupcoming', $upcount);

	// show the template
	$main_smarty->assign('tpl_center', $the_template . '/upcoming_center');
	$main_smarty->display($the_template . '/pligg.tpl');
?>