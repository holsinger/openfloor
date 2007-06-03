{php}
	global $db, $dblang, $globals, $main_smarty, $offset, $from_where, $top_users_size, $link_id, $order_by, $select;
	
include_once('libs/link.php');

{/php}

<h2>{#PLIGG_Visual_Breadcrumb_Published#}</h2>

<div class="tabs" style="margin-top:-50px; border:none;">
 	<ul>
		<li><a href="{$URL_comments}"><span>{#PLIGG_Visual_Breadcrumb_Comments#}</span></a></li>
		<li><a href="{$URL_unpublished}"><span>{#PLIGG_Visual_Breadcrumb_Unpublished_Tab#}</span></a></li>
		<li class="active"><a href="{$URL_published}"><span>{#PLIGG_Visual_Breadcrumb_Published_Tab#}</span></a></li>
 	  	<li><a href="{$URL_live}"><span>{#PLIGG_Visual_Breadcrumb_All#}</span></a></li>	
	</ul>
</div>	

<div class="live2-item">
  <div class="live2-votes" style="width:15%"><strong>{#PLIGG_Visual_Comments_Date#}</strong></div>
  <div class="live2-ts"><strong>{#PLIGG_Visual_Breadcrumb_Vote#}</strong></div>
  <div class="live2-story" style="width:50%"><strong>{#PLIGG_Visual_Comments_Link#}</strong></div>
  <div class="live2-ts"><strong>{#PLIGG_Visual_Breadcrumb_Category#}</strong></div> 
  <div class="live2-ts"><strong>{#PLIGG_Visual_Comments_Author#}</strong></div>   
  <br clear="left"/>
</div>

{php}
$rows = $db->get_var("SELECT count(*) as count $from_where $order_by");
$comments = $db->get_results("$select $from_where $order_by LIMIT $offset,$top_users_size");

$link = new Link;
$user = new User;
if($comments) {
  foreach($comments as $dblink) {
    $link->id = $dblink->link_id;
    $link->read();
	$main_smarty->assign('link_date', txt_time_diff($link->published_date));
    $main_smarty->assign('link_title', $link->title);
	$main_smarty->assign('link_votes', $link->votes);
	$main_smarty->assign('link_username', $link->username);
	$main_smarty->assign('link_category', GetCatName($link->category));
    $main_smarty->assign('link_url', $link->title_url);
	{/php}
	
	<div class="live2-item">
	<div class="live2-votes" style="width:15%">{$link_date}</div>
	<div class="live2-ts">{$link_votes}</div>
	<div class="live2-ts" style="width:50%"><a href="{$URL_storytitle, $link_url}">{$link_title}</a></div>
	<div class="live2-ts"><a href="{$URL_maincategory, $link_category}">{$link_category}</a></div>
	<div class="live2-ts"><a href="{$URL_user, $link_username}">{$link_username}</a></div>
	</div>
	
	{php}
  }
}

echo "<br />\n\n";

do_pages($rows, $top_users_size, "published"); // show the "page" buttons at the bottom 

{/php}