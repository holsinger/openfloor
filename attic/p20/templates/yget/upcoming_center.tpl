{php}
	global $db, $dblang, $globals, $main_smarty, $search, $offset, $from_where, $page_size, $link_id, $linksum_sql, $linksum_count;

	echo '<div id="contents">'; 
	include('./libs/link_summary.php'); // this is the code that show the links / stories
	echo '</div><br/><br/>';
	
	do_pages($rows, $page_size, "upcoming"); // show the "page" buttons at the bottom 
{/php}