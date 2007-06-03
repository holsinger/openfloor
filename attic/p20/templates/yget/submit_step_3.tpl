{config_load file="/libs/lang.conf"}

<h2>{#PLIGG_Visual_Submit3_Header#}</h2>
<fieldset><legend>{#PLIGG_Visual_Submit3_Details#}</legend>

	{* javascript that protects people from clicking away from the story before submitting it *}
	{literal}
	<SCRIPT>
		// Variable toggles exit confirmation on and foff.
		var gPageIsOkToExit = false;

		function submitEdgeStory()
		{
			// Set a variable so that our "before unload" exit handler knows not to verify
			// the page exit operation.
			gPageIsOkToExit = true;

			// Do the submission.
			// var frm = document.getElementById("thisform");
			frms = document.getElementsByName("ATISUBMIT");
			
			if (frms)
			{
				if (frms[0])
					frms[0].submit();
			}
		}

		window.onbeforeunload = function (event) 
		{
			// See if this is a safe exit.
			if (gPageIsOkToExit)
				return;

			if (!event && window.event) 
	          		event = window.event;
	          		
	   		event.returnValue = "You have not hit the Submit Button to submit your story yet.";
		}
	</SCRIPT>
	{/literal}

	{php}
		Global $db, $main_smarty, $dblang, $the_template, $linkres, $current_user;

		$linkres=new Link;
		$linkres->id=$link_id = $_POST['id'];
		$linkres->read();

		if($linkres->votes($current_user->user_id) == 0 && auto_vote == true) {
			$linkres->insert_vote($current_user->user_id, '10');
			$linkres->store_basic();
			$linkres->read();
		}
		
		$linkres->category=$_POST['category'];
		$linkres->title = strip_tags(trim($_POST['title']));
		$linkres->title_url = makeUrlFriendly($linkres->title);
		$linkres->tags = tags_normalize_string(strip_tags(trim($_POST['tags'])));
		$linkres->content = strip_tags(trim($_POST['bodytext']), Story_Content_Tags_To_Allow);
		$linkres->content = str_replace("\n", "<br />", $linkres->content);
		$linkres->link_field1 = trim($_POST['link_field1']);
		$linkres->link_field2 = trim($_POST['link_field2']);
		$linkres->link_field3 = trim($_POST['link_field3']);
		$linkres->link_field4 = trim($_POST['link_field4']);
		$linkres->link_field5 = trim($_POST['link_field5']);
		$linkres->link_field6 = trim($_POST['link_field6']);
		$linkres->link_field7 = trim($_POST['link_field7']);
		$linkres->link_field8 = trim($_POST['link_field8']);
		$linkres->link_field9 = trim($_POST['link_field9']);
		$linkres->link_field10 = trim($_POST['link_field10']);
		$linkres->link_field11 = trim($_POST['link_field11']);
		$linkres->link_field12 = trim($_POST['link_field12']);
		$linkres->link_field13 = trim($_POST['link_field13']);
		$linkres->link_field14 = trim($_POST['link_field14']);
		$linkres->link_field15 = trim($_POST['link_field15']);
		
		if($_POST['summarytext'] == ""){
			$linkres->link_summary = utf8_substr(strip_tags(trim($_POST['bodytext']), Story_Content_Tags_To_Allow), 0, StorySummary_ContentTruncate - 1);
			$linkres->link_summary = str_replace("\n", "<br />", $linkres->link_summary);		
		} else {
			$linkres->link_summary = strip_tags(trim($_POST['summarytext']), Story_Content_Tags_To_Allow);
			$linkres->link_summary = str_replace("\n", "<br />", $linkres->link_summary);
			if(strlen($linkres->link_summary) > StorySummary_ContentTruncate){
				loghack('SubmitAStory-SummaryGreaterThanLimit', 'username: ' . $_POST["username"].'|email: '.$_POST["email"], true);
				$linkres->link_summary = utf8_substr($linkres->link_summary, 0, StorySummary_ContentTruncate - 1);
				$linkres->link_summary = str_replace("\n", "<br />", $linkres->link_summary);
			}
		}
		
		if (link_errors($linkres)) {
			return;
		}

		$linkres->store();
		tags_insert_string($linkres->id, $dblang, $linkres->tags);
		$linkres->read();
		$edit = true;
		$link_title = $linkres->title;
		$link_content = $linkres->content;
		$link_title = stripslashes(strip_tags(trim($_POST['title'])));
		$linkres->print_summary();
		
		$main_smarty->assign('tags', $linkres->tags);
		if (!empty($linkres->tags)) {
			$tags_words = str_replace(",", ", ", $linkres->tags);
			$tags_url = urlencode($linkres->tags);
			$main_smarty->assign('tags_words', $tags_words);
			$main_smarty->assign('tags_url', $tags_url);
		}

		$main_smarty->assign('submit_url', $url);
		$main_smarty->assign('submit_url_title', $linkres->url_title);
		$main_smarty->assign('submit_id', $linkres->id);
		$main_smarty->assign('submit_type', $linkres->type());
		$main_smarty->assign('submit_title', $link_title);
		$main_smarty->assign('submit_content', $link_content);
		$main_smarty->assign('submit_trackback', $trackback);
	{/php}

	<form action="{$URL_submit}" method="post" id="thisform" name="ATISUBMIT" >
		<input type="hidden" name="phase" value="3" />
		<input type="hidden" name="randkey" value="{$templatelite.post.randkey}" />
		<input type="hidden" name="id" value="{$submit_id}" />
		<input type="hidden" name="trackback" value="{$templatelite.post.trackback|escape:"html"}" />
		
		<br style="clear: both;" /><hr />
		<center>
		<input type=button onclick="javascript:gPageIsOkToExit=true;window.history.go(-1);" value="{#PLIGG_Visual_Submit3_Modify#}" class="log2">&nbsp;&nbsp;
		<input type="button" onclick="javascript:submitEdgeStory();" value="{#PLIGG_Visual_Submit3_SubmitStory#}" class="submit" />
		</center>
	</form>
</fieldset>