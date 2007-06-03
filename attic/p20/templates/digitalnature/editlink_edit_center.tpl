{config_load file="/libs/lang.conf"}
<script src="{$my_pligg_base}/templates/{$the_template}/js/submit.js.gz" type="text/javascript"></script>
<form action="" method="post" id="thisform">
	<input type="hidden" name="id" value="{$submit_id}" />

	<fieldset><legend>{#PLIGG_Visual_Submit2_Source#}</legend>
	<br />
	<label for="url" accesskey="2">{#PLIGG_Visual_Submit2_NewsURL#}:</label>
	<a href="{$submit_url}" class="simple">{$submit_url}</a><br />
	{if $isAdmin eq 1}
 	<input type = "text" name = "url" size=60 value = "{$submit_url}"><br />
 	{/if}
	<br />	
	<label for="url_title" accesskey="2">{#PLIGG_Visual_Submit2_URLTitle#}:</label>
	{$submit_url_title}
		
	</fieldset>
		
	<br /><br />

	
	
	<fieldset>
		<legend>{#PLIGG_Visual_Submit2_Details#}</legend>
		<br />
		<strong>{#PLIGG_Visual_Submit2_Title#}:</strong><br/>
		<input type="text" id="title" name="title" value="{$submit_title}" size="60" maxlength="120" />
		
		<br /><br />

		{if $enable_tags eq 'true'}
		<strong>{#PLIGG_Visual_Submit2_Tags#}:</strong>
		<br/><input type="text" id="tags" name="tags" value="{$tags_words}" size="40" maxlength="200" />			
		{/if}
		
		<br /><br />
		<strong>{#PLIGG_Visual_Submit2_Description#}</strong>
		{if $Story_Content_Tags_To_Allow eq ""}<br /><b>No</b> HTML tags allowed
		{else}<br />HTML tags allowed: {$Story_Content_Tags_To_Allow}
		{/if}
			
		<br/><textarea name="bodytext" rows="10" cols="60" id="bodytext" WRAP=SOFT onkeyup="if(this.form.summarycheckbox.checked == false) {ldelim}this.form.summarytext.value = this.form.bodytext.value.substring(0, {$StorySummary_ContentTruncate});{rdelim}textCounter(this.form.summarytext,this.form.remLen, {$StorySummary_ContentTruncate});">{$submit_content}</textarea><br />
			{if $Spell_Checker eq 1 || $Spell_Checker eq 2}<input type="button" name="spelling" value="Check Spelling" class="log2" onClick="openSpellChecker('bodytext');"/>{/if} 
		</p>
		<br /><br />
		{if $SubmitSummary_Allow_Edit eq 1}  
	   <strong>{#PLIGG_Visual_Submit2_Summary#}:</strong>			{#PLIGG_Visual_Submit2_SummaryInstruct#}{#PLIGG_Visual_Submit2_SummaryLimit#}{$StorySummary_ContentTruncate}{#PLIGG_Visual_Submit2_SummaryLimitCharacters#}
			<br /><input align="left" type = "checkbox" name = "summarycheckbox" id = "summarycheckbox" onclick="SetState(this, this.form.summarytext)" checked> {#PLIGG_Visual_Submit2_SummaryCheckBox#}
			{if $Story_Content_Tags_To_Allow eq ""}<br /><b>No</b> {#PLIGG_Visual_Submit2_HTMLTagsAllowed#}
			{else}<br />{#PLIGG_Visual_Submit2_HTMLTagsAllowed#}: {$Story_Content_Tags_To_Allow}
			{/if}
			<br/><textarea name="summarytext"  rows="5" cols="60" id="summarytext" WRAP=SOFT onKeyDown="textCounter(this.form.summarytext,this.form.remLen, {$StorySummary_ContentTruncate});">{$submit_summary}</textarea><br />
			<input readonly type=text name=remLen size=3 maxlength=3 value="125">{#PLIGG_Visual_Submit2_SummaryCharactersLeft#}
			{if $Spell_Checker eq 1}<br /><input type="button" name="spelling" value="Check Spelling" class="submit" onClick="openSpellChecker('summarytext');"/>{/if}
			<br /><br />
		</p>
		{/if}
		<br />
	
		<strong>{#PLIGG_Visual_Submit2_Category#}:</strong>	{#PLIGG_Visual_Submit2_CatInstruct#}<br />
			<select name="category" length="50">
	{section name=thecat loop=$cat_array}
	   <option value = "{$cat_array[thecat].auto_id}"{if $cat_array[thecat].auto_id eq $submit_category} selected="selected"{/if}>
		  {if $cat_array[thecat].spacercount lt $lastspacer}{$cat_array[thecat].spacerdiff|repeat_count:''}{/if}
		  {if $cat_array[thecat].spacercount gt $lastspacer}{/if}
		  {$cat_array[thecat].spacercount|repeat_count:'&nbsp;&nbsp;&nbsp;'}
		  {$cat_array[thecat].name} 
		  &nbsp;&nbsp;&nbsp;       
		  {assign var=lastspacer value=$cat_array[thecat].spacercount}
		   	
	  </option>
	{/section}
</select>
		
		<br style="clear: both;" />
		<br />
		{if $canIhaveAccess eq 1}
		<br />
			<strong>{#PLIGG_Visual_EditStory_Notify#}:</strong><br />
			<input type="checkbox" name="notify" value="yes"> {#PLIGG_Visual_EditStory_NotifyText#}<br/>
				<input type="radio" name="reason" value="typo" onclick="notify.checked = 'true';">{#PLIGG_Visual_EditStory_Reason_typo#}<br/>
				<input type="radio" name="reason" value="category" onclick="notify.checked = 'true';">{#PLIGG_Visual_EditStory_Reason_category#}<br/>
				<input type="radio" name="reason" value="tags" onclick="notify.checked = 'true';">{#PLIGG_Visual_EditStory_Reason_tags#}<br/>
				<input type="radio" name="reason" value="foul" onclick="notify.checked = 'true';">{#PLIGG_Visual_EditStory_Reason_foul#}<br/>
				<input type="radio" name="reason" value="other" onclick="notify.checked = 'true';">{#PLIGG_Visual_EditStory_Reason_other#} 
				<input type="text" name="otherreason" size="75"><br/>
			<br/>
		{/if}
		{include file=$tpl_extra_fields.".tpl"}
		<br />
		<p class="l-mid">
		<input type="submit" value="{#PLIGG_Visual_Submit2_Continue#}" class="log2" />
		</p>
	</form>
</fieldset>
