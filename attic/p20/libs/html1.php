<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

function who_voted($storyid, $avatar_size){
	// this returns who voted for a story
	// eventually add support for filters (only show friends, etc)

	global $db;

	$sql = 'SELECT ' . table_votes . '.*, ' . table_users . '.* FROM ' . table_votes . ' INNER JOIN ' . table_users . ' ON ' . table_votes . '.vote_user_id = ' . table_users . '.user_id WHERE (((' . table_votes . '.vote_value)>0) AND ((' . table_votes . '.vote_link_id)='.$storyid.') AND (' . table_votes . '.vote_type= "links"));';
	$voters = mysql_query($sql);
	$voter = array();
	while ($rows = mysql_fetch_array ($voters, MYSQL_ASSOC)) array_push ($voter, $rows);
	foreach($voter as $key => $val){
	 $voter[$key]['Avatar_ImgSrc'] = get_avatar($avatar_size, "", $val['user_login'], $val['user_email']);
		//foreach($val as $key => $val2){
		//	 echo $key . ' : ' . $val2 . "<br>";
		//}
	}

	return $voter;
}

function sanitize($var, $santype = 1){
	if ($santype == 1) {return strip_tags($var);}
	if ($santype == 2) {return htmlentities(strip_tags($var),ENT_QUOTES,'UTF-8');}
	if ($santype == 3)
	{
		if (!get_magic_quotes_gpc()) {
		   //return addslashes(htmlentities(strip_tags($var)));
       return addslashes(htmlentities(strip_tags($var),ENT_QUOTES,'UTF-8'));
		} else {
		   return htmlentities(strip_tags($var),ENT_QUOTES,'UTF-8');
		}
	}
}

function do_we_use_avatars(){
	if(Enable_User_Upload_Avatar == true){return "1";}
	return "0";
}

function get_avatar($size = "large", $avatarsource, $user_name = "", $user_email = ""){
	global $globals;

	if($avatarsource == ""){
		include_once(mnminclude.'user.php');
		$user=new User();
		$user->username = $user_name;
		if(!$user->read()) {
			echo "invalid username in get_avatar";
			die;
		}	else {
			$avatarsource = $user->avatar_source;
			if(isset($user->login)){$user_email = $user->login;}
		}
		$user = "";
	}

	if($size == "large"){$imgsize = Avatar_Large;}else{$imgsize = Avatar_Small;}

	// use the user uploaded avatars ?
	if(Enable_User_Upload_Avatar == true && $avatarsource == "useruploaded"){
		$imgsrc = my_pligg_base . User_Upload_Avatar_Folder . "/" . $user_name . "_" . $imgsize . ".jpg";
		return $imgsrc;
	}


	if($size == "large"){return my_base_url . my_pligg_base . Default_Gravatar_Large;}
	if($size == "small"){return my_base_url . my_pligg_base . Default_Gravatar_Small;}
}


function do_header_ad($var_smarty) {
	$var_smarty->display('all_header_ad.tpl');
}

function do_header($title, $id='home', $var_smarty) {
	global $current_user, $dblang;

	$var_smarty->assign('header_id', $id);
	$var_smarty->assign('title', $title);
	if(isset($_REQUEST['search'])){$var_smarty->assign('searchedfor', $_REQUEST['search']);}

	$canIhaveAccess = 0;
	$canIhaveAccess = $canIhaveAccess + checklevel('god');
	if($canIhaveAccess == 1){$var_smarty->assign('isgod', 1);}
	$canIhaveAccess = $canIhaveAccess + checklevel('admin');
	if($canIhaveAccess == 1){$var_smarty->assign('isadmin', 1);}

	$var_smarty->display('all_header.tpl');
}

function do_footer($var_smarty) {
	$var_smarty->display('all_footer.tpl');
}

function do_sidebar($var_smarty) {
	global $db, $dblang, $globals;

	$_caching = $var_smarty->cache; 	// get the current cache settings
	$var_smarty->cache = true; 			// cache has to be on otherwise is_cached will always be false
	$var_smarty->cache_lifetime = -1;   // lifetime has to be set to something otherwise is_cached will always be false
	$thetpl = $var_smarty->get_template_vars('the_template_sidebar_modules') . '/categories.tpl';

	// check to see if the category sidebar module is already cached
	// if it is, use it

	if(isset($_REQUEST['category'])){
		$thecat = $_REQUEST['category'];
	}else{
		$thecat = '';
	}
	if ($var_smarty->is_cached($thetpl, 'sidebar|category|'.$thecat)) {
		$var_smarty->assign('cat_array', 'x'); // this is needed. sidebar.tpl won't include the category module if cat_array doesnt have some data
	}else{
		if(isset($_REQUEST['category'])){$thecat = $db->get_var("SELECT category_name FROM " . table_categories . " WHERE `category_safe_name` = '".$_REQUEST['category']."';");}

		if(!empty($_REQUEST['id'])) {
			$doing_story=true;
		} else {
			$doing_story=false;
		}

		$var_smarty->assign('UrlMethod', urlmethod);
		$categories = $db->get_results("SELECT category_id, category_name FROM " . table_categories . " WHERE category_lang='$dblang' and category_parent = 0 ORDER BY category_name ASC");
		foreach ($categories as $category) {
			if(isset($thecat)){
				if($category->category_id == $thecat) {
					$globals['category_id'] = $category->category_id;
					$globals['category_name'] = $category->category_name;
				}
			}
		}

		$pos = strrpos($_SERVER["SCRIPT_NAME"], "/");
		$script_name = substr($_SERVER["SCRIPT_NAME"], $pos + 1, 100);
		$script_name = str_replace(".php", "", $script_name);

		if($script_name != 'submit'){
			include_once('dbtree.php');
			$array = tree_to_array(0, table_categories);
			$var_smarty->assign('lastspacer', 0);
			$var_smarty->assign('cat_array', $array);
		}


		$published_count = $db->get_var("SELECT count(*) FROM " . table_links . " WHERE link_status = 'published'");
		$var_smarty->assign('published_count', $published_count);
		$categories = mysql_query("select *,  count(*) as count from " . table_links . ", " . table_categories . " where category_lang='$dblang' and category_id=link_category group by link_category ORDER BY category_name ASC");

		$categorylist = array();
		while ($rows = mysql_fetch_array ($categories, MYSQL_ASSOC)) array_push ($categorylist, $rows);
		$var_smarty->assign('categorylist', $categorylist);
		$var_smarty->assign('category_url', getmyurl('maincategory'));

	}

	$var_smarty->cache = $_caching; // set cache back to original value

	check_actions('do_sidebar');

	return $var_smarty;
}


function do_rss_box() {
	global $globals;

 //			{include file='all_rss_box.tpl'}

}

function force_authentication() {
	global $current_user;

	if(!$current_user->authenticated) {
		//echo '<div class="instruction"><h2>'._('ERROR: you must login').'. <a href="login.php">'._('Login').'</a>.</h2></div>'."\n";
		header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
		die;
	}
	return true;
}

function print_form_error($mess) {
	echo '<div class="form-error">&nbsp;&nbsp;'._($mess).'</div>'."\n";
}

function do_pages($total, $page_size, $thepage) {
	global $db;
	global $URLMethod;      // added to define URL Method //

	$index_limit = 10;

	$current = get_current_page();
	$total_pages=ceil($total/$page_size);
	$start=max($current-intval($index_limit/2), 1);
	$end=$start+$index_limit-1;


	if ($URLMethod == 1)	{

	$query=preg_replace('/page=[0-9]+/', '', $_SERVER['QUERY_STRING']);
	$query=preg_replace('/^&*(.*)&*$/', "$1", $query);
	if(!empty($query)) $query = "&amp;$query";

	echo '<div class="pagers">';
	echo '<div class="pbg">';
	echo '<div class="list">';
	echo '<ul>';

	if($current==1) {
		echo '<li class="prev"><span>&nbsp;</span></li>';
	} else {
		$i = $current-1;
		echo '<li class="prev"><a href="?page='.$i.$query.'">'._(PLIGG_Visual_Page_Previous).'</a></li>';
	}

	if($start>1) {
		$i = 1;
		echo '<li><a href="?page='.$i.$query.'">'.$i.'</a></li>';
	}
	for ($i=$start;$i<=$end && $i<= $total_pages;$i++) {
		if($i==$current) {
			echo '<li><a href="?page='.$i.$query.'">'.$i.'</a></li>'; //!!!!!
		} else {
			echo '<li><a href="?page='.$i.$query.'">'.$i.'</a></li>';
		}
	}
	if($total_pages>$end) {
		$i = $total_pages;
		echo '<li><a href="?page='.$i.$query.'">'.$i.'</a></li>';
	}
	if($current<$total_pages) {
		$i = $current+1;
		echo '<li class="next"><a href="?page='.$i.$query.'"> '._(PLIGG_Visual_Page_Next). '</a></li>';
	} else {
		echo '<li class="next"><span>&nbsp;</span></li>';
	}
	echo '</ul>';
	echo '</div>';
	echo '</div>';
	echo '</div>';
	}
	if ($URLMethod == 2)	{

	$query=preg_replace('(login=)', '/', $_SERVER['QUERY_STRING']);	//remove login= from query string //
	$query=preg_replace('(view=)', '', $query);	                    //remove view= from query string //
	$query=preg_replace('(part=)', '', $query);
	$query=preg_replace('(order)', '', $query);
	$query=preg_replace('/page=[0-9]+/', '', $query);  				//remove page arguments to because its hardcoded in html   //
	$query=preg_replace('/tag=true/', '', $query);  				//remove tag=true in tag query because its handled in .htaccess and hidden for a cleaner look//
	$query=preg_replace('/(.*)=(.*)/', '$1/$2', $query); 	 		//main line to recompose arg to place in url //
	$query=preg_replace('/&/', '', $query);							//whack any ampersands	//


	echo '<div class="pagination"><p>';

	if($current==1) {
		echo '<span>&#171; '._(PLIGG_Visual_Page_Previous). '</span>';
	} else {
		$i = $current-1;
		if ($thepage == "upcoming") {
			echo '<a href="'.my_pligg_base.'/page/upcoming/'.$i.'/'.$query.'">&#171; '._(PLIGG_Visual_Page_Previous).'</a>'; }
		elseif ($thepage == "topusers") {
			echo '<a href="'.my_pligg_base.'/topusers/page/'.$i.'/'.$query.'">&#171; '._(PLIGG_Visual_Page_Previous).'</a>'; }
		elseif ($thepage == "comments") {
			echo '<a href="'.my_pligg_base.'/comments/page/'.$i.'/'.$query.'">&#171; '._(PLIGG_Visual_Page_Previous).'</a>'; }
		elseif ($thepage == "published") {
			echo '<a href="'.my_pligg_base.'/published/page/'.$i.'/'.$query.'">&#171; '._(PLIGG_Visual_Page_Previous).'</a>'; }
		elseif ($thepage == "unpublished") {
			echo '<a href="'.my_pligg_base.'/unpublished/page/'.$i.'/'.$query.'">&#171; '._(PLIGG_Visual_Page_Previous).'</a>'; }
		else {
			echo '<a href="'.my_pligg_base.'/page/'.$i.'/'.$query.'">&#171; '._(PLIGG_Visual_Page_Previous).'</a>'; }
	}

	if($start>1) {
		$i = 1;
		if ($thepage == "upcoming") {
			echo '<a href="'.my_pligg_base.'/page/upcoming/'.$i.'/'.$query.'">'.$i.'</a>'; }
		elseif ($thepage == "topusers") {
			echo '<a href="'.my_pligg_base.'/topusers/page/'.$i.'/'.$query.'">'.$i.'</a>'; }
		elseif ($thepage == "comments") {
			echo '<a href="'.my_pligg_base.'/comments/page/'.$i.'/'.$query.'">'.$i.'</a>'; }
		elseif ($thepage == "published") {
			echo '<a href="'.my_pligg_base.'/published/page/'.$i.'/'.$query.'">'.$i.'</a>'; }
		elseif ($thepage == "unpublished") {
			echo '<a href="'.my_pligg_base.'/unpublished/page/'.$i.'/'.$query.'">'.$i.'</a>'; }
		else {
			echo '<a href="'.my_pligg_base.'/page/'.$i.'/'.$query.'">'.$i.'</a>'; }
		echo '<span>...</span>';
	}
	for ($i=$start;$i<=$end && $i<= $total_pages;$i++) {
		if($i==$current) {
			echo '<span class="current">'.$i.'</span>';
		} else {
		    if ($thepage == "upcoming") {
				echo '<a href="'.my_pligg_base.'/page/upcoming/'.$i.'/'.$query.'">'.$i.'</a>'; }
			elseif ($thepage == "topusers") {
				echo '<a href="'.my_pligg_base.'/topusers/page/'.$i.'/'.$query.'">'.$i.'</a>'; }
			elseif ($thepage == "comments") {
				echo '<a href="'.my_pligg_base.'/comments/page/'.$i.'/'.$query.'">'.$i.'</a>'; }
			elseif ($thepage == "published") {
				echo '<a href="'.my_pligg_base.'/published/page/'.$i.'/'.$query.'">'.$i.'</a>'; }
			elseif ($thepage == "unpublished") {
				echo '<a href="'.my_pligg_base.'/unpublished/page/'.$i.'/'.$query.'">'.$i.'</a>'; }
			else {
				echo '<a href="'.my_pligg_base.'/page/'.$i.'/'.$query.'">'.$i.'</a>'; }
		}
	}
	if($total_pages>$end) {
		$i = $total_pages;
		echo '<span>...</span>';
		echo '<a href="'.my_pligg_base.'/page/'.$i.'/'.$query.'">'.$i.'</a>';
	}
	if($current<$total_pages) {
		$i = $current+1;
		if ($thepage == "upcoming") {
			echo '<a href="'.my_pligg_base.'/page/upcoming/'.$i.'/'.$query.'"> '._(PLIGG_Visual_Page_Next). ' &#187;' . '</a>'; }
		elseif ($thepage == "topusers") {
			echo '<a href="'.my_pligg_base.'/topusers/page/'.$i.'/'.$query.'"> '._(PLIGG_Visual_Page_Next). ' &#187;' . '</a>'; }
		elseif ($thepage == "comments") {
			echo '<a href="'.my_pligg_base.'/comments/page/'.$i.'/'.$query.'"> '._(PLIGG_Visual_Page_Next). ' &#187;' . '</a>'; }
		elseif ($thepage == "published") {
			echo '<a href="'.my_pligg_base.'/published/page/'.$i.'/'.$query.'"> '._(PLIGG_Visual_Page_Next). ' &#187;' . '</a>'; }
		elseif ($thepage == "unpublished") {
			echo '<a href="'.my_pligg_base.'/unpublished/page/'.$i.'/'.$query.'"> '._(PLIGG_Visual_Page_Next). ' &#187;' . '</a>'; }
		else {
			echo '<a href="'.my_pligg_base.'/page/'.$i.'/'.$query.'"> '._(PLIGG_Visual_Page_Next). ' &#187;' . '</a>'; }
	}
	else {
		echo '<span> '._(PLIGG_Visual_Page_Next). ' &#187;' . '</span>';
	}
	echo "</div>\n";
	}

}

function do_trackbacks() {
	global $db;

	$id = $_REQUEST['id'];
	echo '<div id="blogged" style="z-index: 10;">';
	echo '<h2>'.PLIGG_Visual_Trackback.'</h2>';
	$trackbacks = $db->get_col("SELECT trackback_id FROM " . table_trackbacks . " WHERE trackback_link_id=$id AND trackback_type='in' ORDER BY trackback_date DESC");
	if ($trackbacks) {
		echo '<ul>';
		require_once(mnminclude.'trackback.php');
		$trackback = new Trackback;
		foreach($trackbacks as $trackback_id) {
			$trackback->id=$trackback_id;
			$trackback->read();
			echo '<li><a href="'.$trackback->url.'" title="'.htmlspecialchars($trackback->content).'">'.$trackback->title.'</a></li>';
		}
		echo "</ul>\n";
	}
	echo '<br /></div>';

}

function generateHash($plainText, $salt = null)
{
    if ($salt === null)
    {
        $salt = substr(md5(uniqid(rand(), true)), 0, SALT_LENGTH);
    }
    else
    {
        $salt = substr($salt, 0, SALT_LENGTH);
    }

    return $salt . sha1($salt . $plainText);
}

function CheckPasswordStrength($password)
{

    $strength = 0;
    $patterns = array('#[a-z]#','#[A-Z]#','#[0-9]#','/[�!"�$%^&*()`{}\[\]:@~;\'#<>?,.\/\\-=_+\|]/');
    foreach($patterns as $pattern)
    {
        if(preg_match($pattern,$password,$matches))
        {
            $strength++;
        }
    }
    return $strength;

    // 1 - weak
    // 2 - not weak
    // 3 - acceptable
    // 4 - strong
}

function getmyFullurl($x, $var1="", $var2="", $var3="")
{
	return my_base_url . getmyurl($x, $var1, $var2, $var3);
}

function getmyurl($x, $var1="", $var2="", $var3="")
{
	global $URLMethod;

	If ($x == "storyURL") {
		// var 1 = category_safe_name
		// var 2 = title_url
		// var 3 = story id
		if(enable_friendly_urls == true){
		    if(enable_friendly_caturls == true){
					return getmyurl("storycattitle", $var1, $var2);
		    } else {
					return getmyurl("storytitle", $var2);
		    }
		} else {
			return getmyurl("story", $var3);
		}
	}


	if ($URLMethod == 1)
	{
		If ($x == "maincategory") {return my_pligg_base."/index.php?category=" . $var1;}
		If ($x == "queuedcategory") {return my_pligg_base."/upcoming.php?category=" . $var1;}
		If ($x == "discardedcategory") {return my_pligg_base."/discarded.php?category=" . $var1;}
		If ($x == "editlink") {return my_pligg_base."/editlink.php?id=" . $var1;}
		If ($x == "edit") {return my_pligg_base."/edit.php?id=" . $var1 . "&amp;commentid=" . $var2;}
		If ($x == "user") {return my_pligg_base."/user.php?login=" . $var1;}
		If ($x == "user_inbox") {return my_pligg_base."/user.php?view=" . $var1;}
		If ($x == "user_add_remove") {return my_pligg_base."/user.php?login=" . $var1. "&amp;view=" . $var2;}
		If ($x == "user_friends") {return my_pligg_base."/user.php?login=" . $var1. "&amp;view=" . $var2;}
		If ($x == "index_sort") {return my_pligg_base."/index.php?part=".$var1.$var2;}
		If ($x == "userblank") {return my_pligg_base."/user.php?login=";}
		If ($x == "user2") {return my_pligg_base."/user.php?login=".$var1."&amp;view=".$var2;}
		If ($x == "search") {return my_pligg_base."/search.php?search=" . $var1;}
		If ($x == "login") {return my_pligg_base."/login.php?return=" . $var1;}
		If ($x == "logout") {return my_pligg_base."/login.php?op=logout&amp;return=" . $var1;}
		If ($x == "register") {return my_pligg_base."/register.php";}
		If ($x == "category") {return my_pligg_base."/index.php?category=" . $var1;}
		If ($x == "submit") {return my_pligg_base."/submit.php";}
		If ($x == "story") {return my_pligg_base."/story.php?id=" . $var1;}
		If ($x == "storytitle") {return my_pligg_base."/story.php?title=" . $var1;}
		If ($x == "storycattitle") {return my_pligg_base."/story.php?title=" . $var2;}
		If ($x == "out") {return my_pligg_base."/out.php?id=" . $var1;}
		If ($x == "outtitle") {return my_pligg_base."/out.php?title=" . $var1;}
		If ($x == "outurl") {return my_pligg_base."/out.php?url=" . rawurlencode($var1);}
		If ($x == "root") {return my_pligg_base."/index.php";}
		If ($x == "upcoming") {return my_pligg_base."/upcoming.php";}
		If ($x == "upcoming_sort") {return my_pligg_base."/upcoming.php?part=".$var1."&amp;order=".$var2.$var3;}
		If ($x == "discarded") {return my_pligg_base."/discarded.php";}
		If ($x == "topusers") {return my_pligg_base."/topusers.php";}
		If ($x == "profile") {return my_pligg_base."/profile.php";}
		If ($x == "userNoVar") {return my_pligg_base."/user.php";}
		If ($x == "loginNoVar") {return my_pligg_base."/login.php";}
		If ($x == "rssTime") {return my_pligg_base."/rss2.php?time=" . $var1;}
		If ($x == "about") {return my_pligg_base."/faq-".$var1.".php";}
		If ($x == "bugreport") {return my_pligg_base."/bugreport.php";}
		If ($x == "rss2") {return my_pligg_base."/rss2.php";}
		If ($x == "rss2queued") {return my_pligg_base."/rss2.php?status=queued";}
		If ($x == "rss2all") {return my_pligg_base."/rss2.php?status=all";}
		If ($x == "rss2category") {return my_pligg_base."/rss2.php?category=". $var1;}
		If ($x == "rss2search") {return my_pligg_base."/rss2.php?search=". $var1;}
		If ($x == "rss2user") {return my_pligg_base."/userrss2.php?user=". $var1. "&amp;status=" . $var2;}
		If ($x == "trackback") {return my_pligg_base."/trackback.php?id=" . $var1;}
		If ($x == "page") {return my_pligg_base."/?page=";}
		If ($x == "upcoming_cat") {return my_pligg_base."/?category=";}
		If ($x == "discarded_cat") {return my_pligg_base."/?category=";}
		If ($x == "admin") {return my_pligg_base."/admin_index.php";}
		If ($x == "admin_users") {return my_pligg_base."/admin_users.php";}
		If ($x == "admin_language") {return my_pligg_base."/module.php?module=admin_language";}
		If ($x == "admin_categories") {return my_pligg_base."/admin_categories.php";}
		If ($x == "admin_backup") {return my_pligg_base."/admin_backup.php";}
		If ($x == "admin_modules") {return my_pligg_base."/modules/modules_manage.php";}
		If ($x == "admin_config") {return my_pligg_base."/admin_config.php";}
		If ($x == "admin_rss") {return my_pligg_base."/rss/rss_main.php";}
		If ($x == "admin_modify") {return my_pligg_base."/linkadmin.php?id=" . $var1 . "&amp;action=main";}
		If ($x == "admin_modify_do") {return my_pligg_base."/linkadmin.php?id=" . $var1 . "&amp;action=do" . $var2;}
		If ($x == "admin_modify_edo") {return my_pligg_base."/linkadmin.php?id=" . $var1 . "&amp;action=edo" . $var2;}
		If ($x == "admin_discard") {return my_pligg_base."/linkadmin.php?id=" . $var1 . "&amp;action=discard";}
		If ($x == "admin_queued") {return my_pligg_base."/linkadmin.php?id=" . $var1 . "&amp;action=queued";}
		If ($x == "admin_published") {return my_pligg_base."/linkadmin.php?id=" . $var1 . "&amp;action=published";}
		If ($x == "editcomment") {return my_pligg_base."/edit.php?id=" . $var2 . "&amp;commentid=" . $var1;}
		If ($x == "tagcloud") {return my_pligg_base."/cloud.php";}
		If ($x == "tagcloud_range") {return my_pligg_base."/cloud.php?range=" . $var1;}
		If ($x == "comments") {return my_pligg_base."/comments.php";}
		If ($x == "published") {return my_pligg_base."/published.php";}
		If ($x == "unpublished") {return my_pligg_base."/unpublished.php";}
		If ($x == "tag") {return my_pligg_base."/search.php?search=" . $var1 . "&amp;tag=true";}
		If ($x == "tag2") {return my_pligg_base."/search.php?search=" . $var1 . "&amp;tag=true&amp;from=" . $var2;}
		If ($x == "live") {return my_pligg_base."/live.php";}
		If ($x == "template") {return my_pligg_base."/settemplate.php";}
		If ($x == "settemplate") {return my_pligg_base."/settemplate.php?template=" .$var1;}
	}
	if ($URLMethod == 2)
	{
		If ($x == "maincategory") {return my_pligg_base."/category/" . $var1;}
		If ($x == "queuedcategory") {return my_pligg_base."/queued/category/" . $var1;}
		If ($x == "discardedcategory") {return my_pligg_base."/discarded/category/" . $var1;}
		If ($x == "editlink") {return my_pligg_base."/story/" . $var1 . "/edit/";}
		If ($x == "edit") {return my_pligg_base."/story/" . $var1 . "/editcomment/" . $var2;}
		If ($x == "user") {return my_pligg_base."/user/view/profile/" . $var1;}
		If ($x == "user_friends") {return my_pligg_base."/user/view/" . $var2;}
		If ($x == "user_add_remove") {return my_pligg_base."/user/view/" . $var2. "/login/" . $var1;}
		If ($x == "user_inbox") {return my_pligg_base."/inbox";}
		If ($x == "userblank") {return my_pligg_base."/user/";}
		If ($x == "user2") {return my_pligg_base."/user/view/" . $var2 . "/login/" . $var1 . "/";}
		If ($x == "index") {return my_pligg_base."/index/";}
		If ($x == "index_sort") {return my_pligg_base."/index/" . $var1 . "/".$var2;}
		If ($x == "search") {return my_pligg_base."/search/" . $var1;}
		If ($x == "login") {return my_pligg_base."/login.php?return=" . $var1;}
		If ($x == "logout") {return my_pligg_base."/login.php?op=logout&amp;return=" . $var1;}
		If ($x == "register") {return my_pligg_base."/register";}
		If ($x == "submit") {return my_pligg_base."/submit";}
		If ($x == "story") {return my_pligg_base."/story/" . $var1 . "/";}
		If ($x == "storytitle") {return my_pligg_base."/story/title" . $var1 . "/";}
		If ($x == "storycattitle") {return my_pligg_base."/" . $var1 . "/" . $var2 ."/";}
		If ($x == "out") {return my_pligg_base."/out/" . $var1 . "/";}
		If ($x == "outtitle") {return my_pligg_base."/out/" . $var1 . "/";}
		If ($x == "root") {return my_pligg_base."/";}
		If ($x == "upcoming") {return my_pligg_base."/upcoming";}
		If ($x == "upcoming_sort") {return my_pligg_base."/upcoming/" . $var1 . "/" .$var2."/".$var3;}
		If ($x == "discarded") {return my_pligg_base."/discarded/";}
		If ($x == "topusers") {return my_pligg_base."/topusers";}
		If ($x == "profile") {return my_pligg_base."/profile";}
		If ($x == "userNoVar") {return my_pligg_base."/user";}
		If ($x == "loginNoVar") {return my_pligg_base."/login";}
		If ($x == "rssTime") {return my_pligg_base."/rss2.php?time=" . $var1;}
		If ($x == "about") {return my_pligg_base."/about/".$var1;}
		If ($x == "rss2") {return my_pligg_base."/rss2/";}
		If ($x == "rss2user") {return my_pligg_base."/rss2/user/" . $var1 . "/";}
		If ($x == "rss2queued") {return my_pligg_base."/rss2/" . $var1 . "/";}
		If ($x == "rss2all") {return my_pligg_base."/rss2/" . $var1 . "/";}
		If ($x == "rss2category") {return my_pligg_base."/rss2/category" . $var1 . "/";}
		If ($x == "rss2search") {return my_pligg_base."/rss2/search" . $var1 . "/";}
		If ($x == "trackback") {return my_pligg_base."/trackback/" . $var1 . "/";}
		If ($x == "page") {return my_pligg_base."?page=";}
		//admin functions
		If ($x == "admin") {return my_pligg_base."/admin";}
		If ($x == "admin_users") {return my_pligg_base."/admin_users.php";}
		If ($x == "admin_language") {return my_pligg_base."/module.php?module=admin_language";}
		If ($x == "admin_categories") {return my_pligg_base."/admin_categories.php";}
		If ($x == "admin_backup") {return my_pligg_base."/admin_backup.php";}
		If ($x == "admin_modules") {return my_pligg_base."/modules/modules_manage.php";}
		If ($x == "admin_config") {return my_pligg_base."/admin_config.php";}
		If ($x == "admin_rss") {return my_pligg_base."/rss/rss_main.php";}
		If ($x == "admin_modify") {return my_pligg_base."/story/" . $var1 . "/modify/main/";}
		If ($x == "admin_modify_do") {return my_pligg_base."/story/" . $var1 . "/modify/do" . $var2 . "/";}
		If ($x == "admin_modify_edo") {return my_pligg_base."/story/" . $var1 . "/modify/edo" . $var2 . "/";}
		If ($x == "admin_discard") {return my_pligg_base."/story/" . $var1 . "/modify/discard/";}
		If ($x == "admin_queued") {return my_pligg_base."/story/" . $var1 . "/modify/queued/";}
		If ($x == "admin_published") {return my_pligg_base."/story/" . $var1 . "/modify/published/";}
		If ($x == "editcomment") {return my_pligg_base."/story/" . $var2 . "/editcomment/" . $var1;} //leave the . in "./editcomment" because full url should be /story/15/editcomment/2
		If ($x == "tagcloud") {return my_pligg_base."/tagcloud";}
		If ($x == "tagcloud_range") {return my_pligg_base."/tagcloud/range/" . $var1;}
		If ($x == "comments") {return my_pligg_base."/comments";}
		If ($x == "published") {return my_pligg_base."/published";}
		If ($x == "unpublished") {return my_pligg_base."/unpublished";}
		If ($x == "tag") {return my_pligg_base."/tag/" . $var1;}
		If ($x == "tag2") {return my_pligg_base."/tag/" . $var1 . "/" . $var2 . "/";}
		If ($x == "live") {return my_pligg_base."/live";}
		If ($x == "template") {return my_pligg_base."/settemplate";}
		If ($x == "settemplate") {return my_pligg_base."/settemplate/" .$var1;}
	}
}

function SetSmartyURLs($main_smarty)
{
	global $dblang;
	if(strpos($_SERVER['PHP_SELF'], "login.php") === false){
		$main_smarty->assign('URL_login', getmyurl("login", $_SERVER['REQUEST_URI']));
	} else{
		$main_smarty->assign('URL_login', getmyurl("loginNoVar"));
	}
	$main_smarty->assign('URL_logout', getmyurl("logout", $_SERVER['REQUEST_URI']));
	$main_smarty->assign('URL_register', getmyurl("register"));
	$main_smarty->assign('URL_root', getmyurl("root"));
	$main_smarty->assign('URL_index', getmyurl("index"));
	$main_smarty->assign('URL_search', getmyurl("search"));
	$main_smarty->assign('URL_maincategory', getmyurl("maincategory"));
	$main_smarty->assign('URL_queuedcategory', getmyurl("queuedcategory"));
	$main_smarty->assign('URL_category', getmyurl("category"));
	$main_smarty->assign('URL_user', getmyurl("user"));
	$main_smarty->assign('URL_userNoVar', getmyurl("userNoVar"));
	$main_smarty->assign('URL_user_inbox', getmyurl("user_inbox", "inbox"));
	$main_smarty->assign('URL_user_add_remove', getmyurl("user_add_remove"));
	$main_smarty->assign('URL_profile', getmyurl("profile"));
	$main_smarty->assign('URL_story', getmyurl("story"));
	$main_smarty->assign('URL_storytitle', getmyurl("storytitle"));
	$main_smarty->assign('URL_topusers', getmyurl("topusers"));
	$main_smarty->assign('URL_about', getmyurl("about", $dblang));
	$main_smarty->assign('URL_upcoming', getmyurl("upcoming"));
	$main_smarty->assign('URL_submit', getmyurl("submit"));
	$main_smarty->assign('URL_rss2', getmyurl("rss2"));
	$main_smarty->assign('URL_rss2category', getmyurl("rss2category"));
	$main_smarty->assign('URL_rss2queued', getmyurl("rss2queued", "queued"));
	$main_smarty->assign('URL_rss2all', getmyurl("rss2all", "all"));
	$main_smarty->assign('URL_rss2search', getmyurl("rss2search"));
	$main_smarty->assign('URL_admin', getmyurl("admin"));
	$main_smarty->assign('URL_admin_users', getmyurl("admin_users"));
	$main_smarty->assign('URL_admin_language', getmyurl("admin_language"));
	$main_smarty->assign('URL_admin_categories', getmyurl("admin_categories"));
	$main_smarty->assign('URL_admin_backup', getmyurl("admin_backup"));
	$main_smarty->assign('URL_admin_modules', getmyurl("admin_modules"));
	$main_smarty->assign('URL_admin_config', getmyurl("admin_config"));
	$main_smarty->assign('URL_admin_rss', getmyurl("admin_rss"));
	$main_smarty->assign('URL_tagcloud', getmyurl("tagcloud"));
	$main_smarty->assign('URL_tagcloud_range', getmyurl("tagcloud_range"));
	$main_smarty->assign('URL_live', getmyurl("live"));
	$main_smarty->assign('URL_unpublished', getmyurl("unpublished"));
	$main_smarty->assign('URL_published', getmyurl("published"));
	$main_smarty->assign('URL_comments', getmyurl("comments"));
	$main_smarty->assign('URL_template', getmyurl("template"));
	$main_smarty->assign('URL_settemplate', getmyurl("settemplate"));
	return $main_smarty;
}


function friend_MD5($userA, $userB)
{
	include_once(mnminclude.'user.php');
	$user=new User();
	$user->username = $userA;
	if(!$user->read()) {
		echo "a-" . $userA . "error 2";
		die;
	}
	$userAdata = $user->username . $user->date;

	$user=new User();
	$user->username = $userB;
	if(!$user->read()) {
		echo "b-" . $userB . "error 2";
		die;
	}
	$userBdata = $user->username . $user->date;

	$themd5 = md5($userAdata . $userBdata);
	return $themd5;
}

?>