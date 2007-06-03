<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

include_once('Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'user.php');
include(mnminclude.'friend.php');
include(mnminclude.'smartyvariables.php');
include(mnminclude.'pageview.php');


$offset=(get_current_page()-1)*$page_size;
$main_smarty = do_sidebar($main_smarty);

define('pagename', 'user'); 
$main_smarty->assign('pagename', pagename);


// if not logged in, redirect to the index page
	if(isset($_REQUEST['login'])){$login = $_REQUEST['login'];}
	if(empty($login)){
		if ($current_user->user_id > 0) {
			$login=$current_user->user_login;
		} else {
			header('Location: ./');
			die;
		}
	}

// setup the breadcrumbs
	$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Profile');
	$navwhere['link1'] = getmyurl('user2', $login, 'profile');
	$navwhere['text2'] = $login;
	$navwhere['link2'] = getmyurl('user2', $login, 'profile');

// read the users information from the database
	$user=new User();
	$user->username = $login;
	if(!$user->read()) {
		echo "error 2";
		die;
	}

// find out who last viewed this users profile
	$pageview = new Pageview;
	
// insert a pageview for the current viewer
		$pageview->type='profile'; 	 
		$pageview->page_id=$user->id; 	 
		$pageview->user_id=$current_user->user_id; 	 
		require_once(mnminclude.'check_behind_proxy.php'); 	 
		$pageview->user_ip=check_ip_behind_proxy(); 	 
		$pageview->insert();	

// setup some arrays
		$last_viewers_names = array();
		$last_viewers_profile = array();
		$last_viewers_avatar = array();
		
// get the last 5 viewers
	$last_viewers = $pageview->last_viewers(5);
	
// for each viewer, get their name, profile link and avatar and put it in an array
		$viewers=new User();
		if ($last_viewers) {
			foreach($last_viewers as $viewer_id) {
				$viewers->id=$viewer_id;
				$viewers->read();
				$last_viewers_names[] = $viewers->username;
				$last_viewers_profile[] = getmyurl('user2', $viewers->username, 'profile');
				$last_viewers_avatar[] = get_avatar('small', "", $viewers->username, $viewers->email);
			}
		}
// tell smarty about our arrays
		$main_smarty->assign('last_viewers_names', $last_viewers_names);
		$main_smarty->assign('last_viewers_profile', $last_viewers_profile);
		$main_smarty->assign('last_viewers_avatar', $last_viewers_avatar);
		
// check to see if the profile is of a friend
    $friend = new Friend;
    $main_smarty->assign('is_friend', $friend->get_friend_status($user->id));

// avatars
	$main_smarty->assign('UseAvatars', do_we_use_avatars());
	$main_smarty->assign('Avatar_ImgSrc', get_avatar('large', $user->avatar, $user->username, $user->email));
	if(substr(strtoupper($user->url), 0, 7) != "HTTP://"){
		$main_smarty->assign('user_url', "http://" . $user->url);
	} else {
		$main_smarty->assign('user_url', $user->url);
	};


// setup the URL method 2 links
	$main_smarty->assign('user_url_personal_data', getmyurl('user2', $login, 'profile'));
	$main_smarty->assign('user_url_news_sent', getmyurl('user2', $login, 'history'));
	$main_smarty->assign('user_url_news_published', getmyurl('user2', $login, 'published'));
	$main_smarty->assign('user_url_news_unpublished', getmyurl('user2', $login, 'shaken'));
	$main_smarty->assign('user_url_news_voted', getmyurl('user2', $login, 'voted'));
	$main_smarty->assign('user_url_commented', getmyurl('user2', $login, 'commented'));
	$main_smarty->assign('user_url_friends', getmyurl('user_friends', $login, 'viewfriends'));
	$main_smarty->assign('user_url_friends2', getmyurl('user_friends', $login, 'viewfriends2'));
	$main_smarty->assign('user_url_add', getmyurl('user_add_remove', $login, 'addfriend'));
	$main_smarty->assign('user_url_remove', getmyurl('user_add_remove', $login, 'removefriend'));
	$main_smarty->assign('user_rss', getmyurl('rss2user', $login));
	$main_smarty->assign('URL_Profile', getmyurl('profile'));


// tell smarty about our user
	$main_smarty = $user->fill_smarty($main_smarty);


// setup breadcrumbs for the various views
	if(isset($_REQUEST['view'])){$view = $_REQUEST['view'];}
	if(empty($view)) $view = 'profile';
	$main_smarty->assign('user_view', $view);
	if ($view == 'profile') {
		$main_smarty->assign('page_header', $user->username);
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Profile') . " / " . $login);
		$main_smarty->assign('load_leightbox', "1");
		}
	if ($view == 'voted') {
		$main_smarty->assign('page_header', $user->username . ' / ' . $main_smarty->get_config_vars('PLIGG_Visual_User_NewsVoted'));
		$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_User_NewsVoted');
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Profile') . " / " . $login . " / " . $main_smarty->get_config_vars('PLIGG_Visual_User_NewsVoted'));
		}	
	if ($view == 'history') {
		$main_smarty->assign('page_header', $user->username . ' / ' . $main_smarty->get_config_vars('PLIGG_Visual_User_NewsSent'));
		$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_User_NewsSent');
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Profile') . " / " . $login . " / " . $main_smarty->get_config_vars('PLIGG_Visual_User_NewsSent'));
		}
	if ($view == 'published') {
		$main_smarty->assign('page_header', $user->username . ' / ' . $main_smarty->get_config_vars('PLIGG_Visual_User_NewsPublished'));
		$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_User_NewsPublished');
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Profile') . " / " . $login . " / " . $main_smarty->get_config_vars('PLIGG_Visual_User_NewsPublished'));
		}
	if ($view == 'shaken') {
		$main_smarty->assign('page_header', $user->username . ' / ' . $main_smarty->get_config_vars('PLIGG_Visual_User_NewsUnPublished'));
		$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_User_NewsUnPublished');
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Profile') . " / " . $login . " / " . $main_smarty->get_config_vars('PLIGG_Visual_User_NewsUnPublished'));
		}
	if ($view == 'commented') {
		$main_smarty->assign('page_header', $user->username . ' / ' . $main_smarty->get_config_vars('PLIGG_Visual_User_NewsCommented'));
		$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_User_NewsCommented');
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Profile') . " / " . $login . " / " . $main_smarty->get_config_vars('PLIGG_Visual_User_NewsCommented'));
		}
	if ($view == 'viewfriends') {
		$main_smarty->assign('page_header', $user->username);
		$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_User_Profile_Viewing_Friends');
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Profile') . " / " . $login . " / " . $main_smarty->get_config_vars('PLIGG_Visual_User_Profile_Viewing_Friends'));
		}
	if ($view == 'viewfriends2') {
		$main_smarty->assign('page_header', $user->username);
		$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_User_Profile_Viewing_Friends_2a');
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Profile') . " / " . $login . " / " . $main_smarty->get_config_vars('PLIGG_Visual_User_Profile_Viewing_Friends_2'));
		}
	if ($view == 'removefriend') {
		$main_smarty->assign('page_header', $user->username . ' / ' . $main_smarty->get_config_vars('PLIGG_Visual_User_Profile_Removing_Friend'));
		$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_User_Profile_Removing_Friend');
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Profile') . " / " . $login . " / " . $main_smarty->get_config_vars('PLIGG_Visual_User_Profile_Removing_Friend'));
		}
	if ($view == 'addfriend') {
		$main_smarty->assign('page_header', $user->username . ' / ' . $main_smarty->get_config_vars('PLIGG_Visual_User_Profile_Adding_Friend'));
		$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_User_Profile_Adding_Friend');
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Profile') . " / " . $login . " / " . $main_smarty->get_config_vars('PLIGG_Visual_User_Profile_Adding_Friend'));
		}
	$main_smarty->assign('navbar_where', $navwhere);


// a hook	
	check_actions('user_post_views');

// display the template
	$main_smarty->assign('tpl_center', $the_template . '/user_center');
	$main_smarty->display($the_template . '/pligg.tpl');



function do_voted () {
	global $db, $rows, $user, $offset, $page_size;

	$link = new Link;
	$rows = $db->get_var("SELECT count(*) FROM " . table_links . ", " . table_votes . " WHERE vote_user_id=$user->id AND vote_link_id=link_id AND link_status!='discard'");
	$links = $db->get_col("SELECT DISTINCT link_id FROM " . table_links . ", " . table_votes . " WHERE vote_user_id=$user->id AND vote_link_id=link_id AND link_status!='discard' ORDER BY link_date DESC LIMIT $offset,$page_size");
	if ($links) {
		foreach($links as $link_id) {
			$link->id=$link_id;
			$link->read();
			$link->print_summary('summary');
		}
	}
}


function do_history () {
	global $db, $rows, $user, $offset, $page_size;

	$link = new Link;
	$rows = $db->get_var("SELECT count(*) FROM " . table_links . " WHERE link_author=$user->id AND link_status!='discard'");
	$links = $db->get_col("SELECT link_id FROM " . table_links . " WHERE link_author=$user->id AND link_status!='discard' ORDER BY link_date DESC LIMIT $offset,$page_size");
	if ($links) {
		foreach($links as $link_id) {
			$link->id=$link_id;
			$link->read();
			$link->print_summary('summary');
		}
	}
}

function do_published () {
	global $db, $rows, $user, $offset, $page_size;

	$link = new Link;
	$rows = $db->get_var("SELECT count(*) FROM " . table_links . " WHERE link_author=$user->id AND link_status='published'");
	$links = $db->get_col("SELECT link_id FROM " . table_links . " WHERE link_author=$user->id AND link_status='published'  ORDER BY link_published_date DESC LIMIT $offset,$page_size");
	if ($links) {
		foreach($links as $link_id) {
			$link->id=$link_id;
			$link->read();
			$link->print_summary('summary');
		}
	}
}

function do_shaken () {
	global $db, $rows, $user, $offset, $page_size;

	$link = new Link;
	$rows = $db->get_var("SELECT count(*) FROM " . table_links . " WHERE link_author=$user->id AND link_status='queued'");
	$links = $db->get_col("SELECT link_id FROM " . table_links . " WHERE link_author=$user->id AND link_status='queued' ORDER BY link_date DESC LIMIT $offset,$page_size");
	if ($links) {
		foreach($links as $link_id) {
			$link->id=$link_id;
			$link->read();
			$link->print_summary('summary');
		}
	}
}

function do_commented () {
    global $db, $rows, $user, $offset, $page_size;

    $link = new Link;
    $rows = $db->get_var("SELECT count(*) FROM " . table_links . ", " . table_comments . " WHERE comment_user_id=$user->id AND comment_link_id=link_id");
    $links = $db->get_col("SELECT DISTINCT link_id FROM " . table_links . ", " . table_comments . " WHERE comment_user_id=$user->id AND comment_link_id=link_id AND link_status != 'discard'  ORDER BY link_date DESC LIMIT $offset,$page_size");
    if ($links) {
        foreach($links as $link_id) {
            $link->id=$link_id;
            $link->read();
            $link->print_summary('summary');
        }
    }
    
       
}

function do_removefriend (){
	global $db, $user, $the_template;
	$friend = new Friend;
	echo '<br><center><span class="success" style="border:solid 1px #269900; padding: 2px 2px 2px 2px"><img src="'.my_pligg_base.'/templates/' . $the_template. '/images/green_check.gif" align="absmiddle"> ';
	$friend->remove($user->id);
	echo '</span></center>';

}

function do_addfriend (){
	global $db, $user, $the_template;
	$friend = new Friend;
	echo '<br><center><span class="success" style="border:solid 1px #269900; padding: 2px 2px 2px 2px"><img src="'.my_pligg_base.'/templates/' . $the_template. '/images/green_check.gif" align="absmiddle"> ';
	$friend->add($user->id);
	echo '</span></center>';

}

function do_viewfriends(){
	global $db, $user, $the_template;
	$friend = new Friend;
	$friends = $friend->get_friend_list();

	echo "<h2>Your friends</h2>";
	

	if ($friends){
	    echo '<table style=width:50% class=listing><th>username</th><th>message</th><th>remove</th>';
		foreach($friends as $myfriend) {		    
			echo '<tr><td>';
			echo ' <a href="'.getmyurl('user2', $myfriend->user_login, 'profile').'">' . $myfriend->user_login.'</a></td>
';
						
			echo '<td><a href="#view_message" rel="view_message~!~view=small_msg_compose~!~login=' .$myfriend->user_login . '"	class="lbOn"><img src='.my_pligg_base.'/templates/'.$the_template.'/images/user_message.png border=0></a></td>';
			
			echo '<td><a href = "'.getmyurl('user_add_remove', $myfriend->user_login, 'removefriend').'"><img src='.my_pligg_base.'/templates/'.$the_template.'/images/user_delete.png border=0></a></td></tr>';			
			
		}
		echo '</table>';
	}
	else {
		echo "<br /><br /><center><strong>you have no friends</strong></center>";
	}
}

function do_viewfriends2(){
	global $db, $user, $the_template;
	$friend = new Friend;
	$friends = $friend->get_friend_list_2();

	

	echo "<h2>People who have added you as a friend</h2>";

	if ($friends){
	    echo '<table style=width:50% class=listing><th>username</th><th>message</th>';
		foreach($friends as $myfriend) {
		    echo '<tr><td>';
			echo '<a href="'.getmyurl('user2', $myfriend->user_login, 'profile'). '">' . $myfriend->user_login.'</a></td>';
			
			echo '<td><a href="#view_message" rel="view_message~!~view=small_msg_compose~!~login=' .$myfriend->user_login . '"	class="lbOn"><img src='.my_pligg_base.'/templates/'.$the_template.'/images/user_message.png border=0></a></td>';
					
		}
		echo '</tr></table>';
	}
	else {
		echo "<br /><br /><center><strong>nobody has added you as a friend</strong></center>";
	}
}
?>