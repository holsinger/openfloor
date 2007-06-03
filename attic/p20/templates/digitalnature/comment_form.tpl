{config_load file="/libs/lang.conf"}
<div id="commentform" align="left">
	<form action="" method="POST" id="thisform" style="display:inline;">
		<fieldset><legend>{#PLIGG_Visual_Comment_Send#}</legend>
		<br />

				<p>{#PLIGG_Visual_Comment_NoHTML#}</p><br />
					<textarea name="comment_content" id="comment" rows="3" cols="{$form_cols}"/>{$TheComment}</textarea><br />
					
					<table>
					<tr>
					{if $Spell_Checker eq 1 or $Spell_Checker eq 2}<td><input type="button" name="spelling" value="check spelling" class="log2" onClick="openSpellChecker('comment');"/></td><td>&nbsp;&nbsp;&nbsp;</td>{/if}
					<td><input type="submit" name="submit" value="{#PLIGG_Visual_Comment_Submit#}" class="log2" /></td>
					</tr>
					</table>
					<input type="hidden" name="process" value="newcomment" />
					<input type="hidden" name="randkey" value="{$randkey}" />
					<input type="hidden" name="link_id" value="{$link_id}" />
					<input type="hidden" name="user_id" value="{$user_id}" />
				
	
		</fieldset>
	</form>
</div>
<br /><br />