{config_load file="/libs/lang.conf"}
<div id="commentform" align="left">
	<form action="" method="POST" id="thisform" style="display:inline;">
		<fieldset><legend><span class="sign">{#PLIGG_Visual_Comment_Send#}</span></legend>
			<div id="cformfieldset">
				<p style="margin-left:3px">
					<label for="comment" accesskey="2" style="float:left; margin-bottom:-5px;">{#PLIGG_Visual_Comment_NoHTML#}</label>
					<p class="l-top-s"><br /><br />
					<textarea name="comment_content" id="comment" rows="3" cols="{$form_cols}"/>{$TheComment}</textarea><br />
					{if $Spell_Checker eq 1 or $Spell_Checker eq 2}<input type="button" name="spelling" value="check spelling" class="log2" onClick="openSpellChecker('comment');"/>{/if}
					<input type="submit" name="submit" value="{#PLIGG_Visual_Comment_Submit#}" class="log2" />
					<input type="hidden" name="process" value="newcomment" />
					<input type="hidden" name="randkey" value="{$randkey}" />
					<input type="hidden" name="link_id" value="{$link_id}" />
					<input type="hidden" name="user_id" value="{$user_id}" />
				</p>
			</div>
		</fieldset>
	</form>
</div>
