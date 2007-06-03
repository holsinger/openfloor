{config_load file="/libs/lang.conf"}

<h2 style="margin-top:0px;border:none">{$page_header}</h2>

{checkActionsTpl location="tpl_user_center_just_below_header"}

{if $user_view eq 'history'}
<a href="{$user_rss, "all"}" target="_blank"><img src="{$my_pligg_base}/templates/{$the_template}/images/rss.png" border="0" style="float:left; padding-top:10px; padding-left:13px;"></a>
<div id="cab" style="margin:0px">
	<ul class="postin">
	    <li><a href="{$user_url_personal_data}" class="navbut3"><span>{#PLIGG_Visual_User_PersonalData#}</span></a></li>
	    <li><a href="{$user_url_news_sent}" class="navbut4"><span>{#PLIGG_Visual_User_NewsSent#}</span></a></li>
	    <li><a href="{$user_url_news_published}" class="navbut3"><span>{#PLIGG_Visual_User_NewsPublished#}</span></a></li>
	    <li><a href="{$user_url_news_unpublished}" class="navbut3"><span>{#PLIGG_Visual_User_NewsUnPublished#}</span></a></li>
	    <li><a href="{$user_url_commented}" class="navbut3"><span>{#PLIGG_Visual_User_NewsCommented#}</span></a></li>
		<li><a href="{$user_url_news_voted}" class="navbut3"><span>{#PLIGG_Visual_User_NewsVoted#}</span></a></li>
	</ul>
</div>
<div id="navbar" style="margin:0px;"></div>
{/if}

{if $user_view eq 'published'}
<a href="{$user_rss, "published"}" target="_blank"><img src="{$my_pligg_base}/templates/{$the_template}/images/rss.png" border="0" style="float:left; padding-top:10px; padding-left:13px;"></a>
<div id="cab" style="margin:0px">
	<ul class="postin">
	    <li><a href="{$user_url_personal_data}" class="navbut3"><span>{#PLIGG_Visual_User_PersonalData#}</span></a></li>
	    <li><a href="{$user_url_news_sent}" class="navbut3"><span>{#PLIGG_Visual_User_NewsSent#}</span></a></li>
	    <li><a href="{$user_url_news_published}" class="navbut4"><span>{#PLIGG_Visual_User_NewsPublished#}</span></a></li>
	    <li><a href="{$user_url_news_unpublished}" class="navbut3"><span>{#PLIGG_Visual_User_NewsUnPublished#}</span></a></li>
	    <li><a href="{$user_url_commented}" class="navbut3"><span>{#PLIGG_Visual_User_NewsCommented#}</span></a></li>
		<li><a href="{$user_url_news_voted}" class="navbut3"><span>{#PLIGG_Visual_User_NewsVoted#}</span></a></li>
	</ul>
</div>
<div id="navbar" style="margin:0px;"></div>
{/if}

{if $user_view eq 'shaken'}
<a href="{$user_rss, "queued"}" target="_blank"><img src="{$my_pligg_base}/templates/{$the_template}/images/rss.png" border="0" style="float:left; padding-top:10px; padding-left:13px;"></a>
<div id="cab" style="margin:0px">
	<ul class="postin">
	    <li><a href="{$user_url_personal_data}" class="navbut3"><span>{#PLIGG_Visual_User_PersonalData#}</span></a></li>
	    <li><a href="{$user_url_news_sent}" class="navbut3"><span>{#PLIGG_Visual_User_NewsSent#}</span></a></li>
	    <li><a href="{$user_url_news_published}" class="navbut3"><span>{#PLIGG_Visual_User_NewsPublished#}</span></a></li>
	    <li><a href="{$user_url_news_unpublished}" class="navbut4"><span>{#PLIGG_Visual_User_NewsUnPublished#}</span></a></li>
	    <li><a href="{$user_url_commented}" class="navbut3"><span>{#PLIGG_Visual_User_NewsCommented#}</span></a></li>
		<li><a href="{$user_url_news_voted}" class="navbut3"><span>{#PLIGG_Visual_User_NewsVoted#}</span></a></li>
	</ul>
</div>
<div id="navbar" style="margin:0px;"></div>
{/if}

{if $user_view eq 'commented'}
<a href="{$user_rss, "commented"}" target="_blank"><img src="{$my_pligg_base}/templates/{$the_template}/images/rss.png" border="0" style="float:left; padding-top:10px; padding-left:13px;"></a>
<div id="cab" style="margin:0px">
	<ul class="postin">
	    <li><a href="{$user_url_personal_data}" class="navbut3"><span>{#PLIGG_Visual_User_PersonalData#}</span></a></li>
	    <li><a href="{$user_url_news_sent}" class="navbut3"><span>{#PLIGG_Visual_User_NewsSent#}</span></a></li>
	    <li><a href="{$user_url_news_published}" class="navbut3"><span>{#PLIGG_Visual_User_NewsPublished#}</span></a></li>
	    <li><a href="{$user_url_news_unpublished}" class="navbut3"><span>{#PLIGG_Visual_User_NewsUnPublished#}</span></a></li>
	    <li><a href="{$user_url_commented}" class="navbut4"><span>{#PLIGG_Visual_User_NewsCommented#}</span></a></li>
		<li><a href="{$user_url_news_voted}" class="navbut3"><span>{#PLIGG_Visual_User_NewsVoted#}</span></a></li>
	</ul>
</div>
<div id="navbar" style="margin:0px;"></div>
{/if}

{if $user_view eq 'voted'}
<a href="{$user_rss, "voted"}" target="_blank"><img src="{$my_pligg_base}/templates/{$the_template}/images/rss.png" border="0" style="float:left; padding-top:10px; padding-left:13px;"></a>
<div id="cab" style="margin:0px">
	<ul class="postin">
	    <li><a href="{$user_url_personal_data}" class="navbut3"><span>{#PLIGG_Visual_User_PersonalData#}</span></a></li>
	    <li><a href="{$user_url_news_sent}" class="navbut3"><span>{#PLIGG_Visual_User_NewsSent#}</span></a></li>
	    <li><a href="{$user_url_news_published}" class="navbut3"><span>{#PLIGG_Visual_User_NewsPublished#}</span></a></li>
	    <li><a href="{$user_url_news_unpublished}" class="navbut3"><span>{#PLIGG_Visual_User_NewsUnPublished#}</span></a></li>
	    <li><a href="{$user_url_commented}" class="navbut3"><span>{#PLIGG_Visual_User_NewsCommented#}</span></a></li>
		<li><a href="{$user_url_news_voted}" class="navbut4"><span>{#PLIGG_Visual_User_NewsVoted#}</span></a></li>
	</ul>
</div>
<div id="navbar" style="margin:0px;"></div>
{/if}

{if $user_view eq 'viewfriends'}
{if $UseAvatars neq "0"}<span id="ls_avatar-{$link_shakebox_index}"><img src="{$Avatar_ImgSrc}" style="float:left"/></span>{/if}
<div id="cab" style="margin:0px">
	<ul class="postin">
	    <li><a href="{$user_url_personal_data}" class="navbut3"><span>{#PLIGG_Visual_User_PersonalData#}</span></a></li>
	    <li><a href="{$user_url_news_sent}" class="navbut3"><span>{#PLIGG_Visual_User_NewsSent#}</span></a></li>
	    <li><a href="{$user_url_news_published}" class="navbut3"><span>{#PLIGG_Visual_User_NewsPublished#}</span></a></li>
	    <li><a href="{$user_url_news_unpublished}" class="navbut3"><span>{#PLIGG_Visual_User_NewsUnPublished#}</span></a></li>
	    <li><a href="{$user_url_commented}" class="navbut3"><span>{#PLIGG_Visual_User_NewsCommented#}</span></a></li>
		<li><a href="{$user_url_news_voted}" class="navbut3"><span>{#PLIGG_Visual_User_NewsVoted#}</span></a></li>
	</ul>
</div>
<div id="navbar" style="margin:0px;">
	{if $Allow_Friends neq "0"}

	<img src="{$my_pligg_base}/templates/{$the_template}/images/rss.png" align="absmiddle"/> 
	<a href="{$user_rss, "published"}">{#PLIGG_Visual_User_Profile_View_RSS#} {$user_login}'s {#PLIGG_Visual_User_Profile_View_RSS_2#}</a> 

	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

	{* display "people who've add me as a friend" link *}
	<img src="{$my_pligg_base}/templates/{$the_template}/images/friends2.png" align="absmiddle"/> 
	<a href="{$user_url_friends2}">{#PLIGG_Visual_User_Profile_View_Friends_2#}</a> 
	
	{/if}
</div>
{/if}

{if $user_view eq 'viewfriends2'}
{if $UseAvatars neq "0"}<span id="ls_avatar-{$link_shakebox_index}"><img src="{$Avatar_ImgSrc}" style="float:left"/></span>{/if}
<div id="cab" style="margin:0px">
	<ul class="postin">
	    <li><a href="{$user_url_personal_data}" class="navbut3"><span>{#PLIGG_Visual_User_PersonalData#}</span></a></li>
	    <li><a href="{$user_url_news_sent}" class="navbut3"><span>{#PLIGG_Visual_User_NewsSent#}</span></a></li>
	    <li><a href="{$user_url_news_published}" class="navbut3"><span>{#PLIGG_Visual_User_NewsPublished#}</span></a></li>
	    <li><a href="{$user_url_news_unpublished}" class="navbut3"><span>{#PLIGG_Visual_User_NewsUnPublished#}</span></a></li>
	    <li><a href="{$user_url_commented}" class="navbut3"><span>{#PLIGG_Visual_User_NewsCommented#}</span></a></li>
		<li><a href="{$user_url_news_voted}" class="navbut3"><span>{#PLIGG_Visual_User_NewsVoted#}</span></a></li>
	</ul>
</div>
<div id="navbar" style="margin:0px;">
	{if $Allow_Friends neq "0"}
	
	<img src="{$my_pligg_base}/templates/{$the_template}/images/rss.png" align="absmiddle"/>
	<a href="{$user_rss, "published"}">{#PLIGG_Visual_User_Profile_View_RSS#} {$user_login}'s {#PLIGG_Visual_User_Profile_View_RSS_2#}</a> 

	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 	
	{* display "view my friends" link *}
	<img src="{$my_pligg_base}/templates/{$the_template}/images/friends.png" align="absmiddle"/>
	<a href="{$user_url_friends}">{#PLIGG_Visual_User_Profile_View_Friends#}</a>
	
	{/if}
</div>
{/if}

{if $user_view eq 'removefriend'}
{if $UseAvatars neq "0"}<span id="ls_avatar-{$link_shakebox_index}"><img src="{$Avatar_ImgSrc}" style="float:left"/></span>{/if}
<div id="cab" style="margin:0px">
	<ul class="postin">
	    <li><a href="{$user_url_personal_data}" class="navbut3"><span>{#PLIGG_Visual_User_PersonalData#}</span></a></li>
	    <li><a href="{$user_url_news_sent}" class="navbut3"><span>{#PLIGG_Visual_User_NewsSent#}</span></a></li>
	    <li><a href="{$user_url_news_published}" class="navbut3"><span>{#PLIGG_Visual_User_NewsPublished#}</span></a></li>
	    <li><a href="{$user_url_news_unpublished}" class="navbut3"><span>{#PLIGG_Visual_User_NewsUnPublished#}</span></a></li>
	    <li><a href="{$user_url_commented}" class="navbut3"><span>{#PLIGG_Visual_User_NewsCommented#}</span></a></li>
		<li><a href="{$user_url_news_voted}" class="navbut3"><span>{#PLIGG_Visual_User_NewsVoted#}</span></a></li>
	</ul>
</div>
<div id="navbar" style="margin:0px;">
	{if $Allow_Friends neq "0"}	
		
		{if $user_login neq $user_logged_in}
  
		&nbsp;&nbsp;&nbsp;&nbsp;
  
		<img src="{$my_pligg_base}/templates/{$the_template}/images/friends.png" align="absmiddle"/>
		<a href="{$user_url_friends}">{#PLIGG_Visual_User_Profile_View_Friends#}</a>

        &nbsp;&nbsp;&nbsp;&nbsp;
  
		<img src="{$my_pligg_base}/templates/{$the_template}/images/friends2.png" align="absmiddle"/>
		<a href="{$user_url_friends2}">{#PLIGG_Visual_User_Profile_View_Friends_2#}</a>
  
		{/if}
	{/if}
</div>
{/if}

{if $user_view eq 'addfriend'}
{if $UseAvatars neq "0"}<span id="ls_avatar-{$link_shakebox_index}"><img src="{$Avatar_ImgSrc}" style="float:left"/></span>{/if}
<div id="cab" style="margin:0px">
	<ul class="postin">
	    <li><a href="{$user_url_personal_data}" class="navbut3"><span>{#PLIGG_Visual_User_PersonalData#}</span></a></li>
	    <li><a href="{$user_url_news_sent}" class="navbut3"><span>{#PLIGG_Visual_User_NewsSent#}</span></a></li>
	    <li><a href="{$user_url_news_published}" class="navbut3"><span>{#PLIGG_Visual_User_NewsPublished#}</span></a></li>
	    <li><a href="{$user_url_news_unpublished}" class="navbut3"><span>{#PLIGG_Visual_User_NewsUnPublished#}</span></a></li>
	    <li><a href="{$user_url_commented}" class="navbut3"><span>{#PLIGG_Visual_User_NewsCommented#}</span></a></li>
		<li><a href="{$user_url_news_voted}" class="navbut3"><span>{#PLIGG_Visual_User_NewsVoted#}</span></a></li>
	</ul>
</div>
<div id="navbar" style="margin:0px;">
	{if $Allow_Friends neq "0"}
	
	<img src="{$my_pligg_base}/templates/{$the_template}/images/rss.png" align="absmiddle"/>
	<a href="{$user_rss, "published"}">{#PLIGG_Visual_User_Profile_View_RSS#} {$user_login}'s {#PLIGG_Visual_User_Profile_View_RSS_2#}</a>
 
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 
	<img src="{$my_pligg_base}/templates/{$the_template}/images/friends.png" align="absmiddle"/>
	<a href="{$user_url_friends}">{#PLIGG_Visual_User_Profile_View_Friends#}</a>

  	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  
	<img src="{$my_pligg_base}/templates/{$the_template}/images/friends2.png" align="absmiddle"/>
	<a href="{$user_url_friends2}">{#PLIGG_Visual_User_Profile_View_Friends_2#}</a>   
	
	{/if}
</div>
{/if}

{if $user_view eq 'profile'}
{if $UseAvatars neq "0"}<span id="ls_avatar-{$link_shakebox_index}"><img src="{$Avatar_ImgSrc}" style="float:left"/></span>{/if}
<div id="cab" style="margin:0px">
	<ul class="postin">
	    <li><a href="{$user_url_personal_data}" class="navbut4"><span>{#PLIGG_Visual_User_PersonalData#}</span></a></li>
	    <li><a href="{$user_url_news_sent}" class="navbut3"><span>{#PLIGG_Visual_User_NewsSent#}</span></a></li>
	    <li><a href="{$user_url_news_published}" class="navbut3"><span>{#PLIGG_Visual_User_NewsPublished#}</span></a></li>
	    <li><a href="{$user_url_news_unpublished}" class="navbut3"><span>{#PLIGG_Visual_User_NewsUnPublished#}</span></a></li>
	    <li><a href="{$user_url_commented}" class="navbut3"><span>{#PLIGG_Visual_User_NewsCommented#}</span></a></li>
		<li><a href="{$user_url_news_voted}" class="navbut3"><span>{#PLIGG_Visual_User_NewsVoted#}</span></a></li>
	</ul>
</div>
<div id="navbar" style="margin:0px;">
{if $Allow_Friends neq "0"}	

	<img src="{$my_pligg_base}/templates/{$the_template}/images/rss.png" align="absmiddle"/>
	<a href="{$user_rss, "published"}">{#PLIGG_Visual_User_Profile_View_RSS#} {$user_login}'s {#PLIGG_Visual_User_Profile_View_RSS_2#}</a> 

		{if $user_login neq $user_logged_in}

  			{if $is_friend gt 0}
  
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

			<img src="{$my_pligg_base}/templates/{$the_template}/images/user_delete.png" align="absmiddle"/>
			<a href="{$user_url_remove}">{#PLIGG_Visual_User_Profile_Remove_Friend#} {$user_login} {#PLIGG_Visual_User_Profile_Remove_Friend_2#}</a>

	   			{if $user_authenticated eq true}

				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		
				{checkActionsTpl location="tpl_user_center"}

				{/if}
 			
			{else}
  				
   				{if $user_authenticated eq true}

				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   

				<img src="{$my_pligg_base}/templates/{$the_template}/images/user_add.png" align="absmiddle"/>
				<a href="{$user_url_add}">	{#PLIGG_Visual_User_Profile_Add_Friend#} {$user_login} {#PLIGG_Visual_User_Profile_Add_Friend_2#}</a>

			    {/if}   
   
			{/if}   
   		
		{else}
  
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  
		<img src="{$my_pligg_base}/templates/{$the_template}/images/friends.png" align="absmiddle"/>
		<a href="{$user_url_friends}">{#PLIGG_Visual_User_Profile_View_Friends#}</a> 
  
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  
		<img src="{$my_pligg_base}/templates/{$the_template}/images/friends2.png" align="absmiddle"/>
		<a href="{$user_url_friends2}">{#PLIGG_Visual_User_Profile_View_Friends_2#}</a> 
  
		{/if} 
	{/if}
</div>
	
<br />

<div id="wrapper">
	<div id="personal_info">
		<fieldset><legend>{#PLIGG_Visual_User_PersonalData#}</legend>
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
			<tr><td><input type="button" value="{#PLIGG_Visual_User_Profile_Modify#}" class="log2" onclick="location='{$URL_Profile}'"></td></tr>
			{/if}
			</table>
		</fieldset>
	</div>

	<div id="stats">
		<fieldset><legend>{#PLIGG_Visual_User_Profile_User_Stats#}</legend>
			<table style="border:none;">
			<tr>
			<td style="background:none"><strong>{#PLIGG_Visual_User_Profile_Joined#}:</strong></td>
			<td style="background:none">{$user_joined}</td>
			</tr>

			<tr>
			<td><strong>{#PLIGG_Visual_User_Profile_Total_Links#}:</strong></td>
			<td>{$user_total_links}</td>
			</tr>

			<tr>
			<td><strong>{#PLIGG_Visual_User_Profile_Published_Links#}:</strong></td>
			<td>{$user_published_links}</td>
			</tr>

			<tr>
			<td><strong>{#PLIGG_Visual_User_Profile_Total_Comments#}:</strong></td>
			<td>{$user_total_comments}</td>
			</tr>

			<tr>
			<td><strong>{#PLIGG_Visual_User_Profile_Total_Votes#}:</strong></td>
			<td>{$user_total_votes}</td>
			</tr>

			<tr>
			<td><strong>{#PLIGG_Visual_User_Profile_Published_Votes#}:</strong></td>
			<td>{$user_published_votes}</td>
			</tr>

			{if $user_karma ne ""}
			<tr>
			<td><strong>{#PLIGG_Visual_User_Profile_KarmaPoints#}:</strong></td>
			<td>{$user_karma}</td>
			</tr>
			{/if}

			<tr><td><strong>{#PLIGG_Visual_User_Profile_Last_5_Title#}:</strong></td></tr>
				{section name=customer loop=$last_viewers_names}
				<tr><td><img src="{$last_viewers_avatar[customer]}" align="absmiddle"> <a href = "{$last_viewers_profile[customer]}">{$last_viewers_names[customer]}</a></td></tr>
				{/section}		 
			</table>
		</fieldset>
	</div>

	{if $user_login eq $user_logged_in}
	<hr />
	<div id="bookmarklet">
		<fieldset><legend>{#PLIGG_Visual_User_Profile_Bookmarklet_Title#}</legend>
			<br />{#PLIGG_Visual_User_Profile_Bookmarklet_Title_1#} {#PLIGG_Visual_Name#}.{#PLIGG_Visual_User_Profile_Bookmarklet_Title_2#}<br />
			<br /><b>{#PLIGG_Visual_User_Profile_IE#}:</b> {#PLIGG_Visual_User_Profile_IE_1#}
			<br /><b>{#PLIGG_Visual_User_Profile_Firefox#}:</b> {#PLIGG_Visual_User_Profile_Firefox_1#}
			<br /><b>{#PLIGG_Visual_User_Profile_Opera#}:</b> {#PLIGG_Visual_User_Profile_Opera_1#}
			<br /><br /><b>{#PLIGG_Visual_User_Profile_The_Bookmarklet#}: <a href="javascript:q=(document.location.href);void(open('{$my_base_url}{$my_pligg_base}/submit.php?url='+escape(q),'','resizable,location,menubar,toolbar,scrollbars,status'));">{#PLIGG_Visual_Name#}</a></b>
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
	case 'voted':
        do_voted();
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