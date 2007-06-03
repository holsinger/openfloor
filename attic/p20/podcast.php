<?
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
else $rows = 10;
	

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
	$search = $tmpsearch->get_search_clause;
	// The link_status to search
	if(!empty($_REQUEST['status'])) {
		$status = $_REQUEST['status'];
	} else {
		// By default it searches on all
		if($search) $status = 'all';
		else $status = 'published';
	}
	
	
	switch ($status) {
		case 'published':
			$order_field = 'link_published_date';
			$link_date = 'published_date';
// Podcast Title
			$title = _(PLIGG_Visual_Podcast_Title);
			break;
		case 'queued':
			$title = _(PLIGG_Visual_RSS_Queued);
			$order_field = 'link_date';
			$link_date = "date";
			$home = "/upcoming.php";
			break;
		case 'all':
			$title = _(PLIGG_Visual_RSS_All);
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
		$title .= " -$category_name-";
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
		echo	    '<description>'._(PLIGG_Visual_Podcast_Description).'</description>';
		echo 	    '<link>'._(PLIGG_Visual_Podcast_Link).'</link>';
		echo 	    '<language>'._(PLIGG_Visual_Podcast_Language).'</language>';
		echo 	    '<copyright>'._(PLIGG_Visual_Podcast_Copyright).'</copyright>';
		echo "	    <lastBuildDate>".date("r", $link->$link_date)."</lastBuildDate>\n";
		echo "	    <pubDate>".date("r", $link->$link_date)."</pubDate>\n";
		echo "	    <docs>http://blogs.law.harvard.edu/tech/rss</docs>\n";
		echo 	    '<webMaster>'._(PLIGG_Visual_Podcast_Webmaster).'</webMaster>';
// iTunes Channel Information
		echo 	    '<itunes:author>'._(PLIGG_Visual_Podcast_iTunes_Author).'</itunes:author>';
		echo 	    '<itunes:subtitle>'._(PLIGG_Visual_Podcast_iTunes_Subtitle).'</itunes:subtitle>';
		echo 	    '<itunes:summary>'._(PLIGG_Visual_Podcast_iTunes_Summary).'</itunes:summary>';
		echo "	    <itunes:owner>\n";
		echo 	           '<itunes:name>'._(PLIGG_Visual_Podcast_iTunes_Owner).'</itunes:name>';
		echo 	           '<itunes:email>'._(PLIGG_Visual_Podcast_iTunes_Owner_Email).'</itunes:email>';
		echo "	    </itunes:owner>\n";
		echo 	'<itunes:explicit>'._(PLIGG_Visual_Podcast_iTunes_Explicit).'</itunes:explicit>';
		echo 	'<itunes:image href="'._(PLIGG_Visual_Podcast_iTunes_Image).'"/>';
		echo 	'<itunes:category text="'._(PLIGG_Visual_Podcast_Category).'">';
		echo 	     '<itunes:category text="'._(PLIGG_Visual_Podcast_Subcategory).'"/>';
		echo "	</itunes:category>\n";
// Article Information
		echo "	<item>\n";
		echo "		<title><![CDATA[$link->title]]></title>\n";
		echo "		<link>".getmyFullurl("storyURL", $link->category_safe_name($link->category), $link->title_url, $link->id)."</link>\n";
		echo "		<comments>".getmyFullurl("storyURL", $link->category_safe_name($link->category), $link->title_url, $link->id)."</comments>\n";
		if (!empty($link_date))
		echo "		<pubDate>".date("r", $link->$link_date)."</pubDate>\n";
		else echo "      <pubDate>".date("r", time())."</pubDate>\n";
		echo "		<dc:creator>$link->username</dc:creator>\n";
		echo "		<category>$category_name</category>\n";
		echo "		<guid>".getmyFullurl("storyURL", $link->category_safe_name($link->category), $link->title_url, $link->id)."</guid>\n";
		echo "		<description><![CDATA[$description &nbsp;&#187;&nbsp;<a href='".htmlspecialchars($link->url)."'>"._(PLIGG_Visual_RSS_OriginalNews)."</a>]]></description>\n";
	   	echo "		<enclosure url='$link->url' length='1' type='audio/mpeg'/>\n";
		// echo "		<trackback:ping>".get_trackback($link->id)."</trackback:ping>\n";  // no standard
		//echo "<content:encoded><![CDATA[ ]]></content:encoded>\n";
//itunes article
		echo "	<itunes:explicit>No</itunes:explicit>\n";
		echo "	<itunes:subtitle>$link->content</itunes:subtitle>\n";
		echo "	<itunes:summary>$link->content</itunes:summary>\n";
		echo "	<itunes:duration>00:00:01</itunes:duration>\n";
		echo "	<itunes:keywords>Pligg digg content management open source free yankidank ash ashdigg</itunes:keywords>\n";
		echo "	</item>\n\n";
	}
}

do_rss_footer();

function do_rss_header($title) {
	global $last_modified, $dblang, $home;
	header('Content-type: text/xml; charset=UTF-8', true);
	echo '<?phpxml version="1.0" encoding="UTF-8"?'.'>' . "\n";
	echo '<rss version="2.0" '."\n";
	echo '     xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd"'."\n";

	echo '     xmlns:content="http://purl.org/rss/1.0/modules/content/"'."\n";
	echo '     xmlns:wfw="http://wellformedweb.org/CommentAPI/"'."\n";
	echo '     xmlns:dc="http://purl.org/dc/elements/1.1/"'."\n";
	echo ' >'. "\n";
	echo '<channel>'."\n";
	echo'	<title>'._(PLIGG_Visual_Name).' - '.$title.'</title>'."\n";
	echo'	<link>http://'.get_server_name().$home.'</link>'."\n";
	echo"	<image><title>".get_server_name()."</title><link>http://".get_server_name()."</link><url>http://".get_server_name()."/img/mnm-rss.gif</url></image>\n";
	echo'	<description>'._(PLIGG_Visual_RSS_Description).'</description>'."\n";
	echo'	<pubDate>'.date("r", $last_modified).'</pubDate>'."\n";
	echo'	<generator>Pligg Podcast Generator</generator>'."\n";
	echo'	<language>'.$dblang.'</language>'."\n";
}

function do_rss_footer() {
	echo "</channel>\n</rss>\n";
}
	
?>