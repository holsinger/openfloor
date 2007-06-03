<li>
      <div class="box" id="categorybox">
        <h1><span class="expand"><a id="expcat" class="expand-up"></a></span><a class="htitle">{#PLIGG_Visual_Category_Title#}</a></h1>
  <ul id="categorynav" style="padding-left:10px;">	

	{section name=thecat loop=$cat_array}
			{if $cat_array[thecat].spacercount lt $lastspacer}{$cat_array[thecat].spacerdiff|repeat_count:'</ul>'}{/if}
			{if $cat_array[thecat].spacercount gt $lastspacer}<ul style="padding-left:15px">{/if}			
			
			  <a href="{$URL_rss2category, $cat_array[thecat].auto_id}" target="_blank">           
						
				<span id="category_rss">				
				<img src="{$my_pligg_base}/templates/{$the_template}/images/rss.gif" border="0" style="margin-left:-15px; margin-bottom:-16px;"></a>				
				<li class="cat{$cat_array[thecat].auto_id}"> 
				</span>
				
				
			<a href="{$category_url, $cat_array[thecat].safename}" style="margin-left:5px;">
			{$cat_array[thecat].name}
			</a>
					
			</li>

			{assign var=lastspacer value=$cat_array[thecat].spacercount}
		{/section}

</ul>

</div>

</li>