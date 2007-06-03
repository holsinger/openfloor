{config_load file="/libs/lang.conf"}
<li>
<div class="comment-wrap">
  <div class="comment-head">
    <div class="cleft">

	     {if $UseAvatars neq "0"}
     	 <span id="ls_avatar-{$link_shakebox_index}" class="left"><img src="{$Avatar_ImgSrc}" style="padding-top:2px;"/></span>
		 {/if}
		 <span class="details">
         | {#PLIGG_Visual_Comment_WrittenBy#} <a href="{$user_view_url}">{$user_username}</a> {$comment_age} {#PLIGG_Visual_Comment_Ago#}	
          <span class="comment-subhead">
		  {if $Enable_Comment_Voting eq 1}
            - Rating: <a id="cvote-{$comment_id}" style='text-decoration: none';>{$comment_votes}</a>
		    {if $comment_user_vote_count eq 0 && $current_userid neq $comment_author}
		    | <span id="ratetext-{$comment_id}">Rate comment:</span>
		 	  <span id="ratebuttons-{$comment_id}">
		 		<a class="ratemey" href="javascript:{$link_shakebox_javascript_votey}" style='text-decoration: none;'><span class="rateme">+</span></a>
				<a class="ratemen" href="javascript:{$link_shakebox_javascript_voten}" style='text-decoration: none;'><span class="rateme">-</span></a>
				{/if}
				{if $comment_votes gte 0}{else}
				<span id = "show_hide_comment_content-{$comment_id}"> | <a href = "javascript://"  onclick="	var replydisplay=document.getElementById('comment_content-{$comment_id}').style.display ? '' : 'none';
			document.getElementById('comment_content-{$comment_id}').style.display = replydisplay;
			">show/hide</a> this comment </span>
			{/if}
		  	  </span>
			
		  {/if}
{if $hide_comment_edit neq 'yes'}
			{if $isadmin eq 1}
				| <a href="{$edit_comment_url}">{#PLIGG_Visual_Comment_Edit#}</a>
			{else}
				{if $user_username eq 'you'}
					| <a href="{$edit_comment_url}">{#PLIGG_Visual_Comment_Edit#}</a>
				{/if}
			{/if}
			
		{/if}		
	      </span>
		 </span>


     </div>
  </div> 
  <div class="comment-body" id="wholecomment{$comment_id}">			
		{if $comment_votes gte 0}
			<span id = "comment_content-{$comment_id}">
				<br />{$comment_content}
			</span>
		{else}
			
			<span id = "comment_content-{$comment_id}" style="display:none">
				<br />{$comment_content}
			</span>
		{/if}
  </div>
  
  <div class="comment-info">
	{if $comment_parent eq 0 && $current_userid neq 0}
	    <p class="links" align="right">
	    <a href = "javascript://" onclick="var replydisplay=document.getElementById('reply-{$comment_id}').style.display ? '' : 'none';
			document.getElementById('reply-{$comment_id}').style.display = replydisplay;">Reply</a>

		
		</p>	
  		<div id="reply-{$comment_id}" style="display:none;">
  			<div id="commentform" align="left">
  				<form action="" method="POST" id="thisform" style="display:inline;">
  					<fieldset>
					  <legend>{#PLIGG_Visual_Comment_Send#}</legend>
				  	   <br />
  					   <p>{#PLIGG_Visual_Comment_NoHTML#}</p><br />
  		
  								<textarea name="reply_comment_content-{$comment_id}" id="reply_comment_content-{$comment_id}" rows="3" cols="55"/>{$TheComment}</textarea><br/>
								
								<table>
								<tr>
								{if $Spell_Checker eq 1 or $Spell_Checker eq 2}<td><input type="button" name="spelling" value="Check Spelling" onClick="openSpellChecker('reply_comment_content-{$comment_id}');" class="log2"/></td><td>&nbsp;&nbsp;&nbsp;</td>{/if}
  								<td><input type="submit" name="submit" value="{#PLIGG_Visual_Comment_Submit#}" class="log2" /></td>
								</tr>
								</table>
  								<input type="hidden" name="process" value="newcomment" />
  								<input type="hidden" name="randkey" value="{php}echo rand(1000000,100000000);{/php}" />
  								<input type="hidden" name="link_id" value="{$comment_link}" />
  								<input type="hidden" name="comment_parent_id" value="{$comment_id}" />
  								<input type="hidden" name="user_id" value="{$current_userid}" />
								<br />
  					</fieldset>
  				</form>
  			</div>
  		</div>
	{/if}	

  </div>		
</div><br />
</li>