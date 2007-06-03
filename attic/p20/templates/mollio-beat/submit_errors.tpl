{config_load file="/libs/lang.conf"}
{*Step 2 Errors*}

{if $submit_error eq 'invalidurl'}
	<p class="error"><strong>{#PLIGG_Visual_Submit2Errors_InvalidURL#}:</strong> ({$submit_url})</p>
	<p>{#PLIGG_Visual_Submit2Errors_TryAgain#}</p>
	<form id="thisform">
		<input type="button" onclick="window.history.go(-1)" value="{#PLIGG_Visual_Submit2Errors_Back#}" class="submit">
	</form>
{/if}

{if $submit_error eq 'dupeurl'}
	<p class="error"><strong>{#PLIGG_Visual_Submit2Errors_DupeArticleURL#}:</strong></p>
	<p>{#PLIGG_Visual_Submit2Errors_DupeArticleURL_Instruct#}</p>
	<a href="{$submit_search}"><strong>{#PLIGG_Visual_Submit2Errors_DupeArticleURL_Instruct2#}:</strong></a></p>
	<br style="clear: both;" /><br style="clear: both;" />
	<form id="thisform">
	<input type=button onclick="window.history.go(-1)" value="{#PLIGG_Visual_Submit2Errors_Back#}" class="submit" />
	</form>
{/if}

{*Step 3 Errors*}

{if $submit_error eq 'badkey'}
	<p class="error"><strong>{#PLIGG_Visual_Submit3Errors_BadKey#}</strong></p>
	<p>{#PLIGG_Visual_Submit3Errors_TryAgain#}</p>
	<form id="thisform">
		<input type="button" onclick="window.history.go(-1)" value="{#PLIGG_Visual_Submit3Errors_Back#}" class="submit" />
	</form>
{/if}

{if $submit_error eq 'hashistory'}
	<p class="error"><strong>{#PLIGG_Visual_Submit3Errors_HasHistory#}: {$submit_error_history}</strong></p>
	<p>{#PLIGG_Visual_Submit3Errors_TryAgain#}</p>
	<form id="thisform">
		<input type="button" onclick="window.history.go(-1)" value="{#PLIGG_Visual_Submit3Errors_Back#}" class="submit" />
	</form>
{/if}

{if $submit_error eq 'urlintitle'}
	<p class="error"><strong>{#PLIGG_Visual_Submit3Errors_URLInTitle#}</strong></p>
	<p>{#PLIGG_Visual_Submit3Errors_TryAgain#}</p>
	<form id="thisform">
		<input type="button" onclick="window.history.go(-1)" value="{#PLIGG_Visual_Submit3Errors_Back#}" class="submit" />
	</form>
{/if}

{if $submit_error eq 'incomplete'}
	<p class="error"><strong>{#PLIGG_Visual_Submit3Errors_Incomplete#}</strong></p>
	<p>{#PLIGG_Visual_Submit3Errors_TryAgain#}</p>
	<form id="thisform">
		<input type="button" onclick="window.history.go(-1)" value="{#PLIGG_Visual_Submit3Errors_Back#}" class="submit" />
	</form>
{/if}

{if $submit_error eq 'nocategory'}
	<p class="error"><strong>{#PLIGG_Visual_Submit3Errors_NoCategory#}</strong></p>
	<p>{#PLIGG_Visual_Submit3Errors_TryAgain#}</p>
	<form id="thisform">
		<input type="button" onclick="window.history.go(-1)" value="{#PLIGG_Visual_Submit3Errors_Back#}" class="submit" />
	</form>
{/if}
