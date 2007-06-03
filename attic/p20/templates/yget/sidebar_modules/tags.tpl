{php}
	include_once(mnminclude.'tags.php');
	global $main_smarty;
	
	$cloud=new TagCloud();
	$cloud->smarty_variable = $main_smarty; // pass smarty to the function so we can set some variables
	$cloud->word_limit = 5;
	$cloud->min_points = 6; // the size of the smallest tag
	$cloud->max_points = 15; // the size of the largest tag
	
	$cloud->show();
	$main_smarty = $cloud->smarty_variable; // get the updated smarty back from the function
{/php}


<div class="tlb">{php}
	echo "<span><a onclick=\"new Effect.toggle('s2','blind', {queue: 'end'}); \">  <img src=\"".my_pligg_base."/templates/yget/images/expand.png\"  onClick=expandcontent(this,'s2') ></a></span>";
{/php}<a href="{$URL_tagcloud}">{#PLIGG_Visual_Top_5_Tags#}</a>

</div>
<div id="s2" style="margin: 5px 0 0 0; line-height: {$tags_max_pts}pt;">
	{section name=customer loop=$tag_number}
	
		{* --- to change the way the words are displayed, change this part --- *}
			<span style="font-size: {$tag_size[customer]}pt">
				<a href="{$tag_url[customer]}">{$tag_name[customer]}</a>
			</span>
		{* ---		--- *}
		
	{/section}
	 <li class="rmore"><a href="{$URL_tagcloud}">{#PLIGG_Visual_What_Is_Pligg_Read_More#}</a></li>
</div>
