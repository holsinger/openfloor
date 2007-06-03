<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

class Link {
	var $id = 0;
	var $author = -1;
	var $blog = 0;
	var $username = false;
	var $randkey = 0;
	var $karma = 1;
	var $valid = true;
	var $date = false;
	var $published_date = 0;
	var $modified = 0;
	var $url = true;
	var $url_title = true;
	var $encoding = false;
	var $status = 'discard';
	var $type = '';
	var $category = 0;
	var $votes = 0;
	var $title = '';
	var $title_url = '';
	var $tags = '';
	var $content = '';
	var $html = true;
	var $trackback = false;
	var $read = true;
	var $fullread = true;
	var $voted = false;
	var $link_field1 = '';
	var $link_field2 = '';
	var $link_field3 = '';
	var $link_field4 = '';
	var $link_field5 = '';
	var $link_field6 = '';
	var $link_field7 = '';
	var $link_field8 = '';
	var $link_field9 = '';
	var $link_field10 = '';
	var $link_field11 = '';
	var $link_field12 = '';
	var $link_field13 = '';
	var $link_field14 = '';
	var $link_field15 = '';

	function get($url) {
		$url=trim($url);

		if(Validate_URL != false){
			$r = new HTTPRequest($url);
			$xxx = $r->DownloadToString();
		}else{
			$xxx = "";
			$this->valid = true;
			$this->url=$url;
			return;
		}

		if(CHECK_SPAM && $this->check_spam($url))
			   { $this->valid = false; return; }

		if(!($this->html = $xxx)) {
			return;
		}

		if($xxx == "BADURL") {
			$this->valid = false; return;
		}

		$this->valid = true;
		$this->url=$url;
		if(preg_match('/charset=([a-zA-Z0-9-_]+)/i', $this->html, $matches)) {
			$this->encoding=trim($matches[1]);
			//you need iconv to encode to utf-8
			if(function_exists("iconv"))
			{
				if(strcasecmp($this->encoding, 'utf-8') != 0) {
					//convert the html code into utf-8 whatever encoding it is using
					$this->html=iconv($this->encoding, 'UTF-8//IGNORE', $this->html);
				}
			}
		}
		if(preg_match("'<title>([^<]*?)</title>'", $this->html, $matches)) {
			$this->url_title=trim($matches[1]);
		}
		require_once(mnminclude.'blog.php');
		$blog = new Blog();
		$blog->analyze_html($this->url, $this->html);
		if(!$blog->read('key')) {
			$blog->store();
		}
		$this->blog=$blog->id;
		$this->type=$blog->type;

		// Detect trackbacks
		if (!empty($_POST['trackback'])) {
			$this->trackback=trim($_POST['trackback']);
		} elseif (preg_match('/trackback:ping="([^"]+)"/i', $this->html, $matches) ||
			preg_match('/trackback:ping +rdf:resource="([^>]+)"/i', $this->html, $matches) ||
			preg_match('/<trackback:ping>([^<>]+)/i', $this->html, $matches)) {
			$this->trackback=trim($matches[1]);
		} elseif (preg_match('/<a[^>]+rel="trackback"[^>]*>/i', $this->html, $matches)) {
			if (preg_match('/href="([^"]+)"/i', $matches[0], $matches2)) {
				$this->trackback=trim($matches2[1]);
			}
		} elseif (preg_match('/<a[^>]+href=[^>]+>trackback<\/a>/i', $this->html, $matches)) {
			if (preg_match('/href="([^"]+)"/i', $matches[0], $matches2)) {
				$this->trackback=trim($matches2[1]);
			}
		}

	}
	function type() {
		if (empty($this->type)) {
			if ($this->blog > 0) {
				require_once(mnminclude.'blog.php');
				$blog = new Blog();
				$blog->id = $this->blog;
				if($blog->read()) {
					$this->type=$blog->type;
					return $this->type;
				}
			}
			return 'normal';
		}
		return $this->type;
	}

	function store() {
		global $db, $current_user;

		$this->store_basic();
		$link_url = $db->escape($this->url);
		$link_url_title = $db->escape($this->url_title);
		$link_title = $db->escape($this->title);
		$link_title_url = $db->escape($this->title_url);
		if($link_title_url == ""){$link_title_url = makeUrlFriendly($this->title);}
		$link_tags = $db->escape($this->tags);
		$link_content = $db->escape($this->content);
		$link_field1 = $db->escape($this->link_field1);
		$link_field2 = $db->escape($this->link_field2);
		$link_field3 = $db->escape($this->link_field3);
		$link_field4 = $db->escape($this->link_field4);
		$link_field5 = $db->escape($this->link_field5);
		$link_field6 = $db->escape($this->link_field6);
		$link_field7 = $db->escape($this->link_field7);
		$link_field8 = $db->escape($this->link_field8);
		$link_field9 = $db->escape($this->link_field9);
		$link_field10 = $db->escape($this->link_field10);
		$link_field11 = $db->escape($this->link_field11);
		$link_field12 = $db->escape($this->link_field12);
		$link_field13 = $db->escape($this->link_field13);
		$link_field14 = $db->escape($this->link_field14);
		$link_field15 = $db->escape($this->link_field15);
		$link_summary = $db->escape($this->link_summary);
		$db->query("UPDATE " . table_links . " set link_summary='$link_summary', link_title_url='$link_title_url', link_url='$link_url', link_url_title='$link_url_title', link_title='$link_title', link_content='$link_content', link_tags='$link_tags', link_field1='$link_field1', link_field2='$link_field2', link_field3='$link_field3', link_field4='$link_field4', link_field5='$link_field5', link_field6='$link_field6', link_field7='$link_field7', link_field8='$link_field8', link_field9='$link_field9', link_field10='$link_field10', link_field11='$link_field11', link_field12='$link_field12', link_field13='$link_field13', link_field14='$link_field14', link_field15='$link_field15' WHERE link_id=$this->id");

		$pos = strrpos($_SERVER["SCRIPT_NAME"], "/");
		$script_name = substr($_SERVER["SCRIPT_NAME"], $pos + 1, 100);
		$script_name = str_replace(".php", "", $script_name);

		if($this->count_all_votes() != 0 && $script_name != 'submit'){
			// clear the cache for that story that was voted on
			include_once('Smarty.class.php');
			$votesmarty = new Smarty;
			$votesmarty->compile_dir = "templates_c/";
			$votesmarty->template_dir = "templates/";
			$votesmarty->config_dir = "";
			$votesmarty->cache_dir = "templates_c/";
			// enable caching at your own risk. this code is still experimental
			//$votesmarty->cache = true;
			$votesmarty->clear_cache($the_template . '/link_summary.tpl', 'story' . $this->id);
			$votesmarty = "";
		}

	}

	function store_basic() {
		global $db, $current_user;

		if(!$this->date) $this->date=time();
		$link_author = $this->author;
		$link_blog = $this->blog;
		$link_status = $this->status;
		$link_votes = $this->votes;
		$link_karma = $this->karma;
		$link_randkey = $this->randkey;
		$link_category = $this->category;
		$link_date = $this->date;
		$link_published_date = $this->published_date;
		if($this->id===0) {
			$db->query("INSERT INTO " . table_links . " (link_author, link_blog, link_status, link_randkey, link_category, link_date, link_published_date, link_votes, link_karma) VALUES ($link_author, $link_blog, '$link_status', $link_randkey, $link_category, FROM_UNIXTIME($link_date), FROM_UNIXTIME($link_published_date), $link_votes, $link_karma)");
			$this->id = $db->insert_id;
		} else {
		// update
			$db->query("UPDATE " . table_links . " set link_author=$link_author, link_blog=$link_blog, link_status='$link_status', link_randkey=$link_randkey, link_category=$link_category, link_modified=NULL, link_date=FROM_UNIXTIME($link_date), link_published_date=FROM_UNIXTIME($link_published_date), link_votes=$link_votes, link_karma=$link_karma WHERE link_id=$this->id");
		}
	}

	function read() {
		global $db, $current_user;
		$id = $this->id;
		if(($link = $db->get_row("SELECT " . table_links . ".*, " . table_users . ".user_login, " . table_users . ".user_email FROM " . table_links . ", " . table_users . " WHERE link_id = $id AND user_id=link_author"))) {
			$this->author=$link->link_author;
			$this->author_email=$link->user_email;
			$this->username=$link->user_login;
			$this->blog=$link->link_blog;
			$this->status=$link->link_status;
			$this->votes=$link->link_votes;
			$this->randkey=$link->link_randkey;
			$this->category=$link->link_category;
			$this->url= $link->link_url;
			$this->url_title=$link->link_url_title;
			$this->title=$link->link_title;
			$this->title_url=$link->link_title_url;
			$this->tags=$link->link_tags;
			$this->content=$link->link_content;
			$date=$link->link_date;
			$this->date=unixtimestamp($date);
			$date=$link->link_published_date;
			$this->published_date=unixtimestamp($date);
			$date=$link->link_modified;
			$this->modified=unixtimestamp($date);
			$this->fullread = $this->read = true;
			$this->link_summary = $link->link_summary;

			$this->link_field1=$link->link_field1;
			$this->link_field2=$link->link_field2;
			$this->link_field3=$link->link_field3;
			$this->link_field4=$link->link_field4;
			$this->link_field5=$link->link_field5;
			$this->link_field6=$link->link_field6;
			$this->link_field7=$link->link_field7;
			$this->link_field8=$link->link_field8;
			$this->link_field9=$link->link_field9;
			$this->link_field10=$link->link_field10;
			$this->link_field11=$link->link_field11;
			$this->link_field12=$link->link_field12;
			$this->link_field13=$link->link_field13;
			$this->link_field14=$link->link_field14;
			$this->link_field15=$link->link_field15;

			return true;
		}
		$this->fullread = $this->read = false;
		return false;
	}

	function read_basic() {
		global $db, $current_user;
		$this->username = false;
		$this->fullread = false;
		$id = $this->id;
		if(($link = $db->get_row("SELECT link_author, link_blog, link_status, link_randkey, link_category, link_date, link_votes, link_karma, link_published_date FROM " . table_links . " WHERE link_id = $id"))) {
			$this->author=$link->link_author;
			$this->blog=$link->link_blog;
			$this->votes=$link->link_votes;
			$this->karma=$link->link_karma;
			$this->status=$link->link_status;
			$this->randkey=$link->link_randkey;
			$this->category=$link->link_category;
			$date=$link->link_date;
			$this->date=unixtimestamp($date);
			$date=$link->link_published_date;
			$this->published_date=unixtimestamp($date);
			$this->read = true;
			return true;
		}
		$this->read = false;
		return false;
	}

	function duplicates($url) {
		global $db;
		$link_url=$db->escape($url);
		$n = $db->get_var("SELECT count(*) FROM " . table_links . " WHERE link_url = '$link_url' AND link_status != 'discard'");
		return $n;
	}

	function duplicates_title($title) {
		global $db;
		$link_title=$db->escape($title);
		$n = $db->get_var("SELECT count(*) FROM " . table_links . " WHERE link_title = '$link_title' AND link_status != 'discard'");
		return $n;
	}


/**************
	function print_short_summary() {
		if(!$this->read) return;

		echo '<div class="news-short-summary" id="news-'.$this->id.'" style="z-index:1000">';
		echo '<div class="news-body">';
		echo '<h3 id="title'.$this->id.'"><a href="/story/'.$this->id.'/">'.$this->title.'</a></h3>';
		echo '<p class="news-submitted">'.'<b><a href="'.$this->url.'" class="simple tight" title="'.$this->url_title.'">'.$this->url.'</a></b>';
		echo "<br />\n";
		echo _('posted by').' '.$this->username().' '._('hace').txt_time_diff($this->date);
		echo "</p>\n";
		//echo '<p>'.$this->content.'</p>';
		echo '<div class="news-details">';
		echo '<span class="tool">'._('categories').': '.$this->category_name().'</span>';
		echo '</div>'."\n";
		$this->print_shake_box();
		echo '</div></div>'."\n";

	}
****/


	function print_summary($type='full') {
		global $current_user, $globals, $the_template, $smarty;

		include_once('./Smarty.class.php');

		$smarty = new Smarty;
		$smarty->compile_check=false;
		// enable caching at your own risk. this code is still experimental
		//$smarty->cache = true;
		$smarty->cache_lifetime = 120;

		$smarty->cache_dir = "templates_c/";
		$smarty->compile_dir = "templates_c/";
		$smarty->template_dir = "templates/";
		$smarty->config_dir = "";

		if(!$smarty->is_cached($the_template . '/link_summary.tpl', 'story' . $this->id . "|" . $current_user->user_id . "|" . $type)) {
			if(phpnum() == 4) {
				$smarty->force_compile = true;
			}

			$smarty = $this->fill_smarty($smarty, $type);

			$smarty->assign('use_title_as_link', use_title_as_link);
			$smarty->assign('open_in_new_window', open_in_new_window);
			$smarty->assign('use_thumbnails', use_thumbnails);
			$smarty->assign('the_template', The_Template);

			// this is soooo ugly. we'll fix this for beta 9
			$main_smarty = $smarty;
			include mnminclude.'extra_fields_smarty.php';
			$smarty = $main_smarty;

		}
		$smarty->display($the_template . '/link_summary.tpl', 'story' . $this->id . "|" . $current_user->user_id . "|" . $type);
	}

	function fill_smarty($smarty, $type='full'){

		static $link_index=0;
		global $current_user, $globals, $the_template;

		$smarty->assign('link_id', $this->id);
		$smarty->display('blank.tpl'); //this is just to load the lang file so we can pull from it in php

		if(!$this->read) return;

		$url = str_replace('&amp;', '&', htmlspecialchars($this->url));
		$url_short = txt_shorter($url);

		if($this->url == "http://"){
			$url_short = "http://";
		} else {
			$parsed = parse_url($this->url);
			$url_short = $parsed['scheme'] . "://" . $parsed['host'];
		}

		$title_short = htmlspecialchars(utf8_wordwrap($this->title, 30, " ", 1));

		$smarty->assign('viewtype', $type);
		$smarty->assign('URL_tagcloud', getmyurl("tagcloud"));
		$smarty->assign('No_URL_Name', No_URL_Name);
		if(track_outgoing == true){
			if(track_outgoing_method == "id"){$smarty->assign('url', getmyurl("out", $this->id));}
			if(track_outgoing_method == "title"){$smarty->assign('url', getmyurl("outtitle", $this->title_url));}
			if(track_outgoing_method == "url"){$smarty->assign('url', getmyurl("outurl", $url));}
		} else {
			$smarty->assign('url', $url);
		}
		$smarty->assign('enc_url', urlencode($url));
		$smarty->assign('url_short', $url_short);
		$smarty->assign('title_short', $title_short);
		$smarty->assign('title_url', urlencode($this->title_url));
		$smarty->assign('enc_title_short', urlencode($title_short));
		if ($this->title_url == ""){
			$smarty->assign('story_url', getmyurl("story", $this->id)); // internal link to the comments page
		} else {
			$smarty->assign('story_url', getmyurl("storyURL", $this->category_safe_name(), urlencode($this->title_url), $this->id)); // internal link to the comments page
		}

		$smarty->assign('story_edit_url', getmyurl("editlink", $this->id));
		$smarty->assign('story_admin_url', getmyurl("admin_modify", $this->id));
		$smarty->assign('story_comment_count', $this->comments());
		$smarty->assign('story_status', $this->status);
		if($type == "summary"){
			if($this->link_summary == ""){
				$smarty->assign('story_content', $this->truncate_content());
			} else {
				$smarty->assign('story_content', $this->link_summary);
			}
		}
		if($type == "full"){
			$smarty->assign('story_content', $this->content);
		}
		$smarty->assign('link_submitter', $this->username());
		$smarty->assign('submitter_profile_url', getmyurl('user', $this->username()));
		$smarty->assign('link_submit_time', $this->date);
		$smarty->assign('link_submit_timeago', txt_time_diff($this->date));
		$smarty->assign('link_published_time', $this->published_date);
		$smarty->assign('link_published_timeago', txt_time_diff($this->published_date));
		$smarty->assign('link_category', $this->category_name());
		//assign category id to smarty, so we can use it in the templates. Needed for category colors!
		$smarty->assign('category_id', $this->category);

		global $URLMethod;

		{$catvar = $this->category_safe_name();}

		$smarty->assign('Voting_Method', Voting_Method);
		if(Voting_Method == 2)
		{
			$this->rating = $this->rating($this->id)/2;
			$smarty->assign('link_rating', $this->rating);
			$smarty->assign('link_rating_width', $this->rating * 25);

			$js5link = "menealo($current_user->user_id, $this->id, $link_index, " . "'" . md5($current_user->user_id . $this->randkey) . "', 10)";
			$smarty->assign('link_shakebox_javascript_vote_5star', $js5link);

			$js4link = "menealo($current_user->user_id, $this->id, $link_index, " . "'" . md5($current_user->user_id . $this->randkey) . "', 8)";
			$smarty->assign('link_shakebox_javascript_vote_4star', $js4link);

			$js3link = "menealo($current_user->user_id, $this->id, $link_index, " . "'" . md5($current_user->user_id . $this->randkey) . "', 6)";
			$smarty->assign('link_shakebox_javascript_vote_3star', $js3link);

			$js2link = "menealo($current_user->user_id, $this->id, $link_index, " . "'" . md5($current_user->user_id . $this->randkey) . "', 4)";
			$smarty->assign('link_shakebox_javascript_vote_2star', $js2link);

			$js1link = "menealo($current_user->user_id, $this->id, $link_index, " . "'" . md5($current_user->user_id . $this->randkey) . "', 2)";
			$smarty->assign('link_shakebox_javascript_vote_1star', $js1link);

			$this->votecount = $this->countvotes();
			$smarty->assign('vote_count', $this->votecount);

			if($this->votes($current_user->user_id) > 0){
				$smarty->assign('star_class', "-noh");
			} else {
				$smarty->assign('star_class', "");
			}
		}

		if($this->status == "published"){$smarty->assign('category_url', getmyurl("maincategory", $catvar));}
		if($this->status == "queued"){$smarty->assign('category_url', getmyurl("queuedcategory", $catvar));}
		if($this->status == "discard"){$smarty->assign('category_url', getmyurl("discardedcategory", $catvar));}

		$smarty->assign('trackback_url', get_trackback($this->id));
		$smarty->assign('user_logged_in', $current_user->user_login);
		$smarty->assign('randmd5', md5($current_user->user_id.$this->randkey));
		$smarty->assign('user_id', $this->author);
		$smarty->assign('current_user_id', $current_user->user_id);

		if(Enable_Extra_Fields){
			$main_smarty = $smarty; include mnminclude.'extra_fields_smarty.php'; $smarty=$main_smarty;
			$smarty->assign('link_field1', $this->link_field1);
			$smarty->assign('link_field2', $this->link_field2);
			$smarty->assign('link_field3', $this->link_field3);
			$smarty->assign('link_field4', $this->link_field4);
			$smarty->assign('link_field5', $this->link_field5);
			$smarty->assign('link_field6', $this->link_field6);
			$smarty->assign('link_field7', $this->link_field7);
			$smarty->assign('link_field8', $this->link_field8);
			$smarty->assign('link_field9', $this->link_field9);
			$smarty->assign('link_field10', $this->link_field10);
			$smarty->assign('link_field11', $this->link_field11);
			$smarty->assign('link_field12', $this->link_field12);
			$smarty->assign('link_field13', $this->link_field13);
			$smarty->assign('link_field14', $this->link_field14);
			$smarty->assign('link_field15', $this->link_field15);
		}

		$smarty->assign('Enable_Recommend', Enable_Recommend);
		$smarty->assign('Recommend_Type', Recommend_Type);
		$smarty->assign('instpath', my_base_url . my_pligg_base . "/");
		$smarty->assign('UseAvatars', do_we_use_avatars());
		$smarty->assign('Avatar_ImgSrc', get_avatar('large', "", $this->username(), $this->author_email));

		$canIhaveAccess = 0;
		$canIhaveAccess = $canIhaveAccess + checklevel('god');
		$canIhaveAccess = $canIhaveAccess + checklevel('admin');
		if($canIhaveAccess == 1)
			{$smarty->assign('isadmin', 'yes');}


		// For Friends //
			include_once(mnminclude.'friend.php');
			$friend = new Friend;
			// make sure we're logged in and we didnt submit the link.
			if($current_user->user_id > 0 && $current_user->user_login != $this->username()){
				$friend_md5 = friend_MD5($current_user->user_login, $this->username());
				$smarty->assign('FriendMD5', $friend_md5);

				$isfriend = $friend->get_friend_status($this->author);
				if (!$isfriend)	{$friend_text = 'add to';	$friend_url = 'addfriend';}
					else{$friend_text = 'remove from';	$friend_url = 'removefriend';}

				$smarty->assign('Friend_Text', $friend_text);
				$smarty->assign('user_add_remove', getmyurl('user_add_remove', $this->username(), $friend_url));
			}

			$smarty->assign('Allow_Friends', Allow_Friends);
			$smarty->assign('Enable_AddTo', Enable_AddTo);
		// --- //


		$smarty->assign('enable_tags', Enable_Tags);
		$smarty->assign('link_shakebox_index', $link_index);
		$smarty->assign('link_shakebox_votes', $this->votes);
		$smarty->assign('link_shakebox_currentuser_votes', $this->votes($current_user->user_id));
		$smarty->assign('link_shakebox_currentuser_reports', $this->reports($current_user->user_id));
		$jslink = "menealo($current_user->user_id,$this->id,$link_index,"."'".md5($current_user->user_id.$this->randkey)."',10)";
		$smarty->assign('link_shakebox_javascript_vote', $jslink);
		$jslink_negative = "menealo($current_user->user_id,$this->id,$link_index,"."'".md5($current_user->user_id.$this->randkey)."',-10)";
		$smarty->assign('link_shakebox_javascript_vote_negative', $jslink_negative);
		$alltagtext = $smarty->get_config_vars('PLIGG_Visual_Tags_All_Tags');

		if(Enable_Tags){
			$smarty->assign('tags', $this->tags);
			if (!empty($this->tags)) {
				$tags_words = str_replace(",", ", ", $this->tags);
				$tags_count = substr_count($tags_words, ',');
				if ($tags_count > 1){$tags_words = $tags_words;}

				$tag_array = explode(",", $tags_words);
				$c = count($tag_array);
				$tag_array[$c] = $this->tags;
 				$c++;
 				for($i=0; $i<=$c; $i++)
 				{
					if ( $URLMethod == 1 ) {
					    $tags_url_array[$i] = my_pligg_base . "/search.php?search=".urlencode(trim($tag_array[$i]))."&amp;tag=true";
					} elseif ( $URLMethod == 2) {
					    $tags_url_array[$i] = my_pligg_base . "/tag/" . urlencode(trim($tag_array[$i]));
			    }
 				}
 				$tag_array[$c - 1] = $alltagtext;

				$smarty->assign('tag_array', $tag_array);
				$smarty->assign('tags_url_array', $tags_url_array);

				$tags_url = urlencode($this->tags);
				$smarty->assign('tags_count', $tags_count);
				$smarty->assign('tags_words', $tags_words);
				$smarty->assign('tags_url', $tags_url);
			}
		}

		$smarty->assign('pagename', pagename);
		$smarty->assign('my_base_url', my_base_url);
		$smarty->assign('my_pligg_base', my_pligg_base);
		$smarty->assign('Default_Gravatar_Large', Default_Gravatar_Large);

    $smarty->assign('enable_categorycolors', enable_categorycolors); //read enable or disable category colors in config.php
		$link_index++;

		check_actions('lib_link_summary_fill_smarty');

		return $smarty;
	}


	function truncate_content(){
		$TruncatedContent = substr($this->content, 0, StorySummary_ContentTruncate);
		if(strlen($this->content) > StorySummary_ContentTruncate){$TruncatedContent .= "...";}
		return $TruncatedContent;
	}


	function print_shake_box($smarty) {
		global $current_user;

	}


	function rating($linkid)
	{
		require_once(mnminclude.'votes.php');

		$vote = new Vote;
		$vote->type='links';
		$vote->link=$linkid;
		return $vote->rating();
	}

	function countvotes() {
		require_once(mnminclude.'votes.php');

		$vote = new Vote;
		$vote->type='links';
		$vote->link=$this->id;
		return $vote->anycount();
	}

	function count_all_votes() {
		require_once(mnminclude.'votes.php');

		$vote = new Vote;
		$vote->type='links';
		$vote->link=$this->id;
		return $vote->count_all();
	}

	function votes($user) {
		require_once(mnminclude.'votes.php');

		$vote = new Vote;
		$vote->type='links';
		$vote->user=$user;
		$vote->link=$this->id;
		return $vote->anycount();
	}

	function reports($user) {
		require_once(mnminclude.'votes.php');

		$vote = new Vote;
		$vote->type='links';
		$vote->user=$user;
		$vote->link=$this->id;
		return $vote->reports();
	}

	function insert_vote($user=0, $value=10) {
		global $anon_karma;
		require_once(mnminclude.'votes.php');
		if($value>10){$value=10;}
		$vote = new Vote;
		$vote->type='links';
		$vote->user=$user;
		$vote->link=$this->id;
		$vote->value=$value;
		if($value<10) {$vote->value=($anon_karma/10)*$value;}
		if($user>0) {
			require_once(mnminclude.'user.php');
			$dbuser = new User($user);
			if($dbuser->id>0) {
				if($value<10) {$vote->value = ($dbuser->karma/10)*$value;}
			}
		} else if (!anonymous_vote)
			return;
		if($vote->insert()) {
			$vote = new Vote;
			$vote->type='links';
			$vote->link=$this->id;
			if(Voting_Method == 1){$this->votes=$vote->sum();}
			if(Voting_Method == 2){$this->votes=$vote->rating();$this->votecount=$vote->sum();}
			$this->store_basic();
			/*********
			//
			// check karma
			//
			***********/
			$this->check_should_publish();
			return true;
		}
		return false;
	}

	function check_should_publish(){

		if(Voting_Method == 1){
			// check to see if we should change the status to publish
			if($this->status == 'queued' && $this->votes>=votes_to_publish) {
				$now = time();
				$diff=$now-$this->date;
				$days=intval($diff/86400);
				if ($days <=days_to_publish) {
					$this->publish();
				}
			}
		}

		if(Voting_Method == 2){
			if($this->status == 'queued' && $this->votes>=(rating_to_publish * 2) && $this->votecount>=votes_to_publish) {
				$now = time();
				$diff=$now-$this->date;
				$days=intval($diff/86400);
				if ($days <=days_to_publish+1000) {
					$this->publish();
				}
			}
		}
	}

	function category_name() {
		global $db, $dblang;
		return $db->get_var("SELECT category_name FROM " . table_categories . " WHERE category_lang='$dblang' AND category_id=$this->category");
	}

	function category_safe_name() {
		global $db, $dblang;
		return $db->get_var("SELECT category_safe_name FROM " . table_categories . " WHERE category_lang='$dblang' AND category_id=$this->category");
	}

	function publish() {
		if(!$this->read) $this->read_basic();
		$this->published_date = time();
		$this->status = 'published';
		$this->store_basic();
	}

	function username() {
		global $db;
		if (!$this->fullread) {
			$this->username = $db->get_var("SELECT user_login FROM " . table_users . " WHERE user_id = $this->author");
		}
		return $this->username;
	}

	function comments() {
		global $db;
		return $db->get_var("SELECT count(*) FROM " . table_comments . " WHERE comment_link_id = $this->id");
	}

	function check_spam($text )
	{
		global $MAIN_SPAM_RULESET;
		global $USER_SPAM_RULESET;

		$regex_url   = "/(http:\/\/|https:\/\/|ftp:\/\/|www\.)([^\/\"<\s]*)/im";
		$mk_regex_array = array();
		preg_match_all($regex_url, $text, $mk_regex_array);

		for( $cnt=0; $cnt < count($mk_regex_array[2]); $cnt++ )
			{
			$test_domain = rtrim($mk_regex_array[2][$cnt],"\\");
			if (strlen($test_domain) > 3)
				{
				$domain_to_test = $test_domain . ".multi.surbl.org";
				if( strstr(gethostbyname($domain_to_test),'127.0.0'))
					{ logSpam( "surbl rejected $test_domain");  return true; }
				}
			}
		$retVal = $this->check_spam_rules($MAIN_SPAM_RULESET, $text);
		if(!$retVal) { $retVal = $this->check_spam_rules($USER_SPAM_RULESET, $text); }

		return $retVal;
	}

	#####################################
	# check a file of local rules
	# . . the rules are written in a regex format for php
	#     . . or one entry per line eg: bigtimespammer.com on one line
	####################

	function check_spam_rules($ruleFile, $text)
	{
		if(!file_exists( $ruleFile)) { echo $ruleFile . " does not exist\n"; return false; }
		$handle = fopen( $ruleFile, "r");
		while (!feof($handle))
			{
			$buffer = fgets($handle, 4096);
			$splitbuffer = explode("####", $buffer);
			$expression = $splitbuffer[0];
			$explodedSplitBuffer = explode("/", $expression);
			$expression = $explodedSplitBuffer[0];
			if (strlen($expression) > 0)
				{
				if(preg_match("/".trim($expression)."/", $text))
					{ $this->logSpam( "$ruleFile violation: $expression"); return true; }
				}
			}
		fclose($handle);
		return false;
	}

	##############
	## log date, time, IP address and rule which triggered the spam
	##############

	function logSpam($message)
	{
		global $SPAM_LOG_BOOK;

		$ip = "127.0.0.0";
		if(!empty($_SERVER["REMOTE_ADDR"])) { $ip = $_SERVER["REMOTE_ADDR"]; }
		$date = date('M-d-Y');
		$timestamp = time();

		$message = $date . "\t" . $timestamp . "\t" . $ip . "\t" . $message . "\n";

		$file = fopen( $SPAM_LOG_BOOK, "a");
		fwrite( $file, $message );
		fclose($file);
	}

}
class HTTPRequest
{
   var $_fp;        // HTTP socket
   var $_url;        // full URL
   var $_host;        // HTTP host
   var $_protocol;    // protocol (HTTP/HTTPS)
   var $_uri;        // request URI
   var $_port;        // port



   // scan url
   function _scan_url()
   {
       $req = $this->_url;

       $pos = strpos($req, '://');
       $this->_protocol = strtolower(substr($req, 0, $pos));

       $req = substr($req, $pos+3);
       $pos = strpos($req, '/');
       if($pos === false)
           $pos = strlen($req);
       $host = substr($req, 0, $pos);

       if(strpos($host, ':') !== false)
       {
           list($this->_host, $this->_port) = explode(':', $host);
       }
       else
       {
           $this->_host = $host;
           $this->_port = ($this->_protocol == 'https') ? 443 : 80;
       }

       $this->_uri = substr($req, $pos);
       if($this->_uri == '')
           $this->_uri = '/';
   }

   // constructor
   function HTTPRequest($url)
   {
		$this->_url = $url;
		$this->_scan_url();
   }

   // download URL to string
   function DownloadToString()
   {
       $crlf = "\r\n";

       // generate request
       $req = 'GET ' . $this->_uri . ' HTTP/1.0' . $crlf
           .    'Host: ' . $this->_host . $crlf
           .    $crlf;

	error_reporting(E_ERROR);
	// fetch
	$this->_fp = fsockopen(($this->_protocol == 'https' ? 'tls://' : '') . $this->_host, $this->_port, $errno, $errstr, 20);
	if(!$this->_fp)
		{return("BADURL");}
	fwrite($this->_fp, $req);
       while(is_resource($this->_fp) && $this->_fp && !feof($this->_fp))
           $response .= fread($this->_fp, 1024);
       fclose($this->_fp);

       // split header and body
       $pos = strpos($response, $crlf . $crlf);
       if($pos === false)
           return($response);
       $header = substr($response, 0, $pos);
       $body = substr($response, $pos + 2 * strlen($crlf));

       // parse headers
       $headers = array();
       $lines = explode($crlf, $header);
       foreach($lines as $line)
           if(($pos = strpos($line, ':')) !== false)
               $headers[strtolower(trim(substr($line, 0, $pos)))] = trim(substr($line, $pos+1));

       // redirection?
       if(isset($headers['location']))
       {
           $http = new HTTPRequest($headers['location']);
           return($http->DownloadToString($http));
       }
       else
       {
           return($body);
       }
   }
}
