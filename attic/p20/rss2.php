<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

include('config.php');
include(mnminclude.'link.php');
include(mnminclude.'html1.php');
include(mnminclude.'search.php');

if(!empty($_REQUEST['rows']))
	$rows = $_REQUEST['rows'];
else $rows = 40;


if(!empty($_REQUEST['time'])) {
	// Prepare for times
	if(!($time = check_integer('time')))
		die;
	$sql = "SELECT link_id, count(*) as votes FROM " . table_votes . ", " . table_links . " WHERE  ";
	if ($time > 0) {
		$from = time()-$time;
		$sql .= "vote_date > FROM_UNIXTIME($from) AND ";
	}
	$sql .= "vote_link_id=link_id  AND link_status != 'discard' GROUP BY vote_link_id  ORDER BY votes DESC LIMIT $rows";


	$last_modified = time();
	$title = _(PLIGG_Visual_RSS_Recent) . ' ' . txt_time_diff($from);
	//$link_date = "modified";
	$link_date = "";

} else {
	// All the others
	$tmpsearch = new Search;
	$tmpsearch->searchTerm = sanitize($_REQUEST['search'], 3);
	$search = $tmpsearch->get_search_clause();
	// The link_status to search
	if(!empty($_REQUEST['status'])) {
		$status = $_REQUEST['status'];
	} else {
		// By default it searches on all
		if($search) $status = 'published';
		else $status = 'published';
	}


	switch ($status) {
		case 'published':
			$order_field = 'link_published_date';
			$link_date = 'published_date';
			$title = "";
			break;
		case 'queued':
			$title = "";
			$order_field = 'link_date';
			$link_date = "date";
			$home = "/upcoming.php";
			break;
		case 'all':
			$title = "";
			$order_field = 'link_date';
			$link_date = "date";
			break;
	}


	if($status == 'all') {
		$from_where = "FROM " . table_links . " WHERE link_status!='discard' ";
	} else {
		$from_where = "FROM " . table_links . " WHERE link_status='$status' ";
	}
	if(($cat=check_integer('category'))) {
		$from_where .= " AND link_category=$cat ";
		$category_name = $db->get_var("SELECT category_name FROM " . table_categories . " WHERE category_id = $cat AND category_lang='$dblang'");
		$title .= " / " . htmlspecialchars($category_name);
	}

	if($search) {
		$from_where .= $search;
		$title = _(PLIGG_Visual_RSS_RSSFeed) . ": " . htmlspecialchars($_REQUEST['search']);
	}

	$order_by = " ORDER BY $order_field DESC ";
	$last_modified = $db->get_var("SELECT UNIX_TIMESTAMP(max($order_field)) links $from_where");
	$sql = "SELECT link_id $from_where $order_by LIMIT $rows";
}

do_rss_header($title);

$link = new Link;
$links = $db->get_col($sql);
if ($links) {
	foreach($links as $link_id) {
		$link->id=$link_id;
		$link->read();
		$category_name = $db->get_var("SELECT category_name FROM " . table_categories . " WHERE category_id = $link->category AND category_lang='$dblang'");

		$link->link_summary = str_replace("\n", "<br />", $link->link_summary);
		$link->link_summary = str_replace("’", "'", $link->link_summary);
		$link->link_summary = str_replace("–", "-", $link->link_summary);
		$link->link_summary = str_replace("—", "-", $link->link_summary);
		$link->link_summary = str_replace("“", "\"", $link->link_summary);
		$link->link_summary = str_replace("”", "\"", $link->link_summary);
		
		
		$description = $link->link_summary;
		//$description = onlyreadables(remove_error_creating_chars($description)); it removes not latin characters
		$description = strip_tags($description);
		$description = htmlspecialchars($description);
		
		$title = $link->title;
		//$title = onlyreadables(remove_error_creating_chars($title)); it removes not latin characters
		$title = strip_tags($title);
		$title = htmlspecialchars($title);
		$link->title = str_replace("á", "a", $link->title);
		$link->title = str_replace("é", "e", $link->title);
		$link->title = str_replace("í", "i", $link->title);
		$link->title = str_replace("ó", "o", $link->title);
		$link->title = str_replace("ú", "u", $link->title);
		$link->title = str_replace("ñ", "n", $link->title);
		$link->title = str_replace("Á", "A", $link->title);
		$link->title = str_replace("É", "E", $link->title);
		$link->title = str_replace("Í", "I", $link->title);
		$link->title = str_replace("Ó", "O", $link->title);
		$link->title = str_replace("Ú", "U", $link->title);
		$link->title = str_replace("¿", "", $link->title);
		$link->title = str_replace("Ñ", "N", $link->title);
		
		echo "	<item>\n";
		echo "		<title><![CDATA[". $title . "]]></title>\n";
		echo "		<link>".getmyFullurl("storyURL", $link->category_safe_name($link->category), urlencode($link->title_url), $link->id)."</link>\n";
		echo "		<comments>".getmyFullurl("storyURL", $link->category_safe_name($link->category), urlencode($link->title_url), $link->id)."</comments>\n";
		if (!empty($link_date))
			echo "		<pubDate>".date('D, d M Y H:i:s T', $link->$link_date)."</pubDate>\n";
		else echo "      <pubDate>".date('D, d M Y H:i:s T', time())."</pubDate>\n";
		echo "		<dc:creator>$link->username</dc:creator>\n";
		echo "		<category>" . htmlspecialchars($category_name) . "</category>\n";
		echo "		<guid>".getmyFullurl("storyURL", $link->category_safe_name($link->category), urlencode($link->title_url), $link->id)."</guid>\n";
		echo "		<description><![CDATA[" . $description . " ]]></description>\n";
		// echo "		<trackback:ping>".get_trackback($link->id)."</trackback:ping>\n";  // no standard
		//echo "<content:encoded><![CDATA[ ]]></content:encoded>\n";
		echo "	</item>\n\n";
	}
}

do_rss_footer();

function do_rss_header($title) {
	global $last_modified, $dblang, $home;
	header('Content-type: text/xml; charset=utf-8', true);
	echo '<?xml version="1.0" encoding="utf-8"?'.'>' . "\n";
	echo '<rss version="2.0" '."\n";
	echo '     xmlns:content="http://purl.org/rss/1.0/modules/content/"'."\n";
	echo '     xmlns:wfw="http://wellformedweb.org/CommentAPI/"'."\n";
	echo '     xmlns:dc="http://purl.org/dc/elements/1.1/"'."\n";
	echo ' >'. "\n";
	echo '<channel>'."\n";
	echo'	<title>'._(PLIGG_Visual_Name) .$title.'</title>'."\n";
	echo'	<link>'.my_base_url.my_pligg_base.$home.'</link>'."\n";
	echo'	<description>'._(PLIGG_Visual_RSS_Description).'</description>'."\n";
	echo'	<pubDate>'.date('D, d M Y H:i:s T', $last_modified).'</pubDate>'."\n";
	echo'	<language>'.$dblang.'</language>'."\n";
}

function do_rss_footer() {
	echo "</channel>\n</rss>\n";
}

function onlyreadables($string) {
  for ($i=0;$i<strlen($string);$i++) {
   $chr = $string{$i};
   $ord = ord($chr);
   if ($ord<32 or $ord>126) {
     $chr = "~";
     $string{$i} = $chr;
   }
  }
  return str_replace("~", "", $string);
}
?>
