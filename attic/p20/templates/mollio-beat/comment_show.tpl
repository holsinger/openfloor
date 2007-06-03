{* load language file *}
{config_load file="/libs/lang.conf"}

<li>
  <div id="comment-wrap">
    <div id="comment-head"> 
	
	{* display user's avatar *}
      {if $UseAvatars neq "0"}<span id="ls_avatar-{$link_shakebox_index}" style="padding:0 0 0 4px;"> <img src="{$Avatar_ImgSrc}" alt="Avatar"/></span> {/if}
      
      {* display who wrote the comment and how long ago they wrote it *}
      | {#PLIGG_Visual_Comment_WrittenBy#} <a href="{$user_view_url}">{$user_username}</a> {$comment_age} {#PLIGG_Visual_Comment_Ago#} <span id="comment-subhead"> 
	  
	  {* if comment voting is enabled *}	
      {if $Enable_Comment_Voting eq 1}
      
      {* display the current number of votes *}
      Rating: <a id="cvote-{$comment_id}" style='text-decoration: none';>{$comment_votes}</a> 
	  
	  {* if you're viewing someone elses comment and if you haven't voted for it yet *}
      {if $comment_user_vote_count eq 0 && $current_userid neq $comment_author}
      | <span id="ratetext-{$comment_id}">Rate comment:</span> <span id="ratebuttons-{$comment_id}"> 
	  
	  {* display positive vote link *}
	   <a class="ratemey" href="javascript:{$link_shakebox_javascript_votey}" style='text-decoration:none;'><span class="rateme">+</span></a> 
	   
	   {* display negative vote link *} 
	   <a class="ratemen" href="javascript:{$link_shakebox_javascript_voten}" style='text-decoration:none;'><span class="rateme">-</span></a> </span> {/if}
      {/if} </span> </div>
	  
    {* display comment content *}
    <div class="comment-body" id="wholecomment{$comment_id}"> 
	
	{* display comment content if the comment votes are greater than or equal to 0 *}
      {if $comment_votes gte 0} <span id = "comment_content-{$comment_id}"> <br />
      {$comment_content} </span> 
	  
	  {* if comment votes are less than 0 do not display comment content *}
      {else}
      
      {* display "show/hide" link *} 
	  <span id = "show_hide_comment_content-{$comment_id}"> | <a href = "javascript://"  onclick="var replydisplay=document.getElementById('comment_content-{$comment_id}').style.display ? '' : 'none'; document.getElementById('comment_content-{$comment_id}').style.display = replydisplay;">show/hide</a> this comment </span> <span id = "comment_content-{$comment_id}" style="display:none"> <br />
      {$comment_content} </span> {/if} </div>
	  
	  
    {* display comment form if replying to a comment *}
    <div class="comment-info"> 
	{if $comment_parent eq 0 && $current_userid neq 0} 
	<a href = "javascript://" onClick="var replydisplay=document.getElementById('reply-{$comment_id}').style.display ? '' : 'none'; document.getElementById('reply-{$comment_id}').style.display = replydisplay;">Reply</a>
      <div id="reply-{$comment_id}" style="display:none;"> 
	  
	  {* comment form for replying to a comment *}
        <div id="commentform" align="left">
          <form action="" method="POST" id="thisform" style="display:inline;">
            <fieldset>
            <legend>{#PLIGG_Visual_Comment_Send#}</legend>
            <div id="cformfieldset"> 
			
			{* display allowed HTML tags *}
              <label for="comment" accesskey="2" style="float:left"> {#PLIGG_Visual_Comment_NoHTML#}</label>
              <br />
              <br/>
			  
              {* comment textarea *}
              <textarea name="reply_comment_content-{$comment_id}" id="reply_comment_content-{$comment_id}" rows="3" cols="55"/>
              {$TheComment}
              </textarea>
              <br/>
			  
			  
              {* display spellcheck button if spellchecker is enabled *}
              {if $Spell_Checker eq 1 or $Spell_Checker eq 2}
              <input type="button" name="spelling" value="Check Spelling" onClick="openSpellChecker('reply_comment_content-{$comment_id}');" class="log2"/>
              {/if}
              
              {* display submit button *}
              <input type="submit" name="submit" value="{#PLIGG_Visual_Comment_Submit#}" class="log2" />
			  
              {* additional hidden inputs for submitting a comment *}
              <input type="hidden" name="process" value="newcomment" />
              <input type="hidden" name="randkey" value="{php}echo rand(1000000,100000000);{/php}" />
              <input type="hidden" name="link_id" value="{$comment_link}" />
              <input type="hidden" name="comment_parent_id" value="{$comment_id}" />
              <input type="hidden" name="user_id" value="{$current_userid}" />
            </div>
            </fieldset>
          </form>
        </div>
      </div>
      {/if}	
      
      
      {* display the edit link if admin or if it is your comment *}
      {if $hide_comment_edit neq 'yes'}
	  
      {if $isadmin eq 1}
      | <a href="{$edit_comment_url}">{#PLIGG_Visual_Comment_Edit#}</a> {else}
	  
      {if $user_username eq 'you'}
      | <a href="{$edit_comment_url}">{#PLIGG_Visual_Comment_Edit#}</a> {/if}
      {/if}
      {/if} 
	  </div>
  </div>
  <br />
</li>
