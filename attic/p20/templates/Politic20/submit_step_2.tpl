{config_load file="/libs/lang.conf"}

<script src="{$my_pligg_base}/templates/{$the_template}/js/submit.js{if $enable_gzip_files eq 'true'}.gz{/if}" type="text/javascript"></script>
														<div id="center">
															<div class="ce-l">
																<div class="ce-r">
																	<div class="ce-lt">
																		<div class="ce-br">
																			<div class="text">
																				<!-- list topics start here -->
																				<div id="comments">
<h2>{#PLIGG_Visual_Submit2_Header#}</h2>
<form action="{$URL_submit}" method="post" name="thisform">
	<input type="hidden" name="url" id="url" value="{$submit_url}" />
	<input type="hidden" name="phase" value="2" />
	<input type="hidden" name="randkey" value="{$randkey}" />
	<input type="hidden" name="id" value="{$submit_id}" />
	
	{if $Submit_Show_URL_Input eq 1}
		{#PLIGG_Visual_Submit2_Source#}
			<p class="l-top"><label for="url" accesskey="2">{#PLIGG_Visual_Submit2_NewsURL#}:</label>
			<a href="{$submit_url}" class="simple">{$submit_url}</a></p><br />
			{if $submit_url_title neq "1"}
				<p class="l-top"><label for="url_title" accesskey="2">{#PLIGG_Visual_Submit2_URLTitle#}:</label>{$submit_url_title}
					{if $submit_type eq 'blog'}
						<br /> <strong>({#PLIGG_Visual_Submit2_IsBlog#})</strong>
					{/if}
				</p>
			{/if}
	{/if}
	
	{#PLIGG_Visual_Submit2_Details#}
		<p class="l-mid"><label for="title" accesskey="1">{#PLIGG_Visual_Submit2_Title#}:</label>
		<span class="form-note">{#PLIGG_Visual_Submit2_TitleInstruct#}</span>
		<br/><input type="text" id="title" name="title" value="{$submit_url_title}" size="55" maxlength="100" />
		</p>
		<br />
		
		{if $enable_tags eq 'true'}
			<p class="l-mid">
				<label for="tags" accesskey="4">{#PLIGG_Visual_Submit2_Tags#}:</label>
				<span class="form-note"><strong>{#PLIGG_Visual_Submit2_Tags_Inst1#}</strong> {#PLIGG_Visual_Submit2_Tags_Example#} <em>{#PLIGG_Visual_Submit2_Tags_Inst2#}</em></span>
				<br/><input type="text" id="tags" name="tags" value="{$tags_words}" size="55" maxlength="40" /><br /><br />
			</p>
		{/if}

		<p class="l-mid">
			<label for="bodytext" accesskey="1">{#PLIGG_Visual_Submit2_Description#}:</label>
			<span class="form-note">{#PLIGG_Visual_Submit2_DescInstruct#}</span>
			{if $Story_Content_Tags_To_Allow eq ""}<br /><b>No</b> {#PLIGG_Visual_Submit2_HTMLTagsAllowed#}
			{else}<br />{#PLIGG_Visual_Submit2_HTMLTagsAllowed#}: {$Story_Content_Tags_To_Allow}
			{/if}
			<br/><textarea name="bodytext" rows="10" cols="55" id="bodytext" wrap=SOFT onkeyup="if(this.form.summarycheckbox.checked == false) {ldelim}this.form.summarytext.value = this.form.bodytext.value.substring(0, {$StorySummary_ContentTruncate});{rdelim}textCounter(this.form.summarytext,this.form.remLen, {$StorySummary_ContentTruncate});">{$submit_content}</textarea><br />
			{if $Spell_Checker eq 1 or $Spell_Checker eq 2}<input type="button" name="spelling" value="Check Spelling" class="submit" onclick="openSpellChecker('bodytext');"/>{/if}
			<br /><br />
		</p>

		{if $SubmitSummary_Allow_Edit eq 1}  
		<p class="l-mid">
			<label for="summarytext" accesskey="1">{#PLIGG_Visual_Submit2_Summary#}:</label>
			<span class="form-note">{#PLIGG_Visual_Submit2_SummaryInstruct#}{#PLIGG_Visual_Submit2_SummaryLimit#}{$StorySummary_ContentTruncate}{#PLIGG_Visual_Submit2_SummaryLimitCharacters#}</span>
			<br /><input type = "checkbox" name = "summarycheckbox" id = "summarycheckbox" onclick="SetState(this, this.form.summarytext)"> {#PLIGG_Visual_Submit2_SummaryCheckBox#}
			{if $Story_Content_Tags_To_Allow eq ""}<br /><b>No</b> {#PLIGG_Visual_Submit2_HTMLTagsAllowed#}
			{else}<br />{#PLIGG_Visual_Submit2_HTMLTagsAllowed#}: {$Story_Content_Tags_To_Allow}
			{/if}
			<br/><textarea disabled="true" name="summarytext"  rows="5" cols="55" id="summarytext" wrap=SOFT onkeydown="textCounter(this.form.summarytext,this.form.remLen, {$StorySummary_ContentTruncate});">{$submit_summary}</textarea><br />
			<input readonly type=text name=remLen size=3 maxlength=3 value="125">{#PLIGG_Visual_Submit2_SummaryCharactersLeft#}
			{if $Spell_Checker eq 1}<input type="button" name="spelling" value="Check Spelling" class="submit" onclick="openSpellChecker('summarytext');"/>{/if}
			<br /><br />
		</p>
		{/if}
		
		<p class="l-mid">
			<label for="category" accesskey="1">{#PLIGG_Visual_Submit2_Category#}:</label>
			<span class="form-note">{#PLIGG_Visual_Submit2_CatInstruct#}</span>
			<br/>
			<select name="category">
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
		</p>
		
		<br style="clear: both;" />
		
		{if $Submit_Show_URL_Input eq 1}
			<p class="l-mid"><label for="trackback">{#PLIGG_Visual_Submit2_Trackback#}:</label>
				<span class="form-note">{#PLIGG_Visual_Submit2_TrackbackInstruct#}</span><br />
				<input type="text" name="trackback" id="trackback" value="{$submit_trackback}" size="55" class="form-full" />
			</p>
			<br />
		{/if}
		
		{include file=$tpl_extra_fields.".tpl"}<br />
		<p class="l-mid">
			<input type="submit" value="{#PLIGG_Visual_Submit2_Continue#}" class="submit" />
		<p class="l-mid">
</form>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="pagers">
															<div class="pbg">
																<div class="list">
																</div>
															</div>
														</div>