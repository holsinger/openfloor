{php}
global $db, $dblang, $globals, $main_smarty, $offset, $from_where, $top_users_size, $link_id, $order_by, $select;
include_once('libs/link.php');
{/php}

<div id="cab" style="float:right;">
	<ul class="postin">
		<li><a href="{$URL_comments}" class="navbut3"><span>{#PLIGG_Visual_Breadcrumb_Comments#}</span></a></li>
		<li><a href="{$URL_unpublished}" class="navbut4"><span>{#PLIGG_Visual_Breadcrumb_Unpublished_Tab#}</span></a></li>
		<li><a href="{$URL_published}" class="navbut3"><span>{#PLIGG_Visual_Breadcrumb_Published_Tab#}</span></a></li>
		<li><a href="{$URL_live}" class="navbut3"><span>{#PLIGG_Visual_Breadcrumb_All#}</span></a></li>
	</ul>
</div>

<h2 style="padding-bottom:6px">{#PLIGG_Visual_Breadcrumb_Unpublished#}</h2>

<div class="live2-item">
	<div class="live2-votes" style="width:15%"><strong>{#PLIGG_Visual_Comments_Date#}</strong></div>
	<div class="live2-ts"><strong>{#PLIGG_Visual_Breadcrumb_Vote#}</strong></div>
	<div class="live2-story" style="width:50%"><strong>{#PLIGG_Visual_Comments_Link#}</strong></div>
	<div class="live2-ts"><strong>{#PLIGG_Visual_Breadcrumb_Category#}</strong></div> 
	<div class="live2-ts"><strong>{#PLIGG_Visual_Comments_Author#}</strong></div>   
</div>

{php}
$rows = $db->get_var("SELECT count(*) as count $from_where $order_by");
$stories = $db->get_results("$select $from_where $order_by LIMIT $offset,$top_users_size");

$link = new Link;
$user = new User;
if($stories) {
  foreach($stories as $dblink) {
    $link->id = $dblink->link_id;
    $link->read();
	$main_smarty->assign('link_date', txt_time_diff($link->date));
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
	<div class="live2-ts"><a href="{$URL_queuedcategory, $link_category}">{$link_category}</a></div>
	<div class="live2-ts"><a href="{$URL_user, $link_username}">{$link_username}</a></div>
</div>
	
{php}
  }
}

echo "<br />";
do_pages($rows, $top_users_size, "unpublished"); // show the "page" buttons at the bottom
{/php}