{config_load file="/libs/lang.conf"}

<script src="{$my_pligg_base}/templates/{$the_template}/js/submit.js.gz" type="text/javascript"></script>

<h2>{#PLIGG_Visual_Submit2_Header#}</h2>
<form action="{$URL_submit}" method="post" name="thisform" id="thisform">

	<input type="hidden" name="url" id="url" value="{$submit_url}" />
	<input type="hidden" name="phase" value="2" />
	<input type="hidden" name="randkey" value="{$randkey}" />
	<input type="hidden" name="id" value="{$submit_id}" />
	<br />
	{if $Submit_Show_URL_Input eq 1}
		<fieldset><legend>{#PLIGG_Visual_Submit2_Source#}</legend>
		
		    
			<table cellspacing="5">
			<tr>
			<td><strong>{#PLIGG_Visual_Submit2_NewsURL#}:</strong></td>
			<td><a href="{$submit_url}" class="simple">{$submit_url}</a></td>
			</tr>
			
			{if $submit_url_title neq "1"}
			<tr>
			<td><strong>{#PLIGG_Visual_Submit2_URLTitle#}:</strong></td>
			<td>{$submit_url_title} {if $submit_type eq 'blog'}&nbsp;&nbsp;&nbsp;<strong>({#PLIGG_Visual_Submit2_IsBlog#})</strong>{/if}</td>
			
			</tr>
			<br />
			{/if}
			</table>
			<br />
		</fieldset>
	{/if}
	<br />
	<fieldset>
		<legend>{#PLIGG_Visual_Submit2_Details#}</legend><br />
		<strong>{#PLIGG_Visual_Submit2_Title#}</strong> ({#PLIGG_Visual_Submit2_TitleInstruct#})<br />
		<input type="text" id="title" class="text" name="title" onclick="clearText(this, '{$submit_url_title}')" onblur="restoreText(this,'{$submit_url_title}')" value="{$submit_url_title}" size="60" maxlength="100" />
			
		
		
		{if $enable_tags eq 'true'}
		<br /><br />
			 <strong>{#PLIGG_Visual_Submit2_Tags#}</strong> ({#PLIGG_Visual_Submit2_Tags_Inst1#}) {#PLIGG_Visual_Submit2_Tags_Example#} <em>{#PLIGG_Visual_Submit2_Tags_Inst2#}</em><br />
				<input type="text" id="tags" name="tags" value="{$tags_words}" size="60" maxlength="40" />
			<br/>
		{/if}
   
   <br />
		<strong>{#PLIGG_Visual_Submit2_Description#}</strong> ({#PLIGG_Visual_Submit2_DescInstruct#}) <br />
			{if $Story_Content_Tags_To_Allow eq ""} <b>No</b> {#PLIGG_Visual_Submit2_HTMLTagsAllowed#}
			{else} {#PLIGG_Visual_Submit2_HTMLTagsAllowed#}: {$Story_Content_Tags_To_Allow}
			{/if}		
		<br />

			<textarea name="bodytext" rows="10" cols="60" id="bodytext" WRAP=SOFT onkeyup="if(this.form.summarycheckbox.checked == false) {ldelim}this.form.summarytext.value = this.form.bodytext.value.substring(0, {$StorySummary_ContentTruncate});{rdelim}textCounter(this.form.summarytext,this.form.remLen, {$StorySummary_ContentTruncate});">{$submit_content}</textarea><br />
			{if $Spell_Checker eq 1 or $Spell_Checker eq 2}<input type="button" name="spelling" value="Check Spelling" class="submit" onClick="openSpellChecker('bodytext');"/>{/if}
			<br />
			
			
			
	{if $SubmitSummary_Allow_Edit eq 1}  
	<input type = "checkbox" class="check" name = "summarycheckbox" id = "summarycheckbox" onclick="SetState(this, this.form.summarytext)">{#PLIGG_Visual_Submit2_SummaryCheckBox#} <br />
	
<strong>{#PLIGG_Visual_Submit2_Summary#}</strong> ({#PLIGG_Visual_Submit2_SummaryInstruct#}{#PLIGG_Visual_Submit2_SummaryLimit#}{$StorySummary_ContentTruncate}{#PLIGG_Visual_Submit2_SummaryLimitCharacters#})<br /> {if $Story_Content_Tags_To_Allow eq ""} <b>No</b> {#PLIGG_Visual_Submit2_HTMLTagsAllowed#}
			{else} {#PLIGG_Visual_Submit2_HTMLTagsAllowed#}: {$Story_Content_Tags_To_Allow}
			{/if}<br />
			<textarea disabled="true" name="summarytext"  rows="5" cols="60" id="summarytext" WRAP=SOFT onKeyDown="textCounter(this.form.summarytext,this.form.remLen, {$StorySummary_ContentTruncate});">{$submit_summary}</textarea><br />
			<input readonly type=text name=remLen size=3 maxlength=3 value="125">{#PLIGG_Visual_Submit2_SummaryCharactersLeft#}<br />
			{if $Spell_Checker eq 1}<input type="button" name="spelling" value="Check Spelling" class="submit" onClick="openSpellChecker('summarytext');"/>{/if}
			<br /><br />
	{/if}
		
		<strong>{#PLIGG_Visual_Submit2_Category#}</strong> ({#PLIGG_Visual_Submit2_CatInstruct#})<br />			
	<select name="category" length="50">
	{section name=thecat loop=$cat_array}
	   <option value = "{$cat_array[thecat].auto_id}">
		  {if $cat_array[thecat].spacercount lt $lastspacer}{$cat_array[thecat].spacerdiff|repeat_count:''}{/if}
		  {if $cat_array[thecat].spacercount gt $lastspacer}{/if}
		  {$cat_array[thecat].spacercount|repeat_count:'&nbsp;&nbsp;&nbsp;'}
		  {$cat_array[thecat].name} 
		  &nbsp;&nbsp;&nbsp;       
		  {assign var=lastspacer value=$cat_array[thecat].spacercount}
	  </option>
	{/section}
</select>
			
		<br /><br /><br />
		{if $Submit_Show_URL_Input eq 1}
		<strong>{#PLIGG_Visual_Submit2_Trackback#}</strong> ({#PLIGG_Visual_Submit2_TrackbackInstruct#})<br />
		<input type="text" name="trackback" id="trackback" class="text" onclick="clearText(this, '{$submit_trackback}')" onblur="restoreText(this,'{$submit_trackback}')" value="{$submit_trackback}" size="60" class="form-full" />
			<br />
		{/if}
		{include file=$tpl_extra_fields.".tpl"}<br />
		<br />
		<input type="submit" value="{#PLIGG_Visual_Submit2_Continue#}" class="submit" />
		<br />
	</form>
</fieldset>
