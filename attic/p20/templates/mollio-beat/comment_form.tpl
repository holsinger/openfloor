{* load language file *}
{config_load file="/libs/lang.conf"}

{* comment form *}
<div id="commentform" align="left">
	<form action="" method="POST" id="thisform" style="display:inline;">
		<fieldset><legend>{#PLIGG_Visual_Comment_Send#}</legend>		
			
					{* display allowed HTML tags *}
					<label for="comment" accesskey="2" style="float:left; margin-bottom:-5px;">								{#PLIGG_Visual_Comment_NoHTML#}
					</label><br /><br />

					{* comment textarea *}
					<textarea name="comment_content" id="comment" rows="3" cols="{$form_cols}"/>{$TheComment}</textarea><br />
					
					{* display spell checker button is spell checker is enabled *}
					{if $Spell_Checker eq 1 or $Spell_Checker eq 2}<input type="button" name="spelling" 						value="check spelling" class="log2" onClick="openSpellChecker('comment');"/>
					{/if}

					{* display submit button*}
					<input type="submit" name="submit" value="{#PLIGG_Visual_Comment_Submit#}" class="log2" />

					{* additional hidden inputs for submitting a comment *}
					<input type="hidden" name="process" value="newcomment" />
					<input type="hidden" name="randkey" value="{$randkey}" />
					<input type="hidden" name="link_id" value="{$link_id}" />
					<input type="hidden" name="user_id" value="{$user_id}" />
				
		</fieldset>
	</form>
</div>