{config_load file="/libs/lang.conf"}

<script src="{$my_pligg_base}/templates/{$the_template}/js/submit.js{if $enable_gzip_files eq 'true'}.gz{/if}" type="text/javascript"></script>

<form action="" method="post" id="thisform">
	<input type="hidden" name="id" value="{$submit_id}" />

	<fieldset><legend>{#PLIGG_Visual_Submit2_Source#}</legend>
		<p class="l-top"><label for="url" accesskey="2">{#PLIGG_Visual_Submit2_NewsURL#}:</label>
			<a href="{$submit_url}" class="simple">{$submit_url}</a></p>
			{if $isAdmin eq 1}<input type = "text" name = "url" size=60 value = "{$submit_url}"><br />{/if}	<br />
			<p class="l-top"><label for="url_title" accesskey="2">{#PLIGG_Visual_Submit2_URLTitle#}:</label>{$submit_url_title}
		</p>
	</fieldset>		

	<fieldset><legend>{#PLIGG_Visual_Submit2_Details#}</legend>
		<p class="l-mid"><label for="title" accesskey="1">{#PLIGG_Visual_Submit2_Title#}:</label>
		<span class="form-note">{#PLIGG_Visual_Submit2_TitleInstruct#}</span>
		<br/><input type="text" id="title" name="title" value="{$submit_title}" size="60" maxlength="120" />
		</p>
		
		<br />

		{if $enable_tags eq 'true'}
			<p class="l-mid">
				<label for="tags" accesskey="4">{#PLIGG_Visual_Submit2_Tags#}:</label>
				<span class="form-note"><strong>{#PLIGG_Visual_Submit2_Tags_Inst1#}</strong> {#PLIGG_Visual_Submit2_Tags_Example#} <em>{#PLIGG_Visual_Submit2_Tags_Inst2#}</em></span>
				<br/><input type="text" id="tags" name="tags" value="{$tags_words}" size="40" maxlength="200" />
			</p>
		{/if}
		
		<br />
		
		<p class="l-mid"><label for="bodytext" accesskey="1">{#PLIGG_Visual_Submit2_Description#}</label>
		<span class="form-note">{#PLIGG_Visual_Submit2_DescInstruct#}</span>
			{if $Story_Content_Tags_To_Allow eq ""}
				<br /><b>{#PLIGG_Visual_Submit2_No_HTMLTagsAllowed#}</b> {#PLIGG_Visual_Submit2_HTMLTagsAllowed#}
			{else}
				<br />{#PLIGG_Visual_Submit2_HTMLTagsAllowed#}: {$Story_Content_Tags_To_Allow}
			{/if}
		<br/><textarea name="bodytext" rows="10" cols="60" id="bodytext" WRAP=SOFT onkeyup="if(this.form.summarycheckbox.checked == false) {ldelim}this.form.summarytext.value = this.form.bodytext.value.substring(0, {$StorySummary_ContentTruncate});{rdelim}textCounter(this.form.summarytext,this.form.remLen, {$StorySummary_ContentTruncate});">{$submit_content}</textarea><br />
		{if $Spell_Checker eq 1}<input type="button" name="spelling" value="{#PLIGG_Visual_Check_Spelling#}" class="log2" onClick="openSpellChecker('bodytext');"/>{/if} 
		</p>
		
		<br />
		
		{if $SubmitSummary_Allow_Edit eq 1}  
		<p class="l-mid">
		<label for="summarytext" accesskey="1">{#PLIGG_Visual_Submit2_Summary#}:</label>
		<span class="form-note">{#PLIGG_Visual_Submit2_SummaryInstruct#}{#PLIGG_Visual_Submit2_SummaryLimit#}{$StorySummary_ContentTruncate}{#PLIGG_Visual_Submit2_SummaryLimitCharacters#}</span>
		<br /><input type = "checkbox" name = "summarycheckbox" id = "summarycheckbox" onclick="SetState(this, this.form.summarytext)" checked> {#PLIGG_Visual_Submit2_SummaryCheckBox#}
			{if $Story_Content_Tags_To_Allow eq ""}
				<br /><b>{#PLIGG_Visual_Submit2_No_HTMLTagsAllowed#}</b> {#PLIGG_Visual_Submit2_HTMLTagsAllowed#}
			{else}
				<br />{#PLIGG_Visual_Submit2_HTMLTagsAllowed#}: {$Story_Content_Tags_To_Allow}
			{/if}
		<br/><textarea name="summarytext"  rows="5" cols="60" id="summarytext" WRAP=SOFT onKeyDown="textCounter(this.form.summarytext,this.form.remLen, {$StorySummary_ContentTruncate});">{$submit_summary}</textarea><br />
		<input readonly type=text name=remLen size=3 maxlength=3 value="{$StorySummary_ContentTruncate}">{#PLIGG_Visual_Submit2_SummaryCharactersLeft#}
		{if $Spell_Checker eq 1}<input type="button" name="spelling" value="{#PLIGG_Visual_Check_Spelling#}" class="submit" onClick="openSpellChecker('summarytext');"/>{/if}
		<br /><br />
		</p>
		{/if}
		
		<br />
		
		<p class="l-mid">
		<label for="category" accesskey="1">{#PLIGG_Visual_Submit2_Category#}:</label>
		<span class="form-note">{#PLIGG_Visual_Submit2_CatInstruct#}</span><br/>
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
		</p>
		
		<br />
		
		{if $canIhaveAccess eq 1}
			<label for="notify" accesskey="1">{#PLIGG_Visual_EditStory_Notify#}:</label>
			<input type="checkbox" name="notify" value="yes">{#PLIGG_Visual_EditStory_NotifyText#}<br/>
			&nbsp;&nbsp;<input type="radio" name="reason" value="typo" onclick="notify.checked = 'true';">{#PLIGG_Visual_EditStory_Reason_typo#}<br/>
			&nbsp;&nbsp;<input type="radio" name="reason" value="category" onclick="notify.checked = 'true';">{#PLIGG_Visual_EditStory_Reason_category#}<br/>
			&nbsp;&nbsp;<input type="radio" name="reason" value="tags" onclick="notify.checked = 'true';">{#PLIGG_Visual_EditStory_Reason_tags#}<br/>
			&nbsp;&nbsp;<input type="radio" name="reason" value="foul" onclick="notify.checked = 'true';">{#PLIGG_Visual_EditStory_Reason_foul#}<br/>
			&nbsp;&nbsp;<input type="radio" name="reason" value="other" onclick="notify.checked = 'true';">{#PLIGG_Visual_EditStory_Reason_other#} <input type="text" name="otherreason" size="75"><br/>
			<br/>
		{/if}
		
		{include file=$tpl_extra_fields.".tpl"}
		
		<br />
		
		<p class="l-mid"><input type="submit" value="{#PLIGG_Visual_Submit2_Continue#}" class="log2" />
		
	</fieldset>
</form>