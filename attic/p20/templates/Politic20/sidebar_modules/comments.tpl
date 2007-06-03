														<h3>
														{php}
															echo "<a onclick=\"new Effect.toggle('sr','blind', {queue: 'end'}); \" class=\"close\">close</a>";
														{/php}
														<span class="latest-comments">{#PLIGG_Visual_Comments#}</span></h3>
														<div class="box" id="sr">
															<ul class="list-rss">
{php}
	global $db, $dblang, $globals, $main_smarty;
	include('libs/comment.php');

	$select = "SELECT comment_id";
	$from_where = " FROM " . table_comments . " ";
	$order_by = " ORDER BY comment_id DESC";

	$rows = $db->get_var("SELECT count(*) as count $from_where $order_by");
	$comments = $db->get_results("$select $from_where $order_by LIMIT 5");

	$comment = new Comment;
	$link = new Link;
	if($comments) {
		foreach($comments as $dbcomment) {
			$comment->id = $dbcomment->comment_id;
			$comment->read();
			$link->id = $comment->link;
			$link->read();
{/php}
																<li>
																	<a href="{$URL_storytitle}{php}echo $link->title_url{/php}">{php}echo $link->title;{/php}</a><br />
																	{php}echo $comment->content;{/php}
																</li>
{php}
  }
}
{/php}
															</ul>
														</div>
														<div class="box-bottom"></div>