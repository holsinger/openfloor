{config_load file="/libs/lang.conf"}
<div class="news-summary" id="news-{$link_shakebox_index}">
	{if $Voting_Method eq 1}
	  {if $link_shakebox_currentuser_votes eq 1}
	  
	  <ul class="news-upcoming2">
		
			<li class="mnm-published" id="cat{$category_id}"><a id="mnms-{$link_shakebox_index}" href="">{$link_shakebox_votes}</a></li>
			<li class="menealo" id="mnmlink-{$link_shakebox_index}">			
				{if $link_shakebox_currentuser_votes eq 0}
					<a href="javascript:{$link_shakebox_javascript_vote}">{#PLIGG_Visual_Vote_For_It#}</a>
				{else}
					<span>{#PLIGG_Visual_Vote_Cast#}</span>
				{/if}
			</li>
		</ul>
	  
		
		
	{else}
	
	   <ul class="news-upcoming">
		
			<li class="mnm-published" id="cat{$category_id}"><a id="mnms-{$link_shakebox_index}" href="javascript:{$link_shakebox_javascript_vote}">{$link_shakebox_votes}</a></li>
			<li class="menealo" id="mnmlink-{$link_shakebox_index}">			
				{if $link_shakebox_currentuser_votes eq 0}
					<a href="javascript:{$link_shakebox_javascript_vote}">{#PLIGG_Visual_Vote_For_It#}</a>
				{else}
					<span>{#PLIGG_Visual_Vote_Cast#}</span>
				{/if}
			</li>
		</ul>
	
	{/if}	
		
		
	{/if}
	
	{if $enable_categorycolors eq 'true'}
	<div class="top" id="catcol{$category_id}">
	{else}
	<div class="top" id="nocatcol">
	{/if}
	
		<h4 id="ls_title-{$link_shakebox_index}">

{if $Voting_Method eq 2}
		
		<ul class='star-rating{$star_class}' id="mnms-{$link_shakebox_index}">
			<li class="current-rating" title="Currently {$link_rating} out of 5 Stars" style="width: {$link_rating_width}px;" id="mnmlink-{$link_shakebox_index}">Currently {$link_rating} out of 5 Stars</li>
			<span id = "mnmc-{$link_shakebox_index}">
			{if $link_shakebox_currentuser_votes eq 0}
				<li><a href="javascript:{$link_shakebox_javascript_vote_1star}" title=�1 star out of 5' class='one-star'>1</a></li>
				<li><a href="javascript:{$link_shakebox_javascript_vote_2star}" title=�2 stars out of 5' class='two-stars'>2</a></li>
				<li><a href="javascript:{$link_shakebox_javascript_vote_3star}" title=�3 stars out of 5' class='three-stars'>3</a></li>
				<li><a href="javascript:{$link_shakebox_javascript_vote_4star}" title=�4 stars out of 5' class='four-stars'>4</a></li>
				<li><a href="javascript:{$link_shakebox_javascript_vote_5star}" title=�5 stars out of 5' class='five-stars'>5</a></li>
			{else}
				<li class='one-star-noh'>1</li>
				<li class='two-stars-noh'>2</li>
				<li class='three-stars-noh'>3</li>
				<li class='four-stars-noh'>4</li>
				<li class='five-stars-noh'>5</li>
			{/if}
			</span>
		</ul>
			
	{/if}


	    {if $use_title_as_link eq true}
		      {if $url_short neq "http://" && $url_short neq "://"}
				  <a href="{$url}" {if $open_in_new_window eq true} target="_blank"{/if}>{$title_short}</a>
			  {else}
			  <a href="{$story_url}">{$title_short}</a>
			  {/if}
        {else}
			<a href="{$story_url}">{$title_short}</a>
			{/if}
        </h4>

    <div class="news-submitted">
			<a href="javascript://" onclick="show_hide_user_links(document.getElementById('userlinks-{$link_shakebox_index}'));">		
				{if $UseAvatars neq "0"}<span id="ls_avatar-{$link_shakebox_index}"><img src="{$Avatar_ImgSrc}" alt="Avatar" style="border:none"/></span>{/if}
			</a>
			<span id="ls_story_link-{$link_shakebox_index}">
				{if $url_short neq "http://" && $url_short neq "://"}
					<a href="{$url}" {if $open_in_new_window eq true} target="_blank"{/if} class="screen">{$url_short}{if $use_thumbnails eq true}<b><img src="http://msnsearch.srv.girafa.com/srv/i?s=MSNSEARCH&r={$url_short}"></b>{/if}</a>
				{else}
					{$No_URL_Name}
				{/if}
			</span>
			<br />
			<span id="ls_posted_by-{$link_shakebox_index}">{#PLIGG_Visual_LS_Posted_By#} </span>
			<a href="javascript://" onclick="show_hide_user_links(document.getElementById('userlinks-{$link_shakebox_index}'));">		
				<span id="ls_link_submitter-{$link_shakebox_index}">{$link_submitter}</span></a>
			<span id="ls_timeago-{$link_shakebox_index}">{$link_submit_timeago} {#PLIGG_Visual_Comment_Ago#}
{if $Voting_Method eq 2} - <strong>Average Rating: <span id="mnma-{$link_shakebox_index}">{$link_rating}</span> with <span id="mnmb-{$link_shakebox_index}">{$vote_count}</span> vote(s)</strong>{/if}</span>

		  {if $isadmin eq "yes" || $user_logged_in eq $link_submitter}
  			<span id="adminlinksbuttom"> | <a href="javascript://" onclick="
  								var replydisplay=document.getElementById('ls_adminlinks-{$link_shakebox_index}').style.display ? '' : 'none';
  								document.getElementById('ls_adminlinks-{$link_shakebox_index}').style.display = replydisplay;
  							">admin links</a>
        </span>
		  {/if}				
			<span id="userlinks-{$link_shakebox_index}" style="display:none;">
				<a href = "{$submitter_profile_url}">{#PLIGG_Visual_LS_View_Profile#}</a>  
				{if $FriendMD5 neq ""}
					| {if $Allow_Friends eq 1}<a href ="{$user_add_remove}">{$Friend_Text} {#PLIGG_Visual_LS_My_Friends#}</a>{/if}
					
					{checkActionsTpl location="tpl_link_summary_submitter_links"}					
					
				{/if}
			</span>

			<span id="ls_adminlinks-{$link_shakebox_index}" style="display:none">
				{if $isadmin eq "yes"}
					<span id="ls_admin_links-{$link_shakebox_index}">
						<br /><a href="{$story_edit_url}">{#PLIGG_Visual_LS_Admin_Edit#}</a>
						<br /><a href="{$story_admin_url}">{#PLIGG_Visual_LS_Admin_Status#}</a>
					</span>
				{else}
				{if $user_logged_in eq $link_submitter}
					<span id="ls_user_edit_links-{$link_shakebox_index}">
						<br /><a href="{$story_edit_url}">{#PLIGG_Visual_LS_Admin_Edit#}</a>
					</span>
				{/if}
				{/if}
			</span>
    </div>

  	{if $viewtype neq "short"}
	    <span class="news-body-text">
	  		<span id="ls_contents-{$link_shakebox_index}">
	  			<br />			
			{checkActionsTpl location="tpl_link_summary_pre_story_content"}
			
			{if $show_content neq 'FALSE'}
			{$story_content}
			{/if}
			
			{if $pagename neq "story"} &nbsp;  
			<a href="{$story_url}">read more</a> 
	
			{/if}<br />  
	  				{if $Enable_Extra_Field_1 eq 1}{if $link_field1 neq ""}<br/><b>{$Field_1_Title}:</b> {$link_field1}{/if}{/if}
	  				{if $Enable_Extra_Field_2 eq 1}{if $link_field2 neq ""}<br/><b>{$Field_2_Title}:</b> {$link_field2}{/if}{/if}
	  				{if $Enable_Extra_Field_3 eq 1}{if $link_field3 neq ""}<br/><b>{$Field_3_Title}:</b> {$link_field3}{/if}{/if}
	  				{if $Enable_Extra_Field_4 eq 1}{if $link_field4 neq ""}<br/><b>{$Field_4_Title}:</b> {$link_field4}{/if}{/if}
	  				{if $Enable_Extra_Field_5 eq 1}{if $link_field5 neq ""}<br/><b>{$Field_5_Title}:</b> {$link_field5}{/if}{/if}
	  				{if $Enable_Extra_Field_6 eq 1}{if $link_field6 neq ""}<br/><b>{$Field_6_Title}:</b> {$link_field6}{/if}{/if}
	  				{if $Enable_Extra_Field_7 eq 1}{if $link_field7 neq ""}<br/><b>{$Field_7_Title}:</b> {$link_field7}{/if}{/if}
	  				{if $Enable_Extra_Field_8 eq 1}{if $link_field8 neq ""}<br/><b>{$Field_8_Title}:</b> {$link_field8}{/if}{/if}
	  				{if $Enable_Extra_Field_9 eq 1}{if $link_field9 neq ""}<br/><b>{$Field_9_Title}:</b> {$link_field9}{/if}{/if}
	  				{if $Enable_Extra_Field_10 eq 1}{if $link_field10 neq ""}<br/><b>{$Field_10_Title}:</b> {$link_field10}{/if}{/if}
	  				{if $Enable_Extra_Field_11 eq 1}{if $link_field11 neq ""}<br/><b>{$Field_11_Title}:</b> {$link_field11}{/if}{/if}
	  				{if $Enable_Extra_Field_12 eq 1}{if $link_field12 neq ""}<br/><b>{$Field_12_Title}:</b> {$link_field12}{/if}{/if}
	  				{if $Enable_Extra_Field_13 eq 1}{if $link_field13 neq ""}<br/><b>{$Field_13_Title}:</b> {$link_field13}{/if}{/if}
	  				{if $Enable_Extra_Field_14 eq 1}{if $link_field14 neq ""}<br/><b>{$Field_14_Title}:</b> {$link_field14}{/if}{/if}
	  				{if $Enable_Extra_Field_15 eq 1}{if $link_field15 neq ""}<br/><b>{$Field_15_Title}:</b> {$link_field15}{/if}{/if}  			
	  			<br />
	  		</span>
	    </span>
  	{/if}
	
    <span class="news-details" style="margin-top:-7px;">
    	<span id="ls_comments_url-{$link_shakebox_index}">
    		{if $story_comment_count eq 0}
    			<a href="{$story_url}" class="comments">{#PLIGG_MiscWords_Discuss#}</a>
    		{/if}
    		{if $story_comment_count eq 1}
    			<a href="{$story_url}" class="comments">{$story_comment_count} {#PLIGG_MiscWords_Comment#}</a>
    		{/if}
    		{if $story_comment_count gt 1}
    			<a href="{$story_url}" class="comments">{$story_comment_count} {#PLIGG_MiscWords_Comments#}</a>
    		{/if}
    	</span> | 
			{if $url_short neq "http://" && $url_short neq "://"}
				<span id="ls_trackback-{$link_shakebox_index}">
					<a href="{$trackback_url}" title="{$trackback_url}">{#PLIGG_MiscWords_Trackback#}</a>
				</span> | 
			{/if}
						
  		{if $tags ne ''}
  			<span id="ls_tags-{$link_shakebox_index}">
  				<b><a href="{$URL_tagcloud}" title="Tags" style='text-decoration: none;'>{#PLIGG_Visual_Tags_Link_Summary#}</a></b>: 
  				{section name=thistag loop=$tag_array}
  					<a href="{$tags_url_array[thistag]}" style='text-decoration: none;'>{$tag_array[thistag]}</a>
  				{/section}
  			</span> |
  		{/if}
			<span id="ls_category-{$link_shakebox_index}">
				<b><a href="{$category_url}" style='text-decoration: none;'>{#PLIGG_MiscWords_Category#}</a></b>: <a href="{$category_url}">
				{$link_category}</a>
			</span>
    	
  		{if $Enable_AddTo eq 1}
  			| <a href="javascript://" onclick="
  								var replydisplay=document.getElementById('addto-{$link_shakebox_index}').style.display ? '' : 'none';
  								document.getElementById('addto-{$link_shakebox_index}').style.display = replydisplay;">{#PLIGG_Visual_LS_AddThisLinkTo#}</a>
  		{/if}
  		
			{if $Enable_Recommend eq 1}
				{if $Recommend_Type eq 1}
					<span id="ls_recommend-{$link_shakebox_index}">
						| <a href="javascript://" onclick="show_recommend({$link_shakebox_index}, {$link_id}, '{$instpath}');">{#PLIGG_Visual_Recommend_Link_Text#}</a>
					</span> 
				{/if}
				{if $Recommend_Type eq 2}
					<span id="ls_recommend-{$link_shakebox_index}">
						| <a href="{$recommend_url}">tell a friend</a>
					</span> 
				{/if}
			{/if}		
			
  		{if $story_status ne 'discard' && $link_shakebox_currentuser_votes eq 0 && $link_shakebox_currentuser_reports eq 0}
  			{if $user_logged_in eq '' && $allow_anonymous_reporting eq 0}
  			
  			{else}
  
  			{/if}
  		{/if}
  		{if $link_shakebox_currentuser_reports ne 0}
  
  		{/if}
  		{if $Enable_AddTo eq 1}
	      <span id="addto-{$link_shakebox_index}" style="display:none"><br />{#PLIGG_Visual_LS_AddTo#}
&nbsp;&nbsp;<a title="submit '{$title_short}' to del.icio.us" href="http://del.icio.us/post" onclick="window.open('http://del.icio.us/post?v=4&amp;noui&amp;jump=close&amp;url={$enc_url}&amp;title={$enc_title_short}', '{#PLIGG_Visual_LS_Delicious#}','toolbar=no,width=700,height=400'); return false;"><img src="{$my_base_url}{$my_pligg_base}/templates/{$the_template}/images/delicious.png" border="0"></a>
&nbsp;&nbsp; <a title="submit '{$title_short}' to digg" href="http://digg.com/submit?phase=2&url={$enc_url}&title={$title_short}&bodytext={$story_content}"><img src="{$my_base_url}{$my_pligg_base}/templates/{$the_template}/images/digg.png" border="0"></a>
 &nbsp;&nbsp;<a title="submit '{$title_short}' to reddit" href="http://reddit.com/submit?url={$enc_url}&title={$title_short}"><img src="{$my_base_url}{$my_pligg_base}/templates/{$the_template}/images/reddit.gif" border="0"></a>
 &nbsp;&nbsp;<a title="submit '{$title_short}' to simpy" href="http://www.simpy.com/simpy/LinkAdd.do?href={$enc_url}&title={$title_short}"><img src="{$my_base_url}{$my_pligg_base}/templates/{$the_template}/images/simpy.png" border="0"></a>
 &nbsp;&nbsp;<a title="submit '{$title_short}' to yahoo" href="http://myweb2.search.yahoo.com/myresults/bookmarklet?u={$enc_url}&title={$title_short}"><img src="{$my_base_url}{$my_pligg_base}/templates/{$the_template}/images/yahoomyweb.png" border="0"></a>
 &nbsp;&nbsp;|&nbsp;&nbsp; <a href="javascript:bookmarksite('{$enc_title_short}', '{$enc_url}')">{#PLIGG_Visual_LS_Fav_Book#}</a>
 &nbsp;&nbsp;</span>
  		{/if}
			{if $Enable_Recommend eq 1}
				{if $Recommend_Type eq 1}
					<span id="emailto-{$link_shakebox_index}" style="display:none"></span>
				{/if}
			{/if}
			
    </span>
	</div>
</div>
<br />

