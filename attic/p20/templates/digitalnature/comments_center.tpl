{php}
	global $db, $dblang, $globals, $main_smarty, $offset, $from_where, $top_users_size, $link_id, $order_by, $select;
	
include('libs/comment.php');

{/php}

<h2>{#PLIGG_Visual_Comments#}</h2>

<div class="tabs" style="margin-top:-50px; border:none;">
 	<ul>
		<li class="active"><a href="{$URL_comments}"><span>{#PLIGG_Visual_Breadcrumb_Comments#}</span></a></li>
		<li><a href="{$URL_unpublished}"><span>{#PLIGG_Visual_Breadcrumb_Unpublished_Tab#}</span></a></li>
		<li><a href="{$URL_published}"><span>{#PLIGG_Visual_Breadcrumb_Published_Tab#}</span></a></li>
 	  	<li><a href="{$URL_live}"><span>{#PLIGG_Visual_Breadcrumb_All#}</span></a></li>	
	</ul>
</div>

<div class="live2-item">
  <div class="live2-ts" style="width:43%"><strong>{#PLIGG_Visual_Comments_Comment#}</strong></div>
  <div class="live2-type"><strong>{#PLIGG_Visual_Comments_Author#}</strong></div>
  <div class="live2-votes"><strong>{#PLIGG_Visual_Comments_Date#}</strong></div>
  <div class="live2-story"><strong>{#PLIGG_Visual_Comments_Link#}</strong></div>
  <br clear="left"/>
</div>

{php}
$rows = $db->get_var("SELECT count(*) as count $from_where $order_by");
$comments = $db->get_results("$select $from_where $order_by LIMIT $offset,$top_users_size");

$comment = new Comment;
$user = new User;
$link = new Link;
if($comments) {
  foreach($comments as $dbcomment) {
    $comment->id = $dbcomment->comment_id;
    $comment->read();
    $main_smarty->assign('comment_content', $comment->content);
    $user->id = $comment->author;
    $user->read();
    $main_smarty->assign('comment_author', $user->username);
    $main_smarty->assign('comment_date', txt_time_diff($comment->date));
    $link->id = $comment->link;
    $link->read();
    $main_smarty->assign('comment_link_title', $link->title);
    $main_smarty->assign('comment_link_url', $link->title_url);
	{/php}
	
	<div class="live2-item">
	<div class="live2-ts" style="width:43%; padding:3px 3px 3px 3px">{$comment_content}</div>
	<div class="live2-type"><a href="{$URL_user, $comment_author}">{$comment_author}</a></div>
	<div class="live2-votes">{$comment_date}</div>
	<div class="live2-story"><a href="{$URL_storytitle, $comment_link_url}">{$comment_link_title}</a></div>
	</div>
	
	{php}
  }
}

echo "<br />\n\n";

do_pages($rows, $top_users_size, "comments"); // show the "page" buttons at the bottom 

{/php}