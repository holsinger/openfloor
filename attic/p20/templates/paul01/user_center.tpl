{config_load file="/libs/lang.conf"}
<h2>{$page_header}</h2>
{if $UseAvatars neq "0"}<span id="ls_avatar-{$link_shakebox_index}"><img src="{$Avatar_ImgSrc}" alt="Avatar"/></span>{/if}

{checkActionsTpl location="tpl_user_center_just_below_header"}

{if $user_view eq 'history'}
<div id="usertabs">
  <ul id="nav2">
    <li><a href="{$user_url_personal_data}">{#PLIGG_Visual_User_PersonalData#}</a></li>
    <li class="active"><a href="{$user_url_news_sent}">{#PLIGG_Visual_User_NewsSent#}</a></li>
    <li><a href="{$user_url_news_published}">{#PLIGG_Visual_User_NewsPublished#}</a></li>
    <li><a href="{$user_url_news_unpublished}">{#PLIGG_Visual_User_NewsUnPublished#}</a></li>
    <li class="last"><a href="{$user_url_commented}">{#PLIGG_Visual_User_NewsCommented#}</a></li>
  </ul>
</div>
<br />
<br />
{/if}

{if $user_view eq 'published'}
<div id="usertabs">
  <ul id="nav2">
    <li><a href="{$user_url_personal_data}">{#PLIGG_Visual_User_PersonalData#}</a></li>
    <li><a href="{$user_url_news_sent}">{#PLIGG_Visual_User_NewsSent#}</a></li>
    <li class="active"><a href="{$user_url_news_published}">{#PLIGG_Visual_User_NewsPublished#}</a></li>
    <li><a href="{$user_url_news_unpublished}">{#PLIGG_Visual_User_NewsUnPublished#}</a></li>
    <li class="last"><a href="{$user_url_commented}">{#PLIGG_Visual_User_NewsCommented#}</a></li>
  </ul>
</div>
<br />
<br />

{/if}

{if $user_view eq 'shaken'}
<div id="usertabs">
  <ul id="nav2">
    <li><a href="{$user_url_personal_data}">{#PLIGG_Visual_User_PersonalData#}</a></li>
    <li><a href="{$user_url_news_sent}">{#PLIGG_Visual_User_NewsSent#}</a></li>
    <li><a href="{$user_url_news_published}">{#PLIGG_Visual_User_NewsPublished#}</a></li>
    <li class="active"><a href="{$user_url_news_unpublished}">{#PLIGG_Visual_User_NewsUnPublished#}</a></li>
    <li class="last"><a href="{$user_url_commented}">{#PLIGG_Visual_User_NewsCommented#}</a></li>
  </ul>
</div>
<br />
<br />

{/if}

{if $user_view eq 'commented'}
<div id="usertabs">
  <ul id="nav2">
    <li><a href="{$user_url_personal_data}">{#PLIGG_Visual_User_PersonalData#}</a></li>
    <li><a href="{$user_url_news_sent}">{#PLIGG_Visual_User_NewsSent#}</a></li>
    <li><a href="{$user_url_news_published}">{#PLIGG_Visual_User_NewsPublished#}</a></li>
    <li><a href="{$user_url_news_unpublished}">{#PLIGG_Visual_User_NewsUnPublished#}</a></li>
    <li class="active"><a href="{$user_url_commented}">{#PLIGG_Visual_User_NewsCommented#}</a></li>
  </ul>
</div>
<br />
<br />

{/if}



{if $user_view eq 'viewfriends'}
<div id="usertabs">
  <ul id="nav2">
    <li class="active"><a href="{$user_url_personal_data}">{#PLIGG_Visual_User_PersonalData#}</a></li>
    <li><a href="{$user_url_news_sent}">{#PLIGG_Visual_User_NewsSent#}</a></li>
    <li><a href="{$user_url_news_published}">{#PLIGG_Visual_User_NewsPublished#}</a></li>
    <li><a href="{$user_url_news_unpublished}">{#PLIGG_Visual_User_NewsUnPublished#}</a></li>
    <li><a href="{$user_url_commented}">{#PLIGG_Visual_User_NewsCommented#}</a></li>
  </ul>
</div>

{if $Allow_Friends neq "0"}
<br />
<br />
<div id="mini_profile" align="center"> {* display user's rss link *}
	<img src="{$my_pligg_base}/templates/{$the_template}/images/rss2.gif" align="absmiddle"/> 
	<a href="{$user_rss, "published"}">{#PLIGG_Visual_User_Profile_View_RSS#} {$user_login}'s {#PLIGG_Visual_User_Profile_View_RSS_2#}</a> 

	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

	{* display "people who've add me as a friend" link *}
	<img src="{$my_pligg_base}/templates/{$the_template}/images/friends2.png" align="absmiddle"/> 
	<a href="{$user_url_friends2}">{#PLIGG_Visual_User_Profile_View_Friends_2#}</a> 
</div>
<br />
{/if}
{/if}



{if $user_view eq 'viewfriends2'}
<div id="usertabs">
  <ul id="nav2">
    <li class="active"><a href="{$user_url_personal_data}">{#PLIGG_Visual_User_PersonalData#}</a></li>
    <li><a href="{$user_url_news_sent}">{#PLIGG_Visual_User_NewsSent#}</a></li>
    <li><a href="{$user_url_news_published}">{#PLIGG_Visual_User_NewsPublished#}</a></li>
    <li><a href="{$user_url_news_unpublished}">{#PLIGG_Visual_User_NewsUnPublished#}</a></li>
    <li><a href="{$user_url_commented}">{#PLIGG_Visual_User_NewsCommented#}</a></li>
  </ul>
</div>

{if $Allow_Friends neq "0"}
<br />
<br />
<div id="mini_profile" align="center"> {* display user's rss link *}
	<img src="{$my_pligg_base}/templates/{$the_template}/images/rss2.gif" align="absmiddle"/>
	<a href="{$user_rss, "published"}">{#PLIGG_Visual_User_Profile_View_RSS#} {$user_login}'s {#PLIGG_Visual_User_Profile_View_RSS_2#}</a> 

	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 	
	{* display "view my friends" link *}
	<img src="{$my_pligg_base}/templates/{$the_template}/images/friends.png" align="absmiddle"/>
	<a href="{$user_url_friends}">{#PLIGG_Visual_User_Profile_View_Friends#}</a>
</div>
<br />
{/if}
{/if}



{if $user_view eq 'removefriend'}
<div id="usertabs">
  <ul id="nav2">
    <li class="active"><a href="{$user_url_personal_data}">{#PLIGG_Visual_User_PersonalData#}</a></li>
    <li><a href="{$user_url_news_sent}">{#PLIGG_Visual_User_NewsSent#}</a></li>
    <li><a href="{$user_url_news_published}">{#PLIGG_Visual_User_NewsPublished#}</a></li>
    <li><a href="{$user_url_news_unpublished}">{#PLIGG_Visual_User_NewsUnPublished#}</a></li>
    <li><a href="{$user_url_commented}">{#PLIGG_Visual_User_NewsCommented#}</a></li>
  </ul>
</div>

{if $Allow_Friends neq "0"}
<br />
<br />
<div id="mini_profile" align="center">{* if viewing someone else's profile *}
		{if $user_login neq $user_logged_in}
  
		&nbsp;&nbsp;&nbsp;&nbsp;
  
		{* display "view my friends" link *}
		<img src="{$my_pligg_base}/templates/{$the_template}/images/friends.png" align="absmiddle"/>
		<a href="{$user_url_friends}">{#PLIGG_Visual_User_Profile_View_Friends#}</a>

            &nbsp;&nbsp;&nbsp;&nbsp;
  
		{* display "people who have added me as a friend" link *}
		<img src="{$my_pligg_base}/templates/{$the_template}/images/friends2.png" align="absmiddle"/>
		<a href="{$user_url_friends2}">{#PLIGG_Visual_User_Profile_View_Friends_2#}</a>
  
		{/if}
</div>
{/if}
{/if}



{if $user_view eq 'addfriend'}
<div id="usertabs">
  <ul id="nav2">
    <li class="active"><a href="{$user_url_personal_data}">{#PLIGG_Visual_User_PersonalData#}</a></li>
    <li><a href="{$user_url_news_sent}">{#PLIGG_Visual_User_NewsSent#}</a></li>
    <li><a href="{$user_url_news_published}">{#PLIGG_Visual_User_NewsPublished#}</a></li>
    <li><a href="{$user_url_news_unpublished}">{#PLIGG_Visual_User_NewsUnPublished#}</a></li>
    <li><a href="{$user_url_commented}">{#PLIGG_Visual_User_NewsCommented#}</a></li>
  </ul>
</div>

{if $Allow_Friends neq "0"}
<br />
<br />
<div id="mini_profile" align="center"> {* display user's rss link *}
	<img src="{$my_pligg_base}/templates/{$the_template}/images/rss2.gif" align="absmiddle"/>
	<a href="{$user_rss, "published"}">{#PLIGG_Visual_User_Profile_View_RSS#} {$user_login}'s {#PLIGG_Visual_User_Profile_View_RSS_2#}</a>
 
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 
      {* display "view my friends" link *}
	<img src="{$my_pligg_base}/templates/{$the_template}/images/friends.png" align="absmiddle"/>
	<a href="{$user_url_friends}">{#PLIGG_Visual_User_Profile_View_Friends#}</a>

  	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  
	{* display "people who have added me as a friend" link *}
	<img src="{$my_pligg_base}/templates/{$the_template}/images/friends2.png" align="absmiddle"/>
	<a href="{$user_url_friends2}">{#PLIGG_Visual_User_Profile_View_Friends_2#}</a> 

</div>
{/if}
{/if}


{if $user_view eq 'profile'}
<div id="usertabs">
  <ul id="nav2">
    <li class="active"><a href="{$user_url_personal_data}">{#PLIGG_Visual_User_PersonalData#}</a></li>
    <li><a href="{$user_url_news_sent}">{#PLIGG_Visual_User_NewsSent#}</a></li>
    <li><a href="{$user_url_news_published}">{#PLIGG_Visual_User_NewsPublished#}</a></li>
    <li><a href="{$user_url_news_unpublished}">{#PLIGG_Visual_User_NewsUnPublished#}</a></li>
    <li class="last"><a href="{$user_url_commented}">{#PLIGG_Visual_User_NewsCommented#}</a></li>
  </ul>
</div>

<br /><br />


<div id="mini_profile" align="center">
{#PLIGG_Visual_User_Profile_Last_5_Title#}<br>
{section name=customer loop=$last_viewers_names}
 <img src="{$last_viewers_avatar[customer]}" alt="Avatar" align="absmiddle"> <a href = "{$last_viewers_profile[customer]}">{$last_viewers_names[customer]}</a>
{/section}
</div>

{if $Allow_Friends neq "0"}
<br />
<div id="mini_profile" align="center"> 	{* display user's rss link *}
      {if $user_login neq $user_logged_in}
	<img src="{$my_pligg_base}/templates/{$the_template}/images/rss2.gif" align="absmiddle"/>
	<a href="{$user_rss, "published"}">{#PLIGG_Visual_User_Profile_View_RSS#} {$user_login}'s {#PLIGG_Visual_User_Profile_View_RSS_2#}</a> 
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      {/if}
		{* if you're viewing someone elses profile *}
		{if $user_login neq $user_logged_in}

			{* if they are your friend *}
  			{if $is_friend gt 0}

			{* display "remove user from friends" link *}
			<img src="{$my_pligg_base}/templates/{$the_template}/images/user_delete.png" align="absmiddle"/>
			<a href="{$user_url_remove}">{#PLIGG_Visual_User_Profile_Remove_Friend#} {$user_login} {#PLIGG_Visual_User_Profile_Remove_Friend_2#}</a>

				{* if they are your friend and you are logged in *}
	   			{if $user_authenticated eq true}

				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		
				{* display "send user a message" link *}
				<img src="{$my_pligg_base}/templates/{$the_template}/images/user_message.png" align="absmiddle"/> <a href="#view_message" rel="view_message~!~view=small_msg_compose~!~login={$user_login}" class="lbOn">send a message</a>

				{/if}
 			
			{* if they are not your friend *}
			{else}
  				
				{* if you are logged in *}
   				{if $user_authenticated eq true}  

				{* display "add user to friends" link *}
				<img src="{$my_pligg_base}/templates/{$the_template}/images/user_add.png" align="absmiddle"/>
				<a href="{$user_url_add}">	{#PLIGG_Visual_User_Profile_Add_Friend#} {$user_login} {#PLIGG_Visual_User_Profile_Add_Friend_2#}</a>

			     {/if}   
   
			{/if}   
   
		{* if you're viewing your own profile *}		
		{else}
  
		{* display "view my friends" link *}
		<img src="{$my_pligg_base}/templates/{$the_template}/images/friends.png" align="absmiddle"/>
		<a href="{$user_url_friends}">{#PLIGG_Visual_User_Profile_View_Friends#}</a> 
  
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  
		{* display "people who have added me as a friend" link *}
		<img src="{$my_pligg_base}/templates/{$the_template}/images/friends2.png" align="absmiddle"/>
		<a href="{$user_url_friends2}">{#PLIGG_Visual_User_Profile_View_Friends_2#}</a> 
  
		{/if}
 </div>
{/if}

<br />

<div id="wrapper">
<div id="personal_info">
<fieldset>
<legend>{#PLIGG_Visual_User_PersonalData#}</legend>

<table style="border:none">

<tr>
<td style="background:none"><strong>{#PLIGG_Visual_Login_Username#}:</strong></td>
<td style="background:none">{if $UseAvatars neq "0"}<span id="ls_avatar-{$link_shakebox_index}"><img src="{$Avatar_ImgSrc}" alt="Avatar" align="absmiddle"/></span>{/if} {$user_username}</td>
</tr>

{if $user_names ne ""}
<tr>
<td><strong>{#PLIGG_Visual_User_Profile_User#}:</strong></td>
<td>{$user_names}</td>
</tr>
{/if}



{if $user_url ne ""}
<tr>
<td><strong>{#PLIGG_Visual_User_Profile_Homepage#}:</strong></td>
<td><a href="{$user_url}" target="_blank">{$user_url}</a></td>
</tr>
{/if}


{if $user_publicemail ne ""}
<tr>
<td><strong>{#PLIGG_Visual_User_Profile_PublicEmail#}:</strong></td>
<td>{$user_publicemail}</td>
</tr>
{/if}

{if $user_location ne ""}
<tr>
<td><strong>{#PLIGG_Visual_Profile_Location#}:</strong></td>
<td>{$user_location}</td>
</tr>
{/if}

{if $user_occupation ne ""}
<tr>
<td><strong>{#PLIGG_Visual_Profile_Occupation#}:</strong></td>
<td>{$user_occupation}</td>
</tr>
{/if}

{if $user_aim ne ""}

<tr>
<td><strong>{#PLIGG_Visual_User_Profile_AIM#}:</strong></td>
<td>{$user_aim}</td>
</tr>
{/if}



{if $user_msn ne ""}
<tr>
<td><strong>{#PLIGG_Visual_User_Profile_MSN#}:</strong></td>
<td>{$user_msn}</td>
</tr>
{/if}



{if $user_yahoo ne ""}
<tr>
<td><strong>{#PLIGG_Visual_User_Profile_Yahoo#}:</strong></td>
<td>{$user_yahoo}</td>
</tr>
{/if}



{if $user_gtalk ne ""}
<tr>
<td><strong>{#PLIGG_Visual_User_Profile_GTalk#}:</strong></td>
<td>{$user_gtalk}</td>
</tr>
{/if}



{if $user_skype ne ""}
<tr>
<td><strong>{#PLIGG_Visual_User_Profile_Skype#}:</strong></td>
<td>{$user_skype}</td>
</tr>
{/if}



{if $user_irc ne ""}
<tr>
<td><strong>{#PLIGG_Visual_User_Profile_IRC#}:</strong></td>
<td><a href="{$user_irc}" target="_blank">{$user_irc}</a></td>
</tr>
{/if}

{if $user_login eq $user_logged_in}
<tr>

<td><input type="button" value="modify" class="log2" onclick="location='{$URL_Profile}'"></td>
</tr>
{/if}


</table>
</fieldset>
</div>
<br />


<div id="stats">
<fieldset>
<legend>{#PLIGG_Visual_User_Profile_User_Stats#}</legend>
<table style="border:none;">

<tr>
<td style="background:none"><strong>{#PLIGG_Visual_User_Profile_Joined#}:</strong></td>
<td style="background:none">{$user_joined}</td>
</tr>

<tr>  <td><strong>{#PLIGG_Visual_User_Profile_Total_Links#}:</strong></td>
      <td>{$user_total_links}</td>
  </tr>
<tr>  <td><strong>{#PLIGG_Visual_User_Profile_Published_Links#}:</strong></td>
  <td>{$user_published_links}</td>
  </tr>
<tr>  <td><strong>{#PLIGG_Visual_User_Profile_Total_Comments#}:</strong></td>
  <td>{$user_total_comments}</td>
  </tr>
<tr>  <td><strong>{#PLIGG_Visual_User_Profile_Total_Votes#}:</strong></td>
  <td>{$user_total_votes}</td>
  </tr>
<tr>  <td><strong>{#PLIGG_Visual_User_Profile_Published_Votes#}:</strong></td>
 <td>{$user_published_votes}</td>
 </tr>
 
 {if $user_karma ne ""}
<tr>
<td><strong>{#PLIGG_Visual_User_Profile_KarmaPoints#}:</strong></td>
<td>{$user_karma}</td>
</tr>
{/if}
 
</table>
</fieldset>
</div>


{if $user_login eq $user_logged_in}
<br />

<div id="bookmarklet">
<fieldset>
<legend>{#PLIGG_Visual_User_Profile_Bookmarklet_Title#}</legend>
<br />
{#PLIGG_Visual_User_Profile_Bookmarklet_Title_1#} {#PLIGG_Visual_Name#}.{#PLIGG_Visual_User_Profile_Bookmarklet_Title_2#}<br />
<br />
<b>{#PLIGG_Visual_User_Profile_IE#}:</b> {#PLIGG_Visual_User_Profile_IE_1#}<br />
<b>{#PLIGG_Visual_User_Profile_Firefox#}:</b> {#PLIGG_Visual_User_Profile_Firefox_1#}<br />
<b>{#PLIGG_Visual_User_Profile_Opera#}:</b> {#PLIGG_Visual_User_Profile_Opera_1#}<br />
<br />
<b>{#PLIGG_Visual_User_Profile_The_Bookmarklet#}: <a href="javascript:q=(document.location.href);void(open('{$my_base_url}{$my_pligg_base}/submit.php?url='+escape(q),'','resizable,location,menubar,toolbar,scrollbars,status'));">{#PLIGG_Visual_Name#}</a></b>
</fieldset>
</div>


</div>


{/if}
{/if}


{php}
Global $db, $main_smarty, $view, $user, $rows, $page_size, $offset;

switch ($view) {
	case 'history':
		do_history();
		do_pages($rows, $page_size, $the_page);		
		break;
	case 'published':
		do_published();
		do_pages($rows, $page_size, $the_page); 
		break;
	case 'shaken':
		do_shaken();
		do_pages($rows, $page_size, $the_page);
		break;	
	case 'commented':
        do_commented();
        do_pages($rows, $page_size, $the_page);
        break; 	
	case 'profile':
		default:
		break;
	
	case 'removefriend':
		do_removefriend();
		break;
	case 'addfriend':
		do_addfriend();
		break;
	case 'viewfriends':
		do_viewfriends();
		break;
	case 'viewfriends2':
		do_viewfriends2();
		break;

	case 'sendmessage':
		do_sendmessage();
		break;
}	



{/php} 