<fieldset><legend>{#PLIGG_Visual_Submit1_NewsSource#}</legend>
	<form action="{$URL_submit}" method="post" id="thisform">
		<label for="url">{#PLIGG_Visual_Submit1_NewsURL#}:</label>
		{* What does this do?
			<label for="url" accesskey="2"  class="inside">http://</label>
		*}
		<input type="text" name="url" id="url" value="http://" size=55 class="form-full" />
		<input type="hidden" name="phase" value=1>
		<input type="hidden" name="randkey" value="{$submit_rand}">
		<input type="hidden" name="id" value="c_1">
		<input type="submit" value="{#PLIGG_Visual_Submit1_Continue#}" class="submit-s" />
	</form>
	<br />{if $Submit_Require_A_URL neq 1}{#PLIGG_Visual_Submit_Editorial#}{/if}
</fieldset>
