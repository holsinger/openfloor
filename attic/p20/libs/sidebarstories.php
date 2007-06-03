<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// The Pligg Team <pligger at pligg dot com>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

class SidebarStories {
  var $pagesize = 5; // The number of items to show
  var $orderBy = ""; // The sorting order
  var $filterToStatus = "all"; // Filter to "all" or just "published" or "queued"
  var $filterToTimeFrame = ""; // Filter to "all" or just "published" or "queued"
  var $header = ""; // The text to show at the top
  var $template = ""; // The template to use, including folder
  
	function show() {
		global $main_smarty, $db;
		include_once(mnminclude.'search.php');

		$search=new Search();
		$search->orderBy = $this->orderBy;
		$search->pagesize = $this->pagesize;
		$search->filterToStatus = $this->filterToStatus;
		$search->filterToTimeFrame = $this->filterToTimeFrame;
		$search->doSearch();
	
		$linksum_sql = $search->sql;
	
		$link = new Link;
		$links = $db->get_col($linksum_sql);
	
		if ($links) {
			foreach($links as $link_id) {
				$link->id=$link_id;
				$link->read();
				$main_smarty = $link->fill_smarty($main_smarty);
				$main_smarty->display($this->template);
			 }
		}
		
	}
}