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
	check_actions('index_top');
	
	if(isset($_REQUEST['category'])){
		// find the name of the current category
		$thecat = $db->get_var("SELECT category_name FROM " . table_categories . " WHERE `category_safe_name` = '".$db->escape($_REQUEST['category'])."';");
	}
	
	// start a new search
	$search=new Search();
		// check for some get/post
		if(isset($_REQUEST['from'])){$search->newerthan = sanitize($_REQUEST['from'], 3);}
		if(isset($_REQUEST['search'])){$search->searchTerm = sanitize($_REQUEST['search'], 3);}
		if(!isset($_REQUEST['search'])){$search->orderBy = "link_published_date DESC";}
		if(isset($_REQUEST['tag'])){$search->searchTerm = sanitize($_REQUEST['search'], 3); $search->isTag = true;}

		// figure out what "page" of the results we're on
		$search->offset = (get_current_page()-1)*$page_size;

		// pagesize set in the admin panel
		$search->pagesize = $page_size;

		// since this is index, we only want to view "published" stories
		$search->filterToStatus = "published";
		
		// this is for the tabs on the top that filter
		if(isset($_GET['part'])){$search->setmek = $db->escape($_GET['part']);}
		if(isset($_GET['order'])){$search->setmek = $db->escape($_GET['order']);}
		$search->do_setmek();	
		if(isset($_REQUEST['search'])){$search->filterToStatus = "all";}

		// filter to just the category we're looking at
		if(isset($thecat)){$search->category = $thecat;}

		// do the search
		$search->doSearch();
	
		// find out how many queued stories there are
		$upcount = $search->doCountUpcoming();
	
	 
	$linksum_count = $search->countsql;
	$linksum_sql = $search->sql;

	if(isset($_REQUEST['category']))
	{
		// breadcrumbs / navbar for the category we're looking at
		$main_smarty->assign('title', ''.$main_smarty->get_config_vars('PLIGG_Visual_Published_News').' / ' . $thecat . '');
		$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Published_News');
		$navwhere['link1'] = getmyurl('index', '');
		$navwhere['text2'] = $thecat;
		$navwhere['link1'] = getmyurl('maincategory', sanitize($_REQUEST['category'],2)); //use $_REQUEST['category'] instead of $thecat to use the category_safe_name
		$main_smarty->assign('navbar_where', $navwhere);
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Published_News').' / ' . $thecat);
		$main_smarty->assign('page_header', $main_smarty->get_config_vars('PLIGG_Visual_Published_News').' / ' . $thecat);
	} else {
		// breadcrumbs / navbar
		$navwhere['show'] = 'no';
		$main_smarty->assign('navbar_where', $navwhere);
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Published_News'));
		$main_smarty->assign('page_header', $main_smarty->get_config_vars('PLIGG_Visual_Published_News'));
	}
	
	//  make sure my_base_url is set
	if($my_base_url == ''){echo '<center><span class=error>ERROR: my_base_url is not set. Please correct this using the <a href = "admin_config.php?page=Location%20Installed">admin panel</a>. Then refresh this page.</span></center>';}

	// sidebar
	$main_smarty = do_sidebar($main_smarty);

	// pagename	
	define('pagename', 'index'); 
	$main_smarty->assign('pagename', pagename);
	
	// misc smarty
	if(isset($from_text)){$main_smarty->assign('from_text', $from_text);}
	if(isset($search->setmek)){$main_smarty->assign('setmeka', $search->setmek);}else{$main_smarty->assign('setmeka', '');}
	if(isset($search->ords)){$main_smarty->assign('paorder', $search->ords);}
	$main_smarty->assign('totalupcoming', $upcount);

	// show the template
	$main_smarty->assign('tpl_center', $the_template . '/index_center');
	$main_smarty->display($the_template . '/pligg.tpl');
?>