<?php
	global $new_search;
	$link = new Link;

	if ($new_search) {
		//$rows = count($new_search);
		$rows = $new_search['count'];
		$new_search = $new_search['rows'];
		if ($new_search) {
			foreach($new_search as $link_id) {
				$link->id=$link_id;
				$link->read();
				$link->print_summary('summary');
			}
		}
	} else {
	$rows = $db->get_var($linksum_count);
	$links = $db->get_col($linksum_sql);
	if ($links) {
		foreach($links as $link_id) {
			$link->id=$link_id;
			$link->read();
			$link->print_summary('summary');
			}
		}
	}
?>