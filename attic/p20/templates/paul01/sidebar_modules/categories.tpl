<div id="categories"><br />
<br />
<img src="minus.gif" class="showstate" onClick="expandcontent(this, 'cats')" />
	<strong>{#PLIGG_Visual_Category_Title#}</strong>
	<div id="cats" class="switchcontent">
	<ul id="nav-secondary">
		{section name=thecat loop=$cat_array}
			{if $cat_array[thecat].spacercount lt $lastspacer}{$cat_array[thecat].spacerdiff|repeat_count:'</ul>'}{/if}
			{if $cat_array[thecat].spacercount gt $lastspacer}<ul style="padding-left:10px">{/if}

				{if $cat_array[thecat].name eq $request_category}
					<li class="cat{$cat_array[thecat].auto_id}">
				{else}
					<li class="cat{$cat_array[thecat].auto_id}">
				{/if}
					<a href="{$category_url}{$cat_array[thecat].safename}">
						{$cat_array[thecat].name}
					</a>
				</li>

			{assign var=lastspacer value=$cat_array[thecat].spacercount}
		{/section}

	</ul>
</div>
</div>
<br />